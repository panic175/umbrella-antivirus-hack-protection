<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
Umbrella\Controller::header($data); ?>

<h4><?php _e('Writable Files', UMBRELLA__TEXTDOMAIN); ?></h4>
<p>
</p>
<table class="wp-list-table widefat plugins">
	<thead>
		<tr>
			<th><?php _e('File', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Chmod', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Recommended', UMBRELLA__TEXTDOMAIN); ?></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th><?php _e('File', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Chmod', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Recommended', UMBRELLA__TEXTDOMAIN); ?></th>
		</tr>
	</tfoot>

	<tbody id="the-list">

	<?php foreach($warning_list as $list): ?>
		<tr class="alternate">
			<td><?php echo $list['file']; ?></td>
			<td style="color:red"><?php echo $list['chmod']; ?></td>
			<td>644</td>
		</tr>	
	<?php endforeach; ?>			
	</tbody>
</table>
<?php Umbrella\Controller::footer(); ?>