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

  if ($frm['action'] == 'confirm')
  {
    $smarty->assign ('say', $frm['say']);
    $smarty->display ('account_edit_confirmation.tpl');
    db_close ($dbconn);
    exit ();
  }

  if ($frm['action'] == 'edit_account')
  {
    if ($settings['demomode'] == 1)
    {
      if ($userinfo['id'] < 3)
      {
        header ('Location: account_edit.php?');
        exit ();
      }
    }

    $errors = array ();
    if ($frm['action2'] != 'confirm')
    {
      if ($frm['fullname'] == '')
      {
        array_push ($errors, 'full_name');
      }

      if ($frm['password'] != '')
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

      if ($settings['usercanchangeemail'])
      {
        if ($frm['email'] == '')
        {
          array_push ($errors, 'email');
        }
      }

      if ($settings['use_transaction_code'])
      {
        if ($frm['transaction_code'] != '')
        {
          if ($frm['transaction_code_current'] == $userinfo['transaction_code'])
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
          else
          {
            array_push ($errors, 'invalid_transaction_code');
          }
        }

        if ($frm['transaction_code'] != '')
        {
          if ($frm['password'] != '')
          {
            if ($frm['transaction_code'] == $frm['password'])
            {
              array_push ($errors, 'transaction_code_vs_password');
            }
          }
        }
      }
    }

    if (sizeof ($errors) == 0)
    {
      if ($settings['account_update_confirmation'] == 1)
      {
        session_start ();
        if ($frm['action2'] == 'confirm')
        {
          if ($_SESSION['account_update_confirmation_code'] == $frm['account_update_confirmation_code'])
          {
            if (is_array ($_SESSION['fields']))
            {
              $frm = array_merge ($frm, $_SESSION['fields']);
            }
            else
            {
              header ('Location: account_edit.php');
              db_close ($dbconn);
              exit ();
            }
          }

          header ('Location: account_edit.php?action=confirm&say=invalid_code');
          db_close ($dbconn);
          exit ();
        }

        $code = get_rand_md5 (50);
        $_SESSION['account_update_confirmation_code'] = $code;
        $_SESSION['fields'] = $frm;
        $info = array ();
        $info['confirmation_code'] = $code;
        $info['username'] = $userinfo['username'];
        $info['name'] = $userinfo['name'];
        $info['ip'] = $frm_env['REMOTE_ADDR'];
        send_mail ('account_update_confirmation', $userinfo['email'], $settings['system_email'], $info);
        header ('Location: account_edit.php?action=confirm');
        db_close ($dbconn);
        exit ();
      }

      $fullname = quote ($frm['fullname']);
      $password = quote ($frm['password']);
      $enc_password = md5 ($password);
      $email = quote ($frm['email']);
      $egold = quote ($frm['egold']);
      $ebullion = quote ($frm['ebullion']);
      $libertyreserve = quote ($frm['libertyreserve']);
      $solidtrustpay = quote ($frm['solidtrustpay']);
      $vmoney = quote ($frm['vmoney']);
      $alertpay = quote ($frm['egopay']);
      $paypal = quote ($frm['paypal']);
      $cgold = quote ($frm['cgold']);
      $altergold = quote ($frm['altergold']);
      $pecunix = quote ($frm['pecunix']);
      $perfectmoney = quote ($frm['perfectmoney']);
      $strictpay = quote ($frm['strictpay']);
      $igolds = quote ($frm['igolds']);
      $payement_gateways = 'egold_account = \'' . $egold . '\',ebullion_account = \'' . $ebullion . '\',libertyreserve_account = \'' . $libertyreserve . '\',solidtrustpay_account = \'' . $solidtrustpay . '\',vmoney_account = \'' . $vmoney . '\',alertpay_account = \'' . $alertpay . '\',paypal_account = \'' . $paypal . '\',cgold_account = \'' . $cgold . '\',altergold_account = \'' . $altergold . '\',pecunix_account = \'' . $pecunix . '\',perfectmoney_account = \'' . $perfectmoney . '\',strictpay_account=\'' . $strictpay . '\',igolds_account=\'' . $igolds . '\',';
      $address = quote ($frm['address']);
      $city = quote ($frm['city']);
      $state = quote ($frm['state']);
      $zip = quote ($frm['zip']);
      $country = quote ($frm['country']);
      $transaction_code = quote ($frm['transaction_code']);
      if ($userinfo['email'] != $frm['email'])
      {
        if ($settings['usercanchangeemail'] == 1)
        {
          $q = 'UPDATE hm2_users set email = \'' . $email . '\' where id > 1 and id = ' . $userinfo['id'];
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }
        }
      }

      if ($userinfo['egold_account'] != $frm['egold_account'])
      {
        if ($settings['usercanchangeegoldacc'])
        {
          $q = 'UPDATE hm2_users set egold_account = \'' . $egold . '\' where id > 1 and id = ' . $userinfo['id'];
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }
        }
      }

      if ($frm['password'] != '')
      {
        $q = 'UPDATE hm2_users set password = \'' . $enc_password . '\' where id > 1 and id = ' . $userinfo['id'];
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }

        if ($settings['store_uncrypted_password'] == 1)
        {
          $pswd = quote ($frm['password']);
          $q = 'UPDATE hm2_users set pswd = \'' . $pswd . '\' where id > 1 and id = ' . $userinfo['id'];
          if (!(mysql_query ($q)))
          {
            echo mysql_error ();
            true;
          }
        }
      }

      if ($frm['transaction_code'] != '')
      {
        $q = 'UPDATE hm2_users set transaction_code = \'' . $transaction_code . '\' where id > 1 and id = ' . $userinfo['id'];
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }
      }

      if ($frm['wappassword'] != '')
      {
        $enc_password = quote (md5 ($frm['wappassword']));
        $q = 'update hm2_users set stat_password = \'' . $enc_password . '\' where id > 1 and id = ' . $userinfo['id'];
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }
      }

      $edit_location = '';
      if ($settings['use_user_location'])
      {
        $edit_location = 'address = \'' . $address . '\',city = \'' . $city . '\',state = \'' . $state . '\', zip = \'' . $zip . '\',country = \'' . $country . '\',';
      }

      $user_auto_pay_earning = sprintf ('%d', $frm['user_auto_pay_earning']);
      $q = 'UPDATE hm2_users set name = \'' . $fullname . '\', ' . $edit_location . $payement_gateways . 'user_auto_pay_earning = ' . $user_auto_pay_earning . ' WHERE id > 1 and id = ' . $userinfo['id'];
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $q = 'select * from hm2_users where id =' . $userinfo['id'];
      $sth = mysql_query ($q);
      $userinfo = mysql_fetch_array ($sth);
      $userinfo['logged'] = 1;
      if ($settings['sendnotify_when_userinfo_changed'] == 1)
      {
        $info = array ();
        $info['username'] = $userinfo['username'];
        $info['password'] = $password;
        $info['name'] = $userinfo['name'];
        $info['ip'] = $frm_env['REMOTE_ADDR'];
        $info['egold'] = $userinfo['egold_account'];
        $info['email'] = $userinfo['email'];
        if ($frm['email'] == '')
        {
          $frm['email'] = $userinfo['email'];
        }

        send_mail ('change_account', $frm['email'], $settings['opt_in_email'], $info);
      }

      header ('Location: account_edit.php?say=changed');
      exit ();
    }
  }

  foreach ($exchange_systems as $id => $data)
  {
    $accounts[$id] = $userinfo[$data[sfx] . '_account'];
  }

  $ps = array ();
  reset ($exchange_systems);
  foreach ($exchange_systems as $id => $data)
  {
    array_push ($ps, array_merge (array ('id' => $id, 'account' => $accounts[$id]), $data));
  }

  include './inc/countries.php';
  $q = 'select date_format(\'' . $userinfo['date_register'] . '\' + interval ' . $settings['time_dif'] . ' day, \'%b-%e-%Y %r\') as date_registered';
  $sth = mysql_query ($q);
  $row = mysql_fetch_array ($sth);
  $userinfo['date_register'] = $row['date_registered'];
  $smarty->assign ('pay_accounts', $ps);
  $smarty->assign ('userinfo', $userinfo);
  $smarty->assign ('errors', $errors);
  $smarty->assign ('frm', $frm);
  $smarty->assign ('settings', $settings);
  $smarty->assign ('countries', $countries);
  $smarty->display ('account_edit.tpl');
?>