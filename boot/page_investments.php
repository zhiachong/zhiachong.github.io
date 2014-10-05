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
  $smarty->assign ('frm', $frm);
  $already_deposits = array ();
  if (0 < $userinfo['id'])
  {
    $q = 'select type_id from hm2_deposits where user_id = ' . $userinfo['id'];
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    while ($row = mysql_fetch_array ($sth))
    {
      array_push ($already_deposits, $row['type_id']);
    }
  }

  $q = 'select * from hm2_types where status = \'on\' order by id';
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $plans = array ();
  while ($row = mysql_fetch_array ($sth))
  {
    if (!(((0 < $userinfo['id'] AND 0 < $row['parent']) AND !in_array ($row['parent'], $already_deposits))))
    {
      $q = 'select * from hm2_plans where parent = ' . $row['id'] . ' order by id';
      if (!($sth1 = mysql_query ($q)))
      {
        exit (mysql_error ());
      }

      $row['plans'] = array ();
      while ($row1 = mysql_fetch_array ($sth1))
      {
        $row1['deposit'] = '';
        if ($row1['max_deposit'] == 0)
        {
          $row1['deposit'] = '$' . number_format ($row1['min_deposit']) . ' and more';
        }
        else
        {
          $row1['deposit'] = '$' . number_format ($row1['min_deposit']) . ' - $' . number_format ($row1['max_deposit']);
        }

        array_push ($row['plans'], $row1);
      }

      $periods = array ('d' => 'Daily', 'w' => 'Weekly', 'b-w' => 'Bi Weekly', 'm' => 'Monthly', 'y' => 'Yearly');
      $row['period'] = $periods[$row['period']];
      array_push ($plans, $row);
      continue;
    }
  }

  $smarty->assign ('index_plans', $plans);
  $q = 'select max(percent) as percent from hm2_referal';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $smarty->assign ('percent', $row['percent']);
  }

  $ref_plans = array ();
  $q = 'select * from hm2_referal order by from_value';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    array_push ($ref_plans, $row);
  }

  $smarty->assign ('ref_plans', $ref_plans);
  $ref_levels = array ();
  for ($l = 2; $l < 11; ++$l)
  {
    if (0 < $settings['ref' . $l . '_cms'])
    {
      if ($settings['ref' . $l . '_cms'] < 100)
      {
        array_push ($ref_levels, array ('level' => $l, 'percent' => $settings['ref' . $l . '_cms']));
        continue;
      }

      continue;
    }
  }

  $smarty->assign ('ref_levels', $ref_levels);
  $smarty->display ('page_investments.tpl');
?>