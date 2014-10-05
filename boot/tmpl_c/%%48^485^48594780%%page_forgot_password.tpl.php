<?php /* Smarty version 2.6.19, created on 2013-12-14 13:23:41
         compiled from page_forgot_password.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'myescape', 'page_forgot_password.tpl', 37, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script language=javascript>
function checkform() {
  if (document.forgotform.email.value == \'\') {
    alert("Please type your username or email!");
    document.forgotform.email.focus();
    return false;
  }
  return true;
}
</script>
'; ?>





<div class="page_title">
    <div class="container">
        <div class="sixteen columns">
            FORGOT PASSWORD
        </div>
    </div>
</div>


<div class="container about">
<!-- FEATURES -->
<div class="sixteen columns m-bot-25">
<h3 class="underlined"><span>Reset Your Password</span></h3>
<div class="clearfix"></div>

<div class="container clearfix m-bot-35">
    <div class="sixteen columns">
        <p>Please type in your email address in order to recover your login information.</p>
        <?php if (((is_array($_tmp=$this->_tpl_vars['found_records'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 0): ?>
        <p>Unfortunately, it seems that you have not registered with us as we cannot find your login information.</p>
        <?php endif; ?>
        <?php if (((is_array($_tmp=$this->_tpl_vars['found_records'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 1): ?>
        <p><font color='green'>Woohoo!</font> We found your account. Please check your inbox and follow the instructions to recover your account.</p>
        <?php else: ?>
<form method=post name=forgotform onsubmit="return checkform();" action="page_forgot_password.php">
<input type=hidden name=action value="forgot_password">
<legend>Type your username or e-mail:</legend>
 <input type=text name='email' value="" class=inpts size=30>

 <button class="button sign-up-button" type=submit value="Forgot" class=sbmt>Recover my info</button>
</form><br><br>
<?php endif; ?>
    </div>
</div>
</div>

</div>
</div>

</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
