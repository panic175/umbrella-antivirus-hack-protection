UmbrellaAntivirus.controller('Dashboard', ['$scope', function($scope) {

  $scope.modules = [];

  $scope.InitDashboard = function() {
    $scope.refreshModules();
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
    });
  }

  $scope.deactivateModule = function( module_slug ) {
    jQuery.post(ajaxurl, {'action': 'deactivate_module', 'slug': module_slug, 'security': window.umbrella_ajax_nonce }, function(response) {
      $scope.refreshModules();
    });
  }

}]);