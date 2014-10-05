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
  $activation_code = quote ($frm['code']);
  $code_found = 0;
  if ($activation_code != '')
  {
    $q = 'SELECT id FROM hm2_users where activation_code = \'' . $activation_code . '\'';
    $sth = mysql_query ($q);
    while ($row = mysql_fetch_array ($sth))
    {
      $q = 'UPDATE hm2_users SET bf_counter = 0, activation_code = \'\' WHERE id = ' . $row['id'];
      mysql_query ($q);
      $code_found = 1;
    }
  }

  $smarty->assign ('activated', $code_found);
  $smarty->display ('page_activate_account.tpl');
?>