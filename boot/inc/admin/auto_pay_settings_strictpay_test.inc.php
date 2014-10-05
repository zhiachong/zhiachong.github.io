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
<link href="images/admin.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFF2" link="#666699" vlink="#666699" alink="#666699" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<center>
<br><br><br>
<table cellspacing=0 cellpadding=1 border=0 width=80% height=100% bgcolor=#ff8d00>
 <tr>
  <td>
   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr> 
     <td bgcolor=#FFFFFF>';
  if (function_exists ('curl_init'))
  {
    $amount = '0.10';
    $memo = 'Test Payment';
    $list = '' . $frm['acc'] . ';' . $amount . ';' . $memo . ';
';
    $ch = curl_init ();
    curl_setopt ($ch, CURLOPT_URL, 'https://www.strictpay.com/autopay/autopay.php');
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)');
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, 'acctNumber=' . rawurlencode ($frm['acc']) . '&email=' . rawurlencode ($frm['email']) . '&password=' . rawurlencode (base64_encode ($frm['pass'])) . '&accessCode=' . rawurlencode (base64_encode ($frm['code'])) . '&totalAmount=' . rawurlencode ($amount) . '&payList=' . rawurlencode ($list) . '');
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    $a = curl_exec ($ch);
    curl_close ($ch);
    if (!($a))
    {
      echo 'Error:' . curl_error ($ch);
    }
    else
    {
      if ($a == 'All Transactions Successfully Completed!')
      {
        echo $a;
      }
      else
      {
        echo $a;
      }
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