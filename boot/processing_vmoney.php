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

  if ($frm['CUSTOM_a'] == 'pay_withdraw')
  {
    if (isset ($frm['CUSTOM_withdraw']))
    {
      $batch = $frm['PMT_BATCH_NUM'];
      $withdraw_string = $frm['CUSTOM_withdraw'];
      $payee = $frm['PMT_MERCHANT_ACCOUNT'];
      admin_pay_withdraw ($batch, $withdraw_string, $payee, 3);
      echo 1;
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['CUSTOM_a'] == 'checkpaymentvmoney')
  {
    if ($frm['PMT_VERIFY_HASH'] != '')
    {
      if ($exchange_systems[3]['status'] == 1)
      {
        $secondary_password = decode_pass_for_mysql ($settings['md5altphrase_vmoney']);
        $frm['PMT_MERCHANT_ACCOUNT'] = $settings['def_payee_account_vmoney'];
        $hash_received = strtolower (md5 ($frm['PMT_MERCHANT_ACCOUNT'] . ';' . $frm['PMT_PAYER'] . ';' . $frm['PMT_AMOUNT'] . ';' . $frm['PMT_BATCH_NUM'] . ';' . $frm['PMT_TIMESTAMP'] . ';' . $secondary_password));
        if ($hash_received == strtolower ($frm['PMT_VERIFY_HASH']))
        {
          $user_id = sprintf ('%d', $frm['CUSTOM_userid']);
          $h_id = sprintf ('%d', $frm['CUSTOM_hyipid']);
          $compound = sprintf ('%d', $frm['CUSTOM_compound']);
          $amount = $frm['PMT_AMOUNT'];
          $batch = $frm['PMT_BATCH_NUM'];
          $account = $frm['PMT_PAYER'];
          add_deposit (3, $user_id, $amount, $batch, $account, $h_id, $compound);
        }
      }
    }
  }

  db_close ($dbconn);
  echo 'www.HyipManagerScript.com';
  exit ();
?>