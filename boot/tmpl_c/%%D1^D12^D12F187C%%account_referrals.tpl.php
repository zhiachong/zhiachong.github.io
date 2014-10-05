<?php /* Smarty version 2.6.19, created on 2013-12-17 23:03:53
         compiled from account_referrals.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'myescape', 'account_referrals.tpl', 22, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

 <div class="page_title">
        <div class="container">
            <div class="sixteen columns">
                REFERRAL STATISTICS
            </div>
        </div>
 </div>

<div class="container ">
    <div class="sixteen columns m-bot-25">
            <h3 class="underlined"><span>Referrals</span></h3>
            <div class="clearfix"></div>
            <br/>
            <br/>
            <div class="w1">
                <section id="main-all">
                    <div id="content">
                              <h3>Your Referrals</h3>

<?php if (((is_array($_tmp=$this->_tpl_vars['upline']['email'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) != ""): ?>
<center><p>Your upline is <a href=mailto:<?php echo ((is_array($_tmp=$this->_tpl_vars['upline']['email'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
><?php echo ((is_array($_tmp=$this->_tpl_vars['upline']['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</a></p></center>
<?php endif; ?>
<br>
<table width=300 cellspacing=1 cellpadding=1>
<tr>
  <td class=item>Referrals:</td>
  <td class=item><?php echo ((is_array($_tmp=$this->_tpl_vars['total_ref'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</td>
</tr><tr>
  <td class=item>Active referrals:</td>
  <td class=item><?php echo ((is_array($_tmp=$this->_tpl_vars['active_ref'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</td>
</tr><tr>
  <td class=item>Total referral commission:</td>
  <td class=item><?php echo ((is_array($_tmp=$this->_tpl_vars['currency_sign'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['commissions'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</td>
</tr>
</table>
<br>
<?php if (((is_array($_tmp=$this->_tpl_vars['settings']['show_refstat'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>


                              <link rel="stylesheet" href="form/formoid1/formoid-default-skyblue.css" type="text/css" />
<script type="text/javascript" src="form/formoid1/jquery.min.js"></script>

<form class="formoid-default-skyblue" style="margin-left:50px;background-color:#FFFFFF;font-size:16px;font-family:'Open Sans',Arial,Verdana,sans-serif;color:#666666;max-width:900px;min-width:150px" method="post" onsubmit="return checkform()" name=opts action="account_referrals.php"><div class="title"><h2>Referral Statistics:</h2></div>
     <div class="element-select"><label class="title"></label><div class="large"><span>

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
</option>
                            <?php endfor; endif; ?>
                            </select> 
                            <i></i></span></div></div>
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
</option>
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
</option>
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
</option>
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
</option>
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
</option>
                            <?php endfor; endif; ?>
                            </select>
    <i></i></span></div></div>
  
<div class="submit"><input type="submit" value="Filter"/></div>
</span></div></div></form>


<script type="text/javascript" src="form/formoid1/formoid-default-skyblue.js"></script>

<table width=300 celspacing=1 cellpadding=1 border=0>
<tr>
 <td class=inheader>Date</td>
 <td class=inheader>Ins</td>
 <td class=inheader>Signups</td>
</tr>
<?php if (((is_array($_tmp=$this->_tpl_vars['show_refstat'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>
<?php unset($this->_sections['s']);
$this->_sections['s']['name'] = 's';
$this->_sections['s']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['refstat'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['s']['show'] = true;
$this->_sections['s']['max'] = $this->_sections['s']['loop'];
$this->_sections['s']['step'] = 1;
$this->_sections['s']['start'] = $this->_sections['s']['step'] > 0 ? 0 : $this->_sections['s']['loop']-1;
if ($this->_sections['s']['show']) {
    $this->_sections['s']['total'] = $this->_sections['s']['loop'];
    if ($this->_sections['s']['total'] == 0)
        $this->_sections['s']['show'] = false;
} else
    $this->_sections['s']['total'] = 0;
if ($this->_sections['s']['show']):

            for ($this->_sections['s']['index'] = $this->_sections['s']['start'], $this->_sections['s']['iteration'] = 1;
                 $this->_sections['s']['iteration'] <= $this->_sections['s']['total'];
                 $this->_sections['s']['index'] += $this->_sections['s']['step'], $this->_sections['s']['iteration']++):
$this->_sections['s']['rownum'] = $this->_sections['s']['iteration'];
$this->_sections['s']['index_prev'] = $this->_sections['s']['index'] - $this->_sections['s']['step'];
$this->_sections['s']['index_next'] = $this->_sections['s']['index'] + $this->_sections['s']['step'];
$this->_sections['s']['first']      = ($this->_sections['s']['iteration'] == 1);
$this->_sections['s']['last']       = ($this->_sections['s']['iteration'] == $this->_sections['s']['total']);
?>
<tr>
 <td class=item align=center><b><?php echo ((is_array($_tmp=$this->_tpl_vars['refstat'][$this->_sections['s']['index']]['date'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b></td>
 <td class=item align=right><?php echo ((is_array($_tmp=$this->_tpl_vars['refstat'][$this->_sections['s']['index']]['income'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</td>
 <td class=item align=right><?php echo ((is_array($_tmp=$this->_tpl_vars['refstat'][$this->_sections['s']['index']]['reg'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</td>
</tr>
<?php endfor; endif; ?>
<?php else: ?>
<tr>
 <td class=item align=center colspan=3>No statistics found for this period.</td>
</tr>
<?php endif; ?>
</table><br>
<?php endif; ?>

<?php if (((is_array($_tmp=$this->_tpl_vars['settings']['show_referals'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>
<?php if (((is_array($_tmp=$this->_tpl_vars['show_referals'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>
<h3>Your referrals:</h3>
<table cellspacing=1 cellpadding=1 border=0>
<tr>
 <td class=inheader>Nickname</td>
 <td class=inheader>E-mail</td>
 <td class=inheader>Status</td>
</tr>
<?php unset($this->_sections['s']);
$this->_sections['s']['name'] = 's';
$this->_sections['s']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['referals'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['s']['show'] = true;
$this->_sections['s']['max'] = $this->_sections['s']['loop'];
$this->_sections['s']['step'] = 1;
$this->_sections['s']['start'] = $this->_sections['s']['step'] > 0 ? 0 : $this->_sections['s']['loop']-1;
if ($this->_sections['s']['show']) {
    $this->_sections['s']['total'] = $this->_sections['s']['loop'];
    if ($this->_sections['s']['total'] == 0)
        $this->_sections['s']['show'] = false;
} else
    $this->_sections['s']['total'] = 0;
if ($this->_sections['s']['show']):

            for ($this->_sections['s']['index'] = $this->_sections['s']['start'], $this->_sections['s']['iteration'] = 1;
                 $this->_sections['s']['iteration'] <= $this->_sections['s']['total'];
                 $this->_sections['s']['index'] += $this->_sections['s']['step'], $this->_sections['s']['iteration']++):
$this->_sections['s']['rownum'] = $this->_sections['s']['iteration'];
$this->_sections['s']['index_prev'] = $this->_sections['s']['index'] - $this->_sections['s']['step'];
$this->_sections['s']['index_next'] = $this->_sections['s']['index'] + $this->_sections['s']['step'];
$this->_sections['s']['first']      = ($this->_sections['s']['iteration'] == 1);
$this->_sections['s']['last']       = ($this->_sections['s']['iteration'] == $this->_sections['s']['total']);
?>
<tr>
 <td><b><?php echo ((is_array($_tmp=$this->_tpl_vars['referals'][$this->_sections['s']['index']]['username'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</b></td>
 <td><a href=mailto:<?php echo ((is_array($_tmp=$this->_tpl_vars['referals'][$this->_sections['s']['index']]['email'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
><?php echo ((is_array($_tmp=$this->_tpl_vars['referals'][$this->_sections['s']['index']]['email'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
</a></td>
 <td><?php if (((is_array($_tmp=$this->_tpl_vars['referals'][$this->_sections['s']['index']]['q_deposits'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) > 0): ?>Deposited<?php else: ?>No deposit yet<?php endif; ?></td>
</tr>
<?php if (((is_array($_tmp=$this->_tpl_vars['referals'][$this->_sections['s']['index']]['ref_stats'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>
<tr>
 <td colspan=3>
  User referrals:
  <?php unset($this->_sections['l']);
$this->_sections['l']['name'] = 'l';
$this->_sections['l']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['referals'][$this->_sections['s']['index']]['ref_stats'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['l']['show'] = true;
$this->_sections['l']['max'] = $this->_sections['l']['loop'];
$this->_sections['l']['step'] = 1;
$this->_sections['l']['start'] = $this->_sections['l']['step'] > 0 ? 0 : $this->_sections['l']['loop']-1;
if ($this->_sections['l']['show']) {
    $this->_sections['l']['total'] = $this->_sections['l']['loop'];
    if ($this->_sections['l']['total'] == 0)
        $this->_sections['l']['show'] = false;
} else
    $this->_sections['l']['total'] = 0;
if ($this->_sections['l']['show']):

            for ($this->_sections['l']['index'] = $this->_sections['l']['start'], $this->_sections['l']['iteration'] = 1;
                 $this->_sections['l']['iteration'] <= $this->_sections['l']['total'];
                 $this->_sections['l']['index'] += $this->_sections['l']['step'], $this->_sections['l']['iteration']++):
$this->_sections['l']['rownum'] = $this->_sections['l']['iteration'];
$this->_sections['l']['index_prev'] = $this->_sections['l']['index'] - $this->_sections['l']['step'];
$this->_sections['l']['index_next'] = $this->_sections['l']['index'] + $this->_sections['l']['step'];
$this->_sections['l']['first']      = ($this->_sections['l']['iteration'] == 1);
$this->_sections['l']['last']       = ($this->_sections['l']['iteration'] == $this->_sections['l']['total']);
?>
   <nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['referals'][$this->_sections['s']['index']]['ref_stats'][$this->_sections['l']['index']]['cnt_active'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 active of <?php echo ((is_array($_tmp=$this->_tpl_vars['referals'][$this->_sections['s']['index']]['ref_stats'][$this->_sections['l']['index']]['cnt'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 on level <?php echo ((is_array($_tmp=$this->_tpl_vars['referals'][$this->_sections['s']['index']]['ref_stats'][$this->_sections['l']['index']]['level'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php if (! ((is_array($_tmp=$this->_sections['l']['last'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>;<?php endif; ?></nobr>
  <?php endfor; endif; ?>
 </td>
</tr>
<?php endif; ?>
<?php if (((is_array($_tmp=$this->_tpl_vars['referals'][$this->_sections['s']['index']]['came_from'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>
<tr><td colspan=3>
<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['referals'][$this->_sections['s']['index']]['came_from'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
" target=_blank>[User came from]</a>
</td></tr>
<?php endif; ?>
<?php endfor; endif; ?>
</table>
<?php endif; ?>
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