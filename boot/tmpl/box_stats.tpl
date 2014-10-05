<table cellspacing=0 cellpadding=2 border=0 width="100%">
<tr>
 <th colspan=2 class="block_top"><span class="title">Fund Stats</span></th>
</tr>
<tr colspan=2>
 <td class="bg_block" align="center">
  <table width="100%">
  {if $settings.show_members_stats == 1}
   <tr>
    <td><a href="stats_members.php" class=menutxt>Investors Stats</a></td>
   </tr>   
  {/if}
  {if $settings.show_paidout_stats == 1}
  <tr>
    <td><a href="stats_paidout.php" class=menutxt>Paid Out</a></td>
  </tr>
  {/if}
  {if $settings.show_top10_stats == 1}
  <tr>
    <td><a href="stats_top_investors.php" class=menutxt>Investors Top 10</a></td>
  </tr>
  {/if}
  {if $settings.show_last10_stats == 1}
  <tr>
   <td><a href="stats_last_investors.php" class=menutxt>Investors Last 10</a></td>
  </tr>
  {/if}
  {if $settings.show_refs10_stats == 1}
  <tr>
   <td><a href="stats_top_refs.php" class=menutxt>Referrers Top 20</a></td>
  </tr>
  {/if}
  </table>
 </td>
</tr>
</table>