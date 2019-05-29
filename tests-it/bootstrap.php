<?php
/**
 * PHP Unit bootstrap for integration tests requiring WordPress and WooCommerce
 *
 */
if ( ! file_exists( __DIR__ . '/../vendor/autoload.php' ) ) {
	throw new PHPUnit_Framework_Exception(
		'ERROR' . PHP_EOL . PHP_EOL .
		'You must use Composer to install the test suite\'s dependencies!' . PHP_EOL
	);
}

require_once __DIR__ . '/../vendor/autoload.php';




if ( ! defined( 'PROJECT' ) ) {
	define( 'PROJECT', __DIR__ . '/../includes/' );
}

if ( ! defined( 'WP_TESTS_DIR' ) ) {
	define( 'WP_TESTS_DIR', __DIR__ . '/../vendor/wordpress/wp-develop/tests/phpunit/' );
}

if ( ! defined( 'WC_TESTS_DIR' ) ) {
	define( 'WC_TESTS_DIR', __DIR__ . '/../vendor/woocommerce/woo-develop/tests/' );
}
putenv( 'WP_TESTS_DIR=' . WP_TESTS_DIR );

if ( ! defined( 'WP_TESTS_CONFIG_FILE_PATH' ) ) {
	define( 'WP_TESTS_CONFIG_FILE_PATH', dirname( __FILE__ ) . '/wp-tests-config.php' );
}

require_once WP_TESTS_DIR . 'includes/functions.php';


// Require Composer autoloader if it exists.





function set_active_plugins($activePlugins){
	//fwrite(STDERR, '$activePlugins ' . print_r($activePlugins,true));
	return array_unique(
		array_merge([
			'plugin.php'
		], $activePlugins ?: [])
	);
}

tests_add_filter('option_active_plugins', 'set_active_plugins');

function _must_load_plugin() {
	require_once __DIR__ . '/../plugin.php';
}

tests_add_filter( 'muplugins_loaded', '_must_load_plugin' );

require_once WC_TESTS_DIR . 'bootstrap.php';