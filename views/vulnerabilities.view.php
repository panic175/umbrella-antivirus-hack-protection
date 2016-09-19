<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
Umbrella\Controller::header($data); ?>

<h3><?php _e('Plugin Vulnerabilities', UMBRELLA__TEXTDOMAIN); ?></h3>
<p>
</p>
<table class="wp-list-table widefat plugins">
	<thead>
		<tr>
			<th><?php _e('Plugin Name', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Plugin Version', UMBRELLA__TEXTDOMAIN); ?></th>
			<th style="width:60%;"><?php _e('Vulnerabilities', UMBRELLA__TEXTDOMAIN); ?></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th><?php _e('Plugin Name', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Plugin Version', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Vulnerabilities', UMBRELLA__TEXTDOMAIN); ?></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
		<?php foreach($plugins as $plugin):

			if (!isset($plugin['vulndb']['response']))
					continue;
		?>
		<tr>
			<td>
				<strong><?php echo esc_attr($plugin['Name']); ?></strong><br>
				<em>by <?php echo esc_attr($plugin['Author']); ?></em>
			</td>
			<td><?php echo esc_attr($plugin['Version']); ?></td>
			<td>
				<?php
				if ($plugin['vulndb']['response']['code'] == '404'): 
					_e('No vulnerabilities found.', UMBRELLA__TEXTDOMAIN);

				elseif ($plugin['vulndb']['response']['code'] == '501'): 
					_e('Couldn\'t connect. Please reload this page.', UMBRELLA__TEXTDOMAIN);
				
				else: 
					$vulndb = json_decode($plugin['vulndb']['body']); 
					if (is_object($vulndb)):
					foreach($vulndb->plugin->vulnerabilities as $v):

					if (version_compare($plugin['Version'], $v->fixed_in, ">=")) { 
						$color = 'green';
					} else { 
						$color = 'red'; 
					} 	
				?>
					<strong style="color:<?php echo $color; ?>"><?php echo $v->title; ?> <small class="fixed_in">(fixed in <?php echo $v->fixed_in; ?>)</small></strong>
					<br>
					<?php if (isset($v->url)): foreach($v->url as $url): ?>
						<a target="_blank" href="<?php echo $url; ?>"><?php echo $url; ?></a><br>
					<?php endforeach; else: ?>
						<small><?php _e('No external information found about this vulnerabilty.', UMBRELLA__TEXTDOMAIN ); ?></small>
					<?php endif; ?>
					<br>
				<?php 
					endforeach; endif;
				endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<h3><?php _e('Theme Vulnerabilities', UMBRELLA__TEXTDOMAIN); ?></h3>
<p>
</p>
<table class="wp-list-table widefat plugins">
	<thead>
		<tr>
			<th><?php _e('Theme Name', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Theme Version', UMBRELLA__TEXTDOMAIN); ?></th>
			<th style="width:60%;"><?php _e('Vulnerabilities', UMBRELLA__TEXTDOMAIN); ?></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th><?php _e('Theme Name', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Theme Version', UMBRELLA__TEXTDOMAIN); ?></th>
			<th><?php _e('Vulnerabilities', UMBRELLA__TEXTDOMAIN); ?></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
		<?php 
			foreach($themes as $theme): 
				
			if (!isset($plugin['vulndb']['response']))
				continue;
		?>
		<tr>
			<td>
				<strong><?php echo esc_attr($theme['Name']); ?></strong><br>
				<em>by <?php echo esc_attr($theme['Author']); ?></em>
			</td>
			<td><?php echo esc_attr($theme['Version']); ?></td>
			<td>
				<?php
				if ($theme['vulndb']['response']['code'] == '404'): 
					_e('No vulnerabilities found.', UMBRELLA__TEXTDOMAIN );
				elseif ($theme['vulndb']['response']['code'] == '501'): 
					_e('Couldn\'t connect. Please reload this page.', UMBRELLA__TEXTDOMAIN );
				else: 
					$vulndb = json_decode($theme['vulndb']['body']); 

					if (is_object($vulndb)):
					foreach($vulndb->theme->vulnerabilities as $v):

					if ($v->fixed_in <= $theme['Version'])
						$color = 'green';
					else
						$color = 'red';
				?>
					<strong style="color:<?php echo $color; ?>"><?php echo $v->title; ?> <small class="fixed_in">(fixed in <?php echo $v->fixed_in; ?>)</small></strong><br>
					<?php if (isset($v->url)): foreach($v->url as $url): ?>
						<a target="_blank" href="<?php echo $url; ?>"><?php echo $url; ?></a><br>
					<?php endforeach; else: ?>
						<small><?php _e('No external information found about this vulnerabilty.', UMBRELLA__TEXTDOMAIN ); ?></small>
					<?php endif; ?>
				<?php 
					endforeach;
					endif;
				endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php Umbrella\Controller::footer(); ?>