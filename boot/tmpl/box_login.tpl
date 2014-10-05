{if $userinfo.logged != 1}
{literal}
<script language=javascript>
function checklogin() 
{   
 if (document.loginform.username.value=='') 
 {
  alert("Please enter your username!");
  document.loginform.username.focus();
  return false;
 }
 if (document.loginform.password.value=='') 
 {
   alert("Please enter your password!");
   document.loginform.password.focus();
   return false;
 }
 return true;
}
</script>
{/literal}
<form method=post name=loginform onsubmit="return checklogin()" action="page_login.php">
<input type=hidden name=a value='do_login'>

<table cellspacing=0 cellpadding=2 border=0 width="100%">
<tr>
 <th colspan=2 class="block_top"><span class="title">Member login</span></th>
</tr>
<tr colspan=2>
 <td class="bg_block" align="center">
  <table width="100%">
   <tr>
    <td class=menutxt>Username:</td>
    <td><input type=text name=username class=inpts size=15></td>
   </tr>
   <tr>
    <td class=menutxt>Password:</td>
    <td><input type=password name=password class=inpts size=15></td>
   </tr>
   {if $settings.validation_enabled == 1}
   <tr>
    <td class=menutxt>
     <img src="turing_number.php?{$userinfo.session_name}={$userinfo.session_id}&rand={$userinfo.rand}">
    </td>
    <td><input type=text name=validation_number class=inpts size=15></td>
   </tr>
   {/if}
   <tr>
    <td class=menutxt>&nbsp;</td>
    <td><input type=submit value="Login" class=sbmt size=15></td>
   </tr>
   <tr>
    <td colspan=2 align=right><a href="page_forgot_password.php">Password recovery</a></td>
   </tr>
  </table>
 </td>
</tr>
</table>
</form>

{else}
<table cellspacing=0 cellpadding=2 border=0 width="100%">
<tr>
 <th colspan=2 class="block_top"><span class="title">Members Menu</span></th>
</tr>
<tr colspan=2>
 <td class="bg_block" align="center">
  <table width="100%">
   <tr><td class=menutxt><a href="account_main.php" class=menutxt>Account</a></td></tr>
   <tr><td class=menutxt><a href="account_deposit.php" class=menutxt>Make Deposit</a></td></tr>
   {if $settings.use_add_funds}
   <tr><td class=menutxt><a href="account_addfunds.php" class=menutxt>Make Deposit to Account</a></td></tr>
   {/if} 
   <tr><td class=menutxt><a href="account_deposit_list.php" class=menutxt>Your Deposits</a></td></tr>
   <tr><td class=menutxt><a href="account_deposit_history.php" class=menutxt>Deposits History</a></td></tr>
   <tr><td class=menutxt><a href="account_earnings.php" class=menutxt>Earnings History</a></td></tr>
   {if $settings.use_referal_program == 1}
   <tr><td class=menutxt><a href="account_earnings.php?type=commissions" class=menutxt>Referrals History</a></td></tr>
   {/if}
   <tr><td class=menutxt><a href="account_withdraw.php" class=menutxt>Withdraw</a></td></tr>
   <tr><td class=menutxt><a href="account_withdraw_history.php" class=menutxt>Withdrawals History</a></td></tr>
   <tr><td class=menutxt><a href="account_exchange.php" class=menutxt>Currency Exchange</a></td>
   </tr>
   {if $settings.internal_transfer_enabled}
   <tr><td class=menutxt><a href="account_internal_transfer.php" class=menutxt>Internal Transfer</a></td></tr>
   {/if}
   {if $settings.use_referal_program == 1}
   <tr><td class=menutxt><a href="account_referrals.php" class=menutxt>Your Referrals</a></td></tr>
   <tr><td class=menutxt><a href="account_referral_links.php" class=menutxt>Referral Links</a></td></tr>
   {/if}
   <tr><td class=menutxt><a href="account_edit.php" class=menutxt>Edit Account</a></td></tr>
   <tr><td class=menutxt><a href="page_logout.php" class=menutxt>Logout</a></td></tr>
   </table>
  </td>
 </tr>
</table>
{/if}