{include file="header.tpl"}
{if $false_data != 1}
<h3>Please confirm your deposit:</h3><br><br>


<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="cmd" value="_xclick">
  <input type="hidden" name="business" value="{$settings.def_payee_account_paypal}">
  <input type="hidden" name="item_name" value="Deposit to {$settings.site_name} User {$userinfo.username}"> 
  <input type="hidden" name="amount" value="{$amount}"> 
  <input type="hidden" name="return" value="{$settings.site_url}/processing_paypal.php"> 
  <input type="hidden" name="cancel_return" value="{$settings.site_url}/processing_status.php"> 
  <input type=hidden name=custom value="checkpayment|{$userinfo.id}|{$h_id}">
  <input type=hidden name=quantity value=1>
  <input type=hidden name=no_note value=1>
  <input type=hidden name=no_shipping value=1>
  <input type=hidden name=rm value=2>
  <input type=hidden name=currency_code value=USD>

Your PayPal account <b>{$userinfo.paypal_account}</b><br>
Amount ($US): <b>{$amount_format}</b><br>
{if $use_compound}
 {if $compound_min_percents == $compound_max_percents && !$compound_percents}
  <input type=hidden name=on0 value="compound">
  <input type=hidden name=os0 value="{$compound_min_percents}">
 {else}
 <table cellspacing=0 cellpadding=2 border=0>
  <tr>
   <td nowrap width=1%>Compounding percent: </td>
   {if $compound_percents}
   <input type=hidden name=on0 value="compound">
   <td><select name='os0' class=inpts>
       {section name=p loop=$compound_percents}
       <option value="{$compound_percents[p].percent}">{$compound_percents[p].percent}%</option>
       {/section}
       </select>
   </td>
  {else}
  <input type=hidden name=on0 value="compound">
  <td width=99%>
   <input type=text name='os0' value="{$compound_min_percents}" class=inpts size=5>
  </td>
 </tr>
 <tr>
  <td nowrap colspan=2>
   (You can set any percent between <b>{$compound_min_percents}%</b> and <b>{$compound_max_percents}%</b>) 
  </td>
  {/if}
  </tr>
 </table>
 {/if}
{/if}

<br><br>
<input type=submit value="Process" class=sbmt> &nbsp;
<input type=button class=sbmt value="Cancel" onclick="document.location='account_main.php'">
</form>
{/if}
{include file="footer.tpl"}