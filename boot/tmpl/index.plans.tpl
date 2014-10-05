{literal}
<script language="javascript">
 function openCalculator(id)
 {
   w = 225; 
   h = 400;
   t = (screen.height-h-30)/2;
   l = (screen.width-w-30)/2;
   window.open('calendar.php?type=' + id, 'calculator' +id, "top="+t+",left="+l+",width="+w+",height="+h+",resizable=1,scrollbars=0");
 }
</script>
{/literal}

{section name=plans loop=$index_plans}
{if !$index_plans[plans].closed}
<table cellspacing=1 cellpadding=2 border=0 width=100%>
<tr>
 <td colspan=3 align=center>
  {if $index_plans[plans].dsc != ''}<a href="page_package_info.php?id={$index_plans[plans].id}">{/if}
  <b>{$index_plans[plans].name|escape:html}</b></a>
 </td>
</tr>
<tr>
 <td class=inheader>Plan</td>
 <td class=inheader width=200>Spent Amount ({$currency_sign})</td>
 <td class=inheader width=100 nowrap><nobr>{$index_plans[plans].period} Profit (%)</nobr></td>
</tr>

{section name=plan_options loop=$index_plans[plans].plans}
<tr>
 <td class=item>{$index_plans[plans].plans[plan_options].name|escape:html}</td>
 <td class=item align=right>{$index_plans[plans].plans[plan_options].deposit}</td>
 <td class=item align=right>{$index_plans[plans].plans[plan_options].percent}</td>
</tr>
{/section}
{if $settings.enable_calculator}
<tr>
 <td colspan=3 align=right>
  <a href="javascript:openCalculator('{$index_plans[plans].id}')">Calculate your profit &gt;&gt;</a>
 </td>
</tr>
{/if}
</table>

{if $userinfo.logged}
<br>
 <form method=post action="account_deposit.php">
 <input type=submit value="Make deposit" class=sbmt>
 <input type=hidden name=h_id value={$index_plans[plans].id}>
</form>
<br><br>
{/if}
{/if}
{/section}