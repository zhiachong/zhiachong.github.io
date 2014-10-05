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


  if ($settings['demomode'])
  {
    echo start_info_table ('100%');
    echo '<b>Demo version restriction!</b><br>You cannot change the exchange rates!';
    echo end_info_table ();
  }

  $exch = array ();
  $q = 'SELECT * FROM hm2_exchange_rates';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $exch[$row['sfrom']][$row['sto']] = $row['percent'];
  }

  echo '
<form method=post>
<input type=hidden name=a value=exchange_rates>
<input type=hidden name=action value=save>
<b>Exchange Rates:</b><br><br>

<table cellspacing=0 cellpadding=2 border=0 width=100%><tr><td valign=top>

<table cellspacing=0 cellpadding=0 border=0><tr><td valign=top bgcolor=#FF8D00>
<table cellspacing=1 cellpadding=2 border=0>
<tr>
  <td bgcolor=#FFFFFF nowrap align=center>From / To</td>
';
  foreach ($exchange_systems as $id => $value)
  {
    echo '<td bgcolor=#FFFFFF align=center><img src=images/pay/' . $id . '.gif height=21></td>';
  }

  echo '</tr>';
  foreach ($exchange_systems as $id_from => $value)
  {
    echo '<tr><td align=center bgcolor=#FFFFFF><img src=images/pay/' . $id_from . '.gif height=21></td>';
    foreach ($exchange_systems as $id_to => $value)
    {
      echo '<td align=center bgcolor=#FFFFFF>';
      if ($id_from != $id_to)
      {
        echo '<input type="text" name="exch[' . $id_from . '][' . $id_to . ']" value="';
        echo sprintf ('%.02f', $exch[$id_from][$id_to]);
        echo '" size=5 class=inpts>';
      }
      else
      {
        echo ' N/A ';
      }

      echo '</td>';
    }

    echo '</tr>';
  }

  echo '</table>
</td></tr></table>
<br>
<input type=submit value="Update" class=sbmt>
</td>
<tr>
 <td valign=top align=right> 
        ';
  echo start_info_table ('300');
  echo 'Exchange Rates:<br><br>
        Figures are the percents of an exchange rates.<br>
        <b>Vertical column</b> is <b>FROM</b> currency.<br>
        <b>Horizontal row</b> is <b>TO</b> currency.<br>
        <br>
        Ex: To set a percent for E-gold to Liberty Reserve exchange you should 
        edit the field in the vertical column with the E-gold icon and in the row with the Liberty Reserve one.<br> <br>To disable an exchange set its percentage to 100. ';
  echo end_info_table ();
  echo '      </td>
    </tr></table>
</form>
<br><br>
';
?>