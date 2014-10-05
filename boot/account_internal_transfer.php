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

  if ($frm['complete'])
  {
    $smarty->assign ('fatal', 'completed');
    $smarty->display ('account_internal_transfer.tpl');
    exit ();
  }

  if (!($settings['internal_transfer_enabled']))
  {
    $smarty->assign ('fatal', 'forbidden');
    $smarty->display ('account_internal_transfer.tpl');
    exit ();
  }

  if (0 < $settings['forbid_withdraw_before_deposit'])
  {
    $q = 'SELECT count(*) as cnt from hm2_deposits where user_id = ' . $userinfo['id'];
    $sth = mysql_query ($q);
    $row = mysql_fetch_array ($sth);
    if ($row['cnt'] < 1)
    {
      $smarty->assign ('say', 'no_deposits');
    }
  }

  $ab = get_user_balance ($userinfo['id']);
  $ab_formated = array ();
  $ab['withdraw_pending'] = 0 - $ab['withdraw_pending'];
  reset ($ab);
  while (list ($kk, $vv) = each ($ab))
  {
    $vv = floor ($vv * 100) / 100;
    $ab_formated[$kk] = number_format ($vv, 2);
  }

  $smarty->assign ('ab_formated', $ab_formated);
  $q = 'SELECT SUM(actual_amount) as sm, ec from hm2_history where user_id = ' . $userinfo['id'] . ' group by ec';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $sm = floor ($row['sm'] * 100) / 100;
    $exchange_systems[$row['ec']]['balance'] = number_format ($sm, 2);
    $exchange_systems[$row['ec']]['actual_balance'] = $row['sm'];
  }

  $ps = array ();
  reset ($exchange_systems);
  foreach ($exchange_systems as $id => $data)
  {
    array_push ($ps, array_merge (array ('id' => $id), $data));
  }

  $smarty->assign ('ps', $ps);
  if ($settings['hold_only_first_days'] == 1)
  {
    $q = 'SELECT SUM(hm2_history.actual_amount) as am, hm2_history.ec FROM hm2_history, hm2_deposits, hm2_types WHERE hm2_history.user_id = ' . $userinfo[id] . ' AND hm2_history.deposit_id = hm2_deposits.id AND hm2_types.id = hm2_deposits.type_id AND now() - interval hm2_types.hold day < hm2_history.date AND hm2_deposits.deposit_date + interval hm2_types.hold day > now() AND (hm2_history.type=\'earning\' OR (hm2_history.type=\'deposit\' and (hm2_history.description like \'Compou%\' or hm2_history.description like \'<b>Archived transactions</b>:<br>Compound%\'))) GROUP BY hm2_history.ec';
  }
  else
  {
    $q = 'SELECT SUM(hm2_history.actual_amount) as am, hm2_history.ec FROM hm2_history, hm2_deposits, hm2_types WHERE hm2_history.user_id = ' . $userinfo[id] . ' AND hm2_history.deposit_id = hm2_deposits.id AND hm2_types.id = hm2_deposits.type_id AND now() - interval hm2_types.hold day < hm2_history.date AND (hm2_history.type=\'earning\' OR (hm2_history.type=\'deposit\' AND (hm2_history.description like \'Compou%\' or hm2_history.description like \'<b>Archived transactions</b>:<br>Compound%\'))) GROUP BY hm2_history.ec';
  }

  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $deps = array ();
  $deps[0] = 0;
  $hold = array ();
  while ($row = mysql_fetch_array ($sth))
  {
    array_push ($hold, array ('ec' => $row[ec], 'amount' => number_format ($row[am], 2)));
  }

  $smarty->assign ('hold', $hold);
  if ($frm['action'] == 'preview_transaction')
  {
    $amount = sprintf ('%.02f', $frm['amount']);
    $ec = intval ($frm['ec']);
    if ($amount <= 0)
    {
      $smarty->assign ('say', 'too_small_amount');
      $smarty->display ('account_internal_transfer.tpl');
      exit ();
    }

    if ($settings['hold_only_first_days'] == 1)
    {
      $q = 'select hm2_deposits.id, hm2_types.hold from hm2_deposits, hm2_types where user_id = ' . $userinfo[id] . ' and hm2_types.id = hm2_deposits.type_id and ec=' . $ec . ' and hm2_deposits.deposit_date + interval hm2_types.hold day > now()';
    }
    else
    {
      $q = 'select hm2_deposits.id, hm2_types.hold from hm2_deposits, hm2_types where user_id = ' . $userinfo[id] . ' and hm2_types.id = hm2_deposits.type_id and ec=' . $ec;
    }

    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $deps = array ();
    $deps[0] = 0;
    $on_hold = 0;
    while ($row = mysql_fetch_array ($sth))
    {
      $q = 'SELECT SUM(actual_amount) AS amount from hm2_history where user_id = ' . $userinfo['id'] . (' and ec = ' . $ec . ' AND deposit_id = ' . $row[id] . ' and date > now() - interval ' . $row[hold] . ' day AND (type=\'earning\' OR (type=\'deposit\' and (description like \'Compou%\' or description like \'<b>Archived transactions</b>:<br>Compound%\')));');
      if (!($sth1 = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      while ($row1 = mysql_fetch_array ($sth1))
      {
        $on_hold += $row1[amount];
      }
    }

    if ($exchange_systems[$ec]['actual_balance'] < $amount)
    {
      $smarty->assign ('say', 'too_big_amount');
      $smarty->display ('account_internal_transfer.tpl');
      exit ();
    }

    if ($exchange_systems[$ec]['actual_balance'] - $on_hold < $amount)
    {
      $smarty->assign ('say', 'on_hold');
      $smarty->display ('account_internal_transfer.tpl');
      exit ();
    }

    $recipient = quote ($frm['account']);
    $q = 'SELECT * from hm2_users where username = \'' . $recipient . '\' and status = \'on\'';
    $sth = mysql_query ($q);
    $user = mysql_fetch_array ($sth);
    if (!($user))
    {
      $smarty->assign ('say', 'user_not_found');
      $smarty->display ('account_internal_transfer.tpl');
      exit ();
    }

    $smarty->assign ('user', $user);
    $smarty->assign ('amount', $amount);
    $smarty->assign ('ec', $ec);
    $smarty->assign ('ec_name', $exchange_systems[$ec]['name']);
    $smarty->assign ('comment', $frm['comment']);
    $smarty->assign ('preview', 1);
    $smarty->display ('account_internal_transfer.tpl');
    exit ();
  }

  if ($frm['action'] == 'make_transaction')
  {
    if ($settings['use_transaction_code'])
    {
      if ($frm['transaction_code'] != $userinfo['transaction_code'])
      {
        $smarty->assign ('fatal', 'invalid_transaction_code');
        $smarty->display ('account_internal_transfer.tpl');
        exit ();
      }
    }

    $amount = sprintf ('%.02f', $frm['amount']);
    $ec = intval ($frm['ec']);
    if ($amount <= 0)
    {
      $smarty->assign ('say', 'too_small_amount');
      $smarty->display ('account_internal_transfer.tpl');
      exit ();
    }

    if ($settings['hold_only_first_days'] == 1)
    {
      $q = 'SELECT hm2_deposits.id, hm2_types.hold from hm2_deposits, hm2_types where user_id = ' . $userinfo[id] . ' and hm2_types.id = hm2_deposits.type_id and ec=' . $ec . ' and hm2_deposits.deposit_date + interval hm2_types.hold day > now()';
    }
    else
    {
      $q = 'SELECT hm2_deposits.id, hm2_types.hold from hm2_deposits, hm2_types where user_id = ' . $userinfo[id] . ' and hm2_types.id = hm2_deposits.type_id and ec=' . $ec;
    }

    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $deps = array ();
    $deps[0] = 0;
    $on_hold = 0;
    while ($row = mysql_fetch_array ($sth))
    {
      $q = 'SELECT SUM(actual_amount) as amount from hm2_history where user_id = ' . $userinfo['id'] . (' and ec = ' . $ec . ' AND deposit_id = ' . $row[id] . ' and date > now() - interval ' . $row[hold] . ' day  AND (type=\'earning\'  OR (type=\'deposit\' AND (description like \'Compou%\' or description like \'<b>Archived transactions</b>:<br>Compound%\')));');
      if (!($sth1 = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      while ($row1 = mysql_fetch_array ($sth1))
      {
        $on_hold += $row1[amount];
      }
    }

    if ($exchange_systems[$ec]['actual_balance'] - $on_hold < $amount)
    {
      $smarty->assign ('say', 'on_hold');
      $smarty->display ('account_internal_transfer.tpl');
      exit ();
    }

    if ($exchange_systems[$ec]['actual_balance'] < $amount)
    {
      $smarty->assign ('say', 'too_big_amount');
      $smarty->display ('account_internal_transfer.tpl');
      exit ();
    }

    $recipient = quote ($frm['account']);
    $q = 'select * from hm2_users where username = \'' . $recipient . '\' and status = \'on\'';
    $sth = mysql_query ($q);
    $user = mysql_fetch_array ($sth);
    if (!($user))
    {
      $smarty->assign ('say', 'user_not_found');
      $smarty->display ('account_internal_transfer.tpl');
      exit ();
    }

    $q = 'INSERT INTO hm2_history SET user_id = ' . $userinfo['id'] . (', amount = -' . $amount . ', actual_amount = -' . $amount . ', type = \'internal_transaction_spend\', description = \'Internal transaction to `') . $user['username'] . '` account.' . ($frm['comment'] ? ' Comments: ' . $frm['comment'] : '') . ('\', date = now(), ec = ' . $ec . '');
    mysql_query ($q);
    $q = 'INSERT INTO hm2_history SET user_id = ' . $user['id'] . (', amount = ' . $amount . ',actual_amount = ' . $amount . ', type = \'internal_transaction_receive\', description = \'Internal transaction from `') . $userinfo['username'] . '` account.' . ($frm['comment'] ? ' Comments: ' . $frm['comment'] : '') . ('\', date = now(), ec = ' . $ec . '');
    mysql_query ($q);
    header ('Location: account_internal_transfer.php?complete=1');
    exit ();
  }

  $smarty->display ('account_internal_transfer.tpl');
?>