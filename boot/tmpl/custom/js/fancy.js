function loadSignIn() {
	if(status == 0) {
        $("html, body").animate({ scrollTop:"0px"}, 600);
		$("#sign-in-form").fadeIn(300);
		$("#background-on-popup").css("opacity", "0.7");
		$("#background-on-popup").fadeIn(300);
		status = 1;
	}
}

function loadRegister() {
	if(status == 0) {
        $("html, body").animate({ scrollTop: "0px" }, 600);
		$("#register-form").fadeIn(300);
		$("#background-on-popup").css("opacity", "0.7");
		$("#background-on-popup").fadeIn(300);
		status = 1;
	}
}

function loadDeposit() {
    if(status == 0) {
        $("#deposit-form").fadeIn(300);
        $("#background-on-popup").css("opacity", "0.7");
        $("#background-on-popup").fadeIn(300);
        status = 1;
    }
}

function loadWithdraw() {
    if(status == 0) {
        $("#withdraw-form").fadeIn(300);
        $("#background-on-popup").css("opacity", "0.7");
        $("#background-on-popup").fadeIn(300);
        status = 1;
    }
}

function loadForgot() {
    if(status == 0) {
        $("#forgot-form").fadeIn(300);
        $("#background-on-popup").css("opacity", "0.7");
        $("#background-on-popup").fadeIn(300);
        status = 1;
    }
}

function loadRepresentatives() {
    if(status == 0) {
        $("#representatives-form").fadeIn(300);
        $("#background-on-popup").css("opacity", "0.7");
        $("#background-on-popup").fadeIn(300);
        status = 1;
    }
}

function disablePopup() {
	if(status == 1) {
		$("#sign-in-form").fadeOut("normal");
		$("#register-form").fadeOut("normal");
        $("#forgot-form").fadeOut("normal");
        $("#deposit-form").fadeOut("normal");
        $("#withdraw-form").fadeOut("normal");
        $("#representatives-form").fadeOut("normal");
		$("#background-on-popup").fadeOut("normal");
		status = 0;
	}
}
var status;
$(document).ready(function() {

	status = 0;

	if (typeof errors != 'undefined' && errors)
	{
		switch(action)
		{
		case "representatives":
			loadRepresentatives();
			break;
		case "signin":
			loadSignIn();
			break;
		case "register":
			loadRegister();
			break;
		case "invest":
			loadDeposit();
			break;
		case "withdraw":
			loadWithdraw();
			break;
		case "forgot":
			loadForgot();
			break;
		}
	
	}

	$("#sign-in-button").click(function(e) {
        e.preventDefault();
		loadSignIn();  // function to display the sin in form
	});

	$("#sign-up-button").click(function(e) {
        e.preventDefault();
		loadRegister(); // function to display the register form
	});

    $("#deposit, .load-deposit").click(function(e) {
        e.preventDefault();
        loadDeposit(); // function to display the register form
    });

    $("#withdraw, .load-withdraw").click(function(e) {
        e.preventDefault();
        loadWithdraw(); // function to display the register form
    });

    $("#represent").click(function(e) {
        e.preventDefault();
        loadRepresentatives(); // function to display the register form
    });

	$("div.close").click(function(e) {
        e.preventDefault();
		disablePopup();  // function to close pop-up forms
	});

    $("#forgot").click(function(e) {
        $("#sign-in-form").fadeOut("normal", function() {
            status = 0;
            console.log(status);
            loadForgot();
        });
    });

    $("#back-to-login").click(function() {
        $("#forgot-form").fadeOut("normal", function() {
            status = 0;
            loadSignIn();
        });
    });

	$("#background-on-popup").click(function() {
		disablePopup();  // function to close pop-up forms
	});

	$(this).keyup(function(event) {
		if (event.which == 27) { // 27 is the code of the ESC key
			disablePopup();
		}
	});

	if (typeof $('#Accept').attr('checked') != 'undefined')	$('#checkbox').find('div').addClass("selected");
	else $('#checkbox').find('div').removeClass("selected");
	
	$("#checkbox .unchecked-state").click( // checkbox select event
		function(event) {
			$(this).parent().addClass("selected");
			$('#Accept').attr('checked', 'checked');
		}
	);
	
	$("#checkbox .checked-state").click( // checkbox deselect event
		function(event) {
			$(this).parent().removeClass("selected");
			$('#Accept').removeAttr('checked');
		}
	);

    $('#deposit-amount').keyup(function() {
        var val = $(this).val();
        var output = $('#deposit-plan');

        if (val > 3000) {
            output.text('WIND PLAN')
        } else if (val > 1000) {
            output.text('GEOTHERMAL PLAN')
        } else if (val > 300) {
            output.text('SOLAR PLAN')
        } else {
            output.text('BIOMASS PLAN')
        }
    });

    $('#from_acc').click(function() {
        $('#deposit-form .from_ps').hide();
        $('#deposit-form .from_acc').show();
    });

    $('#from_ps').click(function() {
        $('#deposit-form .from_acc').hide();
        $('#deposit-form .from_ps').show();
    });

    $.widget( "ui.pcntspinner", $.ui.spinner, {
        _format: function( value ) { return value + '%'; },

        _parse: function(value) { return parseInt(value, 10); }
    });

    $("#compound_spinner").pcntspinner({
        min: 0,
        max: 100,
        step: 10 });

    $("#compound_spinner").focus(function () {
        $(this).blur();
    });

});