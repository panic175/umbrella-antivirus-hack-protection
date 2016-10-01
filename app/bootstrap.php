<?php
/**
 * Umbrella Antivirus bootstrap
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

namespace Umbrella;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

global $umbrella_antivirus;

// Require main classes and dashboard.
require_once( app_file( 'umbrella-antivirus' ) );
require_once( lib_file( 'api' ) );
require_once( lib_file( 'dashboard' ) );
require_once( lib_file( 'scanner' ) );
require_once( lib_file( 'scanner-core' ) );
require_once( lib_file( 'vulnerability-scanner' ) );
require_once( lib_file( 'modules' ) );
require_once( lib_file( 'modules' ) );
require_once( vendor_dir_path( 'really-simple-captcha/really-simple-captcha.php' ) );


// Get all available modules from module class.
$modules = Modules::valid_modules();
$options = get_option( 'umbrella_load_modules' );
// Loop trough all available modules and include them if they are activated.
foreach ( $modules as $mod ) {


	// Check if modules is activated.
	if ( isset( $options[ $mod[0] ] ) and 1 === $options[ $mod[0] ] ) {
		// Include module if it exists.
		$path_to_file = module_file( $mod[0] );

		if ( file_exists( $path_to_file ) ) {
			require_once( $path_to_file );
		}
	}
}

$umbrella_antivirus = new UmbrellaAntivirus();
$umbrella_antivirus->dashboard = new Dashboard();
$umbrella_antivirus->vulnerability_scanner = new VulnerabilityScanner();
$umbrella_antivirus->scanner = new Scanner();
$umbrella_antivirus->scanner->core = new CoreScanner();
$umbrella_antivirus->modules = new Modules();
