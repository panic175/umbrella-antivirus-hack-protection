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

define( 'UMBRELLA__VERSION', '2.0' );
define( 'UMBRELLA__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'UMBRELLA__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Localization
 * Load WordPress text domain for translation.
 *
 * @since 2.0.0
 */
function umbrella_plugin_init() {
	load_plugin_textdomain( 'umbrella-antivirus', false,  UMBRELLA__PLUGIN_DIR . '/config/locales' );
}

add_action( 'init', 'umbrella_plugin_init' );

// Require helpers for paths within plugin.
require_once( UMBRELLA__PLUGIN_DIR . 'app/helpers/paths.php' );

// Require bootstrap (load files and init plugin).
require_once( Umbrella\app_file( 'bootstrap.php' ) );

