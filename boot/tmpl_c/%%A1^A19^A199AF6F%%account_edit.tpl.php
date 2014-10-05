<?php /* Smarty version 2.6.19, created on 2013-12-17 23:16:35
         compiled from account_edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'myescape', 'account_edit.tpl', 18, false),array('modifier', 'escape', 'account_edit.tpl', 25, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

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
                        <?php if (((is_array($_tmp=$this->_tpl_vars['frm']['say'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'changed'): ?>
                        <p class="welcome">Your account data has been updated successfully.</p><br><br>
                        <?php endif; ?>
                      <link rel="stylesheet" href="form/formoid1/formoid-default-skyblue.css" type="text/css" />
<script type="text/javascript" src="form/formoid1/jquery.min.js"></script>
<form class="formoid-default-skyblue" style="background-color:#FFFFFF;font-size:16px;font-family:'Open Sans',Arial,Verdana,sans-serif;color:#666666;max-width:900px;min-width:150px" method="post" onsubmit="return checkform()" name="editform" action="account_edit.php"><div class="title"><h2>Your Information:</h2></div>
  <input type=hidden name=action value="edit_account">
  <div class="element-input"  title="Please write your full name"><label class="title">Full Name<span class="required">*</span></label><input class="large" type="text" name=fullname id="nameSubmit" value='<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['userinfo']['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
' required="required"/></div>
  
  <div class="element-input"  title="Please write your email address"><label class="title">Email Address<span class="required">*</span></label><input class="large" type="text" id="emailSubmit" name=email value=<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['userinfo']['email'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
 disabled="disabled"/></div>
  
  <div class="element-password"  title="Please enter your password"><label class="title">Password<span class="required">*</span></label><input class="large" type="password" name=password value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['frm']['password'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
" id="editPassword" required="required"/></div>
  
  <div class="element-password"  title="Please re-enter your password"><label class="title">Confirm Password<span class="required">*</span></label><input class="large" type="password" name=password2 value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['frm']['password2'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
" id="editPassword2" required="required"/></div>
  
  <?php unset($this->_sections['ps']);
$this->_sections['ps']['name'] = 'ps';
$this->_sections['ps']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['pay_accounts'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ps']['show'] = true;
$this->_sections['ps']['max'] = $this->_sections['ps']['loop'];
$this->_sections['ps']['step'] = 1;
$this->_sections['ps']['start'] = $this->_sections['ps']['step'] > 0 ? 0 : $this->_sections['ps']['loop']-1;
if ($this->_sections['ps']['show']) {
    $this->_sections['ps']['total'] = $this->_sections['ps']['loop'];
    if ($this->_sections['ps']['total'] == 0)
        $this->_sections['ps']['show'] = false;
} else
    $this->_sections['ps']['total'] = 0;
if ($this->_sections['ps']['show']):

            for ($this->_sections['ps']['index'] = $this->_sections['ps']['start'], $this->_sections['ps']['iteration'] = 1;
                 $this->_sections['ps']['iteration'] <= $this->_sections['ps']['total'];
                 $this->_sections['ps']['index'] += $this->_sections['ps']['step'], $this->_sections['ps']['iteration']++):
$this->_sections['ps']['rownum'] = $this->_sections['ps']['iteration'];
$this->_sections['ps']['index_prev'] = $this->_sections['ps']['index'] - $this->_sections['ps']['step'];
$this->_sections['ps']['index_next'] = $this->_sections['ps']['index'] + $this->_sections['ps']['step'];
$this->_sections['ps']['first']      = ($this->_sections['ps']['iteration'] == 1);
$this->_sections['ps']['last']       = ($this->_sections['ps']['iteration'] == $this->_sections['ps']['total']);
?>
  <?php if (((is_array($_tmp=$this->_tpl_vars['pay_accounts'][$this->_sections['ps']['index']]['status'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 1): ?>
  <div class="element-input"  title="Your <?php if (((is_array($_tmp=$this->_tpl_vars['pay_accounts'][$this->_sections['ps']['index']]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'AlertPay'): ?>EgoPay<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['pay_accounts'][$this->_sections['ps']['index']]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php endif; ?> account"><label class="title"><?php if (((is_array($_tmp=$this->_tpl_vars['pay_accounts'][$this->_sections['ps']['index']]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'AlertPay'): ?>EgoPay<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['pay_accounts'][$this->_sections['ps']['index']]['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php endif; ?></label><input class="large" type="text" name="<?php if (((is_array($_tmp=$this->_tpl_vars['pay_accounts'][$this->_sections['ps']['index']]['sfx'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'alertpay'): ?>egopay<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['pay_accounts'][$this->_sections['ps']['index']]['sfx'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php endif; ?>" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['pay_accounts'][$this->_sections['ps']['index']]['account'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"/></div>
  <?php endif; ?>
  <?php endfor; endif; ?>
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

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>