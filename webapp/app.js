
var app = angular.module('barGolf',['ngRoute','ui.bootstrap','ngProgress']);

app.controller('HomeController', function($scope, $http, SessionService, ngProgressFactory) {
  $scope.message = 'Bar Golf';

    var apiEndpoint = 'http://localhost/bar.golf/api/index.php/';

    $scope.requireLogin = function(){
        userID = window.prompt('Please enter your password.');

                if(userID) {
                    $http.get(apiEndpoint + "login/" + userID)
                        .then(function (response) {
                            if (response.data.data.id) {

                                var id = response.data.data.id;
                                var name = response.data.data.name;
                                SessionService.set("userID", id);
                                SessionService.set("username", name);

                                $scope.user = response.data.data;
                            }
                            else {
                                window.alert('Your password is incorrect. Please try again.');
                                $scope.requireLogin();
                            }
                        });
                }
                else {
                    window.alert('Please enter a password.');
                    $scope.requireLogin();
                }
    }

    var userID = SessionService.get('userID');

    if(! userID){
        $scope.requireLogin();
    }
    else {
        $scope.user = {};
        $scope.user.id = SessionService.get('userID');
        $scope.user.name = SessionService.get('username');
    }

   $scope.getEverything = function(){
       $scope.progressbar = ngProgressFactory.createInstance();
       $scope.progressbar.start();
       return $http.get(apiEndpoint + "everything")
           .then(function (response) {
               $scope.data = response.data.data;

               for(var i = 0; i < $scope.data.players.length; i++){
                   if($scope.data.players[i].id == $scope.user.id){
                       $scope.user = $scope.data.players[i];
                   }
               }
               $scope.user.specificBars = {};
               for(var j = 0; j < $scope.user.bars.length; j++){
                   var name =  $scope.user.bars[j].name;
                   $scope.user.specificBars[name] = $scope.user.bars[j];
               }

               $scope.progressbar.complete();

           });
   };
   $scope.getEverything();


    $scope.upsertPlayerAction = function (barID, actionID) {

        var playerID = SessionService.get("userID");
        $http.put(apiEndpoint + 'players/' + playerID +'/' + barID + '/' + actionID, null).then(function (response) {
            if(response.data.success == 1){
                $scope.getEverything();
            }
            else if (response.data.success == 0){
                window.alert('Unknown error you fool');
            }

        })
    }

    $scope.clearPlayerAction = function (barID) {

        var playerID = SessionService.get("userID");
        $http.delete(apiEndpoint + 'players/' + playerID +'/' + barID, null).then(function (response) {
            if(response.data.success == 1){
                $scope.getEverything();

            }
            else if (response.data.success == 0){
                window.alert('Unknown error you fool');
            }
        })
    }
    $scope.inviteUser = function () {
        var name = window.prompt("Enter the new player's name. This must be unique.");
        if(name){
            $http.post(apiEndpoint + 'players/' + name, null).then(function (response) {
                if (response.data.success == 1) {
                    window.alert(response.data.data);
                    $scope.getEverything();

                }
                else if (response.data.success == 0) {
                    window.alert(response.data.error.message);
                }
            });
        }
    }
});
