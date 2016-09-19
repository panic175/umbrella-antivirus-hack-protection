<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
Umbrella\Controller::header($data);
global $wp_version;
global $current_user;
?>
<h3><?php _e('An introduction to Umbrella Network', UMBRELLA__TEXTDOMAIN); ?></h3>
<p><?php _e('Do you manage a lot of WordPress sites?', UMBRELLA__TEXTDOMAIN); ?> <strong>Then you'll love this.</strong></p> We will soon release our PREMIUM feature Umbrella Network. Upgrade to Umbrella Network and <strong>manage all of our services/plugins from one place</strong>. Link all of your websites together and we will make monitored security scans on all of your WordPress sites once an hour. If we find anything suspicious, we'll send you an email right away!</p>

<h3><?php _e('We are looking for BETA testers', UMBRELLA__TEXTDOMAIN); ?></h3>
<p><?php _e('We will soon release our first BETA version and give out 100 beta invites for free.', UMBRELLA__TEXTDOMAIN); ?><br>
<?php _e('If you want to be one of the first BETA-testers, subcribe to our email list by filling in your email in the form below and we will send you an invite when our first beta of Umbrella Network is released.', UMBRELLA__TEXTDOMAIN); ?></p>

<!-- Begin MailChimp Signup Form -->
<div id="mc_embed_signup">
<form action="//umbrellaplugins.us10.list-manage.com/subscribe/post?u=c9275a8fcb137f275b3fe9cdf&amp;id=5265868950" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
	<h3>Request free BETA Invite</h3>
	<div class="mc-field-group">
		<h4>Email Address </h4>
		<input type="text" value="<?php echo $current_user->user_email; ?>" name="EMAIL" class="required email big-input" id="mce-EMAIL">
	</div>
	<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;"><input type="text" name="b_c9275a8fcb137f275b3fe9cdf_5265868950" tabindex="-1" value=""></div>
    <div class="clear"><br><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form>
</div>
<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
<!--End mc_embed_signup-->
<?php Umbrella\Controller::footer(); ?>