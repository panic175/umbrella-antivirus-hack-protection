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

$umbrella_antivirus = new UmbrellaAntivirus();
$umbrella_antivirus->dashboard = new Dashboard();
$umbrella_antivirus->scanner = new Scanner();
