<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('plugins_loaded', 'umbrella_filter_requests_loaded');
function umbrella_filter_requests_loaded() {
	/*
	* Get trough all requests and queires to see if we find something suspicous.
	*/

	$forbidden_requests	= apply_filters('request_uri_items',  array('eval\(', 'UNION\+SELECT', '\(null\)', 'base64_', '\/pingserver', '\/config\.', '\/wwwroot', '\/makefile', 'crossdomain\.', 'proc\/self\/environ', 'etc\/passwd', '\/https\:', '\/http\:', '\/ftp\:', '\/cgi\/', '\.cgi', '\.exe', '\.sql', '\.ini', '\.dll', '\.asp', '\.jsp', '\/\.bash', '\/\.git', '\/\.svn', '\/\.tar', ' ', '\<', '\>', '\/\=', '\.\.\.', '\+\+\+', '\:\/\/', '\/&&', '\/Nt\.', '\;Nt\.', '\=Nt\.', '\,Nt\.', '\.exec\(', '\)\.html\(', '\{x\.html\(', '\(function\('));
	$forbidden_queries	= apply_filters('query_string_items', array('\.\.\/', 'loopback', '\%0A', '\%0D', '\%00', '\%2e\%2e', 'input_file', 'execute', 'mosconfig', 'path\=\.', 'mod\=\.'));

	$request  = false;
	$query = false;

	if (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI']))
		$request = $_SERVER['REQUEST_URI'];

	if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']))
		$query = $_SERVER['QUERY_STRING'];

	if ($request || $query) {
		if (
			preg_match( '/' . implode( '|', $forbidden_requests )  . '/i', $request ) ||
			preg_match( '/' . implode( '|', $forbidden_queries ) . '/i', $query )
		) {

		    Umbrella\Log::write('Filter Requests', __('Blocked suspicous request', UMBRELLA__TEXTDOMAIN));

			header('HTTP/1.1 403 Forbidden');
			header('Status: 403 Forbidden');
			echo "403 Forbidden. Protected by <a target='_blank' href='https://www.siteprotection.co'>SiteProtection</a>.";
			die();
			exit;
		}
	}
}