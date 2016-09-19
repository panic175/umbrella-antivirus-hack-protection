<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
Umbrella\Controller::header($data); 
?>


<span id="disable-admin-notices"  style="margin-left: 5px; float: right;">
	<?php if(get_option('umbrella_sp_disable_notices') AND get_option('umbrella_sp_disable_notices') == 1): ?>
		<a href="?page=umbrella-sp-logging&amp;do=enable-admin-notices" class="button button-primary"><?php _e('Enable admin notices', UMBRELLA__TEXTDOMAIN); ?></a>
	<?php else: ?>
		<a href="?page=umbrella-sp-logging&amp;do=disable-admin-notices" class="button"><?php _e('Disable admin notices', UMBRELLA__TEXTDOMAIN); ?></a>
	<?php endif; ?>
</span>

<a href="?page=umbrella-sp-logging&amp;do=empty-logs" id="empty-logs" class="button" style="float: right;"><?php _e('Empty logs', UMBRELLA__TEXTDOMAIN); ?></a>

<h3><?php _e('Logs', UMBRELLA__TEXTDOMAIN); ?></h3>
<?php if (isset($ip)) echo $ip; ?>

<?php if (!count($logs) > 0): ?>
<p><?php _e('You have no log entries yet.', UMBRELLA__TEXTDOMAIN); ?></p>
<?php else: ?>

<div class="paginator"><?php echo Umbrella\Log::paginator(); ?></div>
<table class="wp-list-table widefat plugins">
	<thead>
		<tr>
			<th style="width: 120px;"><?php _e('Time', UMBRELLA__TEXTDOMAIN); ?></th>
			<th style="width: 100px;"><?php _e('Module', UMBRELLA__TEXTDOMAIN); ?></th>
			<th style="width: 100px;"><?php _e('IP-address', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Information', UMBRELLA__TEXTDOMAIN); ?></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th style="width: 120px;"><?php _e('Time', UMBRELLA__TEXTDOMAIN); ?></th>
			<th style="width: 100px;"><?php _e('Module', UMBRELLA__TEXTDOMAIN); ?></th>
			<th style="width: 100px;"><?php _e('IP-address', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Information', UMBRELLA__TEXTDOMAIN); ?></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
	<?php foreach($logs as $log): ?>
		<tr class="alternate">
			<td>
			<?php 
			if ($log->admin_notice == 1)
				echo "<strong>" . $log->time . "</strong>";
			else
				echo esc_attr($log->time); 
			?></td>
			<td><?php echo esc_attr($log->module); ?></td>
			<td>
				<a href="?page=umbrella-sp-logging&amp;ip=<?php echo esc_attr($log->visitor_ip); ?>">
				<?php echo esc_attr($log->visitor_ip); ?>
				</a>
			</td>
			<td><?php echo esc_attr($log->message); ?> &nbsp; <small>(<a href="javascript:toggleDetails(<?php echo esc_attr($log->id); ?>);"><?php _e('toggle advanced details', UMBRELLA__TEXTDOMAIN); ?></a>)</small></td>
		</tr>
		<tr class="logdetails log-id-<?php echo esc_attr($log->id); ?>">
			<td colspan="4">

				<strong><?php _e('VISITOR INFORMATION', UMBRELLA__TEXTDOMAIN); ?></strong>
				<hr>
				<strong>IP-address:</strong> <?php echo esc_attr(urldecode($log->visitor_ip)); ?><br>
				<strong>Log entries:</strong> <?php echo Umbrella\Log::count_by_ip($log->visitor_ip); ?><br>

				<br>

				<strong><?php _e('$_REQUEST DATA', UMBRELLA__TEXTDOMAIN); ?></strong>
				<hr>
				<?php 
				$request_data = unserialize($log->request_data);
				foreach($request_data as $key => $value): 
				?>
				<strong>$_REQUEST['<?php echo esc_attr($key); ?>']</strong> = <?php echo esc_attr($value); ?><br>
				<?php endforeach; ?>

				<br>

				<strong><?php _e('QUERY STRING', UMBRELLA__TEXTDOMAIN); ?></strong>
				<hr>
				<?php echo esc_attr(urldecode($log->query_string)); ?>

			</td>
		</tr>	
	<?php endforeach; ?>	

	</tbody>
</table>
<div class="paginator"><?php echo Umbrella\Log::paginator(); ?></div>
<?php endif; ?>
<?php Umbrella\Controller::footer(); ?>