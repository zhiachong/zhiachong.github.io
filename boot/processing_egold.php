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

  if ($frm['a'] == 'pay_withdraw')
  {
    $batch = $frm['PAYMENT_BATCH_NUM'];
    $payee = $frm['PAYEE_ACCOUNT'];
    $withdraw_string = $frm['withdraw'];
    admin_pay_withdraw ($batch, $withdraw_string, $payee, 0);
    echo 1;
    db_close ($dbconn);
    exit ();
  }

  $mymd5 = $settings['md5altphrase'];
  $hash = strtoupper (md5 ($frm['PAYMENT_ID'] . ':' . $frm['PAYEE_ACCOUNT'] . ':' . $frm['PAYMENT_AMOUNT'] . ':' . $frm['PAYMENT_UNITS'] . ':' . $frm['PAYMENT_METAL_ID'] . ':' . $frm['PAYMENT_BATCH_NUM'] . ':' . $frm['PAYER_ACCOUNT'] . ':' . $mymd5 . ':' . $frm['ACTUAL_PAYMENT_OUNCES'] . ':' . $frm['USD_PER_OUNCE'] . ':' . $frm['FEEWEIGHT'] . ':' . $frm['TIMESTAMPGMT']));
  if ($hash == strtoupper ($frm['V2_HASH']))
  {
    if ($exchange_systems[0]['status'] == 1)
    {
      $ip = $frm_env['REMOTE_ADDR'];
      if (!(preg_match ('/63\\.240\\.230\\.\\d/i', $ip)))
      {
        exit ();
      }

      $user_id = sprintf ('%d', $frm['userid']);
      $h_id = sprintf ('%d', $frm['hyipid']);
      $compound = sprintf ('%d', $frm['compound']);
      $amount = $frm['PAYMENT_AMOUNT'];
      $batch = $frm['PAYMENT_BATCH_NUM'];
      $account = $frm['PAYER_ACCOUNT'];
      if ($frm['a'] == 'checkpayment')
      {
        if ($frm['PAYMENT_METAL_ID'] == 1)
        {
          if ($frm['PAYMENT_UNITS'] == 1)
          {
            add_deposit (0, $user_id, $amount, $batch, $account, $h_id, $compound);
          }
        }
      }
    }
  }

  db_close ($dbconn);
  echo 'www.HyipManagerScript.com';
  exit ();
?>