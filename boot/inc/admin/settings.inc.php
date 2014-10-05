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


  $month = array ('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
  $admin_stat_password = '';
  $q = 'SELECT * FROM hm2_users WHERE id=1';
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  while ($row = mysql_fetch_array ($sth))
  {
    if ($row['stat_password'] != '')
    {
      $admin_stat_password = '*****';
      continue;
    }
    else
    {
/*-- Remarked by deZender, 2008.8.1: begin --
      if (!($row['came_from'] == $mddomain))
      {
        exit ();
      }
-- Remarked by deZender, 2008.8.1: end --*/

      continue;
    }
  }

  if ($settings['demomode'] == 1)
  {
    echo start_info_table ('100%');
    echo '<b>Demo version restriction!</b><br>You cannot edit settings! ';
    echo end_info_table ();
  }

  $settings['use_alternative_passphrase'] = ($userinfo['transaction_code'] != '' ? 1 : 0);
  if ($frm['say'] == 'invalid_passphrase')
  {
    echo '<b style="color:red">Invalid Alternative Passphrase. No data has been updated.</b><br><br>';
  }

  if ($frm['say'] == 'done')
  {
    echo '<b style="color:green">Changes has been successfully saved.</b><br><br>';
  }

  echo '  
<script language=javascript>

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
  }';
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
<input type=hidden name=a value=settings>
<input type=hidden name=action value=settings>

<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td colspan=2><b>Main settings:</b><br><br></td>
</tr><tr>
 <td>Site name:</td>
 <td><input type=text name=site_name value=\'' . quote ($settings['site_name']) . '\' class=inpts size=30></td>
</tr>
<tr>
 <td>Site url:</td>
 <td><input type=text name=site_url value=\'' . quote ($settings['site_url']) . '\' class=inpts size=30></td>
</tr>
<tr>
 <td>Start day:</td>
 <td>';
  echo '<select name=site_start_day class=inpts>';
  for ($i = 1; $i < 32; ++$i)
  {
    echo '<option value=';
    echo $i;
    echo ' ';
    echo ($i == $settings['site_start_day'] ? 'selected' : '');
    echo '>';
    echo $i;
  }

  echo '</select><select name=site_start_month class=inpts>';
  for ($i = 0; $i < sizeof ($month); ++$i)
  {
    echo '<option value=';
    echo $i + 1;
    echo ' ';
    echo ($i + 1 == $settings['site_start_month'] ? 'selected' : '');
    echo '>';
    echo $month[$i];
  }

  echo '</select><select name=site_start_year class=inpts>';
  for ($i = date ('Y') - 2; $i <= date ('Y'); ++$i)
  {
    echo '<option value=';
    echo $i;
    echo ' ';
    echo ($i == $settings['site_start_year'] ? 'selected' : '');
    echo '>';
    echo $i;
  }

  echo '</select>
 </td>
</tr><tr>
<td colspan=2><input type=checkbox name=reverse_columns value=1 ';
  echo ($settings['reverse_columns'] == 1 ? 'checked' : '');
  echo '> Reverse left and right columns</td>
</tr><tr>
      <td colspan=2> 
        ';
  echo start_info_table ('100%');
  echo 'Site name: your site title.<br>
        Site url: your site url, without tailing slash (http://yoursite.com for 
        example).<br>
        Start day: shows days online. Select the date you have launched your site here.<br>
	Reverse left and right columns. If the (this) box is unchecked, the user menu will be located on the left and news box on the right. If checked: news on the left, user menu on the right';
  echo end_info_table ();
  echo '</td></tr>
<tr>
 <td colspan=2>&nbsp;<br>
        <b>Administrator login settings:</b></td>
</tr>
<tr>
 <td>Login:</td>
 <td><input type=text name=admin_login value=\'' . quote ($userinfo['username']) . '\' class=inpts size=30></td>
</tr>
<tr>
 <td>Password:</td>
 <td><input type=password name=admin_password value=\'\' class=inpts size=30></td>
</tr>
<tr>
 <td>Retype password:</td>
 <td><input type=password name=admin_password2 value=\'\' class=inpts size=30></td>
</tr>
<tr>
 <td>Administrator e-mail:</td>
 <td><input type=text name=admin_email value=\'' . quote ($userinfo['email']) . '\' class=inpts size=30></td>
</tr>
<tr>
 <td>Notify admin when settings change:</td>
 <td>';
  echo '<select name=notify_on_change class=inpts><option>???<option value=1 ';
  echo ($settings['notify_on_change'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['notify_on_change'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr>
<tr>
  <td colspan=2>';
  echo start_info_table ('100%');
  echo 'Administrator login settings: type a new login and a password here to login in admin area.!';
  echo end_info_table ();
  echo '</td>
    </tr><tr>
 <td colspan=2>&nbsp;<br><b>Other settings:</b></td>
</tr>
<tr>
 <td>Deny registrations:</td>
 <td><select name=deny_registration class=inpts><option>???<option value=1 ';
  echo ($settings['deny_registration'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['deny_registration'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr>
<tr>
 <td>Double opt-in during registration:</td>
 <td><select name=use_opt_in class=inpts><option>???<option value=1 ';
  echo ($settings['use_opt_in'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['use_opt_in'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr>
<tr>
 <td>Opt-in e-mail:</td>
 <td><input type=text name=opt_in_email value=\'' . quote ($settings['opt_in_email']) . '\' class=inpts size=30>
</tr>
<tr>
 <td>Use user location fields:</td>
 <td>';
  echo '<select name=use_user_location class=inpts><option>???<option value=1 ';
  echo ($settings['use_user_location'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['use_user_location'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr>
<tr>
 <td>Minimal user password length:</td>
 <td><input type=text name=min_user_password_length value=\'';
  echo quote ($settings['min_user_password_length']);
  echo '\' class=inpts size=6>
</tr>
<tr>
 <td>System e-mail:</td>
 <td><input type=text name=system_email value=\'' . quote ($settings['system_email']) . '\' class=inpts size=30>
</tr>
<tr>
 <td>Enable Calculator:</td>
 <td>';
  echo '<select name=enable_calculator class=inpts><option>???<option value=1 ';
  echo ($settings['enable_calculator'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['enable_calculator'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr><tr>
 <td>Use double entry accounting:</td>
 <td><select name=use_history_balance_mode class=inpts><option>???<option value=1 ';
  echo ($settings['use_history_balance_mode'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['use_history_balance_mode'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr><tr>
 <td>Redirect to HTTPS:</td>
 <td>
  <table cellspacing=0 cellpadding=0 border=0><tr>
   <td><select name=redirect_to_https class=inpts><option>???<option value=1 ';
  echo ($settings['redirect_to_https'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['redirect_to_https'] == 0 ? 'selected' : '');
  echo '>No</select></td>
   <td style="padding-left:5px">';
  echo '<small>Do not change this option if you don\'t exactly know how does it work.</small></td></tr></table>
 </td>
</tr><tr>
 <td>Withdrawal Fee (%):</td>
 <td><input type=text name=withdrawal_fee value=\'' . quote ($settings['withdrawal_fee']) . '\' class=inpts size=6></td>
</tr>
<tr>
 <td>Minimal Withdrawal Fee ($):</td>
 <td><input type=text name=withdrawal_fee_min value=\'';
  echo quote ($settings['withdrawal_fee_min']);
  echo '\' class=inpts size=6></td>
</tr><tr>
 <td>Minimal Withdrawal Amount ($):</td>
 <td><input type=text name=min_withdrawal_amount value=\'';
  echo quote ($settings['min_withdrawal_amount']);
  echo '\' class=inpts size=6></td>
</tr>
      <td colspan=2> 
        ';
  echo start_info_table ('100%');
  echo '<B>Double opt-in when registering:</b> Select \'yes\' if a user has to confirm the 
        registration. An E-mail with the confirmation code will be sent to the user 
        after he had submitted the registration request.<br>
<B>Opt-in e-mail:</b> Confirmation messages will be sent from this e-mail account.<br>
<b>System e-mail:</b> All system messages will be sent from this e-mail account.<br>
        Use<B>User location fields:</b> Adds &quot;Address&quot;, &quot;City&quot;, 
        &quot;State&quot;, &quot;Zip&quot; and &quot;Country&quot; fields to user\'s 
        profile.<br>
        <b>Min user password length:</b> Specifies the minimal user password and the 
        transaction code length.<br>
		<B>Use double entry accounting:</b> This mod is used for the transactions history screen in both users and admin areas. It shows three different columns - "Debit", "Credit" and "Balance" instead of one "Amount" field.<br>
        ';
  $https_site_url = preg_replace ('/http:/', 'https:', $settings['site_url']);
  echo '<B>Redirect to HTTPS:</b> Redirects users from HTTP to HTTPS. Use this option 
        only if you can access your site using https. You should go to <a href="';
  echo $https_site_url;
  echo '" target=_blank> 
        ';
  echo $https_site_url;
  echo '        </a> and your site will be displayed if the HTTPS is supported.<br>
';
  echo end_info_table ();
  echo '</td>
</tr><tr>
 <td colspan=2>&nbsp;<br><b>User settings:</b></td>
</tr><tr>
 <td>Users should use a transaction code to withdraw:</td>
 <td><select name=use_transaction_code class=inpts><option>???<option value=1 ';
  echo ($settings['use_transaction_code'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['use_transaction_code'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr><tr>
 <td>Use confirmation code when account update:</td>
 <td><select name=account_update_confirmation class=inpts><option>???<option value=1 ';
  echo ($settings['account_update_confirmation'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['account_update_confirmation'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr><tr>
      <td>Change e-gold account:</td>
 <td><select name=usercanchangeegoldacc class=inpts><option>???<option value=1 ';
  echo ($settings['usercanchangeegoldacc'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['usercanchangeegoldacc'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr><tr>
 <td>Change e-mail:</td>
 <td><select name=usercanchangeemail class=inpts><option>???<option value=1 ';
  echo ($settings['usercanchangeemail'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['usercanchangeemail'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr><tr>
      <td>Notify user of his profile change:</td>
 <td><select name=sendnotify_when_userinfo_changed class=inpts><option>???<option value=1 ';
  echo ($settings['sendnotify_when_userinfo_changed'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['sendnotify_when_userinfo_changed'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr><tr>
 <td>Allow internal transfer:</td>
 <td><select name=internal_transfer_enabled class=inpts><option>???<option value=1 ';
  echo ($settings['internal_transfer_enabled'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['internal_transfer_enabled'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr><tr>
 <td>Allow Deposit to Account:</td>
 <td><select name=use_add_funds class=inpts><option>???<option value=1 ';
  echo ($settings['use_add_funds'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['use_add_funds'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr><tr>
 <td>Max daily withdraw:</td>
 <td><input type=text name=max_daily_withdraw class=inpts value=\'';
  echo sprintf ('%0.2f', $settings['max_daily_withdraw']);
  echo '\' style=\'text-align: right\'> <small>(0 for unlimited)</small></td>
</tr><tr>
      <td colspan=2> 
        ';
  echo start_info_table ('100%');
  echo '        Here you can specify whether user can change his own e-gold or e-mail 
        account after registration.<br>
        Also system can send e-mail to user when he changes his profile (for security 
        reason).<br>
        Users should use transaction code to withdraw: Specifies an additional 
        password which is needed to do the withdrawal. That password can be restored 
        by the administrator only. It is stored in MySQL database in plain format. 
        ';
  echo end_info_table ();
  echo '      </td>
    </tr><tr>
 <td>&nbsp;<br><b>Turing verification:</b></td>
</tr><tr>
 <td>Use turing verification:</td>
 <td><select name=graph_validation class=inpts><option>???<option value=1 ';
  echo ($settings['graph_validation'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['graph_validation'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr><tr>
      <td>Number of characters in the turing image:</td>
 <td><input type=text name=graph_max_chars value="';
  echo $settings['graph_max_chars'];
  echo '" class=inpts size=10></td>
</tr><tr>
 <td colspan=2><input type=checkbox name=use_number_validation_number value=1 ';
  echo ($settings[use_number_validation_number] == 1 ? 'checked' : '');
  echo '> Show numbers only in the validation image</td>
</tr><tr>
 <td>Turing image text color:</td>
 <td><input type=text name=graph_text_color value="';
  echo $settings['graph_text_color'];
  echo '" class=inpts size=10></td>
</tr><tr>
 <td>Turing image bg color:</td>
 <td><input type=text name=graph_bg_color value="';
  echo $settings['graph_bg_color'];
  echo '" class=inpts size=10></td>
</tr>
';
  if (!((!function_exists ('imagettfbbox') AND !($settings['demomode'] == 1))))
  {
    echo '<tr>
 <td>Use advanced turing verification:</td>
 <td><select name=advanced_graph_validation class=inpts><option>???<option value=1 ';
    echo ($settings['advanced_graph_validation'] == 1 ? 'selected' : '');
    echo '>Yes<option value=0 ';
    echo ($settings['advanced_graph_validation'] == 0 ? 'selected' : '');
    echo '>No</select></td>
</tr>
<tr>
 <td>Font minimal size:</td>
 <td><input type=text name=advanced_graph_validation_min_font_size value="';
    echo $settings['advanced_graph_validation_min_font_size'];
    echo '" class=inpts size=10></td>
</tr>
<tr>
 <td>Font maximal size:</td>
 <td><input type=text name=advanced_graph_validation_max_font_size value="';
    echo $settings['advanced_graph_validation_max_font_size'];
    echo '" class=inpts size=10></td>
</tr>
';
  }

  echo '<tr>
      <td colspan=2> 
        ';
  echo start_info_table ('100%');
  echo '        You can use the turing image for verification when users login to the system. 
        It will stop brute force scripts from hacking passwords.<br>
        Change the text and background color of the turing image here.<br>
        Use advanced turing verification: Creates a turing image with the font 
        \'fonts/font.ttf\' (you can upload any TTF font into this file). The font 
        size (in a range specified in &quot;Font min size&quot; and &quot;Font 
        max size&quot;) and angle are random for each char. White noise is added 
        into the final image. 
        ';
  echo end_info_table ();
  echo '      </td>
    </tr>
<tr>
 <td>&nbsp;<br><b>Brute force handler:</b></td>
</tr><tr>
 <td>Prevent brute force:</td>
 <td><select name=brute_force_handler class=inpts><option>???<option value=1 ';
  echo ($settings['brute_force_handler'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['brute_force_handler'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr><tr>
 <td>Max invalid tries:</td>
 <td><input type=text name=brute_force_max_tries value="';
  echo $settings['brute_force_max_tries'];
  echo '" class=inpts size=10></td>
</tr><tr>
      <td colspan=2> 
        ';
  echo start_info_table ('100%');
  echo '        Prevent brute force: Turns on the brute force prevention system.<br>
        Max invalid tries: The number of invalid login tries. The login is being 
        blocked if one tries to login more than specified here number of times 
        with the invalid password. The e-mail message with an activation link 
        is generated and being sent to a user. One cannot login even with a correct 
        password before the account activation. 
        ';
  echo end_info_table ();
  echo '      </td>
    </tr><tr>
 <td>&nbsp;</td>
</tr><tr>
 <td>&nbsp;<br><b>Time settings:</b></td>
</tr><tr>
 <td>Server time:</td>
 <td>';
  echo date ('dS of F Y h:i:s A');
  echo '</td>
</tr><tr>
 <td>System time:</td>
 <td>';
  echo date ('dS of F Y h:i:s A', time () + $settings['time_dif'] * 60 * 60);
  echo '</td>
</tr><tr>
 <td>Difference:</td>
 <td><input type=text name=time_dif value="';
  echo $settings['time_dif'];
  echo '" class=inpts size=10> hours</td>
</tr><tr>
      <td colspan=2> 
        ';
  echo start_info_table ('100%');
  echo '        Change your system time. You can set the system to show all dates for 
        your time zone. 
        ';
  echo end_info_table ();
  echo '</td>
    </tr><tr>
 <td>&nbsp;</td>
</tr>
<tr>
 <td colspan=2>&nbsp;<br><b>Administrator Alternative Passphrase:</b></td>
</tr><tr>
<tr>
 <td>Use admin alternative passphrase:</td>
 <td><select name=use_alternative_passphrase class=inpts><option>???<option value=1 ';
  echo ($settings['use_alternative_passphrase'] == 1 ? 'selected' : '');
  echo '>Yes<option value=0 ';
  echo ($settings['use_alternative_passphrase'] == 0 ? 'selected' : '');
  echo '>No</select></td>
</tr>
<tr>
 <td>New alternative passphrase:</td>
 <td><input type=password name=new_alternative_passphrase value="" class=inpts size=30></td>
</tr>
<tr>
 <td>Confirm New alternative passphrase:</td>
 <td><input type=password name=new_alternative_passphrase2 value="" class=inpts size=30></td>
</tr>
<tr>
      <td colspan=2> 
        ';
  echo start_info_table ('100%');
  echo '        This feature raises the security level for the administrator area. If 
        enabled Administrator can change \'Settings\', \'Auto-Withdrawal Settings\' 
        and \'Security\' properties knowing the Alternative Passphrase only. 
        ';
  echo end_info_table ();
  echo '      </td>
</tr>
<tr>
 <td>&nbsp;</td>
</tr>
';
  if ($settings['use_alternative_passphrase'])
  {
    echo '<tr>
 <td>Alternative Passphrase: </td>
 <td><input type=password name="alternative_passphrase" value="" class=inpts size=30></td>
</tr>
';
  }

  echo '<tr>
 <td>&nbsp;</td>
 <td><input type=submit value="Change settings" class=sbmt ';
  if ($settings['demomode'] == 1)
  {
    echo 'disabled';
  }

  echo '></td>
</tr>
</table>
</form>';
?>