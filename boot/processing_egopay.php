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
	/* NEEDS FURTHER WORK */
  $alertpay_account = $settings['def_payee_account_alertpay'];
  $secret_code = $settings['md5altphrase_alertpay'];
  if ($_POST[ap_securitycode] == $secret_code)
  {
    if ($_POST['ap_status'] == 'Success')
    {
      $user_id = sprintf ('%d', $frm['apc_1']);
      $h_id = sprintf ('%d', $frm['apc_2']);
      $compound = sprintf ('%d', $frm['apc_4']);
      $amount = $frm['ap_amount'];
      $batch = $frm['ap_referencenumber'];
      $account = $frm['ap_custemailaddress'];
      if ($_POST['apc_3'] == 'checkpayment')
      {
        if ($exchange_systems[4]['status'] == 1)
        {
          add_deposit (4, $user_id, $amount, $batch, $account, $h_id, $compound);
          header ('Location: ' . $settings['site_url'] . '/processing_status.php?process=yes');
          exit ();
        }
      }

      header ('Location: processing_status.php?process=no');
    }
  }

  header ('Location: processing_status.php?process=no');
  db_close ($dbconn);
  exit ();
?>
