"use strict";

var myFunc = function(){

	var initCitySelect = function(){
		var data;
		$.ajax({
            url: "/old/country.json",
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                data = data.location;
				$.each(data, function(index, value) {
					if ( 
						value.type === 'city' && 
						value.parent_id == '118593' && 
						value.status == 'active'
					) { 
						_citySelectInit(value.id, value.names.en);
					}
				});
            },
            error: function (data) {
                console.log(data);
            }
        });
	}

	var getLocaleList = function(){
		$('.qqq').click(function(){
			$.ajax({
                url: "/syncLocation.php",
                type: 'POST',
                dataType: 'json',
                data: {
                    email: '111'
                },
                success: function (data) {
                    var responce = data.location;
                    //console.log(typeof responce);
                    //countrySelectInit(responce);
                },
                error: function (data) {
                    console.log(data);
                }
            });
		});
	}

	var _citySelectInit = function(id, name, ){
		$('select._city')
			.append($("<option></option>")
				.attr("value",id)
				.text(name)
			); 
	}

	var submitForm = function(){
		$('.search_form form').on('submit', function (event) {
        	event.preventDefault();

        	var city = $('select._city').val();
        	var hotelCategory = $('._hotel_category').val();
        	var hotelName = $('._hotel_name').val();
        	var checkInDate = $('._check_in_date').val();
        	var checkOutDate = $('._check_out_date').val();
        	var boardType = $('._board_type').val();
        	var adults = $('._adults').val();
        	var children = $('._children').val();


        	if (checkInDate == '') {
        		var d = new Date();
				var month = d.getMonth()+1;
				var day = d.getDate();
				var output = d.getFullYear() + '-' +
				    ((''+month).length<2 ? '0' : '') + month + '-' +
				    ((''+day).length<2 ? '0' : '') + day;
				checkInDate = output;
        	}

        	$('.loader').show();
        	$.ajax({
	            url: "/searchHotel.php",
	            type: 'POST',
	            dataType: 'json',
	            data : {
	            	city: city,
	            	hotelCategory: hotelCategory,
	            	hotelName: hotelName,
	            	checkInDate: checkInDate,
	            	checkOutDate: checkOutDate,
	            	boardType: boardType,
	            	adults: adults,
	            	children: children
	            },
	            success: function (data) {
	            	$('.table').html('');
	            	if ( data.hotelOffers === null || data.hotelOffers === undefined || data.hotelOffers == '' ) {
	            		$('.table').append($('<tr><td>Empty</td></tr>'));
	            		$('.loader').hide();
	            		return false;
	            	}
	                $.each(data.hotelOffers, function( index, value ) {
	                	console.log(value);
					  	var name = value.hotel.name;
					  	var category = value.hotel.hotelCategory.id;
					  	switch(category) {
						  case 7:
						    category = 'Villa';
						    break;
						  case 8:
						    category = "Appartment";
						    break;
						}
					  	$('.table').append($('<tr><td>' + name + '</td><td>' + category + '*</td></tr>'));
					});
					$('.loader').hide();
	            },
	            error: function (data) {
	                console.log(data);

	            }
	        });
        });
	}

	$(document).ready(function(){
		initCitySelect();
		getLocaleList();		
		submitForm();
	});

}

myFunc();