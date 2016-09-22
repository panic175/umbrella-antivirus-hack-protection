<?php
/**
 * Umbrella Antivirus
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

namespace Umbrella;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

/**
 * Umbrella Antivirus
 * This is the base class - all modules extends this.
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */
class UmbrellaAntivirus {

	/**
	 * Whitelabel autoload actions/methods
	 * List of valid methods/hooks.
	 *
	 * @since 2.0
	 * @var array
	 */
	protected $autoload = array( 'admin_menu' );

	/**
	 * This will init the plugin and autoload files.
	 * Final makes it unable to be overwritten by subclass.
	 *
	 * @since 2.0
	 */
	public final function __construct() {
		$this->autoload();
	}

	/**
	 * Autoload
	 * Links WordPress hooks to equalient method name if they're
	 * included in the $autoload array.
	 *
	 * @since 2.0
	 */
	public function autoload() {

		// Loop trough hooks and add actions for those who have declared methods.
		foreach ( $this->autoload as $hook ) {
			if ( method_exists( $this, $hook ) ) {
				add_action( $hook, array( $this, $hook ) );
			}
		}

	}

	/**
	 * Admin Menu
	 * This function will run when WordPress calls the hook "admin_menu".
	 *
	 * @since 2.0
	 */
	public function admin_menu() {

		add_menu_page(
			__( 'Umbrella', 'umbrella-antivirus' ),
			__( 'Umbrella', 'umbrella-antivirus' ),
			'administrator',
			'umbrella-antivirus',
			null,
			'dashicons-shield'
		);
	}

	/**
	 * Add submenu page
	 * This function will run when WordPress calls the hook "admin_menu".
	 *
	 * @since 2.0
	 * @param string $menu_name Name displayed in admin menu.
	 * @param string $method_name The method that should be called in subclass.
	 */
	public function add_submenu( $menu_name, $method_name ) {

		add_submenu_page(
			'umbrella-antivirus',
			'Umbrella Antivirus',
			$menu_name,
			'administrator',
			'umbrella-antivirus',
			array( $this, $method_name )
		);

	}

	/**
	 * Render
	 * Render a view from apps/views directory if it exists.
	 *
	 * @since 2.0
	 * @param string $view_file Name of the view file.
	 * @param string $data Data that should be passed to view.
	 */
	function render( $view_file, $data = array() ) {

		if ( file_exists( view_file( $view_file ) ) ) {
			include( view_file( $view_file ) );
		} else {
			echo 'View ' . esc_attr( $view_file ) . ' do not exists';
		}

	}

}
