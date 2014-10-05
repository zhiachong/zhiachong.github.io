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

  $lr_account = $settings['def_payee_account_libertyreserve'];
  $lr_store = $settings['md5altphrase_libertyreserve_store'];
  $secondary_password = decode_pass_for_mysql ($settings['md5altphrase_libertyreserve']);
  $hash_recieved = $_REQUEST['lr_paidto'] . ':' . $_REQUEST['lr_paidby'] . ':' . stripslashes ($_REQUEST['lr_store']) . ':' . $_REQUEST['lr_amnt'] . ':' . $_REQUEST['lr_transfer'] . ':' . $_REQUEST['lr_currency'] . ':' . $secondary_password;
  if (function_exists ('mhash'))
  {
    $hash_recieved = strtoupper (bin2hex (mhash (MHASH_SHA256, $hash_recieved)));
  }
  else
  {
    require_once 'inc/lrsha256_class.php';
    $hash_recieved = strtoupper (sha256::hash ($hash_recieved));
  }

  if (isset ($_REQUEST['lr_paidto']))
  {
    if ($_REQUEST['lr_paidto'] == strtoupper ($lr_account))
    {
      if (isset ($_REQUEST['lr_store']))
      {
        if (stripslashes ($_REQUEST['lr_store']) == $lr_store)
        {
          if ($_REQUEST['lr_encrypted'] == $hash_recieved)
          {
            if ($exchange_systems[1]['status'] == 1)
            {
              $user_id = sprintf ('%d', $frm['userid']);
              $h_id = sprintf ('%d', $frm['hyipid']);
              $compound = sprintf ('%d', $frm['compound']);
              $amount = $_REQUEST['lr_amnt'];
              $batch = $_REQUEST['lr_transfer'];
              $account = $_REQUEST['lr_paidby'];
              add_deposit (1, $user_id, $amount, $batch, $account, $h_id, $compound);
            }
          }
        }
      }
    }
  }

  db_close ($dbconn);
  echo 'www.HyipManagerScript.com';
  exit ();
?>