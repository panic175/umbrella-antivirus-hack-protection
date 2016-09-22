UmbrellaAntivirus.controller('Scanner', ['$scope', function($scope) {
  $scope.showFullLog = false;
  
  $scope.refreshScannerVariables = function() {
    $scope.steps = [];
    $scope.steps_index = 0;
    $scope.logs = [];
    $scope.results = [];
  }

  $scope.refreshScannerVariables();

  $scope.InitScanner = function() {

    $scope.refreshScannerVariables();
    $scope.writeLog('Preparing...');

    /* Download plugins data */
    jQuery.post(ajaxurl, {'action': 'init_scanner'}, function(response) {
      $scope.$apply(function () {
        $scope.steps = response.steps;
        $scope.writeLog('Scan started.');
        $scope.continueScanner();
      });
    });

  }

  $scope.toggleLog = function() {
    $scope.showFullLog = ! $scope.showFullLog;
  }

  $scope.continueScanner = function() {
    if ($scope.steps_index < $scope.steps.length) {
      var step = $scope.steps[$scope.steps_index];
      $scope.steps_index = $scope.steps_index + 1;
      $scope.perform( step );
    } else {
      $scope.$apply(function () {
        var diff = ((new Date() - $scope.logs[0].timestamp) / 1000);
        $scope.writeLog( "Scan completed in " + diff + " seconds." );
      });
    }
  };

  $scope.perform = function( step ) {
    $scope.writeLog( step.log );

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