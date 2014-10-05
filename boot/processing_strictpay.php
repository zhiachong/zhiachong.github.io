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

  if ($frm['extra4'] == 'pay_withdraw')
  {
    $batch = $frm['transactionID'];
    $withdraw_string = $frm['extra2'];
    $payee = $frm['payee_account'];
    admin_pay_withdraw ($batch, $withdraw_string, $payee, 11);
    echo 1;
    db_close ($dbconn);
    exit ();
  }

  $mymd5 = decode_pass_for_mysql ($settings['md5altphrase_strictpay']);
  $string = $_POST['payee_account'] . $_POST['amount'] . $mymd5;
  $hash = md5 ($string);
  if ($hash == $_POST['ver_string'])
  {
    if ($exchange_systems[11]['status'] == 1)
    {
      if ($settings['def_payee_account_strictpay'] == $_POST['payee_account'])
      {
        $user_id = sprintf ('%d', $frm['extra2']);
        $h_id = sprintf ('%d', $frm['extra3']);
        $compound = sprintf ('%d', $frm['extra1']);
        $amount = $frm['amount'];
        $batch = $frm['transactionID'];
        $account = $frm['payer_account'];
        if ($frm['extra4'] == 'checkpayment')
        {
          add_deposit (11, $user_id, $amount, $batch, $account, $h_id, $compound);
        }
      }
    }
  }

  db_close ($dbconn);
  echo 'www.HyipManagerScript.com';
  exit ();
?>