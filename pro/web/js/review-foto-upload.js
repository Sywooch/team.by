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
				}
			}
		}
	}
	
	
	var upload_review_item_num = getImageNum('uploading-review-foto-list'),
		clicked_el = null;
	
	var upload_review_foto = new AjaxUpload('#upload-review-foto-btn', {
		action: '/ajax/upload-review-foto',
		name: 'UploadReviewsFotoForm[imageFiles]',
		onSubmit : function(file, extension){
			$("#loading-review-foto").show();
			$('#loading-review-foto-errormes').html('');
			upload_review_foto.setData({'file': file});
		},
		onComplete : function(file, response){
			$("#loading-review-foto").hide();
			
			response = $.parseJSON(response);

			if(response.res == 'ok') {
				$('#uploading-review-foto-list .item-' + upload_review_item_num).html(response.html_file + response.html_file_remove + response.filename);
				$('#uploading-review-foto-list .item-' + upload_review_item_num).toggleClass('no-foto');
				upload_review_item_num++;
				if(upload_review_item_num > 9)	$('#upload-review-foto-btn').css('visibility', 'hidden');
			} else {
				for (var i = 0; i < response.msg.length; i++) {
				   $('#loading-review-foto-errormes').append(response.msg[i]);
				}
			}
		}
	});
	
	$('#uploading-review-foto').on('click', '.remove-uploaded-file', function(e){
		e.preventDefault();
		$(this).parent().html($(this).parent().data('item'));
				
		reorderImages('uploading-awards-list');
		upload_review_item_num = getImageNum('uploading-review-foto-list');
		
		var pItems = $('#uploading-review-foto-list li');		
		$(pItems[upload_review_item_num-1]).toggleClass('no-foto');
		
		if(upload_review_item_num < 10)	$('#upload-review-foto-btn').css('visibility', 'visible');
		return false;
	});
	
});
