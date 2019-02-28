var myApp = angular.module('myApp',[]);

myApp.controller("welcomeController", function ($scope,$http) {

    $scope.currentCity;
    $scope.hotelsByCity;
    $scope.cityList = [
        {
            id: '118593', 
            name: 'все города'
        }
    ];

    $scope.initCitySelect = function(){
        $.ajax({
            url: urlAjax,
            type: 'POST',
            dataType: 'json',
            data: {
                action:'getAllCities'
            },
            success: function(data) {
                $scope.cityList = JSON.parse(data);
                $scope.cityList.unshift({id: '118593',name: 'все города'});
                $scope.$apply();
            },
            error: function(data) {
                
            }
        });
    }
    $scope.initCitySelect();

    $scope.changeSelectCity = function() {
        $.ajax({
            url: urlAjax,
            type: 'POST',
            dataType: 'json',
            data: {
                action:'changeSelectCity',
                id: $scope.currentCity
            },
            success: function(data) {
                if ( typeof data.hotel !== 'undefined') {
                    $scope.hotelsByCity = data.hotel;                  
                } else {
                    $scope.hotelsByCity = [
                        {
                          id: '', 
                          name: 'нет отелей'
                        }
                    ];
                }
                $scope.$apply();
            },
            error: function(data) {
                
            }
        });        
    };

});
