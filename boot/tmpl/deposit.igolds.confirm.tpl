{include file="header.tpl"}

{if $false_data != 1}
<h3>Please confirm your deposit:</h3>

<br><br>

<form name=spend method=post action="https://www.igolds.net/sci_payment.html">

Your iGolds account number <b>{$userinfo.igolds_account}</b><br>
Amount ($US): <b>{$amount_format}</b><br>

{if $use_compound}
 {if $compound_min_percents == $compound_max_percents && !$compound_percents}
  <input type=hidden name=IGS_CUSTOM_compound value="{$compound_min_percents}">
 {else}
 <table cellspacing=0 cellpadding=2 border=0>
 <tr>
  <td nowrap width=1%>Compounding percent: </td>
  {if $compound_percents}
  <td><select name='IGS_CUSTOM_compound' class=inpts>
      {section name=p loop=$compound_percents}
      <option value="{$compound_percents[p].percent}">{$compound_percents[p].percent}%</option>
      {/section}
      </select>
  </td>
  {else}
  <td width=99%><input type=text name='IGS_CUSTOM_compound' value="{$compound_min_percents}" class=inpts size=5></td>
 </tr>
 <tr>
  <td nowrap colspan=2>
   (You can set any percent between <b>{$compound_min_percents}%</b> and <b>{$compound_max_percents}%</b>)
  </td>
  {/if} 
 </tr>

<!--tr><td colspan=2><small>Example: {$compounding}% of your earning will be accumulate on deposit.</small></td></tr-->
 </table>
 {/if}
 {else}
  <input type=hidden name=IGS_CUSTOM_compound value="0">
 {/if}
 <br>
  <input type=hidden name=IGS_CUSTOM_userid value="{$userinfo.id}">
  <input type=hidden name=IGS_CUSTOM_hyipid value={$h_id}>
  <input type=hidden name=IGS_CUSTOM_a value=checkpayment>
  <INPUT type=hidden name=IGS_AMOUNT value="{$amount}">
  <INPUT type=hidden name=IGS_PAYEE_ACCOUNT value="{$settings.def_payee_account_igolds}" >
  <INPUT type=hidden name=IGS_PAYER_ACCOUNT value="{$userinfo.igolds_account}">
  <INPUT type=hidden name=IGS_CURRENCY value="2"> 
  <INPUT type=hidden name=IGS_VERIFY_URL value="{$settings.site_url}/processing_igolds.php">
  <INPUT type=hidden name=IGS_SUCCESS_URL value="{$settings.site_url}/processing_status.php?process=yes">
  <INPUT type=hidden name=IGS_FAIL_URL  value="{$settings.site_url}/processing_status.php?process=no">
  <INPUT type=hidden value="Deposit to {$settings.site_name} User {$userinfo.username}" name=IGS_MEMO>
 <br>
  <input type=submit value="Process transaction" class=sbmt> &nbsp;
  <input type=button class=sbmt value="Cancel" onclick="document.location='?a=account'">
</form>
{/if}
{include file="footer.tpl"}