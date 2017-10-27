
var app = angular.module('barGolf',['ngRoute']);

app.controller('HomeController', function($scope, $http) {
  $scope.message = 'Bar Golf';
  
   $http.get("dummy_login.php")
    .then(function (response) {$scope.user = response.data;});
   $http.get("http://bar.golf/api/index.php/everything")
    .then(function (response) {$scope.data = response.data.data;});
	
});




app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "partials/home.html"
    })
    .when("/leaderboard", {
        templateUrl : "partials/leaderboard.html"
    });
});