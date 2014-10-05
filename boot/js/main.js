var $ = jQuery.noConflict();


//BLACK & WHITE HOVER EFFECT--------------------------------------
$(window).load(function(){
    $('.bw-wrapper').BlackAndWhite({
        hoverEffect : true, // default true
        speed: { //this property could also be just speed: value for both fadeIn and fadeOut
            fadeIn: 200, // 200ms for fadeIn animations
            fadeOut: 300 // 800ms for fadeOut animations
        }
    });
});	

//CAROUSEL--------------------------------------------------------

(function($){
	$(document).ready(function(){

// Add classes for other carousels
var $carousel = $('.latest-work-jc, .latest-posts-jc, .testimonials-jc');

var scrollCount;

function adjustScrollCount() {
	if( $(window).width() < 768 ) {
		scrollCount = 1;
	} else {
		scrollCount = 1;
	}

}

function adjustCarouselHeight() {

	$carousel.each(function() {
		var $this    = $(this);
		var maxHeight = -1;
		$this.find('li').each(function() {
			maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
		});
		$this.height(maxHeight);
	});
}
function initCarousel() {
	adjustCarouselHeight();
	adjustScrollCount();
	var i = 0;
	var g = {};
	$carousel.each(function() {
		i++;

		var $this = $(this);
		g[i] = $this.jcarousel({
			animation           : 500,
			scroll              : scrollCount,
			wrap: 'circular'
		});
		$this.jcarousel('scroll', 0);
		 $this.prev().find('.jcarousel-prev').bind('active.jcarouselcontrol', function() {
			$(this).addClass('active');
		}).bind('inactive.jcarouselcontrol', function() {
			$(this).removeClass('active');
		}).jcarouselControl({
			target: '-='+scrollCount,
			carousel: g[i]
		});

		$this.prev().find('.jcarousel-next').bind('active.jcarouselcontrol', function() {
			$(this).addClass('active');
		}).bind('inactive.jcarouselcontrol', function() {
			$(this).removeClass('active');
		}).jcarouselControl({
			target: '+='+scrollCount,
			carousel: g[i]
		});

		$this.touchwipe({
		wipeLeft: function() {
			$this.jcarousel('scroll','+='+scrollCount);
		},
		wipeRight: function() {
			$this.jcarousel('scroll','-='+scrollCount);
		}
	});

	});
}
$(window).load(function(){
	initCarousel();
});

});

})(this.jQuery);

/**
 * jQuery Plugin to obtain touch gestures from iPhone, iPod Touch and iPad, should also work with Android mobile phones (not tested yet!)
 * Common usage: wipe images (left and right to show the previous or next image)
 *
 * @author Andreas Waltl, netCU Internetagentur (http://www.netcu.de)
 * @version 1.1.1 (9th December 2010) - fix bug (older IE's had problems)
 * @version 1.1 (1st September 2010) - support wipe up and wipe down
 * @version 1.0 (15th July 2010)
 */
(function($){$.fn.touchwipe=function(settings){var config={min_move_x:20,min_move_y:20,wipeLeft:function(){},wipeRight:function(){},wipeUp:function(){},wipeDown:function(){},preventDefaultEvents:true};if(settings)$.extend(config,settings);this.each(function(){var startX;var startY;var isMoving=false;function cancelTouch(){this.removeEventListener('touchmove',onTouchMove);startX=null;isMoving=false}function onTouchMove(e){if(config.preventDefaultEvents){e.preventDefault()}if(isMoving){var x=e.touches[0].pageX;var y=e.touches[0].pageY;var dx=startX-x;var dy=startY-y;if(Math.abs(dx)>=config.min_move_x){cancelTouch();if(dx>0){config.wipeLeft()}else{config.wipeRight()}}else if(Math.abs(dy)>=config.min_move_y){cancelTouch();if(dy>0){config.wipeDown()}else{config.wipeUp()}}}}function onTouchStart(e){if(e.touches.length==1){startX=e.touches[0].pageX;startY=e.touches[0].pageY;isMoving=true;this.addEventListener('touchmove',onTouchMove,false)}}if('ontouchstart'in document.documentElement){this.addEventListener('touchstart',onTouchStart,false)}});return this}})(jQuery);