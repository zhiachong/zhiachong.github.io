{include file="header.tpl"}

{if $ok == 1}
<h3>Please confirm your deposit:</h3><br><br>

{$description}<br><br>

Amount ($): <b>{$amount}</b> of {$cname}<br>
<form name=spend method=post>
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

<input type=hidden name=a value=deposit>
<input type=hidden name=action value=confirm>
<input type=hidden name=type value={$type}>
<input type=hidden name=h_id value={$h_id}>
<INPUT type=hidden name=amount value="{$famount}">
{if $fields}
<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td colspan=2><b>Required Information:</b></td>
</tr>
{section name=f loop=$fields}
<tr>
 <td>{$fields[f].name}</td>
 <td><input type="text" name="fields[{$fields[f].id}]" value="" class=inpts></td>
</tr>
{/section}
</table>
{/if}

<br><input type=submit value="Save" class=sbmt> &nbsp;
<input type=button class=sbmt value="Cancel" onclick="document.location='"account_deposit.php'">
</form>

{else}

{if $max_deposit_less == 1}
Sorry, the maximal deposit is {$max_deposit_format}.<br>
{/if} 
{if $wrong_paln == 1} The Plan does not exist. {/if} 
{if $not_enough_funds == 1} You have not enough funds to complete the operation.<br>{/if}
{if $less_than_min == 1}
The minimal spend amount for '{$plan_name}' is ${$min_amount}.<br>
{/if}
{if $zero_amount}
You should enter amount grater than zero.<br>
{/if}

<br>
Click <a href="account_deposit.php">here</a> and try again.
{/if}


{include file="footer.tpl"}
