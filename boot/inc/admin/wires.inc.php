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


  echo '<form method=post name=nform >
<input type=hidden name=a value=wires>
<table cellspacing=0 cellpadding=1 border=0 width=100%>
<tr>
<td><b> Wire Transfers:</b></td>
<td align=right>
<select name=type class=inpts onchange="document.nform.submit()">
          <option value=\'new\'>New</option>
          <option value=\'problem\' ';
  echo ($frm['type'] == 'problem' ? 'selected' : '');
  echo '>Problem</option>
          <option value=\'processed\' ';
  echo ($frm['type'] == 'processed' ? 'selected' : '');
  echo '>Processed</option>
</select>
<input type=submit value=\'GO\' class=sbmt></form>
</td>

<table cellspacing=1 cellpadding=2 border=0 width=100%>
<tr>
 <th bgcolor=FFEA00>Account</th>
 <th bgcolor=FFEA00>Amount</th>
 <th bgcolor=FFEA00>Bank Name</th>
 <th bgcolor=FFEA00>Bank Account</th>
 <th bgcolor=FFEA00>-</th>
</tr>
';
  if ($frm['type'] == 'problem')
  {
    $q = 'SELECT hm2_wires.*, hm2_users.username FROM hm2_wires, hm2_users WHERE hm2_wires.status=\'problem\' AND hm2_users.id = hm2_wires.user_id ORDER BY wire_date DESC';
  }
  else
  {
    $q = 'SELECT hm2_wires.*, hm2_users.username FROM hm2_wires, hm2_users WHERE hm2_wires.status=\'new\' AND hm2_users.id = hm2_wires.user_id ORDER BY wire_date DESC';
  }

  $sth = mysql_query ($q);
  $col = 0;
  while ($row = mysql_fetch_array ($sth))
  {
    ++$col;
    echo '     <tr onMouseOver="bgColor=\'#FFECB0\';" onMouseOut="bgColor=\'\';">
	<td><b>';
    echo $row['username'];
    echo '</b></td>
	<td align=right>';
    echo number_format ($row['amount'], 2);
    echo '</td>
	<td align=center>';
    echo $row['bname'];
    echo '</td>
	<td align=center>';
    echo $row['baccount'];
    echo '</td>
	<td align=center><a href=?a=wiredetails&id=';
    echo $row['id'];
    echo '>[details]</a></td>
     </tr>
    ';
  }

  if ($col == 0)
  {
    echo '       <tr><td colspan=5 align=center>No records found</td></tr>
    ';
  }

  echo '

</table>
';
?>