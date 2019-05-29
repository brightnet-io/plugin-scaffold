<?php

namespace TenUpScaffold\Admin;


use TenUpScaffold\TestCase;

class UpdateManagerTests extends TestCase {


	public function test_updates_when_no_previous_version() {
		// Setup
		\WP_Mock::userFunction( 'get_option', array(
			'times'  => 1,
			'args'   => array( 'tenup_scaffold_version' ),
			'return' => false
		) );


		\WP_Mock::userFunction( 'TenUpScaffold\Core\code_version', array(
			'times' => 1,
			'return' => '0.1.0'
		) );

		\WP_Mock::userFunction( 'update_option', array(
			'times' => 1,
			'args'  => array( 'tenup_scaffold_version', '0.1.0' )
		) );

		// Fires actions
		\WP_Mock::expectAction( 'tenup_scaffold_before_update' );
		\WP_Mock::expectAction( 'tenup_scaffold_after_update' );

		// Act
		$updater = UpdateManager::get_instance();
		$updated = $updater->maybe_update();

		$this->assertTrue( $updated, 'maybe_update did not return true' );
		$this->assertConditionsMet();


	}


	public function test_updates_when_new_version() {
		// Setup
		\WP_Mock::userFunction( 'get_option', array(
			'times'  => 1,
			'args'   => array( 'tenup_scaffold_version' ),
			'return' => '0.0.1'
		) );


		\WP_Mock::userFunction( 'TenUpScaffold\Core\code_version', array(
			'times' => 1,
			'return' => '0.2.0'
		) );

		\WP_Mock::userFunction( 'update_option', array(
			'times' => 1,
			'args'  => array( 'tenup_scaffold_version', '0.2.0' )
		) );


		// Fires actions
		\WP_Mock::expectAction( 'tenup_scaffold_before_update' );
		\WP_Mock::expectAction( 'tenup_scaffold_after_update' );

		// Act
		$updater = UpdateManager::get_instance();
		$updated = $updater->maybe_update();

		$this->assertTrue( $updated, 'maybe_update did not return true' );
		$this->assertConditionsMet();
	}


	public function test_does_not_update_equal_version() {
		// Setup

		\WP_Mock::userFunction( 'get_option', array(
			'times'  => 1,
			'args'   => array( 'tenup_scaffold_version' ),
			'return' => '0.0.1'
		) );

		\WP_Mock::userFunction( 'TenUpScaffold\Core\code_version', array(
			'times' => 1,
			'return' => '0.0.1'
		) );

		\WP_Mock::userFunction( 'update_option', array(
			'times' => 0
		) );


		// NOTE To test that the before_update and after_update actions are not called would require WP_Mock to be in strict mode.

		// Act
		$updater = UpdateManager::get_instance();
		$updated = $updater->maybe_update();

		$this->assertFalse( $updated, 'maybe_update did not return false' );
		$this->assertConditionsMet();
	}


	public function test_does_not_update_older_version() {
		// Setup

		\WP_Mock::userFunction( 'get_option', array(
			'times'  => 1,
			'args'   => array( 'tenup_scaffold_version' ),
			'return' => '0.0.2'
		) );

		\WP_Mock::userFunction( 'TenUpScaffold\Core\code_version', array(
			'times' => 1,
			'return' => '0.0.1'
		) );

		\WP_Mock::userFunction( 'update_option', array(
			'times' => 0
		) );


		// NOTE To test that the before_update and after_update actions are not called would require WP_Mock to be in strict mode.

		// Act
		$updater = UpdateManager::get_instance();
		$updated = $updater->maybe_update();

		$this->assertFalse( $updated, 'maybe_update did not return false' );
		$this->assertConditionsMet();
	}


}