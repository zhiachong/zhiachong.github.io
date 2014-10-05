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


  session_start ();
  include 'inc/config.inc.php';
  setcookie ('password', 'hyipmanagerscript', time () + 630720000);
  $frm_cookie['username'] = '';
  $frm_cookie['password'] = '';
  if ($settings['redirect_logout'] != '')
  {
    header ('Location: ' . $settings['redirect_logout']);
    db_close ($dbconn);
    exit ();
  }

  $frm['a'] = '';
  header ('Location: ' . $settings['site_url']);
?>