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


  echo '<b>Wire Transfer Settings.</b><br><br>';
  $q = 'select count(*) as col from hm2_settings where name=\'wire_text\'';
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  while ($row = mysql_fetch_array ($sth))
  {
    if ($row['col'] == 0)
    {
      $q = 'insert into hm2_settings set name=\'wire_text\', value=\'Enter your bank account number information.\'';
      mysql_query ($q);
      continue;
    }
  }

  $q = 'select `value` from hm2_settings where name=\'wire_text\'';
  $sth = mysql_query ($q);
  $row = mysql_fetch_array ($sth);
  $wire_txt = $row['value'];
  echo '
';
  if ($settings['demomode'] == 1)
  {
    echo start_info_table ('100%');
    echo '<b>Demo version restriction!</b><br>You cannot edit settings!';
    echo end_info_table ();
  }

  echo '


<form method=post>
<input type=hidden name=a value=wire_settings>
<input type=hidden name=action value=wire_settings>
<input type=checkbox name=enable_wire ';
  echo ($settings['enable_wire'] == 1 ? 'checked' : '');
  echo ' value=1> Use Wire Transfers for incoming deposits<br><br>

Wire details:<br>
<textarea name=details class=inpts cols=80 rows=10>';
  echo $wire_txt;
  echo '</textarea>
<br><br>

<input type=submit value="Save" class=sbmt>
</form>
<br><br>
';
  echo start_info_table ('100%');
  echo 'This screen helps you to accept Wire Transfers.<br>
Enter your bank account information in the text area. This text will be shown to 
users when they are trying to send Wire Transfers.<br>
A user should fill a form with the transfer details after sending this form. Deposit 
will be active when the administrator accepts the Wire Transfer. 
';
  echo end_info_table ();
?>