<?php
/**
 * Scanner
 * This is the base for the Scanner module for UmbrellaAntivirus
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

namespace Umbrella;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

/**
 * Scanner
 * Scans plugin and themes for known vulnerabilities
 *
 * @package UmbrellaAntivirus
 */
class Scanner extends UmbrellaAntivirus {

	/**
	 * Whitelabel autoload actions/methods
	 * List of valid methods/hooks.
	 *
	 * @since 2.0
	 * @var array
	 */
	protected $autoload = array( 'admin_menu' );

	/**
	 * Admin Menu
	 * This function will run when WordPress calls the hook "admin_menu".
	 */
	public function admin_menu() {
		$this->add_submenu( 'Scanner', 'admin_page_view' );
	}

	/**
	 * Admin Page View
	 * Load admin page view
	 */
	public function admin_page_view() {
		$this->render( 'scanner' );
	}
}
