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
  $id = intval ($frm['type']);
  $plans = array ();
  $q = 'SELECT *, 
               date_format(now() + interval ' . $settings['time_dif'] . ' hour, \'%m/%d/%Y\') as from_date,
               date_format((now() + interval ' . $settings['time_dif'] . (' hour) + interval q_days day, \'%m/%d/%Y\') as to_date
        from hm2_types where id = ' . $id);
  if (!($sth = mysql_query ($q)))
  {
    exit (mysql_error ());
  }

  $trow = mysql_fetch_array ($sth);
  if (!($trow))
  {
    $smarty->assign ('error', 'type_not_found');
    $smarty->display ('calendar_simple.tpl');
    exit ();
  }

  $i = 0;
  $q = 'SELECT * from hm2_plans where parent = ' . $id . ' ORDER BY id';
  if (!($sth = mysql_query ($q)))
  {
    exit (mysql_error ());
  }

  while ($row = mysql_fetch_array ($sth))
  {
    $row['i'] = $i;
    ++$i;
    array_push ($plans, $row);
  }

  $smarty->assign ('plans', $plans);
  if ($trow['period'] == 'd')
  {
    if ($trow['work_week'])
    {
      $trow['period'] = 'w-d';
    }
  }

  $periods = array ('w-d' => 'Work Days', 'd' => 'Days', 'w' => 'Weeks', 'b-w' => 'Bi Weeks', 'm' => 'Months', '2m' => 'Bi-Months', '3m' => '3 Months', '6m' => '6 Months', 'y' => 'Years');
  $trow['period_name'] = $periods[$trow['period']];
  $trow['min_deposit'] = $plans[0][min_deposit];
  $smarty->assign ('type', $trow);
  if ($trow['period'] == 'end')
  {
    $smarty->display ('calendar_simple.tpl');
    return 1;
  }

  $smarty->display ('calendar.tpl');
?>