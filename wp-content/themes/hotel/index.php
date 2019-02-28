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
    <script src="<?php bloginfo('template_url');?>/app/libs/angular-route.min.js"></script>

    <!-- app -->
    <script src="<?php bloginfo('template_url');?>/app/app.js?v=<?php echo time(); ?>"></script>

</head>
<body ng-app="myApp">

    <div ng-controller="welcomeController">
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
                <div class="title">Hotel Name</div>
                <select class="_hotel_name">
                    <option ng-repeat="option in hotelsByCity" value="{{option.id}}">{{option.name}}</option>
                </select>
            </div>

            <div class="row">
                <div class="title">Hotel Category</div>
                <select class="_hotel_category">
                    <option>3*</option>
                    <option>4*</option>
                    <option>5*</option>
                </select>
            </div>
            
            <div class="row">
                <div class="title">Check-in date</div>
                <input type="date" class="_check_in_date">
            </div>
            <div class="row">
                <div class="title">Check-out date</div>
                <input type="date" class="_check_out_date">
            </div>
            <div class="row">
                <div class="title">Board type</div>
                <select class="_board_type">
                    <option>ALL</option>
                    <option>BB</option>
                    <option>HB</option>
                    <option>FB</option>
                    <option>HB+treatment</option>
                    <option>FB+treatment</option>
                </select>
            </div>
            <div class="row">
                <div class="title">Adults</div>
                <select class="_adults">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                </select>
            </div>
            <div class="row">
                <div class="title">Children</div>
                <select class="_children">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                </select>
            </div>
            <div class="row">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>

    <div class="loader" style="display:none;text-align:center;">loader</div>
    

    <table class="table" style="width:100%;" border="1px">
    	<tr>
    		<td>Name</td>
    		<td>Category</td>
    	</tr>
    </table>






</body>
</html>