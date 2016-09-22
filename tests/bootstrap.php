<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Umbrella_Antivirus_Hack_Protection
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

define('PLUGIN_NAME','init.php');
define('PLUGIN_FOLDER',basename(dirname( __DIR__ )));
define('PLUGIN_PATH',PLUGIN_FOLDER.'/'.PLUGIN_NAME);
define('PLUGIN_ABSOLUTE_PATH', dirname( dirname( __FILE__ ) ) . '/init.php' );

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require PLUGIN_ABSOLUTE_PATH;
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';