<?php
/**
 * Class PluginTest
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

/**
 * Sample test case.
 */
class PluginTest extends WP_UnitTestCase {

	/**
	 * Plugin version tags matches
	 * Check that plugin versions in init.php matches.
	 */
	function test_plugin_version_tag() {
		$plugin_data = get_plugin_data( PLUGIN_ABSOLUTE_PATH, false, false );
		$this->assertTrue( UMBRELLA__VERSION == $plugin_data['Version'] );
	}

	/**
	 * Class file loads
	 * Check that classfile loads correctly.
	 */
	function test_class_file_loads() {
		$this->assertTrue( class_exists( '\Umbrella\UmbrellaAntivirus' ) );
	}
}
