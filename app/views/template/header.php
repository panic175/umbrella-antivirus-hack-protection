<div id="umbrella" class="wrap" ng-app="UmbrellaAntivirus">
<h1>Umbrella Antivirus &amp; Hack protection</h1>
<div class="wp-filter">
	<ul class="filter-links">
		<?php foreach( $navigation_links as $link ): ?>
		<li>
			<a
			href="admin.php?page=<?php echo esc_attr( $link['screen'] ); ?>"
			class="<?php
				if ( isset( $_GET['page'] ) and $link['screen'] == $_GET['page']) {
					echo 'current';
				}
			?>">
				<i class="<?php echo esc_attr( $link['icon'] ); ?>"></i>
				<?php echo esc_attr( $link['title'] ); ?>
			</a>
		</li>
		<?php endforeach;?>
	</ul>
</div>