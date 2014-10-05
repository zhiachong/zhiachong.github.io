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
            <h3 class="underlined"><span>Make A Deposit</span></h3>
            <div class="clearfix"></div>
            <br/>
            <br/>
            <div class="w1">
                <section id="main-all">
                    <div id="content">
                        {if $frm.say eq 'deposit_success'}<h4>Congratulations!</h4> <p class='welcome'>Your deposit has been successfully registered in our database.</p> <br><br> {/if}
                        {if $frm.say eq 'deposit_saved'}
                        <h4>Your deposit has been saved.</h4><p class="welcome">Our administration team will review your deposit and provide further instructions if needed.</p><br><br>
                        {/if}
                        <form method=post name="spendform" action="account_deposit.php">
                        </br>
                        <h4 class="underlined">Investments</h4>
                        <table>
                        <tbody>
                        <tr>
                            <td>CHOICE</td>
                            <td>NAME</td>
                            <td>INTEREST</td>
                            <td>MINIMUM</td>
                            <td>MAXIMUM</td>
                            <td>PERIOD</td>
                        </tr>
                        <tr>
                            <td><input type='radio' name='h_id' value='4' checked/></td>
                            <td><span class="title">DEFENSE</span></td>
                            <td>2.0% Daily</td>
                            <td>$10</td>
                            <td>$2999</td>
                            <td>60 days</td>
                        </tr>
                        <tr>
                            <td><input type='radio' name='h_id' value='5'/></td>
                            <td><span class="title">LOVE</span></td>
                            <td>2.2% Daily</td>
                            <td>$3000</td>
                            <td>$5999</td>
                            <td>90 days</td>
                        </tr>
                        <tr>
                            <td><input type='radio' name='h_id' value='6'/></td>
                            <td><span class="title">STAR</span></td>
                            <td>2.5% Daily</td>
                            <td>$6000</td>
                            <td>$50000</td>
                            <td>120 days</td>
                        </tr>
                        </tbody>
                        </table>
                        
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <h4 class="underlined">Your Balance</h4>
                        
                        <table>
                        <tr>
                            <td>Your account balance in USD($):</td>
                            <td align=right>{$currency_sign}{$ab_formated.total}</td>
                        </tr>
                        <tr>
                            <td>Account balance breakdown:</td>
                            <td>
                                <small>
                                    {section name=p loop=$ps}
                                    {if $ps[p].balance != 0}{if $ps[p].name == 'AlertPay'}EgoPay{else}{$ps[p].name}{/if}: <font color='green'>{$currency_sign}{$ps[p].balance}</font>{if $hold[p].amount != 0} [<font color='red'>{$currency_sign}{$hold[p].amount} on hold</font>]{/if}<br/>{/if}
                                    {/section}
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <td>Deposit sum($)</td>
                            <td><input type=text name='amount' value='{$min_deposit}' style="width:92%; padding-bottom: 2px; text-align:center;"/></td>
                        </tr>
                                {section name=p loop=$ps}
                                {if $ps[p].balance > 0 and $ps[p].status == 1 and $ps[p].name=='SolidTrustPay'}
                                <tr>
                                    <td>Reinvest From Balance</td>
                                    <td>
                                        <select name="type" id="reinvest" style="width:100%">
                                            <option selected></option>
                                            <option value="account_2">SolidTrustPay</option>
                                            <option value="account_4">EgoPay</option>
                                            <option value="account_10">PerfectMoney</option>
                                        </select>
                                    </td>
                                </tr>
                                {/if}
                                {/section}
                                <tr>
                                        <td>Payment Gateway</td>
                                        <td>
                                        <select name="type" id="external" style="width: 100%;">
                                             <option selected></option>
                                             <option value="process_2">SolidTrustPay</option>
                                             <option value="process_4">EgoPay</option>
                                             <option value="process_10">PerfectMoney</option>
                                         </select>
                                         </td>
                                </tr>
                        <tr>
                            <td colspan='2' class='sbmt'><input type="submit" class="button" value="Submit" style="margin: 10px;"/></td>
                        </tr>
                        </table>
                        <br/>
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