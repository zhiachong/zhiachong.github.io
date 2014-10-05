<?php /* Smarty version 2.6.19, created on 2013-12-30 22:02:42
         compiled from deposit.solidtrustpay.confirm.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'myescape', 'deposit.solidtrustpay.confirm.tpl', 13, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="page_title">
    <div class="container">
        <div class="sixteen columns">
            DEPOSIT AREA
        </div>
    </div>
</div>

<div class="container ">
    <div class="sixteen columns m-bot-25">
        <?php if (((is_array($_tmp=$this->_tpl_vars['false_data'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) != 1): ?>
        <h3 class="underlined"><span>Confirm your deposit</span></h3>
        <div class="clearfix"></div>

        <div class="w1">
            <section id="main-all">
                <div id="content">
                    <h1 class="alt-mount">Confirmation:</h1>
                    <form name="spend" method="post" action="https://solidtrustpay.com/handle.php">
                    <?php if (((is_array($_tmp=$this->_tpl_vars['userinfo']['solidtrustpay_account'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) != ''): ?>
                        <img src="images/logo2.png" alt="client">
                        <legend>Your SolidTrustPay account number:</legend>
                        <h4><?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['solidtrustpay_account'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</h4><br/>
                    <?php else: ?>
                        <h4><font color="red">Ooops!</font> It seems like you have not set up your SolidTrustPay account. You'll be asked to login in order to deposit.</h4><br/>
                    <?php endif; ?>
                    <article class="box-icon clearfix">
                        <i class="icon-credit-card"></i>
                        <legend>Total Deposits:</legend>
                        <h3>$<?php echo ((is_array($_tmp=$this->_tpl_vars['amount_format'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</h3>
                    </article>
                    <br/>
                    <input type="hidden" name="merchantAccount" value="zhiahwachong" />
                    <input type="hidden" name="amount" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['amount'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
" />
                    <input type="hidden" name="currency" value="USD" />
                    <input type="hidden" name="sci_name" value="NOVALUE" />
                    <input type="hidden" name="item_id" value="Deposit to <?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 for <?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['username'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
" />
                    <input type="hidden" name="return_url" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/processing_status.php?process=yes" />
                    <input type="hidden" name="notify_url" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/processing_solidtrustpay.php" />
                    <input type="hidden" name="cancel_url" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/processing_status.php?process=no" />
                    <input type="hidden" name="user1" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['id'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
" />
                    <input type="hidden" name="user2" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['h_id'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
" />
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

    <?php endif; ?>
</div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>