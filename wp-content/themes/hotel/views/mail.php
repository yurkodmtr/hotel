<?php
	$userName = isset($_POST['data']['userName']) ? $_POST['data']['userName'] : '';
	$userEmail = isset($_POST['data']['userEmail']) ? $_POST['data']['userEmail'] : '';
	$userPhone = isset($_POST['data']['userPhone']) ? $_POST['data']['userPhone'] : '';


	$persons = isset($_POST['data']['persons']) ? $_POST['data']['persons'] : '';

    $city = isset($_POST['data']['city']) ? $_POST['data']['city'] : '';
    $addHotel = isset($_POST['data']['addHotel']) ? $_POST['data']['addHotel'] : '';

    $addHotelhotelId = $addHotel['hotelId'] !== NULL ? $addHotel['hotelId'] : '';
    $addHotelhotelIdText = $addHotel['hotelIdText'] !== NULL ? $addHotel['hotelIdText'] : '';
    $addHotelcontractGroupId = $addHotel['contractGroupId'] !== NULL ? $addHotel['contractGroupId'] : '';
    $addHotelroomId = $addHotel['roomId'] !== NULL ? $addHotel['roomId'] : '';
    $addHotelstartDate = $addHotel['startDate'] !== NULL ? $addHotel['startDate'] : '';

    $addHotelendDate = $addHotel['endDate'] !== NULL ? $addHotel['endDate'] : '';
    $addHotelearlyBooking = $addHotel['earlyBooking'] !== NULL ? $addHotel['earlyBooking'] : '';


    $addHotelhotelPerson = $addHotel['hotelPerson'] !== NULL ? $addHotel['hotelPerson'] : '';
    $addHotelpenaltyKey = $addHotel['penaltyKey']['nonRefundable'] !== NULL ? $addHotel['penaltyKey']['nonRefundable'] : '';

    $addHotelpenaltyKeyId = $addHotel['penaltyKey']['id'] !== NULL ? $addHotel['penaltyKey']['id'] : '';

    $addHotelhotelPrice = $addHotel['price'] !== NULL ? $addHotel['price'] : '';
    $addHotelhotelPriceavailability = $addHotelhotelPrice['availability'] !== NULL ? $addHotelhotelPrice['availability'] : '';
    $addHotelhotelPricetotalPrice = $addHotelhotelPrice['totalPrice'] !== NULL ? $addHotelhotelPrice['totalPrice'] : '';
    $addHotelhotelPricecurrencyCode = $addHotelhotelPrice['currencyCode'] !== NULL ? $addHotelhotelPrice['currencyCode'] : '';

    

    $comment = isset($_POST['data']['addRequestComment']['comment']) ? $_POST['data']['addRequestComment']['comment'] : '';
    $comment = $comment != '' ? $comment : 'no comment';









    $parameters = array(
        'outOperatorIncID' => $AuthCompanyId,
        'actions' => [
            'addPerson' => [
                'index' => 0,
                'person' => $persons,
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
?>

<table cellspacing="2" border="1" cellpadding="5" width="600">
	<tr>
		<td>User</td>
		<td>
			userName - <?php echo $userName; ?> <br>
			userEmail - <?php echo $userEmail; ?> <br>
			userPhone - <?php echo $userPhone; ?>
		</td>
	</tr>
	<tr>
		<td>City</td>
		<td><?php echo $city; ?></td>
	</tr>
	<tr>
		<td>Hotel Id</td>
		<td><?php echo $addHotelhotelId; ?></td>
	</tr>	
	<tr>
		<td>Hotel Name</td>
		<td><?php echo $addHotelhotelIdText; ?></td>
	</tr>
	<tr>
		<td>contract Group Id</td>
		<td><?php echo $addHotelcontractGroupId; ?></td>
	</tr>
	<tr>
		<td>room Id</td>
		<td><?php echo $addHotelroomId; ?></td>
	</tr>
	<tr>
		<td>start Date</td>
		<td><?php echo $addHotelstartDate; ?></td>
	</tr>
	<tr>
		<td>end Date</td>
		<td><?php echo $addHotelendDate; ?></td>
	</tr>
	<tr>
		<td>early Booking</td>
		<td><?php echo $addHotelearlyBooking; ?></td>
	</tr>
	<tr>
		<td>hotel Person</td>
		<td>
			<?php foreach ($persons as $key => $value) : ?>
				<div style="border-bottom:1px solid #000;padding-bottom:10px;margin-bottom:10px;">
					id - <?php echo $value['outId']?> <br>
					name - <?php echo $value['name']?> <br>
					surname - <?php echo $value['surname']?> <br>
					birthday - <?php echo $value['birthday']?> <br>
					passportNumber - <?php echo $value['passportNumber']?> <br>
					passportExpiration - <?php echo $value['passportExpiration']?> <br>
					citizenship - <?php echo $value['citizenship']?>
				</div>
			<?php endforeach;?>			
		</td>
	</tr>
	<tr>
		<td>price</td>
		<td>
			<?php echo $addHotelhotelPricetotalPrice;?> EUR
		</td>
	</tr>

	<tr>
		<td>penalty Key id</td>
		<td>
			<?php echo $addHotelpenaltyKeyId;?>
		</td>
	</tr>
	<tr>
		<td>penalty Key nonRefundable</td>
		<td>
			<?php echo $addHotelpenaltyKey;?>
		</td>
	</tr>

	<tr>
		<td>comment</td>
		<td><?php echo $comment; ?></td>
	</tr>
</table>