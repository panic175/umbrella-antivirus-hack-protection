<?php
add_action('init', 'umbrella_realtime_updates_init');

function umbrella_realtime_updates_init() {
	// Check for plugin updates each 10 minutes instead of each 12 hours.
    if ( false === get_transient("umbrella_sp_update_plugins") ) {
		delete_site_transient('update_plugins');
    	set_transient( "umbrella_sp_update_plugins", 1, 600 );
    }
}
