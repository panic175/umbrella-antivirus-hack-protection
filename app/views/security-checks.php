<div id="dashboard" ng-controller="SecurityChecks" ng-init="InitSecurityChecks()">
<h2>Security Checks</h2>
<div class="stuffbox">
	<h3>Security Status</h3>
	<div class="inside">
		<div id="security_status_container" ng-class="securitystatus.class">
			<div id="security_status">
				<div id="security_status_bar" style="width: {{securitystatus.percent}}%"></div>
			</div>
		</div>
		{{securitystatus.passed_checks}}/{{securitystatus.total_checks}} checks passed with a total of {{securitystatus.passed_points}}/{{securitystatus.total_points}} security points.
	</div>
</div>
<h2>Details</h2>
<table class="wp-list-table widefat striped">
	<thead>
		<th style="width: 50px;text-align:center">Status</th>
		<th style="width: 100px;text-align:center">Security Points</th>
		<th>Description</th>
	</thead>
	<tbody>
		<tr ng-repeat="check in securitylist">
			<td style="text-align: center">
				<span ng-if="check.passed" class="status passed"><i class="fa fa-check" aria-hidden="true"></i></span>
				<span ng-if="!check.passed" class="status failed"><i class="fa fa-times" aria-hidden="true"></i></span>
			</td>
			<td style="text-align:center">{{check.weight}}</td>
			<td>{{check.description}}</td>
		</tr>
	</tbody>
	<tfoot>
		<td style="text-align:center">Status</td>
		<td>Security Points</td>
		<td>Description</td>
	</tfoot>
</table>
</div>
