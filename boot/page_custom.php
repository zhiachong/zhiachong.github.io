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
  $file = $frm['page'];
  $file = basename ($file);
  if (file_exists ('tmpl/custom/' . $file . '.tpl'))
  {
    $smarty->display ('custom/' . $file . '.tpl');
    db_close ($dbconn);
    exit ();
  }

  header ('Location: index.php');
  db_close ($dbconn);
  exit ();
?>