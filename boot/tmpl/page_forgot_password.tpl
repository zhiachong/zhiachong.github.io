{include file="header.tpl"}

{literal}
<script language=javascript>
function checkform() {
  if (document.forgotform.email.value == '') {
    alert("Please type your username or email!");
    document.forgotform.email.focus();
    return false;
  }
  return true;
}
</script>
{/literal}




<div class="page_title">
    <div class="container">
        <div class="sixteen columns">
            FORGOT PASSWORD
        </div>
    </div>
</div>


<div class="container about">
<!-- FEATURES -->
<div class="sixteen columns m-bot-25">
<h3 class="underlined"><span>Reset Your Password</span></h3>
<div class="clearfix"></div>

<div class="container clearfix m-bot-35">
    <div class="sixteen columns">
        <p>Please type in your email address in order to recover your login information.</p>
        {if $found_records == 0}
        <p>Unfortunately, it seems that you have not registered with us as we cannot find your login information.</p>
        {/if}
        {if $found_records == 1}
        <p><font color='green'>Woohoo!</font> We found your account. Please check your inbox and follow the instructions to recover your account.</p>
        {else}
<form method=post name=forgotform onsubmit="return checkform();" action="page_forgot_password.php">
<input type=hidden name=action value="forgot_password">
<legend>Type your username or e-mail:</legend>
 <input type=text name='email' value="" class=inpts size=30>

 <button class="button sign-up-button" type=submit value="Forgot" class=sbmt>Recover my info</button>
</form><br><br>
{/if}
    </div>
</div>
</div>

</div>
</div>

</div>

{include file="footer.tpl"}
