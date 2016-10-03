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
	protected $autoload = array( 'admin_init', 'wp_ajax_core_scanner', 'wp_ajax_update_core_db' );


	/**
	 * Excluded paths
	 * Files and directories that will not be included in a core scan.
	 *
	 * @since 2.0
	 * @var array
	 */
	protected $excluded_paths = array(
		'wp-config-sample.php',
		'wp-includes/version.php',
		'wp-content/',
		'wp-config.php',
		'readme.html',
		'.txt',
		'/..',
		'/.',
	);

	/**
	 * Admin Init
	 * This function will run when WordPress calls the hook "admin_init".
	 */
	public function admin_init() {
		add_filter( 'umbrella-scanner-steps', array( $this, 'register_scanner' ) );

		add_filter( 'scanner-buttons-0020', array( $this, 'add_compare_button') );
		add_filter( 'scanner-buttons-0020', array( $this, 'add_ignore_button') );
		add_filter( 'scanner-buttons-0010', array( $this, 'add_ignore_button') );
	}

	/**
	 * Register Scanner
	 * Register CoreScanner to Scanner steps.
	 *
	 * @param array $steps Default scanner steps.
	 */
	public function register_scanner( $steps ) {

		global $wp_version;

		$steps[] = array(
			'action' => 'update_core_db',
			'log' => "Downloading core files list for WordPress {$wp_version}..",
		);

		$steps[] = array(
			'action' => 'core_scanner',
			'log' => 'Scanning core files..',
		);
		return $steps;
	}

	/**
	 * Has Core Files List
	 * Check if there is a core lists transient.
	 */
	public function has_core_files_list() {
		global $wp_version;
		return false !== get_transient( 'core_tree_list_' . $wp_version );
	}

	/**
	 * Add ignore button.
	 * Add ignore button to scanner results.
	 */
	public function add_ignore_button( $buttons ) {
		$buttons[] = '<a href="#" ng-click="#" class="button">IGNORE</a>';
		return $buttons;
	}

	/**
	 * Add compare button.
	 * Add compare button to scanner results.
	 */
	public function add_compare_button( $buttons ) {
		$buttons[] = '<a href="#" ng-click="#" class="button">COMPARE</a>';
		return $buttons;
	}

	/**
	 * Core Files List
	 * Returns a list of core files default file sizes from transient.
	 */
	public function core_files_list() {
		global $wp_version;
		return get_transient( 'core_tree_list_' . $wp_version );
	}

	/**
	 * Build Core List
	 * Get file sizes and build core list.
	 */
	public function build_core_list() {

		global $wp_version;

		// Check if there is any existing copy in transients.
		if ( false === ( $core_tree_list = $this->core_files_list() ) ) {

			// It wasn't there, so regenerate the data and save the transient.
			if ( ! $core_tree_list = API::download_core_tree() ) {
				return false; // Couldn't download core list.
			}

			$hours = 60 * 60 * 4; // 60 seconds * 60 = 4 hours.
			set_transient( 'core_tree_list_' . $wp_version, $core_tree_list, $hours );
		}

		return true;

	}

	/**
	 * Get Whitelist
	 * Get whitelist for the current WP version.
	 */
	public function whitelist() {

		$whitelist = array();

		foreach ( $this->core_files_list() as $file ) {
			$whitelist[ $file->file ] = $file->size;
		}

		return $whitelist;
	}

	/**
	 * Check file
	 * Check a specific file.
	 *
	 * @param string $file Which file to check.
	 */
	public function check_file( $file ) {

		global $umbrella_antivirus;

		$file_path = ABSPATH . $file;

		$scanner = $umbrella_antivirus->scanner;
		$whitelist = $this->whitelist();

		// File is unknown (not included in core).
		if ( ! isset( $whitelist[ $file ] ) ) {
			return $scanner->add_result(
				'core_scanner',
				$file, // Relative file path.
				'0010', // Error code.
				'Unexpected file' // Error Message.
			);
		}

		$original_size = $whitelist[ $file ];

		if ( filesize( $file_path ) != $original_size ) {
			return $scanner->add_result(
				'core_scanner',
				$file, // Relative file path.
				'0020', // Error code.
				'Modified file' // Error Message.
			);
		}

	}

	/**
	 * Scan Core Files
	 * Initialize the core file scanner.
	 */
	public function scan_core_files() {

		$system_files = $this->system_files();

		foreach ( $system_files as $file ) {
			$this->check_file( $file );
		}

		return count( $system_files );
	}

	/**
	 * System files
	 * Returns a list of all files to scan
	 */
	public function system_files() {

		$exclude = $this->excluded_paths;
		$output = array();

		// Get files and directories recursive from ABSPATH.
		$files = new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator( ABSPATH ) );

		foreach ( $files as $file ) {

			$file = (string) $file;
			$continue = 0;

			// Continue if file is in $excluded_paths.
			foreach ( $exclude as $e ) {
				if ( strpos( $file, $e ) !== false ) {
					$continue = 1;
				}
			}

			if ( 0 == $continue ) {
				$output[] = str_replace( ABSPATH, '', $file );
			} else {
				$continue = 1;
			}
		}

		return $output;
	}

	/**
	 * AJAX: Init Core Scanner
	 * Initializes a core scan
	 */
	public function wp_ajax_core_scanner() {

		$this->only_admin(); // Die if not admin.

		$number_of_files = $this->scan_core_files(); // Scan all core files.
		$number_of_files = number_format( $number_of_files );

		$output = array(
			'status' => 'success',
			'logs' => array(
				"Core scanner finished. Scanned {$number_of_files} files."
			),
		);

		$this->render_json( $output );
	}

	/**
	 * AJAX: Update Core Database
	 * Initializes an update of CORE database.
	 */
	public function wp_ajax_update_core_db() {

		$this->only_admin(); // Die if not admin.

		if ( $this->build_core_list() ) {
			$output = array(
				'status' => 'success',
				'logs' => array(
					'Update database finished.',
				),
			);
		} else {
			$output = array(
				'status' => 'error',
				'logs' => array(
					'Could not build core list.',
				),
			);
		}

		$this->render_json( $output );
	}
}
