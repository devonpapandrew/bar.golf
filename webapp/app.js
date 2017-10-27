
var app = angular.module('barGolf',['ngRoute']);

app.controller('HomeController', function($scope, $http, SessionService) {
  $scope.message = 'Bar Golf';

    var userID = SessionService.get('userID');

    if(! userID){
        userID = window.prompt('Please enter your password.');
        $http.get("http://bar.golf/api/index.php/login/" + userID)
            .then(function (response) {
                var id = response.data.data.id;
                var name = response.data.data.name;
                SessionService.set("userID", id);
                SessionService.set("username", name);

                $scope.user = response.data.data;
            });
    }
    else {
        $scope.user = {};
        $scope.user.id = SessionService.get('userID');
        $scope.user.name = SessionService.get('username');
    }

   $http.get("http://bar.golf/api/index.php/everything")
    .then(function (response) {$scope.data = response.data.data;});


    $scope.upsertPlayerAction = function (barID, actionID) {
        var playerID = SessionService.get("userID");
        $http.put('http://bar.golf/api/index.php/players/' + playerID +'/' + barID + '/' + actionID, null).then(function (response) {
            if(response.data.success == 1){
                console.log('Successfully added '+ playerID +'/' + barID + '/' + actionID);
            }
            else if (response.data.success == 0){
                window.alert('Unknown error you fool');
            }
        })
    }
	
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