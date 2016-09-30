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
	protected $autoload = array( 'init', 'admin_menu' );

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
	function autoload() {

		// Loop trough hooks and add actions for those who have declared methods.
		foreach ( $this->autoload as $hook ) {
			if ( method_exists( $this, $hook ) ) {
				add_action( $hook, array( $this, $hook ) );
			}
		}

	}

	/**
	 * Init
	 * This function will run when WordPress calls the hook "init".
	 *
	 * @since 2.0
	 */
	function init() {
		// Always autoupdate Umbrella Antivirus for security reasons.
		add_filter( 'auto_update_plugin', array( $this, 'filter_auto_update_plugin' ), 10, 2 );
	}

	/**
	 * Admin Menu
	 * This function will run when WordPress calls the hook "admin_menu".
	 *
	 * @since 2.0
	 */
	function admin_menu() {

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
	 * Auto Update Plugin
	 * auto_update_plugin filter
	 *
	 * @param bool   $update Whether to update (not used for plugins).
	 * @param object $item Wordpress plugin object.
	 */
	public function filter_auto_update_plugin( $update, $item ) {

		// Array of plugin slugs to always auto-update.
	    $plugins = array( 'umbrella-antivirus-hack-protection' );

	    if ( in_array( $item->slug, $plugins ) ) {
	        return true; // Always update plugins in this array.
	    } else {
	        return $update; // Else, use the normal API response to decide whether to update or not.
	    }
	}

	/**
	 * Add submenu page
	 * This function will run when WordPress calls the hook "admin_menu".
	 *
	 * @since 2.0
	 * @param string $menu_name Name displayed in admin menu.
	 * @param string $method_name The method that should be called in subclass.
	 * @param string $icon Font awesome icon class.
	 * @param string $slug_name Force slug to something else (optional).
	 */
	function add_submenu( $menu_name, $method_name, $icon, $slug_name = null ) {

		// Auto generate a slug from $menu_name if no custom slug is set.
		if ( ! isset( $slug_name ) ) {
			$slug_name = slugify( $menu_name );
		}

		add_submenu_page(
			'umbrella-antivirus',
			'Umbrella Antivirus',
			$menu_name,
			'administrator',
			$slug_name,
			array( $this, $method_name )
		);

		// Add link to header template navigation.
		$this->navlink = array(
			'title' => $menu_name,
			'icon' => $icon,
			'screen' => $slug_name,
		);

		// Add link to header template navigation.
		add_filter( 'umbrella-navigation-links', array( $this, 'add_navigation_link' ) );
	}

	/**
	 * Add link to header template navigation.
	 *
	 * @param array $navigation Default navigation array.
	 */
	function add_navigation_link( $navigation ) {
		array_push( $navigation, $this->navlink );
		return $navigation;
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

		$navigation_links = apply_filters( 'umbrella-navigation-links', array() );

		// Enqueue angular to all views.
		wp_enqueue_script( 'angular', vendor_url( 'angular/angular.min.js' ) );
		wp_enqueue_script( 'umbrella-antivirus', assets_url( 'js/umbrella-antivirus.js' ) );
		wp_enqueue_script( 'umbrella-scanner', assets_url( 'js/scanner.js' ) );
		wp_enqueue_script( 'umbrella-vulnerability-scanner', assets_url( 'js/vulnerability-scanner.js' ) );

		// Enqueue font-awesome.
		wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );

		// Enqueue Umbrella CSS.
		wp_enqueue_style( 'umbrella-antivirus', assets_url( 'css/umbrella-antivirus.css' ) );

		// Include template files if they exists.
		if ( file_exists( view_file( $view_file ) ) ) {
			include( view_file( 'template/header' ) );
			include( view_file( $view_file ) );
			include( view_file( 'template/footer' ) );
		} else {
			echo 'View ' . esc_attr( $view_file ) . ' do not exists';
		}
	}

	/**
	 * Render JSON
	 * Renders a JSON response.
	 *
	 * @since 2.0
	 * @param string $data Data that should be passed to JSON.
	 */
	function render_json( $data ) {
		header( 'Content-Type: application/json' );
		echo json_encode( $data );
		wp_die(); // this is required to terminate immediately and return a proper response.
	}

	/**
	 * Only admin
	 * Protects ajax methods from being called by non-admin users.
	 *
	 * @since 2.0
	 */
	function only_admin() {
		if ( ! is_admin() ) {
			wp_die();
		}
	}

}
