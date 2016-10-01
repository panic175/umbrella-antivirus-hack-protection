UmbrellaAntivirus.controller('Dashboard', ['$scope', function($scope) {

  $scope.modules = [];
  $scope.securitystatus = {};

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
    jQuery("#loader-" + module_slug).fadeIn();
    jQuery("#btns-" + module_slug).hide();
    jQuery.post(ajaxurl, {'action': 'activate_module', 'slug': module_slug, 'security': window.umbrella_ajax_nonce }, function(response) {
      jQuery("#loader-" + response).fadeOut();
      jQuery("#btns-" + response).fadeIn();
      $scope.refreshModules();
      $scope.refreshSecurityStatus();
    });
  }

  $scope.deactivateModule = function( module_slug ) {
    jQuery("#loader-" + module_slug).fadeIn();
    jQuery("#btns-" + module_slug).hide();
    jQuery.post(ajaxurl, {'action': 'deactivate_module', 'slug': module_slug, 'security': window.umbrella_ajax_nonce }, function(response) {
      jQuery("#loader-" + response).hide();
      jQuery("#btns-" + response).fadeIn();
      $scope.refreshModules();
      $scope.refreshSecurityStatus();
    });
  }

}]);