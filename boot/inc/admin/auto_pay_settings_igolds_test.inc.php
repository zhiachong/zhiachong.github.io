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
<title>HYIP Manager Scroipt | www.hyipmanagerscript.com</title>
<link href="images/admin.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFF2" link="#666699" vlink="#666699" alink="#666699" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<center>
<br><br><br>
	 <table cellspacing=0 cellpadding=1 border=0 width=80% height=100% bgcolor=#ff8d00>
	   <tr>
	     <td>
           <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
             <tr bgcolor="#FFFFFF" valign="top"> 
<td bgcolor=#FFFFFF>
';
  if (function_exists ('curl_init'))
  {
    $ch = curl_init ();
    echo curl_error ($ch);
    curl_setopt ($ch, CURLOPT_URL, 'https://www.igolds.net/ai_payment.html');
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, 'IGS_ACCOUNT=' . $frm['acc'] . '&IGS_PASSWORD=' . $frm['pass'] . '&IGS_PAYEE_ACCOUNT=' . $frm['acc'] . '&IGS_AMOUNT=0.01&IGS_CURRENCY=2');
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    $a = curl_exec ($ch);
    echo '<hr>' . $a . '<hr>';
    curl_close ($ch);
    $parts = array ();
    if (preg_match ('/<input type="hidden" name="IGS_TRANSACTION_ID" value="(\\d+)">/ims', $a, $parts))
    {
      echo 'Test status: OK<br>Batch id = ' . $parts[1];
    }
    else
    {
      if (preg_match ('/<input type="hidden" name="IGS_ERROR" value="(.*?)">/ims', $a, $parts))
      {
        $txt = preg_replace ('/&lt;/i', '<', $parts[1]);
        $txt = preg_replace ('/&gt;/i', '>', $txt);
        echo 'Test status: Failed<br>' . $txt;
      }
      else
      {
        echo 'Test status: Failed<br>Unknown Error:<BR>' . $a;
      }
    }
  }
  else
  {
    echo 'Sorry, but curl does not installed on your server';
  }

  echo '
</tr></table>
</tr></table>
</center>
</body>
';
  exit ();
?>