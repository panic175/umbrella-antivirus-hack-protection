<?php if ( ! defined( 'ABSPATH' ) ) exit;  
if (isset($refresh_page)): 
?>
<script type="text/javascript">
	location.href='admin.php?page=<?php echo esc_attr($_GET['page']); ?>';
</script>
<?php endif; ?>
<div class="wrap">
<div id="umbrella-site-protection">

	<img id="header-img" src="<?php echo UMBRELLA__PLUGIN_URL; ?>/img/header.jpeg" alt="">

	<nav id="umbrella-nav">
		<ul>
			<?php foreach($navbars as $nav): ?>
				<li class="<?php
					if (isset($_GET['page']) AND $_GET['page'] == $nav[0])
						echo 'current'
				?>"><a href="admin.php?page=<?php echo $nav[0]; ?>"><?php echo $nav[1]; ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>

	<div class="spacer"></div>

	<?php do_action('admin_notices'); ?>

	<div id="umbrella_subscribe_box">
		<h3><?php _e('Do you enjoy our product?', UMBRELLA__TEXTDOMAIN); ?><a href="#" id="nosubscribe" onclick="javascript:jQuery('#umbrella_subscribe_box').fadeOut();">No thanks</a></h3>
		<p><?php _e('Why not sign up for email updates? We promise we won\'t spam you, and we\'ll only send out emails when we have written someting truly worth reading.', UMBRELLA__TEXTDOMAIN); ?></p>
		<form id="subscribe-form" action="">
			<input type="hidden" name="page" value="<?php echo esc_attr($_GET['page']); ?>">
			<input type="submit" name="do" value="subscribe" value="<?php _e('SUBSCRIBE', UMBRELLA__TEXTDOMAIN); ?>" style="float:right;">
			<p style="width: 70%;">
				<?php
				$user = get_userdata(get_current_user_id());
				?>
				<input name="e" id="email" placeholder="<?php echo $user->user_email; ?>" value="<?php echo $user->user_email; ?>" type="text" class="big-input" style="width:100%;">
			</p>
		</form>
	</div>