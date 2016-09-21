<?php
/**
 * Plugin Name: Umbrella Antivirus & Hack protection
 * Plugin URI: https://www.umbrellaantivirus.com
 * Description: WordPress Antivirus and Hack protection. With features as vulnerability scanner, file scanner, hide versions, disable pings, captcha login and more.
 * Author: Umbrella Antivirus
 * Version: 2.0
 * Author URI: https://www.umbrellaantivirus.com
 * Text Domain: umbrella-antivirus-hack-protection
 * Domain Path: /languages
 * License: GPL
 * Copyright: Rasmus Kjellberg
 *
 * @package UmbrellaAntivirus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

$up_dir = wp_upload_dir();

define( 'UMBRELLA__VERSION', '2.0' );
define( 'UMBRELLA__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'UMBRELLA__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'UMBRELLA__STORAGE_DIR', $up_dir['basedir'] . '/umbrella/' );
define( 'UMBRELLA__STORAGE_URL', $up_dir['baseurl'] . '/umbrella/' );

/**
 * Plugin Init
 * Load WordPress text domain for translation.
 *
 * @since 1.8.5
 */
function umbrella_plugin_init() {
	load_plugin_textdomain( UMBRELLA__TEXTDOMAIN, false, UMBRELLA__TEXTDOMAIN . '/languages' );
}

add_action( 'init', 'umbrella_plugin_init' );
