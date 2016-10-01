UmbrellaAntivirus.controller('Dashboard', ['$scope', function($scope) {

  $scope.modules = [];
  $scope.securitystatus = {
    'class': 'red',
    'percent': 0,
    'total_checks': 0,
    'passed_checks': 0
  };

  $scope.InitDashboard = function() {
    $scope.refreshSecurityStatus();
    $scope.refreshModules();
  }

  $scope.refreshSecurityStatus = function() {
    /* Download modules data */
    jQuery.post(ajaxurl, {'action': 'get_security_status', 'security': window.umbrella_ajax_nonce }, function(response) {
      $scope.$apply(function () {
        $scope.securitystatus = response;
      });
    });
  }

  $scope.refreshModules = function() {
    /* Download modules data */
    jQuery.post(ajaxurl, {'action': 'list_modules', 'security': window.umbrella_ajax_nonce }, function(response) {
      $scope.$apply(function () {
        $scope.modules = response;
      });
    });
  }

  $scope.activateModule = function( module_slug ) {
    jQuery.post(ajaxurl, {'action': 'activate_module', 'slug': module_slug, 'security': window.umbrella_ajax_nonce }, function(response) {
      $scope.refreshModules();
      $scope.refreshSecurityStatus();
    });
  }

  $scope.deactivateModule = function( module_slug ) {
    jQuery.post(ajaxurl, {'action': 'deactivate_module', 'slug': module_slug, 'security': window.umbrella_ajax_nonce }, function(response) {
      $scope.refreshModules();
      $scope.refreshSecurityStatus();
    });
  }

}]);