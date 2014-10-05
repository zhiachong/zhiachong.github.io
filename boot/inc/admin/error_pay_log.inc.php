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


  echo '
<b>Error transactions:</b><br><br>

<table cellspacing=1 cellpadding=2 border=0 width=100%>
<tr>
 <td bgcolor=FFEA00 align=center>Date</td>
 <td bgcolor=FFEA00 align=center>Error</td>
</tr>

';
  $q = 'select * from hm2_pay_errors order by id desc';
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  while ($row = mysql_fetch_array ($sth))
  {
    $txt = $row['txt'];
    $txt = preg_replace ('/<.*?>/', '', $txt);
    echo '<tr>
 <td>';
    echo $row['date'];
    echo '</td>
 <td>';
    echo $txt;
    echo '</td>
</tr>

';
  }

  echo '</table>';
?>