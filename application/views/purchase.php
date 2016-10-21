<?php 
    $attributes = array('class' => 'form', 'id' => 'purchase_coins_form');
    echo form_open($this->uri->uri_string(),$attributes); 
?>
<table>
    <input type="hidden" name="purchase_form_amount" id="purchase_form_amount" value="" />
    <input type="hidden" name="purchase_form_coins" id="purchase_form_coins" value="" />
    <tr>
        <td><label>Buy 500 coins - Rs 1500/-</label></td>
        <td><input type="button" name="btn_500" id="btn_500" value="Buy 500 Coins" /></td>        
    </tr> 
    <tr>
        <td><label>Buy 1000 coins - Rs 3000/-</label></td>
        <td><input type="button" name="btn_1000" id="btn_1000" value="Buy 1000 Coins" /></td>        
    </tr> 
    <tr>
        <td><label>Buy 2000 coins - Rs 5000/-</label></td>
        <td><input type="button" name="btn_2000" id="btn_2000" value="Buy 2000 Coins" /></td>        
    </tr>     
</table>
<?php echo form_close(); ?>


    

