jQuery(function($) {
	var upload_award_item_num = 1,
		upload_example_item_num = 1;
	
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

	$('#site-reg-step2-frm').on('submit', function(){
		var allOk = false,
			check_presents = false;
		//console.log('12111');
		
		$('.categories-block').each(function(){
			if($(this).is(':visible')) {
				$(this).find('.categories-block-error').remove();
				
				$(this).find('.reg-step2-category').each(function(){
					if($(this).prop('checked')) allOk = true;
				});
				
				if(allOk === false)	{
					$(this).append('<span class="categories-block-error small">Отметьте выполняемые услуги</span>')
				}
				
				check_presents = true;
			}
		});
		
		if(allOk === true && $('#selected_categories').is(':visible'))	{
			
			allOk = true;
			
			$('#selected_categories_cnt').find('.selected_categories-block-error').remove();
			
			$('#selected_categories_cnt .form-control').each(function() {
				check_presents = true;
				
				if($(this).val() == '')	 allOk = false;
			});
			
			if(allOk === false)	{
				$('#selected_categories_cnt').append('<span class="selected_categories-block-error small">Укажите цены на выполняемые услуги</span>')
			}
			
		}
		
		if(check_presents == false)	allOk = true;
		
		console.log(allOk);
		
		//return false;
		if(allOk === false)	{
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
		upload_award_item_num--;
		if(upload_award_item_num < 9)	$('#upload-examples-btn').css('visibility', 'visible');
		return false;
	});
	
	$('#site-reg-step2-frm').on('click', '.remove-uploaded-file', function(e){
		e.preventDefault();
		$(this).parent().html($(this).parent().data('item'));
		upload_example_item_num--;
		if(upload_example_item_num < 9)	$('#upload-examples-btn').css('visibility', 'visible');
		return false;
	});
	
	
	/*
	$('.reg-step2-category').on('click', function(e){
		if($(this).prop('checked')) {
			$('#selected_categories_cnt').append('<div id="cnt-price-' + $(this).val()+'" class="form-group clearfix"><label for="price-' + $(this).val() + '" class="col-sm-5 control-label">' + $.trim($(this).parent().text())+'</label><div class="col-sm-6"><input type="text" name="RegStep2Form[price][' + $(this).val()+']" class="form-control" id="price-' + $(this).val() + '" placeholder="Укажите стоимость"></div><div class="col-sm-1"><span class="site-reg-remove-price" data-category="' + $(this).val() + '">×</span></div></div>');
		}	else	{
			$('#selected_categories_cnt').find('#cnt-price-' + $(this).val()).remove();
		}
		
		if($('#selected_categories').is(':hidden')) {
			$('#selected_categories').slideDown();
		}
			
	});
	*/
	$('.reg-step2-category').on('click', function(e){
		if($(this).prop('checked')) {
			//$('#selected_categories_cnt').append('<div id="cnt-price-' + $(this).val()+'" class="form-group clearfix"><label for="price-' + $(this).val() + '" class="col-sm-5 control-label">' + $.trim($(this).parent().text())+'</label><div class="col-sm-6"><input type="text" name="RegStep2Form[price][' + $(this).val()+']" class="form-control" id="price-' + $(this).val() + '" placeholder="Укажите стоимость"></div><div class="col-sm-1"><span class="site-reg-remove-price" data-category="' + $(this).val() + '">×</span></div></div>');
			
			$.ajax({
				type: 'get',
				url: '/ajax/get-childrens/'+$(this).val(),
				data: {},
				dataType: 'html',
				beforeSend: function () {
				},
				success: function (msg) {
					$('#selected_categories_cnt').append(msg);
					
					if($('#selected_categories').is(':hidden')) {
						$('#selected_categories').slideDown();
					}
					
				}
			});
			
		}	else	{
			$('#selected_categories_cnt').find('#cnt-price-' + $(this).val()).remove();
		}
		
			
	});
	
	/*
	$('#selected_categories_cnt').on('click', '.site-reg-remove-price', function(e){
		//console.log($(this).data('category'));
		$('#category-' + $(this).data('category')).prop('checked', false);
		$('#selected_categories_cnt').find('#cnt-price-' + $(this).data('category')).remove();
	});
	*/
	
	$('#selected_categories_cnt').on('click', '.site-reg-remove-price', function(e){
		//console.log($(this).data('category'));
		//$('#category-' + $(this).data('category')).prop('checked', false);
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
	
	
});