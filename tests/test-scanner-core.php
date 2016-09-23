<?php
/**
 * Class ScannerCore
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

namespace Umbrella;

/**
 * Sample test case.
 */
class ScannerCore extends \WP_UnitTestCase {

	/**
	 * Core Scanner Loads.
	 * Check that CoreScanner is loaded into scanner steps.
	 */
	function test_core_scanner_loads() {

		global $umbrella_antivirus;

		$this->assertTrue( class_exists( 'Umbrella\CoreScanner' ) );
		$this->assertTrue( isset( $umbrella_antivirus->scanner->core ) );

	}

	/**
	 * Build core lists.
	 * Check that CoreScanner is building a correct core list.
	 */
	function test_core_scanner_builds_core_list() {

		global $umbrella_antivirus;

		$core_scanner = $umbrella_antivirus->scanner->core;
		$core_scanner->build_core_list();

		$this->assertTrue( true === $core_scanner->has_core_files_list() );

	}

}
