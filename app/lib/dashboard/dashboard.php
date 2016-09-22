<?php
/**
 * Dashboard
 * This is the dashboard file for UmbrellaAntivirus
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

namespace Umbrella;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

/**
 * Dashboard
 * Umbrella Antivirus dashboard
 *
 * @package UmbrellaAntivirus
 */
class Dashboard extends UmbrellaAntivirus {

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
		$this->add_submenu( 'Dashboard', 'admin_page_view', 'fa fa-dashboard', 'umbrella-antivirus' );
	}

	/**
	 * Admin Page View
	 * Load admin page view
	 */
	public function admin_page_view() {
		$this->render( 'dashboard' );
	}
}
