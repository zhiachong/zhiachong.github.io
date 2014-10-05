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
 <table cellspacing=0 cellpadding=1 border=0 width=80%  bgcolor=#ff8d00>
  <tr>
   <td>
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
     <tr bgcolor="#FFFFFF" valign="top"> 
      <td bgcolor=#FFFFFF>';
  if (function_exists ('curl_init'))
  {
    $token = $frm['pass'] . ':' . gmdate ('Ymd') . ':' . gmdate ('H');
    if (function_exists ('mhash'))
    {
      $token = strtoupper (bin2hex (mhash (MHASH_SHA256, $token)));
    }
    else
    {
      require_once 'inc/lrsha256_class.php';
      $token = strtoupper (sha256::hash ($token));
    }

    $data = '<BalanceRequest id="' . rand (1000000, 9999999) . '">
  <Auth>
  <ApiName>' . htmlspecialchars ($frm['code']) . '</ApiName>
  <Token>' . $token . '</Token>
 </Auth>
 <Balance>

   <CurrencyId>LRUSD</CurrencyId>
 <AccountId>' . htmlentities ($frm['acc'], ENT_NOQUOTES) . '</AccountId>
 </Balance>
 </BalanceRequest>';
    $ch = curl_init ();
    curl_setopt ($ch, CURLOPT_URL, 'https://api.libertyreserve.com/xml/balance.aspx?req=' . urlencode ($data));
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    $a = curl_exec ($ch);
    curl_close ($ch);
    $out = parsexml_libertyreserve ($a);
    if ($out['status'] == 'ok')
    {
      echo 'Status <font color="green"><b>OK</b></font> Balance: ' . $out['value'];
    }
    else
    {
      if ($out['status'] == 'error')
      {
        echo 'Test Status: <font color="red"><b>Error</b>';
      }
      else
      {
        echo '<font color="red"><b>Error</b><br>Parse error: ' . $a;
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