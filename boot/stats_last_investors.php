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
  if ($settings['show_stats_box'])
  {
    if ($settings['show_last10_stats'])
    {
      $q = 'SELECT u.username, h.actual_amount as balance, date_format(h.deposit_date + interval ' . $settings['time_dif'] . ' hour, \'%b-%e-%Y %r\') as dd FROM hm2_deposits as h left outer join hm2_users as u on u.id = h.user_id WHERE h.status = \'on\' and u.id != 1 and u.status = \'on\' order by deposit_date desc limit 0, 10 ';
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $stats = array ();
      while ($row = mysql_fetch_array ($sth))
      {
        $row['balance'] = number_format (abs ($row['balance']), 2);
        array_push ($stats, $row);
      }

      $smarty->assign ('top', $stats);
      $smarty->display ('stats_last_investors.tpl');
    }
  }

?>