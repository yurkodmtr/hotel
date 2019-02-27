<?php
include 'auth.php';

$client = new SoapClient("http://booking.realobs.com/booking/public/ws/syncHotel.wsdl");
//$client->__setSoapHeaders(Array(new WsseAuthHeader('17', '881Ass963WX')));

$parameters= array(
    'outOperatorIncID' => '981208873',
    'dateFrom' => '2018-05-05',
    'nightsDuration' => 5,
    'availableOnly' => false,
    'persons' => [
        'adults' => 1,
        'childAges' => [11]
    ],    
    'locationIds'=>[111756], 
    'hotelIds'=>[], 
    'hotelServices'=> []    
);

echo "<pre>"; 
print_r($client->__getFunctions());
echo $client->__getLastResponse();

?>