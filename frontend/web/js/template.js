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
	
});
