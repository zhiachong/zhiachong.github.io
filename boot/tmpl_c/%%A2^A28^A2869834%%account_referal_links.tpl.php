<?php /* Smarty version 2.6.19, created on 2013-12-17 22:46:15
         compiled from account_referal_links.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'myescape', 'account_referal_links.tpl', 25, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="page_title">
    <div class="container">
        <div class="sixteen columns">
            Referral Links
        </div>
    </div>
</div>


<div class="container about">

    <div class="sixteen columns m-bot-25">
        <h3 class="underlined"><span>Advertisement</span></h3>
    </div>

    <div class="twelve alt columns">

       <!-- Toggle 1 -->
       <div class="toggle-wrap faq">
                   <span class="trigger"><a href="index-_erv=site|faq.html#"><i class="icon-magic"></i>Referral Link
                   </a></span>

           <div class="toggle-container" style="display: none;">
               <p><pre><?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/?ref=IS<?php echo ((is_array($_tmp=$this->_tpl_vars['user']['username'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</pre>
               </p>
           </div>
       </div>
       <div class="toggle-wrap faq">
                   <span class="trigger"><a href="index-_erv=site|faq.html#"><i class="icon-magic"></i>128x128 Banner
                   </a></span>

           <div class="toggle-container" style="display: none;">
               <p><center><pre>&lt;img src="/images/banners/128.gif"&gt;&lt;/img&gt;</pre><br/><a href=<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/?ref=<?php echo ((is_array($_tmp=$this->_tpl_vars['user']['username'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
><img src="images/banners/128.gif"></img></a></center>
               </p>
           </div>
       </div>

       <!-- Toggle 2 -->
       <div class="toggle-wrap faq">
           <span class="trigger"><a href="index-_erv=site|faq.html#"><i class="icon-magic"></i>468x90 Banner</a></span>

           <div class="toggle-container" style="display: none;">
               <p><center><pre>&lt;img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/images/banners/468.gif"&gt;&lt;/img&gt;</pre><br/><a href=<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/?ref=<?php echo ((is_array($_tmp=$this->_tpl_vars['user']['username'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/images/banners/468.gif"></img></a></center>
               </p>
           </div>
       </div>


       <!-- Toggle 4 -->
       <div class="toggle-wrap faq">
           <span class="trigger"><a href="index-_erv=site|faq.html#"><i class="icon-magic"></i>728x90 Banner</a></span>

           <div class="toggle-container" style="display: none;">
               <p><center><pre>&lt;img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/images/banners/728.gif"&gt;&lt;/img&gt;</pre><br/><a href=<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/?ref=<?php echo ((is_array($_tmp=$this->_tpl_vars['user']['username'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['site_url'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
/images/banners/728.gif"></img></a></center>
               </p>
           </div>
       </div>

    <div class="five columns" id="sliding_box">
        
    </div>
</div>
</div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
