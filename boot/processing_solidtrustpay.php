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

  if ($frm['user2'] == 'pay_withdraw')
  {
    $batch = $frm['tr_id'];
    $withdraw_string = $frm['user1'];
    $payee = $frm['merchantAccount'];
    admin_pay_withdraw ($batch, $withdraw_string, $payee, 2);
    echo 1;
    db_close ($dbconn);
    exit ();
  }

  $secondary_password = $settings['md5altphrase_solidtrustpay'];
  $hash_received = md5 ($_POST['tr_id'] . ':' . md5 ($secondary_password) . ':' . $_POST['amount'] . ':' . $settings['def_payee_account_solidtrustpay'] . ':' . $_POST['payerAccount']);
  if (strtoupper ($hash_received) == strtoupper ($frm['hash']))
  {
    if ($exchange_systems[2]['status'] == 1)
    {
      $user_id = sprintf ('%d', $frm['user1']);
      $h_id = sprintf ('%d', $frm['user2']);
      $compound = sprintf ('%d', $frm['user4']);
      $amount = $frm['amount'];
      $batch = $frm['tr_id'];
      $account = $frm['payerAccount'];
      if ($frm['user3'] == 'checkpayment')
      {
        if ($frm['status'] == 'COMPLETE')
        {
          add_deposit (2, $user_id, $amount, $batch, $account, $h_id, $compound);
        }
      }
    }
  }

  db_close ($dbconn);
  exit ();
?>