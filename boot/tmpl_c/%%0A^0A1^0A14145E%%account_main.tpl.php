<?php /* Smarty version 2.6.19, created on 2013-12-30 22:02:35
         compiled from account_main.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'myescape', 'account_main.tpl', 18, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

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
                        <h1 class="alt-mount">Welcome back, <?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['username'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</h1>
                        <table class="account-data">
                        <tbody>
                        <tr>
                            <td>
                                <span class="title">Available balances:</span>
                                <dl class="data">
                                    <dt><?php echo ((is_array($_tmp=$this->_tpl_vars['ps'][10]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
:</dt>
                                    <dd><?php if (((is_array($_tmp=$this->_tpl_vars['ps'][10]['balance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?>$<?php echo ((is_array($_tmp=$this->_tpl_vars['ps'][10]['balance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php else: ?>$0.00<?php endif; ?></dd>
                                    <dt><?php echo ((is_array($_tmp=$this->_tpl_vars['ps'][2]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
:</dt>
                                    <dd><?php if (((is_array($_tmp=$this->_tpl_vars['ps'][2]['balance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?>$<?php echo ((is_array($_tmp=$this->_tpl_vars['ps'][2]['balance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php else: ?>$0.00<?php endif; ?></dd>
                                    <dt>EgoPay:</dt>
                                    <dd><?php if (((is_array($_tmp=$this->_tpl_vars['ps'][4]['balance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?>$<?php echo ((is_array($_tmp=$this->_tpl_vars['ps'][4]['balance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php else: ?>$0.00<?php endif; ?></dd>
                                </dl>
                            </td>
                            <td>
                                <dl class="total">
                                    <dt>Total Balance:</dt>
                                    <dd>$<?php echo ((is_array($_tmp=$this->_tpl_vars['ab_formated']['total'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</dd>
                                </dl>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="title">Account overview:</span>
                                <dl class="data">
                                    <dt>Total Invested:</dt>
                                    <dd>$<?php echo ((is_array($_tmp=$this->_tpl_vars['ab_formated']['total'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</dd>
                                    <dt>Last Investment:</dt>
                                    <dd><?php if (((is_array($_tmp=$this->_tpl_vars['last_deposit'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?>$<?php echo ((is_array($_tmp=$this->_tpl_vars['last_deposit'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php else: ?>$0.00<?php endif; ?></dd>
                                    <dt>Active Deposit:</dt>
                                    <dd>$<?php echo ((is_array($_tmp=$this->_tpl_vars['ab_formated']['active_deposit'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</dd>
                                    <dt>Last Withdrawal:</dt>
                                    <dd>$<?php if (((is_array($_tmp=$this->_tpl_vars['last_withdrawal'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) != ''): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['last_withdrawal'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php else: ?>0.00<?php endif; ?></dd>
                                    <dt>Total Withdrawal:</dt>
                                    <dd>$<?php if (((is_array($_tmp=$this->_tpl_vars['ab_formated']['withdrawal'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['ab_formated']['withdrawal'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php else: ?>0.00<?php endif; ?></dd>
                                    <dt>Earned Total:</dt>
                                    <dd>$<?php echo ((is_array($_tmp=$this->_tpl_vars['ab_formated']['earning'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</dd>
                                </dl>
                            </td>
                            <td>
                                <dl class="total">
                                    <dt>Pending Withdrawals:</dt>
                                    <dd>$<?php if (((is_array($_tmp=$this->_tpl_vars['ab_formated']['withdraw_pending'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) < 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['ab_formated']['withdraw_pending'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php else: ?>0.00<?php endif; ?></dd>
                                </dl>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <dl class="account-info">
                        <dt>Registration Date:</dt>
                        <dd><?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['create_account_date'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</dd>
                        <dt>Last Access:</dt>
                        <dd><?php echo ((is_array($_tmp=$this->_tpl_vars['last_access'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
&nbsp;</dd>
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

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>