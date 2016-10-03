<div id="scanner" ng-controller="Scanner" ng-init="getResults()">
	<h2>Scanner</h2>
	<a ng-if="logs.length==0" href="#" class="button button-primary" ng-click="InitScanner()">Perform Scan</a>

	<i ng-if="scannerRunning" class="fa fa-spin fa-spinner"></i> {{ logs[logs.length - 1].message }}

	<div ng-if="logs.length>0">
		<hr>
		<a href="#" class="button" ng-if="!showFullLog" ng-click="toggleLog()"> + Show full scan log</a>
		<a href="#" class="button" ng-if="showFullLog" ng-click="toggleLog()"> - Hide full scan log</a>
		<a href="#" class="button button-primary" ng-click="InitScanner()" ng-disabled="scannerRunning">Perform a new scan</a>
	</div>

	<div ng-if="logs.length!=0 && showFullLog">
		<h3>Scanner Log</h3>
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

	<div ng-if="results.length==0 && scannerCompleted">
		<h3>Scanner Results</h3>
		<strong style="color:#27ae60">Scanner succeeded without any errors. No suspect files or issues were found. Good job!</strong>
	</div>
	<div ng-if="results.length!=0 && results!=false">
		<h3>Scanner Results</h3>
		<table class="wp-list-table widefat striped">
			<thead>
				<tr>
					<td style="width: 100px;">Error Code</td>
					<td style="width: 200px;">File</td>
					<td>Logmessage</td>
					<td>Actions</td>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="result in results">
					<td style="max-width: 100px;vertical-align: middle;">
						<a href="https://github.com/kjellberg/umbrella-antivirus-hack-protection/wiki/Error-codes#{{result.error_code}}" target="_blank">{{result.error_code}}</a>
					</td>
					<td style="max-width: 100px;vertical-align: middle;">{{result.file}}</td>
					<td style="vertical-align: middle;">{{result.error_message}}</td>
					<td>
						<?php foreach ( apply_filters( 'scanner-buttons', array() ) as $button ): ?>
							<?php echo  $button ; ?>
						<?php endforeach; ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<a name="file-comparision"></a>
	<div ng-if="displayFileComparison">
		<div id="compare-container">
			<h3>File comparison</h3>
			<div ng-if="compare_file_html==false">
				<i class="fa fa-spin fa-spinner"></i> Downloading original source file..
			</div>
			<div ng-if="compare_file_html" class="revisions-diff-frame">
				<div class="revisions-diff">
					<table width="100%">
						<tr>
							<td style="font-weight: bold;">Original File</td>
							<td style="font-weight: bold;">Modified File</td>
						</tr>
					</table>
					<div class="diff" ng-bind-html="compare_file_html">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
