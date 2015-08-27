jQuery(function($) {
	
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
					//$(pItems[i]).toggleClass('no-foto');
					//$(pItems[i+1]).toggleClass('no-foto');
				}
			}
		}
	}
	
	
	var upload_award_item_num = getImageNum('uploading-awards-list'),
		upload_example_item_num = getImageNum('uploading-examples-list'),
		clicked_el = null;
	
	//console.log(upload_award_item_num);
	//console.log(upload_example_item_num);
	
	
	var upload_price = new AjaxUpload('#upload-price-btn', {
		action: '/ajax/upload-price',
		name: 'UploadPriceForm[imageFiles]',
		onSubmit : function(file, extension){
			$("#loading-price").show();
			$('#loading-price-errormes').html('');
			upload_price.setData({'file': file});
		},
		onComplete : function(file, response){
			$("#loading-price").hide();
			
			response = $.parseJSON(response);
			
			if(response.res == 'ok') {
				$("#loading-price-success").show();
				$("#loading-price-success").append(response.filename);
			} else {
				for (var i = 0; i < response.msg.length; i++) {
				   $('#loading-price-errormes').append(response.msg[i]);
				}
			}
		}
	});

	$('#set-weekend-frm').on('submit', function() {
		var dates = ['13-07-2015', '15.07.2015'],
			dates_d = [],
			dates_n = [],
			i = 0;
		
		//$('#weekend-input').parent().datepicker('setDates', ['13-07-2015', '15.07.2015']);
		//return false;
		
		dates_d = $('#weekend-input').parent().datepicker('getDates');
		//console.log(dates_d);
		

		for(i = 0; i < dates_d.length; i++)	{
			dates_n.push(dates_d[i].format("yyyy-mm-dd"));
		}
		//console.log(dates_n.join(';'));
		$('#setweekendform-weekends').val(dates_n.join(';'));
		//console.log($('#setweekendform-weekends').val());
		//return false;
	});
	
	$('#set-call-time-frm').on('submit', function() {
		var allOk = false;
		
		$('#profile-time-error-cnt').hide();
		
		if(parseInt($('#calltimeform-call_to').val()) > parseInt($('#calltimeform-call_from').val())) {
			allOk = true;
		} else {
			$('#profile-time-error-cnt').show();
		}
		
		return allOk

	});
	
	
	$('#site-reg-step2-frm, #anketa-frm').on('submit', function() {
		var allOk = false,
			check_presents = false;
		
		$(".field-regstep2form-category1").removeClass('has-error');
		$(".field-regstep2form-category1 .help-block").text('');
		$("#regions-cnt .categories-block-error").text('');
		
		
		
		
		$('#regions-cnt > .region-row').each(function(){
			if($(this).find('select').val() != 0) {
				allOk = true;
				if ($(this).find('input[type="text"]').val() == '') $(this).find('input[type="text"]').val('1');
			}
		});
		
		if(allOk === false)	{
			$('#regions-cnt').prepend('<span class="categories-block-error small">Укажите город и ценовой коэффициент.</span>');
			$('html, body').animate({
				scrollTop: $("#regions-cnt").offset().top
			}, 1000);
			return false;
		}
		
		
		$('.categories-block').each(function(){
			if($(this).is(':visible')) {
				$(this).find('.categories-block-error').remove();
				
				$(this).find('.reg-step2-category').each(function(){
					if($(this).prop('checked')) allOk = true;
				});
				
				if(allOk === false)	{
					$(this).prepend('<span class="categories-block-error small">Отметьте выполняемые услуги</span>')
				} else {
					$(this).find('.reg-step2-category').each(function(){
						
						if($(this).prop('checked')) {
							check_presents = false;
							$(this).parent().parent().next('ul').children('li').each(function(){
								$(this).removeClass('has-error');
								if($(this).find('input:checkbox').prop('checked')) {
									check_presents = true;
									allOk = true;
									/*
									if($(this).find('input:text').val() == '') {
										allOk = false;
										$(this).addClass('has-error');
									}
									*/
								} else {
									/*
									if($(this).find('input:text').val() != '') {
										allOk = false;
										check_presents = false;
										$(this).addClass('has-error');
									}
									*/
								}
							});
						}
					});
					if(check_presents == false)	{
						$(this).prepend('<span class="categories-block-error small">Укажите выполняемые услуги</span>')
						allOk = false;
					} else if(allOk === false)	{
						$(this).prepend('<span class="categories-block-error small">Укажите цены на выполняемые услуги</span>')
					}
				}
			}
		});
				
		//return false;
		console.log(allOk);
		console.log($('#regstep2form-category1').val());
		if(allOk === false)	{
			if($('#regstep2form-category1').val() == '') {
				$(".field-regstep2form-category1").addClass('has-error');
				$(".field-regstep2form-category1 .help-block").text('Выберите услуги');
				$('html, body').animate({
					scrollTop: $(".field-regstep2form-category1").offset().top
				}, 1000);
				
			} else {
				$('html, body').animate({
					scrollTop: $("#category-block-2").offset().top
				}, 1000);
				
			}
			
			
			return false;
		}	else	{
			return true;
		}
	});
	
	
	var upload_awards = new AjaxUpload('#upload-awards-btn', {
		action: '/ajax/upload-awards',
		name: 'UploadAwardsForm[imageFiles]',
		onSubmit : function(file, extension){
			$("#loading-awards").show();
			$('#loading-awards-errormes').html('');
			upload_awards.setData({'file': file});
		},
		onComplete : function(file, response){
			$("#loading-awards").hide();
			
			response = $.parseJSON(response);

			if(response.res == 'ok') {
				$('#uploading-awards-list .item-' + upload_award_item_num).html(response.html_file + response.html_file_remove + response.filename);
				$('#uploading-awards-list .item-' + upload_award_item_num).toggleClass('no-foto');
				upload_award_item_num++;
				if(upload_award_item_num > 9)	$('#upload-awards-btn').css('visibility', 'hidden');
			} else {
				for (var i = 0; i < response.msg.length; i++) {
				   $('#loading-awards-errormes').append(response.msg[i]);
				}
			}
		}
	});
	
	var upload_avatar = new AjaxUpload('#upload-avatar-btn', {
		action: '/ajax/upload-avatar',
		name: 'UploadAvatarForm[imageFiles]',
		onSubmit : function(file, extension){
			$("#loading-avatar").show();
			$('#loading-avatar-errormes').html('');
			upload_avatar.setData({'file': file});
		},
		onComplete : function(file, response){
			$("#loading-avatar").hide();
			
			response = $.parseJSON(response);

			if(response.res == 'ok') {
				$('#avatar-cnt').html(response.html_file + response.filename);
				
			} else {
				for (var i = 0; i < response.msg.length; i++) {
				   $('#loading-avatar-errormes').append(response.msg[i]);
				}
			}
		}
	});
	
	var upload_examples = new AjaxUpload('#upload-examples-btn', {
		action: '/ajax/upload-examples',
		name: 'UploadExamplesForm[imageFiles]',
		onSubmit : function(file, extension){
			$("#loading-examples").show();
			$('#loading-examples-errormes').html('');
			upload_awards.setData({'file': file});
		},
		onComplete : function(file, response){
			$("#loading-examples").hide();
			
			response = $.parseJSON(response);

			if(response.res == 'ok') {
				$('#uploading-examples-list .item-' + upload_example_item_num).html(response.html_file + response.html_file_remove + response.filename);
				$('#uploading-examples-list .item-' + upload_example_item_num).toggleClass('no-foto');
				upload_example_item_num++;
				if(upload_example_item_num > 9)	$('#upload-examples-btn').css('visibility', 'hidden');
			} else {
				for (var i = 0; i < response.msg.length; i++) {
				   $('#loading-examples-errormes').append(response.msg[i]);
				}
			}
		}
	});
	
	
	
	$('#uploading-awards').on('click', '.remove-uploaded-file', function(e){
		e.preventDefault();
		$(this).parent().html($(this).parent().data('item'));
				
		reorderImages('uploading-awards-list');
		upload_award_item_num = getImageNum('uploading-awards-list');
		
		var pItems = $('#uploading-awards-list li');		
		$(pItems[upload_award_item_num-1]).toggleClass('no-foto');
		
		if(upload_award_item_num < 10)	$('#upload-examples-btn').css('visibility', 'visible');
		return false;
	});
	
	$('#uploading-examples-list').on('click', '.remove-uploaded-file', function(e){
		e.preventDefault();
		$(this).parent().html($(this).parent().data('item'));
		
		reorderImages('uploading-examples-list');
		upload_example_item_num = getImageNum('uploading-examples-list');

		var pItems = $('#uploading-examples-list li');		
		$(pItems[upload_example_item_num-1]).toggleClass('no-foto');
		
		if(upload_example_item_num < 10)	$('#upload-examples-btn').css('visibility', 'visible');
		return false;
	});
	
	$('#regions-wr').on('click', '.add_new_region', function(e){
		var to_block = $('#regions-cnt'),
			block = $('#region-row-f'),
			select = block.find('select'),
			selected_towns = [];
		
		e.preventDefault();
		
		to_block.find('select').each(function(){
			selected_towns.push(parseInt($(this).val()));
		});
		
		if(selected_towns.length == 1 && selected_towns[0] == 0)
			return false;
		
		//console.log(selected_towns);
		//console.log(selected_towns.join());
		
		$("#regions-cnt .categories-block-error").remove();
		
		$.ajax({
			type: 'post',				
			url: 'https://pro.team.by/ajax/getregionsdropdown',
			data: {ids :selected_towns.join(), form_name: $('#form_name').val()},
			//dataType: 'json',
			beforeSend: function(){ $('#adding-region').show(); },
			success: function(msg){
				$('#adding-region').hide();
				$('#regions-field-descr').show();
				to_block.append(msg);
				//to_block.find('.region-row:last-of-type .region-dd-cnt select').val(0);
				to_block.find('.region-row:last-of-type .region-dd-cnt select').styler();
				
				
				/*
				$(".modal").find('#addreviewform-user_id').remove();
				$(".modal").find('#addreviewform-user_id-styler').remove();
				$(".modal").find('.field-addreviewform-user_id').children('label').after(msg);
				$(".modal").find('select').styler();
				*/
				
			}
		});
		/*
		to_block.append('<div class="form-group row clearfix region-row">' + block.html() + '</div>');
		to_block.find('.region-row:last-of-type .region-dd-cnt').html('<select id="profileanketaform-regions" class="form-control" name="' + select.attr('name') + '">' + select.html() + '</select>');
		
		to_block.find('.region-row:last-of-type .region-dd-cnt select option').each(function(){
			for(var i=0; i<selected_towns.length; i++) {
				if(selected_towns[i] == parseInt($(this).attr('value')))
					$(this).remove();
			}
			
		});
		*/
		//to_block.find('.region-row:last-of-type .region-dd-cnt select').val(0);
		//to_block.find('.region-row:last-of-type .region-dd-cnt select').styler();
		

		/*
		block = to_block.find('.region-row:last-of-type select');
		block.attr('name', 'ProfileAnketaForm[ratios][]');
		
		*/
		//to_block.find('.region-row:last-of-type select').styler();
		return false;
	});
	
	
	$('#regions-wr').on('click', '.remove_region_row', function(e){
		e.preventDefault();
		$(this).parent().parent().remove();
		console.log($('#regions-wr select').length);
		if ($('#regions-wr select').length < 2)
			$('#regions-field-descr').hide();
		
		return false;
	});


	
	$('input.reg-step2-category').on('change', function(e){
		clicked_el = $(this);
		
		$(this).parent().parent().toggleClass('category-block-checked');
		if($(this).prop('checked')) {
			if($(".categories-block ul").is("#cnt-price-" + $(this).val())) {
				$(".categories-block ul").find("#cnt-price-" + $(this).val()).slideDown();
			} else {
				$.ajax({
					type: 'get',
					url: '/ajax/get-childrens/'+$(this).val(),
					data: {},
					dataType: 'html',
					beforeSend: function () {
					},
					success: function (msg) {
						clicked_el.parent().parent().parent().append(msg);
						clicked_el.parent().parent().parent().children('ul').find('input:checkbox').styler();
					}
				});
			}
		}	else	{
			$(".categories-block ul").find("#cnt-price-" + $(this).val()).slideUp();
		}
	});
	
	$('#selected_categories_cnt').on('click', '.site-reg-remove-price', function(e){
		$('#selected_categories_cnt').find('#usluga-price-' + $(this).data('category')).remove();
	});
	
	$('#site-reg-add-new-city').on('click', function(e){
		$('#regstep2form-region_name').val('');
		$('#site-reg-add-new-city-cnt').slideToggle();
		return false;
	});
	
	$('#regstep2form-category1, #profileanketaform-category1').on('change', function(e){
		$('.categories-block').each(function(){
			if($(this).is(':visible')) {
				$(this).find('input[type="checkbox"]').each(function(){
					$(this).prop('checked', false);
					//$(this).prop('checked', false).trigger('refresh');
				});
				$(this).hide();
			}
		});
		$('#selected_categories_cnt').html('');
		$('#selected_categories').hide();
		$('#category-block-' + $(this).val()).show();
	});
	
	$('#profile_delete_btn').on('click', function(e) {
		if(confirm('Вы действительно хотите удалить аккаунт?'))	{
			return true;
		} else {
			return false;
		}
		
	});
	
	$('#calltimeform-call_to').on('change', function(e){
		var call_to = parseInt($(this).val());
		
		console.log($(this).val());
		$('#calltimeform-call_from option').each(function(){
			console.log($(this).attr('value'));
			console.log(call_to);
			if((parseInt($(this).attr('value'))) > call_to) {
				$(this).remove();
			}
				
		})
		$('#calltimeform-call_from').styler();
	});
	
	//
    $('#offer-service').on('click', function (e) {
		e.preventDefault();
        var url = $(this).data('url'),
            modal = $('.modal');
		
        $.get(url, function (data) {
			//console.log(data);
			//data = data.replace('/site/', 'team.by/site/');
			
            modal.html(data);
			//console.log();
			modal.find('#offerservicesform-verifycode-image').attr('src', ('https://team.by' + modal.find('#offerservicesform-verifycode-image').attr('src')));
			modal.modal('show');
        });
        return false;
    });
	
});