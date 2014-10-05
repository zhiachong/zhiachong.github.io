{include file="header.tpl"}

 <div class="page_title">
        <div class="container">
            <div class="sixteen columns">
                DEPOSIT INFORMATION
            </div>
        </div>
 </div>

<div class="container ">
    <div class="sixteen columns m-bot-25">
            <h3 class="underlined"><span>DEPOSIT STATUS</span></h3>
            <div class="clearfix"></div>
            <div class="w1">
                <section id="main-all">
                    <div id="content">
                      {if $process eq 'yes'}
                        <h1 class="alt-mount"><font color="green">Congratulations!</font></h1>
                        <p>We have successfully received your deposit. Thank you for your patronage!</p>
                        <img src="images/congrats.gif" alt="congratulations!" id='success' style="opacity: 0"></img>
                      {else}
                        <h1 class="alt-mount"><font color="red">Oops!</font></h1>
                        <p>Unfortunately, we did not receive your deposit. Please try again, or contact one of our support staff for immediate assistance.</p>
                        <img src="images/oops.gif" alt="Oops!" style="opacity: 0" id='oops'></img>
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
