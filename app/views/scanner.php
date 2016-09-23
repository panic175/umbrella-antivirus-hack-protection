<div id="scanner" ng-controller="Scanner">
	<h2>Scanner</h2>
	<a ng-if="logs.length==0" href="#" class="button button-primary" ng-click="InitScanner()">Start scan</a>
	{{ logs[logs.length - 1].message }}
	<div ng-if="logs.length>0">
		<hr>
		<a href="#" class="button" ng-if="!showFullLog" ng-click="toggleLog()"> + Show full scan log</a>
		<a href="#" class="button" ng-if="showFullLog" ng-click="toggleLog()"> - Hide full scan log</a>
		<a href="#" class="button button-primary" ng-click="InitScanner()" ng-disabled="scannerRunning">Perform a new scan</a>
	</div>

	<div ng-if="logs.length!=0 && showFullLog">
		<h3>Scanner log</h3>
		<table class="wp-list-table widefat striped">
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

	<div ng-if="results.length!=0">
		<h3>Scanner Results</h3>
		<table class="wp-list-table widefat striped">
			<thead>
				<tr>
					<td style="width: 100px;">Error Code</td>
					<td style="width: 200px;">File</td>
					<td>Logmessage</td>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="result in results">
					<td style="max-width: 100px;">{{result.error_code}}</td>
					<td style="max-width: 100px;">{{result.file}}</td>
					<td>{{result.error_message}}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>