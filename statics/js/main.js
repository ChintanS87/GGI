$(document).ready(function () {
 
    $('#btn_500').click(function(){
        $('#purchase_form_coins').val(500);
        //$('#purchase_form_amount').val(1500);
        $('#purchase_form_amount').val(1);
        $('#purchase_coins_form').submit();       
    });
    $('#btn_1000').click(function(){
        $('#purchase_form_coins').val(1000);
        //$('#purchase_form_amount').val(3000);
        $('#purchase_form_amount').val(1);
        $('#purchase_coins_form').submit();        
    });
    $('#btn_2000').click(function(){
        $('#purchase_form_coins').val(2000);
        //$('#purchase_form_amount').val(5000);
        $('#purchase_form_amount').val(1);
        $('#purchase_coins_form').submit();        
    });    
});

