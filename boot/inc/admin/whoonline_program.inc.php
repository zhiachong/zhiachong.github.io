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


  $q = 'select count(*) as col from hm2_online ';
  $sth = mysql_query ($q);
  $visitors_online = 0;
  while ($row = mysql_fetch_array ($sth))
  {
    $visitors_online = $row['col'];
  }

  echo '<html>
<head>
<link href="images/adminstyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<b>Who online:</b><br><br>

Number visitors: ';
  echo $visitors_online;
  echo '<br><br>

Registered Uses:<br><br>
';
  $q = 'select * from hm2_users where last_access_time + interval 30 minute > now()';
  $sth = mysql_query ($q);
  $i = 0;
  while ($row = mysql_fetch_array ($sth))
  {
    if (0 < $i)
    {
      echo ', ';
    }

    echo $row['username'];
    ++$i;
  }

?>