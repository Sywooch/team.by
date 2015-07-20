jQuery(function($) {
	function ekkoLightboxInit() {
		$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
			event.preventDefault();
			$(this).ekkoLightbox({loadingMessage:'<p style="padding:20px;font-weight:bold;">Загрузка...</p>'});
		}); 				
		
	}
	
	ekkoLightboxInit();
	
	
	//$("[data-toggle='tooltip']").tooltip();
	//$("[data-toggle='popover']").popover();
	
	$('#header_phone').hover(
		function(){$('#header_phone__popup').stop(true,true).fadeIn();},
		function(){$('#header_phone__popup').stop(true,true).fadeOut();}
	);
	
	$('#currency_select__usd').hover(
		function(){$('#currency_select__popup').stop(true,true).fadeIn();},
		function(){$('#currency_select__popup').stop(true,true).fadeOut();}
	);
	
    $('#login-modal, #login-modal-footer').on('click', function (e) {
        var url = $(this).attr('href')+"?modal=1",
            modal = $('.modal');
		
        $.get(url, function (data) {
            modal.html(data).modal('show');
        });
        return false;
    });
	
    $('.modal').on('click', '.login_button, .send_email_button', function () {
        var form = $(this).closest('form'),
            modal = $('.modal');
        $.post(
            form.attr('action'),
            form.serialize(),
            function (data) {
                if (data == 'ok') {
                    window.location.reload();
                } else {
                    //$('.modal').html(data);
                    modal.children('.modal-dialog').remove();
                    modal.append(data);
                }
            }
        );
        return false;
    });
	

    $('.modal').on('click', '.reset_url', function () {
        var url = $(this).attr('href')+"?modal=1",
            modal = $('.modal');
        $.get(url, function (data) {
            modal.children('.modal-dialog').remove();
            modal.append(data);
        });
        return false;
    });
	
	
    $('#header_regions__active').on('click', function (e) {
		$('#header_regions__list_cnt').fadeToggle();
        return false;
    });
	
    
	$('#profi_search_inner_regions__active').on('click', function (e) {
		$('#profi_search_inner_regions__list_cnt').fadeToggle();
        return false;
    });
	
	$('.profi_search_regions__item a').on('click', function (e) {
		$('#profi_search_inner_regions__active').text($(this).text());
		$('#profi_search_inner_regions__list_cnt').fadeToggle(10);
		$('.profi_search_inner__inputbox').css('width', ($('.profi_search_inner__inputbox_cnt').width() - $('#profi_search_inner_regions__active').width() - 40)+'px');
		
		console.log($('#profi_search_inner_regions__active').width());
		console.log($('.profi_search_inner__inputbox_cnt').width());
        return false;
    });
	
	
    $('#profi_search_tab_1_regions__active').on('click', function (e) {
		$('#profi_search_tab_1_regions__list_cnt').fadeToggle();
        return false;
    });
	
    $('.profi_search_tab_1_regions__item a').on('click', function (e) {
		$('#profi_search_tab_1_regions__active').html($(this).html());
		$('#profi_search_tab_1_regions__list_cnt').fadeToggle();
        return false;
    });
	
	$('.header_regions__item a').on('click', function(e){
		$('#region_id').val($(this).data('region'));
		$('#header_regions__list_cnt').fadeToggle();
		$('#set-region-frm').submit();
	});
	
	$('.currency_select__item').on('click', function(e){
		$('#currency_id').val($(this).data('currency'));
		$('#set-currency-frm').submit();
	});
	
	$('.category-sort-cnt').on('click', 'a', function(e){
		//console.log($(this).data('category'));
		$('#category-sort-sw #orderby').val($(this).data('sort'));
		$('#category-sort-sw').submit();
		return false;
	});
	
	
	//заказ подбора спеиалиста
    $('#profi_search_btn').on('click', function (e) {
        var url = $(this).attr('href')+"?modal=1",
            modal = $('.modal');
		
        $.get(url, function (data) {
            modal.html(data).modal('show');
        });
        return false;
    });
	
	
    $('.modal').on('click', '#zakaz-spec1-btn', function () {
        var form = $(this).closest('form'),
            modal = $('.modal');
        $.post(
            form.attr('action'),
            form.serialize(),
            function (data) {
				modal.children('.modal-dialog').remove();
				modal.append(data);
            }
        );
        return false;
    });
	
    $('.modal').on('click', '#zakaz-spec2-btn', function () {
        var form = $(this).closest('form'),
            modal = $('.modal');
        $.post(
            form.attr('action'),
            form.serialize(),
            function (data) {
				modal.children('.modal-dialog').remove();
				modal.append(data);
            }
        );
        return false;
    });
		
    $('#logout-btn, #logout-btn-footer').on('click', function (e) {
		e.preventDefault;
		$(this).parent().submit();
        return false;
    });
		
		
	$('#begin-reg').on('click', function(e){
		if($('#rules_agree').prop('checked') === false) {
			e.preventDefault();
			return false;
		}	
	});
	
	
	
	
	
});