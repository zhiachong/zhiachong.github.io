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


  echo '<form method=post name=nform>
<input type=hidden name=a value=pending_deposits>
<table cellspacing=0 cellpadding=1 border=0 width=100%>
<tr>
<td><b>Pending Deposits:</b></td>
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
<input type=submit value=\'GO\' class=sbmt>
</td>
</tr>
</table>
</form>
<br>
<table cellspacing=1 cellpadding=2 border=0 width=100%>
<tr>
 <th bgcolor=FFEA00>UserName</th>
 <th bgcolor=FFEA00>Date</th>
 <th bgcolor=FFEA00>Amount</th>
 <th bgcolor=FFEA00>Fields</th>
 <th bgcolor=FFEA00>P.S.</th>
 <th bgcolor=FFEA00>-</th>
</tr>
';
  $processings = array ();
  $q = 'select * from hm2_processings';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $processings[$row['id']] = unserialize ($row['infofields']);
  }

  $status = ($frm['type'] == 'problem' ? 'problem' : ($frm['type'] == 'processed' ? 'processed' : 'new'));
  $q = 'select
          hm2_pending_deposits.*,
          date_format(hm2_pending_deposits.date + interval ' . $settings['time_dif'] . (' hour, \'%b-%e-%Y %r\') as d,
          hm2_users.username
        from
          hm2_pending_deposits,
          hm2_users
        where
          hm2_pending_deposits.status = \'' . $status . '\' and
          hm2_users.id = hm2_pending_deposits.user_id
        order by date desc
       ');
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $col = 0;
  while ($row = mysql_fetch_array ($sth))
  {
    $infofields = unserialize ($row['fields']);
    $fields = '';
    if (!($exchange_systems[$row['ec']]))
    {
      $row['ec'] = 'deleted';
      foreach ($infofields as $id => $name)
      {
        $fields .= '' . $name . '<br>';
      }
    }
    else
    {
      foreach ($processings[$row['ec']] as $id => $name)
      {
        $fields .= '' . $name . ': ' . stripslashes ($infofields[$id]) . '<br>';
      }
    }

    ++$col;
    echo '     <tr onMouseOver="bgColor=\'#FFECB0\';" onMouseOut="bgColor=\'\';">
	<td><b>';
    echo $row['username'];
    echo '</b></td>
	<td align=center>';
    echo $row['d'];
    echo '</td>
	<td align=center>$';
    echo number_format ($row['amount'], 2);
    echo '</td>
	<td>';
    echo $fields;
    echo '</td>
	<td align=center><img src="images/';
    echo $row['ec'];
    echo '.gif" height=17 hspace=1 vspace=1></td>
	<td align=center><a href=?a=pending_deposit_details&id=';
    echo $row['id'];
    echo '>[details]</a></td>
     </tr>
    ';
  }

  if ($col == 0)
  {
    echo '       <tr><td colspan=6 align=center>No records found</td></tr>
    ';
  }

  echo '

</table>
';
?>