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
  $q = 'SELECT * FROM hm2_users WHERE id = ' . $id;
  $sth = mysql_query ($q);
  $userinfo = mysql_fetch_array ($sth);
  $ab = get_user_balance ($id);
  $q = 'select count(*) as col from hm2_users where ref=' . $userinfo[id];
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $q_affilates = 0;
  while ($row = mysql_fetch_array ($sth))
  {
    $q_affilates = $row['col'];
  }

  $q = 'select ec, sum(actual_amount) as sum from hm2_history where user_id = ' . $id . ' group by ec';
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  while ($row = mysql_fetch_array ($sth))
  {
    $balance[$row['ec']] = $row['sum'];
  }

  echo '
<b>Manage user funds:</b><br><br>


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
 <td>E-mail:</td>
 <td><a href=\'mailto:' . $userinfo['email'] . '\'>' . $userinfo['email'] . '</td>
</tr>
<tr>';
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

  echo '</td>
</tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr>
 <td>Account balance:</td>
 <td align=right>$';
  echo number_format ($ab['total'], 2);
  echo '</td>
</tr>
';
  foreach ($exchange_systems as $id => $data)
  {
    if (!($data['status'] != 1))
    {
      echo '
<tr>
 <td>';
      echo $data['name'];
      echo ' balance:</td>
 <td align=right>$';
      echo number_format ($balance[$id], 2);
      echo '</td>
</tr>
';
      continue;
    }
  }

  echo '<tr>
          <td colspan=2> <a href=?a=thistory&u_id=';
  echo $userinfo['id'];
  echo '><small>[transactions 
            history]</small></a><br>
            <br>
 </td>
</tr>

<tr>
 <td>Total deposit: </td>
 <td align=right>$';
  echo number_format (0 - $ab['deposit'], 2);
  echo '</td>
</tr><tr>
 <td>Total active deposit:</td>
 <td align=right>$';
  echo number_format ($ab['active_deposit'], 2);
  echo '</td>
</tr><tr>
          <td colspan=2> <small><a href=?a=thistory&u_id=';
  echo $userinfo['id'];
  echo '&ttype=deposit>[transactions 
            history]</a> &nbsp; <a href=?a=releasedeposits&u_id=';
  echo $userinfo['id'];
  echo '>[release 
            a deposit]</a></small><br>
            <br>
 </td>
</tr>

<tr>
 <td>Total earning:</td>
 <td align=right>$';
  echo number_format ($ab['earning'], 2);
  echo '</td>
</tr><tr>
          <td colspan=2> <small><a href=?a=thistory&u_id=';
  echo $userinfo['id'];
  echo '&ttype=earning>[earnings 
            history]</a></small><br>
            <br>
 </td>
</tr>
<tr>
 <td>Total withdrawal:</td>
 <td align=right>$';
  echo number_format (abs ($ab['withdrawal']), 2);
  echo '</td>
</tr><tr>
 <td>Requested withdrawals:</td>
 <td align=right>$';
  echo number_format (abs ($ab['withdraw_pending']), 2);
  echo '</td>
</tr><tr>
 <td colspan=2>
	<small><a href=?a=thistory&u_id=';
  echo $userinfo['id'];
  echo '&ttype=withdrawal>[withdrawals history]</a> &nbsp; <a href=?a=thistory&u_id=';
  echo $userinfo['id'];
  echo '&ttype=withdraw_pending>[process withdrawals]</a></small><br><br>
 </td>
</tr>

<!--<tr>
 <td>Referral commissions:</td>
 <td align=right>$23.33!!!</td>
</tr><tr>
 <td colspan=2>
	<small><a href=?a=thistory&u_id=';
  echo $userinfo['id'];
  echo '&ttype=commissions>[affilate history]</a></small><br><br>
 </td>	
</tr>-->

<tr>
          <td>Total bonus:</td>
 <td align=right>$';
  echo number_format ($ab['bonus'], 2);
  echo '</td>
</tr><tr>
          <td colspan=2> <small><a href=?a=thistory&u_id=';
  echo $userinfo['id'];
  echo '&ttype=bonus>[bonuses 
            history]</a> &nbsp; <a href="?a=addbonuse&id=';
  echo $userinfo['id'];
  echo '">[add 
            a bonus]</a></small><br>
            <br>
 </td>
</tr>

<tr>
          <td>Total penalty:</td>
 <td align=right>$';
  echo number_format (0 - $ab['penality'], 2);
  echo '</td>
</tr><tr>
          <td colspan=2> <small><a href=?a=thistory&u_id=';
  echo $userinfo['id'];
  echo '&ttype=penality>[penalties 
            history]</a> &nbsp; <a href=?a=addpenality&id=';
  echo $userinfo['id'];
  echo '>[add 
            a penalty]</a></small><br>
            <br>
 </td>
</tr>
<tr>
          <td>Referrals quantity:</td>
 <td align=right>';
  echo $q_affilates;
  echo '</td>
</tr><tr>
 <td colspan=2>
	<small><a href=?a=affilates&u_id=';
  echo $userinfo['id'];
  echo '>[manage referrals]</small><br><br>
 </td>
</tr>
<tr>
 <td colspan=2>User IP\'s:</td>
</tr>
<tr>
 <td colspan=2>
  <table cellspacing=0 cellpadding=1 border=0 width=100%>
  <tr><th>IP</th><th>Last Access</th></tr>
';
  $q = 'select date_format(max(date), \'%b-%e-%Y %r\') as fdate, max(date) + interval 0 hour as mdate, ip from hm2_user_access_log where user_id = ' . $userinfo['id'] . ' group by ip order by mdate desc';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    echo '   <tr><td>';
    echo $row['ip'];
    echo ' &nbsp;</td><td>';
    echo $row['fdate'];
    echo '</td></tr>
';
  }

  echo '  </table>
 </td>
</tr>
</table>

</td><td valign=top align=center>
';
  echo start_info_table ('230');
  echo 'Manage user funds:<br>
Account balance: how many funds can the user deposit to any investment package or withdraw from the system.<br>
Total deposit: how many funds has the user ever deposited to your system.<br>
Total active deposit: the whole current deposit of this user.<br>
Total earnings: how many funds has the user ever earned with your system.<br>
Total withdrawals: how many funds has the user ever withdrawn from system.<br>
Total bonus: how many funds has the administrator ever added to the user account as a bonus.<br>
Total penalty: how many funds has the administrator ever deleted from the user account as a penalty.<br>

Actions:<br>
Transactions history - you can check the transactions history for this user.<br>
Active deposits/Transactions history - you can check the deposits history for this user.<br>
Earnings history - you can check the earnings history for this user.<br>
Withdrawals history - you can check the withdrawals history for this user.<br>
Process withdrawals - you can withdraw funds by clicking this link if a user asked you for a withdrawal.<br>
Bonuses history - you can check the bonuses history for this user.<br>
Penalties history - you can check the penalties history for this user.<br>
Add a bonus and add a penalty - add a bonus or a penalty to this user.<br>
';
  echo end_info_table ();
  echo '</td></tr></table>';
?>