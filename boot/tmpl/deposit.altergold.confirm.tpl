{include file="header.tpl"}

{if $false_data != 1}
<h3>Please confirm your deposit:</h3>

<br><br>

<form name='payment' method='POST' action=' http://www.altergold.com/sci.php'>

Your Altergold account number <b>{$userinfo.altergold_account}</b><br>
Amount ($US): <b>{$amount_format}</b><br>


{if $use_compound}
{if $compound_min_percents == $compound_max_percents && !$compound_percents}
<input type=hidden name=COMPOUND value="{$compound_min_percents}">
{else}
<table cellspacing=0 cellpadding=2 border=0>
<tr><td nowrap width=1%>Compounding percent: </td>
  {if $compound_percents}
<td><select name='COMPOUND' class=inpts>
{section name=p loop=$compound_percents}<option value="{$compound_percents[p].percent}">{$compound_percents[p].percent}%</option>{/section}
</select></td>
  {else}
<td width=99%><input type=text name='COMPOUND' value="{$compound_min_percents}" class=inpts size=5></td></tr>
<tr><td nowrap colspan=2>(You can set any percent between <b>{$compound_min_percents}%</b> and <b>{$compound_max_percents}%</b>)</td>
  {/if}
</tr>
<!--tr><td colspan=2><small>Example: {$compounding}% of your earning will be accumulate on deposit.</small></td></tr-->
</table>
{/if}
{else}
<input type=hidden name='COMPOUND' value="0">
{/if}

<input type='hidden' name='USERID' value='{$userinfo.id}'>
<input type='hidden' name='HYIPID' value='{$h_id}'>
<input type='hidden' name='A' value='checkpayment'>


<input type='hidden' name='PAYEE_ACCOUNT' value='{$settings.def_payee_account_altergold}'>
<input type='hidden' name='PAYMENT_AMOUNT' value='{$amount}'>
<input type='hidden' name='PAYMENT_CURRENCY' value='USD'>
<input type='hidden' name='MEMO' value='Spend from {$userinfo.username}'>
<input type='hidden' name='BAGGAGE_FIELDS' value='USERID,HYIPID,A,{if $use_compound}COMPOUND{/if}'>

<input type='hidden' name='STATUS_URL' value='{$settings.site_url}/processing_altergold.php'>
<input type='hidden' name='PAYMENT_URL' value='{$settings.site_url}/processing_status.php?process=yes'>
<input type='hidden' name='NO_PAYMENT_URL' value='{$settings.site_url}/processing_status.php'>


<br><input type=submit value="Process" class=sbmt> &nbsp;
<input type=button class=sbmt value="Cancel" onclick="document.location='account_main.php'">
</form>
{/if}
{include file="footer.tpl"}