<?php

namespace TenUpScaffold\Core;

/**
 * A somewhat contrived "integration" test example. These tests could probably be achieved with an adequate level of confidence by using WP_Mock, and are here only as an example.
 * Integration tests should be geared more towards testing integration between plugins, such as WooCommerce.
 */
class PluginBootstrapTests extends \WP_UnitTestCase {

	/**
	 * Test teardown
	 */
	public function tearDown() {
		parent::tearDown();
		// Need to dequeue scripts on teardown as parent teardown does manage $wp_scripts global;
		wp_dequeue_script( 'tenup_scaffold_frontend' );
		wp_dequeue_script( 'tenup_scaffold_shared' );
		wp_dequeue_script( 'tenup_scaffold_admin' );
		wp_dequeue_style( 'tenup_scaffold_frontend' );
		wp_dequeue_style( 'tenup_scaffold_shared' );
		wp_dequeue_style( 'tenup_scaffold_admin' );

	}

	/**
	 * Test that the client side scripts are enqueued and the admin script is not
	 */
	public function test_enqueued_scripts() {

		do_action( 'wp_enqueue_scripts' );
		$this->assertTrue( wp_script_is( 'tenup_scaffold_frontend' ) );
		$this->assertTrue( wp_script_is( 'tenup_scaffold_shared' ) );
		$this->assertFalse( wp_script_is( 'tenup_scaffold_admin' ) );


	}
	/**
	 * Test that the admin side scripts are enqueued and the client side is not
	 */
	public function test_admin_scripts() {

		do_action( 'admin_enqueue_scripts' );
		$this->assertTrue( wp_script_is( 'tenup_scaffold_shared' ) );
		$this->assertTrue( wp_script_is( 'tenup_scaffold_admin' ) );
		$this->assertFalse( wp_script_is( 'tenup_scaffold_frontend' ) );
	}

	/**
	 * Test that the client side styles are enqueued and the admin script is not
	 */
	public function test_enqueued_styles() {
		do_action( 'wp_enqueue_scripts' ); // Note: The plugin core hook styles to to enqueue_scripts;

		$this->assertTrue( wp_style_is( 'tenup_scaffold_frontend' ) );
		$this->assertTrue( wp_style_is( 'tenup_scaffold_shared' ) );
		$this->assertFalse( wp_style_is( 'tenup_scaffold_admin' ) );
	}

	/**
	 * Test that the admin side styles are enqueued and the client side is not
	 */
	public function test_admin_styles() {
		do_action( 'admin_enqueue_scripts' );
		$this->assertTrue( wp_style_is( 'tenup_scaffold_shared' ) );
		$this->assertTrue( wp_style_is( 'tenup_scaffold_admin' ) );
		$this->assertFalse( wp_style_is( 'tenup_scaffold_frontend' ) );
	}

	/**
	 * Test that the updater/installer ran
	 */
	public function test_sets_version_option() {
		$this->assertEquals( TENUP_SCAFFOLD_VERSION, get_option( 'tenup_scaffold_version' ) );
	}


}