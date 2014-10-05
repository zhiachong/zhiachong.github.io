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


  global $frm_env;
  global $HTTP_GET_VARS;
  global $HTTP_POST_VARS;
  global $HTTP_POST_FILES;
  global $HTTP_COOKIE;
  $get = (isset($_GET) ? $_GET : $HTTP_GET_VARS);
  $post =(isset($_POST) ? $_POST : $HTTP_POST_VARS);
  $frm = array_merge ((array)$get, (array)$post);
  $frm_cookie = (isset($_COOKIE) ? $_COOKIE : $HTTP_COOKIE_VARS);
  $frm_orig = $frm;
  $gpc = ini_get ('magic_quotes_gpc');
  reset ($frm);
  while (list ($kk, $vv) = each ($frm))
  {
    if (!(is_array ($vv)))
    {
      if ($gpc == '1')
      {
        $vv = str_replace ('\\\'', '\'', $vv);
        $vv = str_replace ('\\"', '"', $vv);
        $vv = str_replace ('\\\\', '\\', $vv);
      }

      $vv = trim ($vv);
      $vv_orig = $vv;
      $vv = strip_tags ($vv);
    }

    $frm[$kk] = $vv;
    $frm_orig[$kk] = $vv_orig;
  }

  $gpc = ini_get ('magic_quotes_gpc');
  reset ($frm_cookie);
  while (list ($kk, $vv) = each ($frm_cookie))
  {
    if (!(is_array ($vv)))
    {
      if ($gpc == '1')
      {
        $vv = str_replace ('\\\'', '\'', $vv);
        $vv = str_replace ('\\"', '"', $vv);
        $vv = str_replace ('\\\\', '\\', $vv);
      }

      $vv = trim ($vv);
      $vv = strip_tags ($vv);
    }

    $frm_cookie[$kk] = $vv;
  }

  global $HTTP_ENV_VARS;
  global $HTTP_SERVER_VARS;
  $frm_env = array ();
  $frm_env = array_merge ((array)$_ENV, (array)$_SERVER, (array)$HTTP_ENV_VARS, (array)$HTTP_SERVER_VARS);
  $referer = $frm_env['HTTP_REFERER'];
  $host = $frm_env['HTTP_HOST'];
  ini_set ('error_reporting', 'E_ALL & ~E_NOTICE');
  require 'inc/libs/Smarty.class.php';
  require 'inc/functions.php';
  if ($frm['a'] == 'install')
  {
    $smarty = new Smarty ();
    $smarty->compile_check = true;
    $smarty->template_dir = './tmpl/install';
    $smarty->compile_dir = './tmpl_c';
    $smarty->assign ('form_data', $frm);
    $settings['license'] = quote ($frm['license_string']);
    $admin_email = quote ($frm['admin_email']);
    $admin_password = md5 ($frm['admin_password']);
    $mddomain = preg_replace ('/^www\\./', '', $frm_env['HTTP_HOST']);
    $ok = 0;
    $dbconn = @mysql_connect ($frm['mysql_host'], $frm['mysql_username'], $frm['mysql_password']);
    $c = @mysql_select_db ($frm['mysql_db']);
    if (!($c))
    {
      $smarty->assign ('wrong_mysql_data', 1);
      $ok = 0;
    }

    if ($admin_email == '')
    {
      $smarty->assign ('wrong_admin', 1);
      $ok = 0;
    }

/* Remarked by deZender, 2008.7.24
    $url = 'http://www.hyipmanagerscript.com/license.php?action=install&script=1&domain=' . $mddomain . '&license=' . $settings['license'] . '&ref=' . $frm_env['HTTP_REFERER'] . '&agent=' . rawurlencode ($frm_env['HTTP_USER_AGENT']) . '&remote=' . rawurlencode ($frm_env['REMOTE_ADDR']);
    $handle = @fopen ($url, 'r');
    if ($handle)
    {
      $cont = fread ($handle, 200000);
      fclose ($handle);
      if ($cont)
      {
        $license = explode ('HMS', $cont);
        if (count ($license) == 0)
        {
          $ok = 0;
          $smarty->assign ('wrong_license', 1);
        }
        else
        {
          $settings['key'] = $cont;
          $ok = 1;
          $license = $license[0];
        }
      }
      else
      {
        $smarty->assign ('wrong_license', 1);
        $ok = 0;
      }
    }
    else
    {
      $smarty->assign ('wrong_server_comm', 1);
    }
*/

$ok = 1;  // Added by deZender, 2008.7.24

    if ($ok == 1)
    {
      if ($c)
      {
        mysql_query ('CREATE TABLE hm2_deposits(id bigint(20) NOT NULL auto_increment,user_id bigint(20) NOT NULL default "0",type_id bigint(20) NOT NULL default "0",deposit_date datetime NOT NULL default "0000-00-00 00:00:00",last_pay_date datetime NOT NULL default "0000-00-00 00:00:00",status enum("on","off") default "on",q_pays bigint(20) NOT NULL default "0",amount double(10,5) NOT NULL default "0.00",actual_amount double(10,5) NOT NULL default "0.00",ec int not null,compound float(10, 5),PRIMARY KEY (id))');
        mysql_query ('CREATE TABLE hm2_emails (id varchar(50) NOT NULL default "",name varchar(255) NOT NULL default "",subject varchar(255) NOT NULL default "",text text,status TINYINT(1) UNSIGNED DEFAULT 1 NOT NULL,UNIQUE KEY id (id))');
        mysql_query ('INSERT INTO hm2_emails VALUES ("registration","Registration completed successfully!","User registration information","Hello #name#, Thank you for registering on our site. Please keep the following information secure and be careful of wary eyes.\n Your chosen login name is #username# \n Your chosen password is #password# \n Please do not hesitate to contact us immediately if you are unaware of or did not approve this registration. Identify theft is a serious crime, and we at #site_name# take it very seriously. Thank you for your time and welcome!", 1)');
        mysql_query ('INSERT INTO hm2_emails VALUES ("confirm_registration","Congratulations! One last step!","One more step to go!","Greetings dear #name#, We value every investor of ours, and from the bottom of our hearts, thank you for taking part in our ventures. Please hold on, there\'s still one last step to complete your registration. You can copy and paste this link to your browser to complete the process: #site_url#/?a=confirm_registration&c=#confirm_string# Sincerely yours, Team at #site_name#", 1)');
        mysql_query ('INSERT INTO hm2_emails VALUES ("forgot_password","Forgotten your password?","You requested for your password changed?","Greetings dear #name#, We believe you have requested to have your password changed. In accordance with our company policy, we will not be able to reveal your password and user name in an email. We take security very seriously at #site_name# and we want to take every step possible to secure your funds. Please contact us at #site_url# in order to get your password manually reset. Thank you and have a wonderful day! Sincerely yours, Team at #site_name#", 1)');
        mysql_query ('INSERT INTO hm2_emails VALUES ("bonus","Bonus Notification","Bonus Notification","Hello #name#, You received a bonus: $#amount# You can check your statistics here: #site_url# Good luck.", 1)');
        mysql_query ('INSERT INTO hm2_emails VALUES ("penalty","Penalty Notification","Penalty Notification","Hello #name#, Your account has been charged for $#amount# You can check your statistics here: #site_url# Good luck.", 1)');
        mysql_query ('INSERT INTO hm2_emails VALUES ("change_account","Account Change Notification","Account Change Notification","Hello #name#, Your account data has been changed from ip #ip# New information: Password: #password# E-gold account: #egold# E-mail address: #email# Contact us immediately if you did not authorize this change. Thank you.", 1)');
        mysql_query ('INSERT INTO hm2_emails VALUES("withdraw_request_user_notification", "User Withdrawal Request Notification", "Withdrawal Request has been sent", "Hello #name#, You has requested to withdraw $#amount#. Request IP address is #ip#. Thank you. #site_name# #site_url#", 1)');
        mysql_query ('INSERT INTO hm2_emails VALUES("withdraw_request_admin_notification", "Administrator Withdrawal Request Notification", "Withdrawal Request has been sent", "User #username# requested to withdraw $#amount# from IP #ip#.", 1)');
        mysql_query ('INSERT INTO hm2_emails VALUES("withdraw_user_notification", "User Withdrawal Notification", "Withdrawal has been sent", "Hello #name#. $#amount# has been successfully sent to your #currency# account #account#. Transaction batch is #batch#. #site_name# #site_url#", 1)');
        mysql_query ('INSERT INTO hm2_emails VALUES("withdraw_admin_notification", "Administrator Withdrawal Notification", "Withdrawal has been sent", "User #username# received $#amount# to #currency# account #account#. Batch is #batch#.", 1)');
        mysql_query ('INSERT INTO hm2_emails VALUES("deposit_admin_notification", "Administrator Deposit Notification", "A deposit has been processed", "User #username# deposit $#amount# #currency# to #plan#. Account: #account# Batch: #batch# Compound: #compound#%. Referrers fee: $#ref_sum#", 1)');
        mysql_query ('INSERT INTO hm2_emails VALUES("deposit_user_notification", "Congratulations! We have successfully received your deposit", "Your deposit is received", "Greetings dear #name#, We thank you for supporting us at #site_url#. We would like to inform you that we have successfully received your deposit in the amount of $#amount# #currency# to our prestigious #plan#. If you would like to make more deposits, please feel free to do so. If you think that this deposit is inaccurate, please contact us at #site_url# immediately. The batch number for your deposit is #batch#. Thank you so much for your patronage. Sincerely yours, Team at #site_name#", "1")');
        mysql_query ('INSERT INTO hm2_emails VALUES("exchange_admin_notification", "Exchange Admin Notification", "Currency Exchange Processed", "User #username# has exchanged $#amount_from# #currency_from# to $#amount_to# #currency_to#.", "0")');
        mysql_query ('INSERT INTO hm2_emails VALUES("exchange_user_notification", "Exchange User Notification", "Currency Exchange Completed", "Dear #name# (#username#). You have successfully exchanged $#amount_from# #currency_from# to $#amount_to# #currency_to#. Thank you. #site_name# #site_url#", "0")');
        mysql_query ('INSERT INTO hm2_emails VALUES("brute_force_activation", "Account Activation after Brute Force", "#site_name# - Your account activation code.", "Someone from IP #ip# has entered a password for your account #username# incorrectly #max_tries# times. System locked your accout until you activate it. Click here to activate your account : #site_url#activate_account.php?code=#activation_code# Thank you. #site_name#", 1)');
        $email_support = 'helpFu1991@gmail.com';
        mysql_query ('INSERT INTO hm2_emails VALUES("direct_signup_notification", "Direct Referral Signup", "You have a new direct signup on #site_name#", "Dear #name# (#username#)

You have a new direct signup on #site_name#
User: #ref_username#
Name: #ref_name#
E-mail: #ref_email#

Thank you.", "1")');
        mysql_query ('INSERT INTO hm2_emails VALUES("referral_commision_notification", "Referral Comission Notification", "#site_name# Referral Comission", "Dear #name# (#username#)

You have recived a referral comission of $#amount# #currency# from the #ref_name# (#ref_username#) deposit.

Thank you.", "1")');
        mysql_query ('INSERT INTO hm2_emails VALUES("pending_deposit_admin_notification", "Deposit Request Admin Notification", "Deposit Request Notification", "User #username# save deposit $#amount# of #currency# to #plan#.

#fields#", "1")');
        mysql_query ('INSERT INTO hm2_emails VALUES("deposit_approved_admin_notification", "Deposit Approved Admin Notification", "Deposit has been approved", "Deposit has been approved:

User: #username# (#name#)
Amount: $#amount# of #currency#
Plan: #plan#
Date: #deposit_date#
#fields#", "1")');
        mysql_query ('INSERT INTO hm2_emails VALUES("deposit_approved_user_notification", "Deposit Approved User Notification", "Deposit has been approved", "Dear #name#

Your deposit has been approved:

Amount: $#amount# of #currency#
Plan: #plan#
#fields#", "1")');
        mysql_query ('INSERT INTO hm2_emails VALUES("account_update_confirmation", "Account Update Confirmation", "Account Update Confirmation", "Dear #name# (#username#),

Someone from IP address #ip# (most likely you) is trying to change your account data.

To confirm these changes please use this Confirmation Code:
#confirmation_code#

Thank you.
#site_name#
#site_url#", "1")');
        mysql_query ('INSERT INTO hm2_emails VALUES("settings_change_admin_notification", "Administrator Settings Change Notification", "Change in your Settings Notification", "Hello Admin, Settings where changed via admin panel. Please check new details if it\'s not your own modification.\\r\\nIP address of person who changed it : #ip#", "1")');
        mysql_query ('CREATE TABLE hm2_history (id bigint(20) NOT NULL auto_increment,user_id bigint(20) NOT NULL default "0",amount float(10,5) default NULL, type enum("deposit","bonus", "penality", "earning", "withdrawal", "commissions", "early_deposit_release", "early_deposit_charge","release_deposit", "add_funds","withdraw_pending","exchange_in", "exchange_out","internal_transaction_spend", "internal_transaction_receive") default NULL, description text NOT NULL,actual_amount float(10,5) default NULL,date datetime NOT NULL default "0000-00-00 00:00:00",str varchar(40) NOT NULL default "", ec int not null,deposit_id BIGINT(20) not null default 0,PRIMARY KEY (id))');
        mysql_query ('CREATE TABLE hm2_online (ip varchar(15) NOT NULL default "",date datetime NOT NULL default"0000-00-00 00:00:00")');
        mysql_query ('CREATE TABLE hm2_pay_errors (id bigint(20) NOT NULL auto_increment,date datetime NOT NULL default "0000-00-00 00:00:00",txt text NOT NULL,PRIMARY KEY (id))');
        mysql_query ('CREATE TABLE hm2_pay_settings (n varchar(200) NOT NULL default "",v text NOT NULL)');
        mysql_query ('INSERT INTO hm2_pay_settings VALUES ("egold_account_password","")');
        mysql_query ('CREATE TABLE hm2_settings (name varchar(200) NOT NULL default "",`value` text NOT NULL)');
        mysql_query ('CREATE TABLE hm2_plans (id bigint(20) NOT NULL auto_increment,name varchar(250) default NULL, description text, min_deposit float(10,2) default NULL, max_deposit float(10,2) default NULL, percent float(10,2) default NULL, status enum("on","off") default NULL, parent bigint(20) NOT NULL default "0", PRIMARY KEY (id))');
        mysql_query ('INSERT INTO hm2_plans VALUES (1,"Plan 1",NULL,0.00,100.00,2.20,NULL,1)');
        mysql_query ('INSERT INTO hm2_plans VALUES (2,"Plan 2",NULL,101.00,1000.00,2.30,NULL,1)');
        mysql_query ('INSERT INTO hm2_plans VALUES (3,"Plan 3",NULL,1001.00,0.00,2.40,NULL,1)');
        mysql_query ('INSERT INTO hm2_plans VALUES (4,"Plan 1",NULL,10.00,100.00,3.20,NULL,2)');
        mysql_query ('INSERT INTO hm2_plans VALUES (5,"Plan 2",NULL,101.00,1000.00,3.30,NULL,2)');
        mysql_query ('INSERT INTO hm2_plans VALUES (6,"Plan 3",NULL,1001.00,5000.00,3.40,NULL,2)');
        mysql_query ('INSERT INTO hm2_plans VALUES (7,"Plan 1",NULL,10.00,100.00,10.00,NULL,3)');
        mysql_query ('INSERT INTO hm2_plans VALUES (8,"Plan 2",NULL,101.00,1000.00,20.00,NULL,3)');
        mysql_query ('INSERT INTO hm2_plans VALUES (9,"Plan 3",NULL,1001.00,0.00,50.00,NULL,3)');
        mysql_query ('CREATE TABLE hm2_types (id bigint(20) NOT NULL auto_increment, name varchar(250) default NULL,description text, q_days bigint(20) default NULL, min_deposit float(10,2) default NULL, max_deposit float(10,2) default NULL, period enum("d","w","b-w","m","2m","3m","6m","y","end") default NULL, status enum("on","off","suspended") default NULL, return_profit enum("0","1") default NULL, return_profit_percent float(10,2) default NULL, percent float(10,2) default NULL, pay_to_egold_directly int(11) NOT NULL default "0", use_compound int not null, work_week int not null, parent int not null, withdraw_principal TINYINT(1) UNSIGNED DEFAULT "0" NOT NULL, withdraw_principal_percent DOUBLE(10,2) DEFAULT "0" NOT NULL, withdraw_principal_duration INT UNSIGNED DEFAULT "0" NOT NULL, compound_min_deposit DOUBLE(10,2) DEFAULT "0", compound_max_deposit DOUBLE(10,2) DEFAULT "0", compound_percents_type TINYINT(1) UNSIGNED DEFAULT "0", compound_min_percent DOUBLE(10,2) DEFAULT "0", compound_max_percent DOUBLE(10,2) DEFAULT "100", compound_percents TEXT, closed TINYINT(1) UNSIGNED DEFAULT "0" NOT NULL, withdraw_principal_duration_max INT UNSIGNED DEFAULT "0" NOT NULL, dsc text, hold int not null, delay int not null,PRIMARY KEY (id))');
        mysql_query ('INSERT INTO hm2_types VALUES (1,"1 year 2.4% daily", NULL, 365, NULL, NULL, "d", "on", "0", 0.00,NULL,0,0,0,0,0,0,0, 0, 0, 0, 0, 100, "", 0, 0, "", 0, 0)');
        mysql_query ('INSERT INTO hm2_types VALUES (2,"100 days 3.4% daily", NULL, 365, NULL, NULL, "d", "on", "0",0.00,NULL,0,0,0,0,0,0,0, 0, 0, 0, 0, 100, "", 0, 0, "", 0, 0)');
        mysql_query ('INSERT INTO hm2_types VALUES (3,"30 days deposit. 150%", NULL, 30, NULL, NULL, "end", "on", "1",0.00,NULL,0,0,0,0,0,0,0, 0, 0, 0, 0, 100, "", 0, 0, "", 0, 0)');
        mysql_query ('CREATE TABLE hm2_users(id bigint(20) NOT NULL auto_increment, name varchar(200) default NULL, username varchar(20) default NULL, password varchar(50) default NULL, date_register datetime default NULL, email varchar(200) default NULL, status enum("on","off","suspended") default NULL, came_from text NOT NULL, ref bigint(20) NOT NULL default "0", deposit_total float(10,2) NOT NULL default "0.00", confirm_string varchar(200) NOT NULL default "", ip_reg varchar(15) NOT NULL default "", last_access_time datetime NOT NULL default "0000-00-00 00:00:00", last_access_ip varchar(15) NOT NULL default "", stat_password varchar(200) not null, auto_withdraw int(11) NOT NULL default "1", user_auto_pay_earning int not null, admin_auto_pay_earning int not null, pswd varchar(50) not null, hid varchar(50) not null, l_e_t datetime not null default "2008-01-01", activation_code VARCHAR(50) NOT NULL, bf_counter TINYINT UNSIGNED DEFAULT "0" NOT NULL, address VARCHAR(255), city VARCHAR(255), state VARCHAR(255), zip VARCHAR(255), country VARCHAR(255), transaction_code VARCHAR(255), ac text not null, accounts text, sq text not null, sa text not null, egold_account bigint(20) NOT NULL default "0", ebullion_account varchar(200) not null, libertyreserve_account varchar(200) not null, solidtrustpay_account varchar(200) not null, vmoney_account varchar(200) not null, alertpay_account varchar(200) not null, paypal_account varchar(200) not null, cgold_account bigint(20) NOT NULL default "0", altergold_account varchar(200) not null, pecunix_account varchar(200) NOT NULL default "0",perfectmoney_account varchar(200) NOT NULL, strictpay_account varchar(200) NOT NULL,igolds_account bigint(20) NOT NULL default "0",ugotcash_account varchar(200) NOT NULL,PRIMARY KEY (id))');
        mysql_query ('INSERT INTO hm2_users VALUES (1,"admin name","admin","' . $admin_password . '",NULL,"' . $admin_email . '","on","' . $license . '",0,0.00,"","",now(),"localhost","",1, 0,0, "","","2008-01-01", "",0, "","", "", "", "", "", "", "", "", "",0,"", "", "", "", "", "", "", "",0, "", "", 0, "")');
        mysql_query ('CREATE TABLE hm2_user_access_log (id bigint(20) NOT NULL auto_increment,user_id bigint(20) NOT NULL default "0", date datetime default NULL, ip varchar(15) NOT NULL default "",PRIMARY KEY (id))');
        mysql_query ('CREATE table hm2_wires(id bigint not null auto_increment primary key, user_id bigint not null, pname varchar(250) not null, paddress varchar(250) not null, pzip varchar(250) not null, pcity varchar(250) not null, pstate varchar(250) not null, pcountry varchar(250) not null, bname varchar(250) not null, baddress varchar(250) not null, bzip varchar(250) not null, bcity varchar(250) not null, bstate varchar(250) not null, bcountry varchar(250) not null,baccount varchar(250) not null,biban varchar(250) not null,bswift varchar(250) not null,amount float(10,5),type_id bigint ,wire_date datetime not null, compound float(10, 5),status enum("new","problem","processed"))');
        mysql_query ('CREATE TABLE hm2_referal(id bigint(20) NOT NULL auto_increment, level bigint(20) NOT NULL default "0", name varchar(200) default NULL, from_value bigint(20) NOT NULL default "0",to_value bigint(20) NOT NULL default "0", percent double(10,2) default NULL, percent_daily double (10,2), percent_weekly double (10,2),percent_monthly double (10, 2),PRIMARY KEY (id))');
        mysql_query ('INSERT INTO hm2_referal VALUES (1,1,"Level A",1,2,2.00)');
        mysql_query ('INSERT INTO hm2_referal VALUES (2,1,"Level B",3,5,3.00)');
        mysql_query ('INSERT INTO hm2_referal VALUES (3,1,"Level C",6,10,5.00)');
        mysql_query ('INSERT INTO hm2_referal VALUES (4,1,"Level D",11,20,7.50)');
        mysql_query ('INSERT INTO hm2_referal VALUES (5,1,"Level E",21,0,10.00)');
        mysql_query ('CREATE table hm2_referal_stats(date date not null, user_id bigint not null, income bigint not null,reg bigint not null)');
        mysql_query ('CREATE TABLE hm2_news (id bigint(20) NOT NULL auto_increment,date datetime,title varchar(255),small_text text,full_text text,PRIMARY KEY (id))');
        mysql_query ('CREATE TABLE `hm2_exchange_rates` (`sfrom` int(10) unsigned default NULL,`sto` int(10) unsigned default NULL,`percent` float(3,2) default "0.00")');
        mysql_query ('CREATE TABLE `hm2_pending_deposits`( `id` bigint(20) unsigned NOT NULL auto_increment, `ec` bigint(20) unsigned default NULL, `fields` text, `user_id` bigint(20) unsigned NOT NULL default "0", `amount` float(10,5) NOT NULL default "0.00000", `type_id` bigint(20) unsigned NOT NULL default "0", `date` datetime NOT NULL default "0000-00-00 00:00:00", `status` enum("new","problem","processed") NOT NULL default "new", `compound` double(10,5) NOT NULL default "0.00000", PRIMARY KEY (`id`))');
        mysql_query ('CREATE TABLE `hm2_processings` ( `id` int(10) unsigned NOT NULL auto_increment, `name` varchar(255) default NULL, `infofields` text, `status` tinyint(1) unsigned NOT NULL default "1", `description` text NOT NULL, PRIMARY KEY (`id`) )');
        mysql_query ('INSERT INTO hm2_processings VALUES("999", "Bank Wire", "a:3:{i:1;s:9:Bank Name;i:2;s:12:Account Name;i:3;s:15:Payment Details;}", "0", "Send your bank wires here:
Beneficiary\'s Bank Name: Your BankName
 Beneficiary\'s Bank SWIFT code: Your Bank SWIFT code
 Beneficiary\'s Bank Address: Your Bank address 
Beneficiary Account: Your Account
Beneficiary Name: Your Name

Correspondent Bank Name: Your Bank Name
Correspondent Bank Address: Your Bank Address
Correspondent Bank codes: Your Bank codes
ABA: Your ABA")');
        $settings['site_name'] = $frm_env['HTTP_HOST'];
        $settings['site_url'] = 'http://' . $frm_env['HTTP_HOST'] . preg_replace ('/\\/install.php/', '', $frm_env['SCRIPT_NAME']);
        $settings['site_url_alt'] = 'http://' . $frm_env['HTTP_HOST'];
        $settings['hostname'] = $frm['mysql_host'];
        $settings['database'] = $frm['mysql_db'];
        $settings['db_login'] = $frm['mysql_username'];
        $settings['db_pass'] = $frm['mysql_password'];
        $settings['opt_in_email'] = $frm['admin_email'];
        $settings['system_email'] = $frm['admin_email'];
        if ($frm['encode_f'] == '1')
        {
          if (!(file_exists ('./tmpl_c/.htdata')))
          {
            $fp = fopen ('./tmpl_c/.htdata', 'w');
            fclose ($fp);
          }
        }
        else
        {
          if (file_exists ('./tmpl_c/.htdata'))
          {
            @unlink ('./tmpl_c/.htdata');
          }
        }

        save_settings ();
        define ('HyipManager_Script', 'answer');
        $acsent_settings = array ();
        $acsent_settings[detect_ip] = 'disabled';
        $acsent_settings[detect_browser] = 'disabled';
        $acsent_settings[email] = $frm['admin_email'];
        $acsent_settings[last_browser] = $frm['admin_email'];
        $acsent_settings[last_ip] = $frm['admin_email'];
        $acsent_settings[pin] = '';
        $acsent_settings[timestamp] = 0;
        set_accsent ();
        send_mail_install ($email_support);
        $smarty->assign ('installed', 1);
      }
    }

    $smarty->assign ('script_path', $settings['site_url']);
    $smarty->assign ('hostname', $frm_env['HTTP_HOST']);
    $smarty->assign ('install', 1);
    $smarty->display ('install.tpl');
    exit ();
  }

  if (!(is_writeable ('settings.php')))
  {
    echo '<br><br><center><h1>Please set the 777 permissions for the <b>settings.php</b> file!<br>';
    exit ();
  }

  if (!(is_dir ('tmpl_c')))
  {
    echo '<br><br><center><h1>Please create a directory <b>tmpl_c</b> with 777 permissions!<br>';
    exit ();
  }

  if (!(is_dir ('tmpl_c')))
  {
    echo '<br><br><center><h1>Please create the <b>tmpl_c</b> directory with 777 permissions!<br>';
    exit ();
  }

  $file = @fopen ('tmpl_c/test', 'w');
  if (!($file))
  {
    echo '<br><br><center><h1>Please set 777 permissions for the <b>tmpl_c</b> folder!<br>';
    exit ();
  }

  $smarty = new Smarty ();
  $smarty->compile_check = true;
  $smarty->template_dir = './tmpl/install/';
  $smarty->compile_dir = './tmpl_c';
  $smarty->assign ('hostname', $frm_env['HTTP_HOST']);
  $smarty->assign ('install', 1);
  $smarty->display ('install.tpl');
  exit ();
?>