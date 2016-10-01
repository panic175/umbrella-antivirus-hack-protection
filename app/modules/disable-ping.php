<?php
/**
 * Disable ping
 * Disable pings and trackbacks
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

namespace Umbrella;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

/**
 * Disable X-Pingback HTTP Header.
 *
 * @param array  $headers The list of headers to be sent.
 * @param object $wp_query Current WordPress environment instance.
 */
function umbrella_wp_headers( $headers, $wp_query ) {
	if ( isset( $headers['X-Pingback'] ) ) {
		// Drop X-Pingback.
		unset( $headers['X-Pingback'] );
	}
	return $headers;
}

add_filter( 'wp_headers', 'Umbrella\umbrella_wp_headers', 11, 2 );

/**
 * Disable XMLRPC by hijacking and blocking the option.
 *
 * @param boolean $state Current XMLRPC status.
 */
function umbrella_pre_option_enable_xmlrpc( $state ) {
	return false;
}

add_filter( 'pre_option_enable_xmlrpc', 'Umbrella\umbrella_pre_option_enable_xmlrpc' );


/**
 * Remove rsd_link from filters (<link rel="EditURI" />).
 */
function umbrella_disable_ping() {
	remove_action( 'wp_head', 'rsd_link' );
}

add_action( 'wp', 'Umbrella\umbrella_disable_ping', 9 );

/**
 * Hijack pingback_url for get_bloginfo (<link rel="pingback" />).
 *
 * @param string $output Output.
 * @param string $property Property.
 */
function umbrella_ping_bloginfo_url( $output, $property ) {
	return ( 'pingback_url' == $property ) ? null : $output;
}

add_filter( 'bloginfo_url', 'Umbrella\umbrella_ping_bloginfo_url', 11, 2 );

/**
 * Just disable pingback.ping functionality while leaving XMLRPC intact?
 *
 * @param string $method XMLRPC_CALL method.
 */
function umbrella_xmlrpc_ping_call( $method ) {

	if ( 'pingback.ping' != $method ) {
		return;
	}

	/*
	 @todo: Log here
	 Umbrella\Log::write( 'Disable Ping Module', 'Blocked pingback ping' );
	*/

	wp_die(
		'Pingback functionality is disabled on this Blog.',
		'Pingback Disabled!',
		array( 'response' => 403 )
	);
}

add_action( 'xmlrpc_call', 'Umbrella\umbrella_xmlrpc_ping_call' );
