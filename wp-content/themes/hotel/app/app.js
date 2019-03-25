var myApp = angular.module('myApp',['720kb.datepicker','ngSanitize']);


myApp.controller("welcomeController", function ($scope,$http) {

    $scope.inDateModel;
    $scope.inDate = new Date().toString();
    $scope.outDateModel;
    $scope.outDate = new Date();
    $scope.outDate.setDate($scope.outDate.getDate() + 1);
    $scope.outDate = $scope.outDate.toString();   

    $scope.mealStatic; 

    $scope.searchResultStatic;
    $scope.searchResult;

    $scope.loader = false;
    $scope.currentCity = '118593';
    $scope.hotelsByCity;
    $scope.cityList;

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
    
    $scope.dateChange = function(first,second){
        if ( first === undefined || second === undefined ) {
            return false;
        }

        var date2 = first.split("-");
        date2 = new Date(date2[2], date2[1] - 1, date2[0]);

        var date1 = second.split("-");
        date1 = new Date(date1[2], date1[1] - 1, date1[0]);

        var timeDiff = date1.getTime() - date2.getTime();
        $scope.nigtsCount = Math.ceil(timeDiff / (1000 * 3600 * 24)).toString();
    }

    $scope.nigtsCountDaysSelect = function(){
        $('._nights_count').removeClass('error');
        var date = $scope.inDateModel.split("-");
        date = new Date(date[2], date[1] - 1, date[0]);

        var time = date.getTime() + $scope.nigtsCount*((1000 * 3600 * 24));
        $scope.outDate = new Date(time).toString();
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

    $scope.initMealStatic = function(){
        $.ajax({
            url: urlAjax,
            type: 'POST',
            dataType: 'json',
            data: {
                action:'getMealStatic'
            },
            success: function(data) {
                $scope.mealStatic = JSON.parse(data);
                $scope.mealStatic = $scope.mealStatic['meal'];
                $scope.$apply();
            },
            error: function(data) {
                
            }
        });
    }
    $scope.initMealStatic();

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
                $scope.$apply();

            },
            error: function(data) {
                $scope.$apply();
            }
        });        
    };

    $scope.searchHotels = function(){

        if ($scope.nigtsCount <=0 ) {
            $('._nights_count').addClass('error');
            return false;
        }
        $('._nights_count').removeClass('error');


        $scope.loader = true;
        var cityId = $scope.currentCity;
        var hotelId = [];
        if ($('._hotel_name').val() !== '') {
            hotelId[0] = $('._hotel_name').val();
        } 
        var hotelCategory;
        var checkInDate = $scope.inDateModel;

        var checkInDate = $scope.inDateModel.split("-");
        checkInDate = checkInDate[2] + '-' + checkInDate[1] + '-' + checkInDate[0];

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
                console.log(data);
                $scope.loader = false;
                $scope.searchResultStatic = Object.assign({}, data);
                $scope.searchResult = data;
                if ( !$.isEmptyObject(data) ) {
                    parseSearch();
                    $('.result_block').show();
                    var scrollTo = $('#result_block').offset().top;
                    $('html, body').animate({
                        scrollTop: scrollTo,
                    }, 1000);
                } else {
                    $scope.loader = false;
                    $scope.$apply(); 
                    $('.result_block').show();
                    var scrollTo = $('#result_block').offset().top;
                    $('html, body').animate({
                        scrollTop: scrollTo,
                    }, 1000);
                }
                
            },
            error: function(data) {
                $scope.loader = false;
            }
        });
    }

    $scope.countOfOffers = 0;
    var parseSearch = function(){
        console.log('---');
        console.log($scope.searchResult['hotelOffers']);
        console.log(Object.keys($scope.checkIsArray($scope.searchResult['hotelOffers'])).length);
        console.log('---');
        $scope.countOfOffers = Object.keys($scope.checkIsArray($scope.searchResult['hotelOffers'])).length;
        $scope.$apply();        
    }

    $scope.getCityName = function(id) {
        var res = '';
        $.each( $scope.cityList, function( key, value ) {
            if ( value['id'] == id ) {
                res = value['name'];                
            }
        });
        if (res === '') {
            res = 'неизвестный город';
        }
        return res;
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

    $scope.isStar = function(id){
        if ( id >=1 && id <=5 ) {
            return true;
        }
        return false;
    }

    $scope.getHotelRatingText = function(id) {
        switch (id) {
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

    $scope.getMealName = function(id){
        var res = '';
        $.each( $scope.mealStatic, function( key, value ) {
            if ( value['id'] === id ) {
                res = value['names']['ru'];           
            }
        });
        return res;
    }

    $scope.cancelationPolicyDate = function(data){
        var dateString = data;
        var year = dateString.substring(0,4);
        var month = dateString.substring(5,7);
        var day = dateString.substring(8,10);

        return day + '.' + month + '.' + year;
    }

    $scope.checkIsArray = function(data) {
        if ( data === undefined ) {
            return false;
        }
        if (data[0] === undefined) {
            var res = [];
            res[0] = data;
            return res;
        }
        return data;
    }




    $scope.getActualHotelRooms = function(hotelrooms,rooms) {
        var hotelRooms = $scope.checkIsArray(hotelrooms);
        var rooms = $scope.checkIsArray(rooms);
        var arr = {};

        var index = 0;
        $.each( hotelRooms, function( key, value ) {
            $.each( rooms, function( keyy, valuee ) {
                if (value['id'] == valuee['roomId']) {
                    arr[index] = value;
                    index++;
                }
            });            
        });

        return arr;
    }

    $scope.checkIsShowRoom = function(itemRoomId,offerItem){
        var res = false;
        $.each( $scope.checkIsArray(offerItem), function( key, value ) {
            if (value['roomId'] == itemRoomId) {
                res = true;
            }
        });
        return res;
    }

    $scope.checkIsShowRoomTitle = function(id,rooms){
        var res = true;
        var index = 1;
        $.each( rooms, function( key, value ) {

            if ( id ==  value['roomId'] && value['cancelationPolicy'] === undefined) {
                res = false;
            }
        });
        return res;
    }

    $scope.checkIsShowDetailRoom = function(data) { 
        if (data === undefined) {
            return false;
        }
        return true;
    }    


    $scope.filtered = false;
    $scope.filter = function(ev,id){

        var staticData = $scope.checkIsArray($scope.searchResultStatic['hotelOffers']);
        var filteredData = {};

        var categoryIdList = [];        
        if ($scope.category_3 === true) {
            categoryIdList.push(3);
        }
        if ($scope.category_4 === true) {
            categoryIdList.push(4);
        }
        if ($scope.category_5 === true) {
            categoryIdList.push(5);
        }
        if ($scope.category_7 === true) {
            categoryIdList.push(7);
        }
        if ($scope.category_8 === true) {
            categoryIdList.push(8);
        }

        var mealIdList = [];
        if ($scope.meal_8 === true) {
            mealIdList.push(8);
        }
        if ($scope.meal_1 === true) {
            mealIdList.push(1);
        }
        if ($scope.meal_3 === true) {
            mealIdList.push(3);
        }
        if ($scope.meal_5 === true) {
            mealIdList.push(5);
        }

        var categoryFunc = function() {
            var index = 0;
            $.each(staticData, function( key, value ) {
                if ( categoryIdList.includes(value['hotel']['hotelCategory']['id'])) {
                    filteredData[index] = value;
                    index++;
                }
            });
            

            if (mealIdList.length > 0) {
                mealFunc(filteredData);
                return false;
            }

            $scope.searchResult['hotelOffers'] = filteredData;
        }

        var mealFunc = function(dataToSearchIn) {

            var dataToSearch = staticData;
            if ( dataToSearchIn != undefined ) {
                dataToSearch = $scope.checkIsArray(dataToSearchIn);
            }

            $scope.filtered = true;
            var index = 0;
            $.each(dataToSearch, function( key, value ) {
                var res = [];
                if (value['room'][0] === undefined) {
                    res[0] = value['room'];
                } else {
                    res = value['room'];
                } 

                var indexx = 0;
                $.each( res, function( keyy, item ) {
                    if ( mealIdList.includes(item['person']['meal']['id'])) {
                        indexx++;
                    }
                });

                if ( indexx > 0 ) {
                    filteredData[index] = value;
                    index++;
                }
            });

            

            //todo
            var indexx = 0;
            $.each( $scope.checkIsArray(filteredData), function( key, value ) {

                var res = [];
                if (value['room'][0] === undefined) {
                    res[0] = value['room'];
                } else {
                    res = value['room'];
                }

                var roomWithId = [];
                var roomWithIdIndex = 0;
                $.each( res, function( keyy, valuee ) {   
                    if( mealIdList.includes(valuee['person']['meal']['id'])) {
                        roomWithId[roomWithIdIndex] = valuee;
                        roomWithIdIndex++;
                    }
                }); 

                if ( roomWithId.length > 0 ) {
                    filteredData[indexx]['room'] = roomWithId;
                } else {
                    delete filteredData[indexx];
                }
                
                indexx++;
            });  


            $scope.searchResult['hotelOffers'] = filteredData;  
        }

        if (categoryIdList.length > 0) {
            categoryFunc();
        }

        if (mealIdList.length > 0 && categoryIdList.length < 1) {
            mealFunc();
        }

        if (categoryIdList.length < 1 && mealIdList.length < 1) {
            $scope.searchResult['hotelOffers'] = staticData;
        }

        $scope.countOfOffers = Object.keys($scope.searchResult['hotelOffers']).length;

    }

});
