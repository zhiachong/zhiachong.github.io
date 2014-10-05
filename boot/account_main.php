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


  session_start ();
  include 'inc/config.inc.php';
  if ($userinfo['logged'] == 0)
  {
    header ('location: page_login.php');
    exit ();
  }

  $sth = mysql_query ('SELECT date_format(date + interval ' . $settings['time_dif'] . (' hour, \'%b-%e-%Y %r\') AS last_login FROM hm2_user_access_log WHERE user_id = ' . $userinfo['id'] . ' ORDER BY id DESC LIMIT 1, 1'));
  while ($row = mysql_fetch_array ($sth))
  {
    $last_access = $row['last_login'];
  }

  $smarty->assign ('last_access', $last_access);
  if ($settings[estimate_earnings_for_end_of_day] == 1)
  {
    $q = 'SELECT * FROM hm2_deposits WHERE user_id = ' . $userinfo['id'];
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $est_earn = 0;
    while ($row = mysql_fetch_array ($sth))
    {
      $q = 'SELECT SUM(actual_amount) AS sum FROM hm2_history WHERE deposit_id = ' . $row[id] . ' AND type=\'earning\'';
      if (!($sth1 = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      while ($row1 = mysql_fetch_array ($sth1))
      {
        $est_earn += $row1[sum];
      }
    }

    $q = 'SELECT hm2_deposits.*, to_days(now()) - to_days(last_pay_date) as cnt, hm2_types.period from hm2_deposits, hm2_types where hm2_types.id = hm2_deposits.type_id and user_id = ' . $userinfo['id'] . ' and hm2_deposits.status=\'on\'';
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    while ($row = mysql_fetch_array ($sth))
    {
      $q = 'SELECT * FROM hm2_plans WHERE parent=' . $row[type_id] . ' AND ' . $row[actual_amount] . ' > min_deposit order by min_deposit desc limit 1';
      if (!($sth1 = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      while ($row1 = mysql_fetch_array ($sth1))
      {
        $d = 0;
        if ($row[period] == 'd')
        {
          $d = 1;
        }

        if ($row[period] == 'w')
        {
          $d = 7;
        }

        if ($row[period] == 'b-w')
        {
          $d = 14;
        }

        if ($row[period] == 'm')
        {
          $d = 31;
        }

        if ($row[period] == 'y')
        {
          $d = 365;
        }

        if (0 < $d)
        {
          $est_earn += $row[actual_amount] * $row[cnt] * $row1[percent] / (100 * $d);
          continue;
        }
      }
    }

    $smarty->assign ('earned_est', number_format ($est_earn, 2));
  }

  $ab = get_user_balance ($userinfo['id']);
  $ab_formated = array ();
  $ab['deposit'] = 0 - $ab['deposit'];
  $ab['earning'] = $ab['earning'];
  reset ($ab);
  while (list ($kk, $vv) = each ($ab))
  {
    $ab_formated[$kk] = number_format ($vv, 2);
  }

  $smarty->assign ('ab_formated', $ab_formated);
  $q = 'select count(*) as col, sum(amount) as actual_amount, ec from hm2_pending_deposits where user_id = ' . $userinfo['id'] . ' AND status != \'processed\' group by ec';
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  while ($row = mysql_fetch_array ($sth))
  {
    $exchange_systems[$row['ec']]['pending_col'] = $row['col'];
    $exchange_systems[$row['ec']]['pending_amount'] = number_format ($row['actual_amount'], 2);
  }

  $q = 'select sum(actual_amount) as sm, ec from hm2_history where user_id = ' . $userinfo['id'] . ' GROUP BY ec';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $exchange_systems[$row['ec']]['balance'] = number_format ($row['sm'], 2);
  }

  $ps = array ();
  reset ($exchange_systems);
  foreach ($exchange_systems as $id => $data)
  {
    array_push ($ps, array_merge (array ('id' => $id), $data));
  }

  $smarty->assign ('ps', $ps);
  $q = 'SELECT *, date_format(deposit_date + interval ' . $settings['time_dif'] . (' hour, \'%b-%e-%Y %r\') AS dd FROM hm2_deposits WHERE user_id = ' . $userinfo['id'] . ' AND status = \'on\' ORDER BY deposit_date DESC LIMIT 1');
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  if ($row = mysql_fetch_array ($sth))
  {
    $smarty->assign ('last_deposit', number_format ($row['amount'], 2));
    $smarty->assign ('last_deposit_date', $row['dd']);
  }

  $q = 'SELECT *, date_format(date + interval ' . $settings['time_dif'] . (' hour, \'%b-%e-%Y %r\') AS dd FROM hm2_history where user_id = ' . $userinfo['id'] . ' AND type = \'withdrawal\' ORDER BY date DESC LIMIT 1');
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  if ($row = mysql_fetch_array ($sth))
  {
    $smarty->assign ('last_withdrawal', number_format (abs ($row['actual_amount']), 2));
    $smarty->assign ('last_withdrawal_date', $row['dd']);
  }

  $q = 'SELECT count(*) AS col FROM hm2_wires WHERE user_id = ' . $userinfo['id'] . ' and status != \'processed\'';
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  if ($row = mysql_fetch_array ($sth))
  {
    $smarty->assign ('wires', $row['col']);
  }

  $smarty->assign ('userinfo', $userinfo);
  $smarty->display ('account_main.tpl');
?>