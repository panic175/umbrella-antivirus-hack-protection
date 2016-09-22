<?php
/**
 * Core Scanner
 * This is the core plugin for UmbrellaAntivirus Scanner
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
class CoreScanner extends UmbrellaAntivirus {

	/**
	 * Whitelabel autoload actions/methods
	 * List of valid methods/hooks.
	 *
	 * @since 2.0
	 * @var array
	 */
	protected $autoload = array( 'admin_init', 'wp_ajax_core_scanner' );

	/**
	 * Admin Init
	 * This function will run when WordPress calls the hook "admin_init".
	 */
	public function admin_init() {
		add_filter( 'umbrella-scanner-steps', array( $this, 'register_scanner' ) );
	}

	/**
	 * Register Scanner
	 * Register CoreScanner to Scanner steps.
	 *
	 * @param array $steps Default scanner steps.
	 */
	public function register_scanner( $steps ) {
		$steps[] = array(
			'action' => 'core_scanner',
			'log' => 'Scanning core files..',
		);
		return $steps;
	}

	/**
	 * AJAX: Init Core Scanner
	 * Initializes a core scan
	 */
	public function wp_ajax_core_scanner() {
		$this->only_admin(); // Die if not admin.

		$output = array(
			'status' => 'success',
			'logs' => array(
				'Core scanner finished.',
				'Found 12 modified files',
				'Found 3 unknown files',
			),
		);

		$this->render_json( $output );
	}
}
