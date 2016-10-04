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
	protected $autoload = array(
		'admin_menu',
		'admin_init',
		'wp_ajax_init_scanner',
		'wp_ajax_ignore_result',
		'wp_ajax_scanner_results',
	);

	/**
	 * Admin Menu
	 * This function will run when WordPress calls the hook "admin_menu".
	 */
	public function admin_menu() {
		$this->add_submenu( 'Scanner', 'admin_page_view', 'fa fa-search' );
	}

	/**
	 * Admin Init
	 * This function will run when WordPress calls the hook "admin_init".
	 */
	public function admin_init() {
		add_filter( 'scanner-buttons', array( $this, 'add_buttons' ), 9999 );
		add_filter( 'scanner-results', array( $this, 'hide_ignored_files_from_results' ), 9999 );
	}

	/**
	 * Admin Page View
	 * Load admin page view
	 */
	public function admin_page_view() {
		$this->render( 'scanner' );
	}

	/**
	 * Add button.
	 * Add compare button to scanner results.
	 *
	 * @param array $buttons List of default buttons.
	 */
	public function add_buttons( $buttons ) {
		$buttons[] = '<button ng-if="result.ignored!=true" ng-click="ignoreResult($index, result)" class="button">IGNORE</button>';
		return $buttons;
	}

	/**
	 * Add result
	 * Add a result to result log.
	 *
	 * @param string $module The name of the module. Ex core_scanner.
	 * @param string $file The affected file.
	 * @param string $file_size The affected files size.
	 * @param string $error_code An error code.
	 * @param string $error_message A message for the affected file.
	 */
	public function add_result( $module, $file, $file_size, $error_code, $error_message ) {

		$hours = 60 * 60 * 24; // 60 seconds * 60 = 1 hour.

		$results = get_transient( 'umbrella-scanner-results' );

		array_push( $results, array(
			'module' => $module, // The scanner module slug.
			'file' => $file, // Relative file path.
			'file_size' => $file_size, // Relative file path.
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
	 * Hide ignored files from results.
	 *
	 * @param array $results Default list of results.
	 */
	public function hide_ignored_files_from_results( $results ) {

		if ( ! $ignored_files = get_option( 'umbrella-scanner-ignored-results' ) ) {
			return $results;
		}

		$output = array();

		foreach ( $results as $index => $result ) {
			$ignore = false;

			foreach ( $ignored_files as $ignore_row ) {
				if (
					$ignore_row['file'] == $result['file'] and
					$ignore_row['error_code'] == $result['error_code'] and
					$ignore_row['file_size'] == $result['file_size']
				) {
					$ignore = true;
				}
			}

			if ( $ignore ) {
				$result['ignored'] = true;
				array_push( $output, $result );
			} else {
				$result['ignored'] = false;
				array_push( $output, $result );
			}
		}

		return $output;
	}

	/**
	 * AJAX: Ingore result
	 * Adds a result to ignore list
	 */
	public function wp_ajax_ignore_result() {

		$this->only_admin(); // Die if not admin.
		check_ajax_referer( 'umbrella_ajax_nonce', 'security' ); // Check nonce.

		// Get file post.
		if ( isset( $_POST['file'] ) ) {
			$file = sanitize_text_field( wp_unslash( $_POST['file'] ) );
		} else {
			die( 'Unkown file' );
		}

		// Get error code post.
		if ( isset( $_POST['error_code'] ) ) {
			$error_code = sanitize_text_field( wp_unslash( $_POST['error_code'] ) );
		} else {
			die( 'Unkown error code' );
		}

		// Get file filesize.
		if ( file_exists( ABSPATH . $file ) ) {
			$file_size = filesize( ABSPATH . $file );
		} else {
			die( 'Could not find file.' );
		}

		if ( ! $ignored_files = get_option( 'umbrella-scanner-ignored-results' ) ) {
			$ignored_files = array();
		}

		array_push( $ignored_files, array(
			'file' => $file, // Relative file path.
			'file_size' => $file_size, // Relative file path.
			'error_code' => $error_code, // Error code.
		));

		update_option( 'umbrella-scanner-ignored-results', $ignored_files );

		$this->render_json( array( 'status' => 'success' ) );
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
		check_ajax_referer( 'umbrella_ajax_nonce', 'security' ); // Check nonce.

		$results = array();
		foreach ( $this->get_results() as $result ) {
			$tmp = $result;
			$tmp['buttons'] = apply_filters( 'scanner-buttons-' . $tmp['error_code'], array() );
			$results[] = $tmp;
		}

		if ( isset( $_POST['force_all'] ) and intval( $_POST['force_all'] ) ) {
			$show_ignored = true;
		} else {
			$show_ignored = false;
		}

		$response = array(
			'results' => apply_filters( 'scanner-results', $results ),
		);

		$this->render_json( $response );
	}
}
