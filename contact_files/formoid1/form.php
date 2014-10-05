<?php

define('EMAIL_FOR_REPORTS', 'zhiachong@gmail.com');
define('RECAPTCHA_PRIVATE_KEY', '@privatekey@');
define('FINISH_URI', 'http://www.zhiachong.com/success.php?success=1');
define('FINISH_ACTION', 'redirect');
define('FINISH_MESSAGE', 'Thanks for filling out my form!');
define('UPLOAD_ALLOWED_FILE_TYPES', 'doc, docx, xls, csv, txt, rtf, html, zip, jpg, jpeg, png, gif');

require_once str_replace('\\', '/', __DIR__) . '/handler.php';

?>

<?php if (frmd_message()): ?>
<link rel="stylesheet" href="<?=dirname($form_path)?>/formoid-metro-cyan.css" type="text/css" />
<span class="alert alert-success"><?=FINISH_MESSAGE;?></span>
<?php else: ?>
<!-- Start Formoid form-->
<link rel="stylesheet" href="<?=dirname($form_path)?>/formoid-metro-cyan.css" type="text/css" />
<script type="text/javascript" src="<?=dirname($form_path)?>/jquery.min.js"></script>
<form class="formoid-metro-cyan" style="background-color:#fffff1;font-size:14px;font-family:'Open Sans',Arial,Verdana,sans-serif;color:#666666;max-width:480px;min-width:150px" method="post"><div class="title"><h2>Contact Me</h2></div>
	<div class="element-input"  title="What's your name?" <?frmd_add_class("input")?>><label class="title">Name</label><input class="large" type="text" name="input" /></div>
	<div class="element-input"  title="What's your email address?" <?frmd_add_class("input1")?>><label class="title">Email<span class="required">*</span></label><input class="large" type="text" name="input1" required="required"/></div>
	<div class="element-input"  title="What's your phone number?" <?frmd_add_class("input2")?>><label class="title">Phone number<span class="required">*</span></label><input class="large" type="text" name="input2" required="required"/></div>
	<div class="element-textarea"  title="What do you want to send?" <?frmd_add_class("textarea")?>><label class="title">Message<span class="required">*</span></label><textarea class="medium" name="textarea" cols="20" rows="5" required="required"></textarea></div>

<div class="submit"><input type="submit" value="Submit"/></div></form>
<script type="text/javascript" src="<?=dirname($form_path)?>/formoid-metro-cyan.js"></script>

<!-- Stop Formoid form-->
<?php endif; ?>

<?php frmd_end_form(); ?>