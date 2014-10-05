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
<td bgcolor=#FFFFFF>
';
  if (function_exists ('curl_init'))
  {
    $token = strtoupper (md5 ($frm['pass'] . ':' . gmdate ('Ymd') . (':' . gmdate ('H'))));
    $data = '
  <TransferRequest>
    <Transfer>
      <TransferId> </TransferId>
      <Payer> ' . $frm['acc'] . ' </Payer>
      <Payee> ' . $frm['acc'] . ' </Payee>
      <CurrencyId> GAU </CurrencyId>
      <Equivalent>
        <CurrencyId> USD </CurrencyId>
        <Amount> 0.01 </Amount>
      </Equivalent>
      <FeePaidBy> Payee </FeePaidBy>
      <Memo> HYIP Manager Script Test </Memo>
    </Transfer>
    <Auth>
      <Token> ' . $token . ' </Token>
    </Auth>
  </TransferRequest>
  ';
    $ch = curl_init ();
    curl_setopt ($ch, CURLOPT_URL, 'https://pxi.pecunix.com/money.refined...transfer');
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    $a = curl_exec ($ch);
    curl_close ($ch);
    $out = parsexml_pecunix ($a);
    if ($out['status'] == 'ok')
    {
      echo 'Test status: <font color="green"><b>OK</b></font><br>Batch id = ' . $out['batch'];
    }
    else
    {
      if ($out['status'] == 'error')
      {
        echo 'Test Status: <font color="red"><b>Error</b><br>' . $out['text'] . '<br>' . $out['additional'];
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