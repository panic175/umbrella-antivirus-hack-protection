<?php
/**
 * Class PathHelpersTest
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

namespace Umbrella;

/**
 * Sample test case.
 */
class PathHelpersTest extends \WP_UnitTestCase {

	/**
	 * Slugify
	 * Check that classfile loads correctly.
	 */
	function test_slugify() {
		$this->assertTrue( 'hello-world' === slugify( 'Hello world' ) );
		$this->assertTrue( 'hello-world' === slugify( 'Hello World' ) );
		$this->assertTrue( 'hello-world' === slugify( 'Hello World!' ) );
	}

	/**
	 * App file path generator
	 * Test that file exists
	 */
	function test_app_path_exists() {
		$this->assertTrue( file_exists( app_file( 'umbrella-antivirus' ) ) );
	}

	/**
	 * Library file path generator
	 * Test that file exists
	 */
	function test_lib_path_exists() {
		$this->assertTrue( file_exists( lib_file( 'dashboard' ) ) );
	}

	/**
	 * View file path generator
	 * Test that file exists
	 */
	function test_view_path_exists() {
		$this->assertTrue( file_exists( view_file( 'dashboard' ) ) );
	}
}
