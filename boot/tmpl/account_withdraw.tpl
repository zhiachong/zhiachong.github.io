{include file="header.tpl"}
<div class="page_title">
        <div class="container">
            <div class="sixteen columns">
                WITHDRAWAL AREA
            </div>
        </div>
 </div>

<div class="container ">
    <div class="sixteen columns m-bot-25">
            <h3 class="underlined"><span>Make A Withdrawal</span></h3>
            <div class="clearfix"></div>
            <br/>
            <br/>
            <div class="w1">
                <section id="main-all">
                    <div id="content">
                        {if $say eq 'on_hold'}<p class='welcome'>Sorry, this amount is currently placed on hold.</p><br><br>{/if}
                        {if $say eq 'zero'}<p class='welcome'>We sincerely apologize. You may want to withdraw at least 1 cent.</p><br><br>{/if}
                        {if $say eq 'less_min'}<p class='welcome'>Sorry, at this point you may not request more than ${$settings.min_withdrawal_amount}</p><br><br>{/if}
                        {if $say eq 'daily_limit'}<p class='welcome'>We apologize, there's currently a daily limit in place. Please contact our support team if you have any questions.</p><br><br>{/if}
                        {if $say eq 'processed'}
                         {if $batch eq ''}<p class='welcome'>Your request has been successfully submitted! Our team will review your request and get back to you shortly.</p><br><br>
                         {else} <h4>Congratulations!</h4><p class="welcome">Your request has been successfully processed with the unique batch ID of {$batch}.</p><br>
                        <br>
                        {/if}
                        {/if}
                        {if $say eq 'not_enought'}<p class='welcome'>We apologize, you may only request amounts that are less than or equal to your account balance.</p><br><br>{/if}
                         {if $say eq 'invalid_transaction_code'}<p class='welcome'>You have entered the wrong transaction code, please try again.</p><br><br>{/if}

                        {if $say eq 'no_deposits'}<p class='welcome'>You have not made any deposits yet. Could you be having some issues with making a deposit? Please contact our support for more help if needed.</p><br>{/if}

                        {if $preview}

                        <form method=post action="account_withdraw.php">
                        <input type=hidden name=action value=withdraw>
                        <input type=hidden name=amount value={$amount}>
                        <input type=hidden name=ec value={$ec}>
                        <input type=hidden name=comment value="{$comment|escape:html}">

                         <p class="welcome">You are requesting to withdraw <b>${$amount}</b> of {if $currency =='AlertPay'}EgoPay{else}{$currency}{/if}. 
                        {if $settings.withdrawal_fee > 0 || $settings.withdrawal_fee_min > 0}Our fee is 
                        {if $settings.withdrawal_fee > 0}<b>{$settings.withdrawal_fee}%</b>{/if}
                        {if $settings.withdrawal_fee > 0 && $settings.withdrawal_fee_min > 0} or {/if}
                        {if $settings.withdrawal_fee_min > 0} <b>${$settings.withdrawal_fee_min}</b>{if $settings.withdrawal_fee > 0} as a minimum{/if}{/if}
                        .
                        {else}
                        We have no fee for this operation. 
                        {/if}
                        </p>
                        <br/>
                        <br/>
                        <p>
                         Your withdrawal will result in a total withdrawal of <b>${$to_withdraw}</b> on your {if $currency =='AlertPay'}EgoPay{else}{$currency}{/if} account {if $account}{$account}{/if}.
                        </p>
                        {if $comment}
                        <br/><br/>
                        <p class="welcome">Your comments:</p>
                        <textarea cols='75' rows='5' disabled/>{$comment|escape:html}</textarea>
                        {/if}
                        <br/><br/><br><input type=submit value="Confirm" class='button sign-up-button'>
                        </form>


                        {else}


                        <form method=post action="account_withdraw.php">
                        <input type=hidden name=action value=preview>

                        <table>
                        <tr>
                         <td>Your Balance</td>
                         <td>$<b>{$ab_formated.total}</b></td>
                        </tr>
                        <tr><td>Account Balance Breakdown</td>
                         <td valign="middle"> <small>
                        {section name=p loop=$ps}
                           {if $ps[p].balance > 0}{if $ps[p].name =='AlertPay'}EgoPay{else}{$ps[p].name}{/if}: <font color='green'>${$ps[p].balance}</font>{if $hold[p].amount > 0}[<font color='red'>${$hold[p].amount} on hold</font>]{/if} <br>{/if}
                        {/section}
                         </td>
                        </tr>
                        <tr>
                         <td>Pending Withdrawals </td>
                         <td>$<b>{if $ab_formated.withdraw_pending != 0}{$ab_formated.withdraw_pending}{else}0.00{/if}</b></td>
                        </tr>

                        {section name=p loop=$ps}
                          {if $ps[p].status == 1 AND $ps[p].balance > 0}
                           <tr>
                            <td>{if $ps[p].name =='AlertPay'}EgoPay{else}{$ps[p].name}{/if} Account</td>
                            <td>{$ps[p].account}</td>
                           </tr>
                          {/if}
                        {/section}
                        <table>
                            <tr>
                             <td colspan=2>&nbsp;</td>
                            </tr>
                            <tr>
                             <td>Choose E-currency</td>
                             <td><select name=ec style="width: 100%;">
                                 {section name=p loop=$ps}
                                  {if $ps[p].balance > 0}<option value={$ps[p].id}>{if $ps[p].name =='AlertPay'}EgoPay{else}{$ps[p].name}{/if}</option>{/if}
                                 {/section}
                                 </select>
                             </td>
                            </tr><tr>
                             <td>Withdrawal Amount (US$)</td>
                             <td><input type=text name=amount value="{$settings.min_withdrawal_amount}" style="width:93%;" size=15></td>
                            </tr>
                            <tr>
                             <td colspan=2><textarea name=comment cols=70 rows=5>Your comment</textarea>
                            </tr>
                             <tr>
                            <td colspan='2' class='sbmt'><input type="submit" class="button" value="Submit" style="margin: 10px;"/></td>
                        </tr>
                            </tr></table>
                            </form>
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