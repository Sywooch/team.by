jQuery(function($) {
	var spec_name = '',
		spec_id = 0,
		phone_mask = '+375 (99) 999-99-99';
	
	
	//получаем кол-во миниатюр у блока
	function getImageNum(block) {
		var count_items = 0,
			pItems = $('#' + block + ' li'),
			iLength = pItems.length,
			i = 0;
		
		for(i = 0; i < iLength; i++)	{
			if($(pItems[i]).data('item') != $(pItems[i]).html()) {
				count_items++;
			} else {
				count_items++;
				break;
			}
		}
		return count_items;
	}
	
	//переупорядочиваем после удаления список миниатюр у блока
	function reorderImages(block) {
		var pItems = $('#' + block + ' li'),
			iLength = pItems.length,
			i = 0;
		
		if(iLength > 0)	{
			for(i = 0; i < iLength; i++)	{
				if($(pItems[i]).data('item') == $(pItems[i]).html() && $(pItems[i+1]).data('item') != $(pItems[i+1]).html()) {
					$(pItems[i]).html($(pItems[i+1]).html());
					$(pItems[i+1]).html($(pItems[i+1]).data('item'));
				}
			}
		}
	}
	
	
	var upload_reviewfoto_item_num = getImageNum('uploading-reviewfoto-list'),
		clicked_el = null;
	
	
	function ekkoLightboxInit() {
		$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
			event.preventDefault();
			$(this).ekkoLightbox({loadingMessage:'<p style="padding:20px;font-weight:bold;">Загрузка...</p>'});
		}); 				
		
	}	
	
	function getSpecList()
	{
		$.ajax({
			type: 'post',				
			url: 'http://team.by/ajax/getspeclist',
			data: {phone : $(".modal").find('#addreviewform-phone').val()},
			//dataType: 'json',
			beforeSend: function(){},
			success: function(msg){
				$(".modal").find('#addreviewform-user_id').remove();
				$(".modal").find('#addreviewform-user_id-styler').remove();
				$(".modal").find('.field-addreviewform-user_id').children('label').after(msg);
				$(".modal").find('select').styler();
				
			}
		});
	}
	
	
	function init_upload_reviewfoto()
	{
		var upload_reviewfoto = new AjaxUpload('#upload-reviewfoto-btn', {
			action: 'http://team.by/ajax/upload-reviewfoto',
			name: 'UploadReviewFotoForm[imageFiles]',
			onSubmit : function(file, extension){
				$("#loading-reviewfoto").show();
				$('#loading-reviewfoto-errormes').html('');
				upload_reviewfoto.setData({'file': file});
			},
			onComplete : function(file, response){
				$("#loading-reviewfoto").hide();

				response = $.parseJSON(response);

				if(response.res == 'ok') {
					//$('.modal').find('#uploading-reviewfoto-list .item-' + upload_reviewfoto_item_num).html(response.html_file + response.html_file_remove + response.filename);
					$('.modal').find('#uploading-reviewfoto-list .item-' + upload_reviewfoto_item_num).html(response.html_file + response.filename);
					$('.modal').find('#uploading-reviewfoto-list .item-' + upload_reviewfoto_item_num).toggleClass('no-foto');
					upload_reviewfoto_item_num++;
					if(upload_reviewfoto_item_num > 4)	$('#upload-reviewfoto-btn').css('visibility', 'hidden');
				} else {
					for (var i = 0; i < response.msg.length; i++) {
					   $('#loading-reviewfoto-errormes').append(response.msg[i]);
					}
				}
			}
		});
		
	}
	
	ekkoLightboxInit();	
	
	$.mask.definitions['~']='[+-]';
	$('.phone-input').mask(phone_mask);
	
	
	//подстраиваем ширину инпута для поиска
	if($("div").is(".profi_search_inner__inputbox_cnt")) {
		$('.profi_search_inner__inputbox').css('width', ($('.profi_search_inner__inputbox_cnt').width() - $('#profi_search_inner_regions__active').width() - 140)+'px');
	} else {
		$('.profi_search_tab_1__inputbox').css('width', ($('.profi_search_tab_1__cnt').width() - $('#profi_search_inner_regions__active').width() - 455)+'px');
	}
	
	
	//$("[data-toggle='tooltip']").tooltip();
	//$("[data-toggle='popover']").popover();
	
	$('#profi_search_inner_catalog').on('click', function(){
		$('#catalog_popup').fadeToggle();
	});
		
	/*
	$('#profi_search_inner_catalog').hover(
		function(){$('#catalog_popup').stop(true,true).fadeIn();},
		function(){$('#catalog_popup').stop(true,true).fadeOut();}
	);
	*/
	
	$('#header_phone').hover(
		function(){$('#header_phone__popup').stop(true,true).fadeIn();},
		function(){$('#header_phone__popup').stop(true,true).fadeOut();}
	);
	
	$('#currency_select__usd').hover(
		function(){$('#currency_select__popup').stop(true,true).fadeIn();},
		function(){$('#currency_select__popup').stop(true,true).fadeOut();}
	);
	
	$('.autorization_h__login').hover(
		function(){$('#in_profile__popup').stop(true,true).fadeIn();},
		function(){$('#in_profile__popup').stop(true,true).fadeOut();}
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
	
	$('.profi_search_regions__item .region-name').on('click', function (e) {
		$('#profi_search_inner_regions__active').html($(this).html());
		$('#profi_search_inner_regions__list_cnt').fadeToggle(10);
		$('html, body').animate({
			scrollTop: 0
		}, 1000);
		
		
		//подстраиваем ширину инпута для поиска
		if($("div").is(".profi_search_inner__inputbox_cnt")) {
			$('.profi_search_inner__inputbox').css('width', ($('.profi_search_inner__inputbox_cnt').width() - $(this).width() - 40)+'px');
		} else {
			$('.profi_search_tab_1__inputbox').css('width', ($('.profi_search_tab_1__cnt').width() - $(this).width() - 305)+'px');
		}
        return false;
    });
	
	/*
	$('.profi_search_regions__item .region-ico').on('click', function (e) {

		$(this).html());
    });
	*/
	
    $('#profi_search_regions__active').on('click', function (e) {
		$('#profi_search_regions__list_cnt').fadeToggle();
        return false;
    });
	
    /*
	$('.profi_search_tab_1_regions__item a').on('click', function (e) {
		$('#profi_search_tab_1_regions__active').html($(this).html());
		$('#profi_search_tab_1_regions__list_cnt').fadeToggle();
        return false;
    });
	*/
	
	$('.header_regions__item .region-name').on('click', function(e){
		$('#region_id').val($(this).data('region'));
		$('#header_regions__list_cnt').fadeToggle();
		$('#set-region-frm').submit();
	});
	
	$('.header_regions__item .region-ico, .profi_search_regions__item .region-ico').on('click', function(e){
		$(this).parent().parent().find('ul').slideToggle(50);
		$(this).toggleClass('active');
	});
	
	$('#profi_search_regions__list_cnt .region-name').on('click', function(e){
		$('#profi_search_region_id').val($(this).data('region'));
		$('#profi_search_regions__active').text($(this).text());
		$('#profi_search_regions__list_cnt').fadeToggle();
		
		$('#profi_search_regions__list_cnt a').removeClass('profi_search_regions__item_active');
		$(this).addClass('profi_search_regions__item_active');
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
	
	$('.orders-sort-cnt').on('click', 'a', function(e){
		//console.log($(this).data('category'));
		$('#orders-sort-sw #orderby').val($(this).data('sort'));
		$('#orders-sort-sw').submit();
		return false;
	});
	
	$('.category-list-cnt').on('click', '.catalog-category-list-item__reviews', function(e){
		var examples = $(this).parent().parent().parent().parent().parent().find('.catalog-category-list-examples'),
			reviews = $(this).parent().parent().parent().parent().parent().find('.catalog-category-list-reviews');
		
		e.preventDefault();
		if(examples.is(':visible'))
			examples.slideUp(100);
		
		reviews.slideToggle(200);
		return false;
	});
	
	$('.category-list-cnt').on('click', '.catalog-category-list-item__examples', function(e){
		var examples = $(this).parent().parent().parent().parent().parent().find('.catalog-category-list-examples'),
			reviews = $(this).parent().parent().parent().parent().parent().find('.catalog-category-list-reviews');
		
		e.preventDefault();
		if(reviews.is(':visible'))
			reviews.slideUp(100);
		
		examples.slideToggle(200);

		return false;
	});
	
	$('.category-list-cnt').on('click', '.catalog-category-list-popup__close', function(e){
		var block = $(this).parent();
		
		e.preventDefault();
		
		block.slideToggle(200);

		return false;
	});
	
	
	//заказ подбора спеиалиста
    $('.contact-to-spec').on('click', function (e) {
        var url = $(this).data('contact')+"?modal=1",
            modal = $('.modal');
		
		spec_name = $(this).data('spec');
		spec_id = parseInt($(this).data('spec_id'));
		
        $.get(url, function (data) {
            modal.html(data).modal('show');
			modal.find('#zakazspec1-comment').val(spec_name);
			modal.find('#zakazspec1-user_id').val(spec_id);
			modal.find('#zakazspec1-spec_name').val(spec_name);
			modal.find('.phone-input').mask(phone_mask);
        });
        return false;
    });
	
	
    $('.profi_search_tab__zakaz').on('click', '#send-zayavka', function () {
        var form = $(this).closest('form'),
            modal = $('.modal');
        $.post(
            form.attr('action'),
            form.serialize(),
            function (data) {
				modal.html(data).modal('show');
				$('.modal').find('.phone-input').mask(phone_mask);
            }
        );
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
	
	//добавление отзыва
    $('#add_review').on('click', function (e) {
		e.preventDefault();
        var url = $(this).data('review')+"?modal=1",
            modal = $('.modal');
		
        $.get(url, function (data) {
            modal.html(data).modal('show');
			
			$(".modal").find('select').styler();
			init_upload_reviewfoto();
			upload_reviewfoto_item_num = getImageNum('uploading-reviewfoto-list');
			$(".modal #addreviewform-phone").bind('paste', function(e) {
				getSpecList();
			});
			$('.modal').find('.phone-input').mask(phone_mask);
			
        });
        return false;
    });
	
	
    $('.modal').on('keyup', '#addreviewform-phone', function () {
		getSpecList();
    });
	
	
    $('.modal').on('click', '#send-new-review', function () {
        var form = $(this).closest('form'),
            modal = $('.modal');
        $.post(
            form.attr('action'),
            form.serialize(),
            function (data) {
				modal.children('.modal-dialog').remove();
				modal.append(data);
				
				init_upload_reviewfoto();
				upload_reviewfoto_item_num = getImageNum('uploading-reviewfoto-list');
				
            }
        );
        return false;
    });
	
    $('.profile-page').on('click', '.add-answer', function (e) {
        var url = $(this).data('answer')+"?modal=1",
            modal = $('.modal');
		
        $.get(url, function (data) {
            modal.html(data).modal('show');
        });
        return false;
    });
	
    $('#profi_search_input').on('keyup', function () {		
        var form = $(this).closest('form');
		
		if($(this).val().length > 2)
        $.get(
            form.attr('action'),
            form.serialize(),
            function (data) {
				$('#search-result-cnt').html(data);
				$('#search-result-cnt').show();
            }
        );
    });
	
	$('#profi_search_frm').on('submit', function(){
		if($('#profi_search_input').val() == '') {
			return false
		} else {
			$('#profi_search_modal').val(0);
		}
	});
	
    $('#zayavka-one-click').on('click', function (e) {
        var url = $(this).data('review')+"?modal=1",
            modal = $('.modal');
		
        $.get(url, function (data) {
            modal.html(data).modal('show');
        });
        return false;
    });
	
	$('#activity-btn').on('click', function(e){
		$('#activity').val($(this).data('active'));
		$('#set-activity-frm').submit();
	});
	
	$('#activity-btn').hover(
		function(){$('#profile_header__popup').stop(true,true).fadeIn();},
		function(){$('#profile_header__popup').stop(true,true).fadeOut();}
	);
	
	$(document).click(function(event) {
		if ($(event.target).closest("#header_regions__list_cnt, #profi_search_inner_catalog, #profi_search_regions__list_cnt").length) return;
		
		if($("#header_regions__list_cnt").is(':visible'))
		   $("#header_regions__list_cnt").fadeOut("fast");
		
		if($("#catalog_popup").is(':visible'))
		   $("#catalog_popup").fadeOut("fast");
		
		if($("#profi_search_regions__list_cnt").is(':visible'))
		   $("#profi_search_regions__list_cnt").fadeOut("fast");
		
		event.stopPropagation();
	});	
	
});


$(window).load(function(){
	
	
	function setHeight(blocks)
	{
		var height_block = 0;
		
		$(blocks).each(function(){
			if($(this).height() > height_block) height_block = $(this).height();
		});

		$(blocks).css('height', (height_block + 'px'));
		
	}
	
	setHeight('.catalog-item__related_item_cnt .related_item__name');
	setHeight('.catalog-item__related_item_cnt');
	
	
//	$('.catalog-item__related_item_cnt .related_item__r1').each(function(){
//		if($(this).height() > height_block) height_block = $(this).height();
//	});
//	
//	$('.catalog-item__related_item_cnt .related_item__r1').css('height', (height_block + 'px'));
//	
//	height_block = 0;
//	
//	$('.catalog-item__related_item_cnt').each(function(){
//		if($(this).height() > height_block) height_block = $(this).height();
//	});
//	
//	$('.catalog-item__related_item_cnt').css('height', (height_block + 'px'));
})
