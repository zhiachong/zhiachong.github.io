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

    return true;
}

$(document).ready(
    function() {
        $('#reinvest').on('change', function() {
            if ($('#reinvest option:selected').text() != '')
            {
                $('#external').attr('name', '');
            }
        });
    });