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
    admin_pay_withdraw ($batch, $withdraw_string, $payee, 10);
    echo 1;
    db_close ($dbconn);
    exit ();
  }

  $mymd5 = $settings['md5altphrase_perfectmoney'];
  $string = $_POST['PAYMENT_ID'] . ':' . $_POST['PAYEE_ACCOUNT'] . ':' . $_POST['PAYMENT_AMOUNT'] . ':' . $_POST['PAYMENT_UNITS'] . ':' . $_POST['PAYMENT_BATCH_NUM'] . ':' . $_POST['PAYER_ACCOUNT'] . ':' . $mymd5 . ':' . $_POST['TIMESTAMPGMT'];
  $hash = strtoupper (md5 ($string));
  if ($hash == strtoupper ($_POST['V2_HASH']))
  {
    if ($exchange_systems[10]['status'] == 1)
    {
      if ($settings['def_payee_account_perfectmoney'] == $_POST['PAYEE_ACCOUNT'])
      {
        if ($_POST['PAYMENT_UNITS'] == 'USD')
        {
          $user_id = sprintf ('%d', $frm['userid']);
          $h_id = sprintf ('%d', $frm['hyipid']);
          $compound = sprintf ('%d', $frm['compound']);
          $amount = $frm['PAYMENT_AMOUNT'];
          $batch = $frm['PAYMENT_BATCH_NUM'];
          $account = $frm['PAYER_ACCOUNT'];
          if ($frm['a'] == 'checkpayment')
          {
            if ($frm['PAYMENT_UNITS'] == 'USD')
            {
              add_deposit (10, $user_id, $amount, $batch, $account, $h_id, $compound);
            }
          }
        }
      }
    }
  }

  db_close ($dbconn);
  exit ();
?>