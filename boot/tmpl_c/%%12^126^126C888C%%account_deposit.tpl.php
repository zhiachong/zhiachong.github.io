<?php /* Smarty version 2.6.19, created on 2013-12-30 22:02:38
         compiled from account_deposit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'myescape', 'account_deposit.tpl', 19, false),)), $this); ?>
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
            <h3 class="underlined"><span>Make A Deposit</span></h3>
            <div class="clearfix"></div>
            <br/>
            <br/>
            <div class="w1">
                <section id="main-all">
                    <div id="content">
                        <?php if (((is_array($_tmp=$this->_tpl_vars['frm']['say'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'deposit_success'): ?><h4>Congratulations!</h4> <p class='welcome'>Your deposit has been successfully registered in our database.</p> <br><br> <?php endif; ?>
                        <?php if (((is_array($_tmp=$this->_tpl_vars['frm']['say'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'deposit_saved'): ?>
                        <h4>Your deposit has been saved.</h4><p class="welcome">Our administration team will review your deposit and provide further instructions if needed.</p><br><br>
                        <?php endif; ?>
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
                            <td align=right><?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['ab_formated']['total'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</td>
                        </tr>
                        <tr>
                            <td>Account balance breakdown:</td>
                            <td>
                                <small>
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
                                    <?php if (((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['balance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) != 0): ?><?php if (((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'AlertPay'): ?>EgoPay<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php endif; ?>: <font color='green'><?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['balance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</font><?php if (((is_array($_tmp=$this->_tpl_vars['hold'][$this->_sections['p']['index']]['amount'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) != 0): ?> [<font color='red'><?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['hold'][$this->_sections['p']['index']]['amount'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 on hold</font>]<?php endif; ?><br/><?php endif; ?>
                                    <?php endfor; endif; ?>
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <td>Deposit sum($)</td>
                            <td><input type=text name='amount' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['min_deposit'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
' style="width:92%; padding-bottom: 2px; text-align:center;"/></td>
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
                                <?php if (((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['balance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0 && ((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['status'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 1 && ((is_array($_tmp=$this->_tpl_vars['ps'][$this->_sections['p']['index']]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'SolidTrustPay'): ?>
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
                                <?php endif; ?>
                                <?php endfor; endif; ?>
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

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>