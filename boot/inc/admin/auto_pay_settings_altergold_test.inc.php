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
             <tr bgcolor="#FFFFFF" valign="top"> 
               <td bgcolor=#FFFFFF>';
  if (function_exists ('curl_init'))
  {
    $amount = '0.10';
    $ch = curl_init ();
    curl_setopt ($ch, CURLOPT_URL, 'https://api.altergold.com/spend.php');
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)');
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, 'PAYER_ACCOUNT=' . rawurlencode ($frm['acc']) . '&PAYER_PASSWORD=' . rawurlencode ($frm['pass']) . '&PAYEE_ACCOUNT=' . rawurlencode ($frm['acc']) . '&PAYMENT_AMOUNT=' . rawurlencode ($amount) . '&PAYMENT_CURRENCY=USD&MEMO=TEST_TRANSACTION');
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    $a = curl_exec ($ch);
    curl_close ($ch);
    if ($a == '')
    {
      echo 'Blank response from Altergold processor service.';
    }
    else
    {
      $error_list = array ('E10011' => 'Unable to login.', 'E10012' => 'Account is suspended or limited.', 'E10013' => 'API Automated Spends not Enabled.', 'E10014' => 'Unable to authorize IP address.', 'E10015' => 'Recipient account not found.', 'E10016' => 'Recipient account is suspended.', 'E10017' => 'Invalid spend units.', 'E10018' => 'Spend amount is too low.', 'E10019' => 'Recipient reached balance limit.', 'E10020' => 'Not enough funds.', 'E10021' => 'Please contact support');
      if ($error_list[$a] != '')
      {
        echo 'Test Status: Error<br>' . $error_list[$a];
      }
      else
      {
        echo 'Test status: OK<br> test transaction batch is ' . $a;
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