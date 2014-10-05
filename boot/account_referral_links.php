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
  if ($userinfo['logged'] == 0)
  {
    header ('location: page_login.php');
    exit ();
  }

  if ($settings['use_referal_program'] == 1)
  {
    $smarty->assign ('site_name', $settings['site_name']);
    if ($settings[use_names_in_referral_links] == 1)
    {
      $userinfo[name] = preg_replace ('/\\s+/', '_', $userinfo[name]);
      $userinfo[username] = $userinfo[name];
    }

    $smarty->assign ('user', $userinfo);
    $smarty->display ('account_referal_links.tpl');
    return 1;
  }

  $smarty->display ('account_main.tpl');
?>