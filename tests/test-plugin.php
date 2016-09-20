<?php
/**
 * Class PluginTest
 *
 * @package Umbrella_Antivirus_Hack_Protection
 */

/**
 * Sample test case.
 */
class PluginTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	function test_sample() {
		// Replace this with some actual testing code.
		$this->assertTrue( true );
	}

  // Check that plugin versions in init.php matches
  function test_plugin_version_tag() {
    $plugin_data = get_plugin_data( PLUGIN_ABSOLUTE_PATH, false, false );
    $this->assertTrue( UMBRELLA__VERSION==$plugin_data['Version'] );
  }

}
