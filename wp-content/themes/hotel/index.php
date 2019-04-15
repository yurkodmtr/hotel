<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <script>
        window.urlAjax = "<?php echo admin_url('admin-ajax.php'); ?>";
        window.baseUrl = '<?php bloginfo('template_url');?>';
    </script>

    <?php wp_head(); ?>


</head>

<body ng-app="myApp">


<?php include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views/pop__mailchimp.php'); ?>



<div class="wrap" ng-controller="welcomeController">
    <?php include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views/search_proccess.php'); ?>
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
                    <select class="_hotel_name select" ng-disabled="disabledHotelSelect" ng-class="disabledHotelSelect ? 'disabled' : ''">
                        <option ng-repeat="option in hotelsByCity" value="{{option.id}}">{{option.name}}</option>
                    </select>
                </div>

                <div class="item item__crop">
                    <div class="title">Дата заезда</div>
                    <datepicker class="datepick" date-set="{{inDate}}" date-format="dd-MM-yyyy" date-min-limit="{{inDateMin}}">
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
                    <div class="title">Кол-во взрослых</div>
                    <select class="_adults select" ng-model="adults">
                        <option ng-repeat="option in adultsList" value="{{option}}">{{option}}</option>             
                    </select>
                </div>

                <div class="item item__no_mar">
                    <div class="title">&nbsp;</div>
                    <button ng-click="searchHotels()" class="submit">Найти лучшие цены</button>
                </div>

                <div class="item item__crop">
                    <div class="title">Кол-во детей</div>
                    <select class="_children select" ng-model="children" ng-change="childrenSelect()">      
                        <?php for ($i=0;$i<=4;$i++) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor;?>     
                    </select>
                </div>

                <div class="children_age item item__crop" ng-repeat="item in childrenAgeArray">
                    <div class="title">Возраст детей</div>
                    <select class="select">
                        <?php for ($i=0;$i<=18;$i++) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor;?>
                    </select>
                </div>

                
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
                        Категория отеля
                    </div>                
                    <div class="label_wrap">
                        <label>
                            <input type="checkbox" ng-model="category_3" ng-click="filter('category','3')">
                            3*
                        </label>
                        <label>
                            <input type="checkbox" ng-model="category_4" ng-click="filter('category','4')">
                            4*
                        </label>
                        <label>
                            <input type="checkbox" ng-model="category_5" ng-click="filter('category','5')">
                            5*
                        </label>
                        <label>
                            <input type="checkbox" ng-model="category_7" ng-click="filter('category','7')">
                            Апартаменты
                        </label>
                        <label>
                            <input type="checkbox" ng-model="category_8" ng-click="filter('category','8')">
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
                            <input type="checkbox" ng-model="meal_8" ng-click="filter('meal','8')">
                            Без питания
                        </label>
                        <label>
                            <input type="checkbox" ng-model="meal_1" ng-click="filter('meal','1')">
                            Завтрак
                        </label>
                        <label>
                            <input type="checkbox" ng-model="meal_3" ng-click="filter('meal','3')">
                            Полупансион
                        </label>
                        <label>
                            <input type="checkbox" ng-model="meal_5" ng-click="filter('meal','5')">
                            Полный пансион
                        </label>
                    </div>                
                </div>
            </div>            
        </div>

        <div class="result_list">
            <div class="center">
                <div class="result_list__title">Найдено {{countOfOffers}} предложений</div>
                <div class="result_list__subtitle" ng-if="countOfOffers!='0'">Стоимость указана за номер на весь срок прибывания</div>
                <div class="item__list" ng-if="countOfOffers!='0'">
                    <div 
                        class="item" 
                        dir-paginate="item in checkIsArray(searchResult['hotelOffers']) | itemsPerPage: 10" 
                        current-page="currentPage"                         
                    >                        
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
                                <a data-href="http://www.google.com/{{item['hotel']['id']}}" class="_open_modal">
                                    Фото и описание отеля >>>>                                        
                                </a>
                            </div>
                            <div class="right_side">

                                <div class="room" 
                                    ng-repeat="itemRoom in checkIsArray(item['hotel']['room'])" 
                                    ng-class="$index >= 2 && filtered === false ? '_hide room_toggle' : ''"
                                    ng-if="checkIsShowRoom(itemRoom['id'],item['room'])"
                                >
                                    <div class="room__title" ng-if="checkIsShowRoomTitle(itemRoom['id'],item['room'])">
                                        <b>Тип номера:</b> {{itemRoom['name']}}
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
                                                    {{getMealName(detailRoomItem['person'])}}
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
                                                        {{getRoomPrice(detailRoomItem['person'])}}
                                                        EUR
                                                    </span>
                                                </div>
                                            </div>                                         
                                        </div>
                                        <div class="btn">
                                            <a ng-click="goToBookBlock(item,itemRoom,detailRoomItem)">Забронировать</a>
                                        </div>
                                    </div>                               
                                </div>

                            </div>
                            <div class="clear"></div>
                            <div class="show_more" ng-if="checkIsArray(item['hotel']['room']).length >2 && filtered === false">
                                <a>
                                    Другие номера
                                    <img src="<?php echo get_template_directory_uri();?>/images/show_more.png" alt="">
                                </a>
                            </div>
                        </div>
                        
                    </div>

                </div>

                <div class="pagination-controller" ng-show="countOfOffers!='0'">
                    <div class="text-center">
                        <dir-pagination-controls
                                boundary-links="true"
                                on-page-change="pageChangeHandler(newPageNumber)"
                                template-url="<?php bloginfo('template_url');?>/pagination.html"
                        >
                        </dir-pagination-controls>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="book_block" id="book_block">
        <div class="book_block__top">
            <div class="center">
                <div class="book_block__top__title">Бронирование</div>

                <div class="info">

                    <div class="info__title">
                        <div class="name">
                            {{bookInfoOffer['hotel']['name']}}
                            <div ng-if="isStar(bookInfoOffer['hotel']['hotelCategory']['id'])" class="rating rating_{{bookInfoOffer['hotel']['hotelCategory']['id']}}">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                            <div ng-if="!isStar(bookInfoOffer['hotel']['hotelCategory']['id'])" class="rating_text">
                                - {{getHotelRatingText(bookInfoOffer['hotel']['hotelCategory']['id'])}}
                            </div>
                        </div>
                        
                        <div class="city">
                            {{getCityName(bookInfoOffer['hotel']['address']['city']['id'])}}
                        </div>
                    </div>

                    <div class="info__wrap clearfix">
                        <div class="info__left_side">
                            <div class="period">
                                Период проживания: <br>
                                {{inDateModel}} - {{outDateModel}} ({{nigtsCount}} ночи)
                            </div>
                            <div class="include" ng-if="getIncludedServices(bookInfoOffer) !== false" ng-bind-html="getIncludedServices(bookInfoOffer)">
                            </div>
                        </div>
                        <div class="info__right_side">
                            <div class="penalty">
                                <div class="penalty__title">
                                    Штрафные санкции при отмене бронирования!
                                </div>
                                <div class="penalty__descr">
                                    <ul ng-repeat="penaltyItem in checkIsArray(bookInfoDetailRoom['cancelationPolicy'])">
                                        <li ng-if="penaltyItem['penalty']['totalPrice'] == '0'">     
                                            Бесплатная отмена до 
                                            {{cancelationPolicyDate(penaltyItem['date'])}}.
                                        </li>
                                        <li ng-if="penaltyItem['penalty']['totalPrice'] != '0' ">
                                            Штраф 
                                            <b>{{penaltyItem['penalty']['totalPrice']}}
                                            {{penaltyItem['penalty']['currencyCode']}}</b>
                                            в случае отмены с
                                            {{cancelationPolicyDate(penaltyItem['date'])}}
                                        </li>
                                    </ul>
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
                                {{bookInfoRoom['name']}}
                            </div>
                        </div>
                        <div class="item">
                            <div class="title">Питание</div>
                            <div class="descr">
                                {{getMealName(bookInfoDetailRoom['person'])}}
                            </div>
                        </div>
                        <div class="item">
                            <div class="title">Условия отмены</div>
                            <div class="descr">
                                <ul ng-repeat="penaltyItem in checkIsArray(bookInfoDetailRoom['cancelationPolicy'])">
                                    <li ng-if="penaltyItem['penalty']['totalPrice'] == '0'">     
                                        Бесплатная отмена до 
                                        {{cancelationPolicyDate(penaltyItem['date'])}}.
                                    </li>
                                    <li ng-if="penaltyItem['penalty']['totalPrice'] != '0' ">
                                        Штраф 
                                        <b>{{penaltyItem['penalty']['totalPrice']}}
                                        {{penaltyItem['penalty']['currencyCode']}}</b>
                                        в случае отмены с
                                        {{cancelationPolicyDate(penaltyItem['date'])}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="item">
                            <div class="title">Стоимость</div>
                            <div class="descr">
                                <span>{{getRoomPrice(bookInfoDetailRoom['person'])}} EUR</span>
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
                    <div 
                        class="row _book_block_person person_{{$index}}" 
                        ng-repeat="person in checkIsArray(bookInfoDetailRoom['person'])"
                    > 
                        <div class="row__title">
                            Турист {{$index+1}} 
                            <span ng-if="person['ageType'] === 'adult' ">(взрослый)</span>
                            <span ng-if="person['ageType'] === 'child' ">(ребенок)</span>
                        </div>
                        <div class="row__wrapper">
                            <div class="row__wrap">
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Имя*</div>
                                        <input type="text" class="input name">
                                    </div>
                                </div>
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Фамилия*</div>
                                        <input type="text" class="input lname">
                                    </div>
                                </div>
                                <div class="row__item row__item__crop">
                                    <div class="item">
                                        <div class="item__title">Дата рождения{{person['ageType'] === 'child' ? '*' : ''}}</div>
                                        <datepicker class="datepick" date-format="dd-MM-yyyy">
                                            <input 
                                                type="text" 
                                                class="input birthday"
                                                ng-class="person['ageType'] === 'child' ? '_child' : '' "
                                            />
                                        </datepicker>
                                    </div>
                                </div>
                            </div>
                            <div class="row__wrap">
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Серия/номер паспорта</div>
                                        <input type="text" class="input serialnum">
                                    </div>
                                </div>
                                <div class="row__item row__item__crop">
                                    <div class="item">
                                        <div class="item__title">Срок действия паспорта</div>
                                        <input type="text" class="input exp">
                                    </div>
                                </div>
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Гражданство</div>
                                        <input type="text" class="input citizenship">
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="user_info">
                        <div class="user_info__title">Контактное лицо</div>
                        <div class="row__wrap">
                            <div class="row__item">
                                <div class="item">
                                    <div class="item__title">Имя*</div>
                                    <input type="text" class="input user_name">
                                </div>
                            </div>
                            <div class="row__item row__item__crop">
                                <div class="item">
                                    <div class="item__title">Email*</div>
                                    <input type="text" class="input user_email">
                                </div>
                            </div>
                            <div class="row__item">
                                <div class="item">
                                    <div class="item__title">Телефон*</div>
                                    <input type="text" class="input user_phone">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="comment">
                        <div class="item">
                            <div class="item__title">Комментарий к заказу</div>
                            <textarea class="textarea comment" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="clear"></div>
                </form>

                <div class="book_block__bottom__btns clearfix">
                    <a class="back" ng-click="backToSearch()">
                        <img src="<?php echo get_template_directory_uri();?>/images/book_back.png" alt="">
                        Вернуться
                    </a>
                    <a class="submit" ng-click="preCompleteBook()">                        
                        Далее
                        <img src="<?php echo get_template_directory_uri();?>/images/book_next.png" alt="">
                    </a>
                </div> 

            </div>
        </div>  

             
    </div>

    <div class="confirm_block" id="confirm_block">
        <div class="center">
            <div class="confirm_block__title">
                Ваше бронирование почти завершено
            </div>
            <div class="confirm_block__subtitle">
                Пожалуйста, проверьте ваши данные и подтвердите бронирование
            </div>
            <div class="confirm_block__info">
                <div class="item">
                    <div class="item__title">
                        Тип номера
                    </div>
                    <div class="item__descr">
                        {{bookInfoRoom['name']}}
                    </div>
                </div>
                <div class="item">
                    <div class="item__title">
                        Питание
                    </div>
                    <div class="item__descr">
                        {{getMealName(bookInfoDetailRoom['person'])}}
                    </div>
                </div>
                <div class="item">
                    <div class="item__title">
                        Условия отмены
                    </div>
                    <div class="item__descr">
                        <ul ng-repeat="penaltyItem in checkIsArray(bookInfoDetailRoom['cancelationPolicy'])">
                            <li ng-if="penaltyItem['penalty']['totalPrice'] == '0'">     
                                Бесплатная отмена до 
                                {{cancelationPolicyDate(penaltyItem['date'])}}.
                            </li>
                            <li ng-if="penaltyItem['penalty']['totalPrice'] != '0' ">
                                Штраф 
                                <b>{{penaltyItem['penalty']['totalPrice']}}
                                {{penaltyItem['penalty']['currencyCode']}}</b>
                                в случае отмены с
                                {{cancelationPolicyDate(penaltyItem['date'])}}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="item">
                    <div class="item__title">
                        Период проживания
                    </div>
                    <div class="item__descr">
                        {{inDateModel}} - {{outDateModel}}
                    </div>
                </div>
            </div>

            <div class="book_block__bottom">
                <div class="book_block__bottom__title">Туристы</div>
                <form class="form_tourists">
                    <div 
                        class="row"
                        ng-repeat="person in personsToConfirm"
                    > 
                        <div class="row__title">
                            Турист
                        </div>
                        <div class="row__wrapper">
                            <div class="row__wrap">
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Имя</div>
                                        <input type="text" class="input" disabled="true" value="{{person['name']}}">
                                    </div>
                                </div>
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Фамилия</div>
                                        <input type="text" class="input" disabled="true" value="{{person['surname']}}">
                                    </div>
                                </div>
                                <div class="row__item row__item__crop">
                                    <div class="item">
                                        <div class="item__title">Дата рождения</div>
                                        <input type="text" class="input" disabled="true" value="{{person['birthday']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row__wrap">
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Серия/номер паспорта</div>
                                        <input type="text" class="input" disabled="true" value="{{person['passportNumber']}}">
                                    </div>
                                </div>
                                <div class="row__item row__item__crop">
                                    <div class="item">
                                        <div class="item__title">Срок действия паспорта</div>
                                        <input type="text" class="input" disabled="true" value="{{person['passportExpiration']}}">
                                    </div>
                                </div>
                                <div class="row__item">
                                    <div class="item">
                                        <div class="item__title">Гражданство</div>
                                        <input type="text" class="input" disabled="true" value="{{person['citizenship']}}">
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="user_info">
                        <div class="user_info__title">Контактное лицо</div>
                        <div class="row__wrap">
                            <div class="row__item">
                                <div class="item">
                                    <div class="item__title">Имя</div>
                                    <input type="text" class="input" disabled="true" value="{{userInfo['userName']}}">
                                </div>
                            </div>
                            <div class="row__item row__item__crop">
                                <div class="item">
                                    <div class="item__title">Email</div>
                                    <input type="text" class="input" disabled="true" value="{{userInfo['userEmail']}}">
                                </div>
                            </div>
                            <div class="row__item">
                                <div class="item">
                                    <div class="item__title">Телефон</div>
                                    <input type="text" class="input" disabled="true" value="{{userInfo['userPhone']}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="comment">
                        <div class="item">
                            <div class="item__title">Комментарий к заказу</div>
                            <textarea class="textarea comment _comment" rows="5" disabled="true"></textarea>
                        </div>
                    </div>
                    <div class="clear"></div>
                </form>

                <div class="confirm_block__bottom">
                    
                    <div class="right_side">
                        <div class="price">
                            <span>Стоимость бронироваия:</span>
                            <b>{{getRoomPrice(bookInfoDetailRoom['person'])}} EUR</b>
                        </div>
                        <div class="confirm_btn">
                            <a ng-click="completeBook()">Подтверждаю бронирование</a>
                        </div>
                        <div class="agree_block">
                            <div class="policy">
                                Я согласен с <a href="#">политикой конфиденциальности</a>
                            </div>
                            <div class="agree">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" version="1.1" width="26px" height="26px">
                                    <g><path style=" " d="M 22.566406 4.730469 L 20.773438 3.511719 C 20.277344 3.175781 19.597656 3.304688 19.265625 3.796875 L 10.476563 16.757813 L 6.4375 12.71875 C 6.015625 12.296875 5.328125 12.296875 4.90625 12.71875 L 3.371094 14.253906 C 2.949219 14.675781 2.949219 15.363281 3.371094 15.789063 L 9.582031 22 C 9.929688 22.347656 10.476563 22.613281 10.96875 22.613281 C 11.460938 22.613281 11.957031 22.304688 12.277344 21.839844 L 22.855469 6.234375 C 23.191406 5.742188 23.0625 5.066406 22.566406 4.730469 Z "/></g>
                                    </svg>
                                </span>
                                Я ознакомился и согласен с <a href="#">условиями бронирования</a>
                            </div>
                        </div>
                    </div>

                    <div class="left_side">
                        <a class="back" ng-click="backToSearch()">
                            <img src="<?php echo get_template_directory_uri();?>/images/book_back.png" alt="">
                            Редактировать
                        </a>
                    </div>
                </div> 
            </div>
        </div> 
    </div>

    <div class="responce_block responce_block__success" id="responce_block__success">
        <div class="center">
            Ваша заявка принята! <br>
            Номер заявки - {{bookIdNumber}} 
        </div>
    </div>

    <div class="responce_block responce_block__error" id="responce_block__error">
        <div class="center">
            Произошла ошибка. Пожалуйста, попробуйте позже
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
                        <a href="#">Договор оферты</a><br>
                        <a href="#">Политика конфиденциальности</a>
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