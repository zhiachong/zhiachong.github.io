{include file="header.tpl"}


<h3>News</h3><br>

<table cellspacing=1 cellpadding=2 border=0 width=100%>
{if $news}
{section name=s loop=$news}
<tr>
 <td align=justify><a name="{$news[s].id}"></a><b>{$news[s].title}</b><br>
  {$news[s].full_text}<br>
  <small><i>{$news[s].d}</i></small>
 </td>
</tr>
{/section}
{else}
<tr>
 <td colspan=3 align=center>No news found</td>
</tr>
{/if}
</table>

{if $colpages > 1}
<center>
{if $prev_page > 0}
 <a href="page_news.php?page={$prev_page}">&lt;&lt;</a>
{/if}
{section name=p loop=$pages}
{if $pages[p].current == 1}
{$pages[p].page}
{else}
 <a href="page_news.php?page={$pages[p].page}">{$pages[p].page}</a>
{/if}
{/section}
{if $next_page > 0}
 <a href="page_news.php?page={$next_page}">&gt;&gt;</a>
{/if}
</center>
{/if}


{include file="footer.tpl"}
