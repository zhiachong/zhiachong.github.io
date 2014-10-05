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


  $arr = get_defined_vars ();
  while (list ($kk, $vv) = each ($arr))
  {
    if (gettype ($$kk) != 'array')
    {
      $$kk = '';
      continue;
    }
  }

  if (file_exists ('install.php'))
  {
    echo 'DELETE or RENAME install.php file in order to access the site!';
    exit ();
  }

  include 'inc/config.inc.php';
  if ($frm_env['HTTPS'])
  {
    $settings[SSL_USED] = 1;
  }

  if (!($frm_env['HTTPS']))
  {
    if ($settings['redirect_to_https'] == 1)
    {
      $url = 'https://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      if ($env_frm['QUERY_STRING'])
      {
        $url .= $env_frm['QUERY_STRING'];
      }

      header ('Location: ' . $url);
      exit ();
    }
  }

  if ($settings['ssl_url'] != '')
  {
    if ($SERVER_PORT == 80)
    {
      header ('Location: ' . $settings['ssl_url'] . '/');
      db_close ($dbconn);
      exit ();
    }
  }

  if ($frm['a'] == 'run_crontab')
  {
    count_earning (-2);
    db_close ($dbconn);
    exit ();
  }

  $already_deposits = array ();
  if (0 < $userinfo['id'])
  {
    $q = 'SELECT type_id FROM hm2_deposits WHERE user_id = ' . $userinfo['id'];
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

  $q = 'SELECT * FROM hm2_types WHERE status = \'on\' ORDER BY id';
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
      $q = 'SELECT * FROM hm2_plans WHERE parent = ' . $row['id'] . ' ORDER BY id';
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
  $q = 'SELECT max(percent) AS percent FROM hm2_referal';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $smarty->assign ('percent', $row['percent']);
  }

  $ref_plans = array ();
  $q = 'SELECT * FROM hm2_referal ORDER BY from_value';
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
  $smarty->display ('page_home.tpl');
  db_close ($dbconn);
  exit ();
?>