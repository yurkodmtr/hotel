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

    include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'auth.php');    
    $client = new SoapClient("http://test.bestoftravel.cz:8080/booking/public/ws/syncHotel.wsdl", array( 'trace' => 1));
    $client->__setSoapHeaders(Array(new WsseAuthHeader($AuthUser, $AuthPassword)));

    $parameters= array(
        'locationId' => $id    
    );

    $data = $client->pullHotels($parameters);

    echo json_encode($data);
    die();
}


// cache example
/*
if (!isset($_POST['url'])) {
        echo json_encode(array(
            'error' => true,
            'code' => 503,
            'message' => 'bad_request',
        ));
        die();
    }

    $url = trim($_POST['url']);

    $uid = md5($url);
    $cacheId = 'parse_' . $uid;
    $cache = new FileCache(array(
        'name' => $cacheId,
        'path' => dirname(__FILE__) . DIRECTORY_SEPARATOR  . 'cache' . DIRECTORY_SEPARATOR,
        'extension' => '.json'
    ));
    $cache->eraseExpired();
    $cacheData = $cache->retrieve($cacheId);
    if ($cacheData === null) {
        $curl = new Curl();
        $curl->setUrl($url);
        $response = $curl->execute();

        if(empty(trim($response))){
            echo "line:L " . __LINE__;
            die();
        }
        $cacheData = OgParser::parse($response);
        $cache->store($cacheId, $cacheData, 86400);    
    }
    echo json_encode($cacheData);
    die();
*/
