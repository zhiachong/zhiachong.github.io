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


  if ($settings['show_news_box'])
  {
    if (!($max_news = $settings['last_news_count']))
    {
      true;
    }

    $q = 'SELECT *, date_format(date + interval ' . $settings['time_dif'] . (' hour, \'%b-%e-%Y %r\') AS d FROM hm2_news ORDER BY date DESC LIMIT  0, ' . $max_news);
    if (!($sth = mysql_query ($q)))
    {
      echo mysql_error ();
      true;
    }

    $news = array ();
    while ($row = mysql_fetch_array ($sth))
    {
      if ($row['small_text'] == '')
      {
        $row['full_text'] = strip_tags ($row['full_text']);
        $row['small_text'] = preg_replace ('/^(.{100,120})\\s.*/', '$1...', $row['full_text']);
      }

      $row['small_text'] = preg_replace ('/
/', '<br>', $row['small_text']);
      array_push ($news, $row);
    }

    if (sizeof ($news) == 0)
    {
      $settings['show_news_box'] = 0;
    }
    else
    {
      $smarty->assign ('news', $news);
    }
  }
  else
  {
    $settings['show_news_box'] = 0;
  }

  $smarty->assign ('settings', $settings);
?>