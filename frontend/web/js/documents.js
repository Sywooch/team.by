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
	
	
	var upload_other_file_item_num = getImageNum('uploading-other-file-list'),
		//upload_example_item_num = getImageNum('uploading-examples-list'),
		clicked_el = null;
		
	
	var upload_passport_file = new AjaxUpload('#upload-passport-file-btn', {
		action: '/ajax/upload-passport-file',
		name: 'UploadPassportForm[imageFiles]',
		onSubmit : function(file, extension){
			$("#loading-passport-file").show();
			$('#loading-passport-file-errormes').html('');
			upload_passport_file.setData({'file': file});
			$("#loading-passport-file-success").hide();
			$("#loading-passport-file-success").find('input[type="hidden"]').remove();
		},
		onComplete : function(file, response){
			$("#loading-passport-file").hide();
			
			response = $.parseJSON(response);
			
			if(response.res == 'ok') {
				$("#loading-passport-file-success").show();
				$("#loading-passport-file-success").append(response.filename);
			} else {
				for (var i = 0; i < response.msg.length; i++) {
				   $('#loading-passport-file-errormes').append(response.msg[i]);
				}
			}
		}
	});

	var upload_trud_book_file = new AjaxUpload('#upload-book-file-btn', {
		action: '/ajax/upload-book-file',
		name: 'UploadBookForm[imageFiles]',
		onSubmit : function(file, extension){
			$("#loading-book-file").show();
			$('#loading-book-file-errormes').html('');
			upload_trud_book_file.setData({'file': file});
			$("#loading-book-file-success").hide();
			$("#loading-book-file-success").find('input[type="hidden"]').remove();
		},
		onComplete : function(file, response){
			$("#loading-book-file").hide();
			
			response = $.parseJSON(response);
			
			if(response.res == 'ok') {
				$("#loading-book-file-success").show();
				$("#loading-book-file-success").append(response.filename);
			} else {
				for (var i = 0; i < response.msg.length; i++) {
				   $('#loading-book-file-errormes').append(response.msg[i]);
				}
			}
		}
	});

	var upload_diplom_file = new AjaxUpload('#upload-diplom-file-btn', {
		action: '/ajax/upload-diplom-file',
		name: 'UploadDiplomForm[imageFiles]',
		onSubmit : function(file, extension){
			$("#loading-diplom-file").show();
			$('#loading-diplom-file-errormes').html('');
			upload_diplom_file.setData({'file': file});
			$("#loading-diplom-file-success").hide();
			$("#loading-diplom-file-success").find('input[type="hidden"]').remove();
		},
		onComplete : function(file, response){
			$("#loading-diplom-file").hide();
			
			response = $.parseJSON(response);
			
			if(response.res == 'ok') {
				$("#loading-diplom-file-success").show();
				$("#loading-diplom-file-success").append(response.filename);
			} else {
				for (var i = 0; i < response.msg.length; i++) {
				   $('#loading-diplom-file-errormes').append(response.msg[i]);
				}
			}
		}
	});

	
	var upload_other_file = new AjaxUpload('#upload-other-file-btn', {
		action: '/ajax/upload-documents-other',
		name: 'UploadDocumentsOtherForm[imageFiles]',
		onSubmit : function(file, extension){
			$("#loading-other-file").show();
			$('#loading-other-file-errormes').html('');
			upload_other_file.setData({'file': file});
		},
		onComplete : function(file, response){
			$("#loading-other-file").hide();
			
			response = $.parseJSON(response);

			if(response.res == 'ok') {
				$('#uploading-other-file-list .item-' + upload_other_file_item_num).html(response.html_file + response.html_file_remove + response.filename);
				$('#uploading-other-file-list .item-' + upload_other_file_item_num).toggleClass('no-foto');
				upload_other_file_item_num++;
				if(upload_other_file_item_num > 9)	$('#upload-other-file-btn').css('visibility', 'hidden');
			} else {
				for (var i = 0; i < response.msg.length; i++) {
				   $('#loading-other-file-errormes').append(response.msg[i]);
				}
			}
		}
	});
	
	$('#uploading-other-file').on('click', '.remove-uploaded-file', function(e){
		e.preventDefault();
		$(this).parent().html($(this).parent().data('item'));
				
		reorderImages('uploading-other-file-list');
		upload_other_file_item_num = getImageNum('uploading-other-file-list');
		
		var pItems = $('#uploading-other-file-list li');		
		$(pItems[upload_other_file_item_num - 1]).toggleClass('no-foto');
		
		if(upload_other_file_item_num < 10)	$('#upload-other-file-btn').css('visibility', 'visible');
		return false;
	});
	
	
});