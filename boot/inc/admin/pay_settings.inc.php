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


  $gpg_version = 0;
  $gpg_command = escapeshellcmd ($settings['gpg_path']) . ' --version';
  $mddomain = preg_replace ('/^www\\./', '', $frm_env['HTTP_HOST']);
  $fp = @popen ('' . $gpg_command, 'r');
  if ($fp)
  {
    while (!(feof ($fp)))
    {
      $buf = fgets ($fp, 4096);
      $pos = strstr ($buf, 'gpg (GnuPG)');
      if (0 < strlen ($pos))
      {
        $gpg_version = preg_replace ('/[\\n\\r]/', '', substr ($pos, 11));
        continue;
      }
    }

    pclose ($fp);
  }

  $settings['md5altphrase_ebullion'] = decode_pass_for_mysql ($settings['md5altphrase_ebullion']);

/*-- Remarked by deZender,
  $url = 'http://www.hyipmanagerscript.com/license.php?action=check&script=1&domain=' . $mddomain . '&license=' . $settings['license'];
  $handle = @fopen ($url, 'r');
  if ($handle)
  {
    $cont = fread ($handle, 200000);
    fclose ($handle);
  }
Remarked --*/

  if ($settings['demomode'] == 1)
  {
    echo start_info_table ('100%');
    echo '<b>Demo version restriction!</b><br>You cannot edit settings! ';
    echo end_info_table ();
    $settings['md5altphrase'] = '*******';
    $settings['md5altphrase_ebullion'] = '*******';
    $settings['md5altphrase_eeecurrency'] = '*******';
    $settings['md5altphrase_pecunix'] = '*******';
    $settings['md5altphrase_strictpay'] = '*******';
  }

  if ($frm['say'] == 'done')
  {
    echo '<b style="color:green">Changes has been successfully saved.</b><br><br>';
  }

  echo '  
<script language=javascript>

function open_payment_settings(a, ii) 
{
  var z = document.getElementById(a+"_tr_1").style.display == \'\'?\'none\':\'\';
  for (i = 1; i<=ii; i++) 
  {
    document.getElementById(a+"_tr_"+i).style.display = z;
  }
}
function check_form()
{
  var d = document.mainform;

';
  if ($settings['use_alternative_passphrase'] == 0)
  {
    echo '  if (d.use_alternative_passphrase.options[d.use_alternative_passphrase.selectedIndex].value == 1 && d.new_alternative_passphrase.value == \'\')
  {
    alert(\'Please enter your New Alternative Passphrase!\');
    d.new_alternative_passphrase.focus();
    return false;
  }
';
  }

  echo '
  if (d.new_alternative_passphrase.value != \'\' && d.new_alternative_passphrase.value != d.new_alternative_passphrase2.value)
  {
    alert(\'Please, check your Alternative Passphrase!\');
    d.new_alternative_passphrase2.focus();
    return false;
  }
}
</script>

<form method=post name="mainform" enctype="multipart/form-data" onsubmit="return check_form()">
<input type=hidden name=a value=paysettings>
<input type=hidden name=action value=paysettings>

<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td colspan=2><b>Payment settings:</b><br><br></td>
</tr><tr>
         <td colspan=2>&nbsp;<br>
		  <b><img src="images/pay/1.gif"> LibertyReserve settings:</b> <a href="javascript:open_payment_settings(\'LR\', 4)"><B><i>OPEN settings</B></i></a></td>
       </tr>
<tr id="LR_tr_1" style="display:none">
 <td>Your Liberty Reserve account:</td>
 <td><input type=text name="def_payee_account_libertyreserve" value=\'';
  echo quote ($settings['def_payee_account_libertyreserve']);
  echo '\'class=inpts size=30></td>
</tr><tr id="LR_tr_2" style="display:none">
 <td>Store Name:</td>
 <td><input type=text name="md5altphrase_libertyreserve_store" value=\'';
  echo quote ($settings['md5altphrase_libertyreserve_store']);
  echo '\' class=inpts size=30></td>
</tr><tr id="LR_tr_3" style="display:none">
 <td>Secret Word:</td>
 <td><input type=text name="md5altphrase_libertyreserve" value=\'';
  echo quote (decode_pass_for_mysql ($settings['md5altphrase_libertyreserve']));
  echo '\' class=inpts size=30></td>
</tr><tr id="LR_tr_4" style="display:none">
      <td colspan=2>';
  echo start_info_table ('100%');
  echo 'Specify your Liberty Reserve account settings for income transfers here. Clear this field to disable LR payments.<br>Login your LR account, go to "Merchant Tools" (upper menu), Click "Create Store" (right screen area),Type any "Store Name" and any "Security Word", then type the same Store name and Security Word in form at this page.<br><br><b>Try to buy a product to test settings.</b><br>';
  echo end_info_table ();
  echo '</td></tr><tr>
         <td colspan=2>&nbsp;<br>
		  <img src="images/pay/2.gif"> <b>SolidTrustPay settings:</b> <a href="javascript:open_payment_settings(\'STP\', 4)"><B><i>OPEN settings</B></i></a></td>
       </tr>
<tr id="STP_tr_1" style="display:none">
 <td>Your SolidTrustPay account:</td>
 <td><input type=text name="def_payee_account_solidtrustpay" value=\'';
  echo quote ($settings['def_payee_account_solidtrustpay']);
  echo '\'class=inpts size=30></td>
</tr><tr id="STP_tr_2" style="display:none">
 <td>Secret Secondary Password md5 hash:</td>
 <td><input type=text name="md5altphrase_solidtrustpay" value=\'';
  echo quote ($settings['md5altphrase_solidtrustpay']);
  echo '\' class=inpts size=45></td>
</tr><tr id="STP_tr_3" style="display:none">
 <td>Secondary Password:</td>
 <td><input type=text name=\'stpap\' class=inpts size=30> <input type=button class=sbmt onclick="document.mainform.md5altphrase_solidtrustpay.value = calcMD5(document.mainform.stpap.value + \'s+E_a*\').toLowerCase()" value="Calculate MD5 hash"></td>
</tr>
</tr><tr id="STP_tr_4" style="display:none">
      <td colspan=2>';
  echo start_info_table ('100%');
  echo 'Specify your SolidTrustPay account settings for income transfers here. Clear 
        this field to disable SolidTrustPay deposits.<br>SolidTrustPay account: Account to receive STP deposits.<br>SolidTrustPay Secondary Password: Type here your secondary password<br>Secret Secondary Password md5 hash: After you type your secondary password press Calculate MD5 Hash to get Secret Secondary Password<br><br><bTry to buy a product to test settings.</b><br>';
  echo end_info_table ();
  echo '</td></tr><tr>
         <td colspan=2>&nbsp;<br>
		  <img src="images/pay/3.gif"> <b>V-Money settings:</b> <a href="javascript:open_payment_settings(\'VMoney\', 4)"><B><i>OPEN settings</B></i></a></td>
       </tr>
<tr id="VMoney_tr_1" style="display:none">
 <td>Your V-Money account number:</td>
 <td><input type=text name="def_payee_account_vmoney" value=\'';
  echo quote ($settings['def_payee_account_vmoney']);
  echo '\'class=inpts size=30></td>
</tr><tr id="VMoney_tr_2" style="display:none">
 <td>MD5 hash of Merchant Password:</td>
 <td><input type=text name=\'md5altphrase_vmoney\' value=\'';
  echo quote (decode_pass_for_mysql ($settings['md5altphrase_vmoney']));
  echo '\' class=inpts size=30></td>
</tr><tr id="VMoney_tr_3" style="display:none">
 <td>Merchant Password:</td>
 <td><input type=text name=\'vmmp\' class=inpts size=30> <input type=button class=sbmt onclick="document.mainform.md5altphrase_vmoney.value = calcMD5(document.mainform.vmmp.value).toLowerCase(); document.mainform.vmmp.value = \'\'" value="Calculate MD5 hash"></td></tr>
<tr id="VMoney_tr_4" style="display:none">
      <td colspan=2>';
  echo start_info_table ('100%');
  echo 'Specify your V-Money account settings for income transfers here. Clear 
        this field to disable V-Money deposits.<br>V-Money account: Account to receive V-Money deposits.<br>V-Money Merchant Password: Type here your Merchant password<br><br><b>Try to buy a product to test settings.</b><br>';
  echo end_info_table ();
  echo '</td></tr><tr>
         <td colspan=2>&nbsp;<br>
		  <img src="images/pay/4.gif"> <b>AlertPay settings:</b> <a href="javascript:open_payment_settings(\'ALP\', 3)"><B><i>OPEN settings</B></i></a></td>
       </tr>
<tr id="ALP_tr_1" style="display:none">
 <td>Your AlertPay account:</td>
 <td><input type=text name="def_payee_account_alertpay" value=\'';
  echo quote ($settings['def_payee_account_alertpay']);
  echo '\'class=inpts size=30></td>
</tr><tr id="ALP_tr_2" style="display:none">
 <td>Encrypted Security Code:</td>
 <td><input type=text name="md5altphrase_alertpay" value=\'';
  echo quote ($settings['md5altphrase_alertpay']);
  echo '\' class=inpts size=30></td>
</tr><tr id="ALP_tr_3" style="display:none">
      <td colspan=2>';
  echo start_info_table ('100%');
  echo '        Your AlertPay account:<br>
        Login (E-mail address) to receive deposits. Clear this field to disable AlertPay deposits.<br><br>Important to do first:<br>
        1. Rename file "alertpay_processing.php" to any name with .php extension. 
        Do not provide this name to any person.<br>
        2. Login to your AlerPay account.<br>

        3. Click on "Sell Online" link in top menu.<br>
        4. Click on "IPN Settings" link on the currently opened page.<br>
        5. Check \'Enable IPN\' box.<br>
        6. Type in \'Default Alert URL\' URL to file you just rename in the instruction number 1.<br>
        7. Enter some string into \'Security Code\' field. No metter what you will enter just try to enter something unique - you should not remember this string.<br>
        8. Push \'Submit\' button. Page will reload and you will see \'Encrypted Security Code\'. You will receive something like this:<br>

        Encrypted Security Code: XXXXXXXXXXXXXXXXXXXXXXXXXXXXX<br>
        9. Copy and paste this string to "Encrypted Security Code" field on this page.<br>
<br>
        <b>Try to buy a product to test settings.</b><br>';
  echo end_info_table ();
  echo '</td></tr><tr>
         <td colspan=2>
		   &nbsp;<br>
		   <img src="images/pay/0.gif"> <b>E-gold account settings:</b> <a href="javascript:open_payment_settings(\'EGold\', 6)"><B><i>OPEN settings</b></i></a>
		 </td>
       </tr>
<tr id="EGold_tr_1" style="display:none">
 <td>Your e-gold account number:</td>
 <td><input type=text name=\'def_payee_account\' value=\'';
  echo quote ($settings['def_payee_account']);
  echo '\' class=inpts size=30></td>
</tr>
<tr id="EGold_tr_2" style="display:none">
 <td>Your e-gold account name:</td>
 <td><input type=text name=\'def_payee_name\' value=\'';
  echo quote ($settings['def_payee_name']);
  echo '\' class=inpts size=30></td>
</tr>
<tr id="EGold_tr_3" style="display:none">
 <td>Secret alternate password md5 hash:</td>
 <td><input type=text name=\'md5altphrase\' value=\'';
  echo quote ($settings['md5altphrase']);
  echo '\' class=inpts size=30></td>
</tr>
<tr id="EGold_tr_4" style="display:none">
 <td>Alternate Password:</td>
 <td><input type=text name=\'egoldap\' class=inpts size=30> <input type=button class=sbmt onclick="document.mainform.md5altphrase.value = calcMD5(document.mainform.egoldap.value)" value="Calculate MD5 hash"></td>
</tr>
<tr id="EGold_tr_5" style="display:none">
   <td colspan=2> 
        ';
  echo start_info_table ('100%');
  echo '        Specify your e-gold account settings for income transfers here. Clear 
        this field to disable e-gold deposits.<br>
          Your e-gold account no: Account to receive deposits.<br>
          Your e-gold account name: your e-gold screen name.<br>
          Secret alternate password md5 hash:<br>
        1. Go to https://www.e-gold.com/acct/md5check.html<br>
        2. Type your alternative passphrase in &quot;Alternate Passphrase&quot; 
        field<br>
        3. Click on &quot;calculate hash now&quot; button<BR>
        4. Copy &quot;Passphrase Hash&quot; into the &quot;Secret alternate password 
        md5 hash&quot; field.<br><br>
          <b>Try to buy a product to test settings.</b><br>';
  echo end_info_table ();

  echo '</td></tr><tr>
         <td colspan=2>
         &nbsp;<br>
         <img src="images/pay/12.gif"> <b>iGolds settings</b> <a href="javascript:open_payment_settings(\'iGolds\', 3)"><B><i>OPEN settings</b></i></a>
        </td>
      </tr>
<tr id="iGolds_tr_1" style="display:none">
 <td>Your iGolds account number:</td>
 <td><input type=text name=\'def_payee_account_igolds\' value=\'';
  echo quote ($settings['def_payee_account_igolds']);
  echo '\' class=inpts size=30></td>
</tr>
<tr id="iGolds_tr_2" style="display:none">
 <td>Merchant password:</td>
 <td><input type=text name=\'md5altphrase_igolds\' value=\'';
  echo quote (decode_pass_for_mysql($settings['md5altphrase_igolds']));
  echo '\' class=inpts size=30></td>
</tr>
<tr id="iGolds_tr_3" style="display:none">
   <td colspan=2> 
        ';
  echo start_info_table ('100%');
  echo '        Specify your iGolds account settings for income transfers here. Clear 
        this field to disable iGolds deposits.<br>
          Your iGolds account number: Account to receive deposits.<br>
          Merchant password:<br>
        1. Go to http://www.igolds.net<br>
        2. Login to your iGolds account<br>
        3. Click on "Account" button<br>
        4. Type your merchant password in &quot;Merchant password&quot; field<br><br>
          <b>Try to buy a product to test settings.</b><br>';

  echo end_info_table ();
  echo '</td></tr><tr>
         <td colspan=2>
         &nbsp;<br>
         <img src="images/pay/9.gif"> <b>Pecunix settings</b> <a href="javascript:open_payment_settings(\'Pecunix\', 3)"><B><i>OPEN settings</b></i></a>
        </td>
      </tr>
<tr id="Pecunix_tr_1" style="display:none">
 <td>Your Pecunix account:</td>
 <td><input type=text name=\'def_payee_account_pecunix\' value=\'';
  echo quote ($settings['def_payee_account_pecunix']);
  echo '\' class=inpts size=30></td>
</tr>
<tr id="Pecunix_tr_2" style="display:none">
 <td>Sdared Secret:</td>
 <td><input type=text name=\'md5altphrase_pecunix\' value=\'';
  echo quote (decode_pass_for_mysql ($settings['md5altphrase_pecunix']));
  echo '\' class=inpts size=30></td>
</tr>
<tr id="Pecunix_tr_3" style="display:none">
      <td colspan=2> ';
  echo start_info_table ('100%');
  echo '        Your Pecunix account number:<br>
        Account to receive deposits. Clear this field to disable Pecunix deposits.<br>
<br>Shared Secret:<br>
        1. Login to your Pecunix account<br>
        2. Click on "Account Details" link<br>
        3. Click on "Merchant Settings" link on the currently opened page<br>
        4. Copy and paste "Shared Secret" string to field in thi form<br>
        5. In "Hash algorithm used for payment confirmation" select \'MD5\' option and save settings.<br>
<br><b>Try to buy a product to test settings.</b><br>';
  echo end_info_table ();
  echo '</td>
</tr><tr><td colspan=2>&nbsp;<br><img src="images/pay/5.gif"> <b>e-Bullion settings</b> <a href="javascript:open_payment_settings(\'eBullion\', 8)"><B><i>OPEN settings</b></i></a></td></tr>
  
 <tr id="eBullion_tr_1" style="display:none">
   <td>GPG Path:</td> <td><input type=text name=\'gpg_path\' value=\'';
  echo quote ($settings['gpg_path']);
  echo '\' class=inpts size=30> ';
  echo ($gpg_version != '' ? 'Version: ' . $gpg_version : '');
  echo '</td></tr>
  <tr id="eBullion_tr_2" style="display:none">';
  if ($gpg_version != '')
  {
    echo ' <td>Your e-Bullion account ID:</td>
 <td><input type=text name=\'def_payee_account_ebullion\' value=\'';
    echo quote ($settings['def_payee_account_ebullion']);
    echo '\' class=inpts size=30></td>
</tr>
<tr id="eBullion_tr_2" style="display:none">
 <td>Your e-Bullion account Name:</td>
 <td><input type=text name=\'def_payee_name_ebullion\' value=\'';
    echo quote ($settings['def_payee_name_ebullion']);
    echo '\' class=inpts size=30></td>
</tr>
<tr id="eBullion_tr_3" style="display:none">
 <td>GPG Passphrase:</td>
 <td><input type=text name=\'md5altphrase_ebullion\' value=\'';
    echo quote ($settings['md5altphrase_ebullion']);
    echo '\' class=inpts size=30></td>
</tr>
<tr id="eBullion_tr_4" style="display:none">
 <td>GPG key ID:</td>
 <td><input type=text name=\'ebullion_keyID\' value=\'';
    echo quote ($settings['ebullion_keyID']);
    echo '\' class=inpts size=30></td>
</tr>
<tr id="eBullion_tr_5" style="display:none">
 <td colspan=2>
';
    echo start_info_table ('100%');
    echo '        Your e-Bullion account number:<br>
        Account to receive deposits. Clear this field to disable e-Bullion deposits.<br>
<br>
        All required data for e-Bullion usage is included in the customized for your account downlodable ATIP SDK.<br>
        To download it please login to your e-Bullion account then click on \'Account Settings\' in the left menu and then on \'ATIP Settings\' in the newly opened window. In the bottom of the last page you will see the link \'ATIP SDK Download: (Customized for BXXXXXX)\'. Click it to download SDK archive.<br>
        Unpack the archive onto your local computer and choose the next files in the fields below:<br>
        <table cellspacing=0 cellpadding=2 border=0>
         <tr><td>atip.pl :</td><td><input type=file name=atip_pl class=inpts></td><td>';
    if ($settings['def_payee_account_ebullion'])
    {
      (true ? $settings['md5altphrase_ebullion'] : '<b style="color: green">OK</b>');
    }

    echo '<b style="color: red">NO</b>';
    echo '</td></tr>
         <tr><td>status.php :</td><td><input type=file name=status_php class=inpts></td><td>';
    echo ($settings['ebullion_keyID'] ? '<b style="color: green">OK</b>' : '<b style="color: red">NO</b>');
    echo '</td></tr>
         <tr><td>pubring.gpg :</td><td><input type=file name=pubring_gpg class=inpts></td><td>';
    echo (is_file ('./tmpl_c/pubring.gpg') ? '<b style="color: green">OK</b>' : '<b style="color: red">NO</b>');
    echo '</tr>
         <tr><td>secring.gpg :</td><td><input type=file name=secring_gpg class=inpts></td><td>';
    echo (is_file ('./tmpl_c/secring.gpg') ? '<b style="color: green">OK</b>' : '<b style="color: red">NO</b>');
    echo '</tr>
        </table>
        then save settings. The system will parse the selected files and will get the required information which you will see in the fields above. You will have to enter your e-Bullion account name then.<br><br>
<br><br>
<input value="Test e-bullion" type="button" onclick="window.open(\'?a=test_ebullion_settings\', \'_testebullion\', \'width=400, height=200, status=0\');" class=sbmt><br>e-bullion processing works if your can see your balance after pressing the "Test" button.<br><br><b>login as user and try to deposit.</b><br>';
    echo end_info_table ();
    echo ' </td></tr><tr>';
  }
  else
  {
    echo ' <td colspan=2>';
    echo start_info_table ('100%');
    echo 'To use e-Bullion payment system in automatical mode you must have the GPG (GnuPG) installed on your server and know the full path to it.<br>
If you do not know whether you have the GPG installed on your server please contact your hosting provider.<br>
After you obtain the path to the GPG program place it in the field above and save settings. You will see more fields for e-Bullion data.
';
    echo end_info_table ();
    echo ' </td>
</tr>';
  }

  if (function_exists ('curl_init'))
  {
    echo '<tr> 
	       <td colspan=2>&nbsp;<br><img src="images/pay/6.gif"> <b>PayPal account settings:</b> <a href="javascript:open_payment_settings(\'PayPal\', 3)"><B><i>OPEN settings</b></i></a></td>
          </tr>

<tr id="PayPal_tr_1" style="display:none">
 <td>Your PayPal account e-mail:</td>
 <td>
  <input type=text name=\'def_payee_account_paypal\' value=\'';
    echo quote ($settings['def_payee_account_paypal']);
    echo '\' class=inpts size=30>
 </td>
</tr>
<tr id="PayPal_tr_2" style="display:none">
 <td>Demo mode on</td>
 <td>
   <input name=\'paypal_demo\' type=\'checkbox\' value=1 ';
    echo ($settings[paypal_demo] == 1 ? 'checked' : '');
    echo '>Set Paypal Sandbox on
  </td>
</tr>
<tr id="PayPal_tr_3" style="display:none">
      <td colspan=2> 
        ';
    echo start_info_table ('100%');
    echo 'Specify your PayPal account settings for income transfers here. Clear this field to disable PayPal deposits.<br><b>Demo Mode:</b> Thik this box if you want to test PayPal deposits. Un tick it when site goes live.';
    echo end_info_table ();
    echo '</td></tr>';
  }

  echo '<tr>
         <td colspan=2>&nbsp;<br>
		  <img src="images/pay/7.gif"> <b>C-Gold settings:</b> <a href="javascript:open_payment_settings(\'Cgold\', 3)"><B><i>OPEN settings</B></i></a></td>
       </tr>
<tr id="Cgold_tr_1" style="display:none">
 <td>Your C-gold account:</td>
 <td><input type=text name="def_payee_account_cgold" value=\'';
  echo quote ($settings['def_payee_account_cgold']);
  echo '\'class=inpts size=30></td>
</tr><tr id="Cgold_tr_2" style="display:none">
 <td>Merchant Password:</td>
 <td><input type=text name="md5altphrase_cgold" value=\'';
  echo quote (decode_pass_for_mysql ($settings['md5altphrase_cgold']));
  echo '\' class=inpts size=30></td>
</tr></tr><tr id="Cgold_tr_3" style="display:none">
      <td colspan=2>';
  echo start_info_table ('100%');
  echo 'Specify your C-Gold account settings for income transfers here. Clear 
        this field to disable C-Gold deposits.<br>C-Gold Account: Account to receive C-gold deposits.<br> Merchant Password: Type here your Merchant password<br><br><b>Try to make a deposit to test settings.</b><br>';
  echo end_info_table ();
  echo '</td></tr><tr>
         <td colspan=2>&nbsp;<br>
		  <img src="images/pay/8.gif"> <b>AlterGold settings:</b> <a href="javascript:open_payment_settings(\'AlterGold\', 3)"><B><i>OPEN settings</B></i></a></td>
       </tr>
<tr id="AlterGold_tr_1" style="display:none">
 <td>Your AlterGold account:</td>
 <td><input type=text name="def_payee_account_altergold" value=\'';
  echo quote ($settings['def_payee_account_altergold']);
  echo '\'class=inpts size=30></td>
</tr><tr id="AlterGold_tr_2" style="display:none">
 <td>Account Alternative Password:</td>
 <td><input type=text name="md5altphrase_altergold" value=\'';
  echo quote (decode_pass_for_mysql ($settings['md5altphrase_altergold']));
  echo '\' class=inpts size=30></td>
</tr></tr><tr id="AlterGold_tr_3" style="display:none">
      <td colspan=2>';
  echo start_info_table ('100%');
  echo 'Specify your AlterGold account settings for income transfers here. Clear 
        this field to disable AlterGold deposits.<br>AlterGold account: Account to receive AlterGold deposits.<br>AlterGold Alternative Password: Type here your ALT secondary password<br><br><b>Try to buy a product to test settings.</b><br>';
  echo end_info_table ();
  echo '</td></tr>
  <tr>
   <td colspan=2>
     &nbsp;<br><img src="images/pay/10.gif"> <b>Perfect Money account settings:</b> <a href="javascript:open_payment_settings(\'PerfectMoney\', 5)"><B><i>OPEN settings</i></B></a>
   </td>
 </tr>
 <tr id="PerfectMoney_tr_1" style="display:none">
  <td>Your Perfect Money USD account number:</td>
  <td><input type=text name=\'def_payee_account_perfectmoney\' value=\'';
  echo quote ($settings['def_payee_account_perfectmoney']);
  echo '\' class=inpts size=30></td>
 </tr>
 <tr id="PerfectMoney_tr_2" style="display:none">
  <td>Your Perfect Money account name:</td>
  <td><input type=text name=\'def_payee_name_perfectmoney\' value=\'';
  echo quote ($settings['def_payee_name_perfectmoney']);
  echo '\' class=inpts size=30></td>
</tr>
<tr id="PerfectMoney_tr_3" style="display:none">
 <td>Alternate password md5 hash:</td>
 <td><input type=text name=\'md5altphrase_perfectmoney\' value=\'';
  echo quote ($settings['md5altphrase_perfectmoney']);
  echo '\' class=inpts size=30></td>
</tr>
<tr id="PerfectMoney_tr_4" style="display:none">
 <td>Alternate Password:</td>
 <td><input type=text name=\'perfectmoneyap\' class=inpts size=30> <input type=button class=sbmt onclick="document.mainform.md5altphrase_perfectmoney.value = calcMD5(document.mainform.perfectmoneyap.value); document.mainform.perfectmoneyap.value = \'\'" value="Calculate MD5 hash"></td>
</tr>
<tr id="PerfectMoney_tr_5" style="display:none">
      <td colspan=2>';
  echo start_info_table ('100%');
  echo 'Specify your Perfect Money account settings for income transfers here. Clear this field to disable Perfect Money deposits.<br>Your Perfect Money USD account no: an USD account to receive deposits.<br>Your Perfect Money account name: your Perfect Money screen name.<br>Secret alternate password md5 hash:<br>1. Type your alternative passphrase in &quot;Alternate Passphrase&quot; field<br>2. Click on &quot;calculate hash now&quot; button<BR> <b>login as a user and try to deposit to test settings.</b><br><br>';
  echo end_info_table ();
  echo '</td></tr>
  <tr>
   <td colspan=2>
     &nbsp;<br><img src="images/pay/11.gif"> <b>StrictPay account settings:</b> <a href="javascript:open_payment_settings(\'StrictPay\', 3)"><B><i>OPEN settings</i></B></a>
   </td>
 </tr>
 <tr id="StrictPay_tr_1" style="display:none">
  <td>Your StrictPay account number:</td>
  <td><input type=text name=\'def_payee_account_strictpay\' value=\'';
  echo quote ($settings['def_payee_account_strictpay']);
  echo '\' class=inpts size=30></td>
 </tr>
<tr id="StrictPay_tr_2" style="display:none">
 <td>Your StrictPay Access Code:</td>
 <td><input type=text name=\'md5altphrase_strictpay\' value=\'';
  echo quote (decode_pass_for_mysql ($settings['md5altphrase_strictpay']));
  echo '\' class=inpts size=30></td>
</tr>
<tr id="StrictPay_tr_3" style="display:none">
      <td colspan=2>';
  echo start_info_table ('100%');
  echo 'Specify your StrictPay account settings for income transfers here. Clear this field to disable StrictPay deposits.<br>Your StrictPay account no: account to receive deposits (number not email).<br>Your StrictPay access code: Type the access code you set up on StrictPay sign up here.<BR> <b>login as a user and try to deposit to test settings.</b><br><br>';
  echo end_info_table ();
  echo '</td></tr><td>&nbsp;</td>

 <td><input type=submit value="Change settings" class=sbmt></td>
</tr></table>
</form><script language="JavaScript">
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