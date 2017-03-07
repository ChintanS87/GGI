<script language="javascript">
$(document).ready(function(){
    /*
    $("form").submit(function(){
        alert("Submitted");
    });
      */  
    $("#contact_number").change(function(){
        var contact_number = $('#contact_number').val();
        $.ajax({
            type:'POST',
            data:{contact_number: contact_number},
            url:'<?php echo site_url('getReferals/fetchData'); ?>',
            success: function(result){
                $('#result').html(result);
            }    
        });
    });
});
</script>
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
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
                'placeholder' => 'Username',
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
        'placeholder' => 'Email Address',
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
        'placeholder' => 'Password',
        'class' => 'stlyeRegFormElelments',
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
        'placeholder' => 'Confirm Password',
        'class' => 'stlyeRegFormElelments',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
$contact_number = array(
	'name'	=> 'contact_number',
	'id'	=> 'contact_number',
	'value'	=> set_value('contact_number'),
	'maxlength'	=> 10,
	'size'	=> 30,
        'placeholder' => 'Mobile Number',
);
$address = array(
	'name'	=> 'address',
	'id'	=> 'address',
	'value'	=> set_value('address'),
	'maxlength'	=> 500,
	'size'	=> 30,
        'placeholder' => 'Address',
        'class' => 'stlyeRegFormElelments',
);
$first_name = array(
	'name'	=> 'first_name',
	'id'	=> 'first_name',
	'value'	=> set_value('first_name'),
	'maxlength'	=> 30,
	'size'	=> 30,
        'placeholder' => 'First Name',
);
$last_name = array(
	'name'	=> 'last_name',
	'id'	=> 'last_name',
	'value'	=> set_value('last_name'),
	'maxlength'	=> 30,
	'size'	=> 30,
        'placeholder' => 'Last Name',
);

/*
$referal_code = array(
	'name'	=> 'referal_code',
	'id'	=> 'referal_code',
	'value'	=> set_value('referal_code'),
	'maxlength'	=> 10,
	'size'	=> 30,
);
 */

?>

<?php 
/*
echo form_open($this->uri->uri_string()); ?>
<table>
	<tr>
		<td><?php echo form_label('First Name', $first_name['id']); ?></td>
		<td><?php echo form_input($first_name); ?></td>
		<td style="color: red;"><?php echo form_error($first_name['name']); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Last Name', $last_name['id']); ?></td>
		<td><?php echo form_input($last_name); ?></td>
		<td style="color: red;"><?php echo form_error($last_name['name']); ?></td>
	</tr>        
	<?php if ($use_username) { ?>
	<tr>
		<td><?php echo form_label('Username', $username['id']); ?></td>
		<td><?php echo form_input($username); ?></td>
		<td style="color: red;"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td><?php echo form_label('Email Address', $email['id']); ?></td>
		<td><?php echo form_input($email); ?></td>
		<td style="color: red;"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Password', $password['id']); ?></td>
		<td><?php echo form_password($password); ?></td>
		<td style="color: red;"><?php echo form_error($password['name']); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Confirm Password', $confirm_password['id']); ?></td>
		<td><?php echo form_password($confirm_password); ?></td>
		<td style="color: red;"><?php echo form_error($confirm_password['name']); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Mobile Number', $contact_number['id']); ?></td>
		<td><?php echo form_input($contact_number); ?></td>
		<td style="color: red;"><?php echo form_error($contact_number['name']); ?><?php echo isset($mobile_exists_error)?$mobile_exists_error:''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Address', $address['id']); ?></td>
		<td><?php echo form_textarea($address); ?></td>
		<td style="color: red;"><?php echo form_error($address['name']); ?></td>
	</tr>
        <tr>
            <td><div id="resultText">Select a Referal Code to win Free coins</div></td>
            <td><div id="result" name="result"><?php echo $referalOptions; ?></div></td>
            <td style="color: red;"><?php echo isset($referal_error)?$referal_error:''; ?></td>                        
        </tr>

        <!--
        <tr>
		<td><?php //echo form_label('Referal code', $referal_code['id']); ?></td>
		<td><?php //echo form_input($referal_code); ?></td>
		<td style="color: red;"><?php //echo form_error($referal_code['name']); ?><?php //echo isset($referal_error)?$referal_error:''; ?></td>
	</tr>
        -->
        
	<?php if ($captcha_registration) {
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
        
        
</table>
<?php echo form_submit('register', 'Register'); ?>
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
                <aside class="col-md-8">
                    <!--Overview Contant Start-->
                    <div class="kf_overview_contant">
                        <!--Heading 1 Start-->
                        <h6 class="kf_hd1 margin_0">
                            <span>Register with Us</span>
                            <p style="line-height:29px; text-align:right; font-style: italic; font-weight:bold; padding-top:11px; padding-right:10px; ">New User? Fill the below details &amp; Get started! </p>
                        </h6>

                        <!--Heading 1 End-->
                    </div>
                    <!--Overview Contant End-->

                    <div style="margin-top:15px; border-width:1px;" class="kf_border">
                        <aside class="col-md-12">
                            <!--Overview Form Start-->
                            <div class="kf_overview_contant">
                                <?php echo form_open($this->uri->uri_string()); ?>
                                    <div class="input_dec">
                                        <?php echo form_input($first_name); ?>
                                        <span style="color: red;"><?php echo form_error($first_name['name']); ?></span>
                                    </div>
                                    <div class="input_dec">
                                        <?php echo form_input($last_name); ?>
                                        <span style="color: red;"><?php echo form_error($last_name['name']); ?></span>
                                    </div>
                                    <div class="input_dec">
                                        <?php echo form_input($email); ?>
                                        <span style="color: red;"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?></span>
                                    </div>
                        	<?php if ($use_username) { ?>
                                    <div class="input_dec">
                                        <?php echo form_input($username); ?>
                                        <span style="color: red;"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?></span>
                                    </div>
                        	<?php } ?>                                                                        
                                    
                                    <div class="input_dec">
                                        <?php echo form_password($password); ?>
                                        <span style="color: red;"><?php echo form_error($password['name']); ?></span>                                    
                                    </div>
                                    <div class="input_dec">
                                        <?php echo form_password($confirm_password); ?>
                                        <span style="color: red;"><?php echo form_error($confirm_password['name']); ?></span>                                        
                                    </div>
                                    <div class="input_dec">
                                        <?php echo form_input($contact_number); ?>
                        		<span style="color: red;"><?php echo form_error($contact_number['name']); ?><?php echo isset($mobile_exists_error)?$mobile_exists_error:''; ?></span>
                                    </div>
                                    <div class="input_dec">
                                        <?php echo form_textarea($address); ?>
                                        <span style="color: red;"><?php echo form_error($address['name']); ?></span>
                                    </div>

                                    <div class="input_dec">                                    
                                        <div id="resultText">Select a Referal Code to win Free coins</div>
                                        <div id="result" name="result"><?php echo $referalOptions; ?></div>
                                        <span style="color: red;"><?php echo isset($referal_error)?$referal_error:''; ?></span>                        
                                    </div>

        
                                    <?php if ($captcha_registration) {
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

<!--
                                    <div class="radio_style3">
                                        <label>
                                            <span class="radio">
                                                <input name="car_parking" value="90" type="radio">
                                                <span class="radio-value" aria-hidden="true"></span>
                                            </span>
                                            <span>I Accept <a href="#">Terms &amp; Conditions</a>'</span>
                                        </label>
                                    </div>
                                    <br/><br/>
-->
                                    <!--<div class="input_textarea">
                                        <textarea placeholder="Your Message"></textarea>
                                    </div>-->
                                    <input style="margin-top:25px;" class="input-btn" name="register" value="Register" type="submit">
                                    <?php //echo form_submit('register', 'Register'); ?>
                                <?php echo form_close(); ?>
                            </div>
                            <!--Overview Form End-->
                        </aside> 
                    </div>
                </aside>

            </div>
        </section>
    </div>
    <!--Main Content Wrap End-->