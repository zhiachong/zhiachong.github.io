{include file="header.tpl"}

 <div class="page_title">
        <div class="container">
            <div class="sixteen columns">
                REFERRAL STATISTICS
            </div>
        </div>
 </div>

<div class="container ">
    <div class="sixteen columns m-bot-25">
            <h3 class="underlined"><span>Referrals</span></h3>
            <div class="clearfix"></div>
            <br/>
            <br/>
            <div class="w1">
                <section id="main-all">
                    <div id="content">
                              <h3>Your Referrals</h3>

{if $upline.email != ""}
<center><p>Your upline is <a href=mailto:{$upline.email}>{$upline.name}</a></p></center>
{/if}
<br>
<table width=300 cellspacing=1 cellpadding=1>
<tr>
  <td class=item>Referrals:</td>
  <td class=item>{$total_ref}</td>
</tr><tr>
  <td class=item>Active referrals:</td>
  <td class=item>{$active_ref}</td>
</tr><tr>
  <td class=item>Total referral commission:</td>
  <td class=item>{$currency_sign}{$commissions}</td>
</tr>
</table>
<br>
{if $settings.show_refstat}


                              <link rel="stylesheet" href="form/formoid1/formoid-default-skyblue.css" type="text/css" />
<script type="text/javascript" src="form/formoid1/jquery.min.js"></script>

<form class="formoid-default-skyblue" style="margin-left:50px;background-color:#FFFFFF;font-size:16px;font-family:'Open Sans',Arial,Verdana,sans-serif;color:#666666;max-width:900px;min-width:150px" method="post" onsubmit="return checkform()" name=opts action="account_referrals.php"><div class="title"><h2>Referral Statistics:</h2></div>
     <div class="element-select"><label class="title"></label><div class="large"><span>

    <div class="element-select"><label class="title">From:</label><div class="large"><span><select name="month_from" >
                            {section name=month_from loop=$month}
                            <option value={$smarty.section.month_from.index+1} {if $smarty.section.month_from.index+1 == $frm.month_from}selected{/if}>{$month[month_from]}</option>
                            {/section}
                            </select> 
                            <i></i></span></div></div>
    <div class="element-select"><label class="title"></label><div class="large"><span><select name="day_from" >
                            {section name=day_from loop=$day}
                            <option value={$smarty.section.day_from.index+1} {if $smarty.section.day_from.index+1 == $frm.day_from}selected{/if}>{$day[day_from]}</option>
                            {/section}
                            </select> 
                            <i></i></span></div></div>

    <div class="element-select"><label class="title"></label><div class="large"><span><select name="year_from" >
                            {section name=year_from loop=$year}
                            <option value={$year[year_from]} {if $year[year_from] == $frm.year_from}selected{/if}>{$year[year_from]}</option>
                            {/section}
                            </select><i></i></span></div></div>

    <div class="element-select"><label class="title">To:</label><div class="large"><span><select name="month_to" >

    {section name=month_to loop=$month}
                            <option value={$smarty.section.month_to.index+1} {if $smarty.section.month_to.index+1 == $frm.month_to}selected{/if}>{$month[month_to]}</option>
                            {/section}
                            </select> 
    <i></i></span></div></div>

    <div class="element-select"><label class="title"></label><div class="large"><span><select name="day_to" >

    {section name=day_to loop=$day}
                            <option value={$smarty.section.day_to.index+1} {if $smarty.section.day_to.index+1 == $frm.day_to}selected{/if}>{$day[day_to]}</option>
                            {/section}
                            </select>
    <i></i></span></div></div>

    <div class="element-select"><label class="title"></label><div class="large"><span><select name="year_to" >

    {section name=year_to loop=$year}
                            <option value={$year[year_to]} {if $year[year_to] == $frm.year_to}selected{/if}>{$year[year_to]}</option>
                            {/section}
                            </select>
    <i></i></span></div></div>
  
<div class="submit"><input type="submit" value="Filter"/></div>
</span></div></div></form>


<script type="text/javascript" src="form/formoid1/formoid-default-skyblue.js"></script>

<table width=300 celspacing=1 cellpadding=1 border=0>
<tr>
 <td class=inheader>Date</td>
 <td class=inheader>Ins</td>
 <td class=inheader>Signups</td>
</tr>
{if $show_refstat}
{section name=s loop=$refstat}
<tr>
 <td class=item align=center><b>{$refstat[s].date}</b></td>
 <td class=item align=right>{$refstat[s].income}</td>
 <td class=item align=right>{$refstat[s].reg}</td>
</tr>
{/section}
{else}
<tr>
 <td class=item align=center colspan=3>No statistics found for this period.</td>
</tr>
{/if}
</table><br>
{/if}

{if $settings.show_referals}
{if $show_referals}
<h3>Your referrals:</h3>
<table cellspacing=1 cellpadding=1 border=0>
<tr>
 <td class=inheader>Nickname</td>
 <td class=inheader>E-mail</td>
 <td class=inheader>Status</td>
</tr>
{section name=s loop=$referals}
<tr>
 <td><b>{$referals[s].username}</b></td>
 <td><a href=mailto:{$referals[s].email}>{$referals[s].email}</a></td>
 <td>{if $referals[s].q_deposits > 0}Deposited{else}No deposit yet{/if}</td>
</tr>
{if $referals[s].ref_stats}
<tr>
 <td colspan=3>
  User referrals:
  {section name=l loop=$referals[s].ref_stats}
   <nobr>{$referals[s].ref_stats[l].cnt_active} active of {$referals[s].ref_stats[l].cnt} on level {$referals[s].ref_stats[l].level}{if !$smarty.section.l.last};{/if}</nobr>
  {/section}
 </td>
</tr>
{/if}
{if $referals[s].came_from}
<tr><td colspan=3>
<a href="{$referals[s].came_from}" target=_blank>[User came from]</a>
</td></tr>
{/if}
{/section}
</table>
{/if}
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
