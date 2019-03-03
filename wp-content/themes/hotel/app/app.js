var myApp = angular.module('myApp',['720kb.datepicker']);

myApp.controller("welcomeController", function ($scope,$http) {

    $scope.loader = false;
    $scope.currentCity = '118593';
    $scope.hotelsByCity;
    $scope.cityList;

    $scope.checkInDate = new Date();
    $scope.checkOutDate = new Date();
    $scope.nigtsCount = '1';
    $scope.nigtsCountList = [];

    $scope.adultsList = [];
    $scope.adults = '1';

    $scope.childrenList = [0];
    $scope.children = '0';
    $scope.childrenAgeArray = [];

    for (var i = 1; i <= 100; i++) {
       $scope.nigtsCountList.push(i);
       $scope.adultsList.push(i);
       $scope.childrenList.push(i);
    }

    $scope.nigtsCountCalc = function(first,second){
        var date2 = first;
        var date1 = second;
        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        $scope.nigtsCount = Math.ceil(timeDiff / (1000 * 3600 * 24)).toString();
    }

    $scope.nigtsCountDaysSelect = function(){
        var time = $scope.checkInDate.getTime() + $scope.nigtsCount*((1000 * 3600 * 24));
        $scope.checkOutDate = new Date(time);
    }

    $scope.childrenSelect = function(){
        var childrenCount = $scope.children;
        $scope.childrenAgeArray = [];
        for (var i = 1; i <= childrenCount; i++) {
           $scope.childrenAgeArray.push(i);
        }
    }

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

    $scope.initHotelsSelect = function(){

        $.ajax({
            url: urlAjax,
            type: 'POST',
            dataType: 'json',
            data: {
                action:'changeSelectCity',
                id: '118593'
            },
            success: function(data) {
                var data = JSON.parse(data);
                $scope.hotelsByCity = data.hotel; 
                $scope.hotelsByCity.unshift({id: '',name: 'все отели'});                 
                $scope.$apply();
            },
            error: function(data) {
                
            }
        });
    }
    $scope.initHotelsSelect();

    $scope.changeSelectCity = function() {
        $scope.loader = true;
        $.ajax({
            url: urlAjax,
            type: 'POST',
            dataType: 'json',
            data: {
                action:'changeSelectCity',
                id: $scope.currentCity
            },
            success: function(data) {
                var data = JSON.parse(data);
                if ( typeof data.hotel !== 'undefined') {
                    $scope.hotelsByCity = data.hotel;   
                    $scope.hotelsByCity.unshift({id: '',name: 'все отели'});               
                } else {
                    $scope.hotelsByCity = [
                        {
                          id: '', 
                          name: 'нет отелей'
                        }
                    ];
                }
                $scope.loader = false;
                $scope.$apply();

            },
            error: function(data) {
                $scope.loader = false;
                $scope.$apply();
            }
        });        
    };

    $scope.searchHotels = function(){
        var cityId = $scope.currentCity;
        var hotelId = $('._hotel_name').val();
        var hotelCategory;
        var checkInDate = $scope.checkInDate;
        checkInDate = checkInDate.toISOString().slice(0,10);
        var countOfNigts = $scope.nigtsCount;
        var adultsCount = $scope.adults;
        var childrenCounts = $scope.children;
        var childrenAges = [];
        $('.children_age select').each(function(){
            $scope.nigtsCountList.push(i);
        })

        $.ajax({
            url: urlAjax,
            type: 'POST',
            dataType: 'json',
            data: {
                action:'searcHotels',
                cityId : cityId,
                hotelId : hotelId,
                hotelCategory : hotelCategory,
                checkInDate : checkInDate,
                countOfNigts : countOfNigts,
                adultsCount : adultsCount,
                childrenCounts : childrenCounts,
                childrenAges : childrenAges
            },
            success: function(data) {
                console.log('data1 - ', data);
            },
            error: function(data) {
                console.log('data2 - ', data);
            }
        });

    }

});
