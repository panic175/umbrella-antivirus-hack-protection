<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
Umbrella\Controller::header($data);
global $wp_version;
?>
<p>
	<?php _e('Downloading data for your Wordpress version...',UMBRELLA__TEXTDOMAIN); ?>
</p><p>
	<strong style="color:red"><?php _e('Please wait while downloading latest core database.', UMBRELLA__TEXTDOMAIN); ?></strong>
</p>
<script>
jQuery(document).ready(function($) {
  var data = {
    'action': 'umbrella_build_core_list'
  };
  $.post(ajaxurl, data, function(response) {
    location.reload();
  });
});
</script>

<?php Umbrella\Controller::footer(); ?>