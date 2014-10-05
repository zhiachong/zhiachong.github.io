<?php /* Smarty version 2.6.19, created on 2013-12-30 22:03:01
         compiled from processing_status.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'myescape', 'processing_status.tpl', 18, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

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
                      <?php if (((is_array($_tmp=$this->_tpl_vars['process'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'yes'): ?>
                        <h1 class="alt-mount"><font color="green">Congratulations!</font></h1>
                        <p>We have successfully received your deposit. Thank you for your patronage!</p>
                        <img src="images/congrats.gif" alt="congratulations!" id='success' style="opacity: 0"></img>
                      <?php else: ?>
                        <h1 class="alt-mount"><font color="red">Oops!</font></h1>
                        <p>Unfortunately, we did not receive your deposit. Please try again, or contact one of our support staff for immediate assistance.</p>
                        <img src="images/oops.gif" alt="Oops!" style="opacity: 0" id='oops'></img>
                      <?php endif; ?>
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

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
