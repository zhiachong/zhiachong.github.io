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


//  ini_set ('display_errors', '1');
ini_set ('error_reporting', 'E_ALL & ~E_NOTICE');
  global $frm;
  if (!(extension_loaded ('gd')))
  {
    $prefix = (PHP_SHLIB_SUFFIX == 'dll' ? 'php_' : '');
    @dl ($prefix . 'gd.' . PHP_SHLIB_SUFFIX);
  }

  global $HTTP_GET_VARS;
  global $HTTP_POST_VARS;
  global $HTTP_POST_FILES;
  global $HTTP_COOKIE;
  $get = (isset($_GET) ? $_GET : $HTTP_GET_VARS);
  $post =(isset($_POST) ? $_POST : $HTTP_POST_VARS);
  $frm = array_merge ((array)$get, (array)$post);
  $frm_cookie = (isset($_COOKIE) ? $_COOKIE : $HTTP_COOKIE_VARS);
  $frm_orig = $frm;
  $gpc = ini_get ('magic_quotes_gpc');
  reset ($frm);
  while (list ($kk, $vv) = each ($frm))
  {
    if (!(is_array ($vv)))
    {
      if ($gpc == '1')
      {
        $vv = str_replace ('\\\'', '\'', $vv);
        $vv = str_replace ('\\"', '"', $vv);
        $vv = str_replace ('\\\\', '\\', $vv);
      }

      $vv = trim ($vv);
      $vv_orig = $vv;
      $vv = strip_tags ($vv);
    }

    $frm[$kk] = $vv;
    $frm_orig[$kk] = $vv_orig;
  }

  $gpc = ini_get ('magic_quotes_gpc');
  reset ($frm_cookie);
  while (list ($kk, $vv) = each ($frm_cookie))
  {
    if (!(is_array ($vv)))
    {
      if ($gpc == '1')
      {
        $vv = str_replace ('\\\'', '\'', $vv);
        $vv = str_replace ('\\"', '"', $vv);
        $vv = str_replace ('\\\\', '\\', $vv);
      }

      $vv = trim ($vv);
      $vv = strip_tags ($vv);
    }

    $frm_cookie[$kk] = $vv;
  }

  global $HTTP_ENV_VARS;
  global $HTTP_SERVER_VARS;
  $frm_env = array ();
  $frm_env = array_merge ((array)$_ENV, (array)$_SERVER, (array)$HTTP_ENV_VARS, (array)$HTTP_SERVER_VARS);
  $referer = $frm_env['HTTP_REFERER'];
  $host = $frm_env['HTTP_HOST'];
  if (!(ereg ('\\/\\/' . $host, $referer)))
  {
    setcookie ('CameFrom', $referer, time () + 630720000);
  }

  $userinfo = array ();
  $settings = array ();
  require 'inc/libs/Smarty.class.php';
  require 'functions.php';
  $settings = get_settings ();
  $smarty = new Smarty ();
  $smarty->compile_check = true;
  $smarty->force_compile = true;
  $smarty->template_dir = './tmpl/';
  $smarty->compile_dir = './tmpl_c';
  $smarty->default_modifiers = array ('myescape');
  if (preg_match ('/^https.*/i', $frm_env['SCRIPT_URI']))
  {
    $frm_env['HTTPS'] = 1;
  }

  $mddomain = md5 (preg_replace ('/^www\\./', '', $frm_env['HTTP_HOST']));
  $dbconn = db_open ();
  if (!($dbconn))
  {
    echo 'Cannot connect mysql';
    exit ();
  }

  if (extension_loaded ('gd'))
  {
    if ($settings['graph_validation'] == 1)
    {
      if (0 < $settings['graph_max_chars'])
      {
        $settings['validation_enabled'] = 1;
      }
    }
  }
  else
  {
    $settings['validation_enabled'] = 0;
  }

  include 'box_news.php';
  include 'box_stats.php';
  $currency_sign = '$';
  $smarty->assign ('settings', $settings);
  $smarty->assign ('currency_sign', $currency_sign);
  $transtype = array ('withdraw_pending' => 'Withdrawal request', 'add_funds' => 'Transfer from external processings', 'deposit' => 'Deposit', 'bonus' => 'Bonus', 'penality' => 'Penalty', 'earning' => 'Earning', 'withdrawal' => 'Withdrawal', 'commissions' => 'Referral commission', 'early_deposit_release' => 'Deposit release', 'early_deposit_charge' => 'Commission for an early deposit release', 'release_deposit' => 'Deposit returned to user account', 'exchange_out' => ' Received on exchange', 'exchange_in' => 'Spent on exchange', 'exchange' => 'Exchange', 'internal_transaction_spend' => 'Spent on Internal Transaction', 'internal_transaction_receive' => 'Received from Internal Transaction');
  $exchange_systems = array (0 => array ('name' => 'e-gold', 'sfx' => 'egold'), 1 => array ('name' => 'LibertyReserve', 'sfx' => 'libertyreserve'), 2 => array ('name' => 'SolidTrustPay', 'sfx' => 'solidtrustpay'), 3 => array ('name' => 'V-Money', 'sfx' => 'vmoney'), 4 => array ('name' => 'AlertPay', 'sfx' => 'alertpay'), 5 => array ('name' => 'e-Bullion', 'sfx' => 'ebullion'), 6 => array ('name' => 'PayPal', 'sfx' => 'paypal'), 7 => array ('name' => 'C-Gold', 'sfx' => 'cgold'), 8 => array ('name' => 'AlterGold', 'sfx' => 'altergold'), 9 => array ('name' => 'Pecunix', 'sfx' => 'pecunix'), 10 => array ('name' => 'PerfectMoney', 'sfx' => 'perfectmoney'), 11 => array ('name' => 'StrictPay', 'sfx' => 'strictpay'), 12 => array ('name' => 'iGolds', 'sfx' => 'igolds'));
  foreach ($exchange_systems as $id => $data)
  {
    if ($settings['def_payee_account_' . $data['sfx']] != '')
    {
      if ($settings['def_payee_account_' . $data['sfx']] != '0')
      {
        $exchange_systems[$id]['status'] = 1;
        continue;
      }

      continue;
    }
  }

  if (isset ($frm_cookie))
  {
    if (isset ($frm_cookie['password']))
    {
      if ($frm['a'] != 'do_login')
      {
        $username = $frm_cookie['username'];
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
        if (0 < $user_id)
        {
          $q = 'SELECT *, date_format(date_register, \'%b-%e-%Y\') AS create_account_date, now() - interval 2 minute > l_e_t as should_count FROM hm2_users WHERE id = ' . $user_id . ' and (status=\'on\' or status=\'suspended\') ' . $add_login_check;
          $sth = mysql_query ($q);
          while ($row = mysql_fetch_array ($sth))
          {
            if ($settings['brute_force_handler'] == 1)
            {
              if ($row['activation_code'] != '')
              {
                setcookie ('password', '', time () + 630720000);
                header ('Location: page_login.php?say=invalid_login&username=' . $frm['username']);
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
              $q = 'UPDATE hm2_users SET last_access_time = now() WHERE username=\'' . $username . '\'';
              if (!(mysql_query ($q)))
              {
                exit (mysql_error ());
              }

              continue;
            }
          }
        }
      }
    }
  }

  if ($userinfo['logged'] == 1)
  {
    if ($userinfo['should_count'] == 1)
    {
      count_earning ($userinfo['id']);
    }
  }

  if ($userinfo['id'] == 1)
  {
    $userinfo['logged'] = 0;
  }

  if ($userinfo['logged'] == 1)
  {
    $q = 'SELECT type, SUM(actual_amount) AS s FROM hm2_history WHERE user_id = ' . $userinfo['id'] . ' GROUP BY type';
    $sth = mysql_query ($q);
    $balance = 0;
    while ($row = mysql_fetch_array ($sth))
    {
      if ($row['type'] == 'deposit')
      {
        $userinfo['total_deposited'] = number_format (abs ($row['s']), 2);
      }

      if ($row['type'] == 'earning')
      {
        $userinfo['total_earned'] = number_format (abs ($row['s']), 2);
      }

      $balance += $row['s'];
    }

    $userinfo['balance'] = number_format (abs ($balance), 2);
  }

  $smarty->assign ('userinfo', $userinfo);
  if ($frm['ref'] != '')
  {
    setcookie ('Referer', $frm['ref'], time () + 630720000);
    $q = 'SELECT came_from FROM hm2_users WHERE id = 1';
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $row = mysql_fetch_array ($sth);

/*-- Remarded by deZender, 2008.8.7: begin --*
    if ($row['came_from'] != $mddomain)
    {
      db_close ($dbconn);
      exit ();
    }
*-- Remarded by deZender, 2008.8.7: begin --*/

    if ($frm_cookie['Referer'] == '')
    {
      $ref = quote ($frm['ref']);
      $q = 'SELECT id FROM hm2_users WHERE username = \'' . $ref . '\'';
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      if ($row = mysql_fetch_array ($sth))
      {
        $ref_id = $row['id'];
        $q = 'select * from hm2_referal_stats where date = current_date() and user_id = ' . $ref_id;
        if (!($sth = mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }

        $f = 0;
        while ($row = mysql_fetch_array ($sth))
        {
          $f = 1;
        }

        if ($f == 0)
        {
          $q = 'INSERT INTO hm2_referal_stats SET date = current_date(),user_id = ' . $ref_id . ', income = 1, reg = 0';
        }
        else
        {
          $q = 'UPDATE hm2_referal_stats SET income = income+1 WHERE date = current_date() AND user_id =' . $ref_id;
        }

        $sth = mysql_query ($q);
      }
    }

    if ($settings['redirect_referrals'] != '')
    {
      header ('Location: ' . $settings['redirect_referrals']);
      db_close ($dbconn);
      exit ();
    }
  }

  $q = 'DELETE FROM hm2_online WHERE ip=\'' . $frm_env['REMOTE_ADDR'] . '\' OR date + interval 30 minute < now()';
  if (!(mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $q = 'INSERT INTO hm2_online SET ip=\'' . $frm_env['REMOTE_ADDR'] . '\', date = now()';
  if (!(mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

?>