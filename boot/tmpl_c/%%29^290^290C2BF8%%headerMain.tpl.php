<?php /* Smarty version 2.6.19, created on 2013-12-31 10:49:56
         compiled from headerMain.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'myescape', 'headerMain.tpl', 55, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Inflex Shares Investment Firm</title>
    <meta charset=utf-8>

    <meta name="robots" content="index, follow">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="icon" type="image/gif" href="favicon.gif">

    <!-- CSS begin -->

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/skeleton.css">
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="css/ie-warning.css"><![endif]-->
    <!--[if lte IE 9]>
    <link rel="stylesheet" type="text/css" media="screen" href="https://prime-energy.biz/css/style-ie.css"/><![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="css/ei8fix.css"><![endif]-->
    <!-- Sequence slider CSS -->
    <link rel="stylesheet" type="text/css" href="css/sequencejs-theme.modern-slide-in.css">
    <!--[if lte IE 9]>
    <link rel="stylesheet" type="text/css" media="screen" href="css/sequencejs-theme.modern-slide-in.ie.css"/>
    <![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="css/sequencejs-theme.modern-slide-in.ie8.css"><![endif]-->
    <!--end Sequence slider CSS -->
    <link rel="stylesheet" href="css/colors/aqua.css" id="template-color">
    <!-- CSS end -->
    <!--[if lt IE 9]>
    <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>

<body>
<div id="wrapper">
<div id="main">

<!-- HEADER -->
<header class="navigation main-header">
    <div class="container clearfix">
        <div class="sixteen columns">
            <div class="header-row">
                <div class="header-logo-container ">
                    <a href="https://www.inflexshares.com">
                        <img src="images/header.png"/>
                    </a>
                </div>
                <div class=header-slogan-container>
                    <em><a href="mailto:contact@inflexshares.com"><i class="icon-anchor"></i><span>contact@inflexshares.com</span></a></em>
                </div>
                <?php if (((is_array($_tmp=$this->_tpl_vars['userinfo']['logged'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 0): ?>
                <div class="sf-menu">
                    <div class="header-rr-container clearfix">
                                                <div id="header_buttons">
                            <a id="sign-in-button" class="button medium yellow sign-in-button" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
#">
                                <i class="icon-mail-reply"></i>
                                ACCOUNT LOG IN
                            </a>
                            <a class="button medium blue" href="page_register_account.php">
                                <i class="icon-inbox"></i>
                                ACCOUNT REGISTRATION
                            </a>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="sf-menu">
                    <div class="header-rr-container clearfix">
                        <div id="header_buttons">
                            <a class="button medium yellow sign-in-button" href="account_main.php">
                                <i class="icon-mail-reply"></i>
                                MEMBER BACKOFFICE
                            </a>
                            <a class="button medium blue" href="page_logout.php">
                                <i class="icon-inbox"></i>
                                MEMBER LOGOUT
                            </a>
                        </div>

                    </div>
                </div>
                <?php endif; ?>
                <div style="clear:both"></div>
            </div>
            <div class="header-row">
                <div class="clearfix">
                    <!-- TOP MENU -->
                    <nav id="main-nav">
                        <ul class="sf-menu clearfix">
                            <li class="current">
                                <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
">Home</a>
                                <div class="menu_divider"></div>
                            </li>
                            <li>
                                <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/page.php?p=aboutus">About Us</a>
                                <div class="menu_divider"></div>
                            </li>
                            <li>
                                <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/page.php?p=faq">FAQ / GUIDE</a>
                                <div class="menu_divider"></div>
                            </li>
                            <li>
                                <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/page.php?p=terms">Terms and Conditions</a>
                                <div class="menu_divider"></div>
                            </li>
                            <li>
                                <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/page.php?p=invest">Investment Plans</a>
                                <div class="menu_divider"></div>
                            </li>
                            <li>
                                <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/page.php?p=bonus">Bonus Program</a>
                            </li>
                            <li>
                                <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/page.php?p=contact">Contact Us</a>
                            </li>
                            <li>
                                <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/page.php?p=news">Our News</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- SLIDER -->

