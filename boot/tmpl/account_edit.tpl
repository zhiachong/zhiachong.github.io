{include file="header.tpl"}

 <div class="page_title">
        <div class="container">
            <div class="sixteen columns">
                EDIT ACCOUNT
            </div>
        </div>
 </div>

<div class="container ">
    <div class="sixteen columns m-bot-25">
            <h3 class="underlined"><span>Edit Your Account</span></h3>
            <div class="clearfix"></div>
            <div class="w1">
                <section id="main-all">
                    <div id="content">
                        {if $frm.say eq 'changed'}
                        <p class="welcome">Your account data has been updated successfully.</p><br><br>
                        {/if}
                      <link rel="stylesheet" href="form/formoid1/formoid-default-skyblue.css" type="text/css" />
<script type="text/javascript" src="form/formoid1/jquery.min.js"></script>
<form class="formoid-default-skyblue" style="background-color:#FFFFFF;font-size:16px;font-family:'Open Sans',Arial,Verdana,sans-serif;color:#666666;max-width:900px;min-width:150px" method="post" onsubmit="return checkform()" name="editform" action="account_edit.php"><div class="title"><h2>Your Information:</h2></div>
  <input type=hidden name=action value="edit_account">
  <div class="element-input"  title="Please write your full name"><label class="title">Full Name<span class="required">*</span></label><input class="large" type="text" name=fullname id="nameSubmit" value='{$userinfo.name|escape:"quotes"}' required="required"/></div>
  
  <div class="element-input"  title="Please write your email address"><label class="title">Email Address<span class="required">*</span></label><input class="large" type="text" id="emailSubmit" name=email value={$userinfo.email|escape:"quotes"} disabled="disabled"/></div>
  
  <div class="element-password"  title="Please enter your password"><label class="title">Password<span class="required">*</span></label><input class="large" type="password" name=password value="{$frm.password|escape:"quotes"}" id="editPassword" required="required"/></div>
  
  <div class="element-password"  title="Please re-enter your password"><label class="title">Confirm Password<span class="required">*</span></label><input class="large" type="password" name=password2 value="{$frm.password2|escape:"quotes"}" id="editPassword2" required="required"/></div>
  
  {section name=ps loop=$pay_accounts}
  {if $pay_accounts[ps].status == 1}
  <div class="element-input"  title="Your {if $pay_accounts[ps].name == 'AlertPay'}EgoPay{else}{$pay_accounts[ps].name}{/if} account"><label class="title">{if $pay_accounts[ps].name == 'AlertPay'}EgoPay{else}{$pay_accounts[ps].name}{/if}</label><input class="large" type="text" name="{if $pay_accounts[ps].sfx == 'alertpay'}egopay{else}{$pay_accounts[ps].sfx}{/if}" value="{$pay_accounts[ps].account|escape:html}"/></div>
  {/if}
  {/section}
  <div class="submit"><input type="submit" value="Submit" id="submitEdit"/></div></form>
  <script type="text/javascript" src="form/formoid1/formoid-default-skyblue.js"></script>
                  
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