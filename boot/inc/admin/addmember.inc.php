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


  echo '<b>Add A New Member Account:</b><br>
<br>

<table cellspacing=0 cellpadding=2 border=0 width=100%><tr><td valign=top>
<form method=post name="regform">
<input type=hidden name=a value="editaccount">
<input type=hidden name=action value="editaccount">
<input type=hidden name=id value="0">
<table cellspacing=0 cellpadding=2 border=0>
 <td>Full name:</td>
 <td><input type=text name=fullname value=\'\' class=inpts size=30></td>
</tr><tr>
 <td>Username:</td>
 <td><input type=text name=username value=\'\' class=inpts size=30></td>
</tr><tr>
 <td>Password:</td>
 <td><input type=password name=password value="" class=inpts size=30></td>
</tr><tr>
 <td>Retype password:</td>
 <td><input type=password name=password2 value="" class=inpts size=30></td>
</tr><tr>
 <td>E-Gold Account No:</td>
 <td><input type=text name=egold value=\'\' class=inpts size=30></td>
</tr><tr>
 <td>iGolds Account No:</td>
 <td><input type=text name=igolds value=\'\' class=inpts size=30></td>
</tr><tr>
 <!--td>Evocash Account No:</td>
 <td><input type=text name=evocash value=\'\' class=inpts size=30></td>
</tr><tr-->
 <td>IntGold Account No:</td>
 <td><input type=text name=intgold value=\'\' class=inpts size=30></td>
</tr><tr>
 <td>StormPay Account:</td>
 <td><input type=text name=stormpay value=\'\' class=inpts size=30></td>
</tr><tr>
 <td>e-Bullion Account:</td>
 <td><input type=text name=ebullion value=\'\' class=inpts size=30></td>
</tr><tr>
 <td>PayPal Account:</td>
 <td><input type=text name=paypal value=\'\' class=inpts size=30></td>
</tr><tr>
 <td>GoldMoney Account:</td>
 <td><input type=text name=goldmoney value=\'\' class=inpts size=30></td>
</tr><tr>
 <td>eeeCurrency Account:</td>
 <td><input type=text name=eeecurrency value=\'\' class=inpts size=30></td>
</tr><tr>
 <td>Pecunix Account:</td>
 <td><input type=text name=pecunix value=\'\' class=inpts size=30></td>
</tr><tr>
 <td>E-mail address:</td>
 <td><input type=text name=email value=\'\' class=inpts size=30></td>
</tr><tr>
 <td>Status:</td>
 <td><select name=status class=inpts>
	<option value="on" selected>Active
	<option value="off">Disabled
	<option value="suspended">Suspended</select>
 </td>
</tr><tr>
 <td colspan=2><input type=checkbox name=auto_withdraw value=1 ';
  echo ($settings['use_auto_payment'] == 1 ? 'checked' : '');
  echo '>
              Auto-withdrawal enabled 
              ';
  if ($settings['demomode'] == 1)
  {
    echo '              &nbsp; &nbsp; <span style="color: #D20202;">Checkbox available in 
              Pro version only</span> 
              ';
  }

  echo '            </td>
</tr><tr>
 <td colspan=2><input type=checkbox name=admin_auto_pay_earning value=1>
              Pay earnings directly to the user\'s e-gold account 
              ';
  if ($settings['demomode'] == 1)
  {
    echo '              &nbsp; &nbsp; <span style="color: #D20202;">Checkbox available in 
              Pro version only</span> 
              ';
  }

  echo '            </td>
</tr><tr>
 <td>&nbsp;</td>
 <td><input type=submit value="Save new Account" class=sbmt></td>
</tr></table>
</form>

</td>
    <td valign=top> 
      ';
  echo start_info_table ('200');
  echo '      Add a new member here. Do not forget to type a nick name, password, e-mail 
      and e-gold account number. 
      ';
  echo end_info_table ();
  echo '    </td>
  </tr></table>';
?>