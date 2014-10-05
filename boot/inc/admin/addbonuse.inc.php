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


  $id = sprintf ('%d', $frm['id']);
  $q = 'select * from hm2_users where id = ' . $id;
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $userinfo = mysql_fetch_array ($sth);
  $frm_env['HTTP_HOST'] = preg_replace ('/www\\./', '', $frm_env['HTTP_HOST']);
  $types = array ();
  $q = 'select * from hm2_types where status = \'on\'';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $types[$row['id']] = $row['name'];
  }

  echo '<b>Add a bonus:</b><br><br>';
  if ($frm['say'] == 'done')
  {
    echo 'The bonus has been sent to the user.<br><br>';
  }

  if ($frm['say'] == 'invalid_code')
  {
    echo 'The bonus has been not sent to the user. Invalid confirmation code.<br><br>';
  }

  if ($frm['say'] == 'wrongplan')
  {
    echo 'Bonus has not been sent. Invalid Investment Plan selected.<br><br>';
  }

  echo '

';
  if ($frm['action'] == 'confirm')
  {
    echo '<form method=post name=formb>
<input type=hidden name=a value=addbonuse>
<input type=hidden name=action value=addbonuse>
<input type=hidden name=id value="' . $id . '">
<input type=hidden name=amount value="' . $frm['amount'] . '">
<input type=hidden name=ec value="' . $frm['ec'] . '">
<input type=hidden name=desc value="' . $frm['desc'] . '">
<input type=hidden name=inform value="' . $frm['inform'] . '">
<input type=hidden name=deposit value="' . $frm['deposit'] . '">
<input type=hidden name=hyip_id value="' . $frm['hyip_id'] . '">
<table cellspacing=0 cellpadding=2 border=0 width=100%><tr><td valign=top>
<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td>Confirmation Code:</td>
 <td><input type=text name=code value="" class=inpts size=30></td>
</tr>
<tr>
 <td>&nbsp;</td>
 <td><input type=submit value="Confirm" class=sbmt></td>
</tr>
</table>
';
    return 1;
  }

  echo '
<form method=post name=formb>
<input type=hidden name=a value=addbonuse>
<input type=hidden name=action value=confirm>
<input type=hidden name=id value=\'' . $userinfo['id'] . '\'>
<table cellspacing=0 cellpadding=2 border=0 width=100%><tr><td valign=top>
<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td>Account name:</td>
 <td>' . $userinfo['username'] . '</td>
</tr>
<tr>
 <td>User name:</td>
 <td>' . $userinfo['name'] . '</td>
</tr>
<tr>
 <td>User e-mail:</td>
 <td><a href=\'mailto:' . $userinfo['email'] . '\'>' . $userinfo['email'] . '</td>
</tr>';
  foreach ($exchange_systems as $id => $data)
  {
    if (!($data['status'] != 1))
    {
      echo '<tr>
          <td>' . $data['name'] . ' account:</td>
          <td align=right>' . $userinfo[$data['sfx'] . '_account'] . '</td>
         </tr>';
      continue;
    }
  }

  echo '<tr>
 <td colspan=2>&nbsp;</td>
</tr><tr>
 <td>Select e-currency:</td>
 <td>
	<select name=ec class=inpts>
';
  foreach ($exchange_systems as $id => $data)
  {
    if (!($data['status'] != 1))
    {
      echo '	<option value="' . $id . '">' . $data['name'];
      continue;
    }
  }

  echo '	</select>
 </td>
</tr><tr>
 <td>Amount (US$):</td>
 <td><input type=text name=amount value="0.00" class=inpts size=10 style="text-align: right;"></td>
</tr><tr>
 <td>Description:</td>
 <td><input type=text name=desc value="Bonus note" class=inpts size=30></td>
</tr><tr>
 <td colspan=2><input type=checkbox name=inform value=1 checked> Send the e-mail notification</td>
</tr><tr>
 <td colspan=2><input type=checkbox name=deposit value=1 onclick="document.formb.hyip_id.disabled = !this.checked"> Invest this Bonuse to plan:</td>
</tr><tr>
 <td>&nbsp;</td>
 <td>
  <select name=hyip_id class=inpts disabled>';
  foreach ($types as $id => $name)
  {
    echo '   <option value=';
    echo $id;
    echo '>';
    echo htmlspecialchars ($name);
    echo '</option>
';
  }

  echo '  </select>
 </td>
</tr><tr>
 <td colspan=2>
';
  echo start_info_table ();
  echo 'For security reason you will be asked confirmation code on next page. E-mail with confirmation code will be sent to account you enter bellow. E-mail account should be on \'';
  echo $frm_env['HTTP_HOST'];
  echo '\' domain.<br><br>
E-mail: <input type=text name=conf_email value="admin" class=inpts size=10>@';
  echo $frm_env['HTTP_HOST'];
  echo end_info_table ();
  echo '</tr><tr>
</td>
 <td>&nbsp;</td>
 <td><input type=submit value="Send bonus" class=sbmt></td>
</tr></table>
</form>

</td>
<td valign=top align=center> 
  ';
  echo start_info_table ('200');
  echo '  Add a bonus:<br>
  To send a bonus to any user you should enter a bonus amount and description. 
  The user can read the description in the transactions history.<br>
  Check `send e-mail notification` to report the user about this bonus. 
  ';
  echo end_info_table ();
?>