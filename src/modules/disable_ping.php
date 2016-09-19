<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Disable X-Pingback HTTP Header.
add_filter('wp_headers', 'umbrella_wp_headers', 11, 2);
function umbrella_wp_headers($headers, $wp_query){
    if(isset($headers['X-Pingback'])){
        // Drop X-Pingback
        unset($headers['X-Pingback']);
    }
    return $headers;
}

// Disable XMLRPC by hijacking and blocking the option.
add_filter('pre_option_enable_xmlrpc', 'umbrella_pre_option_enable_xmlrpc');
function umbrella_pre_option_enable_xmlrpc($state){
    return '0'; // return $state; // To leave XMLRPC intact and drop just Pingback
}

// Remove rsd_link from filters (<link rel="EditURI" />).
add_action('wp', 'umbrella_disable_ping', 9);
function umbrella_disable_ping(){
    remove_action('wp_head', 'rsd_link');
}

// Hijack pingback_url for get_bloginfo (<link rel="pingback" />).
add_filter('bloginfo_url', 'umbrella_ping_bloginfo_url', 11, 2);
function umbrella_ping_bloginfo_url($output, $property){
    return ($property == 'pingback_url') ? null : $output;
}

// Just disable pingback.ping functionality while leaving XMLRPC intact?
add_action('xmlrpc_call', 'umbrella_xmlrpc_ping_call');
function umbrella_xmlrpc_ping_call($method){
    if($method != 'pingback.ping') return;
    Umbrella\Log::write('Disable Ping Module', 'Blocked pingback ping');
    wp_die(
        'Pingback functionality is disabled on this Blog.',
        'Pingback Disabled!',
        array('response' => 403)
    );
}