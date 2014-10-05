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
  $q = 'SELECT * FROM hm2_news';
  $sth = mysql_query ($q);
  $count_all = mysql_num_rows ($sth);
  $page = $frm['page'];
  $onpage = 20;
  $colpages = ceil ($count_all / $onpage);
  if ($page <= 1)
  {
    $page = 1;
  }

  if ($colpages < $page)
  {
    if (1 < $colpages)
    {
      $page = $colpages;
    }
  }

  $from = ($page - 1) * $onpage;
  $q = 'SELECT *, date_format(date + interval ' . $settings['time_dif'] . (' hour, \'%b-%e-%Y %r\') as d FROM hm2_news ORDER BY date DESC LIMIT ' . $from . ', ' . $onpage);
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $news = array ();
  while ($row = mysql_fetch_array ($sth))
  {
    if ($row['full_text'] == '')
    {
      $row['full_text'] = $row['small_text'];
    }

    $row['full_text'] = preg_replace ('/
/', '<br>', $row['full_text']);
    array_push ($news, $row);
  }

  $smarty->assign ('news', $news);
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

  $smarty->display ('page_news.tpl');
?>