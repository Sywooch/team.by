jQuery(function($) {
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
	
    $('#login-modal').on('click', function (e) {
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
	
	$('#regstep2form-category1').on('change', function(e){
		console.log($(this).val());
		$('.categories-block').each(function(){
			if($(this).is(':visible')) {
				$(this).find('.reg-step2-category').each(function(){
					$(this).prop('checked', false);
				});
				$(this).hide();
			}
		});
		$('#selected_categories_cnt').html('');
		$('#selected_categories').hide();
		$('#category-block-' + $(this).val()).show();
		
		
	});
	
	$('#site-reg-add-new-city').on('click', function(e){
		$('#regstep2form-region_name').val('');
		$('#site-reg-add-new-city-cnt').slideToggle();
		return false;
	});
	
	$('.reg-step2-category').on('click', function(e){
		if($(this).prop('checked')) {
			$('#selected_categories_cnt').append('<div id="cnt-price-' + $(this).val()+'" class="form-group clearfix"><label for="price-' + $(this).val() + '" class="col-sm-5 control-label">' + $.trim($(this).parent().text())+'</label><div class="col-sm-6"><input type="text" name="RegStep2Form[price][]" class="form-control" id="price-' + $(this).val() + '" placeholder="Укажите стоимость"></div><div class="col-sm-1"><span class="site-reg-remove-price" data-category="' + $(this).val() + '">×</span></div></div>');
		}	else	{
			$('#selected_categories_cnt').find('#cnt-price-' + $(this).val()).remove();
		}
		
		if($('#selected_categories').is(':hidden')) {
			$('#selected_categories').slideDown();
		}
			
	});
	
	$('#selected_categories_cnt').on('click', '.site-reg-remove-price', function(e){
		//console.log($(this).data('category'));
		$('#category-' + $(this).data('category')).prop('checked', false);
		$('#selected_categories_cnt').find('#cnt-price-' + $(this).data('category')).remove();
	});
	
	
	
	
});
