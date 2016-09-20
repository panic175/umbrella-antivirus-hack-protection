<?php
/**
 * Class VulnerabilitiesScannerTest
 *
 * @package Umbrella_Antivirus_Hack_Protection
 */

/**
 * Sample test case.
 */
class VulnerabilitiesScannerTest extends WP_UnitTestCase {

  /**
   * Check that default plugins are listed and API are responding.
   */
  function test_plugins() {
    $plugins = Umbrella\Scanner::vulndb_plugins();
    $this->assertTrue( "Akismet"==$plugins[0]['Name'] );
  }

  /**
   * Check that default plugins are listed and API are responding.
   */
  function test_themes() {
    $themes = Umbrella\Scanner::vulndb_themes();
    $this->assertTrue( "Twenty Fifteen"==$themes[0]['Name'] );
  }

}
