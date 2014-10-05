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


  if ($settings['show_info_box_members_online'] == 1)
  {
    $q = 'SELECT COUNT(*) AS col FROM hm2_users WHERE last_access_time + interval 30 minute > now()';
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $row = mysql_fetch_array ($sth);
    $settings['show_info_box_members_online_generated'] = $row['col'];
  }

  if ($settings['show_info_box_total_accounts'] == 1)
  {
    $q = 'SELECT COUNT(*) AS col FROM hm2_users WHERE id > 1';
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $row = mysql_fetch_array ($sth);
    $settings['info_box_total_accounts_generated'] = $row['col'];
  }

  if ($settings['show_info_box_active_accounts'] == 1)
  {
    $q = 'SELECT COUNT(distinct user_id) AS col FROM hm2_deposits ';
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $row = mysql_fetch_array ($sth);
    $settings['info_box_total_active_accounts_generated'] = $row['col'];
  }

  if ($settings['show_info_box_vip_accounts'] == 1)
  {
    $q = 'SELECT COUNT(distinct user_id) AS col FROM hm2_deposits WHERE actual_amount > ' . sprintf ('%.02f', $settings['vip_users_deposit_amount']);
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $row = mysql_fetch_array ($sth);
    $settings['info_box_total_vip_accounts_generated'] = $row['col'];
  }

  if ($settings['show_info_box_deposit_funds'] == 1)
  {
    $q = 'SELECT SUM(amount) AS sum FROM hm2_deposits';
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $row = mysql_fetch_array ($sth);
    $settings['info_box_deposit_funds_generated'] = number_format ($row['sum'], 2);
  }

  if ($settings['show_info_box_today_deposit_funds'] == 1)
  {
    $q = 'SELECT SUM(amount) AS sum FROM hm2_deposits WHERE TO_DAYS(deposit_date) = TO_DAYS(now() + interval ' . $settings['time_dif'] . ' day)';
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $row = mysql_fetch_array ($sth);
    $settings['info_box_today_deposit_funds_generated'] = number_format ($row['sum'], 2);
  }

  if ($settings['show_info_box_total_withdraw'] == 1)
  {
    $q = 'SELECT SUM(amount) AS sum FROM hm2_history WHERE type=\'withdrawal\'';
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $row = mysql_fetch_array ($sth);
    $settings['info_box_withdraw_funds_generated'] = number_format (abs ($row['sum']), 2);
  }

  if ($settings['show_info_box_visitor_online'] == 1)
  {
    $q = 'SELECT COUNT(*) AS sum FROM hm2_online';
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $row = mysql_fetch_array ($sth);
    $settings['info_box_visitor_online_generated'] = $row['sum'];
  }

  if ($settings['show_info_box_newest_member'] == 1)
  {
    $q = 'SELECT username FROM hm2_users WHERE status = \'on\' ORDER BY id DESC LIMIT 0,1';
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $row = mysql_fetch_array ($sth);
    $settings['show_info_box_newest_member_generated'] = $row['username'];
  }

  if ($settings['show_info_box_last_update'] == 1)
  {
    $settings['show_info_box_last_update_generated'] = date ('M j, Y', time () + $settings['time_dif'] * 60 * 60);
  }

?>