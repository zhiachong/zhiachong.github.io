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


  echo '<html>
<head>
<link href="images/adminstyle.css" rel="stylesheet" type="text/css">
</head>
<body>
';
  $qonpage = 50;
  $qstatus = quote ($frm['status']);
  if ($qstatus == '')
  {
    $qstatus = 'on';
  }

  if ($frm['q'] != '')
  {
    $qsearch = quote ($frm['q']);
    $searchpart = ' and (username like \'%' . $qsearch . '%\' or email like \'%' . $qsearch . '%\' or name like \'%' . $qsearch . '%\') ';
  }

  $q = 'select count(*) from hm2_users where status = \'' . $qstatus . '\' and id <> 1 ' . $searchpart . ' order by id desc';
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $row = mysql_fetch_array ($sth);
  $total = $row[0];
  $page = sprintf ('%d', $frm['p']);
  if ($page == 0)
  {
    $page = 1;
  }

  $qpages = ceil ($total / $qonpage);
  if ($qpages < $page)
  {
    $page = $qpages;
  }

  $start = ($page - 1) * $qonpage;
  if ($start < -1)
  {
    $start = -1;
  }

  $end = $page * $qonpage;
  $end = ($total < $end ? $total : $end);
  $q = 'select *, date_format(date_register, \'%b-%e-%Y\') as dr from hm2_users where status = \'' . $qstatus . '\' and id <> 1 ' . $searchpart . ' order by id desc limit ' . $start . ', ' . $qonpage;
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $members = array ();
  while ($row = mysql_fetch_array ($sth))
  {
    $ar = get_user_balance ($row['id']);
    $row = array_merge ($row, $ar);
    array_push ($members, $row);
  }

  echo '<b>Members:</b><br><br>


<b>Results ';
  echo $start + 1;
  echo ' - ';
  echo $end;
  echo ' of ';
  echo $total;
  echo '</b><br>

<table cellspacing=1 cellpadding=2 border=0 width=100%>
<tr>
 <th bgcolor=FFEA00 align=center>NickName</th>
 <th bgcolor=FFEA00 align=center width=100>Reg.Date</th>
 <th bgcolor=FFEA00 align=center>Account</th>
 <th bgcolor=FFEA00 align=center>Deposit</th>
 <th bgcolor=FFEA00 align=center>Earned</th>
 <th bgcolor=FFEA00 align=center>Withdraw</th>
</tr>
';
  if (0 < sizeof ($members))
  {
    for ($i = 0; $i < sizeof ($members); ++$i)
    {
      echo '<tr onMouseOver="bgColor=\'#FFECB0\';" onMouseOut="bgColor=\'\';">
 <td><small>';
      echo $members[$i]['username'];
      echo '</small></td>
 <td align=center width=100><small>';
      echo $members[$i]['dr'];
      echo ' ';
      echo ($members[$i]['confirm_string'] != '' ? '<br>not confirmed!' : '');
      echo '</small></td>
 <td align=right><small>$';
      echo number_format ($members[$i]['total'], 2);
      echo '</small></td>
 <td align=right><small>$';
      echo number_format (abs ($members[$i]['deposit']), 2);
      echo '</small></td>
 <td align=right><small>$';
      echo number_format ($members[$i]['earning'], 2);
      echo '</small></td>
 <td align=right><small>$';
      echo number_format (abs ($members[$i]['withdrawal']), 2);
      echo '</small></td>
</tr>

';
    }
  }
  else
  {
    echo '<tr>
 <td colspan=7 align=center>No accounts found</td>
</tr>
';
  }

  echo '</table><br>
';
  if (1 < $qpages)
  {
    echo '<center><small>';
    for ($i = 1; $i <= $qpages; ++$i)
    {
      if ($page == $i)
      {
        echo ' [' . $i . '] ';
        continue;
      }
      else
      {
        echo ' <a href="?a=members&status=';
        echo $qstatus;
        echo '&q=';
        echo $frm['q'];
        echo '&p=';
        echo $i;
        echo '">';
        echo $i;
        echo '</a> ';
        continue;
      }
    }

    echo '</small></center>';
  }

  echo '


</body>';
?>