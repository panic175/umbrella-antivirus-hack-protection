<?php
namespace Umbrella;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Modules
{

	static public function valid_modules_slugs() {
		$modules = self::valid_modules();

		$count = count($modules);
		$max_index = $count - 1;

		for($i=0;$i<=$max_index;$i++) {
			$output[] = $modules[$i][0];
		}

		return $output;
	}

	static public function valid_modules() { 
		return array(
			array('realtime_updates', 'Realtime Updates', __('Check for plugin updates each 10 minutes instead of each 12 hours.', UMBRELLA__TEXTDOMAIN ) ),
			array('filter_requests', 'Filter Requests', __('Block all unauthorized and irrelevant requests through query strings.', UMBRELLA__TEXTDOMAIN ) ),
			array('captcha_login', 'Captcha Login', __('Add CAPTCHA to login screen.', UMBRELLA__TEXTDOMAIN ) ),
			array('hide_version', 'Hide Versions', __('Hide version numbers in your front-end source code for WordPress-core and all of your plugins. This will affect meta-tags, stylesheet and javascripts urls.', UMBRELLA__TEXTDOMAIN ) ),
			array('disable_ping', 'Disable Pings', __('Completely turn off trackbacks &amp; pingbacks to your site.', UMBRELLA__TEXTDOMAIN ) ),
			array('disable_editor', 'Disable Themes & Plugins-editor', __('Disable Themes & Plugins-editor so that files can not be changed trough WordPress Dashboard.', UMBRELLA__TEXTDOMAIN ) ),
		);
	}

	static public function validate_modules( $options ) {

		$valid_modules = Modules::valid_modules();
	    
	    if( !is_array( $options ) || empty( $options ) || ( false === $options ) )
	        return array();

	    $valid_names = $valid_modules;
	    $clean_options = array();

	    foreach( $valid_names as $option_name ) {
	        if( isset( $options[$option_name[0]] ) && ( 1 == $options[$option_name[0]] ) )
	            $clean_options[$option_name[0]] = 1;
	        continue;
	    }
	    unset( $options );
	    return $clean_options;
	}
}