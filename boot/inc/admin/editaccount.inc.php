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
  $q = 'SELECT * FROM hm2_users WHERE id = ' . $id . ' AND id <> 1';
  if (!($sth = mysql_query ($q)))
  {
    exit (mysql_error ());
  }

  $row = mysql_fetch_array ($sth);
  if ($settings['demomode'] == 1)
  {
    if ($id <= 3)
    {
      echo start_info_table ('100%');
      echo '<b>Demo version restriction!</b><br>You cannot edit this user information! ';
      echo end_info_table ();
    }
  }

  echo '<b>Edit Member Account:</b><br><br>';
  if ($frm['say'] == 'saved')
  {
    echo 'User information saved<br><br>';
  }

  if ($frm['say'] == 'incorrect_password')
  {
    echo 'Please check your password<br><br>';
  }

  if ($frm['say'] == 'incorrect_transaction_code')
  {
    echo 'Please check your transaction code<br><br>';
  }

  echo '
<form method=post name="regform">
<input type=hidden name=a value="editaccount">
<input type=hidden name=action value="editaccount">
<input type=hidden name=id value="';
  echo $id;
  echo '">
<table cellspacing=0 cellpadding=2 border=0 width=100%><tr><td valign=top>
<table cellspacing=0 cellpadding=2 border=0>
 <td>Full name:</td>
 <td><input type=text name=fullname value=\'' . quote ($row['name']) . '\' class=inpts size=30></td>
</tr>
';
  if ($settings['use_user_location'])
  {
    include './inc/countries.php';
    echo '<tr>
           <td>Address:</td>
           <td><input type=text name=address value=\'' . quote ($row['address']) . '\' class=inpts size=30></td>
          </tr>
          <tr>
           <td>City:</td>
           <td><input type=text name=city value=\'' . quote ($row['city']) . '\' class=inpts size=30></td>
          </tr>
          <tr>
           <td>State:</td>
           <td><input type=text name=state value=\'' . quote ($row['state']) . '\' class=inpts size=30></td>
          </tr>
          <tr>
           <td>Zip:</td>
           <td><input type=text name=zip value=\'' . quote ($row['zip']) . '\' class=inpts size=30></td>
          </tr>
          <tr>
           <td>Country:</td>
           <td><select name=country class=inpts>
              <option value=\'\'>--SELECT--</option>';
    foreach ($countries as $c)
    {
      echo '   <option ';
      echo ($c['name'] == $row['country'] ? 'selected' : '');
      echo '>';
      echo quote ($c['name']);
      echo '</option>';
    }

    echo '</select>
        </td>
       </tr>';
  }

  echo '<tr>
         <td>Username:</td>
         <td><input type=text name=username value=\'' . quote ($row['username']) . '\' class=inpts size=30></td>
       </tr>
       <tr>
        <td>Password:</td>
        <td><input type=password name=password value="" class=inpts size=30></td>
       </tr>
	   <tr>
        <td>Retype password:</td>
        <td><input type=password name=password2 value="" class=inpts size=30></td>
      </tr>';
  if ($settings['use_transaction_code'])
  {
    echo '<tr>
           <td>Transaction Code:</td>
           <td><input type=password name=transaction_code value="" class=inpts size=30></td>
          </tr>
		  <tr>
           <td>Retype Transaction Code:</td>
           <td><input type=password name=transaction_code2 value="" class=inpts size=30></td>
          </tr>';
  }

  foreach ($exchange_systems as $id => $data)
  {
    echo '<tr>
          <td>' . $data['name'] . ' Account:</td>
          <td><input type=text name="' . $data['sfx'] . '" value="' . quote ($row[$data['sfx'] . '_account']) . '" class=inpts size=30></td>
         </tr>';
  }

  echo '<tr>
        <td>E-mail address:</td>
        <td><input type=text name=email value=\'' . quote ($row['email']) . '\' class=inpts size=30></td>
       </tr>
	   <tr>
        <td>Status:</td>
        <td><select name=status class=inpts>
            	<option value="on" ' . ($row['status'] == 'on' ? 'selected' : '') . '>Active
	            <option value="off" ' . ($row['status'] == 'off' ? 'selected' : '') . '>Disabled
         	    <option value="suspended" ' . ($row['status'] == 'suspended' ? 'selected' : '') . '>Suspended
			</select>
        </td>
      </tr>
	  <tr>
        <td colspan=2><input type=checkbox name=auto_withdraw value=1 ';
  echo ($row['auto_withdraw'] == 1 ? 'checked' : '');
  echo '>Auto-withdrawal enabled ';
  if ($settings['demomode'] == 1)
  {
    echo '&nbsp; &nbsp; <span style="color: #D20202;">Checkbox is NO available in DEMO version </span> ';
  }

  echo '</td>
       </tr>
	   <tr>
 <td colspan=2><input type=checkbox name=admin_auto_pay_earning value=1 ';
  echo ($row['admin_auto_pay_earning'] == 1 ? 'checked' : '');
  echo '>
            Tranfer earnings directly to the user\'s e-gold account 
            ';
  if ($settings['demomode'] == 1)
  {
    echo '            &nbsp; &nbsp; <span style="color: #D20202;">Checkbox is available 
            in Pro version only</span> 
            ';
  }

  echo '          </td>
</tr><tr>
';
  if ($row['came_from'] != '')
  {
    echo '<td>Came from:</td> ';
    echo '<td><small><a href="' . $row['came_from'] . '" target=_blank>' . $row['came_from'] . '</a></td></tr><tr>';
  }

  if ($row['activation_code'] != '')
  {
    echo ' <td colspan=2><input type=checkbox name=activate value=1> Activate acount. User account has been blocked by Brute Force Handler feature.</td></tr><tr>';
  }

  echo ' <td>&nbsp;</td>
 <td><input type=submit value="Save changes" class=sbmt></td>
</tr></table>
</form>

</td><td valign=top>
';
  echo start_info_table ('200');
  echo 'Edit member:<br>
  You can change the user information and status here. 
  ';
  echo end_info_table ();
  echo '</td>
</tr></table>';
?>