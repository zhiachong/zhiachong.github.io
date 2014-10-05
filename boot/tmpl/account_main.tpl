{include file="header.tpl"}

 <div class="page_title">
        <div class="container">
            <div class="sixteen columns">
                BACKOFFICE
            </div>
        </div>
 </div>

<div class="container ">
    <div class="sixteen columns m-bot-25">
            <h3 class="underlined"><span>Account Information</span></h3>
            <div class="clearfix"></div>
            <div class="w1">
                <section id="main-all">
                    <div id="content">
                        <h1 class="alt-mount">Welcome back, {$userinfo.username}</h1>
                        <table class="account-data">
                        <tbody>
                        <tr>
                            <td>
                                <span class="title">Available balances:</span>
                                <dl class="data">
                                    <dt>{$ps[10].name}:</dt>
                                    <dd>{if $ps[10].balance > 0}${$ps[10].balance}{else}$0.00{/if}</dd>
                                    <dt>{$ps[2].name}:</dt>
                                    <dd>{if $ps[2].balance > 0}${$ps[2].balance}{else}$0.00{/if}</dd>
                                    <dt>EgoPay:</dt>
                                    <dd>{if $ps[4].balance > 0}${$ps[4].balance}{else}$0.00{/if}</dd>
                                </dl>
                            </td>
                            <td>
                                <dl class="total">
                                    <dt>Total Balance:</dt>
                                    <dd>${$ab_formated.total}</dd>
                                </dl>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="title">Account overview:</span>
                                <dl class="data">
                                    <dt>Total Invested:</dt>
                                    <dd>${$ab_formated.total}</dd>
                                    <dt>Last Investment:</dt>
                                    <dd>{if $last_deposit > 0}${$last_deposit}{else}$0.00{/if}</dd>
                                    <dt>Active Deposit:</dt>
                                    <dd>${$ab_formated.active_deposit}</dd>
                                    <dt>Last Withdrawal:</dt>
                                    <dd>${if $last_withdrawal != ''}{$last_withdrawal}{else}0.00{/if}</dd>
                                    <dt>Total Withdrawal:</dt>
                                    <dd>${if $ab_formated.withdrawal > 0}{$ab_formated.withdrawal}{else}0.00{/if}</dd>
                                    <dt>Earned Total:</dt>
                                    <dd>${$ab_formated.earning}</dd>
                                </dl>
                            </td>
                            <td>
                                <dl class="total">
                                    <dt>Pending Withdrawals:</dt>
                                    <dd>${if $ab_formated.withdraw_pending < 0}{$ab_formated.withdraw_pending}{else}0.00{/if}</dd>
                                </dl>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <dl class="account-info">
                        <dt>Registration Date:</dt>
                        <dd>{$userinfo.create_account_date}</dd>
                        <dt>Last Access:</dt>
                        <dd>{$last_access}&nbsp;</dd>
                    </dl>
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