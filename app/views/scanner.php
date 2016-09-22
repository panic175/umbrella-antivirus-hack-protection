<div id="scanner" ng-controller="Scanner">
	<h2>Scanner</h2>

	<a ng-if="logs.length==0" href="#" class="button button-primary" ng-click="InitScanner()">Start scan</a>
	{{ logs[logs.length - 1].message }}
	<div ng-if="logs.length>0">
		<hr>
		<a href="#" class="button" ng-if="!showFullLog" ng-click="toggleLog()"> + Show full scan log</a>
		<a href="#" class="button" ng-if="showFullLog" ng-click="toggleLog()"> - Hide full scan log</a>
		<a href="#" class="button button-primary" ng-click="InitScanner()">Perform a new scan</a>
		<hr>
	</div>
	<table ng-if="logs.length!=0 && showFullLog" class="wp-list-table widefat striped">
		<thead>
			<tr>
				<td style="width: 100px;">Time</td>
				<td>Logmessage</td>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="row in logs">
				<td style="width: 100px;">{{row.timestamp | date:'HH:mm:ss' }}</td>
				<td>{{row.message}}</td>
			</tr>
		</tbody>
	</table>
</div>