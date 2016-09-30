UmbrellaAntivirus.controller('Scanner', ['$scope', '$timeout', function($scope,$timeout) {
  $scope.showFullLog = false;
  $scope.scannerCompleted = false;
  $scope.scannerRunning = false;
  $scope.results = [];
  
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
    jQuery.post(ajaxurl, {'action': 'init_scanner'}, function(response) {
      $scope.$apply(function () {
        $scope.steps = response.steps;
        $scope.writeLog( response.log );
        $scope.continueScanner();
      });
    });

  }

  $scope.toggleLog = function() {
    $scope.showFullLog = ! $scope.showFullLog;
  }

  $scope.getResults = function() {
    jQuery.post(ajaxurl, {'action': 'scanner_results' }, function(response) {
      $scope.$apply(function () {
        $scope.results = response.results;
        $scope.scannerCompleted = true;
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
        $scope.getResults();
      });
    }
  };

  $scope.perform = function( step ) {
    /* Perform selected scan */
    jQuery.post(ajaxurl, {'action': step.action }, function(response) {
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

  $scope.writeLog = function( message ) {
    $scope.logs.push({ 'timestamp': new Date(), 'message': message});
  }

  $scope.writeLogs = function( messages ) {
    angular.forEach(messages, function (message, index) {
      $scope.logs.push({ 'timestamp': new Date(), 'message': message});
    });
  }

}]);