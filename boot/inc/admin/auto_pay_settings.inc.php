<?
/***********************************************************************/
/*                                                                     */
/*  This file is created by deZender                                   */
/*                                                                     */
/*  deZender (Decoder for Zend Encoder/SafeGuard):                     */
/*    Version:      0.9.5.2                                            */
/*    Author:       qinvent.com                                        */
/*    Release on:   2008.4.22                                          */
/*                                                                     */
/***********************************************************************/


  $q = 'SELECT * FROM hm2_pay_settings WHERE n=\'egold_account_password\'';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $egold_password = $row['v'];
  }

  $q = 'SELECT * FROM hm2_pay_settings WHERE n=\'igolds_password\'';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $igolds_password = $row['v'];
  }

  $q = 'SELECT * FROM hm2_pay_settings WHERE n=\'libertyreserve_password\'';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $libertyreserve_password = $row['v'];
  }

  $q = 'SELECT * FROM hm2_pay_settings WHERE n=\'vmoney_password\'';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $vmoney_password = $row['v'];
  }

  $q = 'SELECT * FROM hm2_pay_settings WHERE n=\'pecunix_password\'';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $pecunix_password = $row['v'];
  }

  $q = 'SELECT * FROM hm2_pay_settings WHERE n=\'altergold_password\'';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $altergold_password = $row['v'];
  }

  $q = 'SELECT * FROM hm2_pay_settings WHERE n=\'perfectmoney_password\'';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $perfectmoney_password = $row['v'];
  }

  $q = 'SELECT * FROM hm2_pay_settings WHERE n=\'strictpay_password\'';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $strictpay_password = $row['v'];
  }

  if ($settings['demomode'] == 1)
  {
    echo start_info_table ('100%');
    echo '<b>Demo version restriction</b><br>You cannot edit these settings.<br><br>';
    echo end_info_table ();
  }

  if ($frm['say'] == 'invalid_passphrase')
  {
    echo '<b style="color:red">Invalid Alternative Passphrase. No data has been updated.</b><br><br>';
  }

  if ($frm['say'] == 'done')
  {
    echo '<b style="color:green">Changes has been successfully made.</b><br><br>';
  }

  if ($settings['demomode'] != 1)
  {
    echo start_info_table ('100%');
    echo '<b>We recommend to use the auto-payment feature only on the dedicated servers. Virtual Shared Hosting has much less security.<br>Use Mass Payment tool instead <a href=?a=thistory&ttype=withdraw_pending>here</a>.</b>';
    echo end_info_table ();
    echo '<br>';
  }

  echo '<script language=javascript>
function test_egold() 
{';
  if ($settings['demomode'] == 1)
  {
    echo 'alert("Sorry, not available in demo mode");  return false;';
  }

  if (!(function_exists ('curl_init')))
  {
    echo 'alert("Sorry, curl extension is not installed on server");return false;';
  }

  echo '
  if (document.formsettings.egold_from_account == \'\') 
  {
    alert("Please type e-gold account no");
    return false;
  }
  if (document.formsettings.egold_account_password.value == \'\') 
  {
    alert("Please type password");
    return false;
  }
  window.open(\'\', \'testegold\', \'width=400, height=200, status=0\');
  document.testsettings.target = \'testegold\';
  document.testsettings.a.value = \'test_egold_settings\';
  document.testsettings.acc.value = document.formsettings.egold_from_account.value;
  document.testsettings.pass.value = document.formsettings.egold_account_password.value;
  document.testsettings.submit();
}

function test_igolds() 
{';
  if ($settings['demomode'] == 1)
  {
    echo 'alert("Sorry, not available in demo mode");  return false;';
  }

  if (!(function_exists ('curl_init')))
  {
    echo 'alert("Sorry, curl extension is not installed on server");return false;';
  }

  echo '
  if (document.formsettings.igolds_from_account == \'\') 
  {
    alert("Please type igolds account no");
    return false;
  }
  if (document.formsettings.igolds_password.value == \'\') 
  {
    alert("Please type password");
    return false;
  }
  window.open(\'\', \'testigolds\', \'width=400, height=200, status=0\');
  document.testsettings.target = \'testigolds\';
  document.testsettings.a.value = \'test_igolds_settings\';
  document.testsettings.acc.value = document.formsettings.igolds_from_account.value;
  document.testsettings.pass.value = document.formsettings.igolds_password.value;
  document.testsettings.submit();
}

function test_pecunix() 
{';
  if ($settings['demomode'] == 1)
  {
    echo 'alert("Sorry, not available in demo mode");return false;';
  }

  if (!(function_exists ('curl_init')))
  {
    echo 'alert("Sorry, curl extension is not installed on server");return false;';
  }

  echo '
  if (document.formsettings.pecunix_from_account.value == \'\') 
  {
    alert("Please type Pecunix account");
    return false;
  }
  if (document.formsettings.pecunix_password.value == \'\') 
  {
    alert("Please type Pecunix password");
    return false;
  }

  window.open(\'\', \'testpecunix\', \'width=400, height=200, status=0\');
  document.testsettings.target = \'testpecunix\';
  document.testsettings.a.value = \'test_pecunix_settings\';
  document.testsettings.acc.value = document.formsettings.pecunix_from_account.value;
  document.testsettings.pass.value = document.formsettings.pecunix_password.value;
  document.testsettings.submit();
}


function test_libertyreserve() 
{';
  if ($settings['demomode'] == 1)
  {
    echo 'alert("Sorry, not available in demo mode");return false;';
  }

  if (!(function_exists ('curl_init')))
  {
    echo 'alert("Sorry, curl extension is not installed on server");return false;';
  }

  echo '
  if (document.formsettings.libertyreserve_from_account.value == \'\') 
  {
    alert("Please type Liberty Reserve account");
    return false;
  }
  if (document.formsettings.libertyreserve_password.value == \'\') 
  {
    alert("Please type Liberty Reserve Security Word");
    return false;
  }

  window.open(\'\', \'testlibertyreserve\', \'width=400, height=200, status=0\');
  document.testsettings.target = \'testlibertyreserve\';
  document.testsettings.a.value = \'test_libertyreserve_settings\';
  document.testsettings.acc.value = document.formsettings.libertyreserve_from_account.value;
  document.testsettings.pass.value = document.formsettings.libertyreserve_password.value;
  document.testsettings.code.value = document.formsettings.libertyreserve_apiname.value;
  document.testsettings.submit();
}

function test_altergold() 
{';
  if ($settings['demomode'] == 1)
  {
    echo 'alert("Sorry, not available in demo mode");return false;';
  }

  if (!(function_exists ('curl_init')))
  {
    echo 'alert("Sorry, curl extension is not installed on server");return false;';
  }

  echo '
  if (document.formsettings.altergold_from_account.value == \'\') 
  {
    alert("Please type AlterGold account");
    return false;
  }
  if (document.formsettings.altergold_password.value == \'\') 
  {
    alert("Please type AlterGold password");
    return false;
  }

  window.open(\'\', \'testaltergold\', \'width=400, height=200, status=0\');
  document.testsettings.target = \'testaltergold\';
  document.testsettings.a.value = \'test_altergold_settings\';
  document.testsettings.acc.value = document.formsettings.altergold_from_account.value;
  document.testsettings.pass.value = document.formsettings.altergold_password.value;
  document.testsettings.submit();
}


function test_vmoney() 
{';
  if ($settings['demomode'] == 1)
  {
    echo 'alert("Sorry, not available in demo mode");return false;';
  }

  if (!(function_exists ('curl_init')))
  {
    echo 'alert("Sorry, curl extension is not installed on server");return false;';
  }

  echo '
  if (document.formsettings.vmoney_from_account.value == \'\') 
  {
    alert("Please type V-Money account");
    return false;
  }
  if (document.formsettings.vmoney_password.value == \'\') 
  {
    alert("Please define V-Money security code");
    return false;
  }

  window.open(\'\', \'testvmoney\', \'width=400, height=200, status=0\');
  document.testsettings.target = \'testvmoney\';
  document.testsettings.a.value = \'test_vmoney_settings\';
  document.testsettings.acc.value = document.formsettings.vmoney_from_account.value;
  document.testsettings.pass.value = document.formsettings.vmoney_password.value;
  document.testsettings.submit();
}

function test_perfectmoney() 
{';
  if ($settings['demomode'] == 1)
  {
    echo 'alert("Sorry, not available in demo mode");return false;';
  }

  if (!(function_exists ('curl_init')))
  {
    echo 'alert("Sorry, curl extension is not installed on server");return false;';
  }

  echo '
  if (document.formsettings.perfectmoney_from_account.value == \'\') 
  {
    alert("Please type PerfectMoney account");
    return false;
  }
  if (document.formsettings.perfectmoney_payer_account.value == \'\') 
  {
    alert("Please type Payer account");
    return false;
  }
  if (document.formsettings.perfectmoney_password.value == \'\') 
  {
    alert("Please define PerfectMoney password");
    return false;
  }

  window.open(\'\', \'testperfectmoney\', \'width=400, height=200, status=0\');
  document.testsettings.target = \'testperfectmoney\';
  document.testsettings.a.value = \'test_perfectmoney_settings\';
  document.testsettings.acc.value = document.formsettings.perfectmoney_from_account.value;
  document.testsettings.code.value = document.formsettings.perfectmoney_payer_account.value;
  document.testsettings.pass.value = document.formsettings.perfectmoney_password.value;
  document.testsettings.submit();
}

function test_strictpay() 
{';
  if ($settings['demomode'] == 1)
  {
    echo 'alert("Sorry, not available in demo mode");return false;';
  }

  if (!(function_exists ('curl_init')))
  {
    echo 'alert("Sorry, curl extension is not installed on server");return false;';
  }

  echo '
  if (document.formsettings.strictpay_from_account.value == \'\') 
  {
    alert("Please type StrictPay account");
    return false;
  }
  if (document.formsettings.strictpay_email_address.value == \'\') 
  {
    alert("Please type StrictPay email address");
    return false;
  }
  if (document.formsettings.strictpay_access_code.value == \'\')
  {
	alert("Please type StrictPay access code");
	return false;
  }
  if (document.formsettings.strictpay_password.value == \'\') 
  {
    alert("Please type StrictPay password");
    return false;
  }

  window.open(\'\', \'teststrictpay\', \'width=400, height=200, status=0\');
  document.testsettings.target = \'teststrictpay\';
  document.testsettings.a.value = \'test_strictpay_settings\';
  document.testsettings.acc.value = document.formsettings.strictpay_from_account.value;
  document.testsettings.code.value = document.formsettings.strictpay_access_code.value;
  document.testsettings.pass.value = document.formsettings.strictpay_password.value;
  document.testsettings.email.value = document.formsettings.strictpay_email_address.value;

  document.testsettings.submit();
}

</script>

<form name=testsettings method=post>
<input type=hidden name=a>
<input type=hidden name=acc>
<input type=hidden name=pass>
<input type=hidden name=code>
<input type=hidden name=email>
</form>

<form method=post name=formsettings>
<input type=hidden name=a value=auto-pay-settings>
<input type=hidden name=action value=auto-pay-settings>

<b>Auto-payment settings:</b><br><br>';
  if (!(function_exists ('curl_init')))
  {
    echo start_info_table ('100%');
    echo '  <b>Auto-payment is not available</b><br>Curl module is not installed on your server. ';
    echo end_info_table ();
    echo '  <br>  <br>';
  }

  echo '<table cellspacing=0 cellpadding=2 border=0 width=100%>
<tr>
 <td colspan=2><input type=checkbox name=use_auto_payment value=1 ';
  echo ($settings['use_auto_payment'] == 1 ? 'checked' : '');
  echo '> Use auto-payment</td>
</tr><tr>
 <td colspan=2>&nbsp;<br><img src="images/pay/0.gif"> <b>E-gold account:</b></td>
</tr><tr>
 <td>Account number:</td>
 <td><input type=text name=egold_from_account value="';
  echo $settings['egold_from_account'];
  echo '" class=inpts size=30></td>
</tr>
';
  if ($egold_password != '')
  {
    echo '<tr><td>Old passphrase:</td><td>**********</td></tr>';
  }

  echo '<tr>
 <td>Account passphrase:</td>
 <td><input type=password name=egold_account_password value="" class=inpts size=30> <input type=button value="Test" onClick="test_egold();" class=sbmt></td>
</tr>';

  echo '<tr><td colspan=2>&nbsp;<br><img src="images/pay/12.gif"> <b>iGolds settings:</b></td></tr>
<tr>
 <td>Account number:</td>
 <td><input type=text name=igolds_from_account value="' . $settings['igolds_from_account'] . '" class=inpts size=30></td></tr>
';

  if ($igolds_password != '')
  {
    echo '<tr><td>Old passphrase:</td><td>**********</td></tr>';
  }

  echo '<tr>
 <td>Account passphrase:</td>
 <td><input type=password name=igolds_password value="" class=inpts size=30> <input type=button value="Test" onClick="test_igolds();" class=sbmt></td>
</tr>';

  echo '<tr><td colspan=2>&nbsp;<br><img src="images/pay/9.gif"> <b>Pecunix settings:</b></td></tr>
<tr>
 <td>Account Id:</td>
 <td><input type=text name=pecunix_from_account value="' . $settings['pecunix_from_account'] . '" class=inpts size=30></td></tr>';
  if ($pecunix_password != '')
  {
    echo '<tr><td>Old Payment PIK:</td> <td>**********</td></tr>';
  }

  echo '<tr>
 <td>Payment PIK:<br><small>You should enter just characters without spaces and \'-\'</small></td>
 <td><input type=password name=pecunix_password value="" class=inpts size=30> <input type=button value="Test" onClick="test_pecunix();" class=sbmt></td>
</tr>';
  echo '<tr><td colspan=2>&nbsp;<br><img src="images/pay/1.gif"> <b>Liberty Reserve settings:</b></td></tr>
<tr>
 <td>Account Id:</td>
 <td><input type=text name=libertyreserve_from_account value="' . $settings['libertyreserve_from_account'] . '" class=inpts size=30></td>
</tr>
<tr>
 <td>API Name:</td>
 <td><input type=text name=libertyreserve_apiname value="' . $settings['libertyreserve_apiname'] . '" class=inpts size=30></td>
</tr>';
  if ($libertyreserve_password != '')
  {
    echo '<tr><td>Old Security Word:</td><td>**********</td></tr>';
  }

  echo '<tr>
 <td>Security Word:</td>
 <td><input type=password name=libertyreserve_password value="" class=inpts size=30> <input type=button value="Test" onClick="test_libertyreserve();" class=sbmt></td>
</tr>
<tr>
 <td colspan=2>';
  echo start_info_table ('100%');
  echo 'To setup Security Word:<br>
        1. Enter your Liberty Reserver account.<br>
        2. Enter Merchant Tools. (link is in top menu).<br>
        3. Create new API.<br> 
		4. Define API name (any string you want). <b>Place this value into field on this page.</b><br>
        5. Define Security word (any string you want). <b>Place this value into field on this page.</b><br>
        6. Enabley this API.<br>
        7. We recommend you to set Requesting IP Addresses - your server IP address is ' . $_SERVER['SERVER_ADDR'] . ' but it can be different - ask your hoster to be sure.<br>';
  echo end_info_table ();
  echo ' </td></tr>';
  echo '<tr><td colspan=2>&nbsp;<br><img src="images/pay/3.gif"> <b>V-Money settings:</b></td></tr>
<tr>
 <td>Account Id:</td>
 <td><input type=text name=vmoney_from_account value="' . $settings['vmoney_from_account'] . '" class=inpts size=30></td>
</tr>';
  if ($vmoney_password != '')
  {
    echo '<tr><td>Old Security Code:</td> <td>**********</td></tr>';
  }

  echo '
<tr>
 <td>Account Password:</td>
 <td><input type=password name=vmpass value="" class=inpts size=30></td>
</tr>
<tr>
 <td>Account PIN:</td>
 <td><input type=password name=vmpin value="" class=inpts size=30></td>
</tr>
<tr>
 <td>&nbsp;</td>
 <td><input type=button value="Generate Security Code" class=sbmt onclick="gen_vm_sec_code()"></td>
</tr>
<tr>
 <td>Security Code:</td>
 <td><input type=password name=vmoney_password  readonly class=inpts size=30> <input type=button value="Test" onClick="test_vmoney();" class=sbmt></td>
</tr>
<tr>
  <td colspan="2">';
  echo start_info_table ('100%');
  echo 'To setup V-Money Auto Withdraws:<br>
        1. Type your V-Money Account ID.<br>
        2. Type in your V-Money Password(used to login not Merchant Password) in <b>Account Password</b> field.<br>
        3. Type in your PIN in <b>Account PIN</b> field.<br> 
		4. Press <b>Generate Security Code</b> in order to get the code used to approve auto payments<br>
        5. Save your changes and press Test to check your settings</b><br>';
  echo end_info_table ();
  echo ' </td></tr>';
  echo '
 <tr>
   <td colspan=2>&nbsp;<br><img src="images/pay/8.gif"> <b>AlterGold settings:</b></td>
 </tr>
 <tr>
   <td>Merchant account:</td>
   <td><input type=text name=altergold_from_account value="' . $settings['altergold_from_account'] . '" class=inpts size=30></td>
 </tr>';
  if ($altergold_password != '')
  {
    echo '<tr><td>Old Password:</td> <td>**********</td></tr>';
  }

  echo '
<tr>
 <td>Account Password:</td>
 <td><input type=password name=altergold_password  value="" class=inpts size=30> <input type=button value="Test" onClick="test_altergold();" class=sbmt></td>
</tr>
<tr>
 <td colspan=2>';
  echo start_info_table ('100%');
  echo 'Merchant\'s account (Payer) must have automation enabled and IP address of server which is connection with AlterGold server must be allowed (Using of wildcards is possible). You can edit these settings at Edit Account Settings option in Account Area. PIN Check must also be disabled.<br>
1. Automation Enabled in Account.<br>
2. Requesting IP Address must be allowed.<br>
3. PIN Check is disabled.<br>
In order to test settings we try to spend 10 cents from your account to your account. Make sure you have funds in your AlterGold account. If the test return an ok message and a batch transaction number means settings are correct otherwise you get an error message.';
  echo end_info_table ();
  echo ' </td></tr>';
  echo '
<tr>
 <td colspan=2>&nbsp;<br><img src="images/pay/10.gif"> <b>PerfectMoney settings:</b></td>
</tr>
<tr>
 <td>AccountID:</td>
 <td><input type=text name=perfectmoney_from_account value="' . $settings['perfectmoney_from_account'] . '" class=inpts size=30></td>
</tr>
<tr>
 <td>Payer Account:</td>
 <td><input type=text name=perfectmoney_payer_account value="' . $settings['perfectmoney_payer_account'] . '" class=inpts size=30></td>
</tr>';
  if ($perfectmoney_password != '')
  {
    echo '<tr><td>Old Password:</td> <td>**********</td></tr>';
  }

  echo '
<tr>
 <td>PerfectMoney Password:</td>
 <td><input type=password name=perfectmoney_password class=inpts size=30> <input type=button value="Test" onClick="test_perfectmoney();" class=sbmt></td>
</tr>
<tr>
 <td colspan=2>';
  echo start_info_table ('100%');
  echo 'Payer account is USD account. Starts with U<br>You should enable API. Login to your PerfectMoney account, follow security section, then "Change Security Settings" and enable API<br>';
  echo end_info_table ();
  echo ' </td></tr>';
  echo '
<tr>
 <td colspan=2>&nbsp;<br><img src="images/pay/11.gif"> <b>StrictPay settings:</b></td>
</tr>
<tr>
 <td>Account ID:</td>
 <td><input type=text name=strictpay_from_account value="' . $settings['strictpay_from_account'] . '" class=inpts size=30></td>
</tr>
<tr>
 <td>Account Email address:</td>
 <td><input type=text name=strictpay_email_address value="' . $settings['strictpay_email_address'] . '" class=inpts size=30></td>
</tr>
<tr>
 <td>Account Access code:</td>
 <td><input type=text name=strictpay_access_code value="' . $settings['strictpay_access_code'] . '" class=inpts size=30></td>
</tr>';
  if ($strictpay_password != '')
  {
    echo '<tr><td>Old Password:</td> <td>**********</td></tr>';
  }

  echo '
<tr>
 <td>StrictPay Password:</td>
 <td><input type=password name=strictpay_password class=inpts size=30> <input type=button value="Test" onClick="test_strictpay();" class=sbmt></td>
</tr>
<tr>
 <td colspan=2>';
  echo start_info_table ('100%');
  echo 'Account ID: Type here your account id you received after signin up (That\'s a number).<br>Account Email address: The email address you use to login on your StrictPay account.<br>Account Access Code: The code you have set up in your StrictPay account<br>Password: The password you use to login on your StrictPay account.<br><b>In order to test settings the script try to send 10 cents from your account to your account. Make sure your balance is positive. If you receive message the transaction was completed successefully settings are correct.</b>';
  echo end_info_table ();
  echo ' </td></tr><br><br>
<tr>
 <td colspan=2><b>Other settings:</b></td>
</tr>
<tr>
 <td>Minimal automatic withdrawal amount (US$):</td>
 <td><input type=text name=min_auto_withdraw value="';
  echo $settings['min_auto_withdraw'];
  echo '" class=inpts size=30></td>
</tr>
<tr>
 <td>Maximal automatic withdrawal amount (US$):</td>
 <td><input type=text name=max_auto_withdraw value="';
  echo $settings['max_auto_withdraw'];
  echo '" class=inpts size=30></td>
</tr>
<tr>
 <td>Maximal daily withdrawal for every user. (US$):</td>
 <td><input type=text name=max_auto_withdraw_user value="';
  echo $settings['max_auto_withdraw_user'];
  echo '" class=inpts size=30></td>
</tr>';
  if ($userinfo['transaction_code'] != '')
  {
    echo '<tr>
 <td colspan=2>&nbsp;</td>
</tr>
<tr>
 <td>Alternative Passphrase: </td>
 <td><input type=password name="alternative_passphrase" value="" class=inpts size=30></td>
</tr>
';
  }

  echo '<tr> <td>&nbsp;</td><td><input type=submit value="Save" class=sbmt></td></tr>
</table>
<br>
</form>';
  $q = 'SELECT * FROM hm2_pay_errors LIMIT 1';
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error;
    true;
  }

  while ($row = mysql_fetch_array ($sth))
  {
    echo '<a href=?a=error_pay_log>Check error transactions</a><br><br>';
  }

  echo start_info_table ('100%');
  echo '<b>Payer account information</b><br>
Type your login and password here. <br>
For e-gold: Make sure you\'ve entered your server IP at "Account Info" -> "Account 
Attributes" -> "Automation Access".<br>
The Password will be encrypted and saved to the mysql database.<br>
<br>
Minimal automatic withdrawal amount and<br>
Maximal automatic withdrawal amount.<br>
Withdrawal will be processed automatically if a user asks to withdraw more or 
equal than the minimal withdrawal amount and less or equal than the maximual withdrawal 
amount. Administrator should process all other transactions manually.<br>
Maximal daily withdrawal for every user. The script will make payments to the 
user\'s e-gold account automatically if the total user withdrawal sum for 24 hour is less than the specified value.<br>
<br>

E-gold:<br>
Test button tries to spend $0.01 from and to your account number. It returns error 
if your settings are wrong.<br><br>

iGolds:<br>
Test button tries to spend $0.01 from and to your account number. It returns error 
if your settings are wrong.<br><br>

Pecunix:<br>
Test button tries to spend $0.01 from and to your account number in test mode. It returns error if your settings
are incorrect.<br><br>';
  echo end_info_table ();
  echo '<script language="JavaScript">

function gen_vm_sec_code()
{
  document.formsettings.vmoney_password.value = calcMD5(document.formsettings.vmpass.value).toLowerCase()+document.formsettings.vmpin.value;
  document.formsettings.vmpass.value = \'\';
  document.formsettings.vmpin.value = \'\';
}

<!--
/* jrw note: this md5 code GPL\'d by paul johnston at his web site: http://cw.oaktree.co.uk/site/legal.html */
/*
	** pjMd5.js
	**
	** A JavaScript implementation of the RSA Data Security, Inc. MD5
	** Message-Digest Algorithm.
	**
	** Copyright (C) Paul Johnston 1999.
	*/

	var sAscii=" !\\"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\\\]^_`"

	var sAscii=sAscii+"abcdefghijklmnopqrstuvwxyz{|}~";
	var sHex="0123456789ABCDEF";

	function hex(i) {
	h="";
	for(j=0; j<=3; j++) {
	  h+=sHex.charAt((i>>(j*8+4))&0x0F)+sHex.charAt((i>>(j*8))&0x0F);
	}
	return h;
	}
	function add(x,y) {
	return ((x&0x7FFFFFFF)+(y&0x7FFFFFFF) )^(x&0x80000000)^(y&0x80000000);
	}
	function R1(A,B,C,D,X,S,T) {
	q=add( add(A,(B&C)|((~B)&D)), add(X,T) );

	return add( (q<<S)|( (q>>(32-S))&(Math.pow(2,S)-1) ), B );
	}
	function R2(A,B,C,D,X,S,T) {
	q=add( add(A,(B&D)|(C&(~D))), add(X,T) );
	return add( (q<<S)|( (q>>(32-S))&(Math.pow(2,S)-1) ), B );
	}
	function R3(A,B,C,D,X,S,T) {
	q=add( add(A,B^C^D), add(X,T) );
	return add( (q<<S)|( (q>>(32-S))&(Math.pow(2,S)-1) ), B );
	}
	function R4(A,B,C,D,X,S,T) {
	q=add( add(A,C^(B|(~D))), add(X,T) );
	return add( (q<<S)|( (q>>(32-S))&(Math.pow(2,S)-1) ), B );
	}

	function calcMD5(sInp) {

	/* Calculate length in words, including padding */
	wLen=(((sInp.length+8)>>6)+1)<<4;
	var X = new Array(wLen);

	/* Convert string to array of words */
	j=4;
	for (i=0; (i*4)<sInp.length; i++) {
	X[i]=0;
	for (j=0; j<4 && (i*4+j)<sInp.length; j++) {
	  X[i]+=(sAscii.indexOf(sInp.charAt((i*4)+j))+32)<<(j*8);
	}
	}

	/* Append the 1 and 0s to make a multiple of 4 bytes */
	if (j==4) { X[i++]=0x80; }
	else { X[i-1]+=0x80<<(j*8); }
	/* Appends 0s to make a 14+k16 words */
	while ( i<wLen ) { X[i]=0; i++; }
	/* Append length */
	X[wLen-2]=sInp.length<<3;
	/* Initialize a,b,c,d */
	a=0x67452301; b=0xefcdab89; c=0x98badcfe; d=0x10325476;

	/* Process each 16 word block in turn */
	for (i=0; i<wLen; i+=16) {
	aO=a; bO=b; cO=c; dO=d;

	a=R1(a,b,c,d,X[i+ 0],7 ,0xd76aa478);
	d=R1(d,a,b,c,X[i+ 1],12,0xe8c7b756);
	c=R1(c,d,a,b,X[i+ 2],17,0x242070db);
	b=R1(b,c,d,a,X[i+ 3],22,0xc1bdceee);
	a=R1(a,b,c,d,X[i+ 4],7 ,0xf57c0faf);
	d=R1(d,a,b,c,X[i+ 5],12,0x4787c62a);
	c=R1(c,d,a,b,X[i+ 6],17,0xa8304613);
	b=R1(b,c,d,a,X[i+ 7],22,0xfd469501);
	a=R1(a,b,c,d,X[i+ 8],7 ,0x698098d8);
	d=R1(d,a,b,c,X[i+ 9],12,0x8b44f7af);
	c=R1(c,d,a,b,X[i+10],17,0xffff5bb1);
	b=R1(b,c,d,a,X[i+11],22,0x895cd7be);
	a=R1(a,b,c,d,X[i+12],7 ,0x6b901122);
	d=R1(d,a,b,c,X[i+13],12,0xfd987193);
	c=R1(c,d,a,b,X[i+14],17,0xa679438e);
	b=R1(b,c,d,a,X[i+15],22,0x49b40821);

	a=R2(a,b,c,d,X[i+ 1],5 ,0xf61e2562);
	d=R2(d,a,b,c,X[i+ 6],9 ,0xc040b340);
	c=R2(c,d,a,b,X[i+11],14,0x265e5a51);
	b=R2(b,c,d,a,X[i+ 0],20,0xe9b6c7aa);
	a=R2(a,b,c,d,X[i+ 5],5 ,0xd62f105d);
	d=R2(d,a,b,c,X[i+10],9 , 0x2441453);
	c=R2(c,d,a,b,X[i+15],14,0xd8a1e681);
	b=R2(b,c,d,a,X[i+ 4],20,0xe7d3fbc8);
	a=R2(a,b,c,d,X[i+ 9],5 ,0x21e1cde6);
	d=R2(d,a,b,c,X[i+14],9 ,0xc33707d6);
	c=R2(c,d,a,b,X[i+ 3],14,0xf4d50d87);
	b=R2(b,c,d,a,X[i+ 8],20,0x455a14ed);
	a=R2(a,b,c,d,X[i+13],5 ,0xa9e3e905);
	d=R2(d,a,b,c,X[i+ 2],9 ,0xfcefa3f8);
	c=R2(c,d,a,b,X[i+ 7],14,0x676f02d9);
	b=R2(b,c,d,a,X[i+12],20,0x8d2a4c8a);

	a=R3(a,b,c,d,X[i+ 5],4 ,0xfffa3942);
	d=R3(d,a,b,c,X[i+ 8],11,0x8771f681);
	c=R3(c,d,a,b,X[i+11],16,0x6d9d6122);
	b=R3(b,c,d,a,X[i+14],23,0xfde5380c);
	a=R3(a,b,c,d,X[i+ 1],4 ,0xa4beea44);
	d=R3(d,a,b,c,X[i+ 4],11,0x4bdecfa9);
	c=R3(c,d,a,b,X[i+ 7],16,0xf6bb4b60);
	b=R3(b,c,d,a,X[i+10],23,0xbebfbc70);
	a=R3(a,b,c,d,X[i+13],4 ,0x289b7ec6);
	d=R3(d,a,b,c,X[i+ 0],11,0xeaa127fa);
	c=R3(c,d,a,b,X[i+ 3],16,0xd4ef3085);
	b=R3(b,c,d,a,X[i+ 6],23, 0x4881d05);
	a=R3(a,b,c,d,X[i+ 9],4 ,0xd9d4d039);
	d=R3(d,a,b,c,X[i+12],11,0xe6db99e5);
	c=R3(c,d,a,b,X[i+15],16,0x1fa27cf8);
	b=R3(b,c,d,a,X[i+ 2],23,0xc4ac5665);

	a=R4(a,b,c,d,X[i+ 0],6 ,0xf4292244);
	d=R4(d,a,b,c,X[i+ 7],10,0x432aff97);
	c=R4(c,d,a,b,X[i+14],15,0xab9423a7);
	b=R4(b,c,d,a,X[i+ 5],21,0xfc93a039);
	a=R4(a,b,c,d,X[i+12],6 ,0x655b59c3);
	d=R4(d,a,b,c,X[i+ 3],10,0x8f0ccc92);
	c=R4(c,d,a,b,X[i+10],15,0xffeff47d);
	b=R4(b,c,d,a,X[i+ 1],21,0x85845dd1);
	a=R4(a,b,c,d,X[i+ 8],6 ,0x6fa87e4f);
	d=R4(d,a,b,c,X[i+15],10,0xfe2ce6e0);
	c=R4(c,d,a,b,X[i+ 6],15,0xa3014314);
	b=R4(b,c,d,a,X[i+13],21,0x4e0811a1);
	a=R4(a,b,c,d,X[i+ 4],6 ,0xf7537e82);
	d=R4(d,a,b,c,X[i+11],10,0xbd3af235);
	c=R4(c,d,a,b,X[i+ 2],15,0x2ad7d2bb);
	b=R4(b,c,d,a,X[i+ 9],21,0xeb86d391);

	a=add(a,aO); b=add(b,bO); c=add(c,cO); d=add(d,dO);
	}
	return hex(a)+hex(b)+hex(c)+hex(d);
	}

//-->
  </script>';
?>