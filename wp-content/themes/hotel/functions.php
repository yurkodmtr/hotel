<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'src'.DIRECTORY_SEPARATOR .'FileCache.php';


/* get all cities */
add_action('wp_ajax_getAllCities', 'getAllCities');
add_action('wp_ajax_nopriv_getAllCities', 'getAllCities');  
function getAllCities(){ 
    $str = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR .'cities.json');
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
    $hotelId = isset($_POST["hotelId"]) && !empty($_POST["hotelId"]) ? $_POST["hotelId"] : '';
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
            'childAges' => []
        ],    
        'locationIds'=>[$cityId], 
        'hotelIds'=>[], 
        'hotelServices'=> []    
    );


    $data = json_encode($client->hotelSearchStep1($parameters));

    echo $data;
    die();
    
}


    

