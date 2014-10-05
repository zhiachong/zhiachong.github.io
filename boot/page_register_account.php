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

  if ($userinfo['logged'] != 1)
  {
    if ($frm['say'] == 'confirm')
    {
      $smarty->display ('page_after_registration_confirm.tpl');
      db_close ($dbconn);
      exit ();
    }

    if ($frm['say'] == 'done')
    {
      $smarty->display ('page_after_registration.tpl');
      db_close ($dbconn);
      exit ();
    }

    if ($frm['action'] == 'signup')
    {
      if ($settings['deny_registration'] == 0)
      {
        $errors = array ();
        if (extension_loaded ('gd'))
        {
          if ($settings['graph_validation'] == 1)
          {
            if (0 < $settings['graph_max_chars'])
            {
              session_start ();
              if ($_SESSION['validation_number'] != $frm['validation_number'])
              {
                array_push ($errors, 'turing_image');
              }
            }
          }
        }

        if ($frm['fullname'] == '')
        {
          array_push ($errors, 'full_name');
        }

        $name = quote ($frm['fullname']);
        $username = quote ($frm['username']);
        $username = str_replace (' ', '', $username);
        if ($frm['username'] == '')
        {
          array_push ($errors, 'username');
        }
        else
        {
          $q = 'SELECT * FROM hm2_users WHERE username = \'' . $username . '\'';
        }

        if (!($sth = mysql_query ($q)))
        {
          exit (mysql_errstr ());
        }

        $row = mysql_fetch_array ($sth);
        if ($row)
        {
          array_push ($errors, 'username_exists');
        }

        if ($frm['password'] == '')
        {
          array_push ($errors, 'password');
        }
        else
        {
          if (0 < $settings['min_user_password_length'])
          {
            if (strlen ($frm['password']) < $settings['min_user_password_length'])
            {
              array_push ($errors, 'password_too_small');
            }
          }

          if ($frm['password'] != $frm['password2'])
          {
            array_push ($errors, 'password_confirm');
          }
        }

        if ($frm['email'] == '')
        {
          array_push ($errors, 'email');
        }

        if ($settings['use_user_location'])
        {
          if ($frm['country'] == '')
          {
            array_push ($errors, 'country');
          }
        }

        if ($settings['use_transaction_code'])
        {
          if ($frm['transaction_code'] == '')
          {
            array_push ($errors, 'transaction_code');
          }
          else
          {
            if (0 < $settings['min_user_password_length'])
            {
              if (strlen ($frm['transaction_code']) < $settings['min_user_password_length'])
              {
                array_push ($errors, 'transaction_code_too_small');
              }
            }

            if ($frm['transaction_code'] != $frm['transaction_code2'])
            {
              array_push ($errors, 'transaction_code_confirm');
            }
          }

          if ($frm['transaction_code'] == $frm['password'])
          {
            array_push ($errors, 'transaction_code_vs_password');
          }
        }

        if ($frm['agree'] != 1)
        {
          array_push ($errors, 'agree');
        }
        
        $ref = quote ($frm_cookie['Referer']);
        $ref_id = 0;
        $ref = preg_replace('/IS/', '', $ref);
        
        if ($settings['use_names_in_referral_links'] == 1)
        {
          $q = 'SELECT id FROM hm2_users WHERE REPLACE (username, \' \', \'_\') = \'' . $ref . '\'';
        }
        else
        {
          $q = 'SELECT id FROM hm2_users WHERE username = \'' . $ref . '\'';
        }

        if (!($sth = mysql_query ($q)))
        {
          echo mysql_errstr;
          true;
        }

        while ($row = mysql_fetch_array ($sth))
        {
          $ref_id = $row['id'];
        }

        if ($settings['force_upline'])
        {
          if ($ref_id == 0)
          {
            if (!((!($settings['get_rand_ref'] != 1) AND !($frm['rand_ref'] != 1))))
            {
              array_push ($errors, 'no_upline');
            }
          }
        }

        if (sizeof ($errors) == 0)
        {
          if ($settings['force_upline'])
          {
            if ($ref_id == 0)
            {
              if ($frm['rand_ref'] == 1)
              {
                if ($settings['get_rand_ref'])
                {
                  $q = 'select id from hm2_users where id != 1 order by rand() limit 1';
                  $sth = mysql_query ($q);
                  $row = mysql_fetch_array ($sth);
                  $ref_id = intval ($row['id']);
                }
              }
            }
          }

          $password = quote ($frm['password']);
          $pswd = '';
          if ($settings['store_uncrypted_password'] == 1)
          {
            $pswd = quote ($frm['password']);
          }

          $enc_password = md5 ($password);
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
          $email = quote ($frm['email']);
          $city = quote ($frm['city']);
          $country = quote ($frm['country']);
          $transaction_code = quote ($frm['transaction_code']);
          $referer_url = quote ($frm_cookie['CameFrom']);
          $confirm_string = gen_confirm_code (10);
          if ($settings['use_opt_in'] != 1)
          {
            $confirm_string = '';
          }

          $ip = $frm_env['REMOTE_ADDR'];
          $q = 'INSERT into hm2_users SET name = \'' . $name . '\', username = \'' . $username . '\', password = \'' . $enc_password . '\', date_register = now(),country = \'' . $country . '\', email = \'' . $email . '\', ip_reg = \'' . $ip . '\',status = \'on\', came_from = \'' . $referer_url . '\', confirm_string = \'' . $confirm_string . '\',pswd = \'' . $pswd . '\', egold_account = \'' . $egold . '\', ebullion_account=\'' . $ebullion . '\',libertyreserve_account=\'' . $libertyreserve . '\',solidtrustpay_account= \'' . $solidtrustpay . '\', vmoney_account= \'' . $vmoney . '\', alertpay_account= \'' . $alertpay . '\',paypal_account= \'' . $paypal . '\', cgold_account= \'' . $cgold . '\', altergold_account= \'' . $altergold . '\', pecunix_account = \'' . $pecunix . '\',perfectmoney_account = \'' . $perfectmoney . '\', strictpay_account = \'' . $strictpay . '\', igolds_account = \'' . $igolds . '\',transaction_code = \'' . $transaction_code . '\', ref = ' . $ref_id;
          if (!(mysql_query ($q)))
          {
            exit (mysql_error ());
          }

          if ($settings['phpbb_register'])
          {
            $q = 'INSERT INTO phpbb_users SET username = \'' . $username . '\',user_regdate = ' . time () . (',user_password = \'' . $enc_password . '\',user_email = \'' . $email . '\',user_viewemail = 0,user_dateformat = \'D M d, Y g:i a\',user_lang = \'english\',user_level = 0,user_active = 1,user_actkey = \'\'');
            mysql_query ($q);
            $php_user_id = mysql_insert_id ();
            $q = 'INSERT INTO phpbb_groups (group_name, group_description, group_single_user, group_moderator)
              VALUES (\'\', \'Personal User\', 1, 0)';
            mysql_query ($q);
            $php_group_id = mysql_insert_id ();
            $q = 'INSERT INTO phpbb_user_group (user_id, group_id, user_pending) VALUES (' . $php_user_id . ', ' . $php_group_id . ', 0)';
            mysql_query ($q);
          }

          $last_id = mysql_insert_id ();
          if (0 < $settings['startup_bonus'])
          {
            $q = 'INSERT into hm2_history SET user_id = ' . $last_id . ',ec = ' . $settings['startup_bonus_ec'] . ',amount = ' . $settings['startup_bonus'] . ',actual_amount = ' . $settings['startup_bonus'] . ',type=\'bonus\',date = now(),description = \'Startup bonus\'';
            if (!(mysql_query ($q)))
            {
              echo mysql_error ();
              true;
            }
          }

          if ($settings['use_opt_in'] == 1)
          {
            $info = array ();
            $info['username'] = $frm['username'];
            $info['confirm_string'] = $confirm_string;
            $info['name'] = $frm['fullname'];
            $info['ip'] = $frm_env['REMOTE_ADDR'];
            send_mail ('confirm_registration', $frm['email'], $settings['opt_in_email'], $info);
            header ('Location: page_register_account.php?say=confirm');
          }
          else
          {
            $q = 'SELECT * from hm2_users WHERE id = \'' . $ref_id . '\'';
            $sth = mysql_query ($q);
            while ($refinfo = mysql_fetch_array ($sth))
            {
              $info = array ();
              $info['username'] = $refinfo['username'];
              $info['name'] = $refinfo['name'];
              $info['ref_username'] = $frm['username'];
              $info['ref_name'] = $frm['fullname'];
              $info['ref_email'] = $frm['email'];
              send_mail ('direct_signup_notification', $refinfo['email'], $settings['opt_in_email'], $info);
            }

            $info = array ();
            $info['username'] = $frm['username'];
            $info['password'] = $password;
            $info['name'] = $frm['fullname'];
            $info['ip'] = $frm_env['REMOTE_ADDR'];
            send_mail ('registration', $frm['email'], $settings['opt_in_email'], $info);
            header ('Location: page_register_account.php?say=done');
          }

          db_close ($dbconn);
          exit ();
        }
      }
    }

    foreach ($exchange_systems as $id => $data)
    {
      $accounts[$id] = $frm[$data[sfx]];
    }

    $ps = array ();
    reset ($exchange_systems);
    foreach ($exchange_systems as $id => $data)
    {
      array_push ($ps, array_merge (array ('id' => $id, 'account' => $accounts[$id]), $data));
    }

    include './inc/countries.php';
    $ref = quote ($frm_cookie['Referer']);
    $ref = preg_replace('/IFS/', '', $ref);
    $q = 'SELECT * from hm2_users where username = \'' . $ref . '\'';
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_errstr;
      true;
    }

    while ($row = mysql_fetch_array ($sth))
    {
      $smarty->assign ('referer', $row);
    }

    $smarty->assign ('pay_accounts', $ps);
    $smarty->assign ('errors', $errors);
    $smarty->assign ('frm', $frm);
    $smarty->assign ('countries', $countries);
    $smarty->assign ('deny_registration', $settings['deny_registration']);
    $smarty->display ('page_register_account.tpl');
    return 1;
  }

  header ('location: account_main.php');
  exit ();
?>