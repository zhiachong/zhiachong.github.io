<table cellspacing=0 cellpadding=2 border=0 width="100%">
<tr>
 <th colspan=2 class="block_top"><span class="title">Fund Infos</span></th>
</tr>
<tr colspan=2>
 <td class="bg_block" align="center">
  <table width="100%">
   {if $settings.show_info_box_started == 1}
   <tr>
    <td class=menutxt>
     <b>Started</b>&nbsp;
      {$settings.site_start_month_str_generated} {$settings.site_start_day}, {$settings.site_start_year}
    </td>
   </tr>
   {/if}
   {if $settings.show_info_box_running_days == 1}
   <tr> 
    <td class=menutxt><b>Running days</b></td>
    <td class=menutxt align=right>{$settings.site_days_online_generated}</td>
   </tr>
   {/if}
   {if $settings.show_info_box_total_accounts}
   <tr>
    <td class=menutxt><b>Total accounts</b></td>
    <td class=menutxt align=right>{$settings.info_box_total_accounts_generated}</td>
   </tr>
   {/if}
   {if $settings.show_info_box_active_accounts}
   <tr>
    <td class=menutxt><b>Active accounts</b></td>
    <td class=menutxt align=right>{$settings.info_box_total_active_accounts_generated}</td>
   </tr>
   {/if}
   {if $settings.show_info_box_vip_accounts}
   <tr>
    <td class=menutxt><b>VIP accounts</b></td>
    <td class=menutxt align=right>{$settings.info_box_total_vip_accounts_generated}</td>
   </tr>
   {/if}
   {if $settings.show_info_box_deposit_funds == 1}
   <tr>
    <td class=menutxt><b>Total deposited</b></td>
    <td class=menutxt align=right>{$currency_sign}{$settings.info_box_deposit_funds_generated}</td>
   </tr>
   {/if}
   {if $settings.show_info_box_today_deposit_funds == 1}
   <tr>
    <td class=menutxt><b>Today deposited</b></td>
    <td class=menutxt align=right>{$currency_sign}{$settings.info_box_today_deposit_funds_generated}</td>
   </tr>
   {/if}
   {if $settings.show_info_box_today_withdraw_funds == 1}
   <tr>
    <td class=menutxt><b>Today withdrawal</b></td>
    <td class=menutxt align=right>{$currency_sign} {$settings.info_box_today_withdraw_funds_generated}</td>
   </tr>
   {/if}
   {if $settings.show_info_box_total_withdraw == 1}
   <tr>
    <td class=menutxt><b>Total withdraw</b></td>
    <td class=menutxt align=right>{$currency_sign} {$settings.info_box_withdraw_funds_generated}</td>
   </tr>
   {/if}
   {if $settings.show_info_box_visitor_online == 1}
   <tr>
    <td class=menutxt><b>Visitors online</b></td>
    <td class=menutxt align=right>{$settings.info_box_visitor_online_generated}</td>
   </tr>
   {/if}
   {if $settings.show_info_box_members_online == 1}
   <tr>
    <td class=menutxt><b>Members online</b></td>
    <td class=menutxt align=right>{$settings.show_info_box_members_online_generated}</td>
   </tr>
   {/if}
   {if $settings.show_info_box_newest_member == 1}
   <tr>
    <td class=menutxt colspan="2"><b>Newest User</b>
      {if $settings.show_info_box_newest_member_generated}
       {$settings.show_info_box_newest_member_generated}
      {else}
       N/A
      {/if}
    </td>
   </tr>
   {/if}
   {if $settings.show_info_box_last_update == 1}
   <tr>
    <td class=menutxt colspan=2><b>Last update</b> &nbsp;{$settings.show_info_box_last_update_generated}</td>
   </tr>
   {/if}
  </table>
 </td>
</tr>
</table>
