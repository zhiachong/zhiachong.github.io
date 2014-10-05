<?php /* Smarty version 2.6.19, created on 2013-12-31 10:49:56
         compiled from footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'myescape', 'footer.tpl', 47, false),array('modifier', 'escape', 'footer.tpl', 64, false),)), $this); ?>
<footer>
    <div class="footer-shadow"></div>
    <div class="footer-content-bg">
        
        <div class="divider"></div>
        <div class="container clearfix">
            All services on the website are provided on behalf of Inflex Shares. The use, duplication or distribution of
            any information
            from the site is allowed only with permission from Inflex Shares <br/>
            except distribution of promotional materials specified in the Terms and conditions statement.
            <div class="copyright"> Copyright © 2013 Inflex Shares. All Rights Reserved</div>
        </div>
    </div>
    <div class="footer-copyright-bg">
        <div class="container ">
        </div>
    </div>
</footer>



<!-- JS begin -->

<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/fancy.js"></script>
<!--[if (gte IE 6)&(lte IE 8)]>
<script type="text/javascript" src="js/selectivizr-min.js"></script>
<![endif]-->
<script type="text/javascript" src="js/jquery.jcarousel.js"></script>
<script type="text/javascript" src="js/jQuery.BlackAndWhite.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/calc.js"></script>
<script type="text/javascript" src="js/faq1.js"></script>
<script type="text/javascript" src="js/custom.js"></script>


<!-- JS end -->
<!-- FORGOT FORM -->
<form id="forgot-form" name=forgotform action="page_forgot_password.php" method="post">
    <div class="close"></div>
    <!-- close button of the sign in form -->
    <ul id="form-section">
        <li>
            <label>
                <span>Forgot your email?</span>
                <p>Click <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/page_forgot_password.php">here</a> or contact one of our staff members at <a href='mailto:contact@inflexshares.com?subject=Password Reminder'>contact@inflexshares.com</a> for further assistance.</p>
            </label>
        </li>
        <br/>
        <div style="clear: both;"></div>
    </ul>
</form>
<!-- END OF FORGOT FORM -->
<!-- BEGIN SIGN IN FORM -->
<form id="sign-in-form" name=mainform onsubmit="return checkform();" action="page_login.php" method="post">
    <div class="close"></div>
    <input type=hidden name=a value='do_login'>
    <!-- close button of the sign in form -->
    <ul id="form-section">
        <li>
            <label>
                <span>Username</span>
                <input id="Username" class="" style="" type="text" name="username" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['frm']['username'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" placeholder="Please enter your username" />				<mark class="validate"></mark>
            </label>
        </li>
        <li>
            <label>
                <span>Password</span>
                <input id="Password" class="" style="" type="password" name="password" value="" placeholder="Please enter your password" />				<mark class="validate"></mark>
            </label>
        </li>
        <div style="clear: both;"></div>
        <li>
            <a id="forgot" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/page_forgot_password.php">Forgot your password?</a>
        </li>
        <li>
            <input type="hidden" name="action" value="signin">
            <button name="sign-in-submit" type="submit" id="sign-in-submit">Sign In</button>
        </li>
        <div style="clear: both;"></div>
    </ul>
</form>
<!-- END OF SIGN IN FORM -->

<div id="background-on-popup"></div>
</body>
</html>

