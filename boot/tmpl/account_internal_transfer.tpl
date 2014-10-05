{include file="header.tpl"}

<h3>Internal Transfer:</h3><br><br>

{if $fatal}

{if $fatal == 'completed'}Internal transfer has been successfully completed.<br><br><a href="?a=internal_transfer">Return to the Internal Transfer form.</a>{/if}

{if $fatal == 'forbidden'}Internal transfers are forbidden.{/if}
{if $fatal == 'invalid_transaction_code'}Invalid Transaction Code.<br><br><a href="javascript:history.go(-1)">&lt;&lt; Back</a>{/if}
{if $fatal == 'one_per_month'}You can send internal transfer once a month only.<br><br>{/if}
{if $fatal == 'no_deposits'}You can not send funds before you make any deposit.<br><br>{/if}

{else}

{if $say == 'too_small_amount'}You can transfer the amount more that {$currency_sign}{if $settings.internal_transfer_min}{$settings.internal_transfer_min}{else}0.00{/if} only.<br><br>{/if}
{if $say == 'too_big_amount'}You have no such amount on your balance.<br><br>{/if}
{if $say == 'user_not_found'}The recipient's username entered has not been found or has been suspended.<br><br>{/if}
{if $say == 'on_hold'}Sorry, this amount on hold now.<br><br>{/if}
{if $say == 'too_big_amount_plus_fee'}You have no enough funds to complte the transaction. Total amount you should have to send ${$amount} + fee ${$fee} is <b>${$to_send}</b>.<br><br>{/if}
{if $say == 'max_amount_exeed'}Maximum amount you can send is {$currency_sign}{$settings.internal_transfer_max}.<br><br>{/if}

{if $preview}

<form method=post action="account_internal_transfer.php">
<input type=hidden name=action value=make_transaction>
<input type=hidden name=amount value={$amount}>
<input type=hidden name=account value={$user.username}>
<input type=hidden name=ec value={$ec}>
<input type=hidden name=comment value="{$comment}">

<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td colspan=2>Send <b>{$currency_sign}{$amount} of {$ec_name}</b> to account <b>{$user.username}</b></td>
{if $settings.internal_transfer_fee_payer == 0 && ($settings.internal_transfer_fee || $settings.minimum_internal_transfer_fee)}
</tr><tr>
 <td colspan=2>Our fee for this transaction is <b>{$settings.internal_transfer_fee}%</b> or at least <b>${$settings.minimum_internal_transfer_fee}</b><br>
 {if $settings.internal_transfer_fee_payer == 0}Actually you will spend <b>${$to_send}</b>{/if}
 {if $settings.internal_transfer_fee_payer == 1}Actually user will receive <b>${$to_receive}</b>{/if}
{/if}
{if $comment}
</tr><tr>
 <td colspan=2>With comments: {$comment|escape:html}
{/if}
</tr>
{if $settings.use_transaction_code && $userinfo.transaction_code}
<tr>
 <td>Transaction Code:</td>
 <td><input type="password" name="transaction_code" class=inpts size=15></td>
</tr>
{/if}
<tr>
 <td colspan=2><br><input type=submit value="Confirm" class=sbmt></td>
</tr></table>
</form>

{else}

<form method=post>
<input type=hidden name=a value=internal_transfer>
<input type=hidden name=action value=preview_transaction>

<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td>Account Balance:</td>
 <td>{$currency_sign}<b>{$ab_formated.total}</b></td>
</tr>
<tr><td>&nbsp;</td>
 <td> <small>
{section name=p loop=$ps}
   {if $ps[p].balance > 0}{$currency_sign}{$ps[p].balance} of {$ps[p].name}{if $hold[p].amount > 0} / {$currency_sign}{$hold[p].amount} on hold{/if}<br>{/if}
{/section}
 </td>
</tr>
<tr>
 <td colspan=2>&nbsp;</td>
</tr>
<tr>
 <td>Select e-currency:</td>
 <td><select name=ec class=inpts>
{section name=p loop=$ps}
   {if $ps[p].balance > 0}<option value={$ps[p].id}>{$ps[p].name}</option>{/if}
{/section}
     </select>
 </td>
</tr><tr>
 <td>Transfer ({$currency_sign}):</td>
 <td><input type=text name=amount value="{if $frm.amount}{$frm.amount|escape:htmlall}{else}10.00{/if}" class=inpts size=15></td>
</tr><tr>
 <td>To Account:</td>
 <td><input type=text name=account value="{$frm.account|escape:htmlall}" class=inpts size=15></td>
</tr><tr>
 <td colspan=2><textarea name=comment class=inpts cols=45 rows=4>{if $frm.comment}{$frm.comment|escape:htmlall}{else}Your comment{/if}</textarea>
</tr><tr>
 <td>&nbsp;</td>
 <td><input type=submit value="Send" class=sbmt></td>
</tr></table>
</form>

{/if}

{/if}


{include file="footer.tpl"}
