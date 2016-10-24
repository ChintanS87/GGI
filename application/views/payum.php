

<table>
    <tr>
        <td colspan="2">Your details are as below:</td>
    </tr>
    <tr>
        <td>Transaction ID:</td>
        <td><?php echo $txnid; ?></td>
    </tr>
    <tr>
        <td>Amount</td>
        <td><?php echo $amount; ?></td>
    </tr>
    <tr>
        <td>Product Info:</td>
        <td><?php echo $productinfo; ?></td>
    </tr>
    <tr>
        <td>First Name:</td>
        <td><?php echo $firstname; ?></td>
    </tr>
    <tr>
        <td>Email:</td>
        <td><?php echo $email; ?></td>
    </tr>
    <tr>
        <td>Contact Number:</td>
        <td><?php echo $phone; ?></td>
    </tr>
    
</table>
<?php
$hash_string = $key."|".$txnid."|".$amount."|".$productinfo."|".$firstname."|".$email."|||||||||||".$SALT;
$hash = hash('sha512', $hash_string);


    $hidden = array('key' => $key, 'hash' => $hash, 'txnid' => $txnid, 'amount' => $amount, 'firstname' => $firstname, 'email' => $email, 'phone' => $phone, 'productinfo' => $productinfo, 'surl' => $surl, 'furl' => $furl, 'service_provider' => 'payu_paisa');
    echo form_open("https://secure.payu.in/_payment",'',$hidden);
    echo form_submit('submit_purchase','Proceed to Payment');
    echo form_close(); 

?>
