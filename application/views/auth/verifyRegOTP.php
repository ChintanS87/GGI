<?php
    $reg_OTP = array(
            'name'          => 'reg_OTP',
            'id'            => 'reg_OTP',
            'value'         => '',
            'maxlength'     => '10',
            'size'          => '50',
            'style'         => 'width:50%'
    );
?>
<?php echo form_open($this->uri->uri_string()); ?>
<table>
    <tr>
        <td><?php echo form_label('Registration OTP', $reg_OTP['id']); ?></td>
        <td><?php echo form_input($reg_OTP); ?></td>
        <td style="color: red;"><?php echo form_error($reg_OTP['name']); ?><?php //echo isset($referal_error)?$referal_error:''; ?></td>
    </tr>
    <tr>
        <td colspan="3" style="color: red;">
            <?php
                if ($error_msg !="")
                    echo $error_msg;
            ?>
        </td>
    </tr>    
</table>
<?php echo form_submit('verifyOTP', 'Verify OTP'); ?>
<?php echo form_close(); ?>