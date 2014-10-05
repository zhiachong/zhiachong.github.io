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


  include 'inc/config.inc.php';
  $dbconn = db_open ();
  if (!($dbconn))
  {
    echo 'Cannot connect mysql';
    exit ();
  }

  $mymd5 = decode_pass_for_mysql ($settings['md5altphrase_pecunix']);
  if ($frm['A'] == 'pay_withdraw')
  {
    $batch = quote ($frm['PAYMENT_REC_ID']);
    list ($id, $str) = explode ('-', $frm['withdraw']);
    $id = sprintf ('%d', $id);
    if ($str == '')
    {
      $str = 'abcdef';
    }

    $str = quote ($str);
    $q = 'SELECT * FROM hm2_history WHERE id =' . $id . ' AND str = ' . $str . ' AND type=\'withdraw_pending\'';
    $sth = mysql_query ($q);
    while ($row = mysql_fetch_array ($sth))
    {
      $q = 'DELETE FROM hm2_history WHERE id =' . $id . '';
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
      }

      $q = 'INSERT INTO hm2_history SET 
	user_id = ' . $row['user_id'] . ',
	amount = -' . abs ($row['amount']) . ',
	type = \'withdrawal\',
	description = \'Withdraw processed. Batch id =' . $batch . ',
	actual_amount = -' . abs ($row['amount']) . ',
	ec = 9,
	date = now()
	';
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
      }

      $q = 'SELECT * FROM hm2_users WHERE id = ' . $row['user_id'];
      $usth = mysql_query ($q);
      $userinfo = mysql_fetch_array ($usth);
      $info = array ($user);
      $info['username'] = $userinfo['username'];
      $info['name'] = $userinfo['name'];
      $info['amount'] = sprintf ('%.02f', abs ($row['amount']));
      $info['account'] = $frm['PAYEE_ACCOUNT'];
      $info['batch'] = $batch;
      $info['paying_batch'] = $batch;
      $info['receiving_batch'] = $batch;
      $info['currency'] = $exchange_systems[9]['name'];
      send_mail ('withdraw_user_notification', $userinfo['email'], $settings['system_email'], $info);
    }

    echo 'HyipManagerScript.com';
    db_close ($dbconn);
    exit ();
  }

  $hash = strtoupper (md5 ($frm['PAYEE_ACCOUNT'] . ':' . $frm['PAYMENT_AMOUNT'] . ':' . $frm['PAYMENT_UNITS'] . ':' . $frm['PAYER_ACCOUNT'] . ':' . $frm['PAYMENT_REC_ID'] . ':' . $frm['PAYMENT_GRAMS'] . ':' . $frm['PAYMENT_ID'] . ':' . $frm['PAYMENT_FEE'] . ':' . $frm['TXN_DATETIME'] . ':' . $mymd5));
  if ($hash == strtoupper ($frm['PAYMENT_HASH']))
  {
    if (strtolower ($settings['def_payee_account_pecunix']) == strtolower ($frm['PAYEE_ACCOUNT']))
    {
      if ($exchange_systems[9]['status'] == 1)
      {
        if (0 < $frm['PAYMENT_REC_ID'])
        {
          $user_id = sprintf ('%d', $frm['USERID']);
          $h_id = sprintf ('%d', $frm['HYIPID']);
          $compound = sprintf ('%d', $frm['COMPOUND']);
          $amount = $frm['PAYMENT_AMOUNT'];
          $batch = $frm['PAYMENT_REC_ID'];
          $account = $frm['PAYER_ACCOUNT'];
          if ($frm['A'] == 'checkpayment')
          {
            if ($frm['PAYMENT_UNITS'] == 'USD')
            {
              add_deposit (9, $user_id, $amount, $batch, $account, $h_id, $compound);
            }
          }
        }
      }
    }
  }

  db_close ($dbconn);
  echo 'HyipManagerScript.com';
  exit ();
?>