<?php /* Smarty version 2.6.19, created on 2013-12-30 22:02:13
         compiled from page_register_account.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'myescape', 'page_register_account.tpl', 22, false),array('modifier', 'escape', 'page_register_account.tpl', 101, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="page_title">
    <div class="container">
        <div class="sixteen columns">
            REGISTRATION
        </div>
    </div>
</div>


<div class="container about">
<!-- FEATURES -->
<div class="sixteen columns m-bot-25">
<h3 class="underlined"><span>REGISTER YOUR ACCOUNT</span></h3>
<div class="clearfix"></div>

<div class="container clearfix m-bot-35">
    <div class="sixteen columns">
        
   
 <?php if (((is_array($_tmp=$this->_tpl_vars['errors'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>
  <ul style="color:red">
  <?php unset($this->_sections['e']);
$this->_sections['e']['name'] = 'e';
$this->_sections['e']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['errors'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['e']['show'] = true;
$this->_sections['e']['max'] = $this->_sections['e']['loop'];
$this->_sections['e']['step'] = 1;
$this->_sections['e']['start'] = $this->_sections['e']['step'] > 0 ? 0 : $this->_sections['e']['loop']-1;
if ($this->_sections['e']['show']) {
    $this->_sections['e']['total'] = $this->_sections['e']['loop'];
    if ($this->_sections['e']['total'] == 0)
        $this->_sections['e']['show'] = false;
} else
    $this->_sections['e']['total'] = 0;
if ($this->_sections['e']['show']):

            for ($this->_sections['e']['index'] = $this->_sections['e']['start'], $this->_sections['e']['iteration'] = 1;
                 $this->_sections['e']['iteration'] <= $this->_sections['e']['total'];
                 $this->_sections['e']['index'] += $this->_sections['e']['step'], $this->_sections['e']['iteration']++):
$this->_sections['e']['rownum'] = $this->_sections['e']['iteration'];
$this->_sections['e']['index_prev'] = $this->_sections['e']['index'] - $this->_sections['e']['step'];
$this->_sections['e']['index_next'] = $this->_sections['e']['index'] + $this->_sections['e']['step'];
$this->_sections['e']['first']      = ($this->_sections['e']['iteration'] == 1);
$this->_sections['e']['last']       = ($this->_sections['e']['iteration'] == $this->_sections['e']['total']);
?> 
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'full_name'): ?>
    <li>Please enter your full name!
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'address'): ?>
    <li>Please enter your address!
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'city'): ?>
    <li>Please enter your city!
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'state'): ?>
    <li>Please enter your state!
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'zip'): ?>
    <li>Please enter your zip!
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'country'): ?>
    <li>Please choose your country!
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'username'): ?>
    <li>Please enter your username!
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'username_exists'): ?>
    <li>Sorry, such user already exists! Please try another username. 
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'email_exists'): ?>
    <li>Sorry, such email already exists! Please try another email. 
   <?php endif; ?> 
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'password'): ?> 
    <li>Please enter a password!
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'password_confirm'): ?>
    <li>Please check your password!
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'password_too_small'): ?>
    <li>The password you provided is too small, please enter at least <?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['min_user_password_length'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 characters!
   <?php endif; ?> 
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'transaction_code'): ?> 
    <li>Please enter the Transaction Code!
   <?php endif; ?> 
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'transaction_code_confirm'): ?> 
    <li>Please check your Transaction Code!
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'transaction_code_too_small'): ?>
    <li>The Transaction Code you provided is too small, please enter at least <?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['min_user_password_length'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 characters!   
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'transaction_code_vs_password'): ?> 
    <li>The Transaction Code should differ from the Password!
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'egold'): ?> 
    <li>Please enter your e-gold account number!
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'email'): ?> 
    <li>Please enter your e-mail!
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'agree'): ?>
    <li>You have to agree with the Terms and Conditions!
   <?php endif; ?>
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'turing_image'): ?>
    <li>Enter the verification code as it is shown in the corresponding box.
   <?php endif; ?> 
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'no_upline'): ?>
    <li>The system requires an upline to register. <?php if (((is_array($_tmp=$this->_tpl_vars['settings']['get_rand_ref'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>You have to be agreed to random one or found a referral link in the net.<?php endif; ?>
   <?php endif; ?> 
   <?php if (((is_array($_tmp=$this->_tpl_vars['errors'][$this->_sections['e']['index']])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == 'ip_exists_in_database'): ?>
    <li>Your IP already exists in our database. Sorry, but registration is impossible.
   <?php endif; ?>
   <br> 
  <?php endfor; endif; ?>
  </ul>
 <?php endif; ?> 


<link rel="stylesheet" href="form/formoid1/formoid-default-skyblue.css" type="text/css" />
<script type="text/javascript" src="form/formoid1/jquery.min.js"></script>
<form class="formoid-default-skyblue" style="background-color:#EEEEEE;font-size:16px;font-family:'Open Sans',Arial,Verdana,sans-serif;color:#666666;max-width:900px;min-width:150px" method="post" onsubmit="return checkform()" name="regform" action="page_register_account.php"><div class="title"><h2>Your Information:</h2></div>
  <input type=hidden name=action value="signup">
  <div class="element-input"  title="Please write your full name"><label class="title">Full Name<span class="required">*</span></label><input class="large" type="text" name=fullname value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['frm']['fullname'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
" required="required"/></div>
  <div class="element-input"  title="Please write your email address"><label class="title">Email Address<span class="required">*</span></label><input class="large" type="text" name=email value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['frm']['email'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
" required="required"/></div>
  <div class="element-input"  title="Please write your email address"><label class="title">Confirm Email Address<span class="required">*</span></label><input class="large" type="text" name=email1 value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['frm']['email1'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
" required="required"/></div>
  <div class="element-input"  title="Please enter your username"><label class="title">Username<span class="required">*</span></label><input class="large" type="text" name=username value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['frm']['username'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
" required="required"/></div>
  <div class="element-password"  title="Please enter your password"><label class="title">Password<span class="required">*</span></label><input class="large" type="password" name=password value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['frm']['password'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
" value="" required="required"/></div>
  <div class="element-password"  title="Please re-enter your password"><label class="title">Confirm Password<span class="required">*</span></label><input class="large" type="password" name=password2 value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['frm']['password2'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
" value="" required="required"/></div>
  <div class="element-input"  title="This is the name of the person who referred you"><label class="title">Referrer</label><input class="large" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['referer']['name'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
 (<?php if (((is_array($_tmp=$this->_tpl_vars['referer']['username'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)) == ''): ?>None<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['referer']['username'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp)); ?>
<?php endif; ?>)" disabled /></div>
  <div class="element-address" ><label class="title">Address (Optional)</label><span class="addr1"><input type="text" name="address[addr1]" /><label>Street Address</label></span><span class="addr2"><input type="text" name="address[addr2]" /><label>Address Line 2</label></span><span class="city"><input type="text" name="address[city]" /><label>City</label></span><span class="state"><input type="text" name="address[state]" /><label>State / Province / Region</label></span><span class="zip"><input type="text" maxlength="15" name="address[zip]" /><label>Postal / Zip Code</label></span><div class="country"><select name="address[country]" ><option selected="selected" value="" disabled="disabled">--- Select a country ---</option><option value="United States">United States</option><option value="United Kingdom">United Kingdom</option><option value="Australia">Australia</option><option value="Canada">Canada</option><option value="France">France</option><option value="New Zealand">New Zealand</option><option value="India">India</option><option value="Brazil">Brazil</option><option value="----" disabled="disabled">----</option><option value="Afghanistan">Afghanistan</option><option value="Aland Islands">Aland Islands</option><option value="Albania">Albania</option><option value="Algeria">Algeria</option><option value="American Samoa">American Samoa</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antarctica">Antarctica</option><option value="Antigua and Barbuda">Antigua and Barbuda</option><option value="Argentina">Argentina</option><option value="Armenia">Armenia</option><option value="Aruba">Aruba</option><option value="Austria">Austria</option><option value="Azerbaijan">Azerbaijan</option><option value="Bahamas">Bahamas</option><option value="Bahrain">Bahrain</option><option value="Bangladesh">Bangladesh</option><option value="Barbados">Barbados</option><option value="Belarus">Belarus</option><option value="Belgium">Belgium</option><option value="Belize">Belize</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Bhutan">Bhutan</option><option value="Bolivia">Bolivia</option><option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option><option value="Botswana">Botswana</option><option value="British Indian Ocean Territory">British Indian Ocean Territory</option><option value="Brunei Darussalam">Brunei Darussalam</option><option value="Bulgaria">Bulgaria</option><option value="Burkina Faso">Burkina Faso</option><option value="Burundi">Burundi</option><option value="Cambodia">Cambodia</option><option value="Cameroon">Cameroon</option><option value="Cape Verde">Cape Verde</option><option value="Cayman Islands">Cayman Islands</option><option value="Central African Republic">Central African Republic</option><option value="Chad">Chad</option><option value="Chile">Chile</option><option value="China">China</option><option value="Colombia">Colombia</option><option value="Comoros">Comoros</option><option value="Democratic Republic of the Congo">Democratic Republic of the Congo</option><option value="Republic of the Congo">Republic of the Congo</option><option value="Cook Islands">Cook Islands</option><option value="Costa Rica">Costa Rica</option><option value="Cote d'Ivoire">Cote d'Ivoire</option><option value="Croatia">Croatia</option><option value="Cuba">Cuba</option><option value="Cyprus">Cyprus</option><option value="Czech Republic">Czech Republic</option><option value="Denmark">Denmark</option><option value="Djibouti">Djibouti</option><option value="Dominica">Dominica</option><option value="Dominican Republic">Dominican Republic</option><option value="East Timor">East Timor</option><option value="Ecuador">Ecuador</option><option value="Egypt">Egypt</option><option value="El Salvador">El Salvador</option><option value="Equatorial Guinea">Equatorial Guinea</option><option value="Eritrea">Eritrea</option><option value="Estonia">Estonia</option><option value="Ethiopia">Ethiopia</option><option value="Faroe Islands">Faroe Islands</option><option value="Fiji">Fiji</option><option value="Finland">Finland</option><option value="Gabon">Gabon</option><option value="Gambia">Gambia</option><option value="Georgia">Georgia</option><option value="Germany">Germany</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Greece">Greece</option><option value="Grenada">Grenada</option><option value="Guatemala">Guatemala</option><option value="Guinea">Guinea</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Guyana">Guyana</option><option value="Haiti">Haiti</option><option value="Honduras">Honduras</option><option value="Hong Kong">Hong Kong</option><option value="Hungary">Hungary</option><option value="Iceland">Iceland</option><option value="Indonesia">Indonesia</option><option value="Iran">Iran</option><option value="Iraq">Iraq</option><option value="Ireland">Ireland</option><option value="Israel">Israel</option><option value="Italy">Italy</option><option value="Jamaica">Jamaica</option><option value="Japan">Japan</option><option value="Jordan">Jordan</option><option value="Kazakhstan">Kazakhstan</option><option value="Kenya">Kenya</option><option value="Kiribati">Kiribati</option><option value="North Korea">North Korea</option><option value="South Korea">South Korea</option><option value="Kuwait">Kuwait</option><option value="Kyrgyzstan">Kyrgyzstan</option><option value="Laos">Laos</option><option value="Latvia">Latvia</option><option value="Lebanon">Lebanon</option><option value="Lesotho">Lesotho</option><option value="Liberia">Liberia</option><option value="Libya">Libya</option><option value="Liechtenstein">Liechtenstein</option><option value="Lithuania">Lithuania</option><option value="Luxembourg">Luxembourg</option><option value="Macedonia">Macedonia</option><option value="Madagascar">Madagascar</option><option value="Malawi">Malawi</option><option value="Malaysia">Malaysia</option><option value="Maldives">Maldives</option><option value="Mali">Mali</option><option value="Malta">Malta</option><option value="Marshall Islands">Marshall Islands</option><option value="Mauritania">Mauritania</option><option value="Mauritius">Mauritius</option><option value="Mexico">Mexico</option><option value="Micronesia">Micronesia</option><option value="Moldova">Moldova</option><option value="Monaco">Monaco</option><option value="Mongolia">Mongolia</option><option value="Montenegro">Montenegro</option><option value="Morocco">Morocco</option><option value="Mozambique">Mozambique</option><option value="Myanmar">Myanmar</option><option value="Namibia">Namibia</option><option value="Nauru">Nauru</option><option value="Nepal">Nepal</option><option value="Netherlands">Netherlands</option><option value="Netherlands Antilles">Netherlands Antilles</option><option value="Nicaragua">Nicaragua</option><option value="Niger">Niger</option><option value="Nigeria">Nigeria</option><option value="Norway">Norway</option><option value="Oman">Oman</option><option value="Pakistan">Pakistan</option><option value="Palau">Palau</option><option value="Palestine">Palestine</option><option value="Panama">Panama</option><option value="Papua New Guinea">Papua New Guinea</option><option value="Paraguay">Paraguay</option><option value="Peru">Peru</option><option value="Philippines">Philippines</option><option value="Poland">Poland</option><option value="Portugal">Portugal</option><option value="Puerto Rico">Puerto Rico</option><option value="Qatar">Qatar</option><option value="Romania">Romania</option><option value="Russia">Russia</option><option value="Rwanda">Rwanda</option><option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option><option value="Saint Lucia">Saint Lucia</option><option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option><option value="Samoa">Samoa</option><option value="San Marino">San Marino</option><option value="Sao Tome and Principe">Sao Tome and Principe</option><option value="Saudi Arabia">Saudi Arabia</option><option value="Senegal">Senegal</option><option value="Serbia">Serbia</option><option value="Seychelles">Seychelles</option><option value="Sierra Leone">Sierra Leone</option><option value="Singapore">Singapore</option><option value="Slovakia">Slovakia</option><option value="Slovenia">Slovenia</option><option value="Solomon Islands">Solomon Islands</option><option value="Somalia">Somalia</option><option value="South Africa">South Africa</option><option value="Spain">Spain</option><option value="Sri Lanka">Sri Lanka</option><option value="Sudan">Sudan</option><option value="Suriname">Suriname</option><option value="Swaziland">Swaziland</option><option value="Sweden">Sweden</option><option value="Switzerland">Switzerland</option><option value="Syria">Syria</option><option value="Taiwan">Taiwan</option><option value="Tajikistan">Tajikistan</option><option value="Tanzania">Tanzania</option><option value="Thailand">Thailand</option><option value="Togo">Togo</option><option value="Tonga">Tonga</option><option value="Trinidad and Tobago">Trinidad and Tobago</option><option value="Tunisia">Tunisia</option><option value="Turkey">Turkey</option><option value="Turkmenistan">Turkmenistan</option><option value="Tuvalu">Tuvalu</option><option value="Uganda">Uganda</option><option value="Ukraine">Ukraine</option><option value="United Arab Emirates">United Arab Emirates</option><option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option><option value="Uruguay">Uruguay</option><option value="Uzbekistan">Uzbekistan</option><option value="Vanuatu">Vanuatu</option><option value="Vatican City">Vatican City</option><option value="Venezuela">Venezuela</option><option value="Vietnam">Vietnam</option><option value="Virgin Islands, British">Virgin Islands, British</option><option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option><option value="Yemen">Yemen</option><option value="Zambia">Zambia</option><option value="Zimbabwe">Zimbabwe</option></select><i></i><label>Country</label></div></div>
  <div class="element-date" ><label class="title">Date Of Birth (Optional)</label><input class="large" placeholder="yyyy-mm-dd" type="date" name="date" /></div>
  <div class="element-checkbox"><div class="column column1"><input type="checkbox" name="agree" value=1 <?php if (((is_array($_tmp=$this->_tpl_vars['frm']['agree'])) ? $this->_run_mod_handler('myescape', true, $_tmp) : smarty_modifier_myescape($_tmp))): ?>checked<?php endif; ?> /><span>I have read the <a href=page_terms.php>terms and conditions</a></span><br/></div><span class="clearfix"></span></div>
  
<div class="submit"><input type="submit" value="Register"/></div></form>
<script type="text/javascript" src="form/formoid1/formoid-default-skyblue.js"></script>

    

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