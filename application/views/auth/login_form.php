<style>
    .stlyeRegFormElelments{
    float: left;
    width: 100%;
    text-align: left;
    min-height: 35px;
    -moz-appearance: none;
    -webkit-appearance: none;
    padding: 7px 25px 7px;
    border: 1px solid #d7d8d8;
    text-transform: capitalize;        
    }
</style>    


<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
        'placeholder'=>'Username',
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or login';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
        'placeholder'=>'Password',
        'class' => 'stlyeRegFormElelments',
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>



<?php 
/*
echo form_open($this->uri->uri_string()); ?>
<table>
	<tr>
		<td><?php echo form_label($login_label, $login['id']); ?></td>
		<td><?php echo form_input($login); ?></td>
		<td style="color: red;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Password', $password['id']); ?></td>
		<td><?php echo form_password($password); ?></td>
		<td style="color: red;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?></td>
	</tr>

	<?php if ($show_captcha) {
		if ($use_recaptcha) { ?>
	<tr>
		<td colspan="2">
			<div id="recaptcha_image"></div>
		</td>
		<td>
			<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
			<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
			<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="recaptcha_only_if_image">Enter the words above</div>
			<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
		</td>
		<td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
		<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
		<?php echo $recaptcha_html; ?>
	</tr>
	<?php } else { ?>
	<tr>
		<td colspan="3">
			<p>Enter the code exactly as it appears:</p>
			<?php echo $captcha_html; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
		<td><?php echo form_input($captcha); ?></td>
		<td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
	</tr>
	<?php }
	} ?>

	<tr>
		<td colspan="3">
			<?php echo form_checkbox($remember); ?>
			<?php echo form_label('Remember me', $remember['id']); ?>
			<?php echo anchor('/auth/forgot_password/', 'Forgot password'); ?>
			<?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register'); ?>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<?php echo anchor('/account/facebook_auth/', 'Facebook Login'); ?>
		</td>
	</tr>        
</table>
<?php echo form_submit('submit', 'Let me in'); ?>
<?php echo form_close(); 
 */
?>
 






    <!--Inner Banner Start-->
    <div class="innner_banner">
        <div class="container">
            <h3>Register / Login</h3>
            <span>Register with us and get started!</span><br/>
        </div>
    </div>
    <!--Inner Banner End-->
    <div class="kode_content_wrap">
        <section class="team_schedule_page">
            <div class="container">

                <aside class="col-md-4">
                    <!--Overview Contant Start-->
                    <div class="kf_overview_contant">
                        <!--Heading 1 Start-->
                        <h6 class="kf_hd1 margin_0">
                            <span>Login</span>
                            <p style="line-height:29px; text-align:right; font-style: italic; font-weight:bold; padding-right:10px; padding-top:11px;">Already Registered? Login here!</p>
                        </h6>
                        <!--Heading 1 End-->
                    </div>
                    <!--Overview Contant End-->
                    <?php echo form_open($this->uri->uri_string()); ?>
                    



                    <div style="margin-top:15px; border-width:1px;" class="kf_border">
                        <div class="newsletter_dec">
                            <div class="input_dec">
                                <?php echo form_input($login); ?>
                                <span style="color: red;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></span>
                            </div>
                            <div class="input_dec">
                                <?php echo form_password($password); ?>
                                <span style="color: red;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?></span>
                            </div>
                            <input class="input-btn" value="Login" type="submit" name="submit">
                            <em> <a href="<?php echo site_url('/auth/forgot_password/') ?>"> Forgot Password? </a></em> 
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    
                    

                    <div class="widget widget_social">
                        <a class="facebook" href="#">
                            <i class="fa fa-facebook"></i>
                            <span>Like Page</span>
                            <em>3265 Likes</em>
                        </a>
                        <a class="twitter" href="#">
                            <i class="fa fa-twitter"></i>
                            <span>Follow us</span>
                            <em>3265 Likes</em>
                        </a>
                        <a style="margin-top:15px;" class="rss" href="#">
                            <i class="fa fa-rss"></i>
                            <span>Subscribe</span>
                            <em>3265 Likes</em>
                        </a>
                    </div>
                </aside>
            </div>
        </section>
    </div>
    <!--Main Content Wrap End-->
