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


  echo '<b>Add Processing:</b><br><br>
  <script>
function c1()
{
  var d = document.processing;
  for (i = 1; i <= 5; i++)
  {
    d.elements[\'field[\'+i+\']\'].disabled = (d.elements[\'use[\'+i+\']\'].checked) ? 0 : 1;
  }
}
</script>
<form method=post name="processing">
<input type="hidden" name=a value=add_processing>
<input type="hidden" name=action value=add_processing>
<table cellspacing=0 cellpadding=1 border=0>
<tr>
 <td>Status</td>
 <td><input type="checkbox" name="status" value=1 checked></td>
</tr>
<tr>
 <td>Name:</td>
 <td><input type="text" name="name" value="" class=inpts size=40></td>
</tr>
<tr>
 <td width=117>Payment notes:</td>
 <td><textarea name="description" rows=8 cols=40 class=inpts></textarea></td>
</tr>
</table>
<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td colspan=2><br>Information Fields:</td>
</tr>
<tr>
 <td><input type=checkbox name="use[1]" value=1 checked onclick="c1()"></td>
 <td>Field 1:</td>
 <td><input type="text" name="field[1]" value="Payer Account" class=inpts size=40></td>
</tr>
<tr>
 <td><input type=checkbox name="use[2]" value=1 checked onclick="c1()"></td>
 <td>Field 2:</td>
 <td><input type="text" name="field[2]" value="Transaction ID" class=inpts size=40></td>
</tr>
<tr>
 <td><input type=checkbox name="use[3]" value=1 onclick="c1()"></td>
 <td>Field 3:</td>
 <td><input type="text" name="field[3]" value="" class=inpts size=40></td>
</tr>
<tr>
 <td><input type=checkbox name="use[4]" value=1 onclick="c1()"></td>
 <td>Field 4:</td>
 <td><input type="text" name="field[4]" value="" class=inpts size=40></td>
</tr>
<tr>
 <td><input type=checkbox name="use[5]" value=1 onclick="c1()"></td>
 <td>Field 5:</td>
 <td><input type="text" name="field[5]" value="" class=inpts size=40></td>
</tr>
</table>
<input type="submit" value="Add Processing" class=sbmt>
</form>
<script>
c1();
</script>
<br>
';
  echo start_info_table ('100%');
  echo 'Enter all the user instructions, your account number in this payment
system and all the needed information here. You\'ll see all new user
transactions in the "Pending deposits" section.<br>
You can also choose the fields a user has to fill after he has
transferred the funds to your account. You can ask the user to give
you the batch ID or his account number in the corresponding payment
system. This information will help you to easily find the transfer
or define whether it was really sent.
';
  echo end_info_table ();
?>