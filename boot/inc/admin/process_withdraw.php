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


  echo ' <b>Process Withdrawal:</b><br><br>';
  $id = sprintf ('%d', $frm['id']);
  $q = 'SELECT * FROM hm2_history WHERE id=' . $id . ' AND type=\'withdraw_pending\'';
  if (!($sth = mysql_query ($q)))
  {
    echo mysql_error ();
    true;
  }

  $do_not_show_form = 0;
  if ($trans = mysql_fetch_array ($sth))
  {
    $q = 'SELECT * FROM hm2_users WHERE id = ' . $trans['user_id'];
    $sth1 = mysql_query ($q);
    if (mysql_num_rows ($sth1) == 0)
    {
      echo 'User not found!';
      exit ();
    }

    $userinfo = mysql_fetch_array ($sth1);
    $pp = $exchange_systems[$trans['ec']];
    $trans['account'] = $userinfo[$pp['sfx'] . '_account'];
    if (!((!($trans['account'] == '0') AND !($trans['account'] == ''))))
    {
      $trans['account'] = 'not set';
    }

    if ($trans['str'] == '')
    {
      $str = gen_confirm_code (30);
      $q = 'UPDATE hm2_history SET str = \'' . $str . '\' WHERE id =' . $id;
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $trans['str'] = $str;
    }
  }
  else
  {
    if ($frm['say'] == 'yes')
    {
      echo 'Transaction successfully processed';
    }
    else
    {
      if ($frm['say'] == 'no')
      {
        echo 'Transaction was not processed';
      }
      else
      {
        echo 'Request not found!';
      }
    }

    $do_not_show_form = 1;
  }

  $amount = abs ($trans['actual_amount']);
  $fee = floor ($amount * $settings['withdrawal_fee']) / 100;
  if ($fee < $settings['withdrawal_fee_min'])
  {
    $fee = $settings['withdrawal_fee_min'];
  }

  $to_withdraw = $amount - $fee;
  if ($to_withdraw < 0)
  {
    $to_withdraw = 0;
  }

  $to_withdraw = sprintf ('%.02f', floor ($to_withdraw * 100) / 100);
  if ($do_not_show_form == 0)
  {
    if ($trans['ec'] == 0)
    {
      echo '
	  <form name=spend method=post action="https://www.e-gold.com/sci_asp/payments.asp">
       <input type=hidden name=withdraw value="' . $id . '-' . $trans['str'] . '">
       <input type=hidden name=a value="pay_withdraw">
       <INPUT type=hidden name=PAYMENT_AMOUNT value="' . $to_withdraw . '">
       <INPUT type=hidden name=PAYEE_ACCOUNT value="' . $userinfo['egold_account'] . '">
       <INPUT type=hidden name=PAYEE_NAME value="' . $userinfo['name'] . '" >
			
	   Sending <b>$' . $to_withdraw . '</b> to E-gold account:' . $trans['account'] . '
       <br>Payment will be made from this account:			
	   <INPUT type=text class=inpts name=FORCED_PAYER_ACCOUNT value="' . $settings['def_payee_account'] . '">
       <INPUT type=hidden name=PAYMENT_UNITS value="1"> 
       <INPUT type=hidden name=PAYMENT_METAL_ID value="1">
       <INPUT type=hidden name=STATUS_URL value="' . $settings['site_url'] . '/processing_egold.php">
       <INPUT type=hidden name=PAYMENT_URL value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=yes">
       <INPUT type=hidden name=NOPAYMENT_URL value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=no">
       <INPUT type=hidden name=BAGGAGE_FIELDS value="withdraw a">
       <INPUT type=hidden value="Withdraw to ' . $userinfo['name'] . ' from ';
      echo $settings['site_name'] . '" name=SUGGESTED_MEMO>
       <br><br>
	   <input type=submit value="Go to e-gold.com" class=sbmt> &nbsp;
       <input type=button class=sbmt value="Cancel" onclick="window.close();">
      </form>';
      return 1;
    }

    if ($trans['ec'] == 12)
    {
      echo '
	  <form name=spend method=post action="https://www.igolds.net/sci_payment.html">
       <input type=hidden name=IGS_CUSTOM_withdraw value="' . $id . '-' . $trans['str'] . '">
       <input type=hidden name=IGS_CUSTOM_a value="pay_withdraw">
       <INPUT type=hidden name=IGS_AMOUNT value="' . $to_withdraw . '">
       <INPUT type=hidden name=IGS_PAYEE_ACCOUNT value="' . $userinfo['igolds_account'] . '">
			
	   Sending <b>$' . $to_withdraw . '</b> to iGolds account:' . $trans['account'] . '
       <br>Payment will be made from this account:			
	   <INPUT type=text class=inpts name=IGS_PAYER_ACCOUNT value="' . $settings['def_payee_account_igolds'] . '">
       <INPUT type=hidden name=IGS_CURRENCY value="2"> 
       <INPUT type=hidden name=IGS_VERIFY_URL value="' . $settings['site_url'] . '/processing_igolds.php">
       <INPUT type=hidden name=IGS_SUCCESS_URL value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=yes">
       <INPUT type=hidden name=IGS_FAIL_URL value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=no">
       <INPUT type=hidden value="Withdraw to ' . $userinfo['name'] . ' from ';
      echo $settings['site_name'] . '" name=IGS_MEMO>
       <br><br>
	   <input type=submit value="Go to igolds.net" class=sbmt> &nbsp;
       <input type=button class=sbmt value="Cancel" onclick="window.close();">
      </form>';
      return 1;
    }

    if ($trans['ec'] == 2)
    {
      echo 'Sending <b>$' . $to_withdraw . '</b> to SolidTrustPay account:' . $trans['account'] . '
	       <br>
	<form name=spend method=post action="http://solidtrustpay.com/handle.php">
     <input type=hidden name="user1" value="' . $id . '-' . $trans['str'] . '">
     <input type=hidden name="user2" value="pay_withdraw">
	 <input type=hidden name="merchantAccount" value="' . $userinfo['solidtrustpay_account'] . '"> 
     <input type=hidden name="amount" value="' . $to_withdraw . '" />
     <input type=hidden name="item_id" value="Withdraw to ' . $userinfo['name'] . ' from ';
      echo $settings['site_name'] . '">
     <input type=hidden name="return_url" value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=yes">
     <input type=hidden name="notify_url" value="' . $settings['site_url'] . '/processing_solidtrustpay.php" />
     <input type=hidden name="cancel_url" value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=no">
      <br><br>
	   <input type=submit value="Go to SolidTrustPay.com" class=sbmt> &nbsp;
       <input type=button class=sbmt value="Cancel" onclick="window.close();">
      </form>';
      return 1;
    }

    if ($trans['ec'] == 4)
    {
      echo 'Sending <b>$' . $to_withdraw . '</b> to EgoPay account:' . $trans['account'] . '<br><br>';
         
         if (file_exists("sci/api.php"))
         {
          require_once("sci/api.php");
         }
         else 
         {
          echo "NO!";
         }
  
         // Create EgoPay Authorization object providing your username, api key
          // and api password
          $oAuth = new EgoPayAuth('Simply', 'TSM4W98597JJ', 'pTPhzfhaJV8S86x3N1h53CBFwcDjWolR');
          // Create JSON API Agent
          $oEgoPayJsonAgent = new EgoPayJsonApiAgent($oAuth);
          // Retrieve transactions
          try {
            $oResponse = $oEgoPayJsonAgent->getTransfer($userinfo['alertpay_account'],1,'USD', 'Withdrawal to ' . $userinfo['name'] . ' from ' . $settings['site_name']);
            
            if (!empty($oResponse))
            {
              if ($oResponse->status == 'ok')  
              {
                if (file_exists('inc/config.inc.php'))
                {
                  echo "YES config exists";
                  require_once("inc/config.inc.php");
                  $dbconn = db_open ();
                  if (!($dbconn))
                  {
                    echo 'Cannot connect mysql';
                    exit ();
                  }
                  $transaction = $oResponse->transaction;
                  if ($transaction)
                  {
                    $batch = $transaction->sId;
                    $withdraw_string = $id . '-' . $trans['str'];
                    $payee = $transaction->sEmail;
                    admin_pay_withdraw ($batch, $withdraw_string, $payee, 4);
                    echo 1;
                    db_close ($dbconn);
                  }
                }
                else
                {
                  echo "Could not open db to update db. ERROR!";
                }
                
                header('Location: ' . ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'] . '?a=pay_withdraw&say=yes');
              }
            }
            else 
            {
              header('Location: ' . ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'] . '?a=pay_withdraw&say=no');
            }

          }
          catch (EgoPayApiException $e)
          {
            echo $e->getCode().': '.$e->getMessage();
            exit;
          }


          //return 1;
      //return 1;
    }

    if ($trans['ec'] == 3)
    {
      echo 'Sending <b>$' . $to_withdraw . '</b> to V-Money account:' . $trans['account'] . '
	       <br>
	 <form name=spend method=post action="https://www.v-money.net/vmi.php">
	  <input type=hidden name=CUSTOM_withdraw value="' . $id . '-' . $trans['str'] . '">
      <input type=hidden name=CUSTOM_a value="pay_withdraw">
	  <input type=hidden name=PMT_AMOUNT value="' . $to_withdraw . '" />
      <input type=hidden name=PMT_MERCHANT_ACCOUNT value="' . $userinfo['vmoney_account'] . '">
      <input type=hidden name=PMT_NOTIFY_URL value="' . $settings['site_url'] . '/processing_vmoney.php">
      <input type=hidden name=PMT_PAYMENT_URL value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=yes">
      <input type=hidden name=PMT_PAYMENT_URL_METHOD value=POST>
      <input type=hidden name=PMT_NOPAYMENT_URL  value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=no">
      <input type=hidden name=PMT_NOPAYMENT_URL_METHOD value=POST>
	  <br><br>
	  <input type=submit value="Go to V-Money.net" class=sbmt> &nbsp;
      <input type=button class=sbmt value="Cancel" onclick="window.close();">
     </form>';
      return 1;
    }

    if ($trans['ec'] == 5)
    {
      echo 'Sending <b>$' . $to_withdraw . '</b> to e-Bullion.
	        <br>
      <form name="spend" method="post" action="https://atip.e-bullion.com/process.php">
      <input type=hidden name=withdraw value="' . $id . '-' . $trans['str'] . '">
      <input type=hidden name=a value="pay_withdraw">
      <input type="hidden" name="ATIP_STATUS_URL" value="' . $settings['site_url'] . '/processing_ebullion.php">
      <input type="hidden" name="ATIP_STATUS_URL_METHOD" value="POST">
      <input type="hidden" name="ATIP_BAGGAGE_FIELDS" value="a withdraw">
      <input type="hidden" name="ATIP_SUGGESTED_MEMO" value="Withdraw to ' . $user['name'] . ' from ';
      echo $settings['site_name'] . '">
      <input type="hidden" name="ATIP_PAYER_FEE_AMOUNT" value="0.00">
      <input type="hidden" name="ATIP_PAYMENT_URL" value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://';
      echo $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'] . '?a=pay_withdraw&say=yes">
      <input type="hidden" name="ATIP_PAYMENT_URL_METHOD" value="POST">
      <input type="hidden" name="ATIP_NOPAYMENT_URL" value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=no">
      <input type="hidden" name="ATIP_NOPAYMENT_URL_METHOD" value="POST">
      <input type="hidden" name="ATIP_PAYMENT_FIXED" value="0">
      <input type="hidden" name="ATIP_PAYMENT_AMOUNT" value="' . $to_withdraw . '">
      <input type="hidden" name="ATIP_PAYMENT_UNIT" value="1">
      <input type="hidden" name="ATIP_PAYMENT_METAL" value="3">
      <input type="hidden" name="ATIP_PAYEE_ACCOUNT" value="' . $user['ebullion_account'] . '">
      <input type="hidden" name="ATIP_PAYEE_NAME" value="' . $user['name'] . '">
      <br>
	  <input type=submit value="Go to e-Bullion.com" class=sbmt> &nbsp;
      <input type=button class=sbmt value="Cancel" onclick="window.close();">
      </form>';
      return 1;
    }

    if ($trans['ec'] == 6)
    {
      echo 'Sending <b>$' . $to_withdraw . '</b> to PayPal.<br>
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
       <input type="hidden" name="cmd" value="_xclick">
       <input type="hidden" name="business" value="' . $user['paypal_account'] . '">
       <input type="hidden" name="item_name" value="Withdraw to ' . $user['name'] . ' from ' . $settings['site_name'] . '"> 
       <input type="hidden" name="amount" value="' . $to_withdraw . '"> 
       <input type="hidden" name="return" value="' . $settings['site_url'] . '/processing_paypal.php"> 
       <input type="hidden" name="cancel_return" value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://".';
      echo $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'] . '."?a=pay_withdraw&say=no"> 
       <input type=hidden name=custom value="pay_withdraw|' . $id . '-' . $trans['str'] . '">
       <input type=hidden name=quantity value=1>
       <input type=hidden name=no_note value=1>
       <input type=hidden name=no_shipping value=1>
       <input type=hidden name=rm value=2>
       <input type=hidden name=currency_code value=USD>
       <br>
	   <input type=submit value="Go to paypal.com" class=sbmt> &nbsp;
       <input type=button class=sbmt value="Cancel" onclick="window.close();">
      </form>';
      return 1;
    }

    if ($trans['ec'] == 7)
    {
      echo '
	<form method=post action="https://c-gold.com/clicktopay/">
     <input type=hidden name=withdraw value="' . $id . '-' . $trans['str'] . '">
     <input type=hidden name=a value="pay_withdraw">
  
     Sending <b>$' . $to_withdraw . '</b> to C-Gold account:' . $trans['account'] . '
     <br>Payment will be made from this account:			
	 <INPUT type=text class=inpts name="forced_payer_account" value="' . $settings['def_payee_account_cgold'] . '">
	 <input type=hidden name="payment_amount" value="' . $to_withdraw . '" />
     <INPUT type=hidden name="payee_account" value="' . $userinfo['cgold_account'] . '">
     <INPUT type=hidden name="payee_name" value="' . $userinfo['name'] . '" >
     <INPUT type=hidden name="payment_units" value="USD worth">
     <INPUT type=hidden name="payment_url" value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=yes">
     <INPUT type=hidden name="payment_url_method" value="post">
     <INPUT type=hidden name="nopayment_url" value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=no">
     <INPUT type=hidden name="nopayment_url_method" value="post">
     <INPUT type=hidden name="status_url" value="' . $settings['site_url'] . '/processing_cgold.php">
     <INPUT type=hidden name="suggested_memo" value="Withdraw to ' . $userinfo['name'] . ' from ';
      echo $settings['site_name'] . '">
     <br>
     <input type=submit value="Go to C-Gold.com" class=sbmt> &nbsp;
     <input type=button class=sbmt value="Cancel" onclick="window.close();">
     </form>';
      return 1;
    }

    if ($trans['ec'] == 8)
    {
      echo '
	 <form name="payment" method="POST" action="https://sci.altergold.com/">
	  <input type="hidden" name="WITHDRAW" value="' . $id . '-' . $trans['str'] . '">
      <input type="hidden" name="A" value="pay_withdraw"> 
	   Sending <b>$' . $to_withdraw . '</b> to AlterGold account:' . $trans['account'] . '
       <br>Payment will be made from this account:		
	  <input type=text class=inpts name="PAYER_ACCOUNT" value="' . $settings['def_payee_account_altergold'] . '">
      <input type="hidden" name="PAYEE_ACCOUNT" value="' . $userinfo['altergold_account'] . '">
	  <input type="hidden" name="PAYMENT_AMOUNT" value="' . $to_withdraw . '" />
      <input type="hidden" name="PAYMENT_CURRENCY" value="USD">
	  <input type="hidden" name="MEMO" value="Withdraw to ' . $userinfo['name'] . ' from ';
      echo $settings['site_name'] . '">
	  <input type="hidden" name="BAGGAGE_FIELDS" value="A,WITHDRAW">
	  <input type="hidden" name="PAYMENT_URL" value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=yes">
	  <input type="hidden" name="NO_PAYMENT_URL" value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=no">
	  <input type="hidden" name="STATUS_URL" value="' . $settings['site_url'] . '/processing_altergold.php">
	  <br>
      <input type=submit value="Go to AlterGold.com" class=sbmt> &nbsp;
      <input type=button class=sbmt value="Cancel" onclick="window.close();">
     </form>';
      return 1;
    }

    if ($trans['ec'] == 9)
    {
      echo 'Sending <b>$' . $to_withdraw . '</b> to Pecunix.<br>
      <form name=spend method=post action="https://pri.pecunix.com/money.refined">
       <input type=hidden name=withdraw value="' . $id . '-' . $trans['str'] . '">
       <input type=hidden name=a value="pay_withdraw">
       
	   <INPUT type=hidden name=PAYMENT_AMOUNT value="' . $to_withdraw . '">
       <INPUT type=hidden name=PAYEE_ACCOUNT value="' . $user['pecunix_account'] . '">
       <input type="hidden" name="PAYMENT_URL" value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://';
      echo $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'] . '?a=pay_withdraw&say=yes">
       <input type="hidden" name="NOPAYMENT_URL" value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://';
      echo $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'] . '?a=pay_withdraw&say=no">
       <input type="hidden" name="STATUS_URL" value="' . $settings['site_url'] . '/processing_pecunix.php">
       <input type="hidden" name="STATUS_TYPE" value="FORM">
       <input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
       <input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">
       <input type="hidden" name="PAYMENT_UNITS" value="USD">
       <input type="hidden" name="WHO_PAYS_FEES" value="PAYEE">
       <input type="hidden" name="SUGGESTED_MEMO" value="Withdraw to ' . $user['name'] . ' from ';
      echo $settings['site_name'] . '">
       <br>
       <br>
	    <input type=submit value="Go to Pecunix.com" class=sbmt> &nbsp;
        <input type=button class=sbmt value="Cancel" onclick="window.close();">
      </form>';
      return 1;
    }

    if ($trans['ec'] == 10)
    {
      echo '
	  <form action="https://perfectmoney.is/api/step1.asp" method="POST">
       <input type=hidden name="a" value="pay_withdraw">
       <input type=hidden name="withdraw" value="' . $id . '-' . $trans['str'] . '">
	    Sending <b>$' . $to_withdraw . '</b> to PerfectMoney account:' . $trans['account'] . '
       <input type="hidden" name="PAYEE_ACCOUNT" value="' . $userinfo['perfectmoney_account'] . '">
       <input type="hidden" name="PAYEE_NAME" value="' . $userinfo['name'] . '" >
       <input type="hidden" name="PAYMENT_AMOUNT" value="' . $to_withdraw . '" />
       <input type="hidden" name="PAYMENT_UNITS" value="USD">
       <input type="hidden" name="SUGGESTED_MEMO" value="Withdraw to ' . $userinfo['name'] . ' from ';
      echo $settings['site_name'] . '">
       <input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
       <input type="hidden" name="PAYMENT_URL" value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=yes">
       <input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">
       <input type="hidden" name="NOPAYMENT_URL"  value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://';
      echo $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'] . '?a=pay_withdraw&say=no">
       <input type="hidden" name="STATUS_URL" value="' . $settings['site_url'] . '/processing_perfectmoney.php">
       <input type="hidden" name="BAGGAGE_FIELDS" value="withdraw a">
	   <br>
       <input type=submit value="Go to PerfectMoney.com" class=sbmt> &nbsp;
       <input type=button class=sbmt value="Cancel" onclick="window.close();">
      </form>';
      return 1;
    }

    if ($trans['ec'] == 11)
    {
      echo '
	  <form action="https://www.strictpay.com/payments/autopay.php" method="POST">
       <input type=hidden name="extra4" value="pay_withdraw">
       <input type=hidden name="extra2" value="' . $id . '-' . $trans['str'] . '">
	    Sending <b>$' . $to_withdraw . '</b> to StrictPay account:' . $trans['account'] . '
	   <input type="hidden" name="payee_account"  value="' . $userinfo['strictpay_account'] . '">
       <input type="hidden" name="amount"  value="' . $to_withdraw . '" />
       <input type="hidden" name="memo" value="Withdraw to ' . $userinfo['name'] . ' from ';
      echo $settings['site_name'] . '">
       <input type="hidden" name="return_url" value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://' . $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'];
      echo '?a=pay_withdraw&say=yes">
       <input type="hidden" name="cancel_url"  value="';
      echo ($frm_env[HTTPS] ? 'https' : 'http') . '://';
      echo $frm_env['HTTP_HOST'] . $frm_env['SCRIPT_NAME'] . '?a=pay_withdraw&say=no">
       <input type="hidden" name="notify_url" value="' . $settings['site_url'] . '/processing_strictpay.php" />
	    <br>
       <input type=submit value="Go to StrictPay.com" class=sbmt> &nbsp;
       <input type=button class=sbmt value="Cancel" onclick="window.close();">
      </form>';
      return 1;
    }

    if ($trans['ec'] == 999)
    {
      if ($frm['confirm'] == 'ok')
      {
        $q = 'DELETE FROM hm2_history WHERE id = ' . $id;
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }

        $q = 'INSERT INTO hm2_history SET user_id = ' . $user['id'] . ',amount = -' . abs ($trans['actual_amount']) . ',type = \'withdrawal\',description = \'Withdraw processed. wire transfer has been sent\',actual_amount = -' . abs ($trans['actual_amount']) . ',ec = 999,date = now()';
        if (!(mysql_query ($q)))
        {
          echo mysql_error ();
          true;
        }

        echo '  Withdrawal has been processed. ';
        return 1;
      }

      echo 'You should send a Wire Transfer to the user bank account and then confirm the transaction.<br>
          <form name=spend method=post>
           <input type=hidden name=a value=pay_withdraw>
           <input type=hidden name=id value="' . $id . '">
           <input type=hidden name=confirm value=ok>
           <br>
		   <input type=submit value="Confirm transaction" class=sbmt> &nbsp;
           <input type=button class=sbmt value="Cancel" onclick="window.close();">
          </form>';
      return 1;
    }

    if ($frm['confirm'] == 'ok')
    {
      $q = 'DELETE FROM hm2_history WHERE id = ' . $id;
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $q = 'INSERT INTO hm2_history SET user_id = ' . $user['id'] . ',amount = -' . abs ($trans['actual_amount']) . ',type = \'withdrawal\',description = \'Withdraw processed\',actual_amount = -' . abs ($trans['actual_amount']) . ',ec = ' . $trans['ec'] . ',date = now()';
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $row = $trans;
      $q = 'SELECT * FROM hm2_users where id = ' . $row['user_id'];
      $sth = mysql_query ($q);
      $userinfo = mysql_fetch_array ($sth);
      $info = array ();
      $info['username'] = $userinfo['username'];
      $info['name'] = $userinfo['name'];
      $info['amount'] = number_format (abs ($row['amount']), 2);
      $info['currency'] = $exchange_systems[$row['ec']]['name'];
      $info['account'] = 'n/a';
      $info['batch'] = 'n/a';
      send_mail ('withdraw_user_notification', $userinfo['email'], $settings['opt_in_email'], $info);
      $q = 'SELECT email FROM hm2_users where id = 1';
      $sth = mysql_query ($q);
      $admin_row = mysql_fetch_array ($sth);
      send_mail ('withdraw_admin_notification', $admin_row['email'], $settings['opt_in_email'], $info);
      echo 'Withdrawal has been processed.<br><br>
             <form><input type=button class=sbmt value="Close" onclick="window.close();"></form>';
      return 1;
    }

    echo 'You should send <b>$' . $to_withdraw . '</b> of <b>' . $exchange_systems[$trans['ec']]['name'] . '</b> to account: <b>' . $trans['account'] . '</b> and then confirm this transaction.<br>
             <form name=spend method=post>
              <input type=hidden name=a value=pay_withdraw>
              <input type=hidden name=id value="' . $id . '">
              <input type=hidden name=confirm value=ok>
              <br>
			  <input type=submit value="Confirm transaction" class=sbmt> &nbsp;
              <input type=button class=sbmt value="Cancel" onclick="window.close();">
            </form>';
  }

?>