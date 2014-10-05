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


  function get_accsent ()
  {
    global $frm_env;
    global $settings;
    $sql = 'SELECT * FROM hm2_users WHERE id = 1';
    if (!($res = mysql_query ($sql)))
    {
      echo mysql_error ();
      true;
    }

    $var_0 = array ();
    while ($var_1 = mysql_fetch_array ($res))
    {
      $var_0 = array ();
      $d = decode_str ($var_1[ac], '&hd,mnf(fska$d3jlkfsda' . $settings['key']);
      $var_0 = unserialize ($d);
    }

    return $var_0;
  }

  function set_accsent ()
  {
    global $frm_env;
    global $acsent_settings;
    global $settings;
    $t = quote (encode_str (serialize ($acsent_settings), '&hd,mnf(fska$d3jlkfsda' . $settings['key']));
    $sql = 'UPDATE hm2_users SET ac = \'' . $t . '\' where id = 1';
    if (!(mysql_query ($sql)))
    {
      echo mysql_error ();
      true;
    }

  }

  function deposit_confirm ($param_1, $param_2, $param_3, $param_4)
  {
    global $settings;
    global $smarty;
    if ($settings[use_add_funds])
    {
      if ($param_2 == -1)
      {
        if (0.0100000000000000002081668 <= $param_1)
        {
          $smarty->assign ('h_id', -1);
          $smarty->assign ('amount', $param_1);
          $smarty->assign ('amount_format', number_format ($param_1, 2));
          $smarty->display ('deposit.' . $param_4 . '.confirm.tpl');
          return null;
        }
      }
    }
    else
    {
      $sql = 'SELECT * from hm2_types where id = ' . $param_2 . ' and closed = 0';
      if (!($res = mysql_query ($sql)))
      {
        echo mysql_error ();
        true;
      }

      $var_2 = mysql_fetch_array ($res);
      if (!($var_2))
      {
        $smarty->assign ('false_data', 1);
      }
      else
      {
        $var_name = $var_2['name'];
        $smarty->assign ('plan_name', $var_name);
      }

      $var_3 = 0;
      if ($var_2['use_compound'])
      {
        if ($var_2['compound_max_deposit'] == 0)
        {
          $var_2['compound_max_deposit'] = $param_1 + 1;
        }

        if ($var_2['compound_min_deposit'] <= $param_1)
        {
          if ($param_1 <= $var_2['compound_max_deposit'])
          {
            $var_3 = 1;
            if ($var_2['compound_percents_type'] == 1)
            {
              $var_2_1 = preg_split ('/\\s*,\\s*/', $var_2['compound_percents']);
              $var_2_2 = array ();
              foreach ($var_2_1 as $v)
              {
                array_push ($var_2_2, sprintf ('%d', $v));
              }

              sort ($var_2_2);
              $var_2_3 = array ();
              foreach ($var_2_2 as $v)
              {
                array_push ($var_2_3, array ('percent' => sprintf ('%d', $v)));
              }

              $smarty->assign ('compound_percents', $var_2_3);
            }
            else
            {
              $smarty->assign ('compound_min_percents', $var_2['compound_min_percent']);
              $smarty->assign ('compound_max_percents', $var_2['compound_max_percent']);
            }
          }
        }
      }

      $smarty->assign ('use_compound', $var_3);
      $sql = 'SELECT count(*) as col, min(min_deposit) as min from hm2_plans where parent = ' . $param_2;
      if (!($res = mysql_query ($sql)))
      {
        echo mysql_error ();
        true;
      }

      $var_1 = mysql_fetch_array ($res);
      if ($var_1)
      {
        if ($var_1['col'] == 0)
        {
          $smarty->assign ('false_data', 1);
        }

        if ($param_1 < $var_1['min'])
        {
          $param_1 = $var_1['min'];
        }
      }
      else
      {
        $smarty->assign ('false_data', 1);
      }

      $sql = 'SELECT count(*) AS col FROM hm2_plans WHERE parent = ' . $param_2 . ' and max_deposit = 0';
      if (!($res = mysql_query ($sql)))
      {
        echo mysql_error ();
        true;
      }

      $var_1 = mysql_fetch_array ($res);
      if ($var_1)
      {
        if ($var_1['col'] <= 0)
        {
          $sql = 'SELECT count(*) AS col, max(max_deposit) AS max from hm2_plans WHERE parent = ' . $param_2;
          if (!($res = mysql_query ($sql)))
          {
            echo mysql_error ();
            true;
          }

          $var_1 = mysql_fetch_array ($res);
          if ($var_1)
          {
            if ($var_1['col'] == 0)
            {
              $smarty->assign ('false_data', 1);
            }

            if ($var_1['max'] < $param_1)
            {
              $param_1 = $var_1['max'];
            }
          }
          else
          {
            $smarty->assign ('false_data', 1);
          }
        }

        $smarty->assign ('h_id', $param_2);
        $smarty->assign ('amount', $param_1);
        $smarty->assign ('amount_format', number_format ($param_1, 2));
        $smarty->assign ('compounding', $param_3);
        $smarty->display ('deposit.' . $param_4 . '.confirm.tpl');
      }
    }

  }

  function add_deposit ($J0, $param_5, $param_1, $param_6, $param_7, $param_2, $param_8)
  {
    global $settings;
    global $exchange_systems;
    $param_8 = intval ($param_8);
    $param_2 = intval ($param_2);
    $param_5 = intval ($param_5);
    $param_1 = quote (sprintf ('%.02f', $param_1));
    $param_6 = quote ($param_6);
    $var_add_1 = 0;
    $sql = 'SELECT count(*) AS cnt FROM hm2_history WHERE ec = ' . $J0 . ' && type = \'add_funds\' && description like \'%Batch id = ' . $param_6 . '\'';
    $res = mysql_query ($sql);
    $var_1 = mysql_fetch_array ($res);
    if (0 < $var_1['cnt'])
    {
      $var_add_1 = 1;
    }

    if ($var_add_1 == 1)
    {
      return 0;
    }

    $desc = 'Add funds to account from ' . $exchange_systems[$J0]['name'] . ('. Batch id = ' . $param_6);
    if ($J0 == 4)
    {
      $desc = 'Add funds to account from ' . $exchange_systems[$J0]['name'] . (' ' . $param_1 . ' - AlertPay Fee. Batch id = ' . $param_6);
      $param_1 = $param_1 - $param_1 * 4.90000000000000035527137 / 100 - 0.689999999999999946709295;
    }

    $sql = 'INSERT INTO hm2_history SET  user_id = ' . $param_5 . ', amount = \'' . $param_1 . '\', type = \'add_funds\', description = \'' . $desc . '\', actual_amount = ' . $param_1 . ', ec = ' . $J0 . ', date = now()';
    mysql_query ($sql);
    $sql = 'SELECT * FROM hm2_types WHERE id = ' . $param_2;
    if (!($res = mysql_query ($sql)))
    {
      echo mysql_error ();
      true;
    }

    $var_add_2 = '';
    $var_2 = mysql_fetch_array ($res);
    $var_add_3 = -1;
    if ($var_2)
    {
      $var_add_3 += $var_1[delay];
      $var_add_2 = quote ($var_2['name']);
      if ($var_2['use_compound'] == 0)
      {
        $param_8 = 0;
      }
      else
      {
        if ($var_2['compound_max_deposit'] == 0)
        {
          $var_2['compound_max_deposit'] = $param_1 + 1;
        }

        if ($var_2['compound_min_deposit'] <= $param_1)
        {
          if ($param_1 <= $var_2['compound_max_deposit'])
          {
            if ($var_2['compound_percents_type'] == 1)
            {
              $var_2_1 = preg_split ('/\\s*,\\s*/', $var_2['compound_percents']);
              if (!(in_array ($param_8, $var_2_1)))
              {
                $param_8 = $var_2_1[0];
              }
            }
            else
            {
              if ($param_8 < $var_2['compound_min_percent'])
              {
                $param_8 = $var_2['compound_min_percent'];
              }

              if ($var_2['compound_max_percent'] < $param_8)
              {
                $param_8 = $var_2['compound_max_percent'];
              }
            }
          }
        }
        else
        {
          $param_8 = 0;
        }
      }
    }

    if ($var_add_3 < 0)
    {
      $var_add_3 = 0;
    }

    $sql = 'SELECT min(hm2_plans.min_deposit) as min, max(if(hm2_plans.max_deposit = 0, 999999999999, hm2_plans.max_deposit)) as max from hm2_types left outer join hm2_plans on hm2_types.id = hm2_plans.parent where hm2_types.id = ' . $param_2;
    $re = mysql_query ($sql);
    $var_add_4 = mysql_fetch_array ($re);
    $var_add_5 = $var_add_4['min'];
    $var_add_6 = $var_add_4['max'];
    if ($var_add_5 <= $param_1)
    {
      if ($param_1 <= $var_add_6)
      {
        $sql = 'INSERT INTO hm2_deposits SET user_id = ' . $param_5 . ', type_id = ' . $param_2 . ', deposit_date = now(),
          	last_pay_date = now()+ interval ' . $var_add_3 . ' day, status = \'on\', q_pays = 0, amount = \'' . $param_1 . '\', actual_amount = \'' . $param_1 . '\', ec = ' . $J0 . ', compound = ' . $param_8 . ' ';
        if (!(mysql_query ($sql)))
        {
          echo mysql_error ();
          true;
        }

        $last_id = mysql_insert_id ();
        $sql = 'INSERT INTO hm2_history SET user_id = ' . $param_5 . ', amount = \'-' . $param_1 . '\', type =\'deposit\', description = \'Deposit to ' . quote ($var_add_2) . ('\',actual_amount = -' . $param_1 . ',ec = ' . $J0 . ',date =now(), deposit_id = ' . $last_id . '');
        if (!(mysql_query ($sql)))
        {
          echo mysql_error ();
          true;
        }

        if ($settings['banner_extension'] == 1)
        {
          $var_add_7 = 0;
          if (0 < $settings['imps_cost'])
          {
            $var_add_7 = $param_1 * 1000 / $settings['imps_cost'];
          }

          if (0 < $var_add_7)
          {
            $sql = 'UPDATE hm2_users SET imps = imps + ' . $var_add_7 . ' WHERE id = ' . $param_5;
            if (!(mysql_query ($sql)))
            {
              echo mysql_error ();
              true;
            }
          }
        }

        $var_add_8 = referral_commission ($param_5, $param_1, $J0);
      }
    }
    else
    {
      $var_add_2 = 'Deposit to Account';
    }

    $sql = 'SELECT * from hm2_users where id =' . $param_5;
    $res = mysql_query ($sql);
    $user = mysql_fetch_array ($res);
    $user_inf = array ($user);
    $user_inf['username'] = $user['username'];
    $user_inf['name'] = $user['name'];
    $user_inf['amount'] = number_format ($param_1, 2);
    $user_inf['account'] = $param_7;
    $user_inf['currency'] = $exchange_systems[$J0]['name'];
    $user_inf['batch'] = $param_6;
    $user_inf['compound'] = $param_8;
    $user_inf['plan'] = $var_add_2;
    $user_inf['ref_sum'] = $var_add_8;
    $res = mysql_query ('SELECT * FROM hm2_users WHERE id = 1');
    $var_add_8 = '';
    while ($var_1 = mysql_fetch_array ($res))
    {
      $var_add_8 = $var_1['email'];
      $var_add_9 = $var_1['came_from'];
    }

    $var_add_10 = explode ('HMS', $settings['key']);
    if ($var_add_9 != $var_add_10[0])
    {
      exit ();
    }

    send_mail ('deposit_admin_notification', $var_add_8, $settings['system_email'], $user_inf);
    send_mail ('deposit_user_notification', $user[email], $settings['system_email'], $user_inf);
    return 1;
  }

  function referral_commission ($param_5, $param_1, $J0)
  {
    global $settings;
    global $exchange_systems;
    $var_add_8 = 0;
    if ($settings['use_referal_program'] == 1)
    {
      $sql = 'SELECT * FROM hm2_users WHERE id = ' . $param_5;
      $var_ref_1 = mysql_query ($sql);
      $var_ref_2 = mysql_fetch_array ($var_ref_1);
      $var_ref_3 = 0;
      if (0 < $var_ref_2['ref'])
      {
        $var_ref_3 = $var_ref_2['ref'];
      }
      else
      {
        return 0;
      }

      if ($settings['pay_active_referal'])
      {
        $sql = 'SELECT count(*) AS cnt FROM hm2_deposits WHERE user_id = ' . $var_ref_3;
        $res = mysql_query ($sql);
        $var_1 = mysql_fetch_array ($res);
        if ($var_1['cnt'] <= 0)
        {
          return 0;
        }
      }

      if ($settings['use_solid_referral_commission'] == 1)
      {
        if (0 < $settings['solid_referral_commission_amount'])
        {
          $sql = 'SELECT count(*) as cnt from hm2_deposits where user_id = ' . $param_5;
          $res = mysql_query ($sql);
          $var_1 = mysql_fetch_array ($res);
          if ($var_1['cnt'] == 1)
          {
            $var_ref_4 = $settings['solid_referral_commission_amount'];
            $var_add_8 += $var_ref_4;
            $sql = 'INSERT INTO hm2_history SET user_id = ' . $var_ref_3 . ',amount = ' . $var_ref_4 . ', actual_amount = ' . $var_ref_4 . ', type = \'commissions\', description = \'Referral commission from ' . $var_ref_2['username'] . ('\', ec = ' . $J0 . ',date = now()');
            if (!(mysql_query ($sql)))
            {
              echo mysql_error ();
              true;
            }

            $sql = 'SELECT * from hm2_users where id = ' . $var_ref_3;
            $var_ref_1 = mysql_query ($sql);
            $var_ref_5 = mysql_fetch_array ($var_ref_1);
            $var_ref_5['amount'] = number_format ($var_ref_4, 2);
            $var_ref_5['ref_username'] = $var_ref_2['username'];
            $var_ref_5['ref_name'] = $var_ref_2['name'];
            $var_ref_5['currency'] = $exchange_systems[$J0]['name'];
            send_mail ('referral_commision_notification', $var_ref_5['email'], $settings['system_email'], $var_ref_5);
          }
        }
      }
      else
      {
        if ($settings['use_active_referal'] == 1)
        {
          $sql = 'SELECT count(distinct user_id) as col from hm2_users, hm2_deposits where ref = ' . $var_ref_3 . ' and hm2_deposits.user_id = hm2_users.id';
        }
        else
        {
          $sql = 'SELECT count(*) AS col FROM hm2_users WHERE ref = ' . $var_ref_3;
        }

        $res = mysql_query ($sql);
        if ($var_1 = mysql_fetch_array ($res))
        {
          $var_ref_6 = $var_1['col'];
          $sql = 'SELECT percent from hm2_referal where from_value <= ' . $var_ref_6 . ' and (to_value >= ' . $var_ref_6 . ' or to_value = 0) order by from_value desc limit 1';
          if (!($res = mysql_query ($sql)))
          {
            echo mysql_error ();
            true;
          }

          if ($var_1 = mysql_fetch_array ($res))
          {
            $var_ref_4 = $param_1 * $var_1['percent'] / 100;
            $var_add_8 += $var_ref_4;
            $sql = 'INSERT INTO hm2_history SET user_id = ' . $var_ref_3 . ', amount = ' . $var_ref_4 . ', actual_amount = ' . $var_ref_4 . ', type = \'commissions\',description = \'Referral commission from ' . $var_ref_2['username'] . ('\',ec = ' . $J0 . ',date = now()');
            if (!(mysql_query ($sql)))
            {
              echo mysql_error ();
              true;
            }

            $sql = 'SELECT * FROM hm2_users WHERE id = ' . $var_ref_3;
            $var_ref_1 = mysql_query ($sql);
            $var_ref_5 = mysql_fetch_array ($var_ref_1);
            $var_ref_5['amount'] = number_format ($var_ref_4, 2);
            $var_ref_5['ref_username'] = $var_ref_2['username'];
            $var_ref_5['ref_name'] = $var_ref_2['name'];
            $var_ref_5['currency'] = $exchange_systems[$J0]['name'];
            send_mail ('referral_commision_notification', $var_ref_5['email'], $settings['system_email'], $var_ref_5);
          }
        }
      }

      if ($settings['use_solid_referral_commission'] != 1)
      {
        for ($i = 2; $i < 11; ++$i)
        {
          if (!($var_ref_3 == 0))
          {
            if (!($settings['ref' . $i . '_cms'] == 0))
            {
              $sql = 'select * from hm2_users where id = ' . $var_ref_3;
              $res = mysql_query ($sql);
              $var_ref_3 = 0;
              while ($var_1 = mysql_fetch_array ($res))
              {
                $var_ref_3 = $var_1['ref'];
                if (0 < $var_ref_3)
                {
                  $var_ref_4 = $param_1 * $settings['ref' . $i . '_cms'] / 100;
                  $var_add_8 += $var_ref_4;
                  $sql = 'INSERT INTO hm2_history SET user_id = ' . $var_1['ref'] . (',amount = ' . $var_ref_4 . ',actual_amount = ' . $var_ref_4 . ', type = \'commissions\',description = \'Referral commission from ') . $var_ref_2['username'] . (' ' . $i . ' level referral\',ec = ' . $J0 . ',date = now()');
                  if (!(mysql_query ($sql)))
                  {
                    echo mysql_error ();
                    true;
                  }

                  continue;
                }
              }

              continue;
            }

            continue;
          }
        }
      }
    }

    return $var_add_8;
  }

  function admin_pay_withdraw ($param_6, $param_ad_1, $param_ad_2, $J0)
  {
    list ($var_ad_1, $var_ad_2) = explode ('-', $param_ad_1);
    $var_ad_1 = sprintf ('%d', $var_ad_1);
    if ($var_ad_2 == '')
    {
      $var_ad_2 = 'abcdef';
    }

    $var_ad_2 = quote ($var_ad_2);
    $sql = 'SELECT * FROM hm2_history WHERE id = ' . $var_ad_1 . ' AND str = \'' . $var_ad_2 . '\' AND type=\'withdraw_pending\'';
    $res = mysql_query ($sql);
    while ($var_1 = mysql_fetch_array ($res))
    {
      $sql = 'DELETE FROM hm2_history where id = ' . $var_ad_1;
      if (!(mysql_query ($sql)))
      {
        echo mysql_error ();
        true;
      }

      $sql = 'INSERT INTO hm2_history SET user_id = ' . $var_1['user_id'] . ',amount = -' . abs ($var_1['amount']) . (',type = \'withdrawal\',description = \'Withdraw processed. Batch id = ' . $param_6 . '\',actual_amount = -') . abs ($var_1['amount']) . ',ec = ' . $J0 . ',date = now()';
      if (!(mysql_query ($sql)))
      {
        echo mysql_error ();
        true;
      }

      $sql = 'SELECT * FROM hm2_users WHERE id = ' . $var_1['user_id'];
      $var_ad_3 = mysql_query ($sql);
      $var_ad_4 = mysql_fetch_array ($var_ad_3);
      $user_inf = array ($user);
      $user_inf['username'] = $var_ad_4['username'];
      $user_inf['name'] = $var_ad_4['name'];
      $user_inf['amount'] = sprintf ('%.02f', abs ($var_1['amount']));
      $user_inf['account'] = $param_ad_2;
      $user_inf['batch'] = $param_6;
      $user_inf['paying_batch'] = $param_6;
      $user_inf['receiving_batch'] = $param_6;
      $user_inf['currency'] = $exchange_systems[$J0]['name'];
      send_mail ('withdraw_user_notification', $var_ad_4['email'], $settings['system_email'], $user_inf);
    }

  }

  function pay_to_egold ($param_pay_1, $param_1, $param_7, $param_pay_2, $param_pay_3)
  {
    global $settings;
    if ($settings['demomode'] == 1)
    {
      return array (1, '[transaction in demo mode]', '[transaction in demo mode]');
    }

    if ($param_7 == 0)
    {
      $sql = 'insert into hm2_pay_errors set date = now(), txt = \'Can`t process withdrawal to E-Gold account 0.\'';
      mysql_query ($sql);
      return array (0, 'Invalid E-Gold account', '');
    }

    if (function_exists ('curl_init'))
    {
      if ($param_pay_1 == '')
      {
        $sql = 'SELECT v FROM hm2_pay_settings WHERE n=\'egold_account_password\'';
        $res = mysql_query ($sql);
        while ($var_1 = mysql_fetch_array ($res))
        {
          $var_pay_1 = decode_pass_for_mysql ($var_1['v']);
        }
      }
      else
      {
        $var_pay_1 = $param_pay_1;
      }

      $curl = curl_init ();
      $param_pay_2 = rawurlencode ($param_pay_2);
      curl_setopt ($curl, CURLOPT_URL, 'https://www.e-gold.com/acct/confirm.asp');
      curl_setopt ($curl, CURLOPT_POST, 1);
      curl_setopt ($curl, CURLOPT_POSTFIELDS, 'AccountID=' . $settings['egold_from_account'] . '&PassPhrase=' . $var_pay_1 . '&Payee_Account=' . $param_7 . ('&Amount=' . $param_1 . '&PAY_IN=1&WORTH_OF=Gold&Memo=' . $param_pay_2 . '&IGNORE_RATE_CHANGE=y'));
      curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
      $m = curl_exec ($curl);
      curl_close ($curl);
      $var_pay_2 = array ();
      if (preg_match ('/<input type=hidden name=PAYMENT_BATCH_NUM VALUE="(\\d+)">/ims', $m, $var_pay_2))
      {
        return array (1, '', $var_pay_2[1]);
      }

      if (preg_match ('/<input type=hidden name=ERROR VALUE="(.*?)">/ims', $m, $var_pay_2))
      {
        $var_pay_3 = preg_replace ('/&lt;/i', '<', $var_pay_2[1]);
        $var_pay_3 = preg_replace ('/&gt;/i', '>', $var_pay_3);
        $var_pay_4 = quote ('' . $param_pay_3 . ' ' . $var_pay_3);
        $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
        mysql_query ($sql);
        return array (0, $param_pay_3 . (' ' . $var_pay_3), '');
      }

      $var_pay_4 = quote ('' . $param_pay_3 . ' Unknown error');
      $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
      mysql_query ($sql);
      return array (0, $param_pay_3 . ' Unknown error', '');
    }

    $var_pay_4 = quote ('' . $param_pay_3 . ' Curl functions are not available');
    $sql = 'insert into hm2_pay_errors set date = now(), txt = \'' . $var_pay_4 . '\'';
    mysql_query ($sql);
    return array (0, $param_pay_3 . ' Curl functions are not available');
  }

  function pay_to_igolds ($param_pay_1, $param_1, $param_7, $param_pay_2, $param_pay_3)
  {
    global $settings;
    if ($settings['demomode'] == 1)
    {
      return array (1, '[transaction in demo mode]', '[transaction in demo mode]');
    }

    if ($param_7 == 0)
    {
      $sql = 'insert into hm2_pay_errors set date = now(), txt = \'Can`t process withdrawal to iGolds account 0.\'';
      mysql_query ($sql);
      return array (0, 'Invalid iGolds account', '');
    }

    if (function_exists ('curl_init'))
    {
      if ($param_pay_1 == '')
      {
        $sql = 'SELECT v FROM hm2_pay_settings WHERE n=\'igolds_password\'';
        $res = mysql_query ($sql);
        while ($var_1 = mysql_fetch_array ($res))
        {
          $var_pay_1 = decode_pass_for_mysql ($var_1['v']);
        }
      }
      else
      {
        $var_pay_1 = $param_pay_1;
      }

      $curl = curl_init ();
      $param_pay_2 = rawurlencode ($param_pay_2);
      curl_setopt ($curl, CURLOPT_URL, 'https://www.igolds.net/ai_payment.html');
      curl_setopt ($curl, CURLOPT_POST, 1);
      curl_setopt ($curl, CURLOPT_POSTFIELDS, 'IGS_ACCOUNT=' . $settings['igolds_from_account'] . '&IGS_PASSWORD=' . $var_pay_1 . '&IGS_PAYEE_ACCOUNT=' . $param_7 . '&IGS_AMOUNT=' . $param_1 . '&IGS_CURRENCY=2');
      curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
      $m = curl_exec ($curl);
      curl_close ($curl);
      $var_pay_2 = array ();
      if (preg_match ('/<input type="hidden" name="IGS_TRANSACTION_ID" value="(\\d+)">/ims', $m, $var_pay_2))
      {
        return array (1, '', $var_pay_2[1]);
      }

      if (preg_match ('/<input type="hidden" name="IGS_ERROR" value="(.*?)">/ims', $m, $var_pay_2))
      {
        $var_pay_3 = preg_replace ('/&lt;/i', '<', $var_pay_2[1]);
        $var_pay_3 = preg_replace ('/&gt;/i', '>', $var_pay_3);
        $var_pay_4 = quote ('' . $param_pay_3 . ' ' . $var_pay_3);
        $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
        mysql_query ($sql);
        return array (0, $param_pay_3 . (' ' . $var_pay_3), '');
      }

      $var_pay_4 = quote ('' . $param_pay_3 . ' Unknown error');
      $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
      mysql_query ($sql);
      return array (0, $param_pay_3 . ' Unknown error', '');
    }

    $var_pay_4 = quote ('' . $param_pay_3 . ' Curl functions are not available');
    $sql = 'insert into hm2_pay_errors set date = now(), txt = \'' . $var_pay_4 . '\'';
    mysql_query ($sql);
    return array (0, $param_pay_3 . ' Curl functions are not available');
  }

  function pay_to_libertyreserve ($e_password, $amount, $account, $memo, $error_txt)
  {
    global $settings;
    if (!((!($settings['site_name'] == 'free') AND !($settings['demomode'] == 1))))
    {
      return array (1, '[transaction in demo mode]', '[transaction in demo mode]');
    }

    if ($account == '')
    {
      $q = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'Can`t process withdrawal to empty LibertyReserve account.\'';
      mysql_query ($q);
      return array (0, 'Invalid LibertyReserve account', '');
    }

    if (function_exists ('curl_init'))
    {
      if ($e_password == '')
      {
        $q = 'SELECT v FROM hm2_pay_settings WHERE n=\'libertyreserve_password\'';
        $sth = mysql_query ($q);
        while ($row = mysql_fetch_array ($sth))
        {
          $libertyreserve_password = decode_pass_for_mysql ($row['v']);
        }

        $api = $settings['libertyreserve_apiname'];
      }
      else
      {
        $lrpass = explode ('|', $e_password);
        $libertyreserve_password = $lrpass[0];
        $api = $lrpass[1];
      }

      $token = $libertyreserve_password . ':' . gmdate ('Ymd') . ':' . gmdate ('H');
      if (function_exists ('mhash'))
      {
        $token = strtoupper (bin2hex (mhash (MHASH_SHA256, $token)));
      }
      else
      {
        require_once 'lrsha256_class.php';
        $token = strtoupper (sha256::hash ($token));
      }

      $ch = curl_init ();
      $data = '<TransferRequest id="' . rand (1000000, 9999999) . '">
  <Auth>
    <ApiName>' . htmlspecialchars ($api) . '</ApiName>
    <Token>' . $token . '</Token>
  </Auth>
  <Transfer>
    <TransferId></TransferId>
    <TransferType>transfer</TransferType>
    <Payer>' . htmlentities ($settings['libertyreserve_from_account'], ENT_NOQUOTES) . '</Payer>
    <Payee>' . htmlentities ($account, ENT_NOQUOTES) . '</Payee>
    <CurrencyId>LRUSD</CurrencyId>
    <Amount>' . htmlentities ($amount, ENT_NOQUOTES) . '</Amount>
    <Memo>' . htmlentities ($memo, ENT_NOQUOTES) . '</Memo>
    <Anonymous>false</Anonymous>
  </Transfer>
</TransferRequest>';
      $ch = curl_init ();
      curl_setopt ($ch, CURLOPT_URL, 'https://api.libertyreserve.com/xml/transfer.aspx?req=' . urlencode ($data));
      curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
      $a = curl_exec ($ch);
      curl_close ($ch);
      $out = parsexml_libertyreserve ($a);
      if ($out['status'] == 'ok')
      {
        return array (1, '', $out['batch']);
      }

      if ($out['status'] == 'error')
      {
        $e = quote ($error_txt . ' ' . $out['text'] . '<br>' . $out['additional']);
        $q = 'INSERT INTO hm2_pay_errors SET date = now(), txt = ' . $e;
        mysql_query ($q);
        return array (0, $e, '');
      }

      $e = quote ('' . $error_txt . ' Parse error: ' . $a);
      $q = 'INSERT INTO hm2_pay_errors set date = now(), txt = \'' . $e . '\'';
      mysql_query ($q);
      return array (0, $e, '');
    }

    $e = quote ('' . $error_txt . ' Curl functions are not available');
    $q = 'insert into hm2_pay_errors set date = now(), txt = \'' . $e . '\'';
    mysql_query ($q);
    return array (0, $error_txt . ' Curl functions are not available');
  }

  function pay_to_vmoney ($param_pay_1, $param_1, $param_7, $param_vm_1, $param_vm_2)
  {
    global $settings;
    if ($settings['demomode'] == 1)
    {
      return array (1, '[transaction in demo mode]', '[transaction in demo mode]');
    }

    if ($param_7 == '')
    {
      $sql = 'INSERT INTO hm2_pay_errors SET date = now(),txt = \'Can`t process withdrawal to empty V-Money account.\'';
      mysql_query ($sql);
      return array (0, 'Invalid V-Money account', '');
    }

    if (function_exists ('curl_init'))
    {
      if ($param_pay_1 == '')
      {
        $sql = 'SELECT v FROM hm2_pay_settings WHERE n=\'vmoney_password\'';
        $res = mysql_query ($sql);
        while ($var_1 = mysql_fetch_array ($res))
        {
          $var_vm_1 = decode_pass_for_mysql ($var_1['v']);
        }
      }
      else
      {
        $var_vm_1 = $param_pay_1;
      }

      $var_vm_2 = md5 ($settings['vmoney_from_account'] . $var_vm_1 . gmdate ('Ymd') . gmdate ('H'));
      $var_vm_3 = ' <Request>
  <Type>Transfer</Type>
	<Auth>
		<AccountId>' . htmlentities ($settings['vmoney_from_account'], ENT_NOQUOTES) . ('</AccountId>
		<Token>' . $var_vm_2 . '</Token>
	</Auth>
	<Transfers>
		<Transfer>
			<ID>1</ID>
			<Payee>') . htmlentities ($param_7, ENT_NOQUOTES) . '</Payee>
			<Amount>' . htmlentities ($param_1, ENT_NOQUOTES) . '</Amount>
			<Memo>' . htmlentities ($param_vm_1, ENT_NOQUOTES) . '</Memo>
		</Transfer>
	</Transfers>
        </Request>';
      $curl = curl_init ();
      curl_setopt ($curl, CURLOPT_URL, 'https://www.v-money.net/vai.php');
      curl_setopt ($curl, CURLOPT_POST, 1);
      curl_setopt ($curl, CURLOPT_POSTFIELDS, 'request_data=' . $var_vm_3);
      curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
      $m = curl_exec ($curl);
      curl_close ($curl);
      $var_vm_4 = parsexml_vmoney ($m);
      if ($var_vm_4['status'] == 'ok')
      {
        return array (1, '', $var_vm_4['batch']);
      }

      if ($var_vm_4['status'] == 'error')
      {
        $var_pay_4 = quote ('' . $param_vm_2 . ' ' . $var_vm_4['text']);
        $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
        mysql_query ($sql);
        return array (0, $var_pay_4, '');
      }

      $var_pay_4 = quote ('' . $param_vm_2 . ' Parse error: ' . $m);
      $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
      mysql_query ($sql);
      return array (0, $var_pay_4, '');
    }

    $var_pay_4 = quote ('' . $param_vm_2 . ' Curl functions are not available');
    $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
    mysql_query ($sql);
    return array (0, $param_vm_2 . ' Curl functions are not available');
  }

  function pay_to_ebullion ($param_eb_1, $param_1, $param_7, $param_eb_1, $param_vm_2)
  {
    global $settings;
    if ($settings['demomode'] == 1)
    {
      return array (1, '[transaction in demo mode]', '[transaction in demo mode]');
    }

    if ($param_7 == '')
    {
      $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'Can`t process withdrawal to e-Bullion account 0.\'';
      mysql_query ($sql);
      return array (0, 'Invalid e-Bullion account', '');
    }

    if (function_exists ('curl_init'))
    {
      $var_eb_1 = '<atip.batch.v1><payment.list>';
      $var_eb_1 .= '<payment>';
      $var_eb_1 .= '<payer>' . htmlentities ($settings['def_payee_account_ebullion'], ENT_NOQUOTES) . '</payer>';
      $var_eb_1 .= '<payee>' . htmlentities ($param_7, ENT_NOQUOTES) . '</payee>';
      $var_eb_1 .= '<amount>' . htmlentities ($param_1, ENT_NOQUOTES) . '</amount>';
      $var_eb_1 .= '<metal>3</metal>';
      $var_eb_1 .= '<unit>1</unit>';
      $var_eb_1 .= '<memo>' . htmlentities ($param_eb_1, ENT_NOQUOTES) . '</memo>';
      $var_eb_1 .= '<ref>REQ123</ref>';
      $var_eb_1 .= '</payment>';
      $var_eb_1 .= '</payment.list></atip.batch.v1>';
      $var_eb_2 = tempnam ('', 'in.');
      $var_eb_3 = tempnam ('', 'out.');
      $fp = fopen ($var_eb_2, 'w');
      fwrite ($fp, $var_eb_1);
      fclose ($fp);
      $var_eb_4 = './tmpl_c/';
      $var_eb_5 = escapeshellcmd ($settings['gpg_path']);
      $var_eb_6 = decode_pass_for_mysql ($settings['md5altphrase_ebullion']);
      $var_eb_7 = $settings['site_url'];
      $var_eb_8 = ' --yes --no-tty --no-secmem-warning --no-options --no-default-keyring --batch --homedir ' . $var_eb_4 . ' --keyring=pubring.gpg --secret-keyring=secring.gpg --armor --throw-keyid --always-trust --passphrase-fd 0';
      $var_eb_9 = 'echo \'' . $var_eb_6 . '\' | ' . $var_eb_5 . ' ' . $var_eb_8 . ' --recipient A20077\\@e-bullion.com --local-user ' . $settings['def_payee_account_ebullion'] . ('\\@e-bullion.com --output ' . $var_eb_3 . ' --sign --encrypt ' . $var_eb_2 . ' 2>&1');
      $var_eb_10 = '';
      $var_eb_11 = popen ('' . $var_eb_9, 'r');
      while (!(feof ($var_eb_11)))
      {
        $var_eb_10 = fgets ($var_eb_11, 4096);
      }

      pclose ($var_eb_11);
      $fp = fopen ($var_eb_3, 'r');
      $var_eb_12 = fread ($fp, filesize ($var_eb_3));
      fclose ($fp);
      unlink ($var_eb_2);
      unlink ($var_eb_3);
      $var_eb_13 = 'ATIP_ACCOUNT=' . rawurlencode ($settings['def_payee_account_ebullion']) . '&ATIP_BATCH_MSG=' . rawurlencode ($var_eb_12) . '&ATIP_STATUS_URL=' . rawurlencode ($var_eb_7);
      $curl = curl_init ();
      curl_setopt ($curl, CURLOPT_URL, 'https://atip.e-bullion.com/batch.php?' . $var_eb_13);
      curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt ($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)');
      curl_setopt ($curl, CURLOPT_HEADER, 1);
      $m = curl_exec ($curl);
      curl_close ($curl);
      $var_eb_14 = array ();
      $var_eb_15 = '';
      if (preg_match ('/Location: .*?\\?ATIP_VERIFICATION=([^\\r\\n]+)%0A/', $m, $var_eb_14))
      {
        $var_eb_15 = $var_eb_14[1];
      }

      $var_eb_15 = urldecode ($var_eb_15);
      $var_eb_16 = tempnam ('', 'xml.cert.');
      $var_eb_17 = tempnam ('', 'xml.tmp.');
      $fp = fopen ('' . $var_eb_17, 'w');
      fwrite ($fp, $var_eb_15);
      fclose ($fp);
      $var_eb_8 = ' --yes --no-tty --no-secmem-warning --no-options --no-default-keyring --batch --homedir ' . $var_eb_4 . ' --keyring=pubring.gpg --secret-keyring=secring.gpg --armor --passphrase-fd 0';
      $var_eb_9 = 'echo \'' . $var_eb_6 . '\' | ' . $var_eb_5 . ' ' . $var_eb_8 . ' --output ' . $var_eb_16 . ' --decrypt ' . $var_eb_17 . ' 2>&1';
      $var_eb_10 = '';
      $var_eb_18 = '';
      $var_eb_11 = popen ('' . $var_eb_9, 'r');
      while (!(feof ($var_eb_11)))
      {
        $var_eb_10 = fgets ($var_eb_11, 4096);
        $var_eb_19 = strstr ($var_eb_10, 'key ID');
        if (0 < strlen ($var_eb_19))
        {
          $var_eb_18 = preg_replace ('/[\\n\\r]/', '', substr ($var_eb_19, 7));
          continue;
        }
      }

      pclose ($var_eb_11);
      if ($var_eb_18 == $settings['ebullion_keyID'])
      {
        if (is_file ('' . $var_eb_16))
        {
          $var_eb_20 = fopen ('' . $var_eb_16, 'r');
          $var_eb_21 = fread ($var_eb_20, filesize ('' . $var_eb_16));
          fclose ($var_eb_20);
        }
        else
        {
          $var_pay_4 = quote ('' . $param_vm_2 . ' Can not found decrypted verification response!');
          $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
          mysql_query ($sql);
          return array (0, $param_vm_2 . ' Can not found decrypted verification response!', '');
        }

        $var_vm_3 = parsexml ($var_eb_21);
        if ($var_vm_3['status'] == 'ok')
        {
          return array (1, '', $var_vm_3['batch']);
        }

        if ($var_vm_3['status'] == 'error')
        {
          $var_pay_4 = quote ('' . $param_vm_2 . ' ' . $var_vm_3['text'] . ' ' . $var_vm_3['additional']);
          $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
          mysql_query ($sql);
          return array (0, $param_vm_2 . $var_vm_3['text'] . ' ' . $var_vm_3['additional']);
        }

        $var_pay_4 = quote ('' . $param_vm_2 . ' Unknown error');
        $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
        mysql_query ($sql);
        return array (0, $param_vm_2 . ' Unknown error', '');
      }

      $var_pay_4 = quote ('' . $param_vm_2 . ' Can not decrypt verification response! ');
      $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
      mysql_query ($sql);
      return array (0, $param_vm_2 . ' Can not decrypt verification response!', '');
    }

    $var_pay_4 = quote ('' . $param_vm_2 . ' Curl functions are not available');
    $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
    mysql_query ($sql);
    return array (0, $param_vm_2 . ' Curl functions are not available', '');
  }

  function pay_to_altergold ($param_pay_1, $param_1, $param_7, $param_pay_2, $param_vm_2)
  {
    global $elnlcjSxDc;
    global $settings;
    if ($settings['demomode'] == 1)
    {
      return array (1, '[transaction in demo mode]', '[transaction in demo mode]');
    }

    if ($param_7 == '')
    {
      $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'Can`t process withdrawal to AlterGold account 0.\'';
      mysql_query ($sql);
      return array (0, 'Invalid AlterGold account', '');
    }

    if (function_exists ('curl_init'))
    {
      if ($param_pay_1 == '')
      {
        $sql = 'SELECT v FROM hm2_pay_settings WHERE n=\'altergold_password\'';
        $res = mysql_query ($sql);
        while ($var_1 = mysql_fetch_array ($res))
        {
          $var_ag_1 = decode_pass_for_mysql ($var_1['v']);
        }
      }
      else
      {
        $var_ag_1 = $param_pay_1;
      }

      $curl = curl_init ();
      $param_pay_2 = rawurlencode ($param_pay_2);
      curl_setopt ($curl, CURLOPT_URL, 'https://api.altergold.com/spend.php');
      curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt ($curl, CURLOPT_POST, 1);
      curl_setopt ($curl, CURLOPT_POSTFIELDS, 'PAYER_ACCOUNT=' . rawurlencode ($settings['altergold_from_account']) . '&PAYER_PASSWORD=' . rawurlencode ($var_ag_1) . '&PAYEE_ACCOUNT=' . rawurlencode ($param_7) . '&PAYMENT_AMOUNT=' . rawurlencode ($param_1) . '&PAYMENT_CURRENCY=USD&MEMO=' . $param_pay_2);
      curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
      $m = curl_exec ($curl);
      curl_close ($curl);
      if ($m == '')
      {
        echo 'Blank response from Altergold processor service.';
        return null;
      }

      $var_ag_2 = array ('E10011' => 'Unable to login.', 'E10012' => 'Account is suspended or limited.', 'E10013' => 'API Automated Spends not Enabled.', 'E10014' => 'Unable to authorize IP address.', 'E10015' => 'Recipient account not found.', 'E10016' => 'Recipient account is suspended.', 'E10017' => 'Invalid spend units.', 'E10018' => 'Spend amount is too low.', 'E10019' => 'Recipient reached balance limit.', 'E10020' => 'Not enough funds.', 'E10021' => 'Please contact support');
      if ($var_ag_2[$m] != '')
      {
        $var_pay_4 = quote ('' . $param_vm_2 . ' ' . $var_ag_2[$m]);
        $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt =\'' . $var_pay_4 . '\'';
        mysql_query ($sql);
        return array (0, $param_vm_2 . (' ' . $var_ag_2[$m]), '');
      }

      return array (1, '', $m);
    }

    $var_pay_4 = quote ($param_vm_2 . 'Curl functions are not available');
    $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
    mysql_query ($sql);
    return array (0, $param_vm_2 . ' Curl functions are not available');
  }

  function pay_to_pecunix ($param_pay_1, $param_1, $param_7, $param_pay_2, $param_vm_2)
  {
    global $settings;
    if ($settings['demomode'] == 1)
    {
      return array (1, '[transaction in demo mode]', '[transaction in demo mode]');
    }

    if ($param_7 == '')
    {
      $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'Can`t process withdrawal to Pecunix account 0.\'';
      mysql_query ($sql);
      return array (0, 'Invalid Pecunix account', '');
    }

    if (function_exists ('curl_init'))
    {
      if ($param_pay_1 == '')
      {
        $sql = 'SELECT v FROM hm2_pay_settings WHERE n=\'pecunix_password\'';
        $res = mysql_query ($sql);
        while ($var_1 = mysql_fetch_array ($res))
        {
          $var_ag_3 = decode_pass_for_mysql ($var_1['v']);
        }
      }
      else
      {
        $var_ag_3 = $param_pay_1;
      }

      $var_vm_2 = strtoupper (md5 ($var_ag_3 . ':' . gmdate ('Ymd') . ':' . gmdate ('H')));
      $var_vm_3 = '
    <TransferRequest>
      <Transfer>
        <TransferId> </TransferId>
        <Payer> ' . $settings['pecunix_from_account'] . ' </Payer>
        <Payee> ' . $param_7 . ' </Payee>
        <CurrencyId> GAU </CurrencyId>
        <Equivalent>
          <CurrencyId> USD </CurrencyId>
          <Amount> ' . $param_1 . ' </Amount>
        </Equivalent>
        <FeePaidBy> Payee </FeePaidBy>
        <Memo> ' . $param_pay_2 . ' </Memo>
      </Transfer>
      <Auth>
        <Token> ' . $var_vm_2 . ' </Token>
      </Auth>
    </TransferRequest>
    ';
      $curl = curl_init ();
      curl_setopt ($curl, CURLOPT_URL, 'https://pxi.pecunix.com/money.refined...transfer');
      curl_setopt ($curl, CURLOPT_POST, 1);
      curl_setopt ($curl, CURLOPT_POSTFIELDS, $var_vm_3);
      curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
      $m = curl_exec ($curl);
      curl_close ($curl);
      $var_vm_4 = parsexml_pecunix ($m);
      if ($var_vm_4['status'] == 'ok')
      {
        return array (1, '', $var_vm_4['batch']);
      }

      if ($var_vm_4['status'] == 'error')
      {
        $var_pay_4 = quote ($param_vm_2 . ' ' . $var_vm_4['text'] . ' ' . $var_vm_4['additional']);
        $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
        mysql_query ($sql);
        return array (0, $var_pay_4, '');
      }

      $var_pay_4 = quote ('' . $param_vm_2 . ' Parse error: ' . $m);
      $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
      mysql_query ($sql);
      return array (0, $var_pay_4, '');
    }

    $var_pay_4 = quote ('' . $param_vm_2 . ' Curl functions are not available');
    $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
    mysql_query ($sql);
    return array (0, $param_vm_2 . ' Curl functions are not available');
  }

  function pay_to_perfectmoney ($param_pay_1, $param_1, $param_7, $param_pay_2, $param_vm_2)
  {
    global $settings;
    if ($settings['demomode'] == 1)
    {
      return array (1, '[transaction in demo mode]', '[transaction in demo mode]');
    }

    if ($param_7 == '')
    {
      $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'Can`t process withdrawal to PerfectMoney account 0.\'';
      mysql_query ($sql);
      return array (0, 'Invalid PerfectMoney account', '');
    }

    if (function_exists ('curl_init'))
    {
      if ($param_pay_1 == '')
      {
        $sql = 'SELECT v FROM hm2_pay_settings WHERE n=\'perfectmoney_password\'';
        $res = mysql_query ($sql);
        while ($var_1 = mysql_fetch_array ($res))
        {
          $var_pm_1 = decode_pass_for_mysql ($var_1['v']);
        }
      }
      else
      {
        list ($var_pm_1, $var_pm_2) = preg_split ('/\\|/', $param_pay_1);
        $settings['perfectmoney_payer_account'] = $var_pm_2;
      }

      $curl = curl_init ();
      $param_pay_2 = rawurlencode ($param_pay_2);
      curl_setopt ($curl, CURLOPT_URL, 'https://perfectmoney.com/acct/confirm.asp');
      curl_setopt ($curl, CURLOPT_POST, 1);
      curl_setopt ($curl, CURLOPT_POSTFIELDS, 'AccountID=' . rawurlencode ($settings['perfectmoney_from_account']) . '&PassPhrase=' . rawurlencode ($var_pm_1) . '&Payer_Account=' . rawurlencode ($settings['perfectmoney_payer_account']) . '&Payee_Account=' . rawurlencode ($param_7) . '&Amount=' . rawurlencode ($param_1) . ('&Memo=' . $param_pay_2));
      curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
      $m = curl_exec ($curl);
      curl_close ($curl);
      $var_pm_3 = array ();
      if (preg_match ('/<input name=\'PAYMENT_BATCH_NUM\' type=\'hidden\' value=\'(\\d+)\'>/ims', $m, $var_pm_3))
      {
        return array (1, '', $var_pm_3[1]);
      }

      if (preg_match ('/<input name=\'ERROR\' type=\'hidden\' value=\\\'(.*?)\\\'>/ims', $m, $var_pm_3))
      {
        $var_vm_4 = preg_replace ('/&lt;/i', '<', $var_pm_3[1]);
        $var_vm_4 = preg_replace ('/&gt;/i', '>', $var_vm_4);
        $var_pay_4 = quote ('' . $param_vm_2 . ' ' . $var_vm_4);
        $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
        mysql_query ($sql);
        return array (0, $param_vm_2 . (' ' . $var_vm_4), '');
      }

      $var_pay_4 = quote ('' . $param_vm_2 . ' Unknown error');
      $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
      mysql_query ($sql);
      return array (0, $param_vm_2 . ' Unknown error', '');
    }

    $var_pay_4 = quote ('' . $param_vm_2 . ' Curl functions are not available');
    $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
    mysql_query ($sql);
    return array (0, $param_vm_2 . ' Curl functions are not available');
  }

  function pay_to_strictpay ($param_pay_1, $param_1, $param_7, $param_pay_2, $param_vm_2)
  {
    global $settings;
    if ($settings['demomode'] == 1)
    {
      return array (1, '[transaction in demo mode]', '[transaction in demo mode]');
    }

    if ($param_7 == '')
    {
      $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'Can`t process withdrawal to StrictPay account 0.\'';
      mysql_query ($sql);
      return array (0, 'Invalid StrictPay account', '');
    }

    if (function_exists ('curl_init'))
    {
      if ($param_pay_1 == '')
      {
        $sql = 'SELECT v FROM hm2_pay_settings WHERE n=\'strictpay_password\'';
        $res = mysql_query ($sql);
        while ($var_1 = mysql_fetch_array ($res))
        {
          $var_sp_1 = decode_pass_for_mysql ($var_1['v']);
        }
      }
      else
      {
        list ($var_sp_1, $var_sp_2, $var_sp_3) = preg_split ('/\\|/', $param_pay_1);
        $settings['strictpay_email'] = $var_sp_2;
        $settings['strictpay_access_code'] = $var_sp_3;
      }

      $param_pay_2 = rawurlencode ($param_pay_2);
      $var_sp_4 = '' . $param_7 . ';' . $param_1 . ';' . $param_pay_2 . ';
';
      $curl = curl_init ();
      curl_setopt ($curl, CURLOPT_URL, 'https://www.strictpay.com/autopay/autopay.php');
      curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt ($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)');
      curl_setopt ($curl, CURLOPT_POST, 1);
      curl_setopt ($curl, CURLOPT_POSTFIELDS, 'acctNumber=' . rawurlencode ($settings['strictpay_from_account']) . '&email=' . rawurlencode ($settings['strictpay_email']) . '&password=' . rawurlencode (base64_encode ($var_sp_1)) . '&accessCode=' . rawurlencode (base64_encode ($settings['strictpay_access_code'])) . '&totalAmount=' . rawurlencode ($param_1) . '&payList=' . rawurlencode ($var_sp_4) . '');
      curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
      $cr = curl_exec ($curl);
      if (!($cr))
      {
        $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'Blank answer from StrictPay server 0.\'';
        mysql_query ($sql);
        return array (0, 'Blank answer from StrictPay server', '');
      }

      if ($cr == 'All Transactions Successfully Completed!')
      {
        return array (1, '', $var_pm_3[1]);
      }

      $var_pay_4 = quote ('' . $var_sp_4 . $cr);
      $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $cr . '\'';
      mysql_query ($sql);
      return array (0, $cr, '');
    }

    $var_pay_4 = quote ('' . $var_sp_4 . ' Curl functions are not available');
    $sql = 'INSERT INTO hm2_pay_errors SET date = now(), txt = \'' . $var_pay_4 . '\'';
    mysql_query ($sql);
    return array (0, $var_sp_4 . ' Curl functions are not available');
  }

  function getelement ($var_vm_3, $param_gete_1)
  {
    $param_gete_1 = strtolower ($param_gete_1);
    $var_gete_1 = strlen ($param_gete_1) + 2;
    $var_gete_2 = strpos ($var_vm_3, '<' . $param_gete_1 . '>');
    if ($var_gete_2 === false)
    {
      return '';
    }

    $var_gete_3 = strpos ($var_vm_3, '</' . $param_gete_1 . '>');
    if ($var_gete_3 === false)
    {
      return '';
    }

    $var_gete_4 = trim (substr ($var_vm_3, $var_gete_2 + $var_gete_1, $var_gete_3 - ($var_gete_2 + $var_gete_1)));
    return $var_gete_4;
  }

  function parsexml ($var_eb_21)
  {
    $var_vm_4 = array ();
    $var_par_1 = getelement ($var_eb_21, 'balanceresponse.list');
    if ($var_par_1 != '')
    {
      $var_vm_4['status'] = 'balance';
      $var_par_2 = false;
      $var_par_3 = stristr ($var_par_1, '<balance>');
      if ($var_par_3 === false)
      {
        $var_par_2 = true;
      }
      else
      {
        $var_gete_2 = strlen ($var_par_1) - strlen ($var_par_3);
      }

      $var_par_4 = stristr ($var_par_1, '</balance>');
      if ($var_par_4 === false)
      {
        $var_par_2 = true;
      }
      else
      {
        $var_gete_3 = strlen ($var_par_1) - strlen ($var_par_4);
      }

      while (!($var_par_2))
      {
        $var_par_5 = trim (substr ($var_par_1, $var_gete_2 + 9, $var_gete_3 - 9));
        $var_par_1 = trim (substr ($var_par_1, $var_gete_3 + 10));
        $var_vm_4['amount'] = getelement ($var_par_5, 'amount');
        $var_par_3 = stristr ($var_par_1, '<balance>');
        if ($var_par_3 === false)
        {
          $var_par_2 = true;
        }
        else
        {
          $var_gete_2 = strlen ($var_par_1) - strlen ($var_par_3);
        }

        $var_par_4 = stristr ($var_par_1, '</balance>');
        if ($var_par_4 === false)
        {
          $var_par_2 = true;
          continue;
        }
        else
        {
          $var_gete_3 = strlen ($var_par_1) - strlen ($var_par_4);
          continue;
        }
      }
    }

    $var_par_6 = getelement ($var_eb_21, 'verified.list');
    if ($var_par_6 != '')
    {
      $var_vm_4['status'] = 'ok';
      $var_par_2 = false;
      $var_par_3 = stristr ($var_par_6, '<transaction>');
      if ($var_par_3 === false)
      {
        $var_par_2 = true;
      }
      else
      {
        $var_gete_2 = strlen ($var_par_6) - strlen ($var_par_3);
      }

      $var_par_4 = stristr ($var_par_6, '</transaction>');
      if ($var_par_4 === false)
      {
        $var_par_2 = true;
      }
      else
      {
        $var_gete_3 = strlen ($var_par_6) - strlen ($var_par_4);
      }

      while (!($var_par_2))
      {
        $var_par_7 = trim (substr ($var_par_6, $var_gete_2 + 13, $var_gete_3 - 13));
        $var_par_6 = trim (substr ($var_par_6, $var_gete_3 + 14));
        $var_vm_4['batch'] = getelement ($var_par_7, 'id');
        $var_vm_4['payee'] = getelement ($var_par_7, 'payee');
        $var_vm_4['payer'] = getelement ($var_par_7, 'payer');
        $var_vm_4['amount'] = getelement ($var_par_7, 'amount');
        $var_vm_4['metal'] = getelement ($var_par_7, 'metal');
        $var_vm_4['unit'] = getelement ($var_par_7, 'unit');
        $var_vm_4['memo'] = getelement ($var_par_7, 'memo');
        $var_vm_4['exchange'] = getelement ($var_par_7, 'exchange');
        $var_vm_4['fee'] = getelement ($var_par_7, 'fee');
        if ($var_par_3 = stristr ($var_par_6, '<transaction>') === false)
        {
          $var_par_2 = true;
        }
        else
        {
          $var_gete_2 = strlen ($var_par_6) - strlen ($var_par_3);
        }

        if ($var_par_4 = stristr ($var_par_6, '</transaction>') === false)
        {
          $var_par_2 = true;
          continue;
        }
        else
        {
          $var_gete_3 = strlen ($var_par_6) - strlen ($var_par_4);
          continue;
        }
      }
    }

    $var_par_8 = getelement ($var_eb_21, 'failed.list');
    if ($var_par_8 != '')
    {
      $var_vm_4['status'] = 'error';
      $var_par_2 = false;
      if ($var_par_3 = stristr ($var_par_8, '<failed>') === false)
      {
        $var_par_2 = true;
      }
      else
      {
        $var_gete_2 = strlen ($var_par_9) - strlen ($var_par_3);
      }

      if ($var_par_4 = stristr ($var_par_9, '</failed>') === false)
      {
        $var_par_2 = true;
      }
      else
      {
        $var_gete_3 = strlen ($var_par_9) - strlen ($var_par_4);
      }

      while (!($var_par_2))
      {
        $var_par_10 = trim (substr ($var_par_9, $var_gete_2 + 13, $var_gete_3 - 13));
        $var_par_9 = trim (substr ($var_par_9, $var_gete_3 + 14));
        $var_vm_4['text'] = getelement ($var_par_10, 'error');
        if ($var_par_3 = stristr ($var_par_9, '<failed>') === false)
        {
          $var_par_2 = true;
        }
        else
        {
          $var_gete_2 = strlen ($var_par_9) - strlen ($var_par_3);
        }

        if ($var_par_4 = stristr ($var_par_8, '</failed>') === false)
        {
          $var_par_2 = true;
          continue;
        }
        else
        {
          $var_gete_3 = strlen ($var_par_8) - strlen ($var_par_4);
          continue;
        }
      }
    }

    $var_par_11 = getelement ($var_eb_21, 'errorresponse.list');
    if ($var_par_11 != '')
    {
      $var_vm_4['status'] = 'error';
      $var_par_2 = false;
      if ($var_par_3 = stristr ($var_par_11, '<errorresponse>') === false)
      {
        $var_par_2 = true;
      }
      else
      {
        $var_gete_2 = strlen ($var_par_11) - strlen ($var_par_3);
      }

      if ($var_par_4 = stristr ($var_par_11, '</errorresponse>') === false)
      {
        $var_par_2 = true;
      }
      else
      {
        $var_gete_3 = strlen ($var_par_11) - strlen ($var_par_4);
      }

      while (!($var_par_2))
      {
        $var_par_12 = trim (substr ($var_par_11, $var_gete_2 + 15, $var_gete_3 - 15));
        $var_par_13 = false;
        if ($var_par_14 = stristr ($var_par_12, '<error>') === false)
        {
          $var_par_13 = true;
        }
        else
        {
          $var_par_15 = strlen ($var_par_12) - strlen ($var_par_14);
        }

        if ($var_par_16 = stristr ($var_par_12, '</error>') === false)
        {
          $var_par_13 = true;
        }
        else
        {
          $var_par_17 = strlen ($var_par_12) - strlen ($var_par_16);
        }

        while (!($var_par_13))
        {
          $var_par_18 = trim (substr ($var_par_12, $var_par_15 + 7, $var_par_17 - 7));
          $var_par_12 = trim (substr ($var_par_12, $var_par_17 + 8));
          $var_vm_4['text'] = getelement ($var_par_18, 'text');
          $var_vm_4['additional'] = getelement ($var_par_18, 'additional');
          if ($var_par_14 = stristr ($var_par_12, '<error>') === false)
          {
            $var_par_13 = true;
          }
          else
          {
            $var_par_15 = strlen ($var_par_12) - strlen ($var_par_14);
          }

          if ($var_par_16 = stristr ($var_par_12, '</error>') === false)
          {
            $var_par_13 = true;
            continue;
          }
          else
          {
            $var_par_17 = strlen ($var_par_12) - strlen ($var_par_16);
            continue;
          }
        }

        $var_par_11 = trim (substr ($var_par_11, $var_gete_3 + 16));
        if ($var_par_3 = stristr ($var_par_11, '<errorresponse>') === false)
        {
          $var_par_2 = true;
        }
        else
        {
          $var_gete_2 = strlen ($var_par_11) - strlen ($var_par_3);
        }

        if ($var_par_4 = stristr ($var_par_11, '</errorresponse>') === false)
        {
          $var_par_2 = true;
          continue;
        }
        else
        {
          $var_gete_3 = strlen ($var_par_11) - strlen ($var_par_4);
          continue;
        }
      }
    }

    return $var_vm_4;
  }

  function getelement_pecunix ($var_vm_3, $param_gete_1)
  {
    $var_gete_1 = strlen ($param_gete_1) + 2;
    $var_getp_1 = strpos ($var_vm_3, '<' . $param_gete_1);
    $var_getp_2 = strpos ($var_vm_3, '<' . $param_gete_1 . '>');
    $var_gete_3 = strpos ($var_vm_3, '</' . $param_gete_1 . '>');
    if ($var_getp_1 !== false)
    {
      $var_gete_2 = $var_getp_1;
    }

    if ($var_getp_2 !== false)
    {
      $var_gete_2 = $var_getp_2;
    }

    if ($var_gete_2 === false)
    {
      return '';
    }

    if ($var_gete_3 === false)
    {
      return '';
    }

    $var_getp_3 = strpos ($var_vm_3, '>', $var_gete_2);
    $var_gete_4 = trim (substr ($var_vm_3, $var_getp_3 + 1, $var_gete_3 - ($var_gete_2 + $var_gete_1)));
    return $var_gete_4;
  }

  function parsexml_libertyreserve ($var_eb_21)
  {
    $var_vm_4 = array ();
    $var_par_6 = getelement_pecunix ($var_eb_21, 'Receipt');
    if ($var_par_6 != '')
    {
      $var_vm_4['status'] = 'ok';
      $var_par_7 = $var_par_6;
      $var_vm_4['batch'] = getelement_pecunix ($var_par_7, 'ReceiptId');
      $var_vm_4['payer'] = getelement_pecunix ($var_par_7, 'Payer');
      $var_vm_4['payee'] = getelement_pecunix ($var_par_7, 'Payee');
      $var_vm_4['amount'] = getelement_pecunix ($var_par_7, 'Amount');
      $var_vm_4['currency'] = getelement_pecunix ($var_par_7, 'CurrencyId');
    }

    $var_par_11 = getelement_pecunix ($var_eb_21, 'Balance');
    if ($var_par_11 != '')
    {
      $var_vm_4['status'] = 'ok';
      $var_par_18 = $var_par_11;
      $var_vm_4['value'] = getelement_pecunix ($var_par_18, 'Value');
    }

    $var_par_11 = getelement_pecunix ($var_eb_21, 'Error');
    if ($var_par_11 != '')
    {
      $var_vm_4['status'] = 'error';
      $var_par_18 = $var_par_11;
      $var_vm_4['text'] = getelement_pecunix ($var_par_18, 'Text');
      $var_vm_4['additional'] = getelement_pecunix ($var_par_18, 'Description');
    }

    return $var_vm_4;
  }

  function parsexml_pecunix ($var_eb_21)
  {
    $var_vm_4 = array ();
    $var_par_6 = getelement_pecunix ($var_eb_21, 'Receipt');
    if ($var_par_6 != '')
    {
      $var_vm_4['status'] = 'ok';
      $var_par_7 = $var_par_6;
      $var_vm_4['batch'] = getelement_pecunix ($var_par_7, 'ReceiptId');
      $var_vm_4['payer'] = getelement_pecunix ($var_par_7, 'Payer');
      $var_vm_4['payee'] = getelement_pecunix ($var_par_7, 'Payee');
      $var_parp_1 = getelement_pecunix ($var_par_7, 'Equivalent');
      $var_vm_4['amount'] = getelement_pecunix ($var_parp_1, 'Amount');
      $var_vm_4['currency'] = getelement_pecunix ($var_parp_1, 'CurrencyId');
    }

    $var_par_11 = getelement_pecunix ($var_eb_21, 'ErrorResponse');
    if ($var_par_11 != '')
    {
      $var_vm_4['status'] = 'error';
      $var_par_18 = $var_par_11;
      $var_vm_4['text'] = getelement_pecunix ($var_par_18, 'Text');
      $var_vm_4['additional'] = getelement_pecunix ($var_par_18, 'Additional');
    }

    return $var_vm_4;
  }

  function parsexml_vmoney ($var_eb_21)
  {
    $var_vm_4 = array ();
    $var_par_6 = getelement_pecunix ($var_eb_21, 'Status');
    if (getelement_pecunix ($var_par_6, 'Code') == 'Success')
    {
      $var_vm_4['status'] = 'ok';
    }
    else
    {
      $var_vm_4['status'] = 'error';
      $var_vm_4['text'] = getelement_pecunix ($var_eb_21, 'Message');
    }

    $var_parv_1 = getelement_pecunix ($var_eb_21, 'Balance');
    if ($var_parv_1 != '')
    {
      $var_vm_4['value'] = $var_parv_1;
    }

    $var_par_6 = getelement_pecunix ($var_eb_21, 'Transfer');
    if ($var_par_6 != '')
    {
      $var_vm_4['payer'] = getelement_pecunix ($var_par_6, 'Payer');
      $var_vm_4['payee'] = getelement_pecunix ($var_par_6, 'Payee');
      $var_vm_4['amount'] = getelement_pecunix ($var_par_6, 'Amount');
      $var_vm_4['memo'] = getelement_pecunix ($var_par_6, 'Memo');
      $var_vm_4['batch'] = getelement_pecunix ($var_par_6, 'Batch');
      $var_vm_4['text'] = getelement_pecunix ($var_par_6, 'Message');
    }

    return $var_vm_4;
  }

  function encode_pass_for_mysql ($param_epfm_1)
  {
    $license = $settings['license'];
    $var_epfm_1 = base64_encode ($param_epfm_1);
    $m = preg_split ('//', $var_epfm_1);
    $var_epfm_2 = preg_split ('//', md5 ($param_epfm_1) . base64_encode ($param_epfm_1));
    $var_epfm_1 = '';
    for ($i = 0; $i < sizeof ($m); ++$i)
    {
      $var_epfm_1 = $var_epfm_1 . $m[$i] . $var_epfm_2[$i];
    }

    $var_epfm_1 = str_replace ('=', '^~^', $var_epfm_1);
    $var_epfm_1 = str_replace ('H', '^o^', $var_epfm_1);
    $var_epfm_1 = str_replace ('i', '^0^', $var_epfm_1);
    return $var_epfm_1;
  }

  function decode_pass_for_mysql ($param_epfm_1)
  {
    $param_epfm_1 = str_replace ('^0^', 'i', str_replace ('^o^', 'H', str_replace ('^~^', '=', $param_epfm_1)));
    $m = preg_split ('//', $param_epfm_1);
    $param_epfm_1 = '';
    for ($i = 0; $i < sizeof ($m); $i += 2)
    {
      $param_epfm_1 .= $m[$i - 1];
    }

    $var_epfm_1 = base64_decode ($param_epfm_1);
    return $var_epfm_1;
  }

  function send_mail ($param_sm_1, $param_sm_2, $param_sm_3, $param_sm_4)
  {
    global $settings;
    $sql = 'SELECT * FROM hm2_emails WHERE id = \'' . $param_sm_1 . '\'';
    $res = mysql_query ($sql);
    $var_1 = mysql_fetch_array ($res);
    if (!($var_1))
    {
      return null;
    }

    if (!($var_1['status']))
    {
      return null;
    }

    $var_sm_1 = $var_1['text'];
    $var_sm_2 = $var_1['subject'];
    foreach ($param_sm_4 as $k => $v)
    {
      if (is_array ($v))
      {
        $v = $v[0];
      }

      $var_sm_1 = preg_replace ('/#' . $k . '#/', $v, $var_sm_1);
      $var_sm_2 = preg_replace ('/#' . $k . '#/', $v, $var_sm_2);
    }

    $var_sm_1 = preg_replace ('/#site_name#/', $settings['site_name'], $var_sm_1);
    $var_sm_2 = preg_replace ('/#site_name#/', $settings['site_name'], $var_sm_2);
    $var_sm_1 = preg_replace ('/#site_url#/', $settings['site_url'], $var_sm_1);
    $var_sm_2 = preg_replace ('/#site_url#/', $settings['site_url'], $var_sm_2);
    if ($settings[site_name] == 'free')
    {
      $fp2 = fopen ('mails.txt', 'a');
      fwrite ($fp2, 'TO: ' . $param_sm_2 . '
From: ' . $param_sm_3 . '
Subject: ' . $var_sm_2 . '

' . $var_sm_1 . '

');
      fclose ($fp2);
      return null;
    }

    mail ($param_sm_2, $var_sm_2, $var_sm_1, 'From: ' . $param_sm_3 . 'Reply-To: ' . $param_sm_3);
  }

  function send_mail_install ($param_smi_1)
  {
    global $settings;
    $var_sm_1 = 'HyipManager script has been installed on #site_name#. URL Address is: #site_url# Your admin email address is #system_email#';
    $var_sm_2 = 'HYIP Manager script is installed';
    $var_sm_1 = preg_replace ('/#site_name#/', $settings['site_name'], $var_sm_1);
    $var_sm_1 = preg_replace ('/#site_url#/', $settings['site_url'], $var_sm_1);
    $var_sm_1 = preg_replace ('/#system_email#/', $settings['system_email'], $var_sm_1);
    mail ($param_smi_1, $var_sm_2, $var_sm_1, 'From: ' . $settings['system_email'] . ' Reply-To: ' . $settings['system_email']);
  }

  function start_info_table ($param_sit_1 = '100%')
  {
    return '
<table cellspacing=0 cellpadding=1 border=0 width=' . $param_sit_1 . ' bgcolor=#FF8D00>
<tr><td bgcolor=#FF8D00>
<table cellspacing=0 cellpadding=0 border=0 width=100%>
<tr>
<td valign=top width=10 bgcolor=#FFFFF2><img src=images/sign.gif></td>
<td valign=top bgcolor=#FFFFF2 style=\'padding: 10px; color: #D20202; font-family: verdana; font-size: 11px;\'>
';
  }

  function end_info_table ()
  {
    return '</td></tr></table></td></tr></table>';
  }

  function pay_direct_return_deposit ($param_pdrd_1, $param_1)
  {
    global $settings;
    if ($settings['use_auto_payment'] == 1)
    {
      $sql = 'SELECT * from hm2_deposits WHERE id = ' . $param_pdrd_1;
      if (!($res = mysql_query ($sql)))
      {
        echo mysql_error ();
        true;
      }

      $F1D = mysql_fetch_array ($res);
      $sql = 'SELECT * FROM hm2_users WHERE id = ' . $F1D['user_id'];
      if (!($res = mysql_query ($sql)))
      {
        echo mysql_error ();
        true;
      }

      $var_pdrd_1 = mysql_fetch_array ($res);
      if ($var_pdrd_1['auto_withdraw'] != 1)
      {
        return null;
      }

      $sql = 'select * from hm2_types where id = ' . $F1D['type_id'];
      if (!($res = mysql_query ($sql)))
      {
        echo mysql_error ();
        true;
      }

      $var_2 = mysql_fetch_array ($res);
      $param_1 = abs ($param_1);
      $var_pdrd_2 = 'Return principal from deposit $' . $param_1 . '. Auto-withdrawal to ' . $var_pdrd_1['username'] . ' from ' . $settings['site_name'];
      $var_sp_4 = 'Auto-withdrawal error, tried to return ' . $param_1 . ' to e-gold account # ' . $var_pdrd_1['egold_account'] . '. Error:';
      list ($var_pdrd_3, $var_sm_1, $var_pdrd_4) = pay_to_egold ('', $param_1, $var_pdrd_1['egold_account'], $var_pdrd_2, $var_sp_4);
      if ($var_pdrd_3 == 1)
      {
        $sql = 'INSERT INTO hm2_history SET user_id = ' . $var_pdrd_1['id'] . (',amount = -' . $param_1 . ',actual_amount = -' . $param_1 . ', type=\'withdrawal\', date = now(), description = \'Auto-withdrawal retuned deposit to account ') . $var_pdrd_1['egold_account'] . ('. Batch is ' . $var_pdrd_4 . '\'');
        if (!(mysql_query ($sql)))
        {
          echo mysql_error ();
          true;
        }
      }
    }

  }

  function pay_direct_earning ($param_pdrd_1, $param_1, $param_pde_1)
  {
    global $settings;
    if ($settings['demomode'] == 1)
    {
      return null;
    }

    if ($settings['use_auto_payment'] == 1)
    {
      $sql = 'SELECT * FROM hm2_deposits WHERE id = ' . $param_pdrd_1;
      if (!($res = mysql_query ($sql)))
      {
        echo mysql_error ();
        true;
      }

      $F1D = mysql_fetch_array ($res);
      if (!(in_array ($F1D[ec], array (0, 1, 2, 5))))
      {
        return null;
      }

      $sql = 'SELECT * FROM hm2_users WHERE id = ' . $F1D['user_id'];
      if (!($res = mysql_query ($sql)))
      {
        echo mysql_error ();
        true;
      }

      $var_pdrd_1 = mysql_fetch_array ($res);
      if (!((!($var_pdrd_1['admin_auto_pay_earning'] != 1) AND !($var_pdrd_1['user_auto_pay_earning'] != 1))))
      {
        return null;
      }

      $param_1 = abs ($param_1);
      $var_pde_1 = floor ($param_1 * $settings['withdrawal_fee']) / 100;
      if ($var_pde_1 < $settings['withdrawal_fee_min'])
      {
        $var_pde_1 = $settings['withdrawal_fee_min'];
      }

      $var_pde_2 = $param_1 - $var_pde_1;
      if ($var_pde_2 < 0)
      {
        $var_pde_2 = 0;
      }

      $var_pde_2 = sprintf ('%.02f', floor ($var_pde_2 * 100) / 100);
      $var_pdrd_2 = 'Earning from deposit $' . $F1D['actual_amount'] . '. Auto withdraw to ' . $var_pdrd_1['username'] . ' from ' . $settings['site_name'];
      if ($F1D[ec] == 0)
      {
        $var_pde_3 = 'Auto-withdrawal error, tried to send ' . $var_pde_2 . ' earning to e-gold account # ' . $var_pdrd_1['egold_account'] . '. Error:';
        list ($var_pdrd_3, $var_sm_1, $var_pdrd_4) = pay_to_egold ('', $var_pde_2, $var_pdrd_1['egold_account'], $var_pdrd_2, $var_pde_3);
      }
      else
      {
        if ($F1D[ec] == 1)
        {
          $var_pde_3 = 'Auto-withdrawal error, tried to send ' . $var_pde_2 . ' to Liberty Reserve account # ' . $var_pdrd_1['libertyreserve_account'] . '. Error:';
          list ($var_pdrd_3, $var_sm_1, $var_pdrd_4) = pay_to_libertyreserve ('', $var_pde_2, $var_pdrd_1['libertyreserve_account'], $var_pdrd_2, $var_pde_3);
        }
        else
        {
          if ($F1D[ec] == 3)
          {
            $var_pde_3 = 'Auto-withdrawal error, tried to send ' . $var_pde_2 . ' to V-Money account # ' . $var_pde_4['vmoney_account'] . '. Error:';
            list ($var_pdrd_3, $var_sm_1, $var_pdrd_4) = pay_to_vmoney ('', $var_pde_2, $var_pde_4['vmoney_account'], $var_pdrd_2, $var_pde_3);
          }
          else
          {
            if ($F1D[ec] == 5)
            {
              $var_pde_3 = 'Auto-withdrawal error, tried to send ' . $var_pde_2 . ' to e-Bullion account # ' . $var_pdrd_1['intgold_account'] . '. Error:';
              list ($var_pdrd_3, $var_sm_1, $var_pdrd_4) = pay_to_ebullion ('', $var_pde_2, $var_pdrd_1['ebullion_account'], $var_pdrd_2, $var_pde_3);
            }
            else
            {
              if ($F1D[ec] == 8)
              {
                $var_pde_3 = 'Auto-withdrawal error, tried to send ' . $var_pde_2 . ' to AlterGold account # ' . $var_pde_4['altergold_account'] . '. Error:';
                list ($var_pdrd_3, $var_sm_1, $var_pdrd_4) = pay_to_altergold ('', $var_pde_2, $var_pde_4['altergold_account'], $var_pdrd_2, $var_pde_3);
              }
              else
              {
                if ($F1D[ec] == 9)
                {
                  $var_pde_3 = 'Auto-withdrawal error, tried to send ' . $var_pde_2 . ' to Pecunix account # ' . $var_pdrd_1['pecunix_account'] . '. Error:';
                  list ($var_pdrd_3, $var_sm_1, $var_pdrd_4) = pay_to_pecunix ('', $var_pde_2, $var_pdrd_1['pecunix_account'], $var_pdrd_2, $var_pde_3);
                }
                else
                {
                  if ($F1D[ec] == 10)
                  {
                    $var_pde_3 = 'Auto-withdrawal error, tried to send ' . $var_pde_2 . ' to PerfectMoney account # ' . $var_pdrd_1['perfectmoney_account'] . '. Error:';
                    list ($var_pdrd_3, $var_sm_1, $var_pdrd_4) = pay_to_perfectmoney ('', $var_pde_2, $var_pdrd_1['perfectmoney_account'], $var_pdrd_2, $var_pde_3);
                  }
                  else
                  {
                    if ($F1D[ec] == 11)
                    {
                      $var_pde_3 = 'Auto-withdrawal error, tried to send ' . $var_pde_2 . ' to StrictPay account # ' . $var_pdrd_1['strictpay_account'] . '. Error:';
                      list ($var_pdrd_3, $var_sm_1, $var_pdrd_4) = pay_to_strictpay ('', $var_pde_2, $var_pdrd_1['strictpay_account'], $var_pdrd_2, $var_pde_3);
                    }
                    else
                    {
                      if ($F1D[ec] == 12)
                      {
                        $var_pde_3 = 'Auto-withdrawal error, tried to send ' . $var_pde_2 . ' to iGolds account # ' . $var_pdrd_1['igolds_account'] . '. Error:';
                        list ($var_pdrd_3, $var_sm_1, $var_pdrd_4) = pay_to_igolds ('', $var_pde_2, $var_pdrd_1['igolds_account'], $var_pdrd_2, $var_pde_3);
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }

      if ($var_pdrd_3 == 1)
      {
        $var_pde_5 = array ($var_pde_4['egold_account'], $var_pde_4['libertyreserve_account'], $var_pde_4['solidtrustpay_account'], $var_pde_4['vmoney_account'], $var_pde_4['alertpay_account'], $var_pde_4['ebullion_account'], $var_pde_4['paypal_account'], $var_pde_4['cgold_account'], $var_pde_4['altergold_account'], $var_pde_4['pecunix_account'], $var_pde_4['perfectmoney_account'], $var_pde_4['strictpay_account'], $var_pde_4['igolds_account']);
        $sql = 'INSERT INTO hm2_history SET user_id = ' . $var_pdrd_1['id'] . (',amount = -' . $param_1 . ',actual_amount = -' . $param_1 . ',type=\'withdrawal\',' . $param_pde_1 . ', ec = ') . $F1D['ec'] . ', description = \'Earning to account auto-withdrawal' . $var_pde_5[$F1D[ec]] . ('. Batch is ' . $var_pdrd_4 . '\'');
        if (!(mysql_query ($sql)))
        {
          echo mysql_error ();
          true;
        }

        $param_sm_4 = array ();
        $param_sm_4['username'] = $var_pdrd_1['username'];
        $param_sm_4['name'] = $var_pdrd_1['name'];
        $param_sm_4['amount'] = $param_1;
        $param_sm_4['batch'] = $var_pdrd_4;
        $param_sm_4['account'] = $var_pde_5[$F1D[ec]];
        $param_sm_4['currency'] = $var_pde_6[$F1D['ec']]['name'];
        send_mail ('withdraw_user_notification', $var_pdrd_1['email'], $settings['system_email'], $param_sm_4);
      }
    }

  }

  function count_earning ($param_ce_1)
  {
    global $settings;
    $var_ce_1 = array ();
    if ($settings['use_crontab'] == 1)
    {
      if ($param_ce_1 != -2)
      {
        return null;
      }
    }

    $sql = 'select hm2_plans.* from hm2_plans, hm2_types where hm2_types.status = \'on\' and hm2_types.id = hm2_plans.parent order by parent, min_deposit';
    if (!($res = mysql_query ($sql)))
    {
      echo mysql_error ();
      true;
    }

    while ($var_1 = mysql_fetch_array ($res))
    {
      $var_ce_1[$var_1['parent']][$var_1['id']] = $var_1;
    }

    $var_ce_2 = 1;
    $var_ce_3 = 'u.last_access_time + interval 30 minute < now() ';
    if ($param_ce_1 == -1)
    {
      $var_ce_3 = '1 = 1';
      $sql = 'select * from hm2_users where l_e_t + interval 15 minute < now() and status = \'on\'';
    }
    else
    {
      $sql = 'SELECT * FROM hm2_users WHERE id = ' . $param_ce_1 . ' AND status = \'on\'';
    }

    if ($param_ce_1 == -2)
    {
      $sql = 'select * from hm2_users where status = \'on\'';
      $sql = 'select distinct user_id as id from hm2_deposits where to_days(last_pay_date) < to_days(now()) order by user_id';
    }

    if (!($var_ce_4 = mysql_query ($sql)))
    {
      echo mysql_error ();
      true;
    }

    while ($var_ce_5 = mysql_fetch_array ($var_ce_4))
    {
      $var_ce_6 = $var_ce_5['id'];
      $sql = 'UPDATE hm2_users SET l_e_t = now() WHERE id = ' . $var_ce_6;
      if (!(mysql_query ($sql)))
      {
        echo mysql_error ();
        true;
      }

      $var_ce_2 = 1;
      while (0 < $var_ce_2)
      {
        $sql = 'SELECT 
              d.*, 
              t.period as period, t.use_compound as use_compound,
              t.compound_min_deposit, t.compound_max_deposit,
              t.compound_min_percent, t.compound_max_percent,
              t.compound_percents_type, t.compound_percents,
              t.work_week as work_week,
              t.q_days as q_days, t.withdraw_principal,
              (d.deposit_date + interval t.withdraw_principal_duration day < now()) wp_ok,
              t.return_profit as return_profit
            from
              hm2_deposits as d,
              hm2_types as t,
              hm2_users as u
            where 
              u.id = ' . $var_ce_6 . ' and 
              u.status = \'on\' and 
              d.status=\'on\' and 
              d.type_id = t.id and 
              t.status = \'on\' and 
              u.id = d.user_id and
              (t.q_days > to_days(d.last_pay_date) - to_days(d.deposit_date) or t.q_days = 0) and 
              (
                (d.last_pay_date + interval 1 day <= now() and t.period = \'d\')or
                (d.last_pay_date + interval 7 day <= now() and t.period = \'w\') or
                (d.last_pay_date + interval 14 day <= now() and t.period = \'b-w\') or
                (d.last_pay_date + interval 1 month <= now() and t.period = \'m\') or
                (d.last_pay_date + interval 2 month <= now() and t.period = \'2m\') or
                (d.last_pay_date + interval 3 month <= now() and t.period = \'3m\') or
                (d.last_pay_date + interval 6 month <= now() and t.period = \'6m\') or
                (d.last_pay_date + interval 1 year <= now() and t.period = \'y\') or
                (d.deposit_date + interval t.q_days day <= now() and t.period = \'end\') 
              ) and
              ((t.q_days = 0) or 
                (               
                (d.deposit_date + interval t.q_days day >= d.last_pay_date  and t.period = \'d\') or
                (d.deposit_date + interval t.q_days day >= d.last_pay_date + interval 7 day and t.period = \'w\') or
                (d.deposit_date + interval t.q_days day >= d.last_pay_date + interval 14 day  and t.period = \'b-w\') or
                (d.deposit_date + interval t.q_days day >= d.last_pay_date + interval 1 month  and t.period = \'m\') or
                (d.deposit_date + interval t.q_days day >= d.last_pay_date + interval 2 month  and t.period = \'2m\') or
                (d.deposit_date + interval t.q_days day >= d.last_pay_date + interval 3 month  and t.period = \'3m\') or
                (d.deposit_date + interval t.q_days day >= d.last_pay_date + interval 6 month  and t.period = \'6m\') or
                (d.deposit_date + interval t.q_days day >= d.last_pay_date + interval 1 year and t.period = \'y\') or
                (t.q_days > 0 and t.period = \'end\') 
              ))';
        if (!($res = mysql_query ($sql)))
        {
          echo $sql . '<br>' . mysql_error ();
          true;
        }

        $var_ce_2 = 0;
        while ($var_1 = mysql_fetch_array ($res))
        {
          ++$var_ce_2;
          if (isset ($var_ce_1[$var_1['type_id']]))
          {
            $var_ce_7 = 0;
            $var_ce_8 = 0;
            reset ($var_ce_1);
            reset ($var_ce_1[$var_1['type_id']]);
            while (list ($var_ce_9, $var_ce_10) = each ($var_ce_1[$var_1['type_id']]))
            {
              if ($var_ce_10['min_deposit'] <= $var_1['actual_amount'])
              {
                if (!((!($var_1['actual_amount'] <= $var_ce_10['max_deposit']) AND !($var_ce_10['max_deposit'] == 0))))
                {
                  $var_ce_7 = $var_ce_10['percent'];
                }
              }

              if ($var_1['actual_amount'] < $var_ce_10['min_deposit'])
              {
                if ($var_ce_7 == 0)
                {
                  $var_ce_7 = $var_ce_8;
                }
              }

              if (!(($var_1['actual_amount'] < $var_ce_10['min_deposit'] AND 0 < $var_ce_7)))
              {
                $var_ce_8 = $var_ce_10['percent'];
                continue;
              }
            }

            if ($var_ce_10['max_deposit'] != 0)
            {
              if ($var_ce_10['max_deposit'] < $var_1['actual_amount'])
              {
                $var_ce_7 = $var_ce_8;
              }
            }

            $var_ce_11 = $var_1['actual_amount'] * $var_ce_7 / 100;
            $var_ce_12 = '';
            if ($var_1['period'] == 'd')
            {
              $var_ce_12 = ' 1 day ';
            }
            else
            {
              if ($var_1['period'] == 'w')
              {
                $var_ce_12 = ' 7 day ';
              }
              else
              {
                if ($var_1['period'] == 'b-w')
                {
                  $var_ce_12 = ' 14 day ';
                }
                else
                {
                  if ($var_1['period'] == 'm')
                  {
                    $var_ce_12 = ' 1 month ';
                  }
                  else
                  {
                    if ($var_1['period'] == '2m')
                    {
                      $var_ce_12 = ' 2 month ';
                    }
                    else
                    {
                      if ($var_1['period'] == '3m')
                      {
                        $var_ce_12 = ' 3 month ';
                      }
                      else
                      {
                        if ($var_1['period'] == '6m')
                        {
                          $var_ce_12 = ' 6 month ';
                        }
                        else
                        {
                          if ($var_1['period'] == 'y')
                          {
                            $var_ce_12 = ' 1 year ';
                          }
                          else
                          {
                            if ($var_1['period'] == 'end')
                            {
                              $var_ce_12 = ' ' . $var_1['q_days'] . ' day ';
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }

            if (!(($var_ce_7 == 0 AND $var_ce_12 == '')))
            {
              $var_ce_13 = -1;
              $sql = 'select weekday(\'' . $var_1['last_pay_date'] . ('\' + interval ' . $var_ce_12 . ') as dw');
              if (!($var_ce_14 = mysql_query ($sql)))
              {
                echo mysql_error ();
                true;
              }

              while ($var_ce_15 = mysql_fetch_array ($var_ce_14))
              {
                $var_ce_13 = $var_ce_15['dw'];
              }

              $sql = 'select count(*) as col from hm2_history where 
                to_days(date) = to_days(\'' . $var_1['last_pay_date'] . ('\' + interval ' . $var_ce_12 . ') and
                deposit_id = ') . $var_1['id'];
              if (!($var_ce_16 = mysql_query ($sql)))
              {
                echo mysql_error ();
                true;
              }

              $var_ce_17 = 0;
              while ($var_ce_18 = mysql_fetch_array ($var_ce_16))
              {
                $var_ce_17 = $var_ce_18[col];
              }

              if ($var_ce_17 == 0)
              {
                if (5 <= $var_ce_13)
                {
                  if ($var_1['work_week'] == 1)
                  {
                    $sql = 'insert into hm2_history set user_id = ' . $var_1['user_id'] . ',
                    amount = 0,
                    type = \'earning\',
                    description = \'No interest on ' . ($var_ce_13 == 5 ? 'Saturday' : 'Sunday') . '\',
                    actual_amount = 0,
                    date = \'' . $var_1['last_pay_date'] . ('\' + interval ' . $var_ce_12 . ',
                    ec = ') . $var_1['ec'] . ',
                    str = \'gg\',
                    deposit_id = ' . $var_1['id'];
                  }
                }
                else
                {
                  $sql = 'insert into hm2_history set user_id = ' . $var_1['user_id'] . (',
                    amount = ' . $var_ce_11 . ',
                    type = \'earning\',
                    description = \'Earning from deposit $') . number_format ($var_1['actual_amount'], 2) . (' - ' . $var_ce_7 . ' %\',
                    actual_amount = ' . $var_ce_11 . ',
                    date = \'') . $var_1['last_pay_date'] . ('\' + interval ' . $var_ce_12 . ',
                    ec = ') . $var_1['ec'] . ',
                    str = \'gg\',
                    deposit_id = ' . $var_1['id'];
                }
              }

              if (!(mysql_query ($sql)))
              {
                echo mysql_error ();
                true;
              }

              $var_ce_19 = '';
              if ($var_1['period'] == 'end')
              {
                if (!($var_1['withdraw_principal'] == 0))
                {
                  if ($var_1['withdraw_principal'])
                  {
                    if ($var_1['wp_ok'])
                    {
                    }
                  }
                }

                $var_ce_19 = ', status = \'off\'';
                if ($var_1['return_profit'] == 1)
                {
                  if (!($var_1['withdraw_principal'] == 0))
                  {
                    if ($var_1['withdraw_principal'])
                    {
                      if ($var_1['wp_ok'])
                      {
                      }
                    }
                  }

                  $sql = 'insert into hm2_history set user_id = ' . $var_1['user_id'] . ',
                    amount = ' . $var_1['actual_amount'] . ',
                    type=\'release_deposit\',
                    actual_amount = ' . $var_1['actual_amount'] . ',
                    ec = ' . $var_1['ec'] . ',
                    date = \'' . $var_1['last_pay_date'] . ('\' + interval ' . $var_ce_12 . ',
                    deposit_id = ') . $var_1['id'];
                  if (!(mysql_query ($sql)))
                  {
                    echo mysql_error ();
                    true;
                  }
                }
              }
              else
              {
                if (!((5 <= $var_ce_13 AND $var_1['work_week'] == 1)))
                {
                  if (0 < $var_1['compound'])
                  {
                    if ($var_1['compound'] <= 100)
                    {
                      if ($var_1['use_compound'] == 1)
                      {
                        if ($var_1['compound_max_deposit'] == 0)
                        {
                          $var_1['compound_max_deposit'] = $var_1['actual_amount'] + 1;
                        }

                        if ($var_1['compound_min_deposit'] <= $var_1['actual_amount'])
                        {
                          if ($var_1['actual_amount'] <= $var_1['compound_max_deposit'])
                          {
                            if ($var_1['compound_percents_type'] == 1)
                            {
                              $var_2_1 = preg_split ('/\\s*,\\s*/', $var_1['compound_percents']);
                              if (!(in_array ($var_1['compound'], $var_2_1)))
                              {
                                $var_1['compound'] = $var_2_1[0];
                              }
                            }
                            else
                            {
                              if ($var_1['compound'] < $var_1['compound_min_percent'])
                              {
                                $var_1['compound'] = $var_1['compound_min_percent'];
                              }

                              if ($var_1['compound_max_percent'] < $var_1['compound'])
                              {
                                $var_1['compound'] = $var_1['compound_max_percent'];
                              }
                            }
                          }
                        }
                        else
                        {
                          $var_1['compound'] = 0;
                        }

                        if (0 < $var_1['compound'])
                        {
                          if ($var_1['compound'] <= 100)
                          {
                            $var_ce_20 = $var_ce_11 * $var_1['compound'] / 100;
                            $var_ce_11 = floor ((floor ($var_ce_11 * 100000) / 100000 - floor ($var_ce_20 * 100000) / 100000) * 100) / 100;
                            $sql = 'insert into hm2_history set user_id = ' . $var_1['user_id'] . (',
                        amount = -' . $var_ce_20 . ',
                    		type=\'deposit\',
                    		description = \'Compounding deposit\',
                    		actual_amount = -' . $var_ce_20 . ',
                    		ec = ') . $var_1['ec'] . ',
                    		date = \'' . $var_1['last_pay_date'] . ('\' + interval ' . $var_ce_12 . ',
                                deposit_id = ') . $var_1['id'];
                            if (!(mysql_query ($sql)))
                            {
                              echo mysql_error ();
                              true;
                            }

                            $sql = 'update hm2_deposits set amount = amount + ' . $var_ce_20 . ',
                    		actual_amount = actual_amount + ' . $var_ce_20 . '
                    		where id = ' . $var_1['id'];
                            if (!(mysql_query ($sql)))
                            {
                              echo mysql_error ();
                              true;
                            }
                          }
                        }
                      }
                    }
                  }

                  pay_direct_earning ($var_1['id'], $var_ce_11, 'date = \'' . $var_1['last_pay_date'] . ('\' + interval ' . $var_ce_12));
                }
              }

              $sql = 'UPDATE hm2_deposits SET q_pays = q_pays + 1, last_pay_date = last_pay_date + interval ' . $var_ce_12 . ' ' . $var_ce_19 . ' where id =' . $var_1['id'];
              if (!(mysql_query ($sql)))
              {
                echo mysql_error ();
                true;
              }

              continue;
            }

            continue;
          }
        }
      }

      $sql = 'select * from hm2_types where q_days > 0';
      $res = mysql_query ($sql);
      while ($var_1 = mysql_fetch_array ($res))
      {
        $var_ce_21 = $var_1['q_days'];
        $var_ce_22 = $var_1['id'];
        if ($var_1['return_profit'] == 1)
        {
          $sql = 'select * from hm2_deposits where 
                type_id = ' . $var_ce_22 . ' and 
                status = \'on\' and 
                user_id = ' . $var_ce_6 . ' and 
                (deposit_date + interval ' . $var_ce_21 . ' day < last_pay_date or deposit_date + interval ' . $var_ce_21 . ' day < now()) and
                ((' . $var_1['withdraw_principal'] . ' = 0) || (' . $var_1['withdraw_principal'] . ' && (deposit_date + interval ' . $var_1['withdraw_principal_duration'] . ' day < now())))
             ';
          $re = mysql_query ($sql);
          while ($var_add_4 = mysql_fetch_array ($re))
          {
            $sql = 'insert into hm2_history set
                user_id = ' . $var_add_4['user_id'] . ',
      		amount = ' . $var_add_4['actual_amount'] . ',
      		type=\'release_deposit\',
      		actual_amount = ' . $var_add_4['actual_amount'] . ',
                      ec = ' . $var_add_4['ec'] . ',
      		date = \'' . $var_add_4['deposit_date'] . ('\' + interval ' . $var_ce_21 . ' day,
                      deposit_id = ') . $var_add_4['id'];
            if (!(mysql_query ($sql)))
            {
              echo mysql_error ();
              true;
            }
          }
        }

        $sql = 'update hm2_deposits set status=\'off\' where 
             user_id = ' . $var_ce_6 . ' and 
    	       (deposit_date + interval ' . $var_ce_21 . ' day < last_pay_date or deposit_date + interval ' . $var_ce_21 . ' day < now()) and
             ((' . $var_1['withdraw_principal'] . ' = 0) || (' . $var_1['withdraw_principal'] . ' && (deposit_date + interval ' . $var_1['withdraw_principal_duration'] . ' day < now()))) and
             type_id = ' . $var_ce_22 . '
           ';
        if (!(mysql_query ($sql)))
        {
          echo mysql_error ();
          true;
        }
      }
    }

  }

  function get_settings ()
  {
    $var_gs_1 = 0;
    if (file_exists ('./tmpl_c/.htdata'))
    {
      $var_gs_1 = 1;
    }

    $p = array ();
    $var_gs_2 = fopen ('./settings.php', 'r');
    if ($var_gs_2)
    {
      while ($var_eb_10 = fgets ($var_gs_2, 20000))
      {
        $var_eb_10 = chop ($var_eb_10);
        if ($var_eb_10 != '<?/*')
        {
          if ($var_eb_10 != '*/?>')
          {
            $var_gs_3 = $var_gs_4 = '';
            list ($var_gs_3, $var_gs_4) = @split ('	', $var_eb_10, 2);
            if (!((!(preg_match ('/^key|^cnf/', $var_gs_3) AND $var_gs_1 == 1) AND !($var_gs_1 == 0))))
            {
              $p[$var_gs_3] = $var_gs_4;
              continue;
            }

            continue;
          }

          continue;
        }
      }
    }

    fclose ($var_gs_2);
    if ($var_gs_1 == 1)
    {
      list ($var_eb_10, $var_gs_5) = file ('./tmpl_c/.htdata');
      $var_gs_6 = $var_eb_10;
      $var_gs_7 = 0;
      for ($i = 0; $i < strlen ($var_gs_6); $i += 5)
      {
        $var_gs_7 += hexdec (substr ($var_gs_6, $i, 5));
      }

      if ($p['cnf'] != $var_gs_7 * 15)
      {
        echo '<!-- Settings are broken. Please e-mail to script developers ASAP -->System maintenance and hardware upgrades.';
        exit ();
      }

      $var_eb_10 = decode_str ($var_eb_10, $p['key']);
      $var_gs_8 = split ('
', $var_eb_10);
      for ($i = 0; $i < sizeof ($var_gs_8); ++$i)
      {
        list ($var_gs_3, $var_gs_4) = @split ('	', $var_gs_8[$i], 2);
        $p[$var_gs_3] = $var_gs_4;
      }
    }

    $var_gs_9 = array ('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    $p['site_start_month_str_generated'] = $var_gs_9[$p['site_start_month'] - 1];
    if ($p['show_info_box_running_days'] == 1)
    {
      $p['site_days_online_generated'] = sprintf ('%d', (time () - mktime (0, 0, 0, $p['site_start_month'], $p['site_start_day'], $p['site_start_year'])) / 86400);
    }

    $p['time_dif'] = sprintf ('%d', $p['time_dif']);
    $p['def_payee_account_wiretransfer'] = ($p['enable_wire'] ? 1 : 0);
    $p['def_payee_account_egold'] = $p['def_payee_account'];
    return $p;
  }

  function save_settings ()
  {
    global $settings;
    if (!(is_writeable ('settings.php')))
    {
      echo '<br><br><br><br><center><h1>Your settings has not been saved.<br>Please set 666 permissions for <b>settings.php</b> file!<br>';
      exit ();
    }

    if (file_exists ('tmpl_c/.htdata'))
    {
      if (!(is_writeable ('tmpl_c/.htdata')))
      {
        echo '<br><br><br><br><center><h1>Your settings has not been saved.<br>Please set 666 permissions for <b>tmpl_c/.htdata</b> file!<br>';
        exit ();
      }
    }

    $var_gs_1 = 0;
    if (file_exists ('tmpl_c/.htdata'))
    {
      $var_gs_1 = 1;
    }

    $var_gs_2 = fopen ('./settings.php', 'w');
    reset ($settings);
    fputs ($var_gs_2, '<?/* 
');
    $var_gs_6 = '';
    while (list ($var_gs_3, $var_gs_4) = each ($settings))
    {
      if ($var_gs_3 != 'logged')
      {
        if (!($var_gs_1 == 0))
        {
          if ($var_gs_1 == 1)
          {
            if (preg_match ('/^key/', $var_gs_3))
            {
            }
          }
        }

        fputs ($var_gs_2, $var_gs_3 . '	' . $var_gs_4 . '
');
        $var_gs_6 .= $var_gs_3 . '	' . $var_gs_4 . '
';
        $var_gs_6 .= '' . $var_gs_3 . '	' . $var_gs_4 . '
';
        continue;
      }
    }

    $var_gs_6 = encode_str ($var_gs_6, $settings['key']);
    $var_gs_7 = 0;
    for ($i = 0; $i < strlen ($var_gs_6); $i += 5)
    {
      $var_gs_7 += hexdec (substr ($var_gs_6, $i, 5));
    }

    $var_gs_7 *= 15;
    fputs ($var_gs_2, 'cnf	' . $var_gs_7 . '
');
    fputs ($var_gs_2, '*/?>
');
    fclose ($var_gs_2);
    if ($var_gs_1 == 1)
    {
      $var_gs_2 = fopen ('./tmpl_c/.htdata', 'w');
      fputs ($var_gs_2, $var_gs_6);
      fclose ($var_gs_2);
    }

  }

  function encode_str ($sql, $param_es_1)
  {
    $A = strtoupper (md5 ($param_es_1));
    $var_es_1 = 0;
    for ($i = 0; $i < strlen ($sql); ++$i)
    {
      if (strlen ($A) == $var_es_1 + 10)
      {
        $var_es_1 = 0;
      }

      $var_es_2 .= sprintf ('%02x', ord (substr ($sql, $i, 1)) ^ ord (substr ($A, $var_es_1, 1)));
      ++$var_es_1;
    }

    return $var_es_2;
  }

  function decode_str ($sql, $param_es_1)
  {
    $A = strtoupper (md5 ($param_es_1));
    $var_es_1 = 0;
    for ($i = 0; $i < strlen ($sql); $i += 2)
    {
      if (strlen ($A) == $var_es_1 + 10)
      {
        $var_es_1 = 0;
      }

      $m = hexdec (substr ($sql, $i, 2));
      $var_es_2 .= chr ($m ^ ord (substr ($A, $var_es_1, 1)));
      ++$var_es_1;
    }

    return $var_es_2;
  }

  function db_open ()
  {
    global $settings;
    if (!($var_do_1 = mysql_connect ($settings['hostname'], $settings['db_login'], $settings['db_pass'])))
    {
      exit (mysql_error ());
    }

    if (!(mysql_select_db ($settings['database'])))
    {
      echo mysql_error ();
      exit ();
    }

    return $var_do_1;
  }

  function db_close ($var_do_1)
  {
    mysql_close ($var_do_1);
  }

  function clean ($var_gete_4)
  {
    $var_cl_1 = array ('javascript:', 'pay_to_', 'document.location', 'vbscript:', '<marquee', '<script', '<SCRIPT', '?php');
    $var_gete_4 = str_replace ($var_cl_1, '_', $var_gete_4);
    return $var_gete_4;
  }

  function quote ($str)
  {
    $tags = array ('applet', 'embed', 'frame', 'frameset', 'iframe', 'ilayer', 'layer', 'meta', 'script', 'xml', 'script', 'onmouseover', '<ScRiPt%20%0a%0d>', '</ScRiPt>');
    $attr = array ('action', 'codebase', 'dynsrc', 'lowsrc', 'onmouseover');
    include_once 'inc/inputfilter_class.php';
    $myFilter = new InputFilter ($tags, $attr, 0, 0, 1);
    return $str = $myFilter->process ($str);
  }

  function gen_confirm_code ($param_gcc_1, $param_gcc_2 = 1)
  {
    $m = array ('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
    $i = 0;
    $var_ad_2 = '';
    for ($i = 0; $i < $param_gcc_1; ++$i)
    {
      $var_ad_2 .= $m[rand (0, sizeof ($m) - 1)];
    }

    if ($param_gcc_2)
    {
      $var_ad_2 = md5 ($var_ad_2);
    }

    return $var_ad_2;
  }

  function get_rand_md5 ($param_gcc_1)
  {
    $m = array ('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'A', 'B', 'C', 'D', 'E', 'F');
    $i = 0;
    $var_ad_2 = '';
    for ($i = 0; $i < $param_gcc_1; ++$i)
    {
      $var_ad_2 .= $m[rand (0, sizeof ($m) - 1)];
    }

    return $var_ad_2;
  }

  function get_user_balance ($var_ce_22)
  {
    $sql = 'SELECT type, sum(actual_amount) as sum FROM hm2_history where user_id = ' . $var_ce_22 . ' GROUP BY type';
    if (!($res = mysql_query ($sql)))
    {
      echo mysql_error ();
      true;
    }

    $var_gub_1 = array ();
    while ($var_1 = mysql_fetch_array ($res))
    {
      $var_gub_1[$var_1['type']] = $var_1['sum'];
    }

    $var_gub_2 = 0;
    while (list ($var_gs_3, $var_gs_4) = each ($var_gub_1))
    {
      $var_gub_2 += $var_gs_4;
    }

    $var_gub_1['total'] = $var_gub_2;
    $sql = 'SELECT SUM(actual_amount) AS sum FROM hm2_deposits WHERE user_id = ' . $var_ce_22 . ' AND status=\'on\'';
    if (!($res = mysql_query ($sql)))
    {
      echo mysql_error ();
      true;
    }

    while ($var_1 = mysql_fetch_array ($res))
    {
      $var_gub_1['active_deposit'] += $var_1['sum'];
    }

    return $var_gub_1;
  }

?>