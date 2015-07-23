$(document).ready(function () {
	'use strict';
	
	$('.bs-switch').bootstrapSwitch();
	
	$('#orderform-client_id').on('change', function(){
		if($(this).val() != 0) {
			$('#add-new-client .form-control').each(function(){
				$(this).val('');
				$(this).prop('disabled', true);
			});
		} else {
			$('#add-new-client .form-control').each(function(){
				$(this).prop('disabled', false);
			});
		}
	})
});