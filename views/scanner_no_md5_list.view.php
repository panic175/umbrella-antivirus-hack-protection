<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
Umbrella\Controller::header($data);
global $wp_version;
?>
<p>
	<?php _e('This scanner does not work with your version of WordPress. Please update your core files.',UMBRELLA__TEXTDOMAIN); ?>
</p><p>
	<strong style="color:red"><?php _e('Please also make sure that Umbrella is running the latest version', UMBRELLA__TEXTDOMAIN); ?></strong>
</p>

<?php Umbrella\Controller::footer(); ?>