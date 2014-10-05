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


  if ($settings['demomode'] != 1)
  {
    if ($frm['action'] == 'add')
    {
      $title = quote ($frm['title']);
      $small_text = addslashes ($frm_orig['small_text']);
      $small_text = preg_replace ('/\\r/', '', $small_text);
      $full_text = addslashes ($frm_orig['full_text']);
      $full_text = preg_replace ('/\\r/', '', $full_text);
      $q = 'INSERT INTO hm2_news SET date=now(), title=\'' . $title . '\', small_text=\'' . $small_text . '\', full_text=\'' . $full_text . '\'';
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }
    }

    if ($frm['action'] == 'edit')
    {
      if ($frm['save'] == 1)
      {
        $id = intval ($frm['id']);
        $title = addslashes ($frm['title']);
        $small_text = addslashes ($frm_orig['small_text']);
        $small_text = preg_replace ('/\\r/', '', $small_text);
        $full_text = addslashes ($frm_orig['full_text']);
        $full_text = preg_replace ('/\\r/', '', $full_text);
        $q = 'UPDATE hm2_news SET title=\'' . $title . '\', small_text=\'' . $small_text . '\', full_text=\'' . $full_text . '\' where id = ' . $id;
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }

        $frm['action'] = '';
      }
    }

    if ($frm['action'] == 'delete')
    {
      $q = 'DELETE FROM hm2_news WHERE id = ' . intval ($frm['id']);
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }
    }
  }

  if ($settings['demomode'] == 1)
  {
    echo start_info_table ('100%');
    echo '<b>Demo version restriction!</b><br>You cannot add/edit news!';
    echo end_info_table ();
    echo '<br>';
  }

  echo '<b>Add/Edit News:</b><br><br>';
  $q = 'SELECT * FROM hm2_news';
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $count_all = mysql_num_rows ($sth);
  if (0 < $count_all)
  {
    echo '<table cellspacing=1 cellpadding=2 border=0 width=100%>';
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
    $edit_row = array ();
    $q = 'SELECT *, date_format(date + interval ' . $settings['time_dif'] . (' hour, \'%b-%e-%Y %r\') as d from hm2_news ORDER BY date DESC LIMIT ' . $from . ', ' . $onpage);
    $sth = mysql_query ($q);
    while ($row = mysql_fetch_array ($sth))
    {
      if ($frm['action'] == 'edit')
      {
        if ($row['id'] == $frm['id'])
        {
          $edit_row = $row;
        }
      }

      if (!($row['small_text']))
      {
        $row['full_text'] = strip_tags ($row['full_text']);
        $row['small_text'] = preg_replace ('/^(.{100,120})\\s.*/', '$1...', $row['full_text']);
      }

      $row['small_text'] = stripslashes (preg_replace ('/\\n/', '<br>', $row['small_text']));
      echo '<tr><td><b>' . stripslashes ($row['title']) . '</b><br>  ';
      echo $row['small_text'];
      echo '<br><small><i>' . stripslashes ($row['d']) . '</i></small><a href="?a=news&action=edit&id=' . $row['id'];
      echo '&page=' . $page . '#editform">[EDIT]</a> <a href="?a=news&action=delete&id=';
      echo $row['id'];
      echo '&page=' . $page;
      echo '" onclick="return confirm(\'Do you really want to delete news?\')">[REMOVE]</a> </td></tr>';
    }

    echo '</table>
<center>
';
    if (1 < $colpages)
    {
      if (1 < $page)
      {
        echo ' <a href="?a=news&page=' . ($page - 1) . '">&lt;&lt;</a> ';
      }

      for ($i = 1; $i <= $colpages; ++$i)
      {
        if ($i == $page)
        {
          echo ' <b>' . $i . '</b> ';
          continue;
        }
        else
        {
          echo ' <a href="?a=news&page=' . $i . '">' . $i . '</a> ';
          continue;
        }
      }

      if ($page < $colpages)
      {
        echo ' <a href="?a=news&page=' . ($page + 1) . '">&gt;&gt;</a> ';
      }
    }

    echo '</center>';
  }
  else
  {
    echo start_info_table ('100%');
    echo 'Here you can manage your program news.<br>Your newly added news will appear on your site index page (if you have enabled \'Show news box in InfoBox Settings section\')<br>Small text will appear on Index page. If you omit Small Text then the system will show first 100-120 characters of your Full Text.<br> If you omit Full Text than the system will show Small Text on all the news page.';
    echo end_info_table ();
  }

  echo '<br><br><a name="editform"></a>
<form method=post>
<input type=hidden name=a value=news>
';
  if ($edit_row)
  {
    echo '<input type=hidden name=action value=edit>
<input type=hidden name=save value=1>
<input type=hidden name=id value=' . $edit_row['id'] . '>';
  }
  else
  {
    echo '<input type=hidden name=action value=add>';
  }

  echo '<input type=hidden name=page value=' . $page . '>
<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td>Title</td>
</tr>
<tr>
 <td>
  <input type="text" name="title" value="';
  echo stripslashes ($edit_row['title']);
  echo '" class=inpts size=100>
 </td>
</tr>
<tr>
 <td>Small Text</td>
</tr>
<tr>
 <td>
  <textarea name=small_text class=inpts cols=100 rows=3>';
  echo stripslashes ($edit_row['small_text']);
  echo '</textarea>
 </td>
</tr>
<tr>
 <td>Full Text</td>
</tr>
<tr>
 <td>
  <textarea name=full_text class=inpts cols=100 rows=5>';
  echo stripslashes ($edit_row['full_text']);
  echo '</textarea>
 </td>
</tr>
<tr>
 <td><input type=submit value="';
  echo ($edit_row ? 'Add' : 'Edit');
  echo '" class=sbmt></td>
</tr></table>
</form>

';
?>