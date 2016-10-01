UmbrellaAntivirus.controller('SecurityChecks', ['$scope', function($scope) {
	$scope.securitystatus = {
		'class': 'red',
		'percent': 0,
		'total_checks': 0,
		'passed_checks': 0
	};

	$scope.securitylist = [];

	$scope.InitSecurityChecks = function() {
		$scope.refreshSecurityStatus();
		$scope.refreshSecurityList();
	}

	$scope.refreshSecurityStatus = function() {
	    jQuery.post(ajaxurl, {'action': 'get_security_status', 'security': window.umbrella_ajax_nonce }, function(response) {
			$scope.$apply(function () {
				$scope.securitystatus = response;
			});
	    });
	}

	$scope.refreshSecurityList = function() {
	    jQuery.post(ajaxurl, {'action': 'get_security_list', 'security': window.umbrella_ajax_nonce }, function(response) {
			$scope.$apply(function () {
				$scope.securitylist = response;
			});
	    });
	}
}]);