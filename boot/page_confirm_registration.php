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
  if ($settings['use_opt_in'] == 1)
  {
    $success = 0;
    if ($frm['c'] != '')
    {
      $info = array ();
      $conf_string = quote ($frm['c']);
      $q = 'SELECT * from hm2_users where confirm_string = \'' . $conf_string . '\'';
      if (!($sth = mysql_query ($q)))
      {
        exit (mysql_error ());
      }

      while ($row = mysql_fetch_array ($sth))
      {
        $success = 1;
        $info['username'] = $row['username'];
        $info['password'] = '********';
        $info['name'] = $row['name'];
        $info['email'] = $row['email'];
        $info['ref'] = $row['ref'];
      }

      if ($success == 1)
      {
        $q = 'UPDATE hm2_users set confirm_string = \'\' where confirm_string = \'' . $conf_string . '\'';
        if (!(mysql_query ($q)))
        {
          exit (mysql_error ());
        }

        send_mail ('registration', $info['email'], $settings['opt_in_email'], $info);
        $ref = quote ($info['ref']);
        $q = 'SELECT * from hm2_users where id = \'' . $ref . '\'';
        $sth = mysql_query ($q);
        while ($refinfo = mysql_fetch_array ($sth))
        {
          $refminfo = array ();
          $refminfo['name'] = $refinfo['name'];
          $refminfo['username'] = $refinfo['username'];
          $refminfo['ref_username'] = $info['username'];
          $refminfo['ref_name'] = $info['name'];
          $refminfo['ref_email'] = $info['email'];
          send_mail ('direct_signup_notification', $refinfo['email'], $settings['opt_in_email'], $refminfo);
        }
      }
    }

    $smarty->assign ('success', $success);
    $smarty->display ('page_confirm_registration.tpl');
    return 1;
  }

  header ('Location: index.php');
  db_close ($dbconn);
  exit ();
?>