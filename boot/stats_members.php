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
    if ($settings['show_members_stats'])
    {
      function compare ($m, $m2)
      {
        return strcmp ($m['username'], $m2['username']);
      }

      $q = 'SELECT COUNT(distinct(user_id)) as cnt FROM hm2_history WHERE type in (\'deposit\', \'earning\', \'withdrawal\') AND user_id != 1';
      $q = 'select count(distinct(user_id)) as cnt FROM hm2_deposits';
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $row = mysql_fetch_array ($sth);
      $count_all = $row['cnt'];
      $q = 'SELECT u.username, h.type, SUM(h.actual_amount) as amt FROM hm2_users as u left outer join hm2_history as h on u.id = h.user_id WHERE h.type in (\'deposit\', \'earning\', \'withdrawal\') and user_id != 1 GROUP BY h.type, u.username';
      if (!($sth = mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $stats = array ();
      while ($row = mysql_fetch_array ($sth))
      {
        $stats[$row['username']][$row['type']] = $row['amt'];
      }

      $total = array ();
      $astats = array ();
      if ($stats)
      {
        foreach ($stats as $k => $row)
        {
          $row['username'] = $k;
          $total['deposit'] += abs ($row['deposit']);
          $total['earning'] += abs ($row['earning']);
          $total['withdrawal'] += abs ($row['withdrawal']);
          $row['deposit'] = number_format (abs ($row['deposit']), 2);
          $row['earning'] = number_format (abs ($row['earning']), 2);
          $row['withdrawal'] = number_format (abs ($row['withdrawal']), 2);
          array_push ($astats, $row);
        }
      }

      $total['deposit'] = number_format ($total['deposit'], 2);
      $total['earning'] = number_format ($total['earning'], 2);
      $total['withdrawal'] = number_format ($total['withdrawal'], 2);
      $smarty->assign ('total', $total);
      usort ($astats, compare);
      $page = $frm['page'];
      $onpage = 20;
      $colpages = ceil ($count_all / $onpage);
      if ($page <= 1)
      {
        $page = 1;
      }

      if ($colpages < $page)
      {
        $page = $colpages;
      }

      $from = ($page - 1) * $onpage;
      $astats = array_slice ($astats, $from, $onpage);
      $smarty->assign ('stats', $astats);
      $pages = array ();
      for ($i = 1; $i <= $colpages; ++$i)
      {
        $apage = array ();
        $apage['page'] = $i;
        $apage['current'] = ($i == $page ? 1 : 0);
        array_push ($pages, $apage);
      }

      $smarty->assign ('pages', $pages);
      $smarty->assign ('colpages', $colpages);
      $smarty->assign ('current_page', $page);
      if (1 < $page)
      {
        $smarty->assign ('prev_page', $page - 1);
      }

      if ($page < $colpages)
      {
        $smarty->assign ('next_page', $page + 1);
      }

      $smarty->display ('stats_members.tpl');
    }
  }

?>