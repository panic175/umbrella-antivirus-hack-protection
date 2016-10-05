UmbrellaAntivirus.controller('Scanner', ['$scope', '$timeout', function($scope,$timeout) {
  $scope.showFullLog = false;
  $scope.showIgnored = false;
  $scope.scannerCompleted = false;
  $scope.scannerRunning = false;
  $scope.results = [];

  $scope.compare_file_html = false;
  $scope.displayFileComparison = false;
  
  $scope.refreshScannerVariables = function() {
    $scope.steps = [];
    $scope.steps_index = 0;
    $scope.logs = [];
    $scope.results = [];
    $scope.scannerCompleted = false;
  }

  $scope.refreshScannerVariables();

  $scope.InitScanner = function() {
    $scope.scannerRunning = true;
    $scope.refreshScannerVariables();
    $scope.writeLog('Preparing...');

    /* Download plugins data */
    jQuery.post(ajaxurl, { 'action': 'init_scanner', 'security': window.umbrella_ajax_nonce }, function(response) {
      $scope.$apply(function () {
        $scope.steps = response.steps;
        $scope.writeLog( response.log );
        $scope.continueScanner();
      });
    });

  }

  $scope.toggleShowIgnored = function() {
    $scope.showIgnored = !$scope.showIgnored;
    $scope.getResults();
  }

  $scope.toggleLog = function() {
    $scope.showFullLog = ! $scope.showFullLog;
  }

  $scope.getResults = function() {
    return results;
  }

  $scope.getResults = function() {
    jQuery.post(ajaxurl, {'action': 'scanner_results', 'security': window.umbrella_ajax_nonce }, function(response) {
      
      var results = [];
      angular.forEach(response.results, function(result) {
        if (result.ignored == false || $scope.showIgnored == true) { 
          this.push(result);
        }
      }, results);

      $scope.$apply(function () {
        $scope.results = results;
      });

    });
  }

  $scope.continueScanner = function() {
    if ($scope.steps_index < $scope.steps.length) {
      var step = $scope.steps[$scope.steps_index];
      $scope.steps_index = $scope.steps_index + 1;
      $scope.writeLog( step.log );
      $timeout($scope.perform( step ), 100);
    } else {
      $scope.$apply(function () {
        var diff = ((new Date() - $scope.logs[0].timestamp) / 1000);
        $scope.writeLog( "Scan completed in " + diff + " seconds." );
        $scope.scannerRunning = false;
        $scope.scannerCompleted = true;
        $scope.getResults();
      });
    }
  };

  $scope.perform = function( step ) {
    /* Perform selected scan */
    jQuery.post(ajaxurl, {'action': step.action, 'security': window.umbrella_ajax_nonce }, function(response) {
      $scope.$apply(function () {
        if ( response.status == 'success' ) {
          $scope.writeLogs( response.logs );
        } else {
          $scope.writeLog( '"' + step.action + '" failed.. Please try again later.' );
        }
      });
      $scope.continueScanner();
    });

  }

  $scope.compareFile = function( file ) {
    $scope.displayFileComparison = true;
    $scope.compare_file_html = false;
    
    jQuery.post(ajaxurl, { 'action': 'compare_file', 'file': file, 'security': window.umbrella_ajax_nonce }, function(response) {
      if (response.status == 'success') {
        $scope.$apply(function () {
          $scope.compare_file_html = response.html;
        });
      }
    });
  }

  $scope.ignoreResult = function( index, result ) {
    $scope.results.splice(index, 1);
    jQuery.post(ajaxurl, { 'action': 'ignore_result', 'file': result.file, 'error_code': result.error_code, 'security': window.umbrella_ajax_nonce }, function(response) {
      console.log(response);
    });
  }

  $scope.writeLog = function( message ) {
    $scope.logs.push({ 'timestamp': new Date(), 'message': message});
  }

  $scope.writeLogs = function( messages ) {
    angular.forEach(messages, function (message, index) {
      $scope.logs.push({ 'timestamp': new Date(), 'message': message});
    });
  }

}]);