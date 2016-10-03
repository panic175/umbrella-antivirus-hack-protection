<?php
/**
 * Modules
 * This is the base for the Modules handler for UmbrellaAntivirus
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

namespace Umbrella;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

/**
 * Modules
 * Handles and loads available modules.
 *
 * @package UmbrellaAntivirus
 */
class Modules extends UmbrellaAntivirus {

	/**
	 * Whitelabel autoload actions/methods
	 * List of valid methods/hooks.
	 *
	 * @since 2.0
	 * @var array
	 */
	protected $autoload = array( 'wp_ajax_list_modules', 'wp_ajax_activate_module', 'wp_ajax_deactivate_module' );

	/**
	 * Valid Modules
	 * Returns an array with all valid modules that can be activated.
	 *
	 * @todo: Should read from config file instead of being hard-coded in this class.
	 * @return array
	 */
	static public function valid_modules() {
		return array(
			array( 'realtime_updates', 'Realtime Updates', __( 'Check for plugin updates each 10 minutes instead of each 12 hours.', 'umbrella-antivirus-hack-protection' ) ),
			array( 'filter_requests', 'Filter Requests', __( 'Block all unauthorized and irrelevant requests through query strings.', 'umbrella-antivirus-hack-protection' ) ),
			array( 'captcha_login', 'Captcha Login', __( 'Add CAPTCHA to login screen.', 'umbrella-antivirus-hack-protection' ) ),
			array( 'hide_version', 'Hide Versions', __( 'Hide version numbers in your front-end source code for WordPress-core and all of your plugins. This will affect meta-tags, stylesheet and javascripts urls.', 'umbrella-antivirus-hack-protection' ) ),
			array( 'disable_ping', 'Disable Pings', __( 'Completely turn off trackbacks & pingbacks to your site.', 'umbrella-antivirus-hack-protection' ) ),
			array( 'disable_editor', 'Disable Themes & Plugins-editor', __( 'Disable Themes & Plugins-editor so that files can not be changed trough WordPress Dashboard.', 'umbrella-antivirus-hack-protection' ) ),
		);
	}

	/**
	 * AJAX: List modules
	 * Returns a list of valid modules and activation status.
	 */
	public function wp_ajax_list_modules() {

		$this->only_admin(); // Die if not admin.
		check_ajax_referer( 'umbrella_ajax_nonce', 'security' ); // Check nonce.

		$modules = Modules::valid_modules();
		$response = array();

		foreach ( $modules as $module ) {
			$response[] = array(
				'slug' => $module[0],
				'name' => $module[1],
				'description' => $module[2],
				'status' => $this->status( $module[0] ),
			);
		}

		$this->render_json( $response );
	}

	/**
	 * AJAX: Activate module.
	 * Activate a module with ajax.
	 */
	public function wp_ajax_activate_module() {

		$this->only_admin(); // Die if not admin.
		check_ajax_referer( 'umbrella_ajax_nonce', 'security' ); // Check nonce.

		if ( isset( $_POST['slug'] ) ) {
			$module = sanitize_text_field( wp_unslash( $_POST['slug'] ) );
		} else {
			die( 'No such module' );
		}

		$options = get_option( 'umbrella_load_modules' );
		$options[ $module ] = 1;
		update_option( 'umbrella_load_modules', $options );

		$this->render_json( $module );
	}
	/**
	 * AJAX: Deactivate module.
	 * Deactivate a module with ajax.
	 */
	public function wp_ajax_deactivate_module() {

		$this->only_admin(); // Die if not admin.
		check_ajax_referer( 'umbrella_ajax_nonce', 'security' ); // Check nonce.

		if ( isset( $_POST['slug'] ) ) {
			$module = sanitize_text_field( wp_unslash( $_POST['slug'] ) );
		} else {
			die( 'No such module' );
		}

		$options = get_option( 'umbrella_load_modules' );
		$options[ $module ] = 0;
		update_option( 'umbrella_load_modules', $options );

		$this->render_json( $module );
	}

	/**
	 * Status
	 * Check if module is activated or inactivated.
	 *
	 * @param string $module_slug Slug of module to check.
	 */
	public function status( $module_slug ) {

		$module_settings = get_option( 'umbrella_load_modules' );

		if ( isset( $module_settings[ $module_slug ] ) and 1 == $module_settings[ $module_slug ] ) {
			return 'active';
		} else {
			return 'inactive';
		}
	}

	/**
	 * Valid Module Slugs
	 * Get a list of valid module slugs that can be included.
	 *
	 * @return array
	 */
	static public function valid_modules_slugs() {
		$modules = self::valid_modules();
		$count = count( $modules );
		$max_index = $count - 1;

		for ( $i = 0; $i <= $max_index; $i++ ) {
			$output[] = $modules[ $i ][0];
		}

		return $output;
	}

	/**
	 * Validate Modules
	 * Creates a list of options to register_settings in autoload.class.php
	 *
	 * @param array $options List of options.
	 */
	static public function validate_modules( $options ) {

		$valid_modules = Modules::valid_modules();

	    if ( ! is_array( $options ) || empty( $options ) || ( false === $options ) ) {
	        return array();
	    }

	    $valid_names = $valid_modules;
	    $clean_options = array();

	    foreach ( $valid_names as $option_name ) {
	        if ( isset( $options[ $option_name[0] ] ) && ( 1 == $options[ $option_name[0] ] ) ) {
	            $clean_options[ $option_name[0] ] = 1;
	        }
	        continue;
	    }

	    unset( $options );
	    return $clean_options;
	}
}
