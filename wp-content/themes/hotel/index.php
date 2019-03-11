<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <script>
        window.urlAjax = 'https://<?php echo $_SERVER['HTTP_HOST'] ?>/wp-admin/admin-ajax.php';
        window.baseUrl = '<?php bloginfo('template_url');?>';
    </script>

    <?php wp_head(); ?>


</head>

<body ng-app="myApp">

<div class="search_proccess">
    <div class="search_proccess__wrap">
        <div class="center">
            <div class="title">Поиск лучших цен</div>
            <div class="search_proccess__loader">
                <img src="<?php echo get_template_directory_uri();?>/images/search_proccess__loader.png" alt="">
            </div>
        </div>
    </div>
</div>

<div class="wrap" ng-controller="welcomeController">

    <div class="header">
        <div class="center">
            <a href="#" class="logo">
                <img src="<?php echo get_template_directory_uri();?>/images/header_logo.png" alt="">
            </a>
            <div class="slogan">
                Туроператор по Словении
            </div>

        </div>
    </div>

    <div class="welcome" style="background-image: url(<?php echo get_template_directory_uri();?>/images/welcome_bg.jpg);">
        <div class="center">
            <div class="loader" ng-if="loader">loading...</div>
            <form class="search_form">
                <div class="item">
                    <div class="title">Страна</div>
                    <input type="text" disabled="true" value="Словения" class="input">
                </div>

                <div class="item">
                    <div class="title">Город/курорт</div>
                    <select class="_city select" ng-model="currentCity" ng-change="changeSelectCity()">
                        <option ng-repeat="option in cityList" value="{{option.id}}">{{option.name}}</option>             
                    </select>
                </div>

                <div class="item">
                    <div class="title">Название отеля</div>
                    <select class="_hotel_name select">
                        <option ng-repeat="option in hotelsByCity" value="{{option.id}}">{{option.name}}</option>
                    </select>
                </div>

                <div class="item">
                    <div class="title">Дата заезда</div>
                    <input type="date" class="_check_in_date input" ng-model="checkInDate" ng-change="nigtsCountCalc(checkInDate,checkOutDate)">
                </div>
                <div class="item">
                    <div class="title">Дата выезда</div>
                    <input type="date" class="_check_out_date input" ng-model="checkOutDate" ng-change="nigtsCountCalc(checkInDate,checkOutDate)">
                </div>
                <div class="item">
                    <div class="title">Кол-во ночей</div>
                    <select class="_nights_count select" ng-model="nigtsCount" ng-change="nigtsCountDaysSelect()">
                        <option ng-repeat="option in nigtsCountList" value="{{option}}">{{option}}</option>             
                    </select>
                </div>
                <div class="item">
                    <div class="title">Взрослые</div>
                    <select class="_adults select" ng-model="adults">
                        <option ng-repeat="option in adultsList" value="{{option}}">{{option}}</option>             
                    </select>
                </div>
                <div class="item">
                    <div class="title">Дети</div>
                    <select class="_children select" ng-model="children" ng-change="childrenSelect()">
                        <option ng-repeat="option in childrenList" value="{{option}}">{{option}}</option>             
                    </select>
                </div>
                <div class="children_age item">
                    <div class="title">Возраст</div>
                    <div class="item" ng-repeat="item in childrenAgeArray">
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
                                    <td>цена</td>
                                    <td>условия отмены</td>
                                </tr>
                                <tr ng-repeat="room in item['hotel']['room']" ng-if="isObject(room)">
                                    <td>{{room['name']}}</td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr ng-if="!isObject(room)" >
                                    <td>{{item['hotel']['room']['name']}}</td>
                                    <td>
                                        <table>
                                            <tr ng-repeat="meal in item['room']">
                                                <td ng-if="item['hotel']['room']['id'] === meal['roomId']">
                                                    {{getMealName(meal['person']['meal']['id'])}}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table>
                                            <tr ng-repeat="meal in item['room']">
                                                <td ng-if="item['hotel']['room']['id'] === meal['roomId']">
                                                    {{meal['person']['price']['totalPrice']}}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="result_block" style="display:none;">

        <div class="filter">
            <div class="center">
                <div class="title">
                    Уточнить поиск
                </div>
                <div class="row">
                    <div class="row__title">
                        Питание
                    </div>                
                    <div class="label_wrap">
                        <label>
                            <input type="checkbox">
                            Без питаия
                        </label>
                        <label>
                            <input type="checkbox">
                            Завтрак
                        </label>
                        <label>
                            <input type="checkbox">
                            Полупансион
                        </label>
                        <label>
                            <input type="checkbox">
                            Полный пансион
                        </label>
                    </div>                
                </div>
            </div>            
        </div>

        <div class="result_list">
            <div class="center">
                <div class="result_list__title">Найдено 29 предложений</div>
                <div class="result_list__subtitle">Стоимость указана за номер на весь срок прибывания</div>
                <div class="item__list">
                    <div class="item">
                        <div class="left_side">
                            <figure>
                                <img src="http://booking.realobs.com/booking/public/thumbnails/640/hotelImages/1/b/7/1b7fac846223b62de7639cecb3ca3472.jpg">
                            </figure>
                            <a href="#">Информация и фото отеля >>></a>
                        </div>
                        <div class="right_side">
                            <div class="top">
                                <div class="name">
                                    City Hotel Ljubljana
                                </div>
                                <div class="rating">
                                    <span></span>
                                </div>
                                <div class="city">
                                    Любляна
                                </div>
                            </div>
                            <div class="table">
                                <ul>
                                    <li>Номер</li>
                                    <li>Питание</li>
                                    <li>Условия отмены</li>
                                    <li>Стоимость</li>
                                    <li></li>
                                </ul>
                                <ul>
                                    <li>Double Economy room</li>
                                    <li>Затрак</li>
                                    <li>
                                        Бесплатная отмена до 28.02.2019
                                        <span class="info">
                                            <div class="info__title">?</div>
                                            <div class="info__descr">
                                                Бесплатная отмена до 28.02.2019
                                            </div>
                                        </span>
                                    </li>
                                    <li>153.97 EUR </li>
                                    <li>    
                                        <a href="#" class="book">Забронировать</a>
                                    </li>
                                </ul>
                                <ul>
                                    <li></li>
                                    <li>Затрак</li>
                                    <li>
                                        Бесплатная отмена до 28.02.2019
                                        <span class="info">
                                            <div class="info__title">?</div>
                                            <div class="info__descr">
                                                Бесплатная отмена до 28.02.2019
                                            </div>
                                        </span>
                                    </li>
                                    <li>153.97 EUR </li>
                                    <li>    
                                        <a href="#" class="book">Забронировать</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="book_block">
        <div class="center">

        </div>
    </div>

    <div class="featured">
        <div class="center">
            <div class="item__list clearfix">
                <div class="item">
                    <figure>
                        <img src="<?php echo get_template_directory_uri();?>/images/featured_1.png" alt="">           
                    </figure>
                    <p>
                        Термальные <br> курорты
                    </p>
                </div>
                <div class="item">
                    <figure>
                        <img src="<?php echo get_template_directory_uri();?>/images/featured_2.png" alt="">
                    </figure>
                    <p>
                        Морское <br> побережье
                    </p>
                </div>
                <div class="item">
                    <figure>
                        <img src="<?php echo get_template_directory_uri();?>/images/featured_3.png" alt="">
                    </figure>
                    <p>
                        Горнолыжные <br> курорты
                    </p>
                </div>
                <div class="item">
                    <figure>
                        <img src="<?php echo get_template_directory_uri();?>/images/featured_4.png" alt="">
                    </figure>
                    <p>
                        Альпы <br> и озера
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="footer_block">
        <div class="center">

            <div class="links">
                <div class="item__list clearfix">
                    <div class="item">
                        <div class="title">Туры и экскурсии по Словении</div>
                        <ul>
                            <li><a href="#">Экскурсионные туры</a></li>
                            <li><a href="#">Туры на озера</a></li>
                            <li><a href="#">Горнолыжные туры</a></li>
                            <li><a href="#">Лечение и оздоровительные пакеты на термальные курорты</a></li>
                            <li><a href="#">Авторские программы WellCo</a></li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="title">Курорты и места</div>
                        <ul>
                            <li><a href="#">Все термальные курорты Словении</a></li>
                            <li><a href="#">Морские курорты</a></li>
                            <li><a href="#">Горнолыжные курорты</a></li>
                            <li><a href="#">Озера Словении</a></li>
                            <li><a href="#">Пещеры Словении</a></li>
                            <li><a href="#">Города</a></li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="title">Дополнительно</div>
                        <ul>
                            <li><a href="#">Корпоративный туризм</a></li>
                            <li><a href="#">Забронировать трансфер в Словении</a></li>
                            <li><a href="#">Аренда авто в Словении</a></li>
                            <li><a href="#">Поиск авиабилетов</a></li>
                            <li><a href="#">Блог о Словении</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="find_btn">
                <a href="#">Найти авиабилеты в Словению по лучшей цене</a>
            </div>

            <div class="subscribe">
                <div class="title">
                    Подпишитесь на рассылку
                </div>
                <div class="subtitle">
                    Получайте специальные цены для подписчиков
                </div>
                <form>
                    <input type="text" placeholder="Ваш E-mail" class="input">
                    <button type="submit" class="submit">Подписаться</button>
                </form>
                <div class="notice">
                    Подписываясь вы соглашаетесь с политикой конфеденциальности
                </div>
            </div>

        </div>
       
    </div>

    <footer class="footer">
        <div class="center">
            <div class="item__list clearfix">
                <div class="item">
                    <a href="#" class="footer_logo">
                        <img src="<?php echo get_template_directory_uri();?>/images/footer_logo.png" alt="">
                    </a>
                    <div class="copy">
                        &copy; 2016 WellCo d.o.o.
                    </div>
                    <div class="link">
                        <a href="#">Договор оферты</a>
                    </div>
                </div>
                <div class="item">
                    <img src="<?php echo get_template_directory_uri();?>/images/footer_carts.png" alt="">
                </div>
                <div class="item">
                    Wellco, turizem in usluge, d.o.o <br>
                    Адрес: 1000, Ljubljana, Opekarska Cesta 15b <br>
                    Регистрационный номер: 7277857000 <br>
                    Налоговый номер: 78817366 
                </div>
                <div class="item">
                    <div class="title">Свяжитесь с нами: </div>
                    <div class="descr">
                        <span>Тел/WhatsApp/Viber: +386 69 656 886</span>
                        <span>E-mail: info@wellco.si</span>
                    </div>
                    <div class="soc">
                        <a href="#"><img src="<?php echo get_template_directory_uri();?>/images/fb.png" alt=""></a>
                        <a href="#"><img src="<?php echo get_template_directory_uri();?>/images/inst.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</div>

</body>
</html>