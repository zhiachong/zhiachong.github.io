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


  echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>HYIP Manager Script | www.hyipmanagerscript.com</title>
<link href="images/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFF2" link="#666699" vlink="#666699" alink="#666699" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<center>
<br><br>

<table cellspacing=0 cellpadding=1 border=0 height=100% bgcolor=#ff8d00>
<tr>
 <td>
  If you see the balances of your accounts then the settings are ok. Otherwise try again.
 </td>
</tr>
<tr>
 <td>
  <table width="100%" height="50%" border="0" cellpadding="0" cellspacing="0">
   <tr bgcolor="#FFFFFF" valign="top"> 
    <td bgcolor=#FFFFFF>';
  if (function_exists ('curl_init'))
  {
    $ch = curl_init ();
    curl_setopt ($ch, CURLOPT_URL, 'https://perfectmoney.com/acct/balance.asp');
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)');
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, 'AccountID=' . rawurlencode ($frm['acc']) . '&PassPhrase=' . rawurlencode ($frm['pass']));
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    $a = curl_exec ($ch);
    curl_close ($ch);
    if (!(preg_match_all ('/<input name=\'(.*)\' type=\'hidden\' value=\'(.*)\'>/', $a, $result, PREG_SET_ORDER)))
    {
      echo 'Ivalid output';
    }
    else
    {
      $ar = '';
      foreach ($result as $item)
      {
        $key = $item[1];
        $ar[$key] = $item[2];
      }

      echo '<pre>';
      print_r ($ar);
      echo '</pre>';
    }
  }
  else
  {
    echo 'Sorry, but curl does not installed on your server';
  }

  echo '
          </td>
         </tr>
        </table>
       </tr>
      </table>
     </center>
    </body>';
  exit ();
?>