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
    <link rel="stylesheet" type="text/css" href="css/all.css">
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
<header class="navigation">
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
                {if $userinfo.logged == 0}
                <div class="sf-menu">
                    <div class="header-rr-container clearfix">
						                        <div id="header_buttons">
                            <a id="sign-in-button" class="button medium yellow sign-in-button" href="{$settings.site_url}#">
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
                {else}
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
                {/if}
                <div style="clear:both"></div>
            </div>
            <div class="header-row">
                <div class="clearfix">
                    <!-- TOP MENU -->
                    <nav id="main-nav">
                        <ul class="sf-menu clearfix">
                            <li id ='home'>
                                <a href="{$settings.site_url}">Home</a>
                                <div class="menu_divider"></div>
                            </li>
                            <li id='aboutus'>
                                <a href="{$settings.site_url}/page.php?p=aboutus">About Us</a>
                                <div class="menu_divider"></div>
                            </li>
                            <li id='faq'>
                                <a href="{$settings.site_url}/page.php?p=faq">FAQ / GUIDE</a>
                                <div class="menu_divider"></div>
                            </li>
                            <li id='terms'>
                                <a href="{$settings.site_url}/page.php?p=terms">Terms and Conditions</a>
                                <div class="menu_divider"></div>
                            </li>
                            <li id='invest'> 
                                <a href="{$settings.site_url}/page.php?p=invest">Investment Plans</a>
                                <div class="menu_divider"></div>
                            </li>
                            <li id='bonus'>
                                <a href="{$settings.site_url}/page.php?p=bonus">Bonus Program</a>
                            </li>
                            <li id='contact'>
                                <a href="{$settings.site_url}/page.php?p=contact">Contact Us</a>
                            </li>
                            <li id='news'>
                                <a href="{$settings.site_url}/page.php?p=news">Our News</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- SLIDER -->

