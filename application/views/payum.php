    
<?php
echo $amount;


$hash_string = $key."|".$txnid."|".$amount."|".$productinfo."|".$firstname."|".$email."|||||||||||".$SALT;
$hash = hash('sha512', $hash_string);

echo $hash_string;
echo $hash;

    $hidden = array('key' => $key, 'hash' => $hash, 'txnid' => $txnid, 'amount' => $amount, 'firstname' => $firstname, 'email' => $email, 'phone' => $phone, 'productinfo' => $productinfo, 'surl' => $surl, 'furl' => $furl, 'service_provider' => 'payu_paisa');
    echo form_open("https://secure.payu.in/_payment",'',$hidden);
    echo form_submit('submit_purchase','Buy Now!');
    echo form_close(); 

?>
