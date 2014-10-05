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

  $id = $userinfo['id'];
  $frm['day_to'] = sprintf ('%d', $frm['day_to']);
  $frm['month_to'] = sprintf ('%d', $frm['month_to']);
  $frm['year_to'] = sprintf ('%d', $frm['year_to']);
  $frm['day_from'] = sprintf ('%d', $frm['day_from']);
  $frm['month_from'] = sprintf ('%d', $frm['month_from']);
  $frm['year_from'] = sprintf ('%d', $frm['year_from']);
  if ($frm['day_to'] == 0)
  {
    $frm['day_to'] = date ('j', time () + $settings['time_dif'] * 60 * 60);
    $frm['month_to'] = date ('n', time () + $settings['time_dif'] * 60 * 60);
    $frm['year_to'] = date ('Y', time () + $settings['time_dif'] * 60 * 60);
    $frm['day_from'] = 1;
    $frm['month_from'] = $frm['month_to'];
    $frm['year_from'] = $frm['year_to'];
  }

  $datewhere = '\'' . $frm['year_from'] . '-' . $frm['month_from'] . '-' . $frm['day_from'] . '\' + interval 0 day < date + interval ' . $settings['time_dif'] . ' hour and \'' . $frm['year_to'] . '-' . $frm['month_to'] . '-' . $frm['day_to'] . '\' + interval 1 day > date + interval ' . $settings['time_dif'] . ' hour ';
  $typewhere = ' and type in (\'deposit\', \'early_deposit_release\', \'release_deposit\', \'early_deposit_charge\')';
  $order = ($settings['use_history_balance_mode'] ? 'asc' : 'desc');
  $dformat = ($settings['use_history_balance_mode'] ? '%b-%e-%Y<br>%r' : '%b-%e-%Y %r');
  $q = 'SELECT *, date_format(date + interval ' . $settings['time_dif'] . (' hour, \'' . $dformat . '\') AS d FROM hm2_history WHERE ' . $datewhere . ' ' . $typewhere . ' and user_id = ' . $id . ' order by date ' . $order . ', id ' . $order);
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $trans = array ();
  while ($row = mysql_fetch_array ($sth))
  {
    $row['transtype'] = $transtype[$row['type']];
    $row['debitcredit'] = ($row['actual_amount'] < 0 ? 1 : 0);
    $row['orig_amount'] = $row['actual_amount'];
    $row['actual_amount'] = number_format (abs ($row['actual_amount']), 2);
    array_push ($trans, $row);
  }

  if ($settings['use_history_balance_mode'])
  {
    $perioddebit = 0;
    $periodcredit = 0;
    for ($i = 0; $i < sizeof ($trans); ++$i)
    {
      $start_id = $trans[$i]['id'];
      $q = 'SELECT SUM(actual_amount) as balance from hm2_history where id < ' . $start_id . ' and user_id = ' . $userinfo['id'];
      $sth = mysql_query ($q);
      $row = mysql_fetch_array ($sth);
      $start_balance = $row['balance'];
      $trans[$i]['balance'] = number_format ($start_balance + $trans[$i]['orig_amount'], 2);
    }

    $q = 'SELECT SUM(actual_amount * (actual_amount < 0)) as debit, SUM(actual_amount * (actual_amount > 0)) as credit, SUM(actual_amount) as balance FROM hm2_history where ' . $datewhere . ' ' . $typewhere . ' and user_id = ' . $userinfo['id'];
    $sth = mysql_query ($q);
    $row = mysql_fetch_array ($sth);
    $start_balance = $row['balance'];
    $perioddebit = $row['debit'];
    $periodcredit = $row['credit'];
    $periodbalance = $row['balance'];
    $smarty->assign ('perioddebit', number_format (abs ($perioddebit), 2));
    $smarty->assign ('periodcredit', number_format (abs ($periodcredit), 2));
    $smarty->assign ('periodbalance', number_format ($periodbalance, 2));
    $q = 'SELECT SUM(actual_amount * (actual_amount < 0)) as debit, SUM(actual_amount * (actual_amount > 0)) as credit, SUM(actual_amount) as balance FROM hm2_history where 1=1 ' . $typewhere . ' and user_id = ' . $userinfo['id'];
    $sth = mysql_query ($q);
    $row = mysql_fetch_array ($sth);
    $start_balance = $row['balance'];
    $perioddebit = $row['debit'];
    $periodcredit = $row['credit'];
    $periodbalance = $row['balance'];
    $smarty->assign ('alldebit', number_format (abs ($perioddebit), 2));
    $smarty->assign ('allcredit', number_format (abs ($periodcredit), 2));
    $smarty->assign ('allbalance', number_format ($periodbalance, 2));
  }

  $q = 'SELECT SUM(actual_amount) as periodsum from hm2_history where ' . $datewhere . ' and user_id = ' . $id . ' and type in (\'deposit\', \'early_deposit_release\', \'release_deposit\', \'early_deposit_charge\')';
  $sth = mysql_query ($q);
  $row = mysql_fetch_array ($sth);
  $periodsum = $row['periodsum'];
  $smarty->assign ('periodsum', number_format (0 - $periodsum, 2));
  $q = 'SELECT SUM(actual_amount) as sum from hm2_history where 1=1 ' . $userwhere . ' and user_id = ' . $id . ' and type in (\'deposit\', \'early_deposit_release\', \'release_deposit\', \'early_deposit_charge\')';
  $sth = mysql_query ($q);
  $row = mysql_fetch_array ($sth);
  $allsum = $row['sum'];
  $smarty->assign ('allsum', number_format (0 - $allsum, 2));
  $month = array ('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
  $smarty->assign ('month', $month);
  $days = array ();
  for ($i = 1; $i <= 31; ++$i)
  {
    array_push ($days, $i);
  }

  $smarty->assign ('day', $days);
  $year = array ();
  for ($i = $settings['site_start_year']; $i <= date ('Y', time () + $settings['time_dif'] * 60 * 60); ++$i)
  {
    array_push ($year, $i);
  }

  $smarty->assign ('year', $year);
  $smarty->assign ('trans', $trans);
  $smarty->assign ('qtrans', sizeof ($trans));
  $smarty->assign ('frm', $frm);
  $smarty->display ('account_deposit_history.tpl');
?>