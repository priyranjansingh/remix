$(document).ready(function() {				
		
	//Owl Slider
	/*$('.home-slider').owlCarousel({
	loop:true,	
    animateOut: 'fadeOut',
    items:1,
	autoplay:true,
	nav:true,
	dots:false,
	navText: [ '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ],
	autoplayTimeout:5000
	});
*/

	$('.av_tab span').click(function(){
		$('.av_tab span').removeClass('active');
		$(this).addClass('active');
	});

	$('.sub_top li a').click(function(){
		$('.sub_top li a').removeClass('select');
		$(this).addClass('select');
	});

	$('.togg_menu').click(function(){
		$('.h_menu').slideToggle();
	});
	
	$(document).on('click', '.h_menu li .sub', function(){
		$(this).next('.sub_menu').slideToggle();
		return false;
	});
	
	
	menu();
}); // Document ready Close



function menu(){
	if($(window).width() > 599){
		$('.h_menu').removeAttr('style');	
		$('.sub_menu').removeAttr('style');
		$('.sub_menu').prev('a').removeClass('sub');
	}else{
		
		$('.sub_menu').prev('a').addClass('sub');
	}	
}

$(window).resize(function(e) {
    menu();
	
});









