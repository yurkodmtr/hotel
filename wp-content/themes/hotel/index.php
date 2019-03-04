<html>
<head>
    <title>Home</title>

    <script>
        window.urlAjax = 'https://<?php echo $_SERVER['HTTP_HOST'] ?>/wp-admin/admin-ajax.php';
        window.baseUrl = '<?php bloginfo('template_url');?>';
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <!-- angular libs -->
    <script src="<?php bloginfo('template_url');?>/app/libs/angular.min.js"></script>
    <script src="<?php bloginfo('template_url');?>/app/libs/angular-datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/app/libs/angular-datepicker.css">

    <script src="<?php bloginfo('template_url');?>/app/libs/angular-sanitize.js"></script>

    <!-- app -->
    <script src="<?php bloginfo('template_url');?>/app/app.js?v=<?php echo time(); ?>"></script>

</head>
<body ng-app="myApp">

    <div ng-controller="welcomeController">
        <div class="loader" ng-if="loader">loading...</div>
        <form>
            <div class="row">
                <div class="title">Страна</div>
                <input type="text" disabled="true" value="Словения">
            </div>

            <div class="row">
                <div class="title">Город/курорт</div>
                <select class="_city" ng-model="currentCity" ng-change="changeSelectCity()">
                    <option ng-repeat="option in cityList" value="{{option.id}}">{{option.name}}</option>             
                </select>
            </div>

            <div class="row">
                <div class="title">Название отеля</div>
                <select class="_hotel_name">
                    <option ng-repeat="option in hotelsByCity" value="{{option.id}}">{{option.name}}</option>
                </select>
            </div>

            <div class="row">
                <div class="title">Категория отеля</div>
                <select class="_hotel_category">
                    <option>3*</option>
                    <option>4*</option>
                    <option>5*</option>
                </select>
            </div>
            <div class="row">
                <div class="title">Дата заезда</div>
                <input type="date" class="_check_in_date" ng-model="checkInDate" ng-change="nigtsCountCalc(checkInDate,checkOutDate)">
            </div>
            <div class="row">
                <div class="title">Дата выезда</div>
                <input type="date" class="_check_out_date" ng-model="checkOutDate" ng-change="nigtsCountCalc(checkInDate,checkOutDate)">
            </div>
            <div class="row">
                <div class="title">Кол-во ночей</div>
                <select class="_nights_count" ng-model="nigtsCount" ng-change="nigtsCountDaysSelect()">
                    <option ng-repeat="option in nigtsCountList" value="{{option}}">{{option}}</option>             
                </select>
            </div>
            <div class="row">
                <div class="title">Взрослые</div>
                <select class="_adults" ng-model="adults">
                    <option ng-repeat="option in adultsList" value="{{option}}">{{option}}</option>             
                </select>
            </div>
            <div class="row">
                <div class="title">Дети</div>
                <select class="_children" ng-model="children" ng-change="childrenSelect()">
                    <option ng-repeat="option in childrenList" value="{{option}}">{{option}}</option>             
                </select>
            </div>
            <div class="children_age row">
                <div class="title">Возраст</div>
                <div class="row" ng-repeat="item in childrenAgeArray">
                    <select>
                        <?php for ($i=0;$i<=18;$i++) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor;?>
                    </select>
                </div>
            </div>
            <div class="row">
                <button ng-click="searchHotels()">Искать</button>
            </div>
        </form>

        найден предложений - {{countOfOffers}}
        <div class="item__list">
            <div class="item" ng-repeat="item in searchResult['hotelOffers']" style="padding:15px;border:1px solid grey;">
                <div class="title">{{item['hotel']['name']}} - {{getHotelCategoryName(item['hotel']['hotelCategory']['id'])}}*</div>
                <div>
                    <div class="left__side" style="display:inline-block;width:45%;vertical-align:top;">
                        <img ng-src="{{getMainImage(item['hotel']['image'])}}">
                        <div class="descr">
                            <div class="descr__item" ng-repeat="descr in item['hotel']['description']">
                                <div ng-if="descr['description'] !== ''">
                                    <div ng-bind-html="descr['description']"></div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="right__side" style="display:inline-block;width:45%;verical-align:top;">
                        <table style="border:1px solid black;">
                            <tr>
                                <td>номер</td>
                                <td>питание</td>
                                <td>условия отмены</td>
                            </tr>
                            <tr ng-repeat="room in item['hotel']['room']" ng-if="isObject(room)">
                                <td>{{room['name']}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr ng-if="!isObject(room)" >
                                <td>{{item['hotel']['room']['name']}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    


    






</body>
</html>