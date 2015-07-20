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
		//console.log ($("#setweekendform-weekedns").datepicker("getDate"));
		$('#setweekendform-weekedns').datepicker('show');
		//$('#setweekendform-weekedns').click();
		//console.log $("#etweekendform-weekedns").datepicker("setDate", new Date)
		return false;
	});
	
	
	$('#site-reg-step2-frm, #anketa-frm').on('submit', function() {
		var allOk = false,
			check_presents = false;
		
		$('.categories-block').each(function(){
			if($(this).is(':visible')) {
				$(this).find('.categories-block-error').remove();
				
				$(this).find('.reg-step2-category').each(function(){
					if($(this).prop('checked')) allOk = true;
				});
				
				if(allOk === false)	{
					$(this).append('<span class="categories-block-error small">Отметьте выполняемые услуги</span>')
				} else {
					$(this).find('.reg-step2-category').each(function(){
						
						if($(this).prop('checked')) {
							check_presents = false;
							$(this).parent().parent().next('ul').children('li').each(function(){
								$(this).removeClass('has-error');
								if($(this).find('input:checkbox').prop('checked')) {
									check_presents = true;
									if($(this).find('input:text').val() == '') {
										allOk = false;
										$(this).addClass('has-error');
									}
								} else {
									if($(this).find('input:text').val() != '') {
										allOk = false;
										check_presents = false;
										$(this).addClass('has-error');
									}									
								}
							});
						}
					});
					if(check_presents == false)	{
						$(this).append('<span class="categories-block-error small">Укажите выполняемые услуги</span>')
						allOk = false;
					} else if(allOk === false)	{
						$(this).append('<span class="categories-block-error small">Укажите цены на выполняемые услуги</span>')
					}
				}
			}
		});
				
		//return false;
		if(allOk === false)	{
			$('html, body').animate({
				scrollTop: $("#category-block-2").offset().top
			}, 1000);
			
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
	
	

	
	$('input.reg-step2-category').on('change', function(e){
		clicked_el = $(this);
		
		$(this).parent().parent().toggleClass('category-block-checked');
		if($(this).prop('checked')) {
			if($("#category-block-2 ul").is("#cnt-price-" + $(this).val())) {
				$("#category-block-2 ul").find("#cnt-price-" + $(this).val()).slideDown();
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
			$("#category-block-2 ul").find("#cnt-price-" + $(this).val()).slideUp();
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
	
	$('#profile_delete_btn').on('click', function(e) {
		if(confirm('Вы действительно хотите удалить аккаунт?'))	{
			return true;
		} else {
			return false;
		}
		
	});
	
	$('#activity-btn').on('click', function(e){
		$('#activity').val($(this).data('active'));
		$('#set-activity-frm').submit();
	});
	/*
	$('.profile__tabs .nav-tabs a').on('click', function(e){
		//if($(this).attr('href') == '#w0-tab2') $('#setweekendform-weekedns').datepicker('show');
		if($(this).attr('href') == '#w0-tab2') $('#set-weekend-frm').submit();;
	});
	*/
	/*
	$('.profile__tabs .nav-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		if($(this).attr('href') == '#w0-tab2') {
			$('#w0').datepicker('show');
			$('#setweekendform-weekedns').click();
			//$('#w0').datepicker('update');
		}
		//if($(this).attr('href') == '#w0-tab2') $('#setweekendform-weekedns').click;
	  //e.target // newly activated tab
	  //e.relatedTarget // previous active tab
	});
	*/
	/*
	$('input[name="Test"]').on('change', function(e) {
		console.log($(this).val());
		
	});
	*/
	$('input[name="Test"]').parent().datepicker().on('changeDate', function(e){
       	console.log(e.date.getDate());
       	console.log(e.date.getFullYear());
       	console.log((e.date.getMonth()+1));
		//console.log($('input[name="Test"]').val());
    });
	
	
});