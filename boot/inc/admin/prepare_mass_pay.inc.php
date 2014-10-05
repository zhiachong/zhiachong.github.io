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


  if (!(is_array ($frm['pend'])))
  {
    echo 'Please select withdraw requests first';
    db_close ($dbconn);
    exit ();
  }

  $ids = implode (', ', array_keys ($frm['pend']));
  $sum = 0;
  $q = 'SELECT SUM(actual_amount) AS sm, ec FROM hm2_history WHERE id IN (' . $ids . ') AND ec IN (0, 1, 3, 5, 8, 9,10,11,12) GROUP by ec';
  $sth = mysql_query ($q);
  while ($row = mysql_fetch_array ($sth))
  {
    $row['sm'] = abs ($row['sm']);
    $fee = floor ($row['sm'] * $settings['withdrawal_fee']) / 100;
    if ($fee < $settings['withdrawl_fee_min'])
    {
      $fee = $settings['withdrawl_fee_min'];
    }

    $row['sm'] = $row['sm'] - $fee;
    if ($row['sm'] < 0)
    {
      $row['sm'] = 0;
    }

    $row['sm'] = number_format (floor ($row['sm'] * 100) / 100, 2);
    $exchange_systems[$row['ec']]['balance'] = $row['sm'];
    $sum += $row['sm'];
  }

  $amount = $sum;
  foreach ($exchange_systems as $id => $data)
  {
    if (0 < $data['balance'])
    {
      echo 'Pending on ' . $data['name'] . ': <b>$' . $data['balance'] . '</b><br>';
      continue;
    }
  }

  echo '  Are you sure you want to pay <b>$';
  echo number_format (abs ($amount), 2);
  echo '</b>  ?<br>  <br> <b>Mass Payment:</b><br><br><script language="JavaScript">
function di_sabled() 
{
  document.payform.submit_but.disabled = true;
  return true;
}


function test_libertyreserve() 
{';
  if ($settings['demomode'] == 1)
  {
    echo 'alert("Sorry, not available in demo mode");return false;';
  }

  if (!(function_exists ('curl_init')))
  {
    echo 'alert("Sorry, CURL extension is not installed on server";return false;';
  }

  echo '
  if (document.payform.libertyreserve_from_account.value == \'\') 
  {
    alert("Please type Liberty Reserve account");
    return false;
  }
  if (document.payform.libertyreserve_password.value == \'\') 
  {
    alert("Please type Liberty Reserve Security Word");
    return false;
  }
   if (document.payform.libertyreserve_code.value == \'\') 
  {
    alert("Please type Liberty Reserve API");
    return false;
  }


  window.open(\'\', \'testlibertyreserve\', \'width=400, height=200, status=0\');
  document.testsettings.target = \'testlibertyreserve\';
  document.testsettings.a.value = \'test_libertyreserve_settings\';
  document.testsettings.acc.value = document.payform.libertyreserve_from_account.value;
  document.testsettings.pass.value = document.payform.libertyreserve_password.value;
  document.testsettings.code.value = document.payform.libertyreserve_code.value;
  document.testsettings.submit();
}

function test_vmoney() 
{';
  if ($settings['demomode'] == 1)
  {
    echo 'alert("Sorry, not available in demo mode");return false;';
  }

  if (!(function_exists ('curl_init')))
  {
    echo 'alert("Sorry, curl extension is not installed on server";return false;';
  }

  echo '
  if (document.payform.vmoney_from_account.value == \'\') 
  {
    alert("Please type V-Money account");
    return false;
  }
  if (document.payform.vmoney_password.value == \'\') 
  {
    alert("Please define V-Money security code");
    return false;
  }

  window.open(\'\', \'testvmoney\', \'width=400, height=200, status=0\');
  document.testsettings.target = \'testvmoney\';
  document.testsettings.a.value = \'test_vmoney_settings\';
  document.testsettings.acc.value = document.payform.vmoney_from_account.value;
  document.testsettings.pass.value = document.payform.vmoney_password.value;
  document.testsettings.submit();
}

function test_altergold() 
{';
  if ($settings['demomode'] == 1)
  {
    echo 'alert("Sorry, not available in demo mode");return false;';
  }

  if (!(function_exists ('curl_init')))
  {
    echo 'alert("Sorry, curl extension is not installed on server";return false;';
  }

  echo '
  if (document.payform.altergold_from_account.value == \'\') 
  {
    alert("Please type AlterGold account");
    return false;
  }
  if (document.payform.altergold_password.value == \'\') 
  {
    alert("Please type AlterGold password");
    return false;
  }

  window.open(\'\', \'testaltergold\', \'width=400, height=200, status=0\');
  document.testsettings.target = \'testaltergold\';
  document.testsettings.a.value = \'test_altergold_settings\';
  document.testsettings.acc.value = document.payform.altergold_from_account.value;
  document.testsettings.pass.value = document.payform.altergold_password.value;
  document.testsettings.submit();
}

function test_perfectmoney() 
{';
  if ($settings['demomode'] == 1)
  {
    echo 'alert("Sorry, not available in demo mode");return false;';
  }

  if (!(function_exists ('curl_init')))
  {
    echo 'alert("Sorry, curl extension is not installed on server";return false;';
  }

  echo '
  if (document.payform.perfectmoney_from_account.value == \'\') 
  {
    alert("Please type PerfectMoney account");
    return false;
  }
   if (document.payform.perfectmoney_payer_account.value == \'\') 
  {
    alert("Please type Payer account");
    return false;
  } 
  if (document.payform.perfectmoney_password.value == \'\') 
  {
    alert("Please type PerfectMoney password");
    return false;
  }

  window.open(\'\', \'testperfectmoney\', \'width=400, height=200, status=0\');
  document.testsettings.target = \'testperfectmoney\';
  document.testsettings.a.value = \'test_perfectmoney_settings\';
  document.testsettings.acc.value = document.payform.perfectmoney_from_account.value;
  document.testsettings.pass.value = document.payform.perfectmoney_password.value;
  document.testsettings.submit();
}


function test_pecunix() 
{';
  if ($settings['demomode'] == 1)
  {
    echo 'alert("Sorry, not available in demo mode");return false;';
  }

  if (!(function_exists ('curl_init')))
  {
    echo 'alert("Sorry, curl extension is not installed on server";return false;';
  }

  echo '
  if (document.payform.pecunix_from_account.value == \'\') 
  {
    alert("Please type Pecunix account");
    return false;
  }
  if (document.payform.pecunix_password.value == \'\') 
  {
    alert("Please type Pecunix Payment PIK");
    return false;
  }

  window.open(\'\', \'testpecunix\', \'width=400, height=200, status=0\');
  document.testsettings.target = \'testpecunix\';
  document.testsettings.a.value = \'test_pecunix_settings\';
  document.testsettings.acc.value = document.payform.pecunix_from_account.value;
  document.testsettings.pass.value = document.payform.pecunix_password.value;
  document.testsettings.submit();
}


function en_it() 
{ 
';
  if (0 < $exchange_systems[0]['balance'])
  {
    echo 'document.payform.egold_account.disabled = document.payform.e_acc[0].checked;
       document.payform.egold_password.disabled = document.payform.e_acc[0].checked;';
  }

  if (0 < $exchange_systems[1]['balance'])
  {
    echo 'document.payform.libertyreserve_from_account.disabled = document.payform.libertyreserve_acc[0].checked;
       document.payform.libertyreserve_code.disabled = document.payform.libertyreserve_acc[0].checked;
       document.payform.libertyreserve_password.disabled = document.payform.libertyreserve_acc[0].checked;
       document.payform.libertyreserve_test.disabled = document.payform.libertyreserve_acc[0].checked;';
  }

  if (0 < $exchange_systems[3]['balance'])
  {
    echo 'document.payform.vmoney_from_account.disabled = document.payform.vmoney_acc[0].checked;
       document.payform.vmoney_password.disabled = document.payform.vmoney_acc[0].checked;
       document.payform.vmoney_test.disabled = document.payform.vmoney_acc[0].checked;';
  }

  if (0 < $exchange_systems[8]['balance'])
  {
    echo 'document.payform.altergold_from_account.disabled = document.payform.altergold_acc[0].checked;
       document.payform.altergold_password.disabled = document.payform.altergold_acc[0].checked;
       document.payform.altergold_test.disabled = document.payform.altergold_acc[0].checked;';
  }

  if (0 < $exchange_systems[9]['balance'])
  {
    echo 'document.payform.pecunix_account.disabled = document.payform.pecunix_acc[0].checked;
       document.payform.pecunix_password.disabled = document.payform.pecunix_acc[0].checked;
       document.payform.pecunix_test.disabled = document.payform.pecunix_acc[0].checked;';
  }

  if (0 < $exchange_systems[10]['balance'])
  {
    echo 'document.payform.perfectmoney_from_account.disabled = document.payform.perfectmoney_acc[0].checked;
       document.payform.perfectmoney_password.disabled = document.payform.perfectmoney_acc[0].checked;
	   document.payform.perfectmoney_payer_account.disabled = document.payform.perfectmoney_acc[0].checked;
       document.payform.perfectmoney_test.disabled = document.payform.perfectmoney_acc[0].checked;';
  }

  if (0 < $exchange_systems[12]['balance'])
  {
    echo 'document.payform.igolds_from_account.disabled = document.payform.igolds_acc[0].checked;
       document.payform.igolds_password.disabled = document.payform.igolds_acc[0].checked;
	   document.payform.igolds_payer_account.disabled = document.payform.igolds_acc[0].checked;
       document.payform.igolds_test.disabled = document.payform.igolds_acc[0].checked;';
  }

  echo '
}
</script>';
  if ($settings['demomode'] != 1)
  {
    echo '
  
<form name="testsettings" method=post>
 <input type=hidden name=a>
 <input type=hidden name=acc>
 <input type=hidden name=pass>
 <input type=hidden name=code>
</form>

<form method=post name=payform onsubmit="return di_sabled()">
 <input type=hidden name=a value=mass>
 <input type=hidden name=action2 value=masspay>
 <input type=hidden name=action3 value=masspay>  ';
  }

  $ids = $frm['pend'];
  if (is_array ($ids))
  {
    reset ($ids);
    while (list ($kk, $vv) = each ($ids))
    {
      echo '<input type=hidden name=pend[' . $kk . '] value=1>';
    }
  }

  if (0 < $exchange_systems[1]['balance'])
  {
    echo '

<img src="images/pay/1.gif"> <b>Liberty Reserve account:</b><br>
<input type=radio name=libertyreserve_acc value=0 onClick="en_it();" checked>
  Pay from the saved account (check auto-payment settings screen)<br>
<input type=radio name=libertyreserve_acc value=1 onClick="en_it();">
  Pay from the other account (specify below):<br>
<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td>Account number:</td>
 <td><input type=text name=libertyreserve_from_account value="" class=inpts size=30></td>
</tr>
<tr>
 <td>API Name:</td>
 <td><input type=password name=libertyreserve_code value="" class=inpts size=30></td>
</tr>
<tr>
 <td>Security Word:</td>
 <td><input type=password name=libertyreserve_password value="" class=inpts size=30>&nbsp;
     <input type=button name=libertyreserve_test value="Test" onClick="test_libertyreserve();" class=sbmt></td>
</tr>
</table>
 <br>';
  }

  if (0 < $exchange_systems[3]['balance'])
  {
    echo '
<img src="images/pay/3.gif"> <b>V-Money account:</b><br>
<input type=radio name=vmoney_acc value=0 onClick="en_it();" checked>
  Pay from the saved account (check auto-payment settings screen)<br>
<input type=radio name=vmoney_acc value=1 onClick="en_it();">
  Pay from the other account (specify below):<br>
<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td>Account number:</td>
 <td><input type=text name=vmoney_from_account value="" class=inpts size=30></td>
</tr>
<tr>
 <td>Account Password:</td>
 <td><input type=password name=vmpass value="" class=inpts size=30></td>
</tr>
<tr>
 <td>Account PIN:</td>
 <td><input type=password name=vmpin value="" class=inpts size=30></td>
</tr>
<tr>
 <td>&nbsp;</td>
 <td><input type=button value="Genrate Security Code" class=sbmt onclick="gen_vm_sec_code()"></td>
</tr>
<tr>
 <td>Security Code:</td>
 <td><input type=password name=vmoney_password value="" readonly class=inpts size=30>&nbsp;
     <input type=button name=vmoney_test value="Test" onClick="test_vmoney();" class=sbmt>
 </td>
</tr>
</table>
<br>';
  }

  if (0 < $exchange_systems[0]['balance'])
  {
    echo '
<img src="images/pay/0.gif"> <b>E-gold account:</b><br>
<input type=radio name=e_acc value=0 onClick="en_it();" checked>
  Pay from the saved account (check auto-payment settings screen)<br>
<input type=radio name=e_acc value=1 onClick="en_it();">
  Pay from the other account (specify below):<br>
<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td>Account number:</td>
 <td><input type=text name=egold_account value="" class=inpts size=30></td>
</tr><tr>
 <td>Passphrase:</td>
 <td><input type=password name=egold_password value="" class=inpts size=30></td>
</tr></table>
<br>';
  }

  if (0 < $exchange_systems[12]['balance'])
  {
    echo '
<img src="images/pay/12.gif"> <b>iGolds account:</b><br>
<input type=radio name=igolds_acc value=0 onClick="en_it();" checked>
  Pay from the saved account (check auto-payment settings screen)<br>
<input type=radio name=igolds_acc value=1 onClick="en_it();">
  Pay from the other account (specify below):<br>
<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td>Account number:</td>
 <td><input type=text name=igolds_from_account value="" class=inpts size=30></td>
</tr><tr>
 <td>Passphrase:</td>
 <td><input type=password name=igolds_password value="" class=inpts size=30></td>
</tr></table>
<br>';
  }

  if (0 < $exchange_systems[8]['balance'])
  {
    echo '
<img src="images/pay/8.gif"> <b>AlterGold account:</b><br>
<input type=radio name=altergold_acc value=0 onClick="en_it();" checked>
  Pay from the saved account (check auto-payment settings screen)<br>
<input type=radio name=altergold_acc value=1 onClick="en_it();">
  Pay from the other account (specify below):<br>
<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td>Account number:</td>
 <td><input type=text name=altergold_from_account value="" class=inpts size=30></td>

</tr>
<tr>
 <td>Account Password:</td>
 <td><input type=password name=altergold_password value="" class=inpts size=30>&nbsp;
     <input type=button name=altergold_test value="Test" onClick="test_altergold();" class=sbmt>
 </td>
</tr>
</table>
<br>';
  }

  if (0 < $exchange_systems[9]['balance'])
  {
    echo '

<img src="images/pay/9.gif"> <b>Pecunix account:</b><br>
<input type=radio name=pecunix_acc value=0 onClick="en_it();" checked>
  Pay from the saved account (check auto-payment settings screen)<br>
<input type=radio name=pecunix_acc value=1 onClick="en_it();">
  Pay from the other account (specify below):<br>
<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td>Account number:</td>
 <td><input type=text name=pecunix_from_account value="" class=inpts size=30></td>
</tr><tr>
 <td>Payment PIK:<br>
     <small>You should enter characters without \'-\'</small>
 </td>
 <td><input type=password name=pecunix_password value="" class=inpts size=30>&nbsp;
     <input type=button name=pecunix_test value="Test" onClick="test_pecunix();" class=sbmt>
 </td>
</tr>
</table>
<br>';
  }

  if (0 < $exchange_systems[10]['balance'])
  {
    echo '

<img src="images/pay/10.gif"> <b>PerfectMoney account:</b><br>
<input type=radio name=perfectmoney_acc value=0 onClick="en_it();" checked>
  Pay from the saved account (check auto-payment settings screen)<br>
<input type=radio name=perfectmoney_acc value=1 onClick="en_it();">
  Pay from the other account (specify below):<br>
  <table cellspacing=0 cellpadding=2 border=0>
  <tr>
 <td>AccountID:</td>
 <td><input type=text name=perfectmoney_from_account value="" class=inpts size=30></td>
</tr>
<tr>
 <td>Payer Account:</td>
 <td><input type=text name=perfectmoney_payer_account value="" class=inpts size=30></td>
</tr>
<tr>
 <td>PerfectMoney Password:</td>
 <td><input type=password name=perfectmoney_password  value="" class=inpts size=30> <input type=button value="Test" onClick="test_perfectmoney();" class=sbmt></td>
</tr>
<tr>
 <td colspan=2>';
    echo start_info_table ('100%');
    echo 'Payer account is USD account. Starts with U<br>You should enable API. Login to perfectmoney, follow secirity section, then "Change Security Settings", and enable API<br>';
    echo end_info_table ();
    echo ' </td>
 </tr>
</table>
<br>';
  }

  echo '
<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td colspan="2" align="center">
   <input type=submit name=submit_but value="Mass process pending payments" class=sbmt>
 </td>
</tr>
</table>
</form>
<script language=javascript>en_it();</script>';
  if ($settings['demomode'] == 1)
  {
    echo start_info_table ('100%');
    echo '<b>Demo restriction!</b><br>Not Available in demo!!';
    echo end_info_table ();
  }

  echo '<script language="JavaScript">

function gen_vm_sec_code()
{
  document.payform.vmoney_password.value = calcMD5(document.payform.vmpass.value).toLowerCase()+document.payform.vmpin.value;
  document.payform.vmpass.value = \'\';
  document.payform.vmpin.value = \'\';
}

<!--
/* jrw note: this md5 code GPL\'d by paul johnston at his web site: http://cw.oaktree.co.uk/site/legal.html */
/*
	** pjMd5.js
	**
	** A JavaScript implementation of the RSA Data Security, Inc. MD5
	** Message-Digest Algorithm.
	**
	** Copyright (C) Paul Johnston 1999.
	*/

	var sAscii=" !\\"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\\\]^_`"

	var sAscii=sAscii+"abcdefghijklmnopqrstuvwxyz{|}~";
	var sHex="0123456789ABCDEF";

	function hex(i) {
	h="";
	for(j=0; j<=3; j++) {
	  h+=sHex.charAt((i>>(j*8+4))&0x0F)+sHex.charAt((i>>(j*8))&0x0F);
	}
	return h;
	}
	function add(x,y) {
	return ((x&0x7FFFFFFF)+(y&0x7FFFFFFF) )^(x&0x80000000)^(y&0x80000000);
	}
	function R1(A,B,C,D,X,S,T) {
	q=add( add(A,(B&C)|((~B)&D)), add(X,T) );

	return add( (q<<S)|( (q>>(32-S))&(Math.pow(2,S)-1) ), B );
	}
	function R2(A,B,C,D,X,S,T) {
	q=add( add(A,(B&D)|(C&(~D))), add(X,T) );
	return add( (q<<S)|( (q>>(32-S))&(Math.pow(2,S)-1) ), B );
	}
	function R3(A,B,C,D,X,S,T) {
	q=add( add(A,B^C^D), add(X,T) );
	return add( (q<<S)|( (q>>(32-S))&(Math.pow(2,S)-1) ), B );
	}
	function R4(A,B,C,D,X,S,T) {
	q=add( add(A,C^(B|(~D))), add(X,T) );
	return add( (q<<S)|( (q>>(32-S))&(Math.pow(2,S)-1) ), B );
	}

	function calcMD5(sInp) {

	/* Calculate length in words, including padding */
	wLen=(((sInp.length+8)>>6)+1)<<4;
	var X = new Array(wLen);

	/* Convert string to array of words */
	j=4;
	for (i=0; (i*4)<sInp.length; i++) {
	X[i]=0;
	for (j=0; j<4 && (i*4+j)<sInp.length; j++) {
	  X[i]+=(sAscii.indexOf(sInp.charAt((i*4)+j))+32)<<(j*8);
	}
	}

	/* Append the 1 and 0s to make a multiple of 4 bytes */
	if (j==4) { X[i++]=0x80; }
	else { X[i-1]+=0x80<<(j*8); }
	/* Appends 0s to make a 14+k16 words */
	while ( i<wLen ) { X[i]=0; i++; }
	/* Append length */
	X[wLen-2]=sInp.length<<3;
	/* Initialize a,b,c,d */
	a=0x67452301; b=0xefcdab89; c=0x98badcfe; d=0x10325476;

	/* Process each 16 word block in turn */
	for (i=0; i<wLen; i+=16) {
	aO=a; bO=b; cO=c; dO=d;

	a=R1(a,b,c,d,X[i+ 0],7 ,0xd76aa478);
	d=R1(d,a,b,c,X[i+ 1],12,0xe8c7b756);
	c=R1(c,d,a,b,X[i+ 2],17,0x242070db);
	b=R1(b,c,d,a,X[i+ 3],22,0xc1bdceee);
	a=R1(a,b,c,d,X[i+ 4],7 ,0xf57c0faf);
	d=R1(d,a,b,c,X[i+ 5],12,0x4787c62a);
	c=R1(c,d,a,b,X[i+ 6],17,0xa8304613);
	b=R1(b,c,d,a,X[i+ 7],22,0xfd469501);
	a=R1(a,b,c,d,X[i+ 8],7 ,0x698098d8);
	d=R1(d,a,b,c,X[i+ 9],12,0x8b44f7af);
	c=R1(c,d,a,b,X[i+10],17,0xffff5bb1);
	b=R1(b,c,d,a,X[i+11],22,0x895cd7be);
	a=R1(a,b,c,d,X[i+12],7 ,0x6b901122);
	d=R1(d,a,b,c,X[i+13],12,0xfd987193);
	c=R1(c,d,a,b,X[i+14],17,0xa679438e);
	b=R1(b,c,d,a,X[i+15],22,0x49b40821);

	a=R2(a,b,c,d,X[i+ 1],5 ,0xf61e2562);
	d=R2(d,a,b,c,X[i+ 6],9 ,0xc040b340);
	c=R2(c,d,a,b,X[i+11],14,0x265e5a51);
	b=R2(b,c,d,a,X[i+ 0],20,0xe9b6c7aa);
	a=R2(a,b,c,d,X[i+ 5],5 ,0xd62f105d);
	d=R2(d,a,b,c,X[i+10],9 , 0x2441453);
	c=R2(c,d,a,b,X[i+15],14,0xd8a1e681);
	b=R2(b,c,d,a,X[i+ 4],20,0xe7d3fbc8);
	a=R2(a,b,c,d,X[i+ 9],5 ,0x21e1cde6);
	d=R2(d,a,b,c,X[i+14],9 ,0xc33707d6);
	c=R2(c,d,a,b,X[i+ 3],14,0xf4d50d87);
	b=R2(b,c,d,a,X[i+ 8],20,0x455a14ed);
	a=R2(a,b,c,d,X[i+13],5 ,0xa9e3e905);
	d=R2(d,a,b,c,X[i+ 2],9 ,0xfcefa3f8);
	c=R2(c,d,a,b,X[i+ 7],14,0x676f02d9);
	b=R2(b,c,d,a,X[i+12],20,0x8d2a4c8a);

	a=R3(a,b,c,d,X[i+ 5],4 ,0xfffa3942);
	d=R3(d,a,b,c,X[i+ 8],11,0x8771f681);
	c=R3(c,d,a,b,X[i+11],16,0x6d9d6122);
	b=R3(b,c,d,a,X[i+14],23,0xfde5380c);
	a=R3(a,b,c,d,X[i+ 1],4 ,0xa4beea44);
	d=R3(d,a,b,c,X[i+ 4],11,0x4bdecfa9);
	c=R3(c,d,a,b,X[i+ 7],16,0xf6bb4b60);
	b=R3(b,c,d,a,X[i+10],23,0xbebfbc70);
	a=R3(a,b,c,d,X[i+13],4 ,0x289b7ec6);
	d=R3(d,a,b,c,X[i+ 0],11,0xeaa127fa);
	c=R3(c,d,a,b,X[i+ 3],16,0xd4ef3085);
	b=R3(b,c,d,a,X[i+ 6],23, 0x4881d05);
	a=R3(a,b,c,d,X[i+ 9],4 ,0xd9d4d039);
	d=R3(d,a,b,c,X[i+12],11,0xe6db99e5);
	c=R3(c,d,a,b,X[i+15],16,0x1fa27cf8);
	b=R3(b,c,d,a,X[i+ 2],23,0xc4ac5665);

	a=R4(a,b,c,d,X[i+ 0],6 ,0xf4292244);
	d=R4(d,a,b,c,X[i+ 7],10,0x432aff97);
	c=R4(c,d,a,b,X[i+14],15,0xab9423a7);
	b=R4(b,c,d,a,X[i+ 5],21,0xfc93a039);
	a=R4(a,b,c,d,X[i+12],6 ,0x655b59c3);
	d=R4(d,a,b,c,X[i+ 3],10,0x8f0ccc92);
	c=R4(c,d,a,b,X[i+10],15,0xffeff47d);
	b=R4(b,c,d,a,X[i+ 1],21,0x85845dd1);
	a=R4(a,b,c,d,X[i+ 8],6 ,0x6fa87e4f);
	d=R4(d,a,b,c,X[i+15],10,0xfe2ce6e0);
	c=R4(c,d,a,b,X[i+ 6],15,0xa3014314);
	b=R4(b,c,d,a,X[i+13],21,0x4e0811a1);
	a=R4(a,b,c,d,X[i+ 4],6 ,0xf7537e82);
	d=R4(d,a,b,c,X[i+11],10,0xbd3af235);
	c=R4(c,d,a,b,X[i+ 2],15,0x2ad7d2bb);
	b=R4(b,c,d,a,X[i+ 9],21,0xeb86d391);

	a=add(a,aO); b=add(b,bO); c=add(c,cO); d=add(d,dO);
	}
	return hex(a)+hex(b)+hex(c)+hex(d);
	}

//-->
  </script>';
?>