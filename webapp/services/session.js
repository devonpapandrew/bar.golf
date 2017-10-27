/**
 * Created by devonpapandrew on 10/26/17.
 */
/**
 This factory takes care of login/out and session management
 */
angular.module('barGolf')// Factory created for session management
    .factory('SessionService', function(){
        return{
            get: function(key){
                return sessionStorage.getItem(key);
            },
            set: function(key, val){
                if(typeof val != 'undefined'){
                    return sessionStorage.setItem(key, val);
                }
            },
            unset: function(key){
                return sessionStorage.removeItem(key);
            }
        };
    });