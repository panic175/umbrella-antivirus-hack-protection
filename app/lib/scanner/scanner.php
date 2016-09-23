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
	protected $autoload = array( 'admin_menu', 'wp_ajax_init_scanner', 'wp_ajax_scanner_results' );

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
	 * Add result
	 * Add a result to result log.
	 *
	 * @param string $module The name of the module. Ex core_scanner.
	 * @param string $file The affected file.
	 * @param string $error_code An error code.
	 * @param string $error_message A message for the affected file.
	 */
	public function add_result( $module, $file, $error_code, $error_message ) {

		$hours = 60 * 60; // 60 seconds * 60 = 1 hour.

		$results = get_transient( 'umbrella-scanner-results' );

		array_push( $results, array(
			'module' => $module, // The scanner module slug.
			'file' => $file, // Relative file path.
			'error_code' => $error_code, // Error code.
			'error_message' => $error_message, // Error Message.
		));

		delete_transient( 'umbrella-scanner-results' );
		set_transient( 'umbrella-scanner-results', $results, $hours );

	}

	/**
	 * Get results
	 * Get the list with scanner results.
	 */
	public function get_results() {
		return get_transient( 'umbrella-scanner-results' );
	}

	/**
	 * Reset results
	 * Erases the scanner results log.
	 */
	public function reset() {
		$hours = 60 * 60; // 60 seconds * 60 = 1 hour.
		delete_transient( 'umbrella-scanner-results' );
		set_transient( 'umbrella-scanner-results', array(), $hours );
	}

	/**
	 * AJAX: Full scan
	 * Initializes a full scan.
	 */
	public function wp_ajax_init_scanner() {
		$this->only_admin(); // Die if not admin.

		$this->reset(); // Reset scanner results.

		$response = array(
			'log' => 'Starting scanner..',
			'steps' => apply_filters( 'umbrella-scanner-steps', array() ),
		);

		$this->render_json( $response );
	}

	/**
	 * AJAX: Get results
	 * Render scanner results as JSON
	 */
	public function wp_ajax_scanner_results() {
		$this->only_admin(); // Die if not admin.

		$response = array(
			'results' => $this->get_results(),
		);

		$this->render_json( $response );
	}
}
