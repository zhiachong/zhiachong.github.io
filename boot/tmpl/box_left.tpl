{if $frm.a ne 'login'}<br>{include file="box_login.tpl"}{/if}
{if $settings.show_stats_box}<br>{include file="box_stats.tpl"}{/if}
{if $settings.show_info_box}<br>{include file="box_info.tpl"}{/if}
{if $settings.show_news_box}<br>{include file="box_news.tpl"}{/if}

{if $settings.show_kitco_dollar_per_ounce_box == 1}
<br>
<table cellspacing=0 cellpadding=2 border=0 width="100%">
<tr>
 <th colspan=2 class="block_top"><span class="title">Dollar price per ounce</span></th>
</tr>
<tr colspan=2>
 <td class="bg_block" align="center">
  <table width="100%">
   <tr>
    <td align=center><img src="http://www.kitco.com/images/live/t24_au_en_usoz_6.gif" width=172 height=124></td>
   </tr>
  </table>
 </td>
</tr>
</table> 

{/if}
