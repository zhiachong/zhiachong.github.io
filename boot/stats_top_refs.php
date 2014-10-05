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
    if ($settings['show_refs10_stats'])
    {
      $q = 'SELECT u1.username, u1.id, count(*) as col FROM hm2_users as u1 left outer join hm2_users as u2 ON u1.id = u2.ref WHERE u2.date_register > \'' . $settings[refs10_start_date] . '\' + interval ' . $settings['time_dif'] . ' hour GROUP BY u1.username having col > 0 ORDER BY col desc, u1.id limit 0, 20';
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $stats = array ();
      while ($row = mysql_fetch_array ($sth))
      {
        $q2 = 'SELECT count(distinct u.id) as col FROM hm2_users as u, hm2_deposits as d WHERE u.ref = ' . $row[id] . '  AND u.id = d.user_id ';
        if (!($sth1 = mysql_query ($q2)))
        {
          echo mysql_error ();
          true;
        }

        $row1 = mysql_fetch_array ($sth1);
        $row[active_col] = $row1[col];
        array_push ($stats, $row);
      }

      $q = 'SELECT date_format(\'' . $settings[refs10_start_date] . '\' + interval ' . $settings['time_dif'] . ' hour, \'%b-%e-%Y\') as d';
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $row = mysql_fetch_array ($sth);
      $smarty->assign ('start_date', $row[d]);
      $smarty->assign ('stats', $stats);
      $smarty->display ('stats_top_refs.tpl');
      return 1;
    }
  }

  $smarty->display ('home.tpl');
?>