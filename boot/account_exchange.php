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

  $id = $userinfo['id'];
  if ($frm['display'] == 'ok')
  {
    $smarty->assign ('exchanged', 1);
    $smarty->display ('account_exchange_preview.tpl');
    exit ();
  }

  if ($frm['action'] == 'preview')
  {
    $from = intval ($frm['from']);
    $q = 'SELECT sum(actual_amount) AS sm FROM hm2_history where user_id = ' . $id . ' and ec = ' . $from;
    $sth = mysql_query ($q);
    $row = mysql_fetch_array ($sth);
    $row['sm'] = floor ($row['sm'] * 100) / 100;
    if (isset ($exchange_systems[$from]))
    {
      if ($exchange_systems[$from]['status'] != 1)
      {
        if ($row['sm'] <= 0)
        {
        }
      }
    }

    $smarty->assign ('error', 'no_from');
    $smarty->display ('account_exchange_preview.tpl');
    exit ();
    $to = intval ($frm['to_' . $from]);
    if (!((((!($frm['to'] === '') AND isset ($exchange_systems[$to])) AND !($exchange_systems[$to]['status'] != 1)) AND !($to == $from))))
    {
      $smarty->assign ('error', 'no_to');
      $smarty->display ('account_exchange_preview.tpl');
      exit ();
    }

    $frm['amount_' . $from] = str_replace (',', '.', $frm['amount_' . $from]);
    $amount = sprintf ('%.02f', $frm['amount_' . $from]);
    if ($settings['hold_only_first_days'] == 1)
    {
      $q = 'select hm2_deposits.id, hm2_types.hold from hm2_deposits, hm2_types where user_id = ' . $userinfo[id] . ' and hm2_types.id = hm2_deposits.type_id and hm2_deposits.deposit_date + interval hm2_types.hold day > now()';
    }
    else
    {
      $q = 'select hm2_deposits.id, hm2_types.hold from hm2_deposits, hm2_types where user_id = ' . $userinfo[id] . ' and hm2_types.id = hm2_deposits.type_id ';
    }

    if (!($sthz = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $deps = array ();
    $deps[0] = 0;
    $on_hold = 0;
    while ($rowz = mysql_fetch_array ($sthz))
    {
      $q = 'select sum(actual_amount) as amount from hm2_history where user_id = ' . $userinfo['id'] . (' and ec = ' . $from . ' AND deposit_id = ' . $rowz[id] . ' and date > now() - interval ' . $rowz[hold] . ' day and 
			(type=\'earning\' OR (type=\'deposit\' and (description like \'Compou%\' or description like \'<b>Archived transactions</b>:<br>Compound%\')));');
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

    if ($amount <= 0)
    {
      $smarty->assign ('error', 'no_amount');
      $smarty->display ('account_exchange_preview.tpl');
      exit ();
    }

    if ($row['sm'] < $amount)
    {
      $smarty->assign ('error', 'to_big_amount');
      $smarty->display ('account_exchange_preview.tpl');
      exit ();
    }

    if ($row['sm'] - $on_hold < $amount)
    {
      $smarty->assign ('error', 'on_hold');
      $smarty->display ('account_exchange_preview.tpl');
      exit ();
    }

    $q = 'SELECT * from hm2_exchange_rates where sfrom = ' . $from . ' and sto = ' . $to;
    $sth = mysql_query ($q);
    $row = mysql_fetch_array ($sth);
    $percent = $row['percent'];
    $percent /= 100;
    if (1 <= $percent)
    {
      $smarty->assign ('error', 'exchange_forbidden');
      $smarty->display ('account_exchange_preview.tpl');
      exit ();
    }

    $exchange_amount = sprintf ('%.02f', (1 - $percent) * $amount);
    if ($exchange_amount <= 0)
    {
      $smarty->assign ('error', 'to_small_amount');
      $smarty->display ('account_exchange_preview.tpl');
      exit ();
    }

    $smarty->assign ('from', $from);
    $smarty->assign ('from_name', $exchange_systems[$from]['name']);
    $smarty->assign ('to', $to);
    $smarty->assign ('to_name', $exchange_systems[$to]['name']);
    $smarty->assign ('amount', $amount);
    $smarty->assign ('exchange_amount', $exchange_amount);
    $smarty->display ('account_exchange_preview.tpl');
    exit ();
  }

  if ($frm['action'] == 'exchange')
  {
    $from = intval ($frm['from']);
    $q = 'select sum(actual_amount) as sm from hm2_history where user_id = ' . $id . ' and ec = ' . $from;
    $sth = mysql_query ($q);
    $row = mysql_fetch_array ($sth);
    $row['sm'] = floor ($row['sm'] * 100) / 100;
    if (isset ($exchange_systems[$from]))
    {
      if ($exchange_systems[$from]['status'] != 1)
      {
        if ($row['sm'] <= 0)
        {
        }
      }
    }

    $smarty->assign ('error', 'no_from');
    $smarty->display ('account_exchange_preview.tpl');
    exit ();
    $to = intval ($frm['to']);
    if (!(((!($frm['to'] == '') AND isset ($exchange_systems[$to])) AND !($exchange_systems[$to]['status'] != 1))))
    {
      $smarty->assign ('error', 'no_to');
      $smarty->display ('account_exchange_preview.tpl');
      exit ();
    }

    $amount = sprintf ('%.02f', $frm['amount']);
    if ($settings['hold_only_first_days'] == 1)
    {
      $q = 'SELECT hm2_deposits.id, hm2_types.hold from hm2_deposits, hm2_types where user_id = ' . $userinfo[id] . ' AND hm2_types.id = hm2_deposits.type_id and hm2_deposits.deposit_date + interval hm2_types.hold day > now()';
    }
    else
    {
      $q = 'SELECT hm2_deposits.id, hm2_types.hold from hm2_deposits, hm2_types where user_id = ' . $userinfo[id] . ' and hm2_types.id = hm2_deposits.type_id ';
    }

    if (!($sthz = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $deps = array ();
    $deps[0] = 0;
    $on_hold = 0;
    while ($rowz = mysql_fetch_array ($sthz))
    {
      $q = 'SELECT SUM(actual_amount) as amount from hm2_history where user_id = ' . $userinfo['id'] . (' and ec = ' . $from . ' AND deposit_id = ' . $rowz[id] . ' and date > now() - interval ' . $rowz[hold] . ' day AND (type=\'earning\' OR (type=\'deposit\' and (description like \'Compou%\' or description like \'<b>Archived transactions</b>:<br>Compound%\')));');
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

    if ($amount <= 0)
    {
      $smarty->assign ('error', 'no_amount');
      $smarty->display ('account_exchange_preview.tpl');
      exit ();
    }

    if ($row['sm'] < $amount)
    {
      $smarty->assign ('error', 'to_big_amount');
      $smarty->display ('account_exchange_preview.tpl');
      exit ();
    }

    if ($row['sm'] - $on_hold < $amount)
    {
      $smarty->assign ('error', 'on_hold');
      $smarty->display ('account_exchange_preview.tpl');
      exit ();
    }

    $q = 'SELECT * from hm2_exchange_rates where sfrom = ' . $from . ' and sto = ' . $to;
    $sth = mysql_query ($q);
    $row = mysql_fetch_array ($sth);
    $percent = $row['percent'];
    $percent /= 100;
    if (1 <= $percent)
    {
      $smarty->assign ('error', 'exchange_forbidden');
      $smarty->display ('account_exchange_preview.tpl');
      exit ();
    }

    $exchange_amount = sprintf ('%.02f', (1 - $percent) * $amount);
    if ($exchange_amount <= 0)
    {
      $smarty->assign ('error', 'to_small_amount');
      $smarty->display ('account_exchange_preview.tpl');
      exit ();
    }

    $from_name = $exchange_systems[$from]['name'];
    $to_name = $exchange_systems[$to]['name'];
    $q = 'INSERT into hm2_history SET user_id = ' . $id . ', amount = -' . $amount . ', actual_amount = -' . $amount . ', date = now(), type = \'exchange_in\', description = \'Send $' . $amount . ' ' . $from_name . ' to ' . $to_name . '\', ec = ' . $from . '  ';
    mysql_query ($q);
    $q = 'INSERT into hm2_history SET user_id = ' . $id . ', amount = ' . $exchange_amount . ', actual_amount = ' . $exchange_amount . ', date = now(), type = \'exchange_out\', description = \'Receive $' . $exchange_amount . ' ' . $to_name . ' from ' . $from_name . '\', ec = ' . $to . ' ';
    mysql_query ($q);
    $info = array ();
    $info['username'] = $userinfo['username'];
    $info['name'] = $userinfo['name'];
    $info['currency_from'] = $exchange_systems[$from]['name'];
    $info['amount_from'] = number_format ($amount, 2);
    $info['currency_to'] = $exchange_systems[$to]['name'];
    $info['amount_to'] = number_format ($exchange_amount, 2);
    $q = 'SELECT email FROM hm2_users WHERE id = 1';
    $sth = mysql_query ($q);
    $admin_email = '';
    while ($row = mysql_fetch_array ($sth))
    {
      $admin_email = $row['email'];
    }

    send_mail ('exchange_admin_notification', $admin_email, $settings['system_email'], $info);
    send_mail ('exchange_user_notification', $userinfo[email], $settings['system_email'], $info);
    header ('Location: account_exchange.php?display=ok');
    exit ();
  }

  $balances = array ();
  $tmp_amounts = array ();
  $q = 'select sum(actual_amount) as sm, ec from hm2_history where user_id = ' . $id . ' group by ec order by ec asc';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $row['sm'] = floor ($row['sm'] * 100) / 100;
    if (!(sprintf ('%.02f', $row['sm']) <= 0))
    {
      $tmp_amounts[$row['ec']] = $row['sm'];
      $tos = array ();
      foreach ($exchange_systems as $to => $data)
      {
        $q1 = 'select * from hm2_exchange_rates where sfrom = ' . $row['ec'] . ' and sto = ' . $to;
        $sth1 = mysql_query ($q1);
        $row1 = mysql_fetch_array ($sth1);
        $row1['percent'] = intval ($row1['percent']);
        if ($row1['percent'] != 100)
        {
          if ($exchange_systems[$to]['status'])
          {
            array_push ($tos, array ('to' => $to, 'ec_name' => $exchange_systems[$to]['name'], 'percent' => $row1['percent']));
            continue;
          }

          continue;
        }
      }

      if ($settings['hold_only_first_days'] == 1)
      {
        $q = 'select hm2_deposits.id, hm2_types.hold from hm2_deposits, hm2_types where user_id = ' . $userinfo[id] . ' and hm2_types.id = hm2_deposits.type_id and hm2_deposits.deposit_date + interval hm2_types.hold day > now()';
      }
      else
      {
        $q = 'SELECT hm2_deposits.id, hm2_types.hold from hm2_deposits, hm2_types where user_id = ' . $userinfo[id] . ' and hm2_types.id = hm2_deposits.type_id ';
      }

      if (!($sthz = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $deps = array ();
      $deps[0] = 0;
      $on_hold = 0;
      while ($rowz = mysql_fetch_array ($sthz))
      {
        $q = 'select sum(actual_amount) as amount from hm2_history where user_id = ' . $userinfo['id'] . (' and ec = ' . $row[ec] . ' AND deposit_id = ' . $rowz[id] . ' and date > now() - interval ' . $rowz[hold] . ' day AND (type=\'earning\' OR (type=\'deposit\' and (description LIKE \'Compou%\' or description like \'<b>Archived transactions</b>:<br>Compound%\')));');
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

      array_push ($balances, array ('balance' => sprintf ('%.02f', $row['sm'] - $on_hold), 'ec' => $row['ec'], 'ec_name' => $exchange_systems[$row['ec']]['name'], 'tos' => $tos));
      continue;
    }
  }

  $smarty->assign ('ec', $balances);
  $exch = array ();
  $q = 'select * from hm2_exchange_rates';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $exch[$row['sfrom']][$row['sto']] = $row['percent'];
  }

  $exchange = array ();
  foreach ($exchange_systems as $from => $data)
  {
    if (!((!$data['status'] AND sprintf ('%.02f', $tmp_amounts[$from]) <= 0)))
    {
      $tos = array ();
      foreach ($exchange_systems as $to => $data)
      {
        if (!((!$data['status'] AND sprintf ('%.02f', $tmp_amounts[$to]) <= 0)))
        {
          if (!($data['status']))
          {
            $exch[$from][$to] = 100;
          }

          if ($from == $to)
          {
            $exch[$from][$to] = 100;
          }

          array_push ($tos, array ('to' => $to, 'percent' => sprintf ('%.02f', $exch[$from][$to])));
          continue;
        }
      }

      array_push ($exchange, array ('from' => $from, 'tos' => $tos));
      continue;
    }
  }

  $smarty->assign ('exchange', $exchange);
  $smarty->display ('account_exchange.tpl');
?>