<?php
/**
 * Paths
 * Helpers for paths within plugin
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

namespace Umbrella;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

/**
 * App file
 * Returns path to files within app directory.
 *
 * @param string $filename name of file.
 */
function app_file( $filename ) {
	return UMBRELLA__PLUGIN_DIR . 'app/' . $filename;
}

/**
 * Library file
 * Returns path to libraries within app directory.
 *
 * @param string $libname name of library.
 */
function lib_file( $libname ) {
	return UMBRELLA__PLUGIN_DIR . 'app/lib/' . $libname . '/' . $libname . '.php';
}

/**
 * View file
 * Returns path to a view file within app/views/ directory.
 *
 * @param string $filename name of view file.
 */
function view_file( $filename ) {
	return UMBRELLA__PLUGIN_DIR . 'app/views/' . $filename . '.php';
}
