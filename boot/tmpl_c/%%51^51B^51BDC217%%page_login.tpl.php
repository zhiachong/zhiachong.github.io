<?php /* Smarty version 2.6.19, created on 2013-12-30 22:02:10
         compiled from page_login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'myescape', 'page_login.tpl', 12, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="page_title">
    <div class="container">
        <div class="sixteen columns">
            INVALID LOGIN
        </div>
    </div>
</div>


<?php if (((is_array($_tmp=$this->_tpl_vars['frm']['say'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'invalid_login'): ?>
<div class="container about">

    <div class="sixteen columns m-bot-25">
        <h2 class="underlined"><span>WRONG LOGIN INFORMATION</span></h2>
        <br/>
        <p>Unfortunately, you typed in the wrong login information. Please try again, or if you forgot your login, please click here to <a href="page_forgot_password.php" >recover your login information</a>.
        </p>
 
    </div>
</div>
</div>
</div>
<?php else: ?>
<div class="container about">

    <div class="sixteen columns m-bot-25">
        <h2 class="underlined"><span>OOPS</span></h2>
        <br/>
        <p>It seems that you have timed out. Please login again to continue your session. Sorry for the inconvenience!
        </p>
 
    </div>
</div>
</div>
</div>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
