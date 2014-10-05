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


  include 'inc/config.inc.php';
  $dbconn = db_open ();
  if (!($dbconn))
  {
    echo 'Cannot connect mysql';
    exit ();
  }

  if ($frm['a'] == 'pay_withdraw')
  {
    $batch = quote ($frm['ATIP_TRANSACTION_ID']);
    list ($id, $str) = explode ('-', $frm['withdraw']);
    if ($str == '')
    {
      $str = 'abcdef';
    }

    $str = quote ($str);
    $q = 'SELECT * FROM hm2_history WHERE id = ' . $id . ' and str = \'' . $str . '\' and type=\'withdraw_pending\'';
    $sth = mysql_query ($q);
    while ($row = mysql_fetch_array ($sth))
    {
      $q = 'DELETE FROM hm2_history WHERE id = ' . $id;
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $q = 'INSERT INTO hm2_history  SET user_id = ' . $row['user_id'] . ', amount = -' . abs ($row['amount']) . (', type = \'withdrawal\', description = \'Withdraw processed. Batch id = ' . $batch . '\', actual_amount = -') . abs ($row['amount']) . ', ec = 5, date = now() ';
      if (!(mysql_query ($q)))
      {
        echo mysql_error ();
        true;
      }

      $q = 'SELECT * FROM hm2_users where id = ' . $row['user_id'];
      $sth = mysql_query ($q);
      $userinfo = mysql_fetch_array ($sth);
      if ($settings['withdraw_user_notification'])
      {
        $info = array ();
        $info['username'] = $userinfo['username'];
        $info['name'] = $userinfo['name'];
        $info['amount'] = abs ($row['amount']);
        $info['currency'] = $exchange_systems[$row['ec']]['name'];
        $info['account'] = $userinfo['ebullion_account'];
        $info['batch'] = $batch;
        send_mail ('withdraw_user_notification', $userinfo['email'], $settings['opt_in_email'], $info);
      }

      if ($settings['withdraw_admin_notification'])
      {
        $q = 'SELECT email FROM hm2_users WHERE id = 1';
        $sth = mysql_query ($q);
        $admin_row = mysql_fetch_array ($sth);
        $info = array ();
        $info['username'] = $userinfo['username'];
        $info['name'] = $userinfo['name'];
        $info['amount'] = abs ($row['amount']);
        $info['currency'] = $exchange_systems[$row['ec']]['name'];
        $info['account'] = $userinfo['ebullion_account'];
        $info['batch'] = $batch;
        send_mail ('withdraw_admin_notification', $admin_row['email'], $settings['opt_in_email'], $info);
        continue;
      }
    }

    echo 'www.HyipManagerScript.com';
    exit ();
  }

  $gpg_path = escapeshellcmd ($settings['gpg_path']);
  $atippath = './tmpl_c';
  $passphrase = decode_pass_for_mysql ($settings['md5altphrase_ebullion']);
  $xmlfile = tempnam ('', 'xml.cert.');
  $tmpfile = tempnam ('', 'xml.tmp.');
  $fd = fopen ('' . $tmpfile, 'w');
  fwrite ($fd, $frm_orig['ATIP_VERIFICATION']);
  fclose ($fd);
  $gpg_options = ' --yes --no-tty --no-secmem-warning --no-options --no-default-keyring --batch --homedir ' . $atippath . ' --keyring=pubring.gpg --secret-keyring=secring.gpg --armor --passphrase-fd 0';
  $gpg_command = 'echo \'' . $passphrase . '\' | ' . $gpg_path . ' ' . $gpg_options . ' --output ' . $xmlfile . ' --decrypt ' . $tmpfile . ' 2>&1';
  $buf = '';
  $keyID = '';
  $fp = @popen ('' . $gpg_command, 'r');
  if (!($fp))
  {
    echo 'GPG not found';
    db_close ($dbconn);
    exit ();
  }

  while (!(feof ($fp)))
  {
    $buf = fgets ($fp, 4096);
    $pos = strstr ($buf, 'key ID');
    if (0 < strlen ($pos))
    {
      $keyID = preg_replace ('/[\\n\\r]/', '', substr ($pos, 7));
      continue;
    }
  }

  pclose ($fp);
  if ($keyID == $settings['ebullion_keyID'])
  {
    if ($exchange_systems[5]['status'] == 1)
    {
      if (is_file ('' . $xmlfile))
      {
        $fx = fopen ('' . $xmlfile, 'r');
        $xmlcert = fread ($fx, filesize ('' . $xmlfile));
        fclose ($fx);
      }

      $data = parsexml ($xmlcert);
      $frm = array_merge ($frm, $data);
      $user_id = sprintf ('%d', $frm['userid']);
      $h_id = sprintf ('%d', $frm['hyipid']);
      $compound = sprintf ('%d', $frm['compound']);
      $amount = $frm['amount'];
      $batch = $frm['batch'];
      $account = $frm['payer'];
      $mode = $frm['a'];
      if ($frm['metal'] == 3)
      {
        if ($frm['unit'] == 1)
        {
          add_deposit (5, $user_id, $amount, $batch, $account, $h_id, $compound);
        }
      }
    }
  }

  db_close ($dbconn);
  echo 'www.HyipManagerScript.com';
  unlink ($tmpfile);
  unlink ($xmlfile);
  exit ();
?>