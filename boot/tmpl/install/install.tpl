{include file="header_install.tpl"}


{if $wrong_license == 1}
</center>
<font color="red"><B>Wrong license.</b><br><br>
Please contact <a href="http://www.hyipmanagerscript.com">HyipManagerScript.com</a> if you bought license to this host.</font>
<br><br>
<center>
{/if}

{if $wrong_admin == 1}
</center>
<font color="red"><B>Wrong Admin Infos.</b><br><br>
Please be sure you entered an admin password and admin email.</font>
<br><br>
<center>
{/if}

{if $wrong_server_comm == 1}
</center>
<font color="red"><B>HMS Server Error.</B><br><br>
Please contact <a href="http://www.hyipmanagerscript.com">HyipManagerScript.com</a>  to inform us about this error.We'll activate manually your license.</font>
<br><br>
<center>
{/if}


{if $wrong_mysql_data}
</center>
<font color="red"><B>Wrong mysql data.</B><br><br>
Please be sure you entered right mysql host, mysql database name, mysql login, mysql password.<br>
Ask this information your hosting provider if you're not sure.</font>
<br><br>
<center>
{/if}

{if $installed != 1}
<table width="100%">
<tr>
 <td width="35%" align="center"><img src="images/install/box.jpg"></td>
 <td widh="65%" align="left">
  <form method=post>
  <input type=hidden name=a value=install>
  <table cellspacing=2 cellpadding=2 border=0>
  <tr>
   <td colspan=2 align="left"><U><B>MySQL data</B></U></td>
  </tr>
  <tr>
   <td><B>Mysql host:</B></td>
   <td>
    <input type=text name=mysql_host value='{if $form_data.mysql_host}{$form_data.mysql_host}{else}localhost{/if}'     class=inpts size=30>
   </td>
  </tr>
  <tr>
   <td><B>Mysql Database name:</B></td>
   <td><input type=text name=mysql_db value='{$form_data.mysql_db}' class=inpts size=30></td>
  </tr>
  <tr>
   <td><B>Mysql username:</B></td>
   <td><input type=text name=mysql_username value='{$form_data.mysql_username}' class=inpts size=30></td>
  </tr>
  <tr>
   <td><B>Mysql password:</B></td>
   <td><input type=text name=mysql_password value='{$form_data.mysql_password}' class=inpts size=30></td>
  </tr>
  <tr>
   <td colspan=2 align="left"><U><B>License data:</B></U></th>
  </tr>
  <tr>
   <td><B>Host:</B></td>
   <td>{$hostname}</td>
  </tr>
  <tr>
   <td><B>License key:</B></td>
   <td><input type=text name=license_string value='{$form_data.license_string}' class=inpts size=30></td>
  </tr>
  <tr>
   <td><B>Encode Settings file:</B></td>
   <td><select name="encode_f" class="inpts">
      <option value="1">Yes</option>
      <option value="0">No</option>
     </select>
   </td>
  </tr>
  <tr>
   <td colspan=2 align="left"><U><B>Admin account data:</B></U></th>
  </tr>
  <tr>
   <td><B>E-mail:</B></td>
   <td><input type=text name=admin_email value='{$form_data.admin_email}' class=inpts size=30></td>
  </tr>
  <tr>
   <td><B>Password:</B></td>
   <td><input type=password name=admin_password value='' class=inpts size=30></td>
  </tr>
  <tr>
   <td>&nbsp;</td>
   <td><input type=submit value='Install' class=sbmt></td>
  </tr>
  </table>
  </form>
 </td>
</tr>
</table>
{else}
<h1>Script successfully installed!</h1>
<br><br>
<table cellspacing=0 cellpadding=1 border=0 width=400><tr><td>
Please delete install.php file for security reason.<br><br>

Path to script: <a href="{$script_path}" target=_blank>{$script_path}</a><br>
Admin login: admin<br>
Admin password: {$form_data.admin_password}<br><br>

Login to admin area, go to settings screen and specify your sitename, e-gold account and other information.<br>
</td></tr></table>
{/if}

{include file="footer_install.tpl"}
