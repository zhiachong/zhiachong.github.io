{include file="header.tpl"}

{if $false_data != 1}
<h3>Please confirm your deposit:</h3><br><br>

<form name="spend" method="post" action="https://atip.e-bullion.com/process.php">
Your e-bullion account number <b>{$account}</b><br>
Amount ($US): <b>{$amount_format}</b><br>
{if $use_compound}
{if $compound_min_percents == $compound_max_percents && !$compound_percents}
<input type=hidden name=compound value="{$compound_min_percents}">
{else}
<table cellspacing=0 cellpadding=2 border=0>
<tr><td nowrap width=1%>Compounding percent: </td>
  {if $compound_percents}
<td><select name='compound' class=inpts>
{section name=p loop=$compound_percents}<option value="{$compound_percents[p].percent}">{$compound_percents[p].percent}%</option>{/section}
</select></td>
  {else}
<td width=99%><input type=text name='compound' value="{$compound_min_percents}" class=inpts size=5></td></tr>
<tr><td nowrap colspan=2>(You can set any percent between <b>{$compound_min_percents}%</b> and <b>{$compound_max_percents}%</b>)</td>
  {/if}
</tr>
<!--tr><td colspan=2><small>Example: {$compounding}% of your earning will be accumulate on deposit.</small></td></tr-->
</table>
{/if}
{else}
<input type=hidden name=compound value="0">
{/if}

<br>

<input type=hidden name=userid value="{$userinfo.id}">
<input type=hidden name=hyipid value={$h_id}>
<input type=hidden name=a value=checkpayment>
<input type="hidden" name="ATIP_STATUS_URL" value="{$settings.site_url}/processing_ebullion.php">
<input type="hidden" name="ATIP_STATUS_URL_METHOD" value="POST">
<input type="hidden" name="ATIP_BAGGAGE_FIELDS" value="userid hyipid a compound">
<input type="hidden" name="ATIP_SUGGESTED_MEMO" value="Deposit to {$settings.site_name} User {$userinfo.username}">
<input type="hidden" name="ATIP_FORCED_PAYER_ACCOUNT" value="{$account}">
<input type="hidden" name="ATIP_PAYER_FEE_AMOUNT" value="0.00">
<input type="hidden" name="ATIP_PAYMENT_URL" value="{$settings.site_url}/processing_status.php?process=yes">
<input type="hidden" name="ATIP_PAYMENT_URL_METHOD" value="POST">
<input type="hidden" name="ATIP_NOPAYMENT_URL" value="{$settings.site_url}/processing_status.php">
<input type="hidden" name="ATIP_NOPAYMENT_URL_METHOD" value="POST">
<input type="hidden" name="ATIP_PAYMENT_FIXED" value="0">
<input type="hidden" name="ATIP_PAYMENT_AMOUNT" value="{$amount}">
<input type="hidden" name="ATIP_PAYMENT_UNIT" value="1">
<input type="hidden" name="ATIP_PAYMENT_METAL" value="3">
<input type="hidden" name="ATIP_PAYEE_ACCOUNT" value="{$settings.def_payee_account_ebullion}">
<input type="hidden" name="ATIP_PAYEE_NAME" value="{$settings.def_payee_name_ebullion}">
<br><input type=submit value="Process" class=sbmt> &nbsp;
<input type=button class=sbmt value="Cancel" onclick="document.location='account_main.php'">
</form>
{/if}
{include file="footer.tpl"}
