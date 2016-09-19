<?php
/*
	Plugin Name: Umbrella Antivirus & Hack protection
	Plugin URI: https://www.umbrellaantivirus.com
	Description: WordPress Antivirus and Hack protection. With features as vulnerability scanner, file scanner, hide versions, disable pings, captcha login and more.
	Author: Umbrella Antivirus
	Version: 1.8.5
	Author URI: https://www.umbrellaantivirus.com
    Text Domain: umbrella-antivirus-hack-protection
    Domain Path: /languages
*/
/*
	Copyright 2015 Rasmus Kjellberg (rk@youngmedia.se)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$up_dir = wp_upload_dir();

// Define some good constants.
define( 'UMBRELLA__VERSION', '1.8.5' );
define( 'UMBRELLA__LATEST_WP_VERSION', '4.6.1' );
define( 'UMBRELLA__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'UMBRELLA__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'UMBRELLA__PLUGIN_TMPURL', UMBRELLA__PLUGIN_URL . 'data/tmp/' );
define( 'UMBRELLA__PLUGIN_TMPDIR', UMBRELLA__PLUGIN_DIR . 'data/tmp/' );
define( 'UMBRElLA__STORAGE_DIR', $up_dir['basedir'] . '/umbrella/' );
define( 'UMBRElLA__STORAGE_URL', $up_dir['baseurl'] . '/umbrella/' );
define( 'UMBRELLA__TEXTDOMAIN', 'umbrella-antivirus-hack-protection' );

// Load plugin textdomain.
add_action('init', 'umbrella_plugin_init');
function umbrella_plugin_init() {

    // Load plugin translation textdomain.
    load_plugin_textdomain( UMBRELLA__TEXTDOMAIN, false, UMBRELLA__TEXTDOMAIN . '/languages' );
}

// Include all libraries.
// There is no libraries yet..
require_once( UMBRELLA__PLUGIN_DIR . 'lib/whois.lib.php' );
require_once( UMBRELLA__PLUGIN_DIR . 'lib/diff.lib.php' );
require_once( UMBRELLA__PLUGIN_DIR . 'lib/really-simple-captcha/really-simple-captcha.php' );

// Include all source files
require_once( UMBRELLA__PLUGIN_DIR . 'src/scanner.class.php' );
require_once( UMBRELLA__PLUGIN_DIR . 'src/logging.class.php' );
require_once( UMBRELLA__PLUGIN_DIR . 'src/modules.class.php' );
require_once( UMBRELLA__PLUGIN_DIR . 'src/backup.class.php' );
require_once( UMBRELLA__PLUGIN_DIR . 'src/controller.class.php' );
require_once( UMBRELLA__PLUGIN_DIR . 'src/autoload.class.php' );

// Run the autoloader
new Umbrella\Autoload();