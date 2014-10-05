$(document).ready(function(){
	//$('.formoid-metro-cyan').hide();
	$('.facebook').hide();
	$('.linkedin').hide();
	$('.github').hide();
	$('.mail').hide();
	//$('.formoid-metro-cyan').slideDown(2500, 'easeOutBounce');

	// $('#submit').on('click', function(e){
	// 	e.preventDefault();
	// 	var name = $('#name').val();
	// 	var email = $('#email').val();
	// 	var message = $('textarea#message').val();

	// 	$.ajax({
	// 	  type: "POST",
	// 	  url: "contact.php",
	// 	  data: { n: name, e: email, m: message }
	// 		})
	// 	  .done(function( msg ) {
	// 		$('.formoid-metro-cyan')[0].reset();
	// 	  	$('#message').modal();
	// 	});
	// });

	$(function(){
	  $(".element").typed({
	    strings: ["Welcome to my about page.", "I'm a software developer/web developer/software enthusiast.", "When I'm not writing software, I'm either playing tennis or in the gym.", "Want to get in touch? Click on any of the buttons below."],
	    typeSpeed: 10,
	    backDelay: 3000,
	    callback: function(){
	    	$('.facebook').show(); 
	    	$('.facebook').animate({opacity: 0.6}, 1500, 'swing');
	    	setTimeout(function(){$('.linkedin').show();$('.linkedin').animate({opacity: 0.6}, 1500, 'swing');}, 500);
	    	setTimeout(function(){$('.github').show();$('.github').animate({opacity: 0.6}, 1500, 'swing');}, 500 + 500);
	    	setTimeout(function(){$('.mail').show();$('.mail').animate({opacity: 0.6}, 1500, 'swing');}, 500 + 500 + 500);
	    }
	  });
	});

	var toggle = true;
	$('.facebook').on('hover', function() {
		var light = 0.6;
		if (toggle)
		{
			light = 1.0;
		}
		toggle = !toggle;
		$('.facebook').animate({opacity: light}, 250);
	});

	$('.linkedin').on('hover', function() {
		var light = 0.6;
		if (toggle)
		{
			light = 1.0;
		}
		toggle = !toggle;
		$('.linkedin').animate({opacity: light}, 250);
	});

	$('.github').on('hover', function() {
		var light = 0.6;
		if (toggle)
		{
			light = 1.0;
		}
		toggle = !toggle;
		$('.github').animate({opacity: light}, 250);
	});

	$('.mail').on('hover', function() {
		var light = 0.6;
		if (toggle)
		{
			light = 1.0;
		}
		toggle = !toggle;
		$('.mail').animate({opacity: light}, 250);
	});
});