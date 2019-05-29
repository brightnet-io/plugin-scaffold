<?php
/**
 *  Update manager for plugin.
 *
 * Responsible for performing any necessary operations such as db schema changes, data migraton or option/settings changes when plugin is installed or updated
 *
 * @package HumanPluginName\Admin
 */

namespace TenUpScaffold\Admin;

use function TenUpScaffold\Core\code_version;

/**
 * Class UpdateManager
 *
 * @package TenUpScaffold\Admin
 */
class UpdateManager {


	/**
	 * Will run plugin update (or installation) scripts if necessary.
	 *
	 * @return bool true if update was performed, otherwise false.
	 */
	public function maybe_update() {
		$current_version = get_option( 'tenup_scaffold_version' );
		$target_version  = code_version();
		if ( $this->requires_update( $current_version, $target_version ) ) {

			do_action( 'tenup_scaffold_before_update' );
			$update_result = $this->run_updates( $current_version, $target_version );
			do_action( 'tenup_scaffold_after_update' );

			return $update_result;
		} else {
			return false;
		}
	}

	/**
	 * Provided two PHP-Standardized version numbers, determins whether an update is required
	 *
	 * @param string $current_version The 'current' version of the plugin before an update is run.
	 * @param string $target_version The 'target' version for updates.
	 *
	 * @return bool true if update required, otherwise false
	 */
	protected function requires_update( $current_version, $target_version ) {

		// If current version is not set (new install) or version constant in code is higher, then update is required
		return empty( $current_version ) || ! ! version_compare( $target_version, $current_version, '>' );

	}

	/**
	 * Run required updates from $current_version up to (including) $target_version.
	 *
	 * @param string $current_version The 'current' version of the plugin before an update is run.
	 * @param string $target_version The 'target' version for updates.
	 *
	 * @return bool
	 */
	protected function run_updates( $current_version, $target_version ) {
		update_option( 'tenup_scaffold_version', $target_version );

		// Code to perform the update go here


		return true;
	}

	/**
	 * Return singleton instance of class.
	 *
	 * @return bool|UpdateManager
	 */
	public static function get_instance() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}
}