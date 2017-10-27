(function () {

    var injectParams = [];

    var locationsFactory = function () {
            var factory = {};

            var locations = [
                {subdivision: 'JPMChase', address: '10420 Highland Manor Dr', city: 'Tampa', state: 'FL', zip: '32510'},
                {subdivision: 'Home', address: '2969 Meadowood Dr', city: 'New Port Richey', state: 'FL', zip: '34655' }
            ];

        //Add factory code here

        factory.getLocations = function () {
            return locations;
        };



        factory.insertLocation = function (address) {

            var addString = address.address + ', ' + address.city + ', ' + address.state;
            
            

            
            
            locations.push({subdivision: address.subdivision, address: address.address, city: address.city, state: address.state, zip: address.zip});
        };


        function getLatLng(addString) {
            var local = {};
            geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'address': addString }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    local = { lat: results[0].geometry.location.lat(), lng: results[0].geometry.location.lng() };
                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
            
        };
        

        return factory;
    };

    locationsFactory.$inject = injectParams;

    angular.module('myApp').factory('locationsFactory', locationsFactory);

}());