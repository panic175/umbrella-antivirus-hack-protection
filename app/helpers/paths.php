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
 * @since 2.0
 * @param string $filename name of file.
 */
function app_file( $filename ) {
	return UMBRELLA__PLUGIN_DIR . 'app/' . $filename . '.php';
}

/**
 * Library file
 * Returns path to libraries within app directory.
 *
 * @since 2.0
 * @param string $libname name of library.
 */
function lib_file( $libname ) {
	return UMBRELLA__PLUGIN_DIR . 'app/lib/' . $libname . '/' . $libname . '.php';
}

/**
 * View file
 * Returns path to a view file within app/views/ directory.
 *
 * @since 2.0
 * @param string $filename name of view file.
 */
function view_file( $filename ) {
	return UMBRELLA__PLUGIN_DIR . 'app/views/' . $filename . '.php';
}

/**
 * Vendor URL
 * Returns URL to the vendor/ directory.
 *
 * @todo: Add some kind of testing for this method. (Requires live test server like rspec?)
 * @since 2.0
 * @param string $file_path Path to file relative from vendor/ directory.
 */
function vendor_url( $file_path ) {
	return UMBRELLA__PLUGIN_URL . 'vendor/' . $file_path;
}

/**
 * Slugify
 * Generete a slug from a string, ex: 'Hello world' => 'hello-world'
 *
 * @since 2.0
 * @param string $string The string to slugify.
 */
function slugify( $string ) {
	// replace non letter or digits by -.
	$string = preg_replace( '~[^\pL\d]+~u', '-', $string );

	// transliterate.
	$string = iconv( 'utf-8', 'us-ascii//TRANSLIT', $string );

	// remove unwanted characters.
	$string = preg_replace( '~[^-\w]+~', '', $string );

	// trim.
	$string = trim( $string, '-' );

	// remove duplicate -.
	$string = preg_replace( '~-+~', '-', $string );

	// lowercase.
	$string = strtolower( $string );

	if ( empty( $string ) ) {
		return 'n-a';
	}

	return $string;
}
