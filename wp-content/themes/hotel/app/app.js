var myApp = angular.module('myApp',['720kb.datepicker','ngSanitize']);

myApp.controller("welcomeController", function ($scope,$http) {
    $scope.searchResult;

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
        $scope.loader = true;
        var cityId = $scope.currentCity;
        var hotelId = [];
        if ($('._hotel_name').val() !== '') {
            hotelId[0] = $('._hotel_name').val();
        } 
        var hotelCategory;
        var checkInDate = $scope.checkInDate;
        checkInDate = checkInDate.toISOString().slice(0,10);
        var countOfNigts = $scope.nigtsCount;
        var adultsCount = $scope.adults;
        var childrenCounts = $scope.children;
        var childrenAges = [];
        $('.children_age select').each(function(){
            var val = $(this).val();
            childrenAges.push(val);
        });

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
                $scope.loader = false;
                $scope.searchResult = data;
                console.log($scope.searchResult);
                parseSearch();
            },
            error: function(data) {
                $scope.loader = false;
            }
        });
    }

    $scope.countOfOffers = 0;
    var parseSearch = function(){
        $scope.countOfOffers = Object.keys($scope.searchResult['hotelOffers']).length;

        $scope.$apply();        
    }

    $scope.getMainImage = function(data){
        var res = baseUrl + '/images/no_img.jpg';;
        if ( typeof data === 'undefined' ) {
            return res;
        }         
        $.each( data, function( key, value ) {
            if ( value['mainImage'] === true ) {
                //res = value['url'];
                res = value['url'].replace('http://test.bestoftravel.cz:8080','http://booking.realobs.com');
            }
        });
        return res;
    }

    $scope.getHotelCategoryName = function(id){
        switch (id) {
            case 1:
                return '1';
                break;
            case 2:
                return '2';
                break;
            case 3:
                return '3';
                break;
            case 4:
                return '4';
                break;
            case 5:
                return '5';
                break;
            case 6:
                return 'Пансионат';
                break;
            case 7:
                return 'Апартаменты';
                break;
            case 8:
                return 'Вилла';
                break;
            case 9:
                return 'Санаторий';
                break;
            case 10:
                return 'Бунгало';
                break;
            case 11:
                return 'Bed and breakfast';
                break;            
            default:
                return 'no category';
        }
    }

    $scope.isObject = function (value) {
        return typeof value === 'object';
    };

});
