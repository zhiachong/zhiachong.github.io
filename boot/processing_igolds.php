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

  if ($frm['IGS_CUSTOM_a'] == 'pay_withdraw')
  {
    $batch = $frm['IGS_TRANSACTION_ID'];
    $payee = $frm['IGS_PAYEE_ACCOUNT'];
    $withdraw_string = $frm['IGS_CUSTOM_withdraw'];
    admin_pay_withdraw ($batch, $withdraw_string, $payee, 12);
    echo 1;
    db_close ($dbconn);
    exit ();
  }

  if (!function_exists ('sha1'))
  {
    require_once 'inc/sha1.class.php';
    function sha1($str)
    {
      $sha = new SHA1; 
      $hasharray = $sha->hash_string($str);
      $r = '';
      for ($i = 0; $i < 5; $i++)
      {
        $r .= sprintf('%08x', $hasharray[$i]);
      }
      
      return $r;
    }
  }
  
  $igs_account = $settings['def_payee_account_igolds'];
  $mpassword = decode_pass_for_mysql($settings['md5altphrase_igolds']);
  $IGS_PAYEE_ACCOUNT = intval($frm['IGS_PAYEE_ACCOUNT']);
  $IGS_CURRENCY = intval($frm['IGS_CURRENCY']);
  $IGS_AMOUNT = sprintf('%.2f', $frm['IGS_AMOUNT']);
  $IGS_TRANSACTION_ID = intval($frm['IGS_TRANSACTION_ID']);
  $IGS_PAYMENT_ID = (isset ($frm['IGS_PAYMENT_ID']) ? intval($frm['IGS_PAYMENT_ID']) : '');
  $IGS_PAYER_ACCOUNT = intval($frm['IGS_PAYER_ACCOUNT']);
  $IGS_TIME_STAMP = intval($frm['IGS_TIME_STAMP']);
  
  $v_str = "$IGS_PAYEE_ACCOUNT,$IGS_CURRENCY,$IGS_AMOUNT,$IGS_TRANSACTION_ID,,$IGS_PAYER_ACCOUNT,$IGS_TIME_STAMP,$mpassword";

  $hash = strtoupper (sha1 ($v_str));

/*
  $fp = fopen ('./tmpl_c/igolds_log', 'a');
  fwrite ($fp, '


');
  fwrite ($fp, 'mpass = ' . $mpassword . '
');
  fwrite ($fp, 'hash(' . $v_str . ') = ' . $hash . '
');
  fwrite ($fp, 'IGS_HASH = ' . $frm['IGS_HASH'] . '
');
  fwrite ($fp, 'ip = ' . $frm_env['REMOTE_ADDR'] . '
');
  fclose ($fp);
*/

  if ($igs_account == $IGS_PAYEE_ACCOUNT AND $hash == strtoupper ($frm['IGS_HASH']))
  {
    if ($exchange_systems[12]['status'] == 1)
    {
      $ip = $frm_env['REMOTE_ADDR'];
      if (!(preg_match ('/75\\.125\\.231\\.\\d/i', $ip)))
      {
        exit ();
      }

      $user_id = sprintf ('%d', $frm['IGS_CUSTOM_userid']);
      $h_id = sprintf ('%d', $frm['IGS_CUSTOM_hyipid']);
      $compound = sprintf ('%d', $frm['IGS_CUSTOM_compound']);
      $amount = $IGS_AMOUNT;
      $batch = $IGS_TRANSACTION_ID;
      $account = $IGS_PAYER_ACCOUNT;
      if ($frm['IGS_CUSTOM_a'] == 'checkpayment')
      {
        if ($IGS_CURRENCY == 2)
        {
          add_deposit (12, $user_id, $amount, $batch, $account, $h_id, $compound);
        }
      }
    }
  }

  db_close ($dbconn);
  echo 'www.HyipManagerScript.com';
  exit ();
?>