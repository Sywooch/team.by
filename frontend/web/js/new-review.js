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
	
	
	var upload_award_item_num = getImageNum('uploading-awards-list'),
		clicked_el = null;
		
	var upload_reviewfoto = new AjaxUpload('#upload-reviewfoto-btn', {
		action: '/ajax/upload-reviewfoto',
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
				$('#uploading-reviewfoto-list .item-' + upload_award_item_num).html(response.html_file + response.html_file_remove + response.filename);
				$('#uploading-reviewfoto-list .item-' + upload_award_item_num).toggleClass('no-foto');
				upload_award_item_num++;
				if(upload_award_item_num > 9)	$('#upload-reviewfoto-btn').css('visibility', 'hidden');
			} else {
				for (var i = 0; i < response.msg.length; i++) {
				   $('#loading-reviewfoto-errormes').append(response.msg[i]);
				}
			}
		}
	});
	
});