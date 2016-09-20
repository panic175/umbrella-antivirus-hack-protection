<?php
/**
 * Class CoreScannerTest
 *
 * @package Umbrella_Antivirus_Hack_Protection
 */

/**
 * Sample test case.
 */
class CoreScannerTest extends WP_UnitTestCase {

  /**
   * Check that default plugins are listed and API are responding.
   */
  function test_build_database() {
    $scanner = new Umbrella\Scanner();

    // Remove old file
    if (file_exists(\Umbrella\Scanner::get_db_file()))
      unlink(\Umbrella\Scanner::get_db_file());

    // Build core list
    $scanner->build_core_list();

    // Check if file exists and that filesize is over 60kb
    $this->assertTrue(
      file_exists(\Umbrella\Scanner::get_db_file()) &&
      filesize(\Umbrella\Scanner::get_db_file()) > 60000
    );

  }

  /*
   * Check that core scanner finds unexpected files in Wordpress tree
  */
  function test_scanner_finds_unknown_file() {
    $file = 'hack.php'; // File
    $file_path = ABSPATH.$file; // File path
    touch($file_path); // Create file

    $scanner = new Umbrella\Scanner();
    $response = $scanner->check_file($file);

    $this->assertTrue(
      isset($response['error']) AND
      isset($response['error']['code']) AND
      $response['error']['code'] == "0010"
    ); // Unexpected file

    unlink($file_path); // Remove file again
  }

  /*
   * Check that core scanner finds modified files in Wordpress tree
  */
  function test_scanner_finds_modified_file() {
    $file = 'xmlrpc.php'; // File
    $file_path = ABSPATH.$file; // File path

    $file_contents = file_get_contents($file_path);
    $file_modified_contents = str_replace("WordPress", "HackerPress", $file_contents);

    file_put_contents($file_path, $file_modified_contents); // Overwrite with hacked content

    $scanner = new Umbrella\Scanner();
    $response = $scanner->check_file($file);

    $this->assertTrue(
      isset($response['error']) AND
      isset($response['error']['code']) AND
      $response['error']['code'] == "0020"
    ); // Modified file

    file_put_contents($file_path, $file_contents); // Reset content
  }

}
