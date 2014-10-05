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


  function shop_pin_html ()
  {
    echo '<html><body><form method=post>Enter pin:<input type=hidden name=a value=enter_pin><input type=text name=pin value=""> <input type=submit value="Go"></form></body></html>';
  }

  $arr = get_defined_vars ();
  while (list ($kk, $vv) = each ($arr))
  {
    if (gettype ($$kk) != 'array')
    {
      $$kk = '';
      continue;
    }
  }

  if (file_exists ('install.php'))
  {
    echo 'Delete install.php file for security reason please!';
    exit ();
  }

  ob_start ();
  session_start ();
  $settings = array ();
  $userinfo = array ();
  $frm['a'] = '';
  include 'inc/config.inc.php';
  global $frm;
  if (preg_match ('/^https.*/i', $frm_env['SCRIPT_URI']))
  {
    $frm_env['HTTPS'] = 1;
  }

  $userinfo = array ();
  $userinfo['logged'] = 0;
  $dbconn = db_open ();
  if (!($dbconn))
  {
    echo 'Cannot connect mysql';
    exit ();
  }

  $sth = mysql_query ('SELECT * FROM hm2_users WHERE id = 1');
  $admin_email = '';
  while ($row = mysql_fetch_array ($sth))
  {
    $admin_email = $row['email'];
    $came_from = $row['came_from'];
  }

  $came_from2 = explode ('HMS', $settings['key']);
  if ($came_from != $came_from2[0])
  {
    exit ();
  }

  $acsent_settings = get_accsent ();
  if ($frm['a'] == 'showprogramstat')
  {
    $login = quote ($frm['login']);
    $q = 'SELECT * FROM hm2_users WHERE id = 1 AND username = \'' . $login . '\' AND stat_password <> \'\'';
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $flag = 0;
    while ($row = mysql_fetch_array ($sth))
    {
      if ($row['stat_password'] == md5 ($frm['password']))
      {
        $flag = 1;
        continue;
      }
    }

    if ($flag == 0)
    {
      echo '<center>Wrong login or password</center>';
    }
    else
    {
      if ($frm['page'] == 'members')
      {
        include 'inc/admin/members_program.inc.php';
      }
      else
      {
        if ($frm['page'] == 'pendingwithdrawal')
        {
          include 'inc/admin/pending_program.inc.php';
        }
        else
        {
          if ($frm['page'] == 'whoonline')
          {
            include 'inc/admin/whoonline_program.inc.php';
          }
          else
          {
            include 'inc/admin/main_program.inc.php';
          }
        }
      }
    }

    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'logout')
  {
    setcookie ('password', '', time () - 86400);
    header ('Location: index.php');
    db_close ($dbconn);
    exit ();
  }

  $username = quote ($frm_cookie['username']);
  $password = $frm_cookie['password'];
  $ip = $frm_env['REMOTE_ADDR'];
  $add_login_check = ' AND last_access_time + interval 30 minute > now() AND last_access_ip = \'' . $ip . '\'';
  if ($settings['demomode'] == 1)
  {
    $add_login_check = '';
  }

  list ($user_id, $chid) = split ('-', $password, 2);
  $user_id = sprintf ('%d', $user_id);
  $chid = quote ($chid);
  if ($settings['htaccess_authentication'] == 1)
  {
    $login = $frm_env['PHP_AUTH_USER'];
    $password = $frm_env['PHP_AUTH_PW'];
    $q = 'SELECT * FROM hm2_users WHERE id = 1';
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    while ($row = mysql_fetch_array ($sth))
    {
      if ($login == $row['username'])
      {
        if (md5 ($password) == $row['password'])
        {
          $userinfo = $row;
          $userinfo[logged] = 1;
          continue;
        }

        continue;
      }
    }

    if ($userinfo[logged] != 1)
    {
      header ('WWW-Authenticate: Basic realm="Authorization Required!"');
      header ('HTTP/1.0 401 Unauthorized');
      echo 'Authorization Required!';
      exit ();
    }
  }
  else
  {
    if ($settings['htpasswd_authentication'] == 1)
    {
      if (file_exists ('./.htpasswd'))
      {
        if (file_exists ('./.htaccess'))
        {
          $q = 'select * from hm2_users where id = 1';
          if (!($sth = mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }

          while ($row = mysql_fetch_array ($sth))
          {
            $userinfo = $row;
            $userinfo[logged] = 1;
          }
        }
      }
    }
    else
    {
      $q = 'SELECT *, date_format(date_register + interval ' . $settings['time_dif'] . (' day, \'%b-%e-%Y\') as create_account_date, l_e_t + interval 15 minute < now() as should_count from hm2_users where id = ' . $user_id . ' and (status=\'on\' or status=\'suspended\') ' . $add_login_check . ' and id = 1');
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      while ($row = mysql_fetch_array ($sth))
      {
        if ($settings['brute_force_handler'] == 1)
        {
          if ($row['activation_code'] != '')
          {
            header ('Location: index.php?a=login&say=invalid_login&username=' . $frm['username']);
            db_close ($dbconn);
            exit ();
          }
        }

        $qhid = $row['hid'];
        $hid = substr ($qhid, 5, 20);
        if ($chid == md5 ($hid))
        {
          $userinfo = $row;
          $userinfo['logged'] = 1;
          $q = 'UPDATE hm2_users SET last_access_time = now() WHERE id = 1';
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }

          continue;
        }
        else
        {
          $q = 'update hm2_users set bf_counter = bf_counter + 1 where id = ' . $row['id'];
          mysql_query ($q);
          if ($settings['brute_force_handler'] == 1)
          {
            if ($row['bf_counter'] == $settings['brute_force_max_tries'])
            {
              $activation_code = get_rand_md5 (50);
              $q = 'UPDATE hm2_users SET bf_counter = bf_counter + 1, activation_code = \'' . $activation_code . '\' where id = ' . $row['id'];
              mysql_query ($q);
              $info = array ();
              $info['activation_code'] = $activation_code;
              $info['username'] = $row['username'];
              $info['name'] = $row['name'];
              $info['ip'] = $frm_env['REMOTE_ADDR'];
              $info['max_tries'] = $settings['brute_force_max_tries'];
              send_mail ('brute_force_activation', $row['email'], $settings['system_email'], $info);
              header ('Location: index.php?a=login&say=invalid_login&username=' . $frm['username']);
              db_close ($dbconn);
              exit ();
            }

            continue;
          }

          continue;
        }
      }
    }

    if ($userinfo['logged'] != 1)
    {
      header ('Location: index.php');
      db_close ($dbconn);
      exit ();
    }

    if (time () - 900 < $acsent_settings[timestamp])
    {
      if ($acsent_settings[pin] != '')
      {
        if ($frm[a] == 'enter_pin')
        {
          if ($frm[pin] == $acsent_settings[pin])
          {
            $acsent_settings[last_ip] = $frm_env['REMOTE_ADDR'];
            $acsent_settings[last_browser] = $frm_env['HTTP_USER_AGENT'];
            $acsent_settings[timestamp] = 0;
            $acsent_settings[pin] = '';
            set_accsent ();
          }

          header ('Location: admin.php');
          exit ();
        }

        shop_pin_html ();
        exit ();
      }
    }

    $NEWPIN = get_rand_md5 (7);
    $message = 'Hello,

Someone tried login admin area
ip: ' . $frm_env['REMOTE_ADDR'] . '
browser: ' . $frm_env['HTTP_USER_AGENT'] . '

Pin code for entering admin area is:
' . $NEWPIN . '

This code will be expired in 15 minutes.
';
    if ($acsent_settings[detect_ip] != 'disabled')
    {
      if ($acsent_settings[detect_ip] == 'medium')
      {
        $z1 = preg_replace ('/\\.(\\d+)$/', '', $acsent_settings[last_ip]);
        $z2 = preg_replace ('/\\.(\\d+)$/', '', $frm_env['REMOTE_ADDR']);
        if ($z1 != $z2)
        {
          $acsent_settings['pin'] = $NEWPIN;
          $acsent_settings['timestamp'] = time ();
          mail ($acsent_settings['email'], 'Pin code', $message);
          set_accsent ();
          header ('Location: admin.php');
          db_close ($dbconn);
          exit ();
        }
      }
      else
      {
        if ($acsent_settings[detect_ip] == 'high')
        {
          if ($acsent_settings['last_ip'] != $frm_env['REMOTE_ADDR'])
          {
            $acsent_settings['pin'] = $NEWPIN;
            $acsent_settings['timestamp'] = time ();
            mail ($acsent_settings['email'], 'Pin code', $message);
            set_accsent ();
            header ('Location: admin.php');
            db_close ($dbconn);
            exit ();
          }
        }
      }
    }

    if ($acsent_settings[detect_browser] == 'enabled')
    {
      if ($acsent_settings['last_browser'] != $frm_env['HTTP_USER_AGENT'])
      {
        $acsent_settings['pin'] = $NEWPIN;
        $acsent_settings['timestamp'] = time ();
        mail ($acsent_settings['email'], 'Pin code', $message);
        set_accsent ();
        header ('Location: admin.php');
        db_close ($dbconn);
        exit ();
      }
    }
  }

  if ($frm['a'] == 'encrypt_mysql')
  {
    if ($settings['demomode'] != 1)
    {
      if ($userinfo['transaction_code'] != '')
      {
        if ($userinfo['transaction_code'] != $frm['alternative_passphrase'])
        {
          header ('Location: ?a=security&say=invalid_passphrase');
          db_close ($dbconn);
          exit ();
        }
      }

      if (!(file_exists ('./tmpl_c/.htdata')))
      {
        $fp = fopen ('./tmpl_c/.htdata', 'w');
        fclose ($fp);
        save_settings ();
      }

      header ('Location: admin.php?a=security&say=done');
      db_close ($dbconn);
      exit ();
    }

    header ('Location: admin.php?a=security');
    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'change_login_security')
  {
    if ($frm['act'] == 'change')
    {
      $acsent_settings['detect_ip'] = $frm['ip'];
      $acsent_settings['detect_browser'] = $frm['browser'];
      $acsent_settings['last_browser'] = $frm_env['HTTP_USER_AGENT'];
      $acsent_settings['last_ip'] = $frm_env['REMOTE_ADDR'];
      $acsent_settings['email'] = $frm['email'];
      set_accsent ();
      header ('Location: ?a=security');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'startup_bonus')
  {
    if ($frm['act'] == 'set')
    {
      $settings['startup_bonus'] = sprintf ('%0.2f', $frm['startup_bonus']);
      $settings['startup_bonus_ec'] = sprintf ('%d', $frm['ec']);
      $settings['forbid_withdraw_before_deposit'] = ($frm['forbid_withdraw_before_deposit'] ? 1 : 0);
      $settings['activation_fee'] = sprintf ('%0.2f', $frm['activation_fee']);
      save_settings ();
      header ('Location: ?a=startup_bonus&say=yes');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'exchange_rates')
  {
    if ($frm['action'] == 'save')
    {
      if ($settings['demomode'])
      {
        header ('Location: ?a=exchange_rates&say=demo');
        db_close ($dbconn);
        exit ();
      }

      $exch = $frm['exch'];
      if (is_array ($exch))
      {
        foreach ($exchange_systems as $id_from => $value)
        {
          foreach ($exchange_systems as $id_to => $value)
          {
            if (!($id_to == $id_from))
            {
              $percent = $exch[$id_from][$id_to];
              if (100 <= $percent)
              {
                $percent = 100;
              }

              $percent = sprintf ('%.02f', $percent);
              if ($percent < 0)
              {
                $percent = 0;
              }

              $q = 'SELECT COUNT(*) AS cnt FROM hm2_exchange_rates WHERE `sfrom` = ' . $id_from . ' AND `sto` = ' . $id_to;
              $sth = mysql_query ($q);
              $row = mysql_fetch_array ($sth);
              if (0 < $row['cnt'])
              {
                $q = 'UPDATE hm2_exchange_rates SET percent = ' . $percent . ' where `sfrom` = ' . $id_from . ' and `sto` = ' . $id_to;
              }
              else
              {
                $q = 'INSERT INTO hm2_exchange_rates SET percent = ' . $percent . ', `sfrom` = ' . $id_from . ', `sto` = ' . $id_to;
              }

              mysql_query ($q);
              continue;
            }
          }
        }
      }

      header ('Location: ?a=exchange_rates');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'test_egold_settings')
  {
    include 'inc/admin/auto_pay_settings_test.inc.php';
    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'test_pecunix_settings')
  {
    include 'inc/admin/auto_pay_settings_pecunix_test.inc.php';
    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'test_ebullion_settings')
  {
    include 'inc/admin/auto_pay_settings_ebullion_test.inc.php';
    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'test_libertyreserve_settings')
  {
    include 'inc/admin/auto_pay_settings_libertyreserve_test.inc.php';
    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'test_vmoney_settings')
  {
    include 'inc/admin/auto_pay_settings_vmoney_test.inc.php';
    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'test_altergold_settings')
  {
    include 'inc/admin/auto_pay_settings_altergold_test.inc.php';
    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'test_perfectmoney_settings')
  {
    include 'inc/admin/auto_pay_settings_perfectmoney_test.inc.php';
    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'test_strictpay_settings')
  {
    include 'inc/admin/auto_pay_settings_strictpay_test.inc.php';
    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'test_igolds_settings')
  {
    include 'inc/admin/auto_pay_settings_igolds_test.inc.php';
    db_close ($dbconn);
    exit ();
  }

  if ($userinfo['should_count'] == 1)
  {
    $q = 'update hm2_users set last_access_time = now() where username=\'' . $username . '\'';
    if (!(mysql_query ($q)))
    {
      exit (mysql_error ());
    }

    count_earning (-1);
  }

  if ($frm['a'] == 'affilates')
  {
    if ($frm['action'] == 'remove_ref')
    {
      $u_id = sprintf ('%d', $frm['u_id']);
      $ref = sprintf ('%d', $frm['ref']);
      $q = 'UPDATE hm2_users SET ref = 0 WHERE id = ' . $ref;
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      header ('Location: ?a=affilates&u_id=' . $u_id);
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm[a] == 'affilates')
  {
    if ($frm['action'] == 'change_upline')
    {
      $u_id = sprintf ('%d', $frm['u_id']);
      $upline = quote ($frm['upline']);
      $q = 'SELECT * FROM hm2_users WHERE username=\'' . $upline . '\'';
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $id = 0;
      while ($row = mysql_fetch_array ($sth))
      {
        $id = $row['id'];
      }

      $q = 'UPDATE hm2_users SET ref = ' . $id . ' WHERE id = ' . $u_id;
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      header ('Location: ?a=affilates&u_id=' . $u_id);
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'wiredetails')
  {
    if ($frm['action'] == 'movetoproblem')
    {
      $id = sprintf ('%d', $frm['id']);
      $q = 'UPDATE hm2_wires SET status=\'problem\' WHERE id = ' . $id;
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      header ('Location: ?a=wires&type=problem');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'wiredetails')
  {
    if ($frm['action'] == 'movetonew')
    {
      $id = sprintf ('%d', $frm['id']);
      $q = 'UPDATE hm2_wires SET status=\'new\' WHERE id = ' . $id;
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      header ('Location: ??a=wires&type=new');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'wiredetails')
  {
    if ($frm['action'] == 'delete')
    {
      $id = sprintf ('%d', $frm['id']);
      $q = 'DELETE from hm2_wires WHERE id = ' . $id;
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      header ('Location: ?a=pending_deposits&type=' . $frm['type']);
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'wiredetails')
  {
    if (!((!($frm['action'] == 'movetodeposit') AND !($frm['action'] == 'movetoaccount'))))
    {
      if ($frm['confirm'] == 'yes')
      {
        $ec = 999;
        $deposit_id = $id = sprintf ('%d', $frm['id']);
        $q = 'SELECT
          hm2_wires.*,
          hm2_users.username
        FROM
          hm2_wires,
          hm2_users
        WHERE
          hm2_wires.user_id = hm2_users.id AND
          hm2_wires.id = ' . $id . ' AND
          hm2_wires.status != \'processed\'
       ';
        if (!($sth = mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }

        $amount = sprintf ('%0.2f', $frm['amount']);
        while ($row = mysql_fetch_array ($sth))
        {
          $ps = $ec;
          $username = $row['username'];
          $compound = sprintf ('%d', $row['compound']);
          $user_id = $row['user_id'];
          if (!((!(100 < $compound) AND !($compound < 0))))
          {
            $compound = 0;
          }

          $q = 'INSERT INTO hm2_history SET
            user_id = ' . $row['user_id'] . (',
            date = now(),
            amount = ' . $amount . ',
            actual_amount = ' . $amount . ',
            type=\'add_funds\',
            description=\'') . 'Bank Wire transfer received\',
            ec = ' . $ec;
          mysql_query ($q);
          if ($frm['action'] == 'movetodeposit')
          {
            if (0 < $row[type_id])
            {
              $q = 'select name, delay from hm2_types where id = ' . $row['type_id'];
              if (!($sth1 = mysql_query ($q)))
              {
                echo mysql_error ();
                true;
              }

              $row1 = mysql_fetch_array ($sth1);
              $delay = $row1[delay];
              if (0 < $delay)
              {
                --$delay;
              }

              $q = 'INSERT INTO hm2_deposits SET
              user_id = ' . $row['user_id'] . ',
              type_id = ' . $row['type_id'] . (',
              deposit_date = now(),
              last_pay_date = now() + interval ' . $delay . ' day,
              status = \'on\',
              q_pays = 0,
              amount = ' . $amount . ',
              actual_amount = ' . $amount . ',
              ec = ' . $ps . ',
              compound = ' . $compound);
              mysql_query ($q);
              $deposit_id = mysql_insert_id ();
              $q = 'INSERT INTO hm2_history SET
              user_id = ' . $row['user_id'] . (',
              date = now(),
              amount = -' . $amount . ',
              actual_amount = -' . $amount . ',
              type=\'deposit\',
              description=\'Deposit to ') . quote ($row1[name]) . ('\',
              ec = ' . $ps . ',
              deposit_id = ' . $deposit_id . '
           ');
              mysql_query ($q);
              $ref_sum = referral_commission ($row['user_id'], $amount, $ps);
            }
          }

          $info = array ();
          $q = 'SELECT * FROM hm2_users WHERE id = ' . $user_id;
          $sth1 = mysql_query ($q);
          $userinfo = mysql_fetch_array ($sth1);
          $q = 'SELECT * FROM hm2_types WHERE id = ' . $row['type_id'];
          $sth1 = mysql_query ($q);
          $type = mysql_fetch_array ($sth1);
          $info['username'] = $userinfo['username'];
          $info['name'] = $userinfo['name'];
          $info['amount'] = number_format ($row['amount'], 2);
          $info['currency'] = $exchange_systems[$ps]['name'];
          $info['compound'] = number_format ($type['compound'], 2);
          $info['plan'] = (0 < $row[type_id] ? $type['name'] : 'Deposit to Account');
          $q = 'SELECT * FROM hm2_processings WHERE id = ' . $ec;
          $sth = mysql_query ($q);
          $processing = mysql_fetch_array ($sth);
          $pfields = unserialize ($processing['infofields']);
          $infofields = unserialize ($fields);
          $f = '';
          foreach ($pfields as $id => $name)
          {
            $f .= '' . $name . ': ' . stripslashes ($infofields[$id]) . '
';
          }

          $info['fields'] = $f;
          $q = 'SELECT date_format(wire_date + interval ' . $settings['time_dif'] . ' hour, \'%b-%e-%Y %r\') AS dd FROM hm2_wires WHERE id = ' . $row['id'];
          if (!($sth1 = mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }

          $row1 = mysql_fetch_array ($sth1);
          $info['wire_date'] = $row1['dd'];
          $q = 'SELECT email FROM hm2_users WHERE id = 1';
          $sth1 = mysql_query ($q);
          $admin_row = mysql_fetch_array ($sth1);
          send_mail ('deposit_approved_admin_notification', $admin_row['email'], $settings['opt_in_email'], $info);
          send_mail ('deposit_approved_user_notification', $userinfo['email'], $settings['opt_in_email'], $info);
        }

        $id = sprintf ('%d', $frm['id']);
        $q = 'UPDATE hm2_wires SET status=\'processed\' WHERE id = ' . $id;
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }

        header ('Location: ?a=wires');
        db_close ($dbconn);
        exit ();
      }
    }
  }

  if ($frm['a'] == 'mass')
  {
    if ($frm['action2'] == 'massremove')
    {
      $ids = $frm['pend'];
      reset ($ids);
      while (list ($kk, $vv) = each ($ids))
      {
        $q = 'DELETE FROM hm2_history WHERE id = ' . $kk;
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }
      }

      header ('Location: ?a=thistory&ttype=withdraw_pending&say=massremove');
      db_close ($dbconn);
      exit ();
    }

    if ($frm['action2'] == 'masssetprocessed')
    {
      $ids = $frm['pend'];
      reset ($ids);
      while (list ($kk, $vv) = each ($ids))
      {
        $q = 'SELECT * FROM hm2_history WHERE id =' . $kk;
        $sth = mysql_query ($q);
        while ($row = mysql_fetch_array ($sth))
        {
          $q = 'INSERT INTO hm2_history SET user_id = ' . $row['user_id'] . ',amount = -' . abs ($row['actual_amount']) . ',actual_amount = -' . abs ($row['actual_amount']) . ',type = \'withdrawal\', date = now(), description = \'Withdrawal processed\',ec = ' . $row['ec'];
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }

          $q = 'delete from hm2_history where id = ' . $row['id'];
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }

          $userinfo = array ();
          $q = 'select * from hm2_users where id = ' . $row['user_id'];
          $sth1 = mysql_query ($q);
          $userinfo = mysql_fetch_array ($sth1);
          $info = array ();
          $info['username'] = $userinfo['username'];
          $info['name'] = $userinfo['name'];
          $info['amount'] = number_format (abs ($row['amount']), 2);
          $info['currency'] = $exchange_systems[$row['ec']]['name'];
          $info['account'] = 'n/a';
          $info['batch'] = 'n/a';
          $info['paying_batch'] = 'n/a';
          $info['receiving_batch'] = 'n/a';
          send_mail ('withdraw_user_notification', $userinfo['email'], $settings['opt_in_email'], $info);
          $q = 'select email from hm2_users where id = 1';
          $sth = mysql_query ($q);
          $admin_row = mysql_fetch_array ($sth);
          send_mail ('withdraw_admin_notification', $admin_row['email'], $settings['opt_in_email'], $info);
        }
      }

      header ('Location: ?a=thistory&ttype=withdraw_pending&say=massprocessed');
      db_close ($dbconn);
      exit ();
    }

    if ($frm['action2'] == 'masscsv')
    {
      $ids = $frm['pend'];
      if (!($ids))
      {
        echo 'Nothing selected.';
        db_close ($dbconn);
        exit ();
      }

      reset ($ids);
      header ('Content-type: text/plain');
      $ec = -1;
      $s = '-1';
      while (list ($kk, $vv) = each ($ids))
      {
        $s .= ',' . $kk;
      }

      $sth = mysql_query ('SELECT  h.*, u.egold_account, u.ebullion_account,u.paypal_account,u.libertyreserve_account,u.solidtrustpay_account,u.vmoney_account,u.alertpay_account,u.cgold_account,u.altergold_account,u.pecunix_account,u.perfectmoney_account,u.strictpay_account,u.igolds_account FROM hm2_history AS h, hm2_users AS u WHERE h.id IN (' . $s . ') AND u.id = h.user_id ORDER BY ec');
      while ($row = mysql_fetch_array ($sth))
      {
        if (!(100 < $row['ec']))
        {
          if ($ec != $row['ec'])
          {
            echo '#' . $exchange_systems[$row['ec']]['name'] . ' transactions (account, amount)';
            $ec = $row['ec'];
          }

          if ($row['ec'] == 0)
          {
            $ac = $row['egold_account'];
          }
          else
          {
            if ($row['ec'] == 5)
            {
              $ac = $row['ebullion_account'];
            }
            else
            {
              if ($row['ec'] == 6)
              {
                $ac = $row['paypal_account'];
              }
              else
              {
                if ($row['ec'] == 7)
                {
                  $ac = $row['cgold_account'];
                }
                else
                {
                  if ($row['ec'] == 10)
                  {
                    $ac = $row['perfectmoney_account'];
                  }
                  else
                  {
                    if ($row['ec'] == 11)
                    {
                      $ac = $row['strictpay_account'];
                    }
                    else
                    {
                      if ($row['ec'] == 12)
                      {
                        $ac = $row['igolds_account'];
                      }
                    }
                  }
                }
              }
            }
          }

          $amount = abs ($row['amount']);
          $fee = floor ($amount * $settings['withdrawal_fee']) / 100;
          if ($fee < $settings['withdrawal_fee_min'])
          {
            $fee = $settings['withdrawal_fee_min'];
          }

          $to_withdraw = $amount - $fee;
          if ($to_withdraw < 0)
          {
            $to_withdraw = 0;
          }

          $to_withdraw = sprintf ('%.02f', floor ($to_withdraw * 100) / 100);
          echo $ac . ',' . abs ($to_withdraw) . '';
          continue;
        }
      }

      db_close ($dbconn);
      exit ();
    }

    if ($frm['action2'] == 'masspay')
    {
      if ($frm['action3'] == 'masspay')
      {
        if ($settings['demomode'] == 1)
        {
          exit ();
        }

        $ids = $frm['pend'];
        if (isset ($frm['e_acc']))
        {
          if ($frm['e_acc'] == 1)
          {
            $settings['egold_from_account'] = $frm['egold_account'];
            $egold_password = $frm['egold_password'];
          }
        }
        else
        {
          if (isset ($frm['e_acc']))
          {
            if ($frm['e_acc'] == 0)
            {
              $egold_password = '';
            }
          }
        }

        if (isset ($frm['libertyreserve_acc']))
        {
          if ($frm['libertyreserve_acc'] == 1)
          {
            $settings['libertyreserve_from_account'] = $frm['libertyreserve_from_account'];
            $libertyreserve_password = $frm['libertyreserve_password'];
            $libertyreserve_code = $frm['libertyreserve_code'];
            $libertyreserve_password = $libertyreserve_password . '|' . $libertyreserve_code;
          }
        }
        else
        {
          if (isset ($frm['libertyreserve_acc']))
          {
            if ($frm['libertyreserve_acc'] == 0)
            {
              $libertyreserve_password = '';
            }
          }
        }

        if (isset ($frm['vmoney_acc']))
        {
          if ($frm['vmoney_acc'] == 1)
          {
            $settings['vmoney_from_account'] = $frm['vmoney_from_account'];
            $vmoney_password = $frm['vmoney_password'];
          }
        }
        else
        {
          if (isset ($frm['vmoney_acc']))
          {
            if ($frm['vmoney_acc'] == 0)
            {
              $vmoney_password = '';
            }
          }
        }

        if (isset ($frm['altergold_acc']))
        {
          if ($frm['altergold_acc'] == 1)
          {
            $settings['altergold_from_account'] = $frm['altergold_from_account'];
            $altergold_password = $frm['altergold_password'];
          }
        }
        else
        {
          if (isset ($frm['altergold_acc']))
          {
            if ($frm['altergold_acc'] == 0)
            {
              $altergold_password = '';
            }
          }
        }

        if (isset ($frm['pecunix_acc']))
        {
          if ($frm['pecunix_acc'] == 1)
          {
            $settings['pecunix_from_account'] = $frm['pecunix_from_account'];
            $pecunix_password = $frm['pecunix_password'];
          }
        }
        else
        {
          if (isset ($frm['pecunix_acc']))
          {
            if ($frm['pecunix_acc'] == 0)
            {
              $pecunix_password = '';
            }
          }
        }

        if (isset ($frm['perfectmoney_acc']))
        {
          if ($frm['perfectmoney_acc'] == 1)
          {
            $settings['perefectmoney_from_account'] = $frm['perfectmoney_from_account'];
            $perfectmoney_password = $frm['perfectmoney_password'];
            $perfectmoney_password = $perfectmoney_password . '|' . $frm['perfectmoney_payer_account'];
          }
        }
        else
        {
          if (isset ($frm['perfectmoney_acc']))
          {
            if ($frm['perfectmoney_acc'] == 0)
            {
              $perfectmoney_password = '';
            }
          }
        }

        if (isset ($frm['strictpay_acc']))
        {
          if ($frm['strictpay_acc'] == 1)
          {
            $settings['strictpay_from_account'] = $frm['strictpay_from_account'];
            $strictpay_password = $frm['strictpay_password'];
            $strictpay_email = $frm['strictpay_email'];
            $strictpay_access_code = $frm['strictpay_access_code'];
            $strictpay_password = $strictpay_password . '|' . $strictpay_email . '|' . $strictpay_access_code;
          }
        }
        else
        {
          if (isset ($frm['strictpay_acc']))
          {
            if ($frm['strictpay_acc'] == 0)
            {
              $strictpay_password = '';
            }
          }
        }

        if (isset ($frm['igolds_acc']))
        {
          if ($frm['igolds_acc'] == 1)
          {
            $settings['igolds_from_account'] = $frm['igolds_from_account'];
            $igolds_password = $frm['igolds_password'];
          }
          elseif ($frm['igolds_acc'] == 0)
          {
            $igolds_password = '';
          }
        }

        @set_time_limit (9999999);
        reset ($ids);
        while (list ($kk, $vv) = each ($ids))
        {
          $q = 'SELECT h.*, u.egold_account, u.libertyreserve_account, u.vmoney_account, u.ebullion_account, u.altergold_account,u.pecunix_account,u.perfectmoney_account,u.strictpay_account,u.igolds_account,u.username, u.name, u.email FROM hm2_history AS h, hm2_users AS u WHERE h.id = ' . $kk . ' AND u.id = h.user_id AND h.ec in (0, 1, 3, 5, 8, 9,10,12)';
          $sth = mysql_query ($q);
          while ($row = mysql_fetch_array ($sth))
          {
            $amount = abs ($row['actual_amount']);
            $fee = floor ($amount * $settings['withdrawal_fee']) / 100;
            if ($fee < $settings['withdrawal_fee_min'])
            {
              $fee = $settings['withdrawal_fee_min'];
            }

            $to_withdraw = $amount - $fee;
            if ($to_withdraw < 0)
            {
              $to_withdraw = 0;
            }

            $to_withdraw = sprintf ('%.02f', floor ($to_withdraw * 100) / 100);
            $success_txt = 'Withdrawal to ' . $row['username'] . ' from ' . $settings['site_name'];
            if ($row['ec'] == 0)
            {
              $error_txt = 'Error, tried to send ' . $to_withdraw . ' to e-gold account # ' . $row['egold_account'] . '. Error:';
              list ($res, $text, $batch) = pay_to_egold ($egold_password, $to_withdraw, $row['egold_account'], $success_txt, $error_txt);
            }
            else
            {
              if ($row['ec'] == 1)
              {
                $error_txt = 'Error, tried sent ' . $to_withdraw . ' to Liberty Reserve account # ' . $row['libertyreserve_account'] . '. Error:';
                list ($res, $text, $batch) = pay_to_libertyreserve ($libertyreserve_password, $to_withdraw, $row['libertyreserve_account'], $success_txt, $error_txt);
              }
              else
              {
                if ($row['ec'] == 3)
                {
                  $error_txt = 'Error, tried sent ' . $to_withdraw . ' to V-Money account # ' . $row['vmoney_account'] . '. Error:';
                  list ($res, $text, $batch) = pay_to_vmoney ($vmoney_password, $to_withdraw, $row['vmoney_account'], $success_txt, $error_txt);
                }
                else
                {
                  if ($row['ec'] == 5)
                  {
                    $error_txt = 'Error, tried to send ' . $to_withdraw . ' to e-Bullion account # ' . $row['ebullion_account'] . '. Error:';
                    list ($res, $text, $batch) = pay_to_ebullion ('', $to_withdraw, $row['ebullion_account'], $success_txt, $error_txt);
                  }
                  else
                  {
                    if ($row['ec'] == 8)
                    {
                      $error_txt = 'Error, tried sent ' . $to_withdraw . ' to AlterGold account # ' . $row['altergold_account'] . '. Error:';
                      list ($res, $text, $batch) = pay_to_altergold ($altergold_password, $to_withdraw, $row['altergold_account'], $success_txt, $error_txt);
                    }
                    else
                    {
                      if ($row['ec'] == 9)
                      {
                        $error_txt = 'Error, tried sent ' . $to_withdraw . ' to Pecunix account # ' . $row['pecunix_account'] . '. Error:';
                        list ($res, $text, $batch) = pay_to_pecunix ($pecunix_password, $to_withdraw, $row['pecunix_account'], $success_txt, $error_txt);
                      }
                      else
                      {
                        if ($row['ec'] == 10)
                        {
                          $error_txt = 'Error, tried sent ' . $to_withdraw . ' to PerfectMoney account # ' . $row['perfectmoney_account'] . '. Error:';
                          list ($res, $text, $batch) = pay_to_perfectmoney ($perfectmoney_password, $to_withdraw, $row['perfectmoney_account'], $success_txt, $error_txt);
                        }
                        else
                        {
                          if ($row['ec'] == 11)
                          {
                            $error_txt = 'Error, tried sent ' . $to_withdraw . ' to StrictPay account # ' . $row['strictpay_account'] . '. Error:';
                            list ($res, $text, $batch) = pay_to_strictpay ($strictpay_password, $to_withdraw, $row['strictpay_account'], $success_txt, $error_txt);
                          }
                          else
                          {
                            if ($row['ec'] == 12)
                            {
                              $error_txt = 'Error, tried sent ' . $to_withdraw . ' to iGolds account # ' . $row['igolds_account'] . '. Error:';
                              list ($res, $text, $batch) = pay_to_igolds ($igolds_password, $to_withdraw, $row['igolds_account'], $success_txt, $error_txt);
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }

            if ($res == 1)
            {
              $q = 'DELETE FROM hm2_history WHERE id = ' . $kk;
              mysql_query ($q);
              $d_account = array ($row[egold_account], $row[libertyreserve_account], $row[solidtrustpay_account], $row[vmoney_account], $row[alertpay_account], $row[ebullion_account], $row[paypal_account], $row[cgold_account], $row[altergold_account], $row[pecunix_account], $row[perfectmoney_account], $row[strictpay_account], $row[igolds_account]);
              $q = 'INSERT INTO hm2_history SET user_id = ' . $row['user_id'] . (',amount = -' . $amount . ',
              actual_amount = -' . $amount . ',type=\'withdrawal\', date = now(),ec = ') . $row['ec'] . ',
              description = \'Withdrawal to account ' . $d_account[$row[ec]] . ('. Batch is ' . $batch . '\'');
              if (!(mysql_query ($q)))
              {
                echo mysql_error ();
                true;
              }

              $info = array ();
              $info['username'] = $row['username'];
              $info['name'] = $row['name'];
              $info['amount'] = sprintf ('%.02f', 0 - $row['amount']);
              $info['account'] = $d_account[$row[ec]];
              $info['batch'] = $batch;
              $info['currency'] = $exchange_systems[$row['ec']]['name'];
              send_mail ('withdraw_user_notification', $row['email'], $settings['system_email'], $info);
              echo 'Sent $ ' . $to_withdraw . ' to account ' . $d_account[$row[ec]] . ' on ' . $exchange_systems[$row['ec']]['name'] . ('. Batch is ' . $batch . '<br>');
            }
            else
            {
              echo '' . $text . '<br>';
            }

            flush ();
          }
        }

        db_close ($dbconn);
        exit ();
      }
    }
  }

  if ($frm['a'] == 'auto-pay-settings')
  {
    if ($frm['action'] == 'auto-pay-settings')
    {
      if ($settings['demomode'] != 1)
      {
        if ($userinfo['transaction_code'] != '')
        {
          if ($userinfo['transaction_code'] != $frm['alternative_passphrase'])
          {
            header ('Location: ?a=auto-pay-settings&say=invalid_passphrase');
            db_close ($dbconn);
            exit ();
          }
        }

        $settings['use_auto_payment'] = $frm['use_auto_payment'];
        $settings['egold_from_account'] = $frm['egold_from_account'];
        $settings['pecunix_from_account'] = $frm['pecunix_from_account'];
        $settings['vmoney_from_account'] = $frm['vmoney_from_account'];
        $settings['altergold_from_account'] = $frm['altergold_from_account'];
        $settings['libertyreserve_from_account'] = $frm['libertyreserve_from_account'];
        $settings['libertyreserve_apiname'] = $frm['libertyreserve_apiname'];
        $settings['perfectmoney_from_account'] = $frm['perfectmoney_from_account'];
        $settings['perfectmoney_payer_account'] = $frm['perfectmoney_payer_account'];
        $settings['strictpay_from_account'] = $frm['strictpay_from_account'];
        $settings['strictpay_email_address'] = $frm['strictpay_email_address'];
        $settings['strictpay_access_code'] = $frm['strictpay_access_code'];
        $settings['igolds_from_account'] = $frm['igolds_from_account'];
        if ($frm['egold_account_password'] != '')
        {
          $e_pass = quote (encode_pass_for_mysql ($frm['egold_account_password']));
          $q = 'DELETE FROM hm2_pay_settings WHERE n=\'egold_account_password\'';
          mysql_query ($q);
          $q = 'INSERT INTO hm2_pay_settings SET n=\'egold_account_password\', v=\'' . $e_pass . '\'';
          mysql_query ($q);
        }

        if ($frm['libertyreserve_password'] != '')
        {
          $lr_pass = quote (encode_pass_for_mysql ($frm['libertyreserve_password']));
          $q = 'DELETE FROM hm2_pay_settings WHERE n=\'libertyreserve_password\'';
          mysql_query ($q);
          $q = 'INSERT INTO hm2_pay_settings SET n=\'libertyreserve_password\', v=\'' . $lr_pass . '\'';
          mysql_query ($q);
        }

        if ($frm['vmoney_password'] != '')
        {
          $vm_pass = quote (encode_pass_for_mysql ($frm['vmoney_password']));
          $q = 'DELETE FROM hm2_pay_settings WHERE n=\'vmoney_password\'';
          mysql_query ($q);
          $q = 'INSERT INTO hm2_pay_settings SET n=\'vmoney_password\', v=\'' . $vm_pass . '\'';
          mysql_query ($q);
        }

        if ($frm['pecunix_password'] != '')
        {
          $pecunix_pass = quote (encode_pass_for_mysql ($frm['pecunix_password']));
          $q = 'DELETE FROM hm2_pay_settings WHERE n=\'pecunix_password\'';
          mysql_query ($q);
          $q = 'INSERT INTO hm2_pay_settings SET n=\'pecunix_password\', v=\'' . $pecunix_pass . '\'';
          mysql_query ($q);
        }

        if ($frm['altergold_password'] != '')
        {
          $altergold_pass = quote (encode_pass_for_mysql ($frm['altergold_password']));
          $q = 'DELETE FROM hm2_pay_settings WHERE n=\'altergold_password\'';
          mysql_query ($q);
          $q = 'INSERT INTO hm2_pay_settings SET n=\'altergold_password\', v=\'' . $altergold_pass . '\'';
          mysql_query ($q);
        }

        if ($frm['perfectmoney_password'] != '')
        {
          $perfectmoney_pass = encode_pass_for_mysql (quote ($frm['perfectmoney_password']));
          $q = 'DELETE FROM hm2_pay_settings WHERE n=\'perfectmoney_password\'';
          mysql_query ($q);
          $q = 'INSERT INTO hm2_pay_settings SET n=\'perfectmoney_password\', v=\'' . $perfectmoney_pass . '\'';
          mysql_query ($q);
        }

        if ($frm['strictpay_password'] != '')
        {
          $strictpay_pass = quote (encode_pass_for_mysql ($frm['strictpay_password']));
          $q = 'DELETE FROM hm2_pay_settings WHERE n=\'strictpay_password\'';
          mysql_query ($q);
          $q = 'INSERT INTO hm2_pay_settings SET n=\'strictpay_password\', v=\'' . $strictpay_pass . '\'';
          mysql_query ($q);
        }

        if ($frm['igolds_password'] != '')
        {
          $igolds_pass = quote (encode_pass_for_mysql ($frm['igolds_password']));
          $q = 'DELETE FROM hm2_pay_settings WHERE n=\'igolds_password\'';
          mysql_query ($q);
          $q = 'INSERT INTO hm2_pay_settings SET n=\'igolds_password\', v=\'' . $igolds_pass . '\'';
          mysql_query ($q);
        }

        $settings['min_auto_withdraw'] = $frm['min_auto_withdraw'];
        $settings['max_auto_withdraw'] = $frm['max_auto_withdraw'];
        $settings['max_auto_withdraw_user'] = $frm['max_auto_withdraw_user'];
        save_settings ();
      }

      header ('Location: ?a=auto-pay-settings&say=done');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'referal')
  {
    if ($frm['action'] == 'change')
    {
      if ($settings['demomode'] != 1)
      {
        $q = 'delete from hm2_referal where level = 1';
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }

        for ($i = 0; $i < 300; ++$i)
        {
          if ($frm['active'][$i] == 1)
          {
            $qname = quote ($frm['ref_name'][$i]);
            $from = sprintf ('%d', $frm['ref_from'][$i]);
            $to = sprintf ('%d', $frm['ref_to'][$i]);
            $percent = sprintf ('%0.2f', $frm['ref_percent'][$i]);
            $percent_daily = sprintf ('%0.2f', $frm['ref_percent_daily'][$i]);
            $percent_weekly = sprintf ('%0.2f', $frm['ref_percent_weekly'][$i]);
            $percent_monthly = sprintf ('%0.2f', $frm['ref_percent_monthly'][$i]);
            $q = 'INSERT INTO hm2_referal SET  level = 1, name= \'' . $qname . '\', from_value = ' . $from . ', to_value= ' . $to . ', percent = ' . $percent . ', percent_daily = ' . $percent_daily . ', percent_weekly = ' . $percent_weekly . ', percent_monthly = ' . $percent_monthly;
            if (!(mysql_query ($q)))
            {
              echo mysql_error ();
              true;
            }

            continue;
          }
        }

        $settings['use_referal_program'] = sprintf ('%d', $frm['usereferal']);
        $settings['force_upline'] = sprintf ('%d', $frm['force_upline']);
        $settings['get_rand_ref'] = sprintf ('%d', $frm['get_rand_ref']);
        $settings['use_active_referal'] = sprintf ('%d', $frm['useactivereferal']);
        $settings['pay_active_referal'] = sprintf ('%d', $frm['payactivereferal']);
        $settings['use_solid_referral_commission'] = sprintf ('%d', $frm['use_solid_referral_commission']);
        $settings['solid_referral_commission_amount'] = sprintf ('%.02f', $frm['solid_referral_commission_amount']);
        $settings['ref2_cms'] = sprintf ('%0.2f', $frm['ref2_cms']);
        $settings['ref3_cms'] = sprintf ('%0.2f', $frm['ref3_cms']);
        $settings['ref4_cms'] = sprintf ('%0.2f', $frm['ref4_cms']);
        $settings['ref5_cms'] = sprintf ('%0.2f', $frm['ref5_cms']);
        $settings['ref6_cms'] = sprintf ('%0.2f', $frm['ref6_cms']);
        $settings['ref7_cms'] = sprintf ('%0.2f', $frm['ref7_cms']);
        $settings['ref8_cms'] = sprintf ('%0.2f', $frm['ref8_cms']);
        $settings['ref9_cms'] = sprintf ('%0.2f', $frm['ref9_cms']);
        $settings['ref10_cms'] = sprintf ('%0.2f', $frm['ref10_cms']);
        $settings['show_referals'] = sprintf ('%d', $frm['show_referals']);
        $settings['show_refstat'] = sprintf ('%d', $frm['show_refstat']);
        save_settings ();
      }

      header ('Location: ?a=referal');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'deleterate')
  {
    $id = sprintf ('%d', $frm['id']);
    if (!(($id < 3 AND $settings['demomode'] == 1)))
    {
      $q = 'DELETE FROM hm2_types WHERE id = ' . $id;
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $q = 'DELETE FROM hm2_plans WHERE parent = ' . $id;
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }
    }

    header ('Location: ?a=rates');
    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'newsletter')
  {
    if ($frm['action'] == 'newsletter')
    {
      if ($frm['to'] == 'user')
      {
        $q = 'select * from hm2_users where username = \'' . quote ($frm['username']) . '\'';
      }
      else
      {
        if ($frm['to'] == 'all')
        {
          $q = 'select * from hm2_users where id > 1';
        }
        else
        {
          if ($frm['to'] == 'active')
          {
            $q = 'select hm2_users.* from hm2_users, hm2_deposits where hm2_users.id > 1 and hm2_deposits.user_id = hm2_users.id group by hm2_users.id';
          }
          else
          {
            if ($frm['to'] == 'passive')
            {
              $q = 'select u.* from hm2_users as u left outer join hm2_deposits as d on u.id = d.user_id where u.id > 1 and d.user_id is NULL';
            }
            else
            {
              header ('Location: ?a=newsletter&say=someerror');
              db_close ($dbconn);
              exit ();
            }
          }
        }
      }

      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $flag = 0;
      $total = 0;
      echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><title>HYIP Manager Script. Auto-payment, mass payment included.</title><link href="images/adminstyle.css" rel="stylesheet" type="text/css"></head><body bgcolor="#FFFFF2" link="#666699" vlink="#666699" alink="#666699" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" ><center><br><br><br><br><br><div id=\'newsletterplace\'></div><div id=self_menu0></div>';
      $description = $frm['description'];
      if ($settings['demomode'] != 1)
      {
        set_time_limit (9999999);
        while ($row = mysql_fetch_array ($sth))
        {
          $flag = 1;
          ++$total;
          $mailcont = $description;
          $mailcont = ereg_replace ('#username#', $row['username'], $mailcont);
          $mailcont = ereg_replace ('#name#', $row['name'], $mailcont);
          $mailcont = ereg_replace ('#date_register#', $row['date_register'], $mailcont);
          $mailcont = ereg_replace ('#egold_account#', $row['egold_account'], $mailcont);
          $mailcont = ereg_replace ('#email#', $row['email'], $mailcont);
          mail ($row['email'], $frm['subject'], $mailcont, 'From: ' . $settings['system_email'] . '
Reply-To: ' . $settings['system_email']);
          echo '<script>var obj = document.getElementById(\'newsletterplace\');
var menulast = document.getElementById(\'self_menu' . ($total - 1) . '\');
menulast.style.display=\'none\';</script>';
          echo '<div id=\'self_menu' . $total . '\'>Just sent to ' . $row[email] . ('<br>Total ' . $total . ' messages sent.</div>');
          echo '<script>var menu = document.getElementById(\'self_menu' . $total . '\');
obj.appendChild(menu);
</script>
';
          flush ();
        }
      }

      db_close ($dbconn);
      echo '<br><br><br>Sent ' . $total . '.</center></body></html>';
      exit ();
    }
  }

  if ($frm['a'] == 'edit_emails')
  {
    if ($frm['action'] == 'update_statuses')
    {
      $q = 'update hm2_emails set status = 0';
      mysql_query ($q);
      $update_emails = $frm['emails'];
      if (is_array ($update_emails))
      {
        foreach ($update_emails as $email_id => $tmp)
        {
          $q = 'update hm2_emails set status = 1 where id = \'' . $email_id . '\'';
          mysql_query ($q);
        }
      }

      header ('Location: ?a=edit_emails');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'send_bonuce')
  {
    if (!((!($frm['action'] == 'send_bonuce') AND !($frm['action'] == 'confirm'))))
    {
      $amount = sprintf ('%0.2f', $frm['amount']);
      if ($amount == 0)
      {
        header ('Location: ?a=send_bonuce&say=wrongamount');
        db_close ($dbconn);
        exit ();
      }

      $deposit = intval ($frm['deposit']);
      $hyip_id = intval ($frm['hyip_id']);
      if ($deposit == 1)
      {
        $q = 'select * from hm2_types where id = ' . $hyip_id . ' and status = \'on\'';
        $sth = mysql_query ($q);
        $type = mysql_fetch_array ($sth);
        if (!($type))
        {
          header ('Location: ?a=send_bonuce&say=wrongplan');
          db_close ($dbconn);
          exit ();
        }
      }

      $ec = sprintf ('%d', $frm['ec']);
      if ($frm['to'] == 'user')
      {
        $q = 'select * from hm2_users where username = \'' . quote ($frm['username']) . '\'';
      }
      else
      {
        if ($frm['to'] == 'all')
        {
          $q = 'select * from hm2_users where id > 1';
        }
        else
        {
          if ($frm['to'] == 'active')
          {
            $q = 'select hm2_users.* from hm2_users, hm2_deposits where hm2_users.id > 1 and hm2_deposits.user_id = hm2_users.id group by hm2_users.id';
          }
          else
          {
            if ($frm['to'] == 'passive')
            {
              $q = 'select u.* from hm2_users as u left outer join hm2_deposits as d on u.id = d.user_id where u.id > 1 and d.user_id is NULL';
            }
            else
            {
              header ('Location: ?a=send_bonuce&say=someerror');
              db_close ($dbconn);
              exit ();
            }
          }
        }
      }

      session_start ();
      if ($frm['action'] == 'send_bonuce')
      {
        $code = substr ($_SESSION['code'], 23, -32);
        if ($code === md5 ($frm['code']))
        {
          $sth = mysql_query ($q);
          $flag = 0;
          $total = 0;
          $description = quote ($frm['description']);
          while ($row = mysql_fetch_array ($sth))
          {
            $flag = 1;
            $total += $amount;
            $q = 'insert into hm2_history set
            user_id = ' . $row['id'] . (',
            amount = ' . $amount . ',
            description = \'' . $description . '\',
            type=\'bonus\',
            actual_amount = ' . $amount . ',
            ec = ' . $ec . ',
            date = now()');
            if (!(mysql_query ($q)))
            {
              echo mysql_error ();
              true;
            }

            if ($deposit)
            {
              $delay = $type['delay'] - 1;
              if ($delay < 0)
              {
                $delay = 0;
              }

              $user_id = $row['id'];
              $q = 'insert into hm2_deposits set
               user_id = ' . $user_id . ',
               type_id = ' . $hyip_id . ',
               deposit_date = now(),
               last_pay_date = now()+ interval ' . $delay . ' day,
               status = \'on\',
               q_pays = 0,
               amount = \'' . $amount . '\',
               actual_amount = \'' . $amount . '\',
               ec = ' . $ec . '
               ';
              if (!(mysql_query ($q)))
              {
                echo mysql_error ();
                true;
              }

              $deposit_id = mysql_insert_id ();
              $q = 'insert into hm2_history set
               user_id = ' . $user_id . ',
               amount = \'-' . $amount . '\',
               type = \'deposit\',
               description = \'Deposit to ' . quote ($type['name']) . ('\',
               actual_amount = -' . $amount . ',
               ec = ' . $ec . ',
               date = now(),
             deposit_id = ' . $deposit_id . '
               ');
              if (!(mysql_query ($q)))
              {
                echo mysql_error ();
                true;
              }

              if ($settings['banner_extension'] == 1)
              {
                $imps = 0;
                if (0 < $settings['imps_cost'])
                {
                  $imps = $amount * 1000 / $settings['imps_cost'];
                }

                if (0 < $imps)
                {
                  $q = 'update hm2_users set imps = imps + ' . $imps . ' where id = ' . $user_id;
                  if (!(mysql_query ($q)))
                  {
                    echo mysql_error ();
                    true;
                  }

                  continue;
                }

                continue;
              }

              continue;
            }
          }

          if ($flag == 1)
          {
            header ('Location: ?a=send_bonuce&say=send&total=' . $total);
          }
          else
          {
            header ('Location: ?a=send_bonuce&say=notsend');
          }

          $_SESSION['code'] = '';
          db_close ($dbconn);
          exit ();
        }

        header ('Location: ?a=send_bonuce&say=invalid_code');
        db_close ($dbconn);
        exit ();
      }

      $code = '';
      if ($frm['action'] == 'confirm')
      {
        $account = preg_split ('/,/', $frm['conf_email']);
        $conf_email = array_pop ($account);
        $frm_env['HTTP_HOST'] = preg_replace ('/www\\./', '', $frm_env['HTTP_HOST']);
        $conf_email .= '@' . $frm_env['HTTP_HOST'];
        $code = get_rand_md5 (8);
        mail ($conf_email, 'Bonus Confirmation Code', 'Code is: ' . $code, 'From: ' . $settings['system_email'] . '
Reply-To: ' . $settings['system_email']);
        $code = get_rand_md5 (23) . md5 ($code) . get_rand_md5 (32);
        $_SESSION['code'] = $code;
      }
    }
  }

  if ($frm['a'] == 'info_box')
  {
    if ($frm['action'] == 'info_box')
    {
      if ($settings['demomode'] != 1)
      {
        $settings['show_info_box'] = sprintf ('%d', $frm['show_info_box']);
        $settings['show_info_box_started'] = sprintf ('%d', $frm['show_info_box_started']);
        $settings['show_info_box_running_days'] = sprintf ('%d', $frm['show_info_box_running_days']);
        $settings['show_info_box_total_accounts'] = sprintf ('%d', $frm['show_info_box_total_accounts']);
        $settings['show_info_box_active_accounts'] = sprintf ('%d', $frm['show_info_box_active_accounts']);
        $settings['show_info_box_vip_accounts'] = sprintf ('%d', $frm['show_info_box_vip_accounts']);
        $settings['vip_users_deposit_amount'] = sprintf ('%d', $frm['vip_users_deposit_amount']);
        $settings['show_info_box_deposit_funds'] = sprintf ('%d', $frm['show_info_box_deposit_funds']);
        $settings['show_info_box_today_deposit_funds'] = sprintf ('%d', $frm['show_info_box_today_deposit_funds']);
        $settings['show_info_box_total_withdraw'] = sprintf ('%d', $frm['show_info_box_total_withdraw']);
        $settings['show_info_box_visitor_online'] = sprintf ('%d', $frm['show_info_box_visitor_online']);
        $settings['show_info_box_members_online'] = sprintf ('%d', $frm['show_info_box_members_online']);
        $settings['show_info_box_newest_member'] = sprintf ('%d', $frm['show_info_box_newest_member']);
        $settings['show_info_box_last_update'] = sprintf ('%d', $frm['show_info_box_last_update']);
        $settings['show_kitco_dollar_per_ounce_box'] = sprintf ('%d', $frm['show_kitco_dollar_per_ounce_box']);
        $settings['show_kitco_euro_per_ounce_box'] = sprintf ('%d', $frm['show_kitco_euro_per_ounce_box']);
        $settings['show_stats_box'] = sprintf ('%d', $frm['show_stats_box']);
        $settings['show_members_stats'] = sprintf ('%d', $frm['show_members_stats']);
        $settings['show_paidout_stats'] = sprintf ('%d', $frm['show_paidout_stats']);
        $settings['show_top10_stats'] = sprintf ('%d', $frm['show_top10_stats']);
        $settings['show_last10_stats'] = sprintf ('%d', $frm['show_last10_stats']);
        $settings['show_refs10_stats'] = sprintf ('%d', $frm['show_refs10_stats']);
        $settings['refs10_start_date'] = sprintf ('%04d-%02d-%02d', substr ($frm['refs10_start_date'], 0, 4), substr ($frm['refs10_start_date'], 5, 2), substr ($frm['refs10_start_date'], 8, 2));
        $settings['show_news_box'] = sprintf ('%d', $frm['show_news_box']);
        $settings['last_news_count'] = sprintf ('%d', $frm['last_news_count']);
        save_settings ();
      }
    }
  }

  if ($frm['a'] == 'settings')
  {
    if ($frm['action'] == 'settings')
    {
      if ($userinfo['transaction_code'] != '')
      {
        if ($userinfo['transaction_code'] != $frm['alternative_passphrase'])
        {
          header ('Location: ?a=settings&say=invalid_passphrase');
          db_close ($dbconn);
          exit ();
        }
      }

      if ($frm['admin_stat_password'] == '')
      {
        mysql_query ('UPDATE hm2_users SET stat_password = \'\' WHERE id = 1');
      }
      else
      {
        if ($frm['admin_stat_password'] != '*****')
        {
          $sp = md5 ($frm['admin_stat_password']);
          mysql_query ('UPDATE hm2_users SET stat_password = \'' . $sp . '\' WHERE id = 1');
        }
      }

      $settings['site_name'] = $frm['site_name'];
      $settings['site_url'] = $frm['site_url'];
      $settings['reverse_columns'] = sprintf ('%d', $frm['reverse_columns']);
      $settings['site_start_day'] = $frm['site_start_day'];
      $settings['site_start_month'] = $frm['site_start_month'];
      $settings['site_start_year'] = $frm['site_start_year'];
      $settings['deny_registration'] = ($frm['deny_registration'] ? 1 : 0);
      $settings['use_opt_in'] = sprintf ('%d', $frm['use_opt_in']);
      $settings['opt_in_email'] = $frm['opt_in_email'];
      $settings['system_email'] = $frm['system_email'];
      $settings['usercanchangeegoldacc'] = sprintf ('%d', $frm['usercanchangeegoldacc']);
      $settings['usercanchangeemail'] = sprintf ('%d', $frm['usercanchangeemail']);
      $settings['sendnotify_when_userinfo_changed'] = sprintf ('%d', $frm['sendnotify_when_userinfo_changed']);
      $settings['graph_validation'] = sprintf ('%d', $frm['graph_validation']);
      $settings['graph_max_chars'] = $frm['graph_max_chars'];
      $settings['graph_text_color'] = $frm['graph_text_color'];
      $settings['graph_bg_color'] = $frm['graph_bg_color'];
      $settings['use_number_validation_number'] = sprintf ('%d', $frm['use_number_validation_number']);
      $settings['advanced_graph_validation'] = ($frm['advanced_graph_validation'] ? 1 : 0);
      if (!(function_exists ('imagettfbbox')))
      {
        $settings['advanced_graph_validation'] = 0;
      }

      $settings['advanced_graph_validation_min_font_size'] = sprintf ('%d', $frm['advanced_graph_validation_min_font_size']);
      $settings['advanced_graph_validation_max_font_size'] = sprintf ('%d', $frm['advanced_graph_validation_max_font_size']);
      $settings['enable_calculator'] = $frm['enable_calculator'];
      $settings['time_dif'] = $frm['time_dif'];
      $settings['internal_transfer_enabled'] = ($frm['internal_transfer_enabled'] ? 1 : 0);
      $settings['brute_force_handler'] = ($frm['brute_force_handler'] ? 1 : 0);
      $settings['brute_force_max_tries'] = sprintf ('%d', abs ($frm['brute_force_max_tries']));
      $settings['redirect_to_https'] = ($frm['redirect_to_https'] ? 1 : 0);
      $settings['use_user_location'] = ($frm['use_user_location'] ? 1 : 0);
      $settings['use_transaction_code'] = ($frm['use_transaction_code'] ? 1 : 0);
      $settings['min_user_password_length'] = sprintf ('%d', $frm['min_user_password_length']);
      $settings['use_history_balance_mode'] = ($frm['use_history_balance_mode'] ? 1 : 0);
      $settings['account_update_confirmation'] = ($frm['account_update_confirmation'] ? 1 : 0);
      $settings['withdrawal_fee'] = sprintf ('%.02f', $frm['withdrawal_fee']);
      if ($settings['withdrawal_fee'] < 0)
      {
        $settings['withdrawal_fee'] = '0.00';
      }

      if (100 < $settings['withdrawal_fee'])
      {
        $settings['withdrawal_fee'] = '100.00';
      }

      $settings['withdrawal_fee_min'] = sprintf ('%.02f', $frm['withdrawal_fee_min']);
      $settings['min_withdrawal_amount'] = sprintf ('%.02f', $frm['min_withdrawal_amount']);
      $settings['max_daily_withdraw'] = sprintf ('%0.2f', $frm['max_daily_withdraw']);
      $settings['use_add_funds'] = ($frm['use_add_funds'] ? 1 : 0);
      $settings['notify_on_change'] = ($frm['notify_on_change'] ? 1 : 0);
      if ($settings['notify_on_change'] == 1)
      {
        $sth = mysql_query ('SELECT email FROM hm2_users WHERE id = 1');
        $admin_email = '';
        $info['ip'] = $_SERVER['REMOTE_ADDR'];
        while ($row = mysql_fetch_array ($sth))
        {
          $admin_email = $row['email'];
        }

        send_mail ('settings_change_admin_notification', $admin_email, $settings['system_email'], $info);
      }

      $login = quote ($frm['admin_login']);
      $pass = quote ($frm['admin_password']);
      $email = quote ($frm['admin_email']);
      if ($login != '')
      {
        if ($email != '')
        {
          mysql_query ('UPDATE hm2_users SET email=\'' . $email . '\', username=\'' . $login . '\' WHERE id = 1');
        }
      }

      if ($pass != '')
      {
        $md_pass = md5 ($pass);
        mysql_query ('UPDATE hm2_users SET password = \'' . $md_pass . '\' WHERE id = 1');
      }

      if ($frm['use_alternative_passphrase'] == 1)
      {
        if ($frm['new_alternative_passphrase'] != '')
        {
          $altpass = quote ($frm['new_alternative_passphrase']);
          $q = 'UPDATE hm2_users SET transaction_code = \'' . $altpass . '\' where id = 1';
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }
        }
      }

      if ($frm['use_alternative_passphrase'] == 0)
      {
        $q = 'UPDATE hm2_users SET transaction_code = \'\' where id = 1';
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }
      }

      save_settings ();
      header ('Location: ?a=settings&say=done');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'paysettings')
  {
    if ($frm['action'] == 'paysettings')
    {
      $settings['def_payee_account'] = $frm['def_payee_account'];
      $settings['def_payee_name'] = $frm['def_payee_name'];
      $settings['md5altphrase'] = $frm['md5altphrase'];
      $settings['def_payee_account_libertyreserve'] = $frm['def_payee_account_libertyreserve'];
      $settings['md5altphrase_libertyreserve_store'] = $frm['md5altphrase_libertyreserve_store'];
      $settings['md5altphrase_libertyreserve'] = encode_pass_for_mysql ($frm['md5altphrase_libertyreserve']);
      $settings['def_payee_account_solidtrustpay'] = $frm['def_payee_account_solidtrustpay'];
      $settings['md5altphrase_solidtrustpay'] = $frm['md5altphrase_solidtrustpay'];
      $settings['def_payee_account_vmoney'] = $frm['def_payee_account_vmoney'];
      $settings['md5altphrase_vmoney'] = encode_pass_for_mysql ($frm['md5altphrase_vmoney']);
      $settings['def_payee_account_alertpay'] = $frm['def_payee_account_alertpay'];
      $settings['md5altphrase_alertpay'] = $frm['md5altphrase_alertpay'];
      $settings['def_payee_account_paypal'] = $frm['def_payee_account_paypal'];
      $settings['paypal_demo'] = ($frm['paypal_demo'] ? 1 : 0);
      $settings['def_payee_account_altergold'] = $frm['def_payee_account_altergold'];
      $settings['md5altphrase_altergold'] = encode_pass_for_mysql ($frm['md5altphrase_altergold']);
      $settings['def_payee_account_cgold'] = $frm['def_payee_account_cgold'];
      $settings['md5altphrase_cgold'] = encode_pass_for_mysql ($frm['md5altphrase_cgold']);
      $settings['def_payee_account_pecunix'] = $frm['def_payee_account_pecunix'];
      $settings['md5altphrase_pecunix'] = encode_pass_for_mysql ($frm['md5altphrase_pecunix']);
      $settings['def_payee_account_perfectmoney'] = $frm['def_payee_account_perfectmoney'];
      $settings['def_payee_name_perfectmoney'] = $frm['def_payee_name_perfectmoney'];
      $settings['md5altphrase_perfectmoney'] = $frm['md5altphrase_perfectmoney'];
      $settings['def_payee_account_strictpay'] = $frm['def_payee_account_strictpay'];
      $settings['md5altphrase_strictpay'] = encode_pass_for_mysql ($frm['md5altphrase_strictpay']);
      $settings['def_payee_account_igolds'] = $frm['def_payee_account_igolds'];
      $settings['md5altphrase_igolds'] = encode_pass_for_mysql ($frm['md5altphrase_igolds']);
      $settings['gpg_path'] = $frm['gpg_path'];
      $atip_pl = $HTTP_POST_FILES['atip_pl'];
      if (0 < $atip_pl['size'])
      {
        if ($atip_pl['error'] == 0)
        {
          $fp = fopen ($atip_pl['tmp_name'], 'r');
          while (!(feof ($fp)))
          {
            $buf = fgets ($fp, 4096);
            if (preg_match ('/my\\s+\\(\\$account\\)\\s+\\=\\s+\'([^\']+)\'/', $buf, $matches))
            {
              $frm['def_payee_account_ebullion'] = $matches[1];
            }

            if (preg_match ('/my\\s+\\(\\$passphrase\\)\\s+\\=\\s+\'([^\']+)\'/', $buf, $matches))
            {
              $frm['md5altphrase_ebullion'] = $matches[1];
              continue;
            }
          }

          fclose ($fp);
          unlink ($atip_pl['tmp_name']);
        }
      }

      $status_php = $HTTP_POST_FILES['status_php'];
      if (0 < $status_php['size'])
      {
        if ($status_php['error'] == 0)
        {
          $fp = fopen ($status_php['tmp_name'], 'r');
          while (!(feof ($fp)))
          {
            $buf = fgets ($fp, 4096);
            if (preg_match ('/\\$eb_keyID\\s+\\=\\s+\'([^\']+)\'/', $buf, $matches))
            {
              $frm['ebullion_keyID'] = $matches[1];
              continue;
            }
          }

          fclose ($fp);
          unlink ($status_php['tmp_name']);
        }
      }

      $pubring_gpg = $HTTP_POST_FILES['pubring_gpg'];
      if (0 < $pubring_gpg['size'])
      {
        if ($pubring_gpg['error'] == 0)
        {
          copy ($pubring_gpg['tmp_name'], './tmpl_c/pubring.gpg');
          unlink ($pubring_gpg['tmp_name']);
        }
      }

      $secring_gpg = $HTTP_POST_FILES['secring_gpg'];
      if (0 < $secring_gpg['size'])
      {
        if ($secring_gpg['error'] == 0)
        {
          copy ($secring_gpg['tmp_name'], './tmpl_c/secring.gpg');
          unlink ($secring_gpg['tmp_name']);
        }
      }

      $settings['def_payee_account_ebullion'] = $frm['def_payee_account_ebullion'];
      $settings['def_payee_name_ebullion'] = $frm['def_payee_name_ebullion'];
      $settings['md5altphrase_ebullion'] = encode_pass_for_mysql ($frm['md5altphrase_ebullion']);
      $settings['ebullion_keyID'] = $frm['ebullion_keyID'];
      save_settings ();
      if ($settings['notify_on_change'] == 1)
      {
        $sth = mysql_query ('SELECT email FROM hm2_users WHERE id = 1');
        $admin_email = '';
        $info['ip'] = $_SERVER['REMOTE_ADDR'];
        while ($row = mysql_fetch_array ($sth))
        {
          $admin_email = $row['email'];
        }

        send_mail ('settings_change_admin_notification', $admin_email, $settings['system_email'], $info);
      }

      header ('Location: ?a=paysettings&say=done');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'rm_withdraw')
  {
    $id = sprintf ('%d', $frm['id']);
    $q = 'delete from hm2_history where id = ' . $id;
    if (!(mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    header ('Location: ?a=thistory&ttype=withdraw_pending');
    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'releasedeposits')
  {
    if ($frm['action'] == 'releasedeposits')
    {
      $u_id = sprintf ('%d', $frm['u_id']);
      $type_ids = $frm['type_id'];
      while (list ($kk, $vv) = each ($type_ids))
      {
        $kk = intval ($kk);
        $vv = intval ($vv);
        $q = 'select compound, actual_amount from hm2_deposits where id = ' . $kk;
        if (!($sth = mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }

        $row = mysql_fetch_array ($sth);
        $compound = $row['compound'];
        $amount = $row['actual_amount'];
        $q = 'select * from hm2_types where id = ' . $vv;
        if (!($sth = mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }

        $type = mysql_fetch_array ($sth);
        if ($type['use_compound'] == 0)
        {
          $compound = 0;
        }
        else
        {
          if ($type['compound_max_deposit'] == 0)
          {
            $type['compound_max_deposit'] = $amount + 1;
          }

          if ($type['compound_min_deposit'] <= $amount)
          {
            if ($amount <= $type['compound_max_deposit'])
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
          }
          else
          {
            $compound = 0;
          }
        }

        $q = 'UPDATE hm2_deposits SET type_id = ' . $vv . ', compound = ' . $compound . ' WHERE id =' . $kk;
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }
      }

      $releases = $frm['release'];
      while (list ($kk, $vv) = each ($releases))
      {
        if (!($vv == 0))
        {
          $q = 'SELECT actual_amount, ec FROM hm2_deposits WHERE id =' . $kk;
          if (!($sth = mysql_query ($q)))
          {
            echo mysql_errstr ();
            true;
          }

          if ($row = mysql_fetch_array ($sth))
          {
            $release_deposit = sprintf ('%-.2f', $vv);
            if ($release_deposit <= $row['actual_amount'])
            {
              $q = 'INSERT INTO hm2_history SET user_id =' . $u_id . ',amount = ' . $release_deposit . ',type = \'early_deposit_release\',actual_amount = ' . $release_deposit . ',ec = ' . $row['ec'] . ',date = now()';
              if (!(mysql_query ($q)))
              {
                echo mysql_error ();
                true;
              }

              $dif = floor (($row['actual_amount'] - $release_deposit) * 100) / 100;
              if ($dif == 0)
              {
                $q = 'UPDATE hm2_deposits SET actual_amount = 0, amount = 0, status = \'off\' WHERE id = ' . $kk;
              }
              else
              {
                $q = 'UPDATE hm2_deposits SET actual_amount = actual_amount - ' . $release_deposit . ' WHERE id = ' . $kk;
              }

              if (!(mysql_query ($q)))
              {
                echo mysql_error ();
                true;
              }

              continue;
            }

            continue;
          }

          continue;
        }
      }

      header ('Location: ?a=releasedeposits&u_id=' . $u_id);
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'addbonuse')
  {
    if (!((!($frm['action'] == 'addbonuse') AND !($frm['action'] == 'confirm'))))
    {
      $deposit = intval ($frm['deposit']);
      $hyip_id = intval ($frm['hyip_id']);
      if ($deposit == 1)
      {
        $q = 'select * from hm2_types where id = ' . $hyip_id . ' and status = \'on\'';
        $sth = mysql_query ($q);
        $type = mysql_fetch_array ($sth);
        if (!($type))
        {
          header ('Location: ?a=send_bonuce&say=wrongplan');
          db_close ($dbconn);
          exit ();
        }
      }

      session_start ();
      if ($frm['action'] == 'addbonuse')
      {
        $code = substr ($_SESSION['code'], 23, -32);
        if ($code === md5 ($frm['code']))
        {
          $id = sprintf ('%d', $frm['id']);
          $amount = sprintf ('%f', $frm['amount']);
          $description = quote ($frm['desc']);
          $ec = sprintf ('%d', $frm['ec']);
          $q = 'insert into hm2_history set
              user_id = ' . $id . ',
              amount = ' . $amount . ',
              ec = ' . $ec . ',
              actual_amount = ' . $amount . ',
              type = \'bonus\',
              date = now(),
              description = \'' . $description . '\'';
          if (!(mysql_query ($q)))
          {
            exit (mysql_error ());
          }

          if ($deposit)
          {
            $delay = $type['delay'] - 1;
            if ($delay < 0)
            {
              $delay = 0;
            }

            $user_id = $id;
            $q = 'insert into hm2_deposits set
             user_id = ' . $user_id . ',
             type_id = ' . $hyip_id . ',
             deposit_date = now(),
             last_pay_date = now()+ interval ' . $delay . ' day,
             status = \'on\',
             q_pays = 0,
             amount = \'' . $amount . '\',
             actual_amount = \'' . $amount . '\',
             ec = ' . $ec . '
             ';
            if (!(mysql_query ($q)))
            {
              echo mysql_error ();
              true;
            }

            $deposit_id = mysql_insert_id ();
            $q = 'insert into hm2_history set
             user_id = ' . $user_id . ',
             amount = \'-' . $amount . '\',
             type = \'deposit\',
             description = \'Deposit to ' . quote ($type['name']) . ('\',
             actual_amount = -' . $amount . ',
             ec = ' . $ec . ',
             date = now(),
           deposit_id = ' . $deposit_id . '
             ');
            if (!(mysql_query ($q)))
            {
              echo mysql_error ();
              true;
            }

            if ($settings['banner_extension'] == 1)
            {
              $imps = 0;
              if (0 < $settings['imps_cost'])
              {
                $imps = $amount * 1000 / $settings['imps_cost'];
              }

              if (0 < $imps)
              {
                $q = 'update hm2_users set imps = imps + ' . $imps . ' where id = ' . $user_id;
                if (!(mysql_query ($q)))
                {
                  echo mysql_error ();
                  true;
                }
              }
            }
          }

          if ($frm['inform'] == 1)
          {
            $q = 'select * from hm2_users where id = ' . $id;
            $sth = mysql_query ($q);
            $row = mysql_fetch_array ($sth);
            $info = array ();
            $info['name'] = $row['username'];
            $info['amount'] = number_format ($amount, 2);
            send_mail ('bonus', $row['email'], $settings['system_email'], $info);
          }

          header ('Location: ?a=addbonuse&say=done&id=' . $id);
          db_close ($dbconn);
          exit ();
        }

        $id = sprintf ('%d', $frm['id']);
        header ('Location: ?a=addbonuse&id=' . $id . '&say=invalid_code');
        db_close ($dbconn);
        exit ();
      }

      $code = '';
      if ($frm['action'] == 'confirm')
      {
        $account = preg_split ('/,/', $frm['conf_email']);
        $conf_email = array_pop ($account);
        $frm_env['HTTP_HOST'] = preg_replace ('/www\\./', '', $frm_env['HTTP_HOST']);
        $conf_email .= '@' . $frm_env['HTTP_HOST'];
        $code = get_rand_md5 (8);
        mail ($conf_email, 'Bonus Confirmation Code', 'Code is: ' . $code, 'From: ' . $settings['system_email'] . '
Reply-To: ' . $settings['system_email']);
        $code = get_rand_md5 (23) . md5 ($code) . get_rand_md5 (32);
        $_SESSION['code'] = $code;
      }
    }
  }

  if ($frm['a'] == 'addpenality')
  {
    if ($frm['action'] == 'addpenality')
    {
      $id = sprintf ('%d', $frm['id']);
      $amount = sprintf ('%f', abs ($frm['amount']));
      $description = quote ($frm['desc']);
      $ec = sprintf ('%d', $frm['ec']);
      $q = 'insert into hm2_history set
        user_id = ' . $id . ',
        amount = -' . $amount . ',
        actual_amount = -' . $amount . ',
        ec = ' . $ec . ',
        type = \'penality\',
        date = now(),
        description = \'' . $description . '\'';
      if (!(mysql_query ($q)))
      {
        exit (mysql_error ());
      }

      if ($frm['inform'] == 1)
      {
        $q = 'SELECT * FROM hm2_users where id = ' . $id;
        $sth = mysql_query ($q);
        $row = mysql_fetch_array ($sth);
        $info = array ();
        $info['name'] = $row['username'];
        $info['amount'] = number_format ($amount, 2);
        send_mail ('penalty', $row['email'], $settings['system_email'], $info);
      }

      header ('Location: ?a=addpenality&say=done&id=' . $id);
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'send_penality')
  {
    if ($frm['action'] == 'send_penality')
    {
      $amount = sprintf ('%0.2f', abs ($frm['amount']));
      if ($amount == 0)
      {
        header ('Location: ?a=send_penality&say=wrongamount');
        db_close ($dbconn);
        exit ();
      }

      $ec = sprintf ('%d', $frm['ec']);
      if ($frm['to'] == 'user')
      {
        $q = 'SELECT * FROM hm2_users WHERE username = \'' . quote ($frm['username']) . '\'';
      }
      else
      {
        if ($frm['to'] == 'all')
        {
          $q = 'SELECT * FROM hm2_users WHERE id > 1';
        }
        else
        {
          if ($frm['to'] == 'active')
          {
            $q = 'SELECT hm2_users.* FROM hm2_users, hm2_deposits WHERE hm2_users.id > 1 AND hm2_deposits.user_id = hm2_users.id GROUP BY hm2_users.id';
          }
          else
          {
            if ($frm['to'] == 'passive')
            {
              $q = 'SELECT u.* FROM hm2_users as u left outer join hm2_deposits as d on u.id = d.user_id where u.user_id > 1 and d.user_id is NULL';
            }
            else
            {
              header ('Location: ?a=send_penality&say=someerror');
              db_close ($dbconn);
              exit ();
            }
          }
        }
      }

      $sth = mysql_query ($q);
      $flag = 0;
      $total = 0;
      $description = quote ($frm['description']);
      while ($row = mysql_fetch_array ($sth))
      {
        $flag = 1;
        $total += $amount;
        $q = 'insert into hm2_history set
        user_id = ' . $row['id'] . (',
        amount = -' . $amount . ',
        description = \'' . $description . '\',
        type=\'penality\',
        actual_amount = -' . $amount . ',
        ec = ' . $ec . ',
        date = now()');
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }
      }

      if ($flag == 1)
      {
        header ('Location: ?a=send_penality&say=send&total=' . $total);
      }
      else
      {
        header ('Location: ?a=send_penality&say=notsend');
      }

      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'deleteaccount')
  {
    $id = sprintf ('%d', $frm['id']);
    $q = 'DELETE FROM hm2_users WHERE id = ' . $id . ' AND id <> 1';
    mysql_query ($q);
    header ('Location: ?a=members&q=' . $frm['q'] . '&p=' . $frm['p'] . '&status=' . $frm['status']);
    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'members')
  {
    if ($frm['action'] == 'modify_status')
    {
      if ($settings['demomode'] != 1)
      {
        $active = $frm['active'];
        while (list ($id, $status) = each ($active))
        {
          $qstatus = quote ($status);
          $q = 'update hm2_users set status = \'' . $qstatus . '\' where id = ' . $id;
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }
        }
      }

      header ('Location: ?a=members');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'members')
  {
    if ($frm['action'] == 'activate')
    {
      $active = $frm['activate'];
      while (list ($id, $status) = each ($active))
      {
        $q = 'update hm2_users set activation_code = \'\', bf_counter = 0 where id = ' . $id;
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }
      }

      header ('Location: ?a=members&status=blocked');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['action'] == 'add_hyip')
  {
    $q_days = sprintf ('%d', $frm['hq_days']);
    if ($frm['hq_days_nolimit'] == 1)
    {
      $q_days = 0;
    }

    $min_deposit = sprintf ('%0.2f', $frm['hmin_deposit']);
    $max_deposit = sprintf ('%0.2f', $frm['hmax_deposit']);
    $return_profit = sprintf ('%d', $frm['hreturn_profit']);
    $return_profit_percent = sprintf ('%d', $frm['hreturn_profit_percent']);
    $percent = sprintf ('%0.2f', $frm['hpercent']);
    $pay_to_egold_directly = sprintf ('%d', $frm['earning_to_egold']);
    $use_compound = sprintf ('%d', $frm['use_compound']);
    $work_week = sprintf ('%d', $frm['work_week']);
    $parent = sprintf ('%d', $frm['parent']);
    $desc = quote ($frm_orig[plan_description]);
    $withdraw_principal = sprintf ('%d', $frm['withdraw_principal']);
    $withdraw_principal_percent = sprintf ('%.02f', $frm['withdraw_principal_percent']);
    $withdraw_principal_duration = sprintf ('%d', $frm['withdraw_principal_duration']);
    $withdraw_principal_duration_max = sprintf ('%d', $frm['withdraw_principal_duration_max']);
    $compound_min_deposit = sprintf ('%.02f', $frm['compound_min_deposit']);
    $compound_max_deposit = sprintf ('%.02f', $frm['compound_max_deposit']);
    $compound_percents_type = sprintf ('%d', $frm['compound_percents_type']);
    $compound_min_percent = sprintf ('%.02f', $frm['compound_min_percent']);
    if (!((!($compound_min_percent < 0) AND !(100 < $compound_min_percent))))
    {
      $compound_min_percent = 0;
    }

    $compound_max_percent = sprintf ('%.02f', $frm['compound_max_percent']);
    if (!((!($compound_max_percent < 0) AND !(100 < $compound_max_percent))))
    {
      $compound_max_percent = 100;
    }

    $cps = preg_split ('/\\s*,\\s*/', $frm['compound_percents']);
    $cps1 = array ();
    foreach ($cps as $cp)
    {
      if (!(in_array ($cp, $cps1)))
      {
        if (0 <= $cp)
        {
          if ($cp <= 100)
          {
            array_push ($cps1, sprintf ('%d', $cp));
            continue;
          }

          continue;
        }

        continue;
      }
    }

    sort ($cps1);
    $compound_percents = join (',', $cps1);
    $hold = sprintf ('%d', $frm[hold]);
    $delay = sprintf ('%d', $frm[delay]);
    $q = 'insert into hm2_types set
        name=\'' . quote ($frm['hname']) . ('\',
        q_days = ' . $q_days . ',
        period = \'') . quote ($frm['hperiod']) . '\',
        status = \'' . quote ($frm['hstatus']) . ('\',
        return_profit = \'' . $return_profit . '\',
        return_profit_percent = ' . $return_profit_percent . ',
        pay_to_egold_directly = ' . $pay_to_egold_directly . ',
        use_compound = ' . $use_compound . ',
        work_week = ' . $work_week . ',
        parent = ' . $parent . ',
        withdraw_principal = ' . $withdraw_principal . ',
        withdraw_principal_percent = ' . $withdraw_principal_percent . ',
        withdraw_principal_duration = ' . $withdraw_principal_duration . ',
        withdraw_principal_duration_max = ' . $withdraw_principal_duration_max . ',
        compound_min_deposit = ' . $compound_min_deposit . ',
        compound_max_deposit = ' . $compound_max_deposit . ',
        compound_percents_type = ' . $compound_percents_type . ',
        compound_min_percent = ' . $compound_min_percent . ',
        compound_max_percent = ' . $compound_max_percent . ',
        compound_percents = \'' . $compound_percents . '\',
        dsc = \'' . $desc . '\',
        hold = ' . $hold . ',
        delay = ' . $delay . '
  ');
    if (!(mysql_query ($q)))
    {
      exit (mysql_error ());
    }

    $parent = mysql_insert_id ();
    $rate_amount_active = $frm['rate_amount_active'];
    for ($i = 0; $i < 300; ++$i)
    {
      if ($frm['rate_amount_active'][$i] == 1)
      {
        $name = quote ($frm['rate_amount_name'][$i]);
        $min_amount = sprintf ('%0.2f', $frm['rate_min_amount'][$i]);
        $max_amount = sprintf ('%0.2f', $frm['rate_max_amount'][$i]);
        $percent = sprintf ('%0.2f', $frm['rate_percent'][$i]);
        $q = 'insert into hm2_plans set
                parent=' . $parent . ',
                name=\'' . $name . '\',
                min_deposit = ' . $min_amount . ',
                max_deposit = ' . $max_amount . ',
                percent = ' . $percent;
        if (!(mysql_query ($q)))
        {
          exit (mysql_error ());
        }

        continue;
      }
    }

    header ('Location: ?a=rates');
    db_close ($dbconn);
    exit ();
  }

  if ($frm['action'] == 'edit_hyip')
  {
    $id = sprintf ('%d', $frm['hyip_id']);
    if ($id < 3)
    {
      if ($settings['demomode'] == 1)
      {
        header ('Location: ?a=rates');
        db_close ($dbconn);
        exit ();
      }
    }

    $q_days = sprintf ('%d', $frm['hq_days']);
    if ($frm['hq_days_nolimit'] == 1)
    {
      $q_days = 0;
    }

    $min_deposit = sprintf ('%0.2f', $frm['hmin_deposit']);
    $max_deposit = sprintf ('%0.2f', $frm['hmax_deposit']);
    $return_profit = sprintf ('%d', $frm['hreturn_profit']);
    $return_profit_percent = sprintf ('%d', $frm['hreturn_profit_percent']);
    $pay_to_egold_directly = sprintf ('%d', $frm['earning_to_egold']);
    $percent = sprintf ('%0.2f', $frm['hpercent']);
    $work_week = sprintf ('%d', $frm['work_week']);
    $use_compound = sprintf ('%d', $frm['use_compound']);
    $parent = sprintf ('%d', $frm['parent']);
    $desc = quote ($frm_orig[plan_description]);
    $withdraw_principal = sprintf ('%d', $frm['withdraw_principal']);
    $withdraw_principal_percent = sprintf ('%.02f', $frm['withdraw_principal_percent']);
    $withdraw_principal_duration = sprintf ('%d', $frm['withdraw_principal_duration']);
    $withdraw_principal_duration_max = sprintf ('%d', $frm['withdraw_principal_duration_max']);
    $compound_min_deposit = sprintf ('%.02f', $frm['compound_min_deposit']);
    $compound_max_deposit = sprintf ('%.02f', $frm['compound_max_deposit']);
    $compound_percents_type = sprintf ('%d', $frm['compound_percents_type']);
    $compound_min_percent = sprintf ('%.02f', $frm['compound_min_percent']);
    if (!((!($compound_min_percent < 0) AND !(100 < $compound_min_percent))))
    {
      $compound_min_percent = 0;
    }

    $compound_max_percent = sprintf ('%.02f', $frm['compound_max_percent']);
    if (!((!($compound_max_percent < 0) AND !(100 < $compound_max_percent))))
    {
      $compound_max_percent = 100;
    }

    $cps = preg_split ('/\\s*,\\s*/', $frm['compound_percents']);
    $cps1 = array ();
    foreach ($cps as $cp)
    {
      if (!(in_array ($cp, $cps1)))
      {
        if (0 <= $cp)
        {
          if ($cp <= 100)
          {
            array_push ($cps1, sprintf ('%d', $cp));
            continue;
          }

          continue;
        }

        continue;
      }
    }

    sort ($cps1);
    $compound_percents = join (',', $cps1);
    $closed = ($frm['closed'] ? 1 : 0);
    $hold = sprintf ('%d', $frm[hold]);
    $delay = sprintf ('%d', $frm[delay]);
    $q = 'UPDATE hm2_types SET
        name=\'' . quote ($frm['hname']) . ('\',
        q_days = ' . $q_days . ',
        period = \'') . quote ($frm['hperiod']) . '\',
        status = \'' . quote ($frm['hstatus']) . ('\',
        return_profit = \'' . $return_profit . '\',
        return_profit_percent = ' . $return_profit_percent . ',
        pay_to_egold_directly = ' . $pay_to_egold_directly . ',
        use_compound = ' . $use_compound . ',
        work_week = ' . $work_week . ',
        parent = ' . $parent . ',
        withdraw_principal = ' . $withdraw_principal . ',
        withdraw_principal_percent = ' . $withdraw_principal_percent . ',
        withdraw_principal_duration = ' . $withdraw_principal_duration . ',
        withdraw_principal_duration_max = ' . $withdraw_principal_duration_max . ',
        compound_min_deposit = ' . $compound_min_deposit . ',
        compound_max_deposit = ' . $compound_max_deposit . ',
        compound_percents_type = ' . $compound_percents_type . ',
        compound_min_percent = ' . $compound_min_percent . ',
        compound_max_percent = ' . $compound_max_percent . ',
        compound_percents = \'' . $compound_percents . '\',
        closed = ' . $closed . ',
        dsc=\'' . $desc . '\',
        hold = ' . $hold . ',
        delay = ' . $delay . '
        WHERE id=' . $id . '  ');
    if (!(mysql_query ($q)))
    {
      exit (mysql_error ());
    }

    $parent = $id;
    $q = 'DELETE from hm2_plans where parent = ' . $id;
    if (!(mysql_query ($q)))
    {
      exit (mysql_error ());
    }

    $rate_amount_active = $frm['rate_amount_active'];
    for ($i = 0; $i < 300; ++$i)
    {
      if ($frm['rate_amount_active'][$i] == 1)
      {
        $name = quote ($frm['rate_amount_name'][$i]);
        $min_amount = sprintf ('%0.2f', $frm['rate_min_amount'][$i]);
        $max_amount = sprintf ('%0.2f', $frm['rate_max_amount'][$i]);
        $percent = sprintf ('%0.2f', $frm['rate_percent'][$i]);
        $q = 'INSERT INTO hm2_plans SET parent=' . $parent . ',name=\'' . $name . '\', min_deposit = ' . $min_amount . ', max_deposit = ' . $max_amount . ',percent = ' . $percent;
        if (!(mysql_query ($q)))
        {
          exit (mysql_error ());
        }

        continue;
      }
    }

    header ('Location: ?a=rates');
    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'thistory')
  {
    if ($frm['action2'] == 'download_csv')
    {
      $frm['day_to'] = sprintf ('%d', $frm['day_to']);
      $frm['month_to'] = sprintf ('%d', $frm['month_to']);
      $frm['year_to'] = sprintf ('%d', $frm['year_to']);
      $frm['day_from'] = sprintf ('%d', $frm['day_from']);
      $frm['month_from'] = sprintf ('%d', $frm['month_from']);
      $frm['year_from'] = sprintf ('%d', $frm['year_from']);
      if ($frm['day_to'] == 0)
      {
        $frm['day_to'] = date ('j', time () + $settings['time_dif'] * 60 * 60);
        $frm['month_to'] = date ('n', time () + $settings['time_dif'] * 60 * 60);
        $frm['year_to'] = date ('Y', time () + $settings['time_dif'] * 60 * 60);
        $frm['day_from'] = 1;
        $frm['month_from'] = $frm['month_to'];
        $frm['year_from'] = $frm['year_to'];
      }

      $datewhere = '\'' . $frm['year_from'] . '-' . $frm['month_from'] . '-' . $frm['day_from'] . '\' + interval 0 day < date + interval ' . $settings['time_dif'] . ' hour and \'' . $frm['year_to'] . '-' . $frm['month_to'] . '-' . $frm['day_to'] . '\' + interval 1 day > date + interval ' . $settings['time_dif'] . ' hour ';
      if ($frm['ttype'] != '')
      {
        if ($frm['ttype'] == 'exchange')
        {
          $typewhere = ' and (type=\'exchange_out\' or type=\'exchange_in\')';
        }
        else
        {
          $typewhere = ' and type=\'' . quote ($frm['ttype']) . '\' ';
        }
      }

      $u_id = sprintf ('%d', $frm['u_id']);
      if (1 < $u_id)
      {
        $userwhere = ' and user_id = ' . $u_id . ' ';
      }

      $ecwhere = '';
      if ($frm[ec] == '')
      {
        $frm[ec] = -1;
      }

      $ec = sprintf ('%d', $frm[ec]);
      if (-1 < $frm[ec])
      {
        $ecwhere = ' and ec = ' . $ec;
      }

      $q = 'select *, date_format(date + interval ' . $settings['time_dif'] . (' hour, \'%b-%e-%Y %r\') as d from hm2_history where ' . $datewhere . ' ' . $userwhere . ' ' . $typewhere . ' ' . $ecwhere . ' order by date desc, id desc');
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $trans = array ();
      while ($row = mysql_fetch_array ($sth))
      {
        $q = 'select username from hm2_users where id = ' . $row['user_id'];
        $sth1 = mysql_query ($q);
        $row1 = mysql_fetch_array ($sth1);
        if ($row1)
        {
          $row['username'] = $row1['username'];
        }
        else
        {
          $row['username'] = '-- deleted user --';
        }

        array_push ($trans, $row);
      }

      $from = $frm['month_from'] . '_' . $frm['day_from'] . '_' . $frm['year_from'];
      $to = $frm['month_to'] . '_' . $frm['day_to'] . '_' . $frm['year_to'];
      header ('Content-Disposition: attachment; filename=' . $frm['ttype'] . ('history-' . $from . '-' . $to . '.csv'));
      header ('Content-type: text/coma-separated-values');
      echo '"Transaction Type","User","Amount","Currency","Date","Description"
';
      for ($i = 0; $i < sizeof ($trans); ++$i)
      {
        echo '"' . $transtype[$trans[$i]['type']] . '","' . $trans[$i]['username'] . '","$' . number_format (abs ($trans[$i]['actual_amount']), 2) . '","' . $exchange_systems[$trans[$i]['ec']]['name'] . '","' . $trans[$i]['d'] . '","' . $trans[$i]['description'] . '"
';
      }

      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm[a] == 'add_processing')
  {
    if ($frm[action] == 'add_processing')
    {
      if (!($settings['demomode']))
      {
        $status = ($frm['status'] ? 1 : 0);
        $name = quote ($frm['name']);
        $description = quote ($frm_orig['description']);
        $use = $frm['field'];
        $fields = array ();
        if ($use)
        {
          reset ($use);
          $i = 1;
          foreach ($use as $id => $value)
          {
            if ($frm['use'][$id])
            {
              $fields[$i] = $value;
              ++$i;
              continue;
            }
          }
        }

        $qfields = serialize ($fields);
        $q = 'select max(id) as max_id from hm2_processings';
        $sth = mysql_query ($q);
        $row = mysql_fetch_array ($sth);
        $max_id = $row['max_id'];
        if ($max_id < 999)
        {
          $max_id = 998;
        }

        ++$max_id;
        $q = 'insert into hm2_processings set
             id = ' . $max_id . ',
             status = ' . $status . ',
             name = \'' . $name . '\',
             description = \'' . $description . '\',
             infofields = \'' . quote ($qfields) . '\'
         ';
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }
      }

      header ('Location: ?a=processings');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm[a] == 'edit_processing')
  {
    if ($frm[action] == 'edit_processing')
    {
      if (!($settings['demomode']))
      {
        $pid = intval ($frm['pid']);
        $status = ($frm['status'] ? 1 : 0);
        $name = quote ($frm['name']);
        $description = quote ($frm_orig['description']);
        $use = $frm['field'];
        $fields = array ();
        if ($use)
        {
          reset ($use);
          $i = 1;
          foreach ($use as $id => $value)
          {
            if ($frm['use'][$id])
            {
              $fields[$i] = $value;
              ++$i;
              continue;
            }
          }
        }

        $qfields = serialize ($fields);
        $q = 'update hm2_processings set
             status = ' . $status . ',
             name = \'' . $name . '\',
             description = \'' . $description . '\',
             infofields = \'' . quote ($qfields) . ('\'
           where id = ' . $pid . '
         ');
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }
      }

      header ('Location: ?a=processings');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm[a] == 'update_processings')
  {
    if (!($settings['demomode']))
    {
      $q = 'update hm2_processings set status = 0';
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $status = $frm['status'];
      if ($status)
      {
        foreach ($status as $id => $v)
        {
          $q = 'update hm2_processings set status = 1 where id = ' . $id;
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }
        }
      }
    }

    header ('Location: ?a=processings');
    db_close ($dbconn);
    exit ();
  }

  if ($frm[a] == 'delete_processing')
  {
    if (!($settings['demomode']))
    {
      $pid = intval ($frm['pid']);
      $q = 'delete from hm2_processings where id = ' . $pid;
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }
    }

    header ('Location: ?a=processings');
    db_close ($dbconn);
    exit ();
  }

  if ($frm['a'] == 'editaccount')
  {
    if ($frm['action'] == 'editaccount')
    {
      $id = sprintf ('%d', $frm['id']);
      if ($settings['demomode'] == 1)
      {
        if ($id <= 3)
        {
          if (0 < $id)
          {
            header ('Location: ?a=editaccount&id=' . $frm['id']);
            db_close ($dbconn);
            exit ();
          }
        }
      }

      $username = quote ($frm['username']);
      $q = 'SELECT * FROM hm2_users WHERE id <> ' . $id . ' and username = \'' . $username . '\'';
      $sth = mysql_query ($q);
      if (!($row = mysql_fetch_array ($sth)))
      {
        echo mysql_error ();
        true;
      }

      if ($row)
      {
        header ('Location: ?a=editaccount&say=userexists&id=' . $frm['id']);
        db_close ($dbconn);
        exit ();
      }

      if ($frm['password'] != '')
      {
        if ($frm['password'] != $frm['password2'])
        {
          header ('Location: ?a=editaccount&say=incorrect_password&id=' . $frm['id']);
          db_close ($dbconn);
          exit ();
        }
      }

      if ($frm['transaction_code'] != '')
      {
        if ($frm['transaction_code'] != $frm['transaction_code2'])
        {
          header ('Location: ?a=editaccount&say=incorrect_transaction_code&id=' . $frm['id']);
          db_close ($dbconn);
          exit ();
        }
      }

      $egold = quote ($frm['egold']);
      $ebullion = quote ($frm['ebullion']);
      $libertyreserve = quote ($frm['libertyreserve']);
      $solidtrustpay = quote ($frm['solidtrustpay']);
      $vmoney = quote ($frm['vmoney']);
      $alertpay = quote ($frm['alertpay']);
      $paypal = quote ($frm['paypal']);
      $cgold = quote ($frm['cgold']);
      $altergold = quote ($frm['altergold']);
      $pecunix = quote ($frm['pecunix']);
      $perfectmoney = quote ($frm['perfectmoney']);
      $strictpay = quote ($frm['strictpay']);
      $igolds = quote ($frm['igolds']);
      $ugotcash = quote ($frm['ugotcash']);
      $payement_gateways = 'egold_account = \'' . $egold . '\',ebullion_account = \'' . $ebullion . '\',libertyreserve_account = \'' . $libertyreserve . '\',solidtrustpay_account = \'' . $solidtrustpay . '\',vmoney_account = \'' . $vmoney . '\',alertpay_account = \'' . $alertpay . '\',paypal_account = \'' . $paypal . '\',cgold_account = \'' . $cgold . '\',altergold_account = \'' . $altergold . '\',pecunix_account = \'' . $pecunix . '\',perfectmoney_account =\'' . $perfectmoney . '\',strictpay_account=\'' . $strictpay . '\',igolds_account=\'' . $igolds . '\',ugotcash_account=\'' . $ugotcash . '\'';
      if ($id == 0)
      {
        $name = quote ($frm['fullname']);
        $username = quote ($frm['username']);
        $password = md5 (quote ($frm['password']));
        $email = quote ($frm['email']);
        $status = quote ($frm['status']);
        $auto_withdraw = sprintf ('%d', $frm['auto_withdraw']);
        $admin_auto_pay_earning = sprintf ('%d', $frm['admin_auto_pay_earning']);
        $pswd = '';
        if ($settings['store_uncrypted_password'] == 1)
        {
          $pswd = quote ($frm['password']);
        }

        $q = 'INSERT INTO hm2_users SET name = \'' . $name . '\', username = \'' . $username . '\', password = \'' . $password . '\',' . $payement_gateways . ', email = \'' . $email . '\', status = \'' . $status . '\',    auto_withdraw = ' . $auto_withdraw . ',    admin_auto_pay_earning = ' . $admin_auto_pay_earning . ',    user_auto_pay_earning = ' . $admin_auto_pay_earning . ',  pswd = \'' . $pswd . '\',    date_register = now()';
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }

        $frm['id'] = mysql_insert_id ();
      }
      else
      {
        $q = 'SELECT * FROM hm2_users WHERE id = ' . $id . ' AND id <> 1';
        $sth = mysql_query ($q);
        if (!($row = mysql_fetch_array ($sth)))
        {
          echo mysql_error ();
          true;
        }

        $name = quote ($frm['fullname']);
        $address = quote ($frm['address']);
        $city = quote ($frm['city']);
        $state = quote ($frm['state']);
        $zip = quote ($frm['zip']);
        $country = quote ($frm['country']);
        $edit_location = '';
        if ($settings['use_user_location'])
        {
          $edit_location = 'address = \'' . $address . '\',city = \'' . $city . '\',state = \'' . $state . '\',zip = \'' . $zip . '\',country = \'' . $country . '\',';
        }

        $username = quote ($frm['username']);
        $password = quote ($frm['password']);
        $transaction_code = quote ($frm['transaction_code']);
        $email = quote ($frm['email']);
        $status = quote ($frm['status']);
        $auto_withdraw = sprintf ('%d', $frm['auto_withdraw']);
        $admin_auto_pay_earning = sprintf ('%d', $frm['admin_auto_pay_earning']);
        $user_auto_pay_earning = $row['user_auto_pay_earning'];
        if ($row['admin_auto_pay_earning'] == 0)
        {
          if ($admin_auto_pay_earning == 1)
          {
            $user_auto_pay_earning = 1;
          }
        }

        $q = 'UPDATE hm2_users SET name = \'' . $name . '\',' . $edit_location . 'username = \'' . $username . '\', ' . $payement_gateways . ',email = \'' . $email . '\',status = \'' . $status . '\',auto_withdraw = ' . $auto_withdraw . ',admin_auto_pay_earning = ' . $admin_auto_pay_earning . ',user_auto_pay_earning = ' . $user_auto_pay_earning . ' WHERE id = ' . $id . ' AND id <> 1';
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }

        if ($password != '')
        {
          $pswd = quote ($password);
          $password = md5 ($password);
          $q = 'UPDATE hm2_users SET password = \'' . $password . '\' where id = ' . $id . ' and id <> 1';
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }

          if ($settings['store_uncrypted_password'] == 1)
          {
            $q = 'UPDATE hm2_users SET pswd = \'' . $pswd . '\' where id = ' . $id . ' and id <> 1';
            if (!(mysql_query ($q)))
            {
              echo mysql_error ();
              true;
            }
          }
        }

        if ($transaction_code != '')
        {
          $pswd = quote ($password);
          $password = md5 ($password);
          $q = 'UPDATE hm2_users SET transaction_code = \'' . $transaction_code . '\' where id = ' . $id . ' and id <> 1';
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }
        }

        if ($frm['activate'])
        {
          $q = 'UPDATE hm2_users SET activation_code = \'\', bf_counter = 0 where id = ' . $id . ' AND id <> 1';
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }
        }
      }

      header ('Location: ?a=editaccount&id=' . $frm['id'] . '&say=saved');
      db_close ($dbconn);
      exit ();
    }
  }

  include 'inc/admin/html.header.inc.php';
  echo '<tr><td valign="top"><table cellspacing=0 cellpadding=1 border=0 width=100% height=100% bgcolor="#DF0100"> <tr><td><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0"><tr bgcolor="#FFFFFF" valign="top"><td width=300 align=center>';
  include 'inc/admin/menu.inc.php';
  echo '<br></td><td bgcolor="#DF0100" valign="top" width=1><img src=images/q.gif width=1 height=1></td><td bgcolor="#FFFFFF" valign="top" width=99%><table width="100%" height="100%" border="0" cellpadding="10" cellspacing="0" class="forTexts"><tr><td width=100% height=100% valign=top>';
  if ($frm['a'] == 'rates')
  {
    include 'inc/admin/rates.inc.php';
  }
  else
  {
    if ($frm['a'] == 'editrate')
    {
      include 'inc/admin/edit_hyip.inc.php';
    }
    else
    {
      if ($frm['a'] == 'add_hyip')
      {
        include 'inc/admin/add_hyip.inc.php';
      }
      else
      {
        if ($frm['a'] == 'members')
        {
          include 'inc/admin/members.inc.php';
        }
        else
        {
          if ($frm['a'] == 'editaccount')
          {
            include 'inc/admin/editaccount.inc.php';
          }
          else
          {
            if ($frm['a'] == 'addmember')
            {
              include 'inc/admin/addmember.inc.php';
            }
            else
            {
              if ($frm['a'] == 'userexists')
              {
                include 'inc/admin/error_userexists.inc.php';
              }
              else
              {
                if ($frm['a'] == 'userfunds')
                {
                  include 'inc/admin/manage_user_funds.inc.php';
                }
                else
                {
                  if ($frm['a'] == 'addbonuse')
                  {
                    include 'inc/admin/addbonuse.inc.php';
                  }
                  else
                  {
                    if ($frm['a'] == 'mass')
                    {
                      if ($frm['action2'] == 'masspay')
                      {
                        include 'inc/admin/prepare_mass_pay.inc.php';
                      }
                    }
                    else
                    {
                      if ($frm['a'] == 'thistory')
                      {
                        include 'inc/admin/transactions_history.php';
                      }
                      else
                      {
                        if ($frm['a'] == 'addpenality')
                        {
                          include 'inc/admin/addpenality.inc.php';
                        }
                        else
                        {
                          if ($frm['a'] == 'releasedeposits')
                          {
                            include 'inc/admin/releaseusersdeposits.inc.php';
                          }
                          else
                          {
                            if ($frm['a'] == 'pay_withdraw')
                            {
                              include 'inc/admin/process_withdraw.php';
                            }
                            else
                            {
                              if ($frm['a'] == 'info_box')
                              {
                                include 'inc/admin/info_box_settings.inc.php';
                              }
                              else
                              {
                                if ($frm['a'] == 'send_bonuce')
                                {
                                  include 'inc/admin/send_bonuce.inc.php';
                                }
                                else
                                {
                                  if ($frm['a'] == 'send_penality')
                                  {
                                    include 'inc/admin/send_penality.inc.php';
                                  }
                                  else
                                  {
                                    if ($frm['a'] == 'newsletter')
                                    {
                                      include 'inc/admin/newsletter.inc.php';
                                    }
                                    else
                                    {
                                      if ($frm['a'] == 'edit_emails')
                                      {
                                        include 'inc/admin/emails.inc.php';
                                      }
                                      else
                                      {
                                        if ($frm['a'] == 'referal')
                                        {
                                          include 'inc/admin/referal.inc.php';
                                        }
                                        else
                                        {
                                          if ($frm['a'] == 'settings')
                                          {
                                            include 'inc/admin/settings.inc.php';
                                          }
                                          else
                                          {
                                            if ($frm['a'] == 'paysettings')
                                            {
                                              include 'inc/admin/pay_settings.inc.php';
                                            }
                                            else
                                            {
                                              if ($frm['a'] == 'auto-pay-settings')
                                              {
                                                include 'inc/admin/auto_pay_settings.inc.php';
                                              }
                                              else
                                              {
                                                if ($frm['a'] == 'error_pay_log')
                                                {
                                                  include 'inc/admin/error_pay_log.inc.php';
                                                }
                                                else
                                                {
                                                  if ($frm['a'] == 'news')
                                                  {
                                                    include 'inc/admin/news.inc.php';
                                                  }
                                                  else
                                                  {
                                                    if ($frm['a'] == 'wire_settings')
                                                    {
                                                      include 'inc/admin/wire_settings.inc.php';
                                                    }
                                                    else
                                                    {
                                                      if ($frm['a'] == 'wires')
                                                      {
                                                        include 'inc/admin/wires.inc.php';
                                                      }
                                                      else
                                                      {
                                                        if ($frm['a'] == 'wiredetails')
                                                        {
                                                          include 'inc/admin/wiredetails.inc.php';
                                                        }
                                                        else
                                                        {
                                                          if ($frm['a'] == 'affilates')
                                                          {
                                                            include 'inc/admin/affilates.inc.php';
                                                          }
                                                          else
                                                          {
                                                            if ($frm['a'] == 'custompages')
                                                            {
                                                              include 'inc/admin/custompage.inc.php';
                                                            }
                                                            else
                                                            {
                                                              if ($frm['a'] == 'exchange_rates')
                                                              {
                                                                include 'inc/admin/exchange_rates.inc.php';
                                                              }
                                                              else
                                                              {
                                                                if ($frm['a'] == 'security')
                                                                {
                                                                  include 'inc/admin/security.inc.php';
                                                                }
                                                                else
                                                                {
                                                                  if ($frm['a'] == 'processings')
                                                                  {
                                                                    include 'inc/admin/processings.inc.php';
                                                                  }
                                                                  else
                                                                  {
                                                                    if ($frm['a'] == 'add_processing')
                                                                    {
                                                                      include 'inc/admin/add_processing.inc.php';
                                                                    }
                                                                    else
                                                                    {
                                                                      if ($frm['a'] == 'edit_processing')
                                                                      {
                                                                        include 'inc/admin/edit_processing.inc.php';
                                                                      }
                                                                      else
                                                                      {
                                                                        if ($frm['a'] == 'pending_deposits')
                                                                        {
                                                                          include 'inc/admin/pending_deposits.inc.php';
                                                                        }
                                                                        else
                                                                        {
                                                                          if ($frm['a'] == 'pending_deposit_details')
                                                                          {
                                                                            include 'inc/admin/pending_deposit_details.inc.php';
                                                                          }
                                                                          else
                                                                          {
                                                                            if ($frm['a'] == 'startup_bonus')
                                                                            {
                                                                              include 'inc/admin/startup_bonus.inc.php';
                                                                            }
                                                                            else
                                                                            {
                                                                              include 'inc/admin/main.inc.php';
                                                                            }
                                                                          }
                                                                        }
                                                                      }
                                                                    }
                                                                  }
                                                                }
                                                              }
                                                            }
                                                          }
                                                        }
                                                      }
                                                    }
                                                  }
                                                }
                                              }
                                            }
                                          }
                                        }
                                      }
                                    }
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  }

  echo '</td></tr></table></td></tr></table></td></tr></table></td></tr>';
  include 'inc/admin/html.footer.inc.php';
  db_close ($dbconn);
  exit ();
?>