{include file="header.tpl"}

{if $false_data != 1}
<h3>Please confirm your deposit:</h3>

<br><br>

<form action="https://sci.libertyreserve.com" method="post">

Your Liberty Reserve account: <b>{$userinfo.libertyreserve_account}</b><br>
Amount ($US): <b>{$amount_format}</b><br>

{if $use_compound}
 {if $compound_min_percents == $compound_max_percents && !$compound_percents}
  <input type=hidden name="compound" value="{$compound_min_percents}">
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
 <input type="hidden" name="compound" value="0" />
 {/if}
 <br>
  <input type=hidden name=userid value="{$userinfo.id}">
  <input type=hidden name=hyipid value={$h_id}>
  <input type=hidden name=a value=checkpayment>

  <input type="hidden" name="lr_acc" value="{$settings.def_payee_account_libertyreserve}">
  <input type="hidden" name="lr_store" value="{$settings.md5altphrase_libertyreserve_store}">
  <input type="hidden" name="lr_amnt" value="{$amount}">
  <input type="hidden" name="lr_currency" value="LRUSD">
  <input type="hidden" name="lr_comments" value="Deposit to {$settings.site_name} User {$userinfo.username}">
  <input type=hidden name=lr_success_url value="{$settings.site_url}/index.php">
  <input type=hidden name=lr_fail_url value="{$settings.site_url}/processing_status.php">
  <input type=hidden name=lr_status_url value="{$settings.site_url}/processing_libertyreserve.php">
  
<br><input type=submit name=i_submit value="Process" class=sbmt> &nbsp;
<input type=button class=sbmt value="Cancel" onclick="document.location='?a=account'">
</form>

{/if}
{include file="footer.tpl"}