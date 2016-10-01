<?php
/**
 * Hide Version
 * Hide version numbers in your front-end source code for WordPress-core and all plugins.
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

namespace Umbrella;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

/**
 * Remove WP Generator from head
 */
function umbrella_hide_versions_init() {
	remove_action( 'wp_head', 'wp_generator' );
}

add_action( 'init', 'Umbrella\umbrella_hide_versions_init' );

/**
 * Remove WordPress version number from both your head file and RSS feeds.
 */
function umbrella_version_generator() {
	return '';
}

add_filter( 'the_generator', 'Umbrella\umbrella_version_generator' );

/**
 * Hide versions from plugin stylesheets & javascripts.
 *
 * @param string $src File URL to be enqueed.
 */
function remove_wp_ver_par( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}

add_filter( 'style_loader_src', 'Umbrella\remove_wp_ver_par', 9999 );
add_filter( 'script_loader_src', 'Umbrella\remove_wp_ver_par', 9999 );
