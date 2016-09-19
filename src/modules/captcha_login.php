<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function captcha_no_gd_msg() {
?>
<div class="error umbrella">
    <p>
    	<a href="admin.php?page=umbrella-site-protection"><strong><?php _e( 'Site Protection', UMBRELLA__TEXTDOMAIN ); ?></strong></a>: 
    	<?php _e( 'WARNING! Captcha Login doesn\'t work without the GD & FreeType PHP modules.', UMBRELLA__TEXTDOMAIN ); ?>
	</p>
</div>
<?php
}

if (function_exists('imagettftext')) {

	// Displaying the Captcha Field in the Login Form
	add_action('login_form', 'umbrella_captcha_login_form');
	function umbrella_captcha_login_form() {
		if(class_exists('Umbrella\ReallySimpleCaptcha')) {
			$captcha_instance = new Umbrella\ReallySimpleCaptcha();
			$word = $captcha_instance->generate_random_word();
			$prefix = mt_rand();
			$captchaimg = $captcha_instance->generate_image( $prefix, $word );
			$imgpath = UMBRELLA__PLUGIN_TMPURL . $captchaimg;

			echo "<input type='hidden' name='umbrella_captcha_prefix' value='{$prefix}'/>";
			echo "<img src='{$imgpath}' style='float: right;position: absolute;margin-left: 190px;margin-top: 11px;' /><input name='umbrella_captcha_text' type='text' />";
		}
	}

	// Validating the Captcha
	add_filter('wp_authenticate_user', 'umbrella_captcha_auth_user', 10, 2);
	function umbrella_captcha_auth_user($user, $password) {
		$return_value = $user;

		if(class_exists('Umbrella\ReallySimpleCaptcha')){

			$captcha_instance = new Umbrella\ReallySimpleCaptcha();
			$prefix = $_POST['umbrella_captcha_prefix'];
			if(!$captcha_instance->check( $prefix, $_POST['umbrella_captcha_text'] ))
			{
				$user_login = $user->user_login;
			  // if there is a mis-match
				Umbrella\Log::write('Captcha Login', "Blocked login attempt with captcha error for user: {$user_login} ");
				$return_value = new WP_Error( 'loginCaptchaError', 'Captcha Error. Please try again.' );
			}

			// remember to remove the prefix
			$captcha_instance->remove( $prefix );
		}
		return $return_value;

	} 	

}
// no GD library
else {
	add_action( 'admin_notices', 'captcha_no_gd_msg' ); 
}



