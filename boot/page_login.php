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
  if ($frm['a'] == 'do_login')
  {
    $username = quote ($frm['username']);
    $password = quote ($frm['password']);
    $password = md5 ($password);
    $add_opt_in_check = '';
    if ($settings['use_opt_in'] == 1)
    {
      $add_opt_in_check = ' and (confirm_string = "" or confirm_string is NULL)';
    }

    $q = 'SELECT *, date_format(date_register, \'%b-%e-%Y\') as create_account_date, now() - interval 2 minute > l_e_t AS should_count FROM hm2_users WHERE username = \'' . $username . '\' AND (status=\'on\' OR status=\'suspended\') ' . $add_opt_in_check;
    $sth = mysql_query ($q);
    while ($row = mysql_fetch_array ($sth))
    {
      if (extension_loaded ('gd'))
      {
        if ($settings['graph_validation'] == 1)
        {
          if (0 < $settings['graph_max_chars'])
          {
            session_start ();
            if ($_SESSION['validation_number'] != $frm['validation_number'])
            {
              header ('Location: page_login.php?say=invalid_login&username=' . $frm['username']);
              db_close ($dbconn);
              exit ();
            }
          }
        }
      }

      if ($settings['brute_force_handler'] == 1)
      {
        if ($row['activation_code'] != '')
        {
          header ('Location: page_login.php?say=invalid_login2&username=' . $frm['username']);
          db_close ($dbconn);
          exit ();
        }
      }

      if ($settings['brute_force_handler'] == 1)
      {
        if ($row['bf_counter'] == $settings['brute_force_max_tries'])
        {
          $activation_code = get_rand_md5 (50);
          $q = 'UPDATE hm2_users set bf_counter = bf_counter + 1, activation_code = \'' . $activation_code . '\' where id = ' . $row['id'];
          mysql_query ($q);
          $info = array ();
          $info['activation_code'] = $activation_code;
          $info['username'] = $row['username'];
          $info['name'] = $row['name'];
          $info['ip'] = $frm_env['REMOTE_ADDR'];
          $info['max_tries'] = $settings['brute_force_max_tries'];
          send_mail ('brute_force_activation', $row['email'], $settings['system_email'], $info);
          header ('Location: page_login.php?say=invalid_login&username=' . $frm['username']);
          db_close ($dbconn);
          exit ();
        }
      }

      if ($row['password'] != $password)
      {
        $q = 'UPDATE hm2_users SET bf_counter = bf_counter + 1 WHERE id = ' . $row['id'];
        mysql_query ($q);
        header ('Location: page_login.php?say=invalid_login&username=' . $frm['username']);
        db_close ($dbconn);
        exit ();
      }

      $hid = get_rand_md5 (20);
      $qhid = get_rand_md5 (5) . $hid . get_rand_md5 (5);
      $chid = $row['id'] . '-' . md5 ($hid);
      $userinfo = $row;
      $userinfo['logged'] = 1;
      $ip = $frm_env['REMOTE_ADDR'];
      $q = 'UPDATE hm2_users SET hid = \'' . $qhid . '\', bf_counter = 0, last_access_time = now(), last_access_ip = \'' . $ip . '\' WHERE id = ' . $row['id'];
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $q = 'INSERT INTO hm2_user_access_log SET user_id = ' . $userinfo['id'] . (', date = now(), ip = \'' . $ip . '\'');
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      if ($settings['generate_password_after_login'] == 1)
      {
        $new_pass = gen_confirm_code (10, 0);
        $q = 'update hm2_users set password = \'' . md5 ($new_pass) . '\' where id = ' . $userinfo['id'];
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }

        $info = array ();
        $info['username'] = $userinfo['username'];
        $info['name'] = $userinfo['name'];
        $info['ip'] = $frm_env['REMOTE_ADDR'];
        $info['password'] = $new_pass;
        send_mail ('send_password_when_changed', $userinfo['email'], $settings['system_email'], $info);
      }

      setcookie ('password', $chid, time () + 630720000);
    }

    if ($userinfo['logged'] == 0)
    {
      header ('Location: page_login.php?say=invalid_login&username=' . $frm['username']);
      db_close ($dbconn);
      exit ();
    }

    if ($userinfo['logged'] == 1)
    {
      if ($userinfo['id'] == 1)
      {
        mail ($userinfo[email], 'Admin logged', 'Admin entered to admin area
ip=' . $frm_env['REMOTE_ADDR'], 'From: ' . $settings['system_email'] . '
Reply-To: ' . $settings['system_email']);
        echo '<head><title>HYIP Manager Script : www.hyipmanagerscript.com</title><meta http-equiv=\'Refresh\' content=\'1; URL=admin.php\'></head><body><center><a href=\'admin.php\'>Go to admin area</a></center></body>';
        flush ();
        db_close ($dbconn);
        exit ();
      }
    }

    if ($userinfo['logged'] == 1)
    {
      if ($userinfo['id'] != 1)
      {
        header ('Location: account_main.php');
        db_close ($dbconn);
        exit ();
      }
    }
  }
  else
  {
    $smarty->assign ('frm', $frm);
    $smarty->display ('page_login.tpl');
  }

?>