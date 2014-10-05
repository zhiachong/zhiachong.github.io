{include file="header.tpl"}

<div class="page_title">
        <div class="container">
            <div class="sixteen columns">
                CONFIRMATION
            </div>
        </div>
 </div>

<div class="container ">
    <div class="sixteen columns m-bot-25">
        <h3 class="underlined"><span>Deposit confirmation:</span></h3>
            <div class="clearfix"></div>
            <br/>
            <br/>
            <div class="w1">
                <section id="main-all">
                    <div id="content">
{if $ok == 1}
                        <h1 class="alt-mount">Confirmation</h1>
                        <form name=spend method=post>
                            {if $ps == 'SolidTrustPay'}
                            <img src="images/logo2.png" alt="client">
                            {/if}
                            {if $ps == 'AlertPay'}
                            <img src="images/logo3.png" alt="client">
                            {/if}
                            {if $ps == 'PerfectMoney'}
                            <img src="images/logo1.png" alt="client">
                            {/if}
                        <article class="box-icon clearfix">
                        <i class="icon-credit-card"></i>
                        <legend>Total Deposits From Account Balance:</legend>
                        <h3>${$amount}</h3>
                        </article>
                        <input type=hidden name=a value=deposit>
                        <input type=hidden name=action value=confirm>
                        <input type=hidden name=type value={$type}>
                        <input type=hidden name=h_id value={$h_id}>
                        <input type=hidden name=amount value="{$famount}">
                        <br>
                        <input type=submit value="Process" class='button sign-up-button'> &nbsp;
                        <input type=button class='button sign-up-button' value="Cancel" onclick="document.location='account_deposit.php'">
                        </form>
{else}
                        <h1 class="alt-mount">Error</h1>
                        <p class="welcome">It appears that an error has occurred. Please note that each plan has its own minimum amount required in order to join. Please revise your budget accordingly and try again. Thank you.</p>
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
                            <a href="account_history.php">
                                <legend class="acc">STATISTICS</legend>
                            </a>
                        </li>
                        <li>
                            <a href="account_referral_links.php">
                                <legend class="acc">AFFILIATES</legend>
                            </a>
                        </li>
                        <li>
                            <a href="account_referrals.php">
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
