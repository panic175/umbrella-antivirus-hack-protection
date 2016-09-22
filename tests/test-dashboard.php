<?php
/**
 * Class Dashboard
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

/**
 * Dashboard tests.
 */
class DashboardTest extends WP_UnitTestCase {

	/**
	 * Class file is included
	 * Check that classfile includes correctly
	 */
	function test_class_is_included() {
		current_user_can( 'administrator' );
		$this->assertTrue( class_exists( '\Umbrella\UmbrellaAntivirus' ) );
	}

	/**
	 * Dashboard is loaded
	 * Check that the class loads correctly.
	 */
	function test_dashboard_is_loaded() {
		global $umbrella_antivirus;
		$this->assertTrue( isset( $umbrella_antivirus->dashboard ) );
	}
}
