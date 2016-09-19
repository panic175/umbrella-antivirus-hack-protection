<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
Umbrella\Controller::header($data); ?>

<h2><?php _e('Database backups', UMBRELLA__TEXTDOMAIN); ?></h2>
<p><?php _e('This will export all of your database tables into a downloadable SQL-file.', UMBRELLA__TEXTDOMAIN); ?></p>

<a href="?page=umbrella-backup&amp;do=create-backup" class="button button-primary"><?php _e('Backup mySQL-database now', UMBRELLA__TEXTDOMAIN); ?></a>

<?php if (count($mysql_dumps) > 0): ?>
<br><br>
<table class="wp-list-table widefat plugins">
	<thead>
		<tr>
			<th><?php _e('Date Created', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('MD5 checksum', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Location', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('File Size', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Download', UMBRELLA__TEXTDOMAIN); ?></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th><?php _e('Date Created', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('MD5 checksum', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Location', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('File Size', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Download', UMBRELLA__TEXTDOMAIN); ?></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
	<?php if(is_array($mysql_dumps)): foreach($mysql_dumps as $row): ?>
		<tr class="alternate">
			<td><?php echo $row['created_at']; ?></td>
			<td><?php echo $row['md5']; ?></td>
			<td><?php echo $row['path']; ?></td>
			<td><?php echo $row['filesize']; ?></td>
			<td><a target="_blank" class="button" href="<?php echo esc_url($row['url']); ?>"><?php _e('Download SQL-file', UMBRELLA__TEXTDOMAIN); ?></a></td>
		</tr>
	<?php endforeach; endif; ?>
	</tbody>
</table>
<?php endif; ?>



<?php Umbrella\Controller::footer(); ?>