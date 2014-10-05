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
  $id = sprintf ('%d', $frm['id']);
  $q = 'SELECT * FROM hm2_types where id = ' . $id;
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $flag = 0;
  while ($row = mysql_fetch_array ($sth))
  {
    $smarty->assign ('package', $row);
    $flag = 1;
  }

  if ($flag == 0)
  {
    $smarty->assign ('no_such_plan', 1);
  }

  $smarty->display ('page_package_info.tpl');
?>