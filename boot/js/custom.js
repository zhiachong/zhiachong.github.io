function checkform() {
    if (document.regform.fullname.value == '')
    {
        alert("Please enter your full name!");
        document.regform.fullname.focus();
        return false;
    }
    if (document.regform.username.value == '')
  {
    alert("Please enter your username!");
    document.regform.username.focus();
    return false;
  }
  if (document.regform.password.value == '')
  {
    alert("Please enter your password!");
    document.regform.password.focus();
    return false;
  }
  if (document.regform.password.value != document.regform.password2.value) 
  {
    alert("Please check your password!");
    document.regform.password2.focus();
    return false;
  }
  if (document.regform.email.value == '')
 {
    alert("Please enter your e-mail address!");
    document.regform.email.focus();
    return false;
  }
  if (document.regform.email.value != document.regform.email1.value)
  {
    alert("Please retupe your e-mail!");
    document.regform.email.focus();
    return false;
  }
  if (document.regform.agree.checked == false)
  {
    alert("You have to agree with the Terms and Conditions!");
    return false;
  }
  return true;
 }
function IsNumeric(sText)
{
  var ValidChars = "0123456789";
  var IsNumber=true;
  var Char;
  if (sText == '') return false;
  for (i = 0; i < sText.length && IsNumber == true; i++)
  { 
    Char = sText.charAt(i); 
    if (ValidChars.indexOf(Char) == -1) 
    {
      IsNumber = false;
    }
  }
  return IsNumber;
 }

function pageChecker()
{
  var page = $('.page').val();
  $('#'+page).attr('class', 'current');
}

function formChecker()
{

}

$(document).ready(
    function() {
        $('#reinvest').on('change', function() {
            if ($('#reinvest option:selected').text() != '')
            {
                $('#external').attr('name', '');
            }
        });

        $('#submit').on('click', function(e) {
            var run = false;
            if ($('#cEmail').val() == '')
            {
              $('#cEmailError').val('Please fill up your email address.');
              $('#cEmailError').attr('style', 'display: show; width: 200px;');
              $('#cEmailError').attr('disabled', 'disabled');
              $('#cEmail').css('border', '1px solid red');
              run = true;
            }

            if ($('#cMessage').val() == '')
            {
              $('#cMessageError').val('Please fill up your message.');
              $('#cMessageError').attr('style', 'display:show; width:200px;');
              $('#cMessageError').attr('disabled', 'disabled');
              $('#cMessage').css('border', '1px solid red');
              run = true;
            }
            if (run)
            {e.preventDefault();}
        });

        $('#editPassword').on('change', function(){
            var edit = $('#editPassword2').val();
            var pass2Elem = $('#editPassword2');
            if (edit === '')
            {
              pass2Elem.css('border', '1px solid red');
            }
            else
            {
              pass2Elem.css('border', '');
            }
        });

        var pass = true;
        $('#nameSubmit, #emailSubmit').on('change', function(){
            var name = $('#nameSubmit');
            var email = $('#emailSubmit');
            var nameFine = true;
            var emailFine = true;

            if (name.val() == '')
            {
              nameFine = false;
              name.css('border', '1px solid red');
            }
            else 
            {
              nameFine = true;
              name.css('border', '');
            }

            if (email.val() == '')
            {
              emailFine = false;
              email.css('border', '1px solid red');
            }
            else 
            {
              emailFine = true;
              email.css('border', '');
            }

            if (emailFine && nameFine)
            {
              pass = true;
            }
            else
            {
              pass = false;
            }
        });

        $('#editPassword2, #editPassword').on('change', function() {
          var pass1 = $('#editPassword').val();
          var pass2 = $('#editPassword2').val();
          
          var passV = $('#editPassword');
          var pass2V = $('#editPassword2');
          
          if (pass1 != pass2 || pass1.length < 6 || pass2.length < 6)
          {
            passV.css('border', '1px solid red');
            pass2V.css('border', '1px solid red');
            pass = false;
          }
          else
          {
            passV.css('border', '');
            pass2V.css('border', '');
            pass = true;
          }
        });

        $('#submitEdit').on('click', function(e){
           if (!pass)
           {
              if ($('#nameSubmit').val() == '')
              {
                $('#nameSubmit').css('border', '1px solid red');
              } else if ($('#editPassword').val() == '')
              {
                $('#editPassword').css('border', '1px solid red');
              } else if ($('#editPassword2').val() == '')
              {
                $('#editPassword2').css('border', '1px solid red');
              }
              e.preventDefault();
              alert("Please fix all errors highlighted before proceeding.\nNote that passwords must be more than 6 characters in length.");
           }
        });

        $('#oops').animate({
            opacity: 1
          }, 8500);
        $('#success').animate({
            opacity: 1
          }, 8500);

        pageChecker();
    });