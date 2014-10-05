{include file="header.tpl"}

{if $ok == 1}
<h3>Please confirm your deposit:</h3><br><br>

{$wire_txt}<br><br>

Amount ($US): <b>{$amount}</b><br>
<form name=spend method=post action="account_deposit.php">
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
{/if}
<br>

<input type=hidden name=action value=confirm>
<input type=hidden name=type value=wire>
<!--input type=hidden name=compound value="{$compounding}"-->
<input type=hidden name=h_id value={$h_id}>
<INPUT type=hidden name=amount value="{$famount}">
<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td colspan=2><b>Personal information:</b></td>
</tr><tr>
 <td>Name:</td>
 <td><input type=text name=pname value="{$userinfo.name}" class=inpts></td>
</tr><tr>
 <td>Address:</td>
 <td><input type=text name=paddress value="" class=inpts></td>
</tr><tr>
 <td>ZIP:</td>
 <td><input type=text name=pzip value="" class=inpts></td>
</tr><tr>
 <td>City:</td>
 <td><input type=text name=pcity value="" class=inpts></td>
</tr><tr>
 <td>State:</td>
 <td><input type=text name=pstate value="" class=inpts></td>
</tr><tr>
 <td>Country:</td>
 <td><input type=text name=pcountry value="" class=inpts></td>
</tr><tr>
 <td colspan=2><br><b>Bank information</b></td>
</tr><tr>
 <td>Bank name:</td>
 <td><input type=text name=bname value="" class=inpts></td>
</tr><tr>
 <td>Bank address:</td>
 <td><input type=text name=baddress value="" class=inpts></td>
</tr><tr>
 <td>Bank zip:</td>
 <td><input type=text name=bzip value="" class=inpts></td>
</tr><tr>
 <td>Bank city:</td>
 <td><input type=text name=bcity value="" class=inpts></td>
</tr><tr>
 <td>Bank state:</td>
 <td><input type=text name=bstate value="" class=inpts></td>
</tr><tr>
 <td>Bank country:</td>
 <td><input type=text name=bcountry value="" class=inpts></td>
</tr><tr>
 <td>Bank account number:</td>
 <td><input type=text name=baccount value="" class=inpts></td>
</tr><tr>
 <td>IBAN account:</td>
 <td><input type=text name=biban value="" class=inpts></td>
</tr><tr>
 <td>SWIFT or BIC account:</td>
 <td><input type=text name=bswift value="" class=inpts></td>
</tr>
</table>


<br><input type=submit value="Save" class=sbmt> &nbsp;
<input type=button class=sbmt value="Cancel" onclick="document.location='account_deposit.php'">
</form>

{else}

{if $max_deposit_less == 1}
Sorry, max deposit is {$max_deposit_format}.<br>
{/if} {if $wrong_paln == 1} The Plan does not exist. {/if} {if $not_enough_funds 
== 1} You have not enough funds to complete the&nbsp; operation.<br>
{/if}
{if $less_than_min == 1}
Min spend amount for '{$plan_name}' is US${$min_amount}.<br>
{/if}
<br>
Click <a href="account_deposit.php">here</a> and try again.

{/if}


{include file="footer.tpl"}
