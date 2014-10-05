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


  $ab = get_user_balance ($userinfo['id']);
  $ab_formated = array ();
  while (list ($kk, $vv) = each ($ab))
  {
    $ab_formated[$kk] = number_format ($vv, 2);
  }

  $smarty->assign ('ab_formated', $ab_formated);
  $smarty->assign ('frm', $frm);
  $q = 'SELECT type_id FROM hm2_deposits WHERE user_id = ' . $userinfo['id'];
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $already_deposits = array ();
  while ($row = mysql_fetch_array ($sth))
  {
    array_push ($already_deposits, $row['type_id']);
  }

  $q = 'SELECT * FROM hm2_types WHERE status = \'on\' and closed = 0 ORDER BY id';
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $plans = array ();
  $i = 0;
  $min_deposit = 1000000000;
  while ($row = mysql_fetch_array ($sth))
  {
    if (!((0 < $row['parent'] AND !in_array ($row['parent'], $already_deposits))))
    {
      ++$i;
      if ($row['use_compound'] == 1)
      {
        if (!(($i == 1 AND $frm['h_id'] == '')))
        {
          if ($frm['h_id'] == $row['id'])
          {
          }
        }

        $smarty->assign ('default_check_compound', 1);
      }

      $compounding_available += $row['use_compound'];
      $q = 'select * from hm2_plans where parent = ' . $row['id'] . ' ORDER BY id';
      if (!($sth1 = mysql_query ($q)))
      {
        exit (mysql_error ());
      }

      $row['plans'] = array ();
      while ($row1 = mysql_fetch_array ($sth1))
      {
        $row1['deposit'] = '';
        $min_deposit = ($row1['min_deposit'] < $min_deposit ? $row1['min_deposit'] : $min_deposit);
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
      array_push ($plans, $row);
      continue;
    }
  }

  $q = 'SELECT SUM(actual_amount) AS sm, ec from hm2_history WHERE user_id = ' . $userinfo['id'] . ' GROUP BY ec';
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
  $hold = array ();
  if ($settings['allow_withdraw_when_deposit_ends'] == 1)
  {
    $q = 'SELECT id FROM hm2_deposits WHERE user_id = ' . $userinfo['id'];
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $deps = array ();
    $deps[0] = 0;
    while ($row = mysql_fetch_array ($sth))
    {
      array_push ($deps, $row[id]);
    }

    $q = 'SELECT SUM(actual_amount) AS amount, ec from hm2_history WHERE user_id = ' . $userinfo['id'] . ' and 
	deposit_id in (' . join (',', $deps) . ') AND (type=\'earning\' OR (type=\'deposit\' AND (description like \'Compou%\' or description like \'<b>Archived transactions</b>:<br>Compound%\'))) GROUP BY ec';
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    while ($row = mysql_fetch_array ($sth))
    {
      array_push ($hold, array ('ec' => $row[ec], 'amount' => number_format ($row[amount], 2)));
    }
  }

  if ($settings['hold_only_first_days'] == 1)
  {
    $q = 'SELECT SUM(hm2_history.actual_amount) as am,  hm2_history.ec FROM hm2_history, hm2_deposits, hm2_types WHERE hm2_history.user_id = ' . $userinfo[id] . ' AND hm2_history.deposit_id = hm2_deposits.id AND hm2_types.id = hm2_deposits.type_id AND now() - interval hm2_types.hold day < hm2_history.date AND hm2_deposits.deposit_date + interval hm2_types.hold day > now() AND (hm2_history.type=\'earning\' OR (hm2_history.type=\'deposit\' and (hm2_history.description like \'Compou%\' OR hm2_history.description like \'<b>Archived transactions</b>:<br>Compound%\'))) GROUP BY hm2_history.ec';
  }
  else
  {
    $q = 'SELECT SUM(hm2_history.actual_amount) as am, hm2_history.ec FROM hm2_history, hm2_deposits, hm2_types WHERE hm2_history.user_id = ' . $userinfo[id] . ' AND hm2_history.deposit_id = hm2_deposits.id AND hm2_types.id = hm2_deposits.type_id AND now() - interval hm2_types.hold day < hm2_history.date AND (hm2_history.type=\'earning\'  OR (hm2_history.type=\'deposit\' and (hm2_history.description like \'Compou%\' or hm2_history.description like \'<b>Archived transactions</b>:<br>Compound%\'))) GROUP BY hm2_history.ec ';
  }

  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $deps = array ();
  $deps[0] = 0;
  while ($row = mysql_fetch_array ($sth))
  {
    array_push ($hold, array ('ec' => $row[ec], 'amount' => number_format ($row[am], 2)));
  }

  $smarty->assign ('hold', $hold);
  $smarty->assign ('plans', $plans);
  $smarty->assign ('qplans', sizeof ($plans));
  $smarty->assign ('min_deposit', sprintf ('%0.2f', $min_deposit));
  $smarty->assign ('compounding_available', $compounding_available);
  $smarty->display ('account_deposit.tpl');
?>