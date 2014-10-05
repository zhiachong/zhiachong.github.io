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

  $q = 'select * from hm2_types where status = \'on\'';
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $plans = array ();
  $total = 0;
  while ($row = mysql_fetch_array ($sth))
  {
    $row['deposits'] = array ();
    $q = 'select * from hm2_plans where parent = ' . $row['id'] . ' order by id';
    if (!($sth1 = mysql_query ($q)))
    {
      exit (mysql_error ());
    }

    $row['plans'] = array ();
    while ($row1 = mysql_fetch_array ($sth1))
    {
      $row1['deposit'] = '';
      if ($row1['max_deposit'] == 0)
      {
        $row1['deposit'] = '$' . number_format ($row1['min_deposit']) . ' and more';
      }
      else
      {
        $row1['deposit'] = '$' . number_format ($row1['min_deposit']) . ' - $' . number_format ($row1['max_deposit']);
      }

      array_push ($row['plans'], $row1);
    }

    $periods = array ('d' => 'Daily', 'w' => 'Weekly', 'b-w' => 'Bi Weekly', 'm' => 'Monthly', 'y' => 'Yearly');
    $row['period'] = $periods[$row['period']];
    $q = 'SELECT *, date_format(deposit_date + interval ' . $settings['time_dif'] . ' hour, \'%b-%e-%Y %r\') as date, (to_days(now()) - to_days(deposit_date)) as duration, (to_days(now()) - to_days(deposit_date) - ' . $row['withdraw_principal_duration'] . ') as pending_duration FROM hm2_deposits WHERE user_id = ' . $userinfo['id'] . '  AND status=\'on\' AND type_id = ' . $row['id'] . ' ORDER BY deposit_date ';
    $sth1 = mysql_query ($q);
    $d = array ();
    while ($row1 = mysql_fetch_array ($sth1))
    {
      array_push ($d, $row1[id]);
      $row1['can_withdraw'] = 1;
      if ($row['withdraw_principal'] == 0)
      {
        $row1['can_withdraw'] = 0;
      }
      else
      {
        if ($row1['duration'] < $row['withdraw_principal_duration'])
        {
          $row1['can_withdraw'] = 0;
        }

        if ($row['withdraw_principal_duration_max'] != 0)
        {
          if ($row['withdraw_principal_duration_max'] <= $row1['duration'])
          {
            $row1['can_withdraw'] = 0;
          }
        }
      }

      $row1['deposit'] = number_format (floor ($row1['actual_amount'] * 100) / 100, 2);
      $row1['compound'] = sprintf ('%.02f', $row1['compound']);
      $row1['pending_duration'] = 0 - $row1['pending_duration'];
      array_push ($row['deposits'], $row1);
      $total += $row1['actual_amount'];
    }

    $q = 'SELECT SUM(hm2_history.actual_amount) as sm FROM hm2_history, hm2_deposits WHERE hm2_history.deposit_id = hm2_deposits.id AND hm2_history.user_id = ' . $userinfo['id'] . ' AND hm2_deposits.user_id = ' . $userinfo['id'] . ' AND hm2_history.type=\'deposit\' AND hm2_deposits.type_id = ' . $row['id'];
    $sth1 = mysql_query ($q);
    $row1 = mysql_fetch_array ($sth1);
    $row['total_deposit'] = number_format (abs ($row1['sm']), 2);
    $q = 'SELECT SUM(hm2_history.actual_amount) as sm FROM hm2_history, hm2_deposits WHERE hm2_history.deposit_id = hm2_deposits.id AND hm2_history.user_id = ' . $userinfo['id'] . ' AND hm2_deposits.user_id = ' . $userinfo['id'] . ' AND hm2_history.type=\'earning\' AND to_days(hm2_history.date + interval ' . $settings['time_dif'] . ' hour) = to_days(now()) AND hm2_deposits.type_id = ' . $row['id'];
    $sth1 = mysql_query ($q);
    $row1 = mysql_fetch_array ($sth1);
    $row['today_profit'] = number_format (abs ($row1['sm']), 2);
    $q = 'SELECT SUM(hm2_history.actual_amount) as sm FROM hm2_history, hm2_deposits WHERE hm2_history.deposit_id = hm2_deposits.id AND hm2_history.user_id = ' . $userinfo['id'] . ' AND hm2_deposits.user_id = ' . $userinfo['id'] . '  AND hm2_history.type=\'earning\' AND hm2_deposits.type_id = ' . $row['id'];
    $sth1 = mysql_query ($q);
    $row1 = mysql_fetch_array ($sth1);
    $row['total_profit'] = number_format (abs ($row1['sm']), 2);
    if (!((!$row['deposits'] AND $row['closed'] != 0)))
    {
      array_push ($plans, $row);
      continue;
    }
  }

  $smarty->assign ('plans', $plans);
  $smarty->assign ('total', number_format ($total, 2));
  $smarty->display ('account_deposit_list.tpl');
?>