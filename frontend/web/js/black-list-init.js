$(window).load(function(){
	$('.wrap__cnt_black_list .catalog-category-list-item__avatar_cnt, .wrap__cnt_black_list .catalog-item__examples_item a, .wrap__cnt_black_list .reviews_item__foto_item a').BlackAndWhite({
		hoverEffect : false, // default true
		// set the path to BnWWorker.js for a superfast implementation
		webworkerPath : false,
		// this option works only on the modern browsers ( on IE lower than 9 it remains always 1)
		intensity:1,
//		speed: { //this property could also be just speed: value for both fadeIn and fadeOut
//	        fadeIn: 200, // 200ms for fadeIn animations
//	        fadeOut: 800 // 800ms for fadeOut animations
//	    }
	});
});