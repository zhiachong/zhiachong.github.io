{include file="header.tpl"}

{if $false_data != 1}
<h3>Please confirm your deposit:</h3>

<br><br>

<form method=post action="https://c-gold.com/clicktopay/">

Your C-gold account number <b>{$userinfo.cgold_account}</b><br>
Amount ($US): <b>{$amount_format}</b><br>

{if $use_compound}
 {if $compound_min_percents == $compound_max_percents && !$compound_percents}
  <input type=hidden name=compound value="{$compound_min_percents}">
 {else}
 <table cellspacing=0 cellpadding=2 border=0>
 <tr>
  <td nowrap width=1%>Compounding percent: </td>
  {if $compound_percents}
  <td><select name='compound' class=inpts>
      {section name=p loop=$compound_percents}
      <option value="{$compound_percents[p].percent}">{$compound_percents[p].percent}%</option>
      {/section}
      </select>
  </td>
  {else}
  <td width=99%><input type=text name='compound' value="{$compound_min_percents}" class=inpts size=5></td>
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
  <input type=hidden name=compound value="0">
 {/if}
 <br>
  <input type=hidden name="userid" value="{$userinfo.id}">
  <input type=hidden name="hyipid" value={$h_id}>
  <input type=hidden name="a" value=checkpayment>
  <INPUT type=hidden name="payment_amount" value="{$amount}">
  <INPUT type=hidden name="payee_account" value="{$settings.def_payee_account_cgold}">
  <INPUT type=hidden name="payee_name" value="{$settings.site_name}">
  <INPUT type=hidden name="forced_payer_account" value="{$userinfo.cgold_account}">
  <INPUT type=hidden name="payment_units" value="USD worth">
  <INPUT type=hidden name="payment_url" value="{$settings.site_url}/processing_status.php?process=yes">
  <INPUT type=hidden name="payment_url_method" value="post">
  <INPUT type=hidden name="nopayment_url" value="{$settings.site_url}/processing_status.php">
  <INPUT type=hidden name="nopayment_url_method" value="post">
  <INPUT type=hidden name="status_url" value="{$settings.site_url}/processing_cgold.php">
  <INPUT type=hidden name="suggested_memo" value="Deposit to {$settings.site_name} User {$userinfo.username}">
 <br>
  <input type=submit value="Process transaction" class=sbmt> &nbsp;
  <input type=button class=sbmt value="Cancel" onclick="document.location='account_main.php'">
</form>
{/if}
{include file="footer.tpl"}