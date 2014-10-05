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

  if ($frm['A'] == 'pay_withdraw')
  {
    $batch = $frm['PAYMENT_BATCH'];
    $withdraw_string = $frm['WITHDRAW'];
    $payee = $frm['PAYEE_ACCOUNT'];
    admin_pay_withdraw ($batch, $withdraw_string, $payee, 8);
    echo 1;
    db_close ($dbconn);
    exit ();
  }

  $mymd5 = decode_pass_for_mysql ($settings['md5altphrase_altergold']);
  $hash = strtoupper (md5 ($frm['PAYEE_ACCOUNT'] . ':' . $frm['PAYER_ACCOUNT'] . ':' . $frm['PAYMENT_AMOUNT'] . ':' . $frm['PAYMENT_CURRENCY'] . ':' . $frm['PAYMENT_AMOUNT_USD'] . ':' . $frm['PAYMENT_FEES'] . ':' . $frm['TIMESTAMP'] . ':' . $frm['MERCHANT_REF'] . ':' . $mymd5));
  if ($hash == strtoupper ($frm['VERIFICATION_HASH']))
  {
    if ($exchange_systems[8]['status'] == 1)
    {
      $user_id = sprintf ('%d', $frm['USERID']);
      $h_id = sprintf ('%d', $frm['HYIPID']);
      $compound = sprintf ('%d', $frm['COMPOUND']);
      $amount = $frm['PAYMENT_AMOUNT_USD'];
      $batch = $frm['PAYMENT_BATCH'];
      $account = $frm['PAYER_ACCOUNT'];
      if ($frm['A'] == 'checkpayment')
      {
        add_deposit (8, $user_id, $amount, $batch, $account, $h_id, $compound);
      }
    }
  }

  db_close ($dbconn);
  echo 'www.HyipManagerScript.com';
  exit ();
?>