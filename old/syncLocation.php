<?php

include 'auth.php';

$client = new SoapClient("http://test.bestoftravel.cz:8080/booking/public/ws/syncLocation.wsdl");
$client->__setSoapHeaders(Array(new WsseAuthHeader($AuthUser, $AuthPassword)));
$qqq = $client->pullLocations();
$data = json_encode($qqq);

//file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR .'country.json', $data );
echo $data ;
die();