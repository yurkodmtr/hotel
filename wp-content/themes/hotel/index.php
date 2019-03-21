<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <script>
        window.urlAjax = 'http://<?php echo $_SERVER['HTTP_HOST'] ?>/wp-admin/admin-ajax.php';
        window.baseUrl = '<?php bloginfo('template_url');?>';
    </script>

    <?php wp_head(); ?>


</head>

<body ng-app="myApp">


<?php include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views\pop__mailchimp.php'); ?>



<div class="wrap" ng-controller="welcomeController">
    <?php include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views\search_proccess.php'); ?>
    <div class="header">
        <div class="center">
            <a href="#" class="logo">
                <img src="<?php echo get_template_directory_uri();?>/images/header_logo.png" alt="">
            </a>
            <div class="slogan">
                Туроператор по Словении
            </div>
            <div class="nav">
                <a class="contact_us _open_menu">связаться с нами</a>
                <div class="burger _open_menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="menu">
            <div class="top">
                <img src="<?php echo get_template_directory_uri();?>/images/header_logo.png">
                <div class="close">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60" enable-background="new 0 0 60 60" xml:space="preserve"> <g> <line stroke="#FFF" stroke-width="10" transform="translate(5, 5)" stroke-miterlimit="10" x1="5" y1="5" x2="50" y2="50" stroke-linecap="round"/> <line stroke="#FFF" stroke-width="10" transform="translate(5, 5)" stroke-miterlimit="10" x1="5" y1="50" x2="50" y2="5" stroke-linecap="round"/> </g> <g> <circle opacity="0" stroke-width="3" stroke="#FFF" stroke-miterlimit="10" cx="30" cy="30" r="40"/> </g> </svg>
                </div>
            </div>
            <div class="mid">
                <ul>
                    <li><a href="#">Туры и экскурсии</a></li>
                    <li><a href="#">Места и курорты Словении</a></li>
                    <li><a href="#">Авиабилеты</a></li>
                    <li><a href="#">Трансферы по Словении</a></li>
                    <li><a href="#">Блог</a></li>
                    <li><a href="#">О нас</a></li>
                </ul>
            </div>
            <div class="bottom">
                <div class="title">Свяжитесь с нами:</div>
                <div class="info">
                    <img src="<?php echo get_template_directory_uri();?>/images/mail.png">
                    info@wellco.si
                </div>
                <div class="info">
                    <img src="<?php echo get_template_directory_uri();?>/images/phone.png">
                    +386(69)656 886
                </div>
                <div class="soc">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri();?>/images/header_soc_1.png">
                    </a>
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri();?>/images/header_soc_2.png">
                    </a>
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri();?>/images/header_soc_3.png">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="welcome" style="background-image: url(<?php echo get_template_directory_uri();?>/images/welcome_bg.jpg);">
        <div class="center">
            <form class="search_form clearfix">
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
                <div class="item item__no_mar">
                    <div class="title">Название отеля</div>
                    <select class="_hotel_name select">
                        <option ng-repeat="option in hotelsByCity" value="{{option.id}}">{{option.name}}</option>
                    </select>
                </div>

                <div class="item item__crop">
                    <div class="title">Дата заезда</div>
                    <datepicker class="datepick" date-set="{{inDate}}" date-format="dd-MM-yyyy">
                        <input ng-model="inDateModel" type="text" class="input" ng-change="dateChange(inDateModel,outDateModel)"/>
                    </datepicker>
                </div>
                <div class="item item__crop">
                    <div class="title">Дата выезда</div>
                    <datepicker class="datepick" date-set="{{outDate}}" date-format="dd-MM-yyyy">
                        <input ng-model="outDateModel" type="text" class="input" ng-change="dateChange(inDateModel,outDateModel)"/>
                    </datepicker>
                </div>
                <div class="item item__crop">
                    <div class="title">Кол-во ночей</div>
                    <select class="_nights_count select" ng-model="nigtsCount" ng-change="nigtsCountDaysSelect()">
                        <option ng-repeat="option in nigtsCountList" value="{{option}}">{{option}}</option>           
                    </select>
                </div>

                <div class="item item__crop">
                    <div class="title">Взрослые</div>
                    <select class="_adults select" ng-model="adults">
                        <option ng-repeat="option in adultsList" value="{{option}}">{{option}}</option>             
                    </select>
                </div>
                <div class="item item__crop">
                    <div class="title">Дети</div>
                    <select class="_children select" ng-model="children" ng-change="childrenSelect()">
                        <option ng-repeat="option in childrenList" value="{{option}}">{{option}}</option>             
                    </select>
                </div>
                <div class="children_age item item__crop">
                    <div class="title">Возраст</div>
                    <div class="item" ng-repeat="item in childrenAgeArray">
                        <select>
                            <?php for ($i=0;$i<=18;$i++) : ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                </div>

                <button ng-click="searchHotels()" class="submit">Найти лучшие цены</button>
            </form>

            
            
        </div>
    </div>

    <div class="result_block" id="result_block">

        <div class="filter">
            <div class="center">
                <div class="title">
                    Уточнить поиск
                </div>
                <div class="row">
                    <div class="row__title">
                        Категория
                    </div>                
                    <div class="label_wrap">
                        <label>
                            <input type="checkbox" ng-model="category_3" ng-click="filter('category_3')">
                            3*
                        </label>
                        <label>
                            <input type="checkbox">
                            4*
                        </label>
                        <label>
                            <input type="checkbox">
                            5*
                        </label>
                        <label>
                            <input type="checkbox">
                            Апартаменты
                        </label>
                        <label>
                            <input type="checkbox">
                            Вилла
                        </label>
                    </div>                
                </div>
                <div class="row">
                    <div class="row__title">
                        Питание
                    </div>                
                    <div class="label_wrap">
                        <label>
                            <input type="checkbox" ng-model="meal_8" ng-click="filter('meal_8')">
                            Без питания
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
                <div class="result_list__title">Найдено {{countOfOffers}} предложений</div>
                <div class="result_list__subtitle">Стоимость указана за номер на весь срок прибывания</div>
                <div class="item__list">
                    <div class="item" ng-repeat="item in checkIsArray(searchResult['hotelOffers'])">                        
                        <div class="item__title">
                            <div class="name">
                                {{item['hotel']['name']}}
                                <div ng-if="isStar(item['hotel']['hotelCategory']['id'])" class="rating rating_{{item['hotel']['hotelCategory']['id']}}">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>

                                <div ng-if="!isStar(item['hotel']['hotelCategory']['id'])" class="rating_text">
                                    - {{getHotelRatingText(item['hotel']['hotelCategory']['id'])}}
                                </div>

                            </div>                            
                            <div class="city">
                                {{getCityName(item['hotel']['address']['city']['id'])}}
                            </div>
                        </div>
                        <div class="item__wrap">
                            <div class="left_side">
                                <figure>
                                    <img ng-src="{{getMainImage(item['hotel']['image'])}}">
                                </figure>
                                <a href="#">Фото и описание отеля >>></a>
                            </div>
                            <div class="right_side">

                                <div class="room" 
                                    ng-repeat="itemRoom in checkIsArray(item['hotel']['room'])" 
                                    ng-class="$index >= 2 ? '_hide room_toggle' : ''"
                                >
                                    <div class="room__title" ng-if="checkIsShowRoom(itemRoom['id'],item['room'])">
                                        {{itemRoom['name']}}
                                    </div>     
                                    <div class="room__item" 
                                    ng-repeat="detailRoomItem in checkIsArray(item['room'])" 
                                    ng-if="detailRoomItem['roomId'] == itemRoom['id'] &&  checkIsShowDetailRoom(detailRoomItem['cancelationPolicy']) ">
                                        <div class="info">
                                            <div class="info__row">
                                                <div class="title">
                                                    Питание
                                                </div>
                                                <div class="descr">
                                                    {{getMealName(detailRoomItem['person']['meal']['id'])}}
                                                </div>
                                            </div>   
                                            <div class="info__row">
                                                <div class="title">
                                                    Условия отмены
                                                </div>
                                                <div class="descr">
                                                    <span class="penalty" ng-repeat="penaltyItem in checkIsArray(detailRoomItem['cancelationPolicy'])">
                                                        <span ng-if="penaltyItem['penalty']['totalPrice'] == '0'">     
                                                            Бесплатная отмена до 
                                                            {{cancelationPolicyDate(penaltyItem['date'])}}.
                                                        </span>
                                                        <span ng-if="penaltyItem['penalty']['totalPrice'] != '0' && $index === 0">
                                                            Штраф 
                                                            <b>{{penaltyItem['penalty']['totalPrice']}}
                                                            {{penaltyItem['penalty']['currencyCode']}}</b>
                                                            в случае отмены с
                                                            {{cancelationPolicyDate(penaltyItem['date'])}}
                                                        </span>
                                                    </span>
                                                    
                                                    <div class="tooltip" ng-if="checkIsArray(detailRoomItem['cancelationPolicy']).length > 1 ">
                                                        <div class="tooltip__title">
                                                            <img src="<?php echo get_template_directory_uri();?>/images/info.png" alt="">
                                                        </div>
                                                        <div class="tooltip__descr">
                                                            <div class="tooltip__descr__close">
                                                                <img src="<?php echo get_template_directory_uri();?>/images/pop_close.png" alt="">
                                                            </div>
                                                            <div class="tooltip__descr__item"
                                                                ng-repeat="penaltyItem in checkIsArray(detailRoomItem['cancelationPolicy'])"
                                                                ng-if="penaltyItem['penalty']['totalPrice'] != '0'"
                                                            >
                                                                Штраф 
                                                                <b>{{penaltyItem['penalty']['totalPrice']}}
                                                                {{penaltyItem['penalty']['currencyCode']}}</b>
                                                                в случае отмены с 
                                                                {{cancelationPolicyDate(penaltyItem['date'])}}
                                                            </div>                                                            
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="info__row">
                                                <div class="title">
                                                    Стоимость
                                                </div>
                                                <div class="descr">
                                                    <span class="price">
                                                        {{detailRoomItem['person']['price']['totalPrice']}}
                                                        {{detailRoomItem['person']['price']['currencyCode']}}
                                                    </span>
                                                </div>
                                            </div>                                         
                                        </div>
                                        <div class="btn">
                                            <a href="#">Забронировать</a>
                                        </div>
                                    </div>                               
                                </div>

                            </div>
                            <div class="clear"></div>
                            <div class="show_more" ng-if="checkIsArray(item['hotel']['room']).length >2">
                                <a>
                                    Другие номера
                                    <img src="<?php echo get_template_directory_uri();?>/images/show_more.png" alt="">
                                </a>
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>
            
        </div>
    </div>

    <div class="book_block">
        <div class="book_block__top">
            <div class="center">
                <div class="book_block__top__title">Бронирование</div>

                <div class="info">

                    <div class="info__title">
                        <div class="name">
                            City Hotel Ljubljana
                            <div class="rating">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                        
                        <div class="city">
                            Любляна
                        </div>
                    </div>

                    <div class="info__wrap clearfix">
                        <div class="info__left_side">
                            <div class="period">
                                Период проживания: 27.03.19 - 30.03.19 (3 ночи)
                            </div>
                            <div class="include">
                                <div class="include__title">
                                    В стоимость проживания включено:
                                </div>
                                <div class="include__descr">
                                    туристический сбор
                                    завтрак – шведский стол,
                                    wi-fi,
                                    библиотека отеля с газетами и другой литературой на разных языках,
                                    аренда велосипеда и
                                    тренажерный зал 24/7
                                </div>
                            </div>
                        </div>
                        <div class="info__right_side">
                            <div class="penalty">
                                <div class="penalty__title">
                                    Штрафные санкции при отмене бронирования!
                                </div>
                                <div class="penalty__descr">
                                    Аннуляция брони без штрафа 2 дней до заезда <br>
                                    Аннуляция брони 1 день до заезда или в день заезда: 100% штраф.
                                </div>
                            </div>
                            <div class="link">
                                <a href="#">Ознакомьтесь с условиями бронирования >>></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info_hotel">
                    <div class="item__list">
                        <div class="item">
                            <div class="title">Тип номера</div>
                            <div class="descr">
                                Double Economy room
                            </div>
                        </div>
                        <div class="item">
                            <div class="title">Питание</div>
                            <div class="descr">
                                Завтраки
                            </div>
                        </div>
                        <div class="item">
                            <div class="title">Условия отмены</div>
                            <div class="descr">
                                Бесплатная отмена до 26.08.2020
                            </div>
                        </div>
                        <div class="item">
                            <div class="title">Стоимость</div>
                            <div class="descr">
                                <span>412,24 EUR</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="book_block__bottom">
            <div class="center">
                <div class="book_block__bottom__title">Туристы</div>
                <form class="form_tourists">
                    <div class="row">
                        <div class="row__title">
                            Турист 1
                        </div>
                        <div class="row__wrapper">
                            <div class="row__wrap">
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Имя</div>
                                        <input type="text" class="input">
                                    </div>
                                </div>
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Фамилия</div>
                                        <input type="text" class="input">
                                    </div>
                                </div>
                                <div class="row__item row__item__crop">
                                    <div class="item">
                                        <div class="item__title">Дата рождения</div>
                                        <input type="text" class="input">
                                    </div>
                                </div>
                            </div>
                            <div class="row__wrap">
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Серия/номер паспорта</div>
                                        <input type="text" class="input">
                                    </div>
                                </div>
                                <div class="row__item row__item__crop">
                                    <div class="item">
                                        <div class="item__title">Срок действия паспорта</div>
                                        <input type="text" class="input">
                                    </div>
                                </div>
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Гражданство</div>
                                        <input type="text" class="input">
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="row__title">
                            Турист 2
                        </div>
                        <div class="row__wrapper">
                            <div class="row__wrap">
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Имя</div>
                                        <input type="text" class="input">
                                    </div>
                                </div>
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Фамилия</div>
                                        <input type="text" class="input">
                                    </div>
                                </div>
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Дата рождения</div>
                                        <input type="text" class="input">
                                    </div>
                                </div>
                            </div>
                            <div class="row__wrap">
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Серия/номер паспорта</div>
                                        <input type="text" class="input">
                                    </div>
                                </div>
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Срок действия паспорта</div>
                                        <input type="text" class="input">
                                    </div>
                                </div>
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Гражданство</div>
                                        <input type="text" class="input">
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </form>

                <div class="book_block__bottom__btns clearfix">
                    <a href="#" class="back">
                        <img src="<?php echo get_template_directory_uri();?>/images/book_back.png" alt="">
                        Вернуться
                    </a>
                    <a class="submit">                        
                        Далее
                        <img src="<?php echo get_template_directory_uri();?>/images/book_next.png" alt="">
                    </a>
                </div> 

            </div>
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
                <form class="mailchimp">
                    <input type="email" placeholder="Ваш E-mail" class="input">
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