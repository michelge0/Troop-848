
var myApp = angular.module('blogPage', []);

myApp.controller('testCtrl', ['$scope', function($scope) {
	$scope.text = "Hello, World.";
	$scope.penis = "PENIS";
}]);

myApp.controller('hm', ['$scope', function($scope) {
	$scope.test = "This is odd.";
}]);
