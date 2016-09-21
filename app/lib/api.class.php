<?php
/**
 * Api
 * Includes the class for connection with UmbrellaAntivirus.com API
 *
 * @package UmbrellaAntivirus
 */

namespace Umbrella;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

/**
 * API
 * Helps to connect with UmbrellaAPI
 *
 * @package UmbrellaAntivirus
 */
class API {

	/**
	 * Base URL UmbrellaAntivirus API
	 *
	 * @var string
	 */
	private static $api_base = 'http://api.umbrellaantivirus.com/api/';

	/**
	 * UmbrellaAntivirus API version
	 *
	 * @var integer
	 */
	private static $api_version = '1.0';

	/**
	 * API URL
	 * Returns API url
	 *
	 * @return string
	 */
	public static function api_url() {
		return trailingslashit( self::$api_base . 'v' . self::$api_version );
	}

	/**
	 * Download Core Tree
	 * Download file sizes from github commit via API
	 *
	 * @return array
	 */
	public static function download_core_tree() {
		global $wp_version;

		try {
			$response = wp_remote_get( self::api_url() . 'corelists/download?wp_version=' . $wp_version );

			if ( is_wp_error( $response ) || ! isset( $response['body'] ) ) {
				return false; // Return false if error!
			}

			$response = json_decode( $response['body'] ); // Convert into object.

			if ( isset( $response->status ) and 'success' == $response->status ) {
				return $response->files; // Return false if no status.
			} else {
				return false;
			}
		} catch (Exception $e) {
			return false;
		}

	}
}
