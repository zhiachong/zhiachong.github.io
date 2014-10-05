{include file="header.tpl"}

{literal}
<script>
function go(p)
{
  document.opts.page.value = p;
  document.opts.submit();
}
</script>
{/literal}

 <div class="page_title">
        <div class="container">
            <div class="sixteen columns">
                ACCOUNT STATISTICS
            </div>
        </div>
 </div>

<div class="container ">
    <div class="sixteen columns m-bot-25">
            <h3 class="underlined"><span>Statistics</span></h3>
            <div class="clearfix"></div>
            <br/>
            <br/>
            <div class="w1">
                <section id="main-all">
                    <div id="content">
                              <h3>Transactions:</h3>

                              <link rel="stylesheet" href="form/formoid1/formoid-default-skyblue.css" type="text/css" />
<script type="text/javascript" src="form/formoid1/jquery.min.js"></script>

<form class="formoid-default-skyblue" style="margin-left:50px;background-color:#FFFFFF;font-size:16px;font-family:'Open Sans',Arial,Verdana,sans-serif;color:#666666;max-width:900px;min-width:150px" method="post" onsubmit="return checkform()" name=opts action="account_earnings.php">

  <div class="element-select"><label class="title">Transactions:</label><div class="large"><span><select name="type" onchange="document.opts.submit();">
                            <option value="">All</option>
                            {section name=opt loop=$options}
                            <option value="{$options[opt].type}" {if $options[opt].selected}selected{/if}>{$options[opt].type_name}</option>
                            {/section}
                               </select><i></i></span></div></div>
 
 <div class="element-select"><label class="title">E-Currencies:</label><div class="large"><span><select name="select" >
    <option value="">All E-Currencies</option><br/>
    <option value="2">SolidTrustPay</option><br/>
    <option value="4">EgoPay</option><br/>
    <option value="10">PerfectMoney</option><br/></select><i></i></span></div></div>

    <div class="element-select"><label class="title">From:</label><div class="large"><span><select name="month_from" >
                            {section name=month_from loop=$month}
                            <option value={$smarty.section.month_from.index+1} {if $smarty.section.month_from.index+1 == $frm.month_from}selected{/if}>{$month[month_from]}
                            {/section}
                            </select><i></i></span></div></div>
    <div class="element-select"><label class="title"></label><div class="large"><span><select name="day_from" >
                            {section name=day_from loop=$day}
                            <option value={$smarty.section.day_from.index+1} {if $smarty.section.day_from.index+1 == $frm.day_from}selected{/if}>{$day[day_from]}
                            {/section}
                            </select> 
                            <i></i></span></div></div>

    <div class="element-select"><label class="title"></label><div class="large"><span><select name="year_from" >
                            {section name=year_from loop=$year}
                            <option value={$year[year_from]} {if $year[year_from] == $frm.year_from}selected{/if}>{$year[year_from]}
                            {/section}
                            </select><i></i></span></div></div>

    <div class="element-select"><label class="title">To:</label><div class="large"><span><select name="month_to" >

    {section name=month_to loop=$month}
                            <option value={$smarty.section.month_to.index+1} {if $smarty.section.month_to.index+1 == $frm.month_to}selected{/if}>{$month[month_to]}
                            {/section}
                            </select> 
    <i></i></span></div></div>

    <div class="element-select"><label class="title"></label><div class="large"><span><select name="day_to" >

    {section name=day_to loop=$day}
                            <option value={$smarty.section.day_to.index+1} {if $smarty.section.day_to.index+1 == $frm.day_to}selected{/if}>{$day[day_to]}
                            {/section}
                            </select>
    <i></i></span></div></div>

    <div class="element-select"><label class="title"></label><div class="large"><span><select name="year_to" >

    {section name=year_to loop=$year}
                            <option value={$year[year_to]} {if $year[year_to] == $frm.year_to}selected{/if}>{$year[year_to]}
                            {/section}
                            </select>
    <i></i></span></div></div>
  <input type=hidden name=a value=earnings>
                            <input type=hidden name=page value={$current_page}>
<div class="submit"><input type="submit" value="Filter"/></div></form>

<script type="text/javascript" src="form/formoid1/formoid-default-skyblue.js"></script>
                            
    
                            {if $settings.use_history_balance_mode}
                            <table cellspacing=1 cellpadding=2 border=0 width=100%>
                            <tr>
                             <td class=inheader>Date</td>
                             <td class=inheader>Type</td>
                             <td class=inheader>Credit</td>
                             <td class=inheader>Debit</td>
                             <td class=inheader>Balance</td>
                             <td class=inheader>P.S.</td>
                            </tr>
                            {if $qtrans > 0}
                            {section name=trans loop=$trans}
                            <tr>
                             <td align=center nowrap>{$trans[trans].d}</td>
                             <td><b>{$trans[trans].transtype}</b><br><small class=gray>{$trans[trans].description}</small></td>
                             <td align=right><b>
                              {if $trans[trans].debitcredit == 0}
                              {$currency_sign}{$trans[trans].actual_amount}
                              </b>
                              {else}
                              &nbsp;
                              {/if}
                             </td>
                             <td align=right><b>
                              {if $trans[trans].debitcredit == 1}
                              {$currency_sign}{$trans[trans].actual_amount}
                              </b> 
                              {else}
                              &nbsp;
                              {/if}
                             </td>
                             <td align=right><b>
                              {$currency_sign}{$trans[trans].balance}
                             </td>
                             <td><img src="images/pay/{$trans[trans].ec}.gif" align=absmiddle hspace=1 height=21></td>
                            </tr>
                            {/section}
                            {else}
                            <tr>
                             <td colspan=6 align=center>No transactions found</td>
                            </tr>
                            {/if}
                            <tr><td colspan=3>&nbsp;</td>

                            {if $qtrans > 0}
                            <tr>
                             <td colspan=2>Total for this period:</td>
                             <td align=right nowrap><b>{$currency_sign}{$periodcredit}</b></td>
                             <td align=right nowrap><b>{$currency_sign}{$perioddebit}</b></td>
                             <td align=right nowrap><b>{$currency_sign}{$periodbalance}</b></td>
                            </tr>
                            {/if}
                            <tr>
                             <td colspan=2>Total:</td>
                             <td align=right nowrap><b>{$currency_sign}{$allcredit}</b></td>
                             <td align=right nowrap><b>{$currency_sign}{$alldebit}</b></td>
                             <td align=right nowrap><b>{$currency_sign}{$allbalance}</b></td>
                            </tr>
                            </table>
                            {else}
                            <table cellspacing=1 cellpadding=2 border=0 width=100%>
                            <tr>
                             <td class=inheader><b>Type</b></td>
                             <td class=inheader width=200><b>Amount</b></td>
                             <td class=inheader width=170><b>Date</b></td>
                            </tr>
                            {if $qtrans > 0}
                            {section name=trans loop=$trans}
                            <tr>
                             <td><b>{$trans[trans].transtype}</b></td>
                             <td width=200 align=right><b>{$currency_sign} {$trans[trans].actual_amount}</b> <img src="images/pay/{$trans[trans].ec}.gif" align=absmiddle hspace=1 height=21></td>
                             <td width=170 align=center valign=bottom><b><small>{$trans[trans].d}</small></b></td>
                            </tr>
                            <tr>
                             <td colspan=3 class=gray><small>{$trans[trans].description}</small></td>
                            </tr>
                            {/section}
                            {else}
                            <tr>
                             <td colspan=3 align=center>No transactions found</td>
                            </tr>
                            {/if}
                            <tr><td colspan=3>&nbsp;</td>

                            {if $qtrans > 0}
                            <tr>
                                <td colspan=2>For this period:</td>
                             <td align=right><b>{$currency_sign} {$periodsum}</b></td>
                            </tr>
                            {/if}
                            <tr>
                                <td colspan=2>Total:</td>
                             <td align=right><b>{$currency_sign} {$allsum}</b></td>
                            </tr>
                            </table>
                            {/if}

                            {if $colpages > 1}
                            <center>
                            {if $prev_page > 0}
                             <button onclick="javascript:go('{$prev_page}')" class="button sign-up-button">Prev</button>
                            {/if}
                            {section name=p loop=$pages}
                            {if $pages[p].current == 1}
                            {$pages[p].page}
                            {else}
                             <button onclick="javascript:go('{$pages[p].page}')" class="button sign-up-button">{$pages[p].page}</button>
                            {/if}
                            {/section}
                            {if $next_page > 0}
                             <button class="button sign-up-button" onclick="javascript:go('{$next_page}')">Next</button>
                            {/if}
                            </center>
                            {/if}
                    </div>
               <aside id="sidebar">
                   <ul class="side-nav">
                        <li>
                            <a href="account_main.php">
                                <legend class="acc">ACCOUNT</legend>
                            </a>
                        </li>
                        <li>
                            <a href="account_deposit.php">
                                <legend class="acc">MAKE DEPOSIT</legend>
                            </a>
                        </li>
                        <li>
                            <a href="account_withdraw.php">
                                <legend class="acc">WITHDRAW</legend>
                            </a>
                        </li>
                        <li>
                            <a href="account_earnings.php">
                                <legend class="acc">STATISTICS</legend>
                            </a>
                        </li>
                        <li>
                            <a href="account_referrals.php">
                                <legend class="acc">AFFILIATES</legend>
                            </a>
                        </li>
                        <li>
                            <a href="account_referral_links.php">
                                <legend class="acc">PROMO MATERIALS</legend>
                            </a>
                        </li>
                        <li>
                            <a href="account_edit.php">
                                <legend class="acc">EDIT PROFILE</legend>
                            </a>
                        </li>
                        <li>
                            <a href="page_logout.php">
                                <legend class="acc">LOGOUT</legend>
                            </a>
                        </li>
                    </ul>
                </aside>
            </section>
        </div>
    </div>
</div>
</div>

{include file="footer.tpl"}
