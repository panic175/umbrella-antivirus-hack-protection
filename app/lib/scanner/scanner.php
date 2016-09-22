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
 * Scans core files
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
	protected $autoload = array( 'admin_menu', 'wp_ajax_init_scanner' );

	/**
	 * Admin Menu
	 * This function will run when WordPress calls the hook "admin_menu".
	 */
	public function admin_menu() {
		$this->add_submenu( 'Scanner', 'admin_page_view', 'fa fa-search' );
	}

	/**
	 * Admin Page View
	 * Load admin page view
	 */
	public function admin_page_view() {
		$this->render( 'scanner' );
	}

	/**
	 * AJAX: Full scan
	 * Initializes a full scan.
	 */
	public function wp_ajax_init_scanner() {
		$this->only_admin(); // Die if not admin.

		$steps = apply_filters( 'umbrella-scanner-steps', array() );

		$this->render_json( array( 'steps' => $steps ) );
	}
}
