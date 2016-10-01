<?php
/**
 * Realtime Updates
 * Returns an array with all valid modules that can be activated.
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

namespace Umbrella;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

add_action( 'init', 'Umbrella\umbrella_realtime_updates_init' );

/**
 * Realtime updates
 */
function umbrella_realtime_updates_init() {
	// Check for plugin updates each 10 minutes instead of each 12 hours.
	if ( false === get_transient( 'umbrella_sp_update_plugins' ) ) {
		delete_site_transient( 'update_plugins' );
		set_transient( 'umbrella_sp_update_plugins', 1, 600 );
	}
}
