<?php
/**
 * Security Checks
 * Checks for security issues and returns a status
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

namespace Umbrella;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

/**
 * Security Checks
 * Checks for security issues and returns a status
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */
class SecurityChecks extends UmbrellaAntivirus {

	/**
	 * Whitelabel autoload actions/methods
	 * List of valid methods/hooks.
	 *
	 * @since 2.0
	 * @var array
	 */
	protected $autoload = array( 'admin_menu', 'wp_ajax_get_security_status', 'wp_ajax_get_security_list' );

	/**
	 * Checks
	 * List of methods to check
	 *
	 * @since 2.0
	 * @var array
	 */
	protected $checks = array(
		'check_scan_results' => array(
			'weight' => 100,
			'desc' => 'Scanner was run without any security issues within the latest 24 hours.',
		),
		'check_module_auto_update' => array(
			'weight' => 5,
			'desc' => 'Umbrella module "Realtime Updates" is activated.',
		),
		'check_module_filter_requests' => array(
			'weight' => 20,
			'desc' => 'Umbrella module "Filter Requests" is activated.',
		),
		'check_module_captcha_login' => array(
			'weight' => 30,
			'desc' => 'Umbrella module "Captcha login" is activated.',
		),
		'check_module_hide_version' => array(
			'weight' => 5,
			'desc' => 'Umbrella module "Hide Versions" is activated.',
		),
		'check_module_disable_ping' => array(
			'weight' => 5,
			'desc' => 'Umbrella module "Disable Ping" is activated.',
		),
		'check_module_disable_editor' => array(
			'weight' => 5,
			'desc' => 'Umbrella module "Disable Editor" is activated.',
		),
		'check_user_admin_exists' => array(
			'weight' => 10,
			'desc' => 'A user with username "admin" should not exist.',
		),
		'check_wp_debug' => array(
			'weight' => 10,
			'desc' => 'WP_DEBUG should not be enabled.',
		),
		'check_latest_core_version' => array(
			'weight' => 10,
			'desc' => 'WordPress core is running the latest update.',
		),
		'check_plugins_updated' => array(
			'weight' => 10,
			'desc' => 'All WordPress plugins are updated',
		),
		'check_themes_updated' => array(
			'weight' => 10,
			'desc' => 'All WordPress themes are updated',
		),
	);

	/**
	 * Admin Menu
	 * This function will run when WordPress calls the hook "admin_menu".
	 */
	public function admin_menu() {
		$this->add_submenu( 'Security Checks', 'admin_page_view', 'fa fa-check-square-o' );
	}


	/**
	 * Check that scanner was runned with successfull results within 24 hours
	 */
	private function check_scan_results() {
		$results = get_transient( 'umbrella-scanner-results' );
		return ( isset( $results ) and is_array( $results ) and empty( $results ) );
	}

	/**
	 * Check that module Auto update is activated.
	 */
	private function check_module_auto_update() {
		return $this->check_module( 'realtime_updates' );
	}

	/**
	 * Check that module Filter Requests is activated.
	 */
	private function check_module_filter_requests() {
		return $this->check_module( 'filter_requests' );
	}

	/**
	 * Check that module Captcha login is activated.
	 */
	private function check_module_captcha_login() {
		return $this->check_module( 'captcha_login' );
	}

	/**
	 * Check that module Hide Version is activated.
	 */
	private function check_module_hide_version() {
		return $this->check_module( 'hide_version' );
	}

	/**
	 * Check that module Disable Ping is activated.
	 */
	private function check_module_disable_ping() {
		return $this->check_module( 'disable_ping' );
	}

	/**
	 * Check that module Disable Editor is activated.
	 */
	private function check_module_disable_editor() {
		return $this->check_module( 'disable_editor' );
	}

	/**
	 * Check if "admin" username exists
	 */
	private function check_user_admin_exists() {
		return false === username_exists( 'admin' );
	}

	/**
	 * Check so that WP_DEBUG is not enabled.
	 */
	private function check_wp_debug() {
		return false === WP_DEBUG;
	}

	/**
	 * Check latest WP core version.
	 */
	private function check_latest_core_version() {

		wp_version_check();
		$latest_core_update = get_preferred_from_update_core();

		return false === ( isset( $latest_core_update->response ) && ( 'upgrade' == $latest_core_update->response ) );
	}

	/**
	 * Check that all plugins are updated.
	 */
	private function check_plugins_updated() {

		wp_update_plugins();

		$plugins = get_site_transient( 'update_plugins' );
		$plugins_count = 0;

		if ( isset( $plugins->response ) && is_array( $plugins->response ) ) {
			$plugins_count = count( $plugins->response );
		}

		return false == ( $plugins_count > 0 );
	}

	/**
	 * Check that all themes are updated.
	 */
	private function check_themes_updated() {

		wp_update_themes();

		$themes = get_site_transient( 'update_themes' );
		$themes_count = 0;

		if ( isset( $themes->response ) && is_array( $themes->response ) ) {
			$themes_count = count( $themes->response );
		}

		return false == ( $themes_count > 0 );
	}

	/**
	 * Check that a module is activated.
	 *
	 * @param string $module Module to check.
	 */
	private function check_module( $module ) {
		global $umbrella_antivirus;

		if ( 'active' == $umbrella_antivirus->modules->status( $module ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * AJAX: Get security list
	 * Get full list of security checks with status
	 */
	public function wp_ajax_get_security_list() {

		$this->only_admin(); // Die if not admin.
		check_ajax_referer( 'umbrella_ajax_nonce', 'security' ); // Check nonce.

		$response = array();

		foreach ( $this->checks as $method => $data ) {
			if ( method_exists( $this, $method ) and true === $this->$method() ) {
				$response[] = array(
					'method' => $method,
					'description' => $data['desc'],
					'passed' => true,
					'weight' => $data['weight'],
				);
			} else {
				$response[] = array(
					'method' => $method,
					'description' => $data['desc'],
					'passed' => false,
					'weight' => $data['weight'],
				);
			}
		}

		$this->render_json( $response );

	}

	/**
	 * AJAX: Get security status
	 * Get security status for status bar
	 */
	public function wp_ajax_get_security_status() {

		$this->only_admin(); // Die if not admin.
		check_ajax_referer( 'umbrella_ajax_nonce', 'security' ); // Check nonce.

		$total_checks = count( $this->checks );
		$total_passed = 0;

		$total_weight = 0;
		$passed_weight = 0;

		foreach ( $this->checks as $method => $data ) {
			$weight = $data['weight'];
			$total_weight = $total_weight + $weight;

			if ( method_exists( $this, $method ) and true === $this->$method() ) {
				$total_passed++;
				$passed_weight = $passed_weight + $weight;
			}
		}

		$percent = ( $passed_weight / $total_weight ) * 100;

		if ( $percent > 80 ) {
			$class = 'green';
		} else {
			$class = 'red';
		}

		$response = array(
			'class' => $class,
			'percent' => $percent,
			'total_checks' => $total_checks,
			'passed_checks' => $total_passed,
			'total_points' => $total_weight,
			'passed_points' => $passed_weight,
		);

		$this->render_json( $response );
	}


	/**
	 * Admin Page View
	 * Load admin page view
	 */
	public function admin_page_view() {
		$this->render( 'security-checks' );
	}

}
