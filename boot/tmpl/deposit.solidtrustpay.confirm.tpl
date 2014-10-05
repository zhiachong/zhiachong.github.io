{include file="header.tpl"}

<div class="page_title">
    <div class="container">
        <div class="sixteen columns">
            DEPOSIT AREA
        </div>
    </div>
</div>

<div class="container ">
    <div class="sixteen columns m-bot-25">
        {if $false_data != 1}
        <h3 class="underlined"><span>Confirm your deposit</span></h3>
        <div class="clearfix"></div>

        <div class="w1">
            <section id="main-all">
                <div id="content">
                    <h1 class="alt-mount">Confirmation:</h1>
                    <form name="spend" method="post" action="https://solidtrustpay.com/handle.php">
                    {if $userinfo.solidtrustpay_account != ''}
                        <img src="images/logo2.png" alt="client">
                        <legend>Your SolidTrustPay account number:</legend>
                        <h4>{$userinfo.solidtrustpay_account}</h4><br/>
                    {else}
                        <h4><font color="red">Ooops!</font> It seems like you have not set up your SolidTrustPay account. You'll be asked to login in order to deposit.</h4><br/>
                    {/if}
                    <article class="box-icon clearfix">
                        <i class="icon-credit-card"></i>
                        <legend>Total Deposits:</legend>
                        <h3>${$amount_format}</h3>
                    </article>
                    <br/>
                    <input type="hidden" name="merchantAccount" value="zhiahwachong" />
                    <input type="hidden" name="amount" value="{$amount}" />
                    <input type="hidden" name="currency" value="USD" />
                    <input type="hidden" name="item_id" value="Deposit to {$settings.site_name} for {$userinfo.username}" />
                    <input type="hidden" name="return_url" value="{$settings.site_url}/processing_status.php?process=yes" />
                    <input type="hidden" name="notify_url" value="{$settings.site_url}/processing_solidtrustpay.php" />
                    <input type="hidden" name="cancel_url" value="{$settings.site_url}/processing_status.php?process=no" />
                    <input type="hidden" name="user1" value="{$userinfo.id}" />
                    <input type="hidden" name="user2" value="{$h_id}" />
                    <input type="hidden" name="user3" value="checkpayment" />
                   <br>
                    <input type=submit value="Confirm" class="button sign-up-button"> &nbsp;
                    <input type=button class="button sign-up-button orange" value="Cancel" onclick="document.location='account_main.php'">
                  </form>
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

    {/if}
</div>
</div>

{include file="footer.tpl"}