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

  if (substr ($frm['type'], 0, 8) == 'account_')
  {
    $ps = substr ($frm['type'], 8);
    if ($exchange_systems[$ps][status] == 1)
    {
      $ok = 1;
      $amount = sprintf ('%0.2f', $frm['amount']);
      $h_id = sprintf ('%d', $frm['h_id']);
      $type = $frm['type'];
      $ec = sprintf ('%d', substr ($frm['type'], 8));
      $on_hold = 0;
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

        $q = 'SELECT SUM(actual_amount) AS amount FROM hm2_history WHERE user_id = ' . $userinfo['id'] . (' and ec = ' . $ec . ' AND deposit_id in (') . join (',', $deps) . ') AND (type=\'earning\' OR (type=\'deposit\' and (description like \'Compou%\' or description like \'<b>Archived transactions</b>:<br>Compound%\')));';
        if (!($sth = mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }

        while ($row = mysql_fetch_array ($sth))
        {
          $on_hold = $row[amount];
        }
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
      while ($row = mysql_fetch_array ($sth))
      {
        $q = 'SELECT SUM(actual_amount) as amount from hm2_history where user_id = ' . $userinfo['id'] . (' and ec = ' . $ec . ' AND deposit_id = ' . $row[id] . ' and date > now() - interval ' . $row[hold] . ' day  AND (type=\'earning\' OR (type=\'deposit\' and (description like \'Compou%\' or description like \'<b>Archived transactions</b>:<br>Compound%\')));');
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

      $q = 'SELECT * FROM hm2_types where id = ' . $h_id . ' and closed = 0';
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $type = mysql_fetch_array ($sth);
      $delay = -1;
      if (!($type))
      {
        $smarty->assign ('wrong_plan', 1);
        $ok = 0;
      }
      else
      {
        $plan_name = $type['name'];
        $smarty->assign ('plan_name', $plan_name);
        $delay += $type[delay];
      }

      if ($delay < 0)
      {
        $delay = 0;
      }

      $use_compound = 0;
      if ($type['use_compound'])
      {
        if ($type['compound_max_deposit'] == 0)
        {
          $type['compound_max_deposit'] = $amount + 1;
        }

        if ($type['compound_min_deposit'] <= $amount)
        {
          if ($amount <= $type['compound_max_deposit'])
          {
            $use_compound = 1;
            if ($type['compound_percents_type'] == 1)
            {
              $cps = preg_split ('/\\s*,\\s*/', $type['compound_percents']);
              $cps1 = array ();
              foreach ($cps as $cp)
              {
                array_push ($cps1, sprintf ('%d', $cp));
              }

              sort ($cps1);
              $compound_percents = array ();
              foreach ($cps1 as $cp)
              {
                array_push ($compound_percents, array ('percent' => sprintf ('%d', $cp)));
              }

              $smarty->assign ('compound_percents', $compound_percents);
            }
            else
            {
              $smarty->assign ('compound_min_percents', $type['compound_min_percent']);
              $smarty->assign ('compound_max_percents', $type['compound_max_percent']);
            }
          }
        }
      }

      $smarty->assign ('use_compound', $use_compound);
      $q = 'SELECT COUNT(*) AS col, min(min_deposit) AS min FROM hm2_plans WHERE parent = ' . $h_id;
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $row = mysql_fetch_array ($sth);
      if ($row)
      {
        if ($row['col'] == 0)
        {
          $smarty->assign ('wrong_plan', 1);
          $ok = 0;
        }

        if ($amount < $row['min'])
        {
          $smarty->assign ('less_than_min', 1);
          $smarty->assign ('min_amount', number_format ($row['min'], 2));
          $ok = 0;
        }
      }
      else
      {
        $smarty->assign ('wrong_plan', 1);
        $ok = 0;
      }

      $smarty->assign ('type', $frm['type']);
      $q = 'select sum(actual_amount) as sm, ec from hm2_history where user_id = ' . $userinfo['id'] . ' group by ec';
      $sth = mysql_query ($q);
      while ($row = mysql_fetch_array ($sth))
      {
        $exchange_systems[$row['ec']]['balance'] = $row['sm'];
      }

      $accounting = get_user_balance ($userinfo['id']);
      $max_deposit = $accounting['total'];
      $q = 'select min(max_deposit) as min, max(max_deposit) as max from hm2_plans where parent = ' . $h_id;
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $row = mysql_fetch_array ($sth);
      if ($row)
      {
        if (0 < $row['min'])
        {
          if ($row['max'] < $accounting['total'])
          {
            $max_deposit = $row['max'];
          }
        }
      }

      $ps = substr ($frm['type'], 8);
      if ($exchange_systems[$ps]['balance'] < $amount + $on_hold)
      {
        if ($amount <= $exchange_systems[$ps]['balance'])
        {
          $smarty->assign ('on_hold', 1);
        }
        else
        {
          $smarty->assign ('not_enough_funds', 1);
        }

        $max_deposit = $exchange_systems[$ps]['balance'];
        $ok = 0;
      }

      if ($max_deposit < $amount)
      {
        $smarty->assign ('max_deposit_less', 1);
        $smarty->assign ('max_deposit_format', number_format ($max_deposit, 2));
        $ok = 0;
      }

      $smarty->assign ('ps', $exchange_systems[$ps]['name']);
      if ($ok == 1)
      {
        if ($frm['action'] == 'confirm')
        {
          $ec = $ps;
          $compound = sprintf ('%.02f', $frm['compound']);
          if ($use_compound)
          {
            if ($type['compound_percents_type'] == 1)
            {
              $cps = preg_split ('/\\s*,\\s*/', $type['compound_percents']);
              if (!(in_array ($compound, $cps)))
              {
                $compound = $cps[0];
              }
            }
            else
            {
              if ($compound < $type['compound_min_percent'])
              {
                $compound = $type['compound_min_percent'];
              }

              if ($type['compound_max_percent'] < $compound)
              {
                $compound = $type['compound_max_percent'];
              }
            }
          }

          $q = 'INSERT INTO hm2_deposits SET user_id = ' . $userinfo['id'] . (', type_id = ' . $h_id . ', deposit_date = now(), last_pay_date = now() + interval ' . $delay . ' day, status = \'on\', amount = ' . $amount . ', actual_amount = ' . $amount . ', compound = ' . $compound . ', ec = ' . $ec . '  ');
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }

          $deposit_id = mysql_insert_id ();
          $q = 'INSERT INTO hm2_history SET user_id = ' . $userinfo['id'] . (', amount = -' . $amount . ',actual_amount = -' . $amount . ', type=\'deposit\', date = now(), description = \'Deposit to ' . $plan_name . '\', ec = ' . $ec . ',deposit_id = ' . $deposit_id . ' ');
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }

          $user_id = $userinfo['id'];
          referral_commission ($user_id, $amount, $ec);
          header ('Location: account_deposit.php?say=deposit_success');
          exit ();
        }
      }

      $smarty->assign ('ok', $ok);
      $smarty->assign ('h_id', $h_id);
      $smarty->assign ('amount', number_format ($amount, 2));
      $smarty->assign ('famount', $amount);
      $smarty->display ('deposit.account.confirm.tpl');
      return 1;
    }

    include 'inc/deposit.php';
    return 1;
  }

  if (substr ($frm['type'], 0, 8) == 'process_')
  {
    $ps = substr ($frm['type'], 8);
    if ($exchange_systems[$ps][status] == 1)
    {
      if (is_numeric ($ps))
      {
        $amount = sprintf ('%0.2f', $frm['amount']);
        $h_id = sprintf ('%d', $frm['h_id']);
        $compounding = sprintf ('%d', $frm['compound']);
        $ecurrency = $exchange_systems[$ps][sfx];
        deposit_confirm ($amount, $h_id, $compounding, $ecurrency);
        return 1;
      }

      $ok = 1;
      $amount = sprintf ('%0.2f', $frm['amount']);
      $h_id = sprintf ('%d', $frm['h_id']);
      $q = 'SELECT * FROM hm2_types WHERE id = ' . $h_id . ' and closed = 0';
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $type = mysql_fetch_array ($sth);
      if (!($type))
      {
        $smarty->assign ('wrong_plan', 1);
      }
      else
      {
        $plan_name = $type['name'];
        $smarty->assign ('plan_name', $plan_name);
      }

      $use_compound = 0;
      if ($type['use_compound'])
      {
        if ($type['compound_max_deposit'] == 0)
        {
          $type['compound_max_deposit'] = $amount + 1;
        }

        if ($type['compound_min_deposit'] <= $amount)
        {
          if ($amount <= $type['compound_max_deposit'])
          {
            $use_compound = 1;
            if ($type['compound_percents_type'] == 1)
            {
              $cps = preg_split ('/\\s*,\\s*/', $type['compound_percents']);
              $cps1 = array ();
              foreach ($cps as $cp)
              {
                array_push ($cps1, sprintf ('%d', $cp));
              }

              sort ($cps1);
              $compound_percents = array ();
              foreach ($cps1 as $cp)
              {
                array_push ($compound_percents, array ('percent' => sprintf ('%d', $cp)));
              }

              $smarty->assign ('compound_percents', $compound_percents);
            }
            else
            {
              $smarty->assign ('compound_min_percents', $type['compound_min_percent']);
              $smarty->assign ('compound_max_percents', $type['compound_max_percent']);
            }
          }
        }
      }

      $smarty->assign ('use_compound', $use_compound);
      $q = 'SELECT `value` FROM hm2_settings WHERE name=\'wire_text\'';
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      while ($row = mysql_fetch_array ($sth))
      {
        $wire_txt = $row['value'];
      }

      $q = 'SELECT count(*) as col, min(min_deposit) AS min FROM hm2_plans WHERE parent = ' . $h_id;
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $row = mysql_fetch_array ($sth);
      if ($row)
      {
        if ($row['col'] == 0)
        {
          $smarty->assign ('wrong_plan', 1);
          $ok = 0;
        }

        if ($amount < $row['min'])
        {
          $smarty->assign ('less_than_min', 1);
          $smarty->assign ('min_amount', number_format ($row['min'], 2));
          $ok = 0;
        }
      }
      else
      {
        $smarty->assign ('wrong_plan', 1);
        $ok = 0;
      }

      $accounting = get_user_balance ($userinfo['id']);
      $max_deposit = 0;
      $q = 'SELECT min(max_deposit) AS min, max(max_deposit) AS max from hm2_plans WHERE parent = ' . $h_id;
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $row = mysql_fetch_array ($sth);
      if ($row)
      {
        if (0 < $row['min'])
        {
          if ($row['max'] < $accounting['total'])
          {
            $max_deposit = $row['max'];
          }
        }
      }

      if ($max_deposit < $amount)
      {
        if (0 < $max_deposit)
        {
          $smarty->assign ('max_deposit_less', 1);
          $smarty->assign ('max_deposit_format', number_format ($max_deposit, 2));
          $ok = 0;
        }
      }

      if ($ok == 1)
      {
        if ($frm['action'] == 'confirm')
        {
          $compound = sprintf ('%.02f', $frm['compound']);
          if ($use_compound)
          {
            if ($type['compound_percents_type'] == 1)
            {
              $cps = preg_split ('/\\s*,\\s*/', $type['compound_percents']);
              if (!(in_array ($compound, $cps)))
              {
                $compound = $cps[0];
              }
            }
            else
            {
              if ($compound < $type['compound_min_percent'])
              {
                $compound = $type['compound_min_percent'];
              }

              if ($type['compound_max_percent'] < $compound)
              {
                $compound = $type['compound_max_percent'];
              }
            }
          }

          $q = 'INSERT INTO hm2_wires SET user_id = \'' . $userinfo['id'] . '\', pname = \'' . quote ($frm['pname']) . '\', paddress = \'' . quote ($frm['paddress']) . '\', pzip = \'' . quote ($frm['pcity']) . '\', pcity = \'' . quote ($frm['pcity']) . '\', pstate = \'' . quote ($frm['pstate']) . '\', pcountry = \'' . quote ($frm['pcountry']) . '\', bname = \'' . quote ($frm['bname']) . '\', baddress = \'' . quote ($frm['baddress']) . '\', bzip = \'' . quote ($frm['bzip']) . '\', bcity = \'' . quote ($frm['bcity']) . '\', bstate = \'' . quote ($frm['bstate']) . '\', bcountry = \'' . quote ($frm['bcountry']) . '\', baccount = \'' . quote ($frm['baccount']) . '\', biban = \'' . quote ($frm['biban']) . '\', bswift = \'' . quote ($frm['bswift']) . ('\', amount = ' . $amount . ', type_id = ' . $h_id . ', wire_date = now(), status = \'new\', compound = ' . $compound);
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }

          $info = array ();
          $info['username'] = $userinfo['username'];
          $info['name'] = $userinfo['name'];
          $info['amount'] = $amount;
          $info['currency'] = 'Bank Wire';
          $info['bank_name'] = $frm['bname'];
          $info['bank_account'] = $frm['baccount'];
          $info['plan'] = $plan_name;
          $q = 'select date_format(now() + interval ' . $settings['time_dif'] . ' hour, \'%b-%e-%Y %r\') as date';
          $sth = mysql_query ($q);
          $row = mysql_fetch_array ($sth);
          $info['date'] = $row['date'];
          $q = 'SELECT email FROM hm2_users WHERE id = 1';
          $sth = mysql_query ($q);
          $admin_row = mysql_fetch_array ($sth);
          send_mail ('wire_admin_notification', $admin_row['email'], $settings['opt_in_email'], $info);
          send_mail ('wire_user_notification', $userinfo['email'], $settings['opt_in_email'], $info);
          header ('Location: account_deposit.php?say=deposit_wire_saved');
        }
      }

      $compound = sprintf ('%d', $frm['compound']);
      $smarty->assign ('ok', $ok);
      $smarty->assign ('h_id', $h_id);
      $smarty->assign ('amount', number_format ($amount, 2));
      $smarty->assign ('famount', $amount);
      $smarty->assign ('wire_txt', $wire_txt);
      $smarty->assign ('compounding', $compound);
      $smarty->display ('deposit.wire.confirm.tpl');
      return 1;
    }

    include 'inc/deposit.php';
    return 1;
  }

  if (substr ($frm['type'], 0, 8) == 'wire')
  {
    include 'inc/deposit.php';
    return 1;
  }

  include 'inc/deposit.php';
?>