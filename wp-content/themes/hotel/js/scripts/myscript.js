"use strict";

var myFunc = function(){

	var removePlaceholder = function () {
	    $('body').on('focus', 'input,textarea', function (){
	        $(this).data('placeholder', $(this).attr('placeholder')).attr('placeholder', '');
	    }).on('blur', 'input,textarea', function (){
	        $(this).attr('placeholder', $(this).data('placeholder'));
	    });
	}

	var sameHeight = function(item){
		item.css('height','auto');
		var maxHeight = 0;
		item.each(function(){
			if ( $(this).outerHeight() > maxHeight ) {
				maxHeight = $(this).outerHeight();
			}
		});
		item.css('height', maxHeight + 'px');
	}

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

	var agreeCheckbox = function(){
		$('.confirm_block .agree').click(function(){
			if ( $(this).hasClass('act') ) {
				$(this).removeClass('act');
			} else {
				$(this).addClass('act');
			}

			if ( $(this).hasClass('error') ) {
				$(this).removeClass('error');
			}
		});
	}
	
	var openModal = function(){
		$('body').on('click', '._open_modal', function (){
			var url = $(this).data('href');

			var wWidth = Math.round($(window).width());
			var wHeight = Math.round($(window).height());

			var modalWidth = Math.round(wWidth * 0.6);
			var modalHeight = Math.round(wHeight * 0.8);

			var left = Math.round((wWidth - modalWidth)/2);
			var top = Math.round((wHeight - modalHeight)/2);

			console.log(wWidth);
			console.log(modalWidth);
			console.log(left);

  			return window.open(url,'title','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+modalWidth+', height='+modalHeight+', top='+top+', left='+left);

		});
	}

	$(document).ready(function(){
		openModal();
		removePlaceholder();
		sameHeight($('.footer_block .links .item .title'));
		agreeCheckbox();
		popClose();
		tooltip();
		menu();
		showMoreRooms();
	});

	$(window).resize(function(){
		sameHeight($('.footer_block .links .item .title'));
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