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
    $batch = $frm['transaction_id'];
    $withdraw_string = $frm['withdraw'];
    $payee = $frm['payee_account'];
    admin_pay_withdraw ($batch, $withdraw_string, $payee, 7);
    echo 1;
    db_close ($dbconn);
    exit ();
  }

  $mymd5 = decode_pass_for_mysql ($settings['md5altphrase_cgold']);
  $hash = strtoupper (md5 ($frm['transaction_id'] . ':' . $frm['pay_from'] . ':' . $frm['payee_account'] . ':' . $frm['payment_amount'] . ':' . $frm['payment_units'] . ':' . $mymd5));
  if ($hash == strtoupper ($frm['verify_hash']))
  {
    if ($exchange_systems[7]['status'] == 1)
    {
      $user_id = sprintf ('%d', $frm['userid']);
      $h_id = sprintf ('%d', $frm['hyipid']);
      $compound = sprintf ('%d', $frm['compound']);
      $amount = $frm['payment_amount'];
      $batch = $frm['transaction_id'];
      $account = $frm['pay_from'];
      if ($frm['a'] == 'checkpayment')
      {
        if ($frm['payment_units'] == 'USD worth')
        {
          add_deposit (7, $user_id, $amount, $batch, $account, $h_id, $compound);
        }
      }
    }
  }

  db_close ($dbconn);
  echo 'www.HyipManagerScript.com';
  exit ();
?>