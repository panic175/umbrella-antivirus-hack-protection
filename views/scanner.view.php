<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
Umbrella\Controller::header($data); ?>
<h2><?php _e('Core Scanner', UMBRELLA__TEXTDOMAIN); ?></h2>

<p>
	<?php _e('This will search trough your core folders for unexpected files or modifications in core files.', UMBRELLA__TEXTDOMAIN); ?>
	<br>
	<?php _e('The scanner will not include your wp-content directory nor your wp-config.php file.', UMBRELLA__TEXTDOMAIN); ?>
</p>

<p id="umbrella-scan-console">
	<button id="startscanner" class="button button-primary"><span class="label"><?php _e('Scan core files', UMBRELLA__TEXTDOMAIN); ?></span><img class="scanner-ajax-loader" src="<?php echo UMBRELLA__PLUGIN_URL; ?>img/ajax-loader.gif" alt="">
</button>
</p>

<p id="no-errors-found">
	<?php _e('Core scanner succeeded without any errors. Your WordPress CORE is fine =)', UMBRELLA__TEXTDOMAIN); ?>
</p>

<?php if(is_array($fileslist) AND count($fileslist) != 0): ?>
<h4 id="latest-results"><?php _e('Results from latest scan:', UMBRELLA__TEXTDOMAIN); ?></h4>
<?php endif; ?>

<table id="filescanner" class="wp-list-table widefat plugins" <?php
	if (is_array($fileslist) AND count($fileslist) != 0) echo 'style="display:block;"';
?>>
	<thead>
		<tr>
			<th style="width:120px;"><?php _e('Error', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('File path', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('md5 checksum', UMBRELLA__TEXTDOMAIN); ?></th>
			<th style="width:300px;"><?php _e('Action', UMBRELLA__TEXTDOMAIN); ?></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th style="width:120px;"><?php _e('Error', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('File path', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('md5 checksum', UMBRELLA__TEXTDOMAIN); ?></th>
			<th style="width:300px;"><?php _e('Action', UMBRELLA__TEXTDOMAIN); ?></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
	<?php if(is_array($fileslist)): foreach($fileslist as $file): ?>
		<tr class="alternate">
			<td>
				<strong><?php echo esc_attr($file['response']['error']['msg']); ?></strong><br>
				<small>#<?php echo esc_attr($file['response']['error']['code']); ?></small>
			</td>
			<td class='file_path'><?php echo esc_attr($file['file']); ?></td>
			<td>
			<?php echo esc_attr($file['response']['md5']); ?>
			</td>
			<td>
				<?php foreach($file['response']['buttons'] as $btn): ?>
					<a href="<?php echo esc_url($btn['href']); ?>" class="button"><?php echo esc_attr($btn['label']); ?></a> &nbsp;
				<?php endforeach; ?>
			</td>
		</tr>
	<?php endforeach; endif; ?>
	</tbody>
</table>

<a name="compare-results"></a>
<br><hr><br>

<div id="compare-container">
	<h4>Compare File</h4>
	<h5 id="file_path_header"></h5>
	<div class="revisions-diff-frame">
		<div class="revisions-diff">
			<div class="diff">	

			<table class="diff">
				<tr>
					<td class="diffBlank"><h4>Original File</h4></td>
					<td class="diffBlank"><h4>Modifications</h4></td>
				</tr>
			</table>

			<div id="compare-results-data"></div>

			</div>
		</div>
	</div>
</div>

<style type="text/css">
	#progressbar {
		background: #e1e1e1;
		height: 10px;
	}
	.progress {
		background: #2980b9;
		height: 10px;
		width: 1%;
		float: left;
		visibility: hidden;
	}
</style>
<?php Umbrella\Controller::footer(); ?>