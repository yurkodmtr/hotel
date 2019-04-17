<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'src'.DIRECTORY_SEPARATOR .'FileCache.php';

// Remove WP Version From Styles    
add_filter( 'style_loader_src', 'sdt_remove_ver_css_js', 9999 );
// Remove WP Version From Scripts
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999 );

// Function to remove version numbers
function sdt_remove_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
function theme_name_scripts() {
    wp_enqueue_style( 'theme-style', get_template_directory_uri() . '/css/main.min.css?v=' . time() );
    wp_enqueue_script( 'theme-angular', get_template_directory_uri() . '/app/app.min.js?v=' . time());
    wp_enqueue_script( 'theme-scripts', get_template_directory_uri() . '/js/app.min.js?v=' . time());
}

/* get all cities */
add_action('wp_ajax_getAllCities', 'getAllCities');
add_action('wp_ajax_nopriv_getAllCities', 'getAllCities');  
function getAllCities(){ 
    $str = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR .'cities.json');
    echo json_encode($str);
    die();
}

/* get meal types */
add_action('wp_ajax_getMealStatic', 'getMealStatic');
add_action('wp_ajax_nopriv_getMealStatic', 'getMealStatic');  
function getMealStatic(){ 
    $str = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR .'meal.json');
    echo json_encode($str);
    die();
}

/* change sity */
add_action('wp_ajax_changeSelectCity', 'changeSelectCity'); 
add_action('wp_ajax_nopriv_changeSelectCity', 'changeSelectCity');  
function changeSelectCity(){  

    $id = isset($_POST['id']) ? $_POST['id'] : '118593';

    $cacheId = 'parse_' . $id;
    $cache = new FileCache(array(
        'name' => $cacheId,
        'path' => dirname(__FILE__) . DIRECTORY_SEPARATOR  . 'cache' . DIRECTORY_SEPARATOR,
        'extension' => '.json'
    ));
    $cache->eraseExpired();
    $cacheData = $cache->retrieve($cacheId);

    if ($cacheData === null || $_GET['clear_cache']) {
       
        include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'auth.php');    
        $client = new SoapClient("http://test.bestoftravel.cz:8080/booking/public/ws/syncHotel.wsdl", array( 'trace' => 1));
        $client->__setSoapHeaders(Array(new WsseAuthHeader($AuthUser, $AuthPassword)));

        $parameters= array(
            'locationId' => $id    
        );

        $cacheData = json_encode($client->pullHotels($parameters));
        $cache->store($cacheId, $cacheData, 86400);    
    }

    echo json_encode($cacheData);
    die();
}

/* search hotels */
add_action('wp_ajax_searcHotels', 'searcHotels'); 
add_action('wp_ajax_nopriv_searcHotels', 'searcHotels');  
function searcHotels(){  

    include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'auth.php');

    $cityId = isset($_POST["cityId"]) && !empty($_POST["cityId"]) ? $_POST["cityId"] : '';
    $hotelId = isset($_POST["hotelId"]) && !empty($_POST["hotelId"]) ? $_POST["hotelId"] : [];
    $hotelCategory = isset($_POST["hotelCategory"]) && !empty($_POST["hotelCategory"]) ? $_POST["hotelCategory"] : '';
    $checkInDate = isset($_POST["checkInDate"]) && !empty($_POST["checkInDate"]) ? $_POST["checkInDate"] : '';
    $countOfNigts = isset($_POST["countOfNigts"]) && !empty($_POST["countOfNigts"]) ? $_POST["countOfNigts"] : '';
    $adultsCount = isset($_POST["adultsCount"]) && !empty($_POST["adultsCount"]) ? $_POST["adultsCount"] : '';
    $childrenCounts = isset($_POST["childrenCounts"]) && !empty($_POST["childrenCounts"]) ? $_POST["childrenCounts"] : '';
    $childrenAges = isset($_POST["childrenAges"]) && !empty($_POST["childrenAges"]) ? $_POST["childrenAges"] : [];
    
    $client = new SoapClient("http://test.bestoftravel.cz:8080/booking/public/ws/searchHotel.wsdl", array( 'trace' => 1));
    $client->__setSoapHeaders(Array(new WsseAuthHeader($AuthUser, $AuthPassword)));

    $parameters= array(
        'outOperatorIncID' => $AuthCompanyId,
        'dateFrom' => $checkInDate,
        'nightsDuration' => $countOfNigts,
        'availableOnly' => false,
        'persons' => [
            'adults' => $adultsCount,
            'childAges' => $childrenAges,
        ],    
        'locationIds'=>[$cityId], 
        'hotelIds'=>$hotelId, 
        'hotelServices'=> []    
    );

    $data = json_encode($client->hotelSearchStep1($parameters));

    echo $data;
    die();    
}

//booking 
add_action('wp_ajax_booking', 'booking'); 
add_action('wp_ajax_nopriv_booking', 'booking');  
function booking(){

    if ( !isset($_POST['data']) ) {
        echo "bad params";
        die();
    }

    include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'auth.php');

    $persons = isset($_POST['data']['persons']) ? $_POST['data']['persons'] : '';

    $addHotel = isset($_POST['data']['addHotel']) ? $_POST['data']['addHotel'] : '';

    $addHotelhotelId = $addHotel['hotelId'] !== NULL ? $addHotel['hotelId'] : '';    
    $addHotelcontractGroupId = $addHotel['contractGroupId'] !== NULL ? $addHotel['contractGroupId'] : '';
    $addHotelroomId = $addHotel['roomId'] !== NULL ? $addHotel['roomId'] : '';
    $addHotelstartDate = $addHotel['startDate'] !== NULL ? $addHotel['startDate'] : '';

    $addHotelendDate = $addHotel['endDate'] !== NULL ? $addHotel['endDate'] : '';
    $addHotelearlyBooking = $addHotel['earlyBooking'] !== NULL ? $addHotel['earlyBooking'] : '';
    if ( $addHotelearlyBooking == 'true' ) {
        $addHotelearlyBooking = true;
    } else {
        $addHotelearlyBooking = false;
    }


    $addHotelhotelPerson = $addHotel['hotelPerson'] !== NULL ? $addHotel['hotelPerson'] : '';
    $addHotelpenaltyKey = $addHotel['penaltyKey']['nonRefundable'] !== NULL ? $addHotel['penaltyKey']['nonRefundable'] : '';
    if ( $addHotelpenaltyKey == 'true' ) {
        $addHotelpenaltyKey = true;
    } else {
        $addHotelpenaltyKey = false;
    }

    $addHotelpenaltyKeyId = $addHotel['penaltyKey']['id'] !== NULL ? $addHotel['penaltyKey']['id'] : '';

    $addHotelhotelPrice = $addHotel['price'] !== NULL ? $addHotel['price'] : '';
    $addHotelhotelPriceavailability = $addHotelhotelPrice['availability'] !== NULL ? $addHotelhotelPrice['availability'] : '';
    $addHotelhotelPricetotalPrice = $addHotelhotelPrice['totalPrice'] !== NULL ? $addHotelhotelPrice['totalPrice'] : '';
    $addHotelhotelPricecurrencyCode = $addHotelhotelPrice['currencyCode'] !== NULL ? $addHotelhotelPrice['currencyCode'] : '';

    

    $comment = isset($_POST['data']['addRequestComment']['comment']) ? $_POST['data']['addRequestComment']['comment'] : '';
    $comment = $comment != '' ? $comment : 'no comment';

    $version = time();

    $parameters = array(
        'outOperatorIncID' => $AuthCompanyId,
        'actions' => [
            'addPerson' => [
                'index' => 0,
                'person' => $persons,
            ],
            'addHotel' => [
                'index' => 1,
                'serviceOutId' => 1,
                'hotelId' => $addHotelhotelId,
                'contractGroupId' => $addHotelcontractGroupId,
                'roomId' => $addHotelroomId,
                'startDate' => $addHotelstartDate,
                'endDate' => $addHotelendDate,
                'earlyBooking' => $addHotelearlyBooking,
                'hotelPerson' => $addHotelhotelPerson,
                'price' => [
                    'availability' => 'available', 
                    'totalPrice' => $addHotelhotelPricetotalPrice,
                    'currencyCode' => $addHotelhotelPricecurrencyCode,
                ],
                'penaltyKey' => [
                    'id' => $addHotelpenaltyKeyId,
                    'nonRefundable' => $addHotelpenaltyKey,
                ],
            ],
            'addRequestComment' => [
                'index' => 2,
                'comment' => $comment,
            ],
        ],
        'requestVersion' => [
            'outId' => time(),
            'version' => 1,
        ],
    );

    $client = new SoapClient("http://test.bestoftravel.cz:8080/booking/public/ws/book.wsdl", array( 'trace' => 1));
    $client->__setSoapHeaders(Array(new WsseAuthHeader($AuthUser, $AuthPassword)));

    try{
        $data = json_encode($client->book($parameters));
        echo $data;
    } 
    catch (Exception $ex) {
        echo $ex->getMessage();
    }
    die();
}
//booking();

add_action('wp_ajax_bookInfoToEmail', 'bookInfoToEmail'); 
add_action('wp_ajax_nopriv_bookInfoToEmail', 'bookInfoToEmail');  
function bookInfoToEmail(){

    if ( !isset($_POST['data']) ) {
        echo "bad params, mail was not send";
        die();
    }

    $to = 'wellcotravel@gmail.com'; //wellcotravel@gmail.com
    $subject = 'online.bestslovenia.com - book event';

    ob_start();
    include(dirname(__FILE__) . DIRECTORY_SEPARATOR . '/views/mail.php');
    $message = ob_get_clean();

    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    wp_mail( $to, $subject, $message, $headers );
    
}


// mailchimp
add_action('wp_ajax_mailChimp', 'mailChimp'); 
add_action('wp_ajax_nopriv_mailChimp', 'mailChimp');  
function mailChimp(){  

    $email = isset($_POST['email']) ? $_POST['email'] : 'test@test.com';
    // MailChimp API credentials
    $apiKey = '8d66e4f6bf7368bb99f7d1ef813936b1-us6';
    $listID = '7ff7cc295d';
    // MailChimp API URL
    $memberID = md5(strtolower($email));
    $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;
    // member information
    $json = json_encode([
        'email_address' => $email,
        'status'        => 'subscribed'
    ]);
    // send a HTTP POST request with curl
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $response = '';
    if ($httpCode == 200) {
        $response = 200;
    } else {
        switch ($httpCode) {
            case 214:
                $response = 214;
                break;
            default:
                $response = 'error';
                break;
        }        
    }
    echo $response;
    die();
}
