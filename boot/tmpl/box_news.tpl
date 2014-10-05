<table cellspacing=0 cellpadding=2 border=0 width="100%">
<tr>
 <th colspan=2 class="block_top"><span class="title">Latest News</span></th>
</tr>
<tr colspan=2>
 <td class="bg_block" align="center">
  <table width="100%">
  {section name=s loop=$news}
  <tr>
   <td>
      <p align=justify><b>{$news[s].title}</b><br>
      {$news[s].small_text} <a href="page_news.php#{$news[s].id}">more</a><br>
      <small><i>{$news[s].d}</i></small></p>
   </td>
  </tr>
  {/section}
  <tr>
   <td><a href="page_news.php">All news</a></td>
  </tr>
  </table>
 </td>
</tr>
</table>