var UmbrellaAntivirus = angular.module('UmbrellaAntivirus', ['ngSanitize']);

UmbrellaAntivirus.filter('unsafe', function($sce) {
    return function(val) {
        return $sce.trustAsHtml(val);
    };
});