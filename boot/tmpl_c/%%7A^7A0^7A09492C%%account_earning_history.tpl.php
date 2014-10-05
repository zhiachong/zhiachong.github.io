<?php /* Smarty version 2.6.19, created on 2013-12-17 23:15:46
         compiled from account_earning_history.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'myescape', 'account_earning_history.tpl', 39, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script>
function go(p)
{
  document.opts.page.value = p;
  document.opts.submit();
}
</script>
'; ?>


 <div class="page_title">
        <div class="container">
            <div class="sixteen columns">
                ACCOUNT STATISTICS
            </div>
        </div>
 </div>

<div class="container ">
    <div class="sixteen columns m-bot-25">
            <h3 class="underlined"><span>Statistics</span></h3>
            <div class="clearfix"></div>
            <br/>
            <br/>
            <div class="w1">
                <section id="main-all">
                    <div id="content">
                              <h3>Transactions:</h3>

                              <link rel="stylesheet" href="form/formoid1/formoid-default-skyblue.css" type="text/css" />
<script type="text/javascript" src="form/formoid1/jquery.min.js"></script>

<form class="formoid-default-skyblue" style="margin-left:50px;background-color:#FFFFFF;font-size:16px;font-family:'Open Sans',Arial,Verdana,sans-serif;color:#666666;max-width:900px;min-width:150px" method="post" onsubmit="return checkform()" name=opts action="account_earnings.php">

  <div class="element-select"><label class="title">Transactions:</label><div class="large"><span><select name="type" onchange="document.opts.submit();">
                            <option value="">All</option>
                            <?php unset($this->_sections['opt']);
$this->_sections['opt']['name'] = 'opt';
$this->_sections['opt']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['options'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['opt']['show'] = true;
$this->_sections['opt']['max'] = $this->_sections['opt']['loop'];
$this->_sections['opt']['step'] = 1;
$this->_sections['opt']['start'] = $this->_sections['opt']['step'] > 0 ? 0 : $this->_sections['opt']['loop']-1;
if ($this->_sections['opt']['show']) {
    $this->_sections['opt']['total'] = $this->_sections['opt']['loop'];
    if ($this->_sections['opt']['total'] == 0)
        $this->_sections['opt']['show'] = false;
} else
    $this->_sections['opt']['total'] = 0;
if ($this->_sections['opt']['show']):

            for ($this->_sections['opt']['index'] = $this->_sections['opt']['start'], $this->_sections['opt']['iteration'] = 1;
                 $this->_sections['opt']['iteration'] <= $this->_sections['opt']['total'];
                 $this->_sections['opt']['index'] += $this->_sections['opt']['step'], $this->_sections['opt']['iteration']++):
$this->_sections['opt']['rownum'] = $this->_sections['opt']['iteration'];
$this->_sections['opt']['index_prev'] = $this->_sections['opt']['index'] - $this->_sections['opt']['step'];
$this->_sections['opt']['index_next'] = $this->_sections['opt']['index'] + $this->_sections['opt']['step'];
$this->_sections['opt']['first']      = ($this->_sections['opt']['iteration'] == 1);
$this->_sections['opt']['last']       = ($this->_sections['opt']['iteration'] == $this->_sections['opt']['total']);
?>
                            <option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['options'][$this->_sections['opt']['index']]['type'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
" <?php if (((is_array($_tmp=$this->_tpl_vars['options'][$this->_sections['opt']['index']]['selected'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>selected<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['options'][$this->_sections['opt']['index']]['type_name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</option>
                            <?php endfor; endif; ?>
                               </select><i></i></span></div></div>
 
 <div class="element-select"><label class="title">E-Currencies:</label><div class="large"><span><select name="select" >
    <option value="">All E-Currencies</option><br/>
    <option value="2">SolidTrustPay</option><br/>
    <option value="4">EgoPay</option><br/>
    <option value="10">PerfectMoney</option><br/></select><i></i></span></div></div>

    <div class="element-select"><label class="title">From:</label><div class="large"><span><select name="month_from" >
                            <?php unset($this->_sections['month_from']);
$this->_sections['month_from']['name'] = 'month_from';
$this->_sections['month_from']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['month'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['month_from']['show'] = true;
$this->_sections['month_from']['max'] = $this->_sections['month_from']['loop'];
$this->_sections['month_from']['step'] = 1;
$this->_sections['month_from']['start'] = $this->_sections['month_from']['step'] > 0 ? 0 : $this->_sections['month_from']['loop']-1;
if ($this->_sections['month_from']['show']) {
    $this->_sections['month_from']['total'] = $this->_sections['month_from']['loop'];
    if ($this->_sections['month_from']['total'] == 0)
        $this->_sections['month_from']['show'] = false;
} else
    $this->_sections['month_from']['total'] = 0;
if ($this->_sections['month_from']['show']):

            for ($this->_sections['month_from']['index'] = $this->_sections['month_from']['start'], $this->_sections['month_from']['iteration'] = 1;
                 $this->_sections['month_from']['iteration'] <= $this->_sections['month_from']['total'];
                 $this->_sections['month_from']['index'] += $this->_sections['month_from']['step'], $this->_sections['month_from']['iteration']++):
$this->_sections['month_from']['rownum'] = $this->_sections['month_from']['iteration'];
$this->_sections['month_from']['index_prev'] = $this->_sections['month_from']['index'] - $this->_sections['month_from']['step'];
$this->_sections['month_from']['index_next'] = $this->_sections['month_from']['index'] + $this->_sections['month_from']['step'];
$this->_sections['month_from']['first']      = ($this->_sections['month_from']['iteration'] == 1);
$this->_sections['month_from']['last']       = ($this->_sections['month_from']['iteration'] == $this->_sections['month_from']['total']);
?>
                            <option value=<?php echo ((is_array($_tmp=$this->_sections['month_from']['index']+1)) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 <?php if (((is_array($_tmp=$this->_sections['month_from']['index']+1)) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == ((is_array($_tmp=$this->_tpl_vars['frm']['month_from'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>selected<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['month'][$this->_sections['month_from']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>

                            <?php endfor; endif; ?>
                            </select><i></i></span></div></div>
    <div class="element-select"><label class="title"></label><div class="large"><span><select name="day_from" >
                            <?php unset($this->_sections['day_from']);
$this->_sections['day_from']['name'] = 'day_from';
$this->_sections['day_from']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['day'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['day_from']['show'] = true;
$this->_sections['day_from']['max'] = $this->_sections['day_from']['loop'];
$this->_sections['day_from']['step'] = 1;
$this->_sections['day_from']['start'] = $this->_sections['day_from']['step'] > 0 ? 0 : $this->_sections['day_from']['loop']-1;
if ($this->_sections['day_from']['show']) {
    $this->_sections['day_from']['total'] = $this->_sections['day_from']['loop'];
    if ($this->_sections['day_from']['total'] == 0)
        $this->_sections['day_from']['show'] = false;
} else
    $this->_sections['day_from']['total'] = 0;
if ($this->_sections['day_from']['show']):

            for ($this->_sections['day_from']['index'] = $this->_sections['day_from']['start'], $this->_sections['day_from']['iteration'] = 1;
                 $this->_sections['day_from']['iteration'] <= $this->_sections['day_from']['total'];
                 $this->_sections['day_from']['index'] += $this->_sections['day_from']['step'], $this->_sections['day_from']['iteration']++):
$this->_sections['day_from']['rownum'] = $this->_sections['day_from']['iteration'];
$this->_sections['day_from']['index_prev'] = $this->_sections['day_from']['index'] - $this->_sections['day_from']['step'];
$this->_sections['day_from']['index_next'] = $this->_sections['day_from']['index'] + $this->_sections['day_from']['step'];
$this->_sections['day_from']['first']      = ($this->_sections['day_from']['iteration'] == 1);
$this->_sections['day_from']['last']       = ($this->_sections['day_from']['iteration'] == $this->_sections['day_from']['total']);
?>
                            <option value=<?php echo ((is_array($_tmp=$this->_sections['day_from']['index']+1)) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 <?php if (((is_array($_tmp=$this->_sections['day_from']['index']+1)) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == ((is_array($_tmp=$this->_tpl_vars['frm']['day_from'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>selected<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['day'][$this->_sections['day_from']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>

                            <?php endfor; endif; ?>
                            </select> 
                            <i></i></span></div></div>

    <div class="element-select"><label class="title"></label><div class="large"><span><select name="year_from" >
                            <?php unset($this->_sections['year_from']);
$this->_sections['year_from']['name'] = 'year_from';
$this->_sections['year_from']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['year'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['year_from']['show'] = true;
$this->_sections['year_from']['max'] = $this->_sections['year_from']['loop'];
$this->_sections['year_from']['step'] = 1;
$this->_sections['year_from']['start'] = $this->_sections['year_from']['step'] > 0 ? 0 : $this->_sections['year_from']['loop']-1;
if ($this->_sections['year_from']['show']) {
    $this->_sections['year_from']['total'] = $this->_sections['year_from']['loop'];
    if ($this->_sections['year_from']['total'] == 0)
        $this->_sections['year_from']['show'] = false;
} else
    $this->_sections['year_from']['total'] = 0;
if ($this->_sections['year_from']['show']):

            for ($this->_sections['year_from']['index'] = $this->_sections['year_from']['start'], $this->_sections['year_from']['iteration'] = 1;
                 $this->_sections['year_from']['iteration'] <= $this->_sections['year_from']['total'];
                 $this->_sections['year_from']['index'] += $this->_sections['year_from']['step'], $this->_sections['year_from']['iteration']++):
$this->_sections['year_from']['rownum'] = $this->_sections['year_from']['iteration'];
$this->_sections['year_from']['index_prev'] = $this->_sections['year_from']['index'] - $this->_sections['year_from']['step'];
$this->_sections['year_from']['index_next'] = $this->_sections['year_from']['index'] + $this->_sections['year_from']['step'];
$this->_sections['year_from']['first']      = ($this->_sections['year_from']['iteration'] == 1);
$this->_sections['year_from']['last']       = ($this->_sections['year_from']['iteration'] == $this->_sections['year_from']['total']);
?>
                            <option value=<?php echo ((is_array($_tmp=$this->_tpl_vars['year'][$this->_sections['year_from']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 <?php if (((is_array($_tmp=$this->_tpl_vars['year'][$this->_sections['year_from']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == ((is_array($_tmp=$this->_tpl_vars['frm']['year_from'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>selected<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['year'][$this->_sections['year_from']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>

                            <?php endfor; endif; ?>
                            </select><i></i></span></div></div>

    <div class="element-select"><label class="title">To:</label><div class="large"><span><select name="month_to" >

    <?php unset($this->_sections['month_to']);
$this->_sections['month_to']['name'] = 'month_to';
$this->_sections['month_to']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['month'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['month_to']['show'] = true;
$this->_sections['month_to']['max'] = $this->_sections['month_to']['loop'];
$this->_sections['month_to']['step'] = 1;
$this->_sections['month_to']['start'] = $this->_sections['month_to']['step'] > 0 ? 0 : $this->_sections['month_to']['loop']-1;
if ($this->_sections['month_to']['show']) {
    $this->_sections['month_to']['total'] = $this->_sections['month_to']['loop'];
    if ($this->_sections['month_to']['total'] == 0)
        $this->_sections['month_to']['show'] = false;
} else
    $this->_sections['month_to']['total'] = 0;
if ($this->_sections['month_to']['show']):

            for ($this->_sections['month_to']['index'] = $this->_sections['month_to']['start'], $this->_sections['month_to']['iteration'] = 1;
                 $this->_sections['month_to']['iteration'] <= $this->_sections['month_to']['total'];
                 $this->_sections['month_to']['index'] += $this->_sections['month_to']['step'], $this->_sections['month_to']['iteration']++):
$this->_sections['month_to']['rownum'] = $this->_sections['month_to']['iteration'];
$this->_sections['month_to']['index_prev'] = $this->_sections['month_to']['index'] - $this->_sections['month_to']['step'];
$this->_sections['month_to']['index_next'] = $this->_sections['month_to']['index'] + $this->_sections['month_to']['step'];
$this->_sections['month_to']['first']      = ($this->_sections['month_to']['iteration'] == 1);
$this->_sections['month_to']['last']       = ($this->_sections['month_to']['iteration'] == $this->_sections['month_to']['total']);
?>
                            <option value=<?php echo ((is_array($_tmp=$this->_sections['month_to']['index']+1)) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 <?php if (((is_array($_tmp=$this->_sections['month_to']['index']+1)) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == ((is_array($_tmp=$this->_tpl_vars['frm']['month_to'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>selected<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['month'][$this->_sections['month_to']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>

                            <?php endfor; endif; ?>
                            </select> 
    <i></i></span></div></div>

    <div class="element-select"><label class="title"></label><div class="large"><span><select name="day_to" >

    <?php unset($this->_sections['day_to']);
$this->_sections['day_to']['name'] = 'day_to';
$this->_sections['day_to']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['day'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['day_to']['show'] = true;
$this->_sections['day_to']['max'] = $this->_sections['day_to']['loop'];
$this->_sections['day_to']['step'] = 1;
$this->_sections['day_to']['start'] = $this->_sections['day_to']['step'] > 0 ? 0 : $this->_sections['day_to']['loop']-1;
if ($this->_sections['day_to']['show']) {
    $this->_sections['day_to']['total'] = $this->_sections['day_to']['loop'];
    if ($this->_sections['day_to']['total'] == 0)
        $this->_sections['day_to']['show'] = false;
} else
    $this->_sections['day_to']['total'] = 0;
if ($this->_sections['day_to']['show']):

            for ($this->_sections['day_to']['index'] = $this->_sections['day_to']['start'], $this->_sections['day_to']['iteration'] = 1;
                 $this->_sections['day_to']['iteration'] <= $this->_sections['day_to']['total'];
                 $this->_sections['day_to']['index'] += $this->_sections['day_to']['step'], $this->_sections['day_to']['iteration']++):
$this->_sections['day_to']['rownum'] = $this->_sections['day_to']['iteration'];
$this->_sections['day_to']['index_prev'] = $this->_sections['day_to']['index'] - $this->_sections['day_to']['step'];
$this->_sections['day_to']['index_next'] = $this->_sections['day_to']['index'] + $this->_sections['day_to']['step'];
$this->_sections['day_to']['first']      = ($this->_sections['day_to']['iteration'] == 1);
$this->_sections['day_to']['last']       = ($this->_sections['day_to']['iteration'] == $this->_sections['day_to']['total']);
?>
                            <option value=<?php echo ((is_array($_tmp=$this->_sections['day_to']['index']+1)) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 <?php if (((is_array($_tmp=$this->_sections['day_to']['index']+1)) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == ((is_array($_tmp=$this->_tpl_vars['frm']['day_to'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>selected<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['day'][$this->_sections['day_to']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>

                            <?php endfor; endif; ?>
                            </select>
    <i></i></span></div></div>

    <div class="element-select"><label class="title"></label><div class="large"><span><select name="year_to" >

    <?php unset($this->_sections['year_to']);
$this->_sections['year_to']['name'] = 'year_to';
$this->_sections['year_to']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['year'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['year_to']['show'] = true;
$this->_sections['year_to']['max'] = $this->_sections['year_to']['loop'];
$this->_sections['year_to']['step'] = 1;
$this->_sections['year_to']['start'] = $this->_sections['year_to']['step'] > 0 ? 0 : $this->_sections['year_to']['loop']-1;
if ($this->_sections['year_to']['show']) {
    $this->_sections['year_to']['total'] = $this->_sections['year_to']['loop'];
    if ($this->_sections['year_to']['total'] == 0)
        $this->_sections['year_to']['show'] = false;
} else
    $this->_sections['year_to']['total'] = 0;
if ($this->_sections['year_to']['show']):

            for ($this->_sections['year_to']['index'] = $this->_sections['year_to']['start'], $this->_sections['year_to']['iteration'] = 1;
                 $this->_sections['year_to']['iteration'] <= $this->_sections['year_to']['total'];
                 $this->_sections['year_to']['index'] += $this->_sections['year_to']['step'], $this->_sections['year_to']['iteration']++):
$this->_sections['year_to']['rownum'] = $this->_sections['year_to']['iteration'];
$this->_sections['year_to']['index_prev'] = $this->_sections['year_to']['index'] - $this->_sections['year_to']['step'];
$this->_sections['year_to']['index_next'] = $this->_sections['year_to']['index'] + $this->_sections['year_to']['step'];
$this->_sections['year_to']['first']      = ($this->_sections['year_to']['iteration'] == 1);
$this->_sections['year_to']['last']       = ($this->_sections['year_to']['iteration'] == $this->_sections['year_to']['total']);
?>
                            <option value=<?php echo ((is_array($_tmp=$this->_tpl_vars['year'][$this->_sections['year_to']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 <?php if (((is_array($_tmp=$this->_tpl_vars['year'][$this->_sections['year_to']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == ((is_array($_tmp=$this->_tpl_vars['frm']['year_to'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>selected<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['year'][$this->_sections['year_to']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>

                            <?php endfor; endif; ?>
                            </select>
    <i></i></span></div></div>
  <input type=hidden name=a value=earnings>
                            <input type=hidden name=page value=<?php echo ((is_array($_tmp=$this->_tpl_vars['current_page'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
>
<div class="submit"><input type="submit" value="Filter"/></div></form>

<script type="text/javascript" src="form/formoid1/formoid-default-skyblue.js"></script>
                            
    
                            <?php if (((is_array($_tmp=$this->_tpl_vars['settings']['use_history_balance_mode'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>
                            <table cellspacing=1 cellpadding=2 border=0 width=100%>
                            <tr>
                             <td class=inheader>Date</td>
                             <td class=inheader>Type</td>
                             <td class=inheader>Credit</td>
                             <td class=inheader>Debit</td>
                             <td class=inheader>Balance</td>
                             <td class=inheader>P.S.</td>
                            </tr>
                            <?php if (((is_array($_tmp=$this->_tpl_vars['qtrans'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?>
                            <?php unset($this->_sections['trans']);
$this->_sections['trans']['name'] = 'trans';
$this->_sections['trans']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['trans'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['trans']['show'] = true;
$this->_sections['trans']['max'] = $this->_sections['trans']['loop'];
$this->_sections['trans']['step'] = 1;
$this->_sections['trans']['start'] = $this->_sections['trans']['step'] > 0 ? 0 : $this->_sections['trans']['loop']-1;
if ($this->_sections['trans']['show']) {
    $this->_sections['trans']['total'] = $this->_sections['trans']['loop'];
    if ($this->_sections['trans']['total'] == 0)
        $this->_sections['trans']['show'] = false;
} else
    $this->_sections['trans']['total'] = 0;
if ($this->_sections['trans']['show']):

            for ($this->_sections['trans']['index'] = $this->_sections['trans']['start'], $this->_sections['trans']['iteration'] = 1;
                 $this->_sections['trans']['iteration'] <= $this->_sections['trans']['total'];
                 $this->_sections['trans']['index'] += $this->_sections['trans']['step'], $this->_sections['trans']['iteration']++):
$this->_sections['trans']['rownum'] = $this->_sections['trans']['iteration'];
$this->_sections['trans']['index_prev'] = $this->_sections['trans']['index'] - $this->_sections['trans']['step'];
$this->_sections['trans']['index_next'] = $this->_sections['trans']['index'] + $this->_sections['trans']['step'];
$this->_sections['trans']['first']      = ($this->_sections['trans']['iteration'] == 1);
$this->_sections['trans']['last']       = ($this->_sections['trans']['iteration'] == $this->_sections['trans']['total']);
?>
                            <tr>
                             <td align=center nowrap><?php echo ((is_array($_tmp=$this->_tpl_vars['trans'][$this->_sections['trans']['index']]['d'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</td>
                             <td><b><?php echo ((is_array($_tmp=$this->_tpl_vars['trans'][$this->_sections['trans']['index']]['transtype'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b><br><small class=gray><?php echo ((is_array($_tmp=$this->_tpl_vars['trans'][$this->_sections['trans']['index']]['description'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</small></td>
                             <td align=right><b>
                              <?php if (((is_array($_tmp=$this->_tpl_vars['trans'][$this->_sections['trans']['index']]['debitcredit'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 0): ?>
                              <?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['trans'][$this->_sections['trans']['index']]['actual_amount'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>

                              </b>
                              <?php else: ?>
                              &nbsp;
                              <?php endif; ?>
                             </td>
                             <td align=right><b>
                              <?php if (((is_array($_tmp=$this->_tpl_vars['trans'][$this->_sections['trans']['index']]['debitcredit'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 1): ?>
                              <?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['trans'][$this->_sections['trans']['index']]['actual_amount'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>

                              </b> 
                              <?php else: ?>
                              &nbsp;
                              <?php endif; ?>
                             </td>
                             <td align=right><b>
                              <?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['trans'][$this->_sections['trans']['index']]['balance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>

                             </td>
                             <td><img src="images/pay/<?php echo ((is_array($_tmp=$this->_tpl_vars['trans'][$this->_sections['trans']['index']]['ec'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
.gif" align=absmiddle hspace=1 height=21></td>
                            </tr>
                            <?php endfor; endif; ?>
                            <?php else: ?>
                            <tr>
                             <td colspan=6 align=center>No transactions found</td>
                            </tr>
                            <?php endif; ?>
                            <tr><td colspan=3>&nbsp;</td>

                            <?php if (((is_array($_tmp=$this->_tpl_vars['qtrans'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?>
                            <tr>
                             <td colspan=2>Total for this period:</td>
                             <td align=right nowrap><b><?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['periodcredit'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b></td>
                             <td align=right nowrap><b><?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['perioddebit'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b></td>
                             <td align=right nowrap><b><?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['periodbalance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b></td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                             <td colspan=2>Total:</td>
                             <td align=right nowrap><b><?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['allcredit'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b></td>
                             <td align=right nowrap><b><?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['alldebit'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b></td>
                             <td align=right nowrap><b><?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['allbalance'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b></td>
                            </tr>
                            </table>
                            <?php else: ?>
                            <table cellspacing=1 cellpadding=2 border=0 width=100%>
                            <tr>
                             <td class=inheader><b>Type</b></td>
                             <td class=inheader width=200><b>Amount</b></td>
                             <td class=inheader width=170><b>Date</b></td>
                            </tr>
                            <?php if (((is_array($_tmp=$this->_tpl_vars['qtrans'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?>
                            <?php unset($this->_sections['trans']);
$this->_sections['trans']['name'] = 'trans';
$this->_sections['trans']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['trans'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['trans']['show'] = true;
$this->_sections['trans']['max'] = $this->_sections['trans']['loop'];
$this->_sections['trans']['step'] = 1;
$this->_sections['trans']['start'] = $this->_sections['trans']['step'] > 0 ? 0 : $this->_sections['trans']['loop']-1;
if ($this->_sections['trans']['show']) {
    $this->_sections['trans']['total'] = $this->_sections['trans']['loop'];
    if ($this->_sections['trans']['total'] == 0)
        $this->_sections['trans']['show'] = false;
} else
    $this->_sections['trans']['total'] = 0;
if ($this->_sections['trans']['show']):

            for ($this->_sections['trans']['index'] = $this->_sections['trans']['start'], $this->_sections['trans']['iteration'] = 1;
                 $this->_sections['trans']['iteration'] <= $this->_sections['trans']['total'];
                 $this->_sections['trans']['index'] += $this->_sections['trans']['step'], $this->_sections['trans']['iteration']++):
$this->_sections['trans']['rownum'] = $this->_sections['trans']['iteration'];
$this->_sections['trans']['index_prev'] = $this->_sections['trans']['index'] - $this->_sections['trans']['step'];
$this->_sections['trans']['index_next'] = $this->_sections['trans']['index'] + $this->_sections['trans']['step'];
$this->_sections['trans']['first']      = ($this->_sections['trans']['iteration'] == 1);
$this->_sections['trans']['last']       = ($this->_sections['trans']['iteration'] == $this->_sections['trans']['total']);
?>
                            <tr>
                             <td><b><?php echo ((is_array($_tmp=$this->_tpl_vars['trans'][$this->_sections['trans']['index']]['transtype'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b></td>
                             <td width=200 align=right><b><?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['trans'][$this->_sections['trans']['index']]['actual_amount'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b> <img src="images/pay/<?php echo ((is_array($_tmp=$this->_tpl_vars['trans'][$this->_sections['trans']['index']]['ec'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
.gif" align=absmiddle hspace=1 height=21></td>
                             <td width=170 align=center valign=bottom><b><small><?php echo ((is_array($_tmp=$this->_tpl_vars['trans'][$this->_sections['trans']['index']]['d'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</small></b></td>
                            </tr>
                            <tr>
                             <td colspan=3 class=gray><small><?php echo ((is_array($_tmp=$this->_tpl_vars['trans'][$this->_sections['trans']['index']]['description'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</small></td>
                            </tr>
                            <?php endfor; endif; ?>
                            <?php else: ?>
                            <tr>
                             <td colspan=3 align=center>No transactions found</td>
                            </tr>
                            <?php endif; ?>
                            <tr><td colspan=3>&nbsp;</td>

                            <?php if (((is_array($_tmp=$this->_tpl_vars['qtrans'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?>
                            <tr>
                                <td colspan=2>For this period:</td>
                             <td align=right><b><?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['periodsum'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b></td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan=2>Total:</td>
                             <td align=right><b><?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['allsum'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b></td>
                            </tr>
                            </table>
                            <?php endif; ?>

                            <?php if (((is_array($_tmp=$this->_tpl_vars['colpages'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 1): ?>
                            <center>
                            <?php if (((is_array($_tmp=$this->_tpl_vars['prev_page'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?>
                             <button onclick="javascript:go('<?php echo ((is_array($_tmp=$this->_tpl_vars['prev_page'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
')" class="button sign-up-button">Prev</button>
                            <?php endif; ?>
                            <?php unset($this->_sections['p']);
$this->_sections['p']['name'] = 'p';
$this->_sections['p']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['pages'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                            <?php if (((is_array($_tmp=$this->_tpl_vars['pages'][$this->_sections['p']['index']]['current'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 1): ?>
                            <?php echo ((is_array($_tmp=$this->_tpl_vars['pages'][$this->_sections['p']['index']]['page'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>

                            <?php else: ?>
                             <button onclick="javascript:go('<?php echo ((is_array($_tmp=$this->_tpl_vars['pages'][$this->_sections['p']['index']]['page'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
')" class="button sign-up-button"><?php echo ((is_array($_tmp=$this->_tpl_vars['pages'][$this->_sections['p']['index']]['page'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</button>
                            <?php endif; ?>
                            <?php endfor; endif; ?>
                            <?php if (((is_array($_tmp=$this->_tpl_vars['next_page'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?>
                             <button class="button sign-up-button" onclick="javascript:go('<?php echo ((is_array($_tmp=$this->_tpl_vars['next_page'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
')">Next</button>
                            <?php endif; ?>
                            </center>
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