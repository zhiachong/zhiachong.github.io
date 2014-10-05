{include file="header.tpl"}

<h3>Change Compounding Percent:</h3><br><br>

{if $fatal}
 {if $fatal eq 'deposit_not_found'}Wrong deposit ID has been provided{/if}
 {if $fatal eq 'compound_forbidden'}There is no compounding for this plan{/if}

 {if $fatal eq 'update_completed'}Your compounding percent has been successfully changed.{/if}

{else}

<script>
{literal}
function openCalculator(id)
{
  w = 225; h = 400;
  t = (screen.height-h-30)/2;
  l = (screen.width-w-30)/2;
  window.open('calendar.php?type=' + id, 'calculator' + id, "top="+t+",left="+l+",width="+w+",height="+h+",resizable=1,scrollbars=0");
}

function c_c()
{
  var out_val = new Number(document.change_compound.percent.value.replace(",","."));
  if (isNaN(out_val))
  { out_val = 0; }
  out_val = Math.floor(out_val * 100) / 100;

  if (out_val < 0)
  {
    document.change_compound.percent.value = 0;
  }
  if (out_val > 100)
  {
    document.change_compound.percent.value = 100;
  }
}
{/literal}
</script>

<form method=post name=change_compound action="account_change_compound.php">
<input type=hidden name=action value=change>
<input type=hidden name=deposit value={$deposit.id}>

<table cellspacing=0 cellpadding=2 border=0>
<tr>
      <td colspan=2>Change the compounding percent for <b>{$currency_sign}{$deposit.deposit}</b> 
        deposit in the <b>{$type.name|escape:html}</b></td>
</tr>
<tr><td nowrap width=1%>Compounding percent: </td>
  {if $compound_percents}
<td><select name='percent' class=inpts>
{section name=p loop=$compound_percents}<option value="{$compound_percents[p].percent}" {if $deposit.compound == $compound_percents[p].percent}selected{/if}>{$compound_percents[p].percent}%</option>{/section}
</select></td>
  {else}
<td width=99%><input type=text name='percent' value="{$deposit.compound}" class=inpts size=5 onchange="c_c()" onkeyup="c_c()" onfocusout="c_c()" onactivate="c_c()" ondeactivate="c_c()"></td></tr>
<tr>
      <td nowrap colspan=2>(You can set any compounding percent between <b>{$compound_min_percents}%</b> 
        and <b>{$compound_max_percents}%</b>)</td>
  {/if}
</tr>
{if $settings.enable_calculator}
<tr>
 <td colspan=2><a href="javascript:openCalculator({$type.id})">Calculate your profit &gt;&gt;</a></td>
</tr>
{/if}
<tr>
 <td>&nbsp;</td>
 <td><input type=submit value="Change" class=sbmt></td>
</tr></table>
</form>

<script>
withdraw();
</script>
{/if}

{include file="footer.tpl"}
