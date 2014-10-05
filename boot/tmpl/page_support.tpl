{include file="header.tpl"}


<h3>Support Form:</h3><br>

{if $say eq 'send'}
Message has been successfully sent. We will back to you in next 24 hours. Thank you.<br><br>
{else}

<script language=javascript>
{if $userinfo.logged == 1}
{literal}
function checkform() { 
  if (document.mainform.message.value == '') {
    alert("Please type your message!");
    document.mainform.message.focus();
    return false;
  }
  return true;
}
{/literal}
{else}
{literal}
function checkform() {
  if (document.mainform.name.value == '') {
    alert("Please type your full name!");
    document.mainform.name.focus();
    return false;
  }
  if (document.mainform.email.value == '') {
    alert("Please enter your e-mail address!");
    document.mainform.email.focus();
    return false;
  }
  if (document.mainform.message.value == '') {
    alert("Please type your message!");
    document.mainform.message.focus();
    return false;
  }
  return true;
}
{/literal}
{/if}
</script>

<form method=post name=mainform onsubmit="return checkform()">
<input type=hidden name=a value=support>
<input type=hidden name=action value=send>

<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td>Your Name:</td>
{if $userinfo.logged}
 <td><b>{$userinfo.name}</b></td>
{else}
 <td><input type="text" name="name" size=30 class=inpts></td>
{/if}
</tr>
<tr>
 <td>Your Email:</td>
{if $userinfo.logged}
 <td><b>{$userinfo.email}</b></td>
{else}
 <td><input type="text" name="email" size=30 class=inpts></td>
{/if}
</tr>
<tr>
 <td>Message:</td>
 <td<textarea name=message class=inpts cols=35 rows=3></textarea>
</tr>
<tr>
 <td>&nbsp;</td>
 <td><input type=submit value="Send" class=sbmt></td>
</tr></table>
</form>

{/if}


{include file="footer.tpl"}
