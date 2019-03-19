"use strict";

var myFunc = function(){

	var popClose = function(){
		$('._pop_close').click(function(){
			$('.pop').fadeOut('slow');
			$('body').css('overflow','visible');
		});
	}

	var tooltip = function(){
		$('body').on('click', '.tooltip__title', function (){
	        if ( $(this).parent().hasClass('act') ) {
				$(this).parent().removeClass('act');
			} else {
				$(this).parent().addClass('act');
			}
	    });
	    $('body').on('click', '.tooltip__descr__close', function (){
	        $(this).parent().parent().removeClass('act');
	    });
	}

	var menu = function(){
		$('._open_menu').click(function(){
			$('.header .menu').addClass('act');
		});
		$('.header .menu .close').click(function(){
			$('.header .menu').removeClass('act');
		});
	}

	var showMoreRooms = function(){
		$('body').on('click', '.result_block .result_list .item__wrap .show_more a', function (){
			if ( $(this).parent().hasClass('act') ) {
				$(this).parent().removeClass('act');
				$(this).closest('.item__wrap').find('.right_side').find('.room_toggle').addClass('_hide');
			} else {
				$(this).parent().addClass('act');
				$(this).closest('.item__wrap').find('.right_side').find('.room_toggle').removeClass('_hide');
			}			
		});		
	}
	

	$(document).ready(function(){
		popClose();
		tooltip();
		menu();
		showMoreRooms();
	});

	$(window).resize(function(){
		
	});

	$(window).load(function(){

	});

}

myFunc();

$(document).ready(function(){

	function validateEmail(email) {
	    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(String(email).toLowerCase());
	}

	$('.mailchimp').submit(function(event){
		event.preventDefault();
		var email = $(this).find('input[type="email"]').val(); 

		if (!validateEmail(email)) {
			$('.mailchimp .input').addClass('error');
			return false;
		}

		$('.mailchimp .input').removeClass('error');
		$('.mailchimp .submit').addClass('loading');

		$.ajax({
            url: urlAjax,
            type: 'POST',
            dataType: 'json',
            data: {
                action:'mailChimp',
                email: email
            },
            success: function(data) {
            	$('.mailchimp .submit').removeClass('loading');
            	$('body').css('overflow','hidden');
                $('.pop__mailchimp__success').fadeIn();
                $('.mailchimp .input').val('');
                setTimeout(function(){
                	$('.pop').fadeOut('slow');
                }, 5000);
            },
            error: function(data) {
            	$('.mailchimp .submit').removeClass('loading');
            	$('body').css('overflow','hidden');
                $('.pop__mailchimp__error').fadeIn();
                setTimeout(function(){
                	$('.pop').fadeOut('slow');
                }, 5000);
            }
        });
	});
});