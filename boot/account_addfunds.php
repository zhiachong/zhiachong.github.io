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

  if ($settings[use_add_funds] == 1)
  {
    $ab = get_user_balance ($userinfo['id']);
    $ab_formated = array ();
    while (list ($kk, $vv) = each ($ab))
    {
      $ab_formated[$kk] = number_format ($vv, 2);
    }

    $smarty->assign ('ab_formated', $ab_formated);
    $smarty->assign ('frm', $frm);
    $q = 'SELECT SUM(actual_amount) AS sm, ec FROM hm2_history where user_id =' . $userinfo['id'] . ' GROUP BY ec';
    $sth = mysql_query ($q);
    while ($row = mysql_fetch_array ($sth))
    {
      $exchange_systems[$row['ec']]['balance'] = number_format ($row['sm'], 2);
    }

    $ps = array ();
    reset ($exchange_systems);
    foreach ($exchange_systems as $id => $data)
    {
      array_push ($ps, array_merge (array ('id' => $id), $data));
    }

    $smarty->assign ('ps', $ps);
    $smarty->display ('account_add_funds.tpl');
    return 1;
  }

  $smarty->display ('account_main.tpl');
?>