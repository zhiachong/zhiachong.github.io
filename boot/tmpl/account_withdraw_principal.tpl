{include file="header.tpl"}

<h3>Withdraw Principal:</h3><br><br>
{if $fatal} {if $fatal eq 'deposit_not_found'}Wrong deposit ID has been provided{/if} 
{if $fatal eq 'withdraw_forbidden'}Can not process principal withdrawal for this 
plan{/if} {if $fatal eq 'too_early_withdraw'}Can not process principal withdrawal 
yet{/if} {if $fatal eq 'too_late_withdraw'}Can not process principal withdrawal 
longer{/if} {if $fatal eq 'withdraw_complete'}Withdrawal has been sucessfully 
completed.{/if} {else} {if $say == 'too_big_amount'}You have no such amount on 
this deposit.<br>
<br>{/if}
{if $say == 'too_small_amount'}Provided amount is too small.<br><br>{/if}

{if $preview == 1}

<form method=post name=withdraw_form action="account_withdraw_principal.php">
<input type=hidden name=action value=withdraw>
<input type=hidden name=deposit value={$deposit.id}>
<input type=hidden name=amount value={$amount}>

<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td>Withdrawal from <b>{$currency_sign}{$deposit.deposit}</b> deposit from the <b>{$type.name|escape:html}</b></td>
</tr>
<tr>
      <td>You are withdrawing <b>{$currency_sign}{$amount}</b>. Our fee is <b>{$type.withdraw_principal_percent}%</b> 
        that is <b>{$currency_sign}{$fee}</b>.</td>
</tr>
<tr>
 <td>Actually you will acquire the total of <b>{$currency_sign}{$to_balance}</b> on your balance.</td>
</tr>
<tr>
 <td><br><input type=submit value="Confirm" class=sbmt></td>
</tr></table>
</form>

{else}

<script>
{literal}
function withdraw()
{
  var max_amount = new Number('{/literal}{$deposit.deposit}{literal}');
  var percent = new Number('{/literal}{$type.withdraw_principal_percent}{literal}');
  var out_val = new Number(document.withdraw_form.amount.value.replace(",","."));
  if (isNaN(out_val))
  { out_val = 0; }
  out_val = Math.floor(out_val * 100) / 100;

  if (out_val > max_amount)
  {
    out_val = max_amount;
    document.withdraw_form.amount.value = out_val;
  }

  if (out_val < 0)
  {
    document.withdraw_form.amount.value = '';
    document.withdraw_form.quote.value = 0;
  }
  else
  {
    var fee = (Math.round(Math.floor(out_val * percent)) / 100);
    if (fee <= 0.01) fee = 0.01;
    out_val = out_val - fee;
    if (out_val < 0) out_val = 0;
    out_val = (Math.round(Math.floor(out_val * 100)) / 100);
    document.withdraw_form.quote.value = out_val;
  }
}
{/literal}
</script>

<form method=post name=withdraw_form>
<input type=hidden name=a value=withdraw_principal>
<input type=hidden name=action value=withdraw_preview>
<input type=hidden name=deposit value={$deposit.id}>

<table cellspacing=0 cellpadding=2 border=0>
<tr>
 <td colspan=2>Withdrawal from <b>{$currency_sign}{$deposit.deposit}</b> deposit from the <b>{$type.name|escape:html}</b></td>
</tr>
<tr>
 <td colspan=2>Withdrawal fee is <b>{$type.withdraw_principal_percent}% or {$currency_sign}0.01 as minimal</b></b></td>
</tr>
<tr>
 <td width=1% nowrap>Withdrawal ({$currency_sign}):</td>
 <td><input type=text name=amount value="{$deposit.deposit}" class=inpts size=15 onchange="withdraw()" onkeyup="withdraw()"
      onfocusout="withdraw()" onactivate="withdraw()" ondeactivate="withdraw()"></td>
</tr>
<tr>
 <td width=1% nowrap>You will get on you account balance ({$currency_sign}):</td>
 <td><input type=text name=quote readonly class=inpts size=15></td>
</tr>
<tr>
 <td>&nbsp;</td>
 <td><input type=submit value="Withdraw" class=sbmt></td>
</tr></table>
</form>

<script>
withdraw();
</script>
{/if}
{/if}

{include file="footer.tpl"}
