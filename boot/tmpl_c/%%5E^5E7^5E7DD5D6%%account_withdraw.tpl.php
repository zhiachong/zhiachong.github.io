<?php /* Smarty version 2.6.19, created on 2013-12-17 23:16:00
         compiled from account_withdraw.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'myescape', 'account_withdraw.tpl', 19, false),array('modifier', 'escape', 'account_withdraw.tpl', 40, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
                        <?php if (((is_array($_tmp=$this->_tpl_vars['say'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'on_hold'): ?><p class='welcome'>Sorry, this amount is currently placed on hold.</p><br><br><?php endif; ?>
                        <?php if (((is_array($_tmp=$this->_tpl_vars['say'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'zero'): ?><p class='welcome'>We sincerely apologize. You may want to withdraw at least 1 cent.</p><br><br><?php endif; ?>
                        <?php if (((is_array($_tmp=$this->_tpl_vars['say'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'less_min'): ?><p class='welcome'>Sorry, at this point you may not request more than $<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['min_withdrawal_amount'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</p><br><br><?php endif; ?>
                        <?php if (((is_array($_tmp=$this->_tpl_vars['say'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'daily_limit'): ?><p class='welcome'>We apologize, there's currently a daily limit in place. Please contact our support team if you have any questions.</p><br><br><?php endif; ?>
                        <?php if (((is_array($_tmp=$this->_tpl_vars['say'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'processed'): ?>
                         <?php if (((is_array($_tmp=$this->_tpl_vars['batch'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == ''): ?><p class='welcome'>Your request has been successfully submitted! Our team will review your request and get back to you shortly.</p><br><br>
                         <?php else: ?> <h4>Congratulations!</h4><p class="welcome">Your request has been successfully processed with the unique batch ID of <?php echo ((is_array($_tmp=$this->_tpl_vars['batch'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
.</p><br>
                        <br>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if (((is_array($_tmp=$this->_tpl_vars['say'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'not_enought'): ?><p class='welcome'>We apologize, you may only request amounts that are less than or equal to your account balance.</p><br><br><?php endif; ?>
                         <?php if (((is_array($_tmp=$this->_tpl_vars['say'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'invalid_transaction_code'): ?><p class='welcome'>You have entered the wrong transaction code, please try again.</p><br><br><?php endif; ?>

                        <?php if (((is_array($_tmp=$this->_tpl_vars['say'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'no_deposits'): ?><p class='welcome'>You have not made any deposits yet. Could you be having some issues with making a deposit? Please contact our support for more help if needed.</p><br><?php endif; ?>

                        <?php if (((is_array($_tmp=$this->_tpl_vars['preview'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>

                        <form method=post action="account_withdraw.php">
                        <input type=hidden name=action value=withdraw>
                        <input type=hidden name=amount value=<?php echo ((is_array($_tmp=$this->_tpl_vars['amount'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
>
                        <input type=hidden name=ec value=<?php echo ((is_array($_tmp=$this->_tpl_vars['ec'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
>
                        <input type=hidden name=comment value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['comment'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
">

                         <p class="welcome">You are requesting to withdraw <b>$<?php echo ((is_array($_tmp=$this->_tpl_vars['amount'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b> of <?php if (((is_array($_tmp=$this->_tpl_vars['currency'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'AlertPay'): ?>EgoPay<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['currency'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php endif; ?>. 
                        <?php if (((is_array($_tmp=$this->_tpl_vars['settings']['withdrawal_fee'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0 || ((is_array($_tmp=$this->_tpl_vars['settings']['withdrawal_fee_min'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?>Our fee is 
                        <?php if (((is_array($_tmp=$this->_tpl_vars['settings']['withdrawal_fee'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?><b><?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['withdrawal_fee'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
%</b><?php endif; ?>
                        <?php if (((is_array($_tmp=$this->_tpl_vars['settings']['withdrawal_fee'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0 && ((is_array($_tmp=$this->_tpl_vars['settings']['withdrawal_fee_min'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?> or <?php endif; ?>
                        <?php if (((is_array($_tmp=$this->_tpl_vars['settings']['withdrawal_fee_min'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?> <b>$<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['withdrawal_fee_min'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b><?php if (((is_array($_tmp=$this->_tpl_vars['settings']['withdrawal_fee'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?> as a minimum<?php endif; ?><?php endif; ?>
                        .
                        <?php else: ?>
                        We have no fee for this operation. 
                        <?php endif; ?>
                        </p>
                        <br/>
                        <br/>
                        <p>
                         Your withdrawal will result in a total withdrawal of <b>$<?php echo ((is_array($_tmp=$this->_tpl_vars['to_withdraw'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b> on your <?php if (((is_array($_tmp=$this->_tpl_vars['currency'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'AlertPay'): ?>EgoPay<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['currency'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php endif; ?> account <?php if (((is_array($_tmp=$this->_tpl_vars['account'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['account'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php endif; ?>.
                        </p>
                        <?php if (((is_array($_tmp=$this->_tpl_vars['comment'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>
                        <br/><br/>
                        <p class="welcome">Your comments:</p>
                        <textarea cols='75' rows='5' disabled/><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['comment'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</textarea>
                        <?php endif; ?>
                        <br/><br/><br><input type=submit value="Confirm" class='button sign-up-button'>
                        </form>


                        <?php else: ?>


                        <form method=post action="account_withdraw.php">
                        <input type=hidden name=action value=preview>

                        <table>
                        <tr>
                         <td>Your Balance</td>
                         <td>$<b><?php echo ((is_array($_tmp=$this->_tpl_vars['ab_formated']['total'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b></td>
                        </tr>
                        <tr><td>Account Balance Breakdown</td>
                         <td valign="middle"> <small>
                        <?php unset($this->_sections['p']);
$this->_sections['p']['name'] = 'p';
$this->_sections['p']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['ps'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['p']['show'] = true;
$this->_sections['p']['max'] = $this->_sections['p']['loop'];
$this->_sections['p']['step'] = 1;
$this->_sections['p']['start'] = $this->_sections['p']['step'] > 0 ? 0 : $this->_sections['p']['loop']-1;
if ($this->_sections['p']['show']) {
    $this->_sections['p']['total'] = $this->_sections['p']['loop'];
    if ($this->_sections['p']['total'] == 0)
        $this->_sections['p']['show'] = false;
} else
    $this->_sections['p']['total'] = 0;
if ($this->_sections['p']['show']):

            for ($this->_sections['p']['index'] = $this->_sections['p']['start'], $this->_sections['p']['iteration'] = 1;
                 $this->_sections['p']['iteration'] <= $this->_sections['p']['total'];
                 $this->_sections['p']['index'] += $this->_sections['p']['step'], $this->_sections['p']['iteration']++):
$this->_sections['p']['rownum'] = $this->_sections['p']['iteration'];
$this->_sections['p']['index_prev'] = $this->_sections['p']['index'] - $this->_sections['p']['step'];
$this->_sections['p']['index_next'] = $this->_sections['p']['index'] + $this->_sections['p']['step'];
$this->_sections['p']['first']      = ($this->_sections['p']['iteration'] == 1);
$this->_sections['p']['last']       = ($this->_sections['p']['iteration'] == $this->_sections['p']['total']);
?>
                           <?php if (((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['balance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?><?php if (((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'AlertPay'): ?>EgoPay<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php endif; ?>: <font color='green'>$<?php echo ((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['balance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</font><?php if (((is_array($_tmp=$this->_tpl_vars['hold'][$this->_sections['p']['index']]['amount'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?>[<font color='red'>$<?php echo ((is_array($_tmp=$this->_tpl_vars['hold'][$this->_sections['p']['index']]['amount'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 on hold</font>]<?php endif; ?> <br><?php endif; ?>
                        <?php endfor; endif; ?>
                         </td>
                        </tr>
                        <tr>
                         <td>Pending Withdrawals </td>
                         <td>$<b><?php if (((is_array($_tmp=$this->_tpl_vars['ab_formated']['withdraw_pending'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) != 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['ab_formated']['withdraw_pending'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php else: ?>0.00<?php endif; ?></b></td>
                        </tr>

                        <?php unset($this->_sections['p']);
$this->_sections['p']['name'] = 'p';
$this->_sections['p']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['ps'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['p']['show'] = true;
$this->_sections['p']['max'] = $this->_sections['p']['loop'];
$this->_sections['p']['step'] = 1;
$this->_sections['p']['start'] = $this->_sections['p']['step'] > 0 ? 0 : $this->_sections['p']['loop']-1;
if ($this->_sections['p']['show']) {
    $this->_sections['p']['total'] = $this->_sections['p']['loop'];
    if ($this->_sections['p']['total'] == 0)
        $this->_sections['p']['show'] = false;
} else
    $this->_sections['p']['total'] = 0;
if ($this->_sections['p']['show']):

            for ($this->_sections['p']['index'] = $this->_sections['p']['start'], $this->_sections['p']['iteration'] = 1;
                 $this->_sections['p']['iteration'] <= $this->_sections['p']['total'];
                 $this->_sections['p']['index'] += $this->_sections['p']['step'], $this->_sections['p']['iteration']++):
$this->_sections['p']['rownum'] = $this->_sections['p']['iteration'];
$this->_sections['p']['index_prev'] = $this->_sections['p']['index'] - $this->_sections['p']['step'];
$this->_sections['p']['index_next'] = $this->_sections['p']['index'] + $this->_sections['p']['step'];
$this->_sections['p']['first']      = ($this->_sections['p']['iteration'] == 1);
$this->_sections['p']['last']       = ($this->_sections['p']['iteration'] == $this->_sections['p']['total']);
?>
                          <?php if (((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['status'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 1 && ((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['balance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?>
                           <tr>
                            <td><?php if (((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'AlertPay'): ?>EgoPay<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php endif; ?> Account</td>
                            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['account'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</td>
                           </tr>
                          <?php endif; ?>
                        <?php endfor; endif; ?>
                        <table>
                            <tr>
                             <td colspan=2>&nbsp;</td>
                            </tr>
                            <tr>
                             <td>Choose E-currency</td>
                             <td><select name=ec style="width: 100%;">
                                 <?php unset($this->_sections['p']);
$this->_sections['p']['name'] = 'p';
$this->_sections['p']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['ps'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['p']['show'] = true;
$this->_sections['p']['max'] = $this->_sections['p']['loop'];
$this->_sections['p']['step'] = 1;
$this->_sections['p']['start'] = $this->_sections['p']['step'] > 0 ? 0 : $this->_sections['p']['loop']-1;
if ($this->_sections['p']['show']) {
    $this->_sections['p']['total'] = $this->_sections['p']['loop'];
    if ($this->_sections['p']['total'] == 0)
        $this->_sections['p']['show'] = false;
} else
    $this->_sections['p']['total'] = 0;
if ($this->_sections['p']['show']):

            for ($this->_sections['p']['index'] = $this->_sections['p']['start'], $this->_sections['p']['iteration'] = 1;
                 $this->_sections['p']['iteration'] <= $this->_sections['p']['total'];
                 $this->_sections['p']['index'] += $this->_sections['p']['step'], $this->_sections['p']['iteration']++):
$this->_sections['p']['rownum'] = $this->_sections['p']['iteration'];
$this->_sections['p']['index_prev'] = $this->_sections['p']['index'] - $this->_sections['p']['step'];
$this->_sections['p']['index_next'] = $this->_sections['p']['index'] + $this->_sections['p']['step'];
$this->_sections['p']['first']      = ($this->_sections['p']['iteration'] == 1);
$this->_sections['p']['last']       = ($this->_sections['p']['iteration'] == $this->_sections['p']['total']);
?>
                                  <?php if (((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['balance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?><option value=<?php echo ((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['id'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
><?php if (((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'AlertPay'): ?>EgoPay<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php endif; ?></option><?php endif; ?>
                                 <?php endfor; endif; ?>
                                 </select>
                             </td>
                            </tr><tr>
                             <td>Withdrawal Amount (US$)</td>
                             <td><input type=text name=amount value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['min_withdrawal_amount'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
" style="width:93%;" size=15></td>
                            </tr>
                            <tr>
                             <td colspan=2><textarea name=comment cols=70 rows=5>Your comment</textarea>
                            </tr>
                             <tr>
                            <td colspan='2' class='sbmt'><input type="submit" class="button" value="Submit" style="margin: 10px;"/></td>
                        </tr>
                            </tr></table>
                            </form>
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