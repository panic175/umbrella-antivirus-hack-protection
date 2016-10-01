<div id="dashboard" ng-controller="Dashboard" ng-init="InitDashboard()">
<h2>Umbrella Antivirus &amp; Hack Protection</h2>
<div class="stuffbox">
	<div class="inside">
		<?php _e( 'This plugin does nothing by default, and that\'s because we want you to know whats happening behind the scenes. With that said, please choose wich modules and settings you want to use with Umbrella. Even if nothing is loaded by default, we recommend you to activate them all for best protection.', 'umbrella-antivirus-hack-protection' ); ?>
	</div>
</div>
<h2>Security settings</h2>
<table class="wp-list-table widefat plugins">
	<thead>
		<td class="manage-column column-cb check-column"></td>
		<th>Module</th>
		<th>Description</th>
	</thead>
	<tbody id="the-list">
		<tr ng-if="modules.length==0">
			<td colspan="3" style="text-align:center">
				<i class="fa fa-spinner fa-spin"></i>
			</td>
		</tr>

		<tr ng-if="modules.length>0" ng-repeat="module in modules" ng-class="module.status">
			<th class="manage-column column-cb check-column" style=""></th>
			<td>
				<strong>{{ module.name }}</strong><br>
				<div class="row-actions visible">
					<a href="javascript:void(0)" ng-click="deactivateModule(module.slug)" class="edit" ng-if="module.status=='active'">Deactivate</a>
					<a href="javascript:void(0)" ng-click="activateModule(module.slug)" class="edit" ng-if="module.status=='inactive'">Activate</a>
				</div>
			</td>
			<td>
				{{ module.description }}
			</td>
		</tr>
	</tbody>
	<tfoot>
		<td class="manage-column column-cb check-column"></td>
		<td>Module</td>
		<td>Description</td>
	</tfoot>
</table>
</div>
