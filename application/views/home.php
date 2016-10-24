<!--
Hi, <strong>
    <?php //echo $username; ?>
</strong>! You are logged in now. 
    <?php //echo anchor('/auth/logout/', 'Logout'); ?>
<br/><br/>
-->



<?php
if ($loggedin=='true')
{
    echo anchor('/auth/logout/', 'Logout');
    echo "<br/><br/>";
    echo "Available coins ";
    
        foreach($user_coins as $row) {        
            echo $row->coins;
        }
     
    //echo anchor('/auth/register/', 'Register Now');
    echo "<br/><br/>";
    echo anchor('/purchase/', 'Buy Coins');
    echo "<br/><br/>";
    echo anchor('/refer/', 'Refer a friend');
    echo "<br/><br/>";
    echo anchor('/freecoin/', 'Get Daily Free Coin');
    echo "<br/><br/>";
}
else
{
    echo anchor('/auth/login/', 'Login');
    echo "<br/><br/>";
    echo anchor('/auth/register/', 'Register Now');
    echo "<br/><br/>";
}

?>





<b>Live Products</b><br/>
<?php
 $ctr=0; foreach ($live_products as $row) { $ctr++; 
echo "<br/>"; 
echo "Product Name ". $row->prod_name;
echo "<br/>";
echo "Product Description ".$row->prod_desc;
echo "<br/>";
echo "Product Cost ".$row->prod_cost;
echo "<br/>";

echo '<div><span id="time_'.$row->product_id.'"></span><br/><input type="button" name="bid_'.$row->product_id.'" id="bid_'.$row->product_id.'" value="Bid Now"/></div>';

 }
 ?>





<br/><br/> 
<b>Upcoming Products</b><br/>
<?php
 $ctr=0; foreach ($upcoming_products as $row) { $ctr++; 
echo "<br/>";
echo "Product Name ".$row->prod_name;
echo "<br/>";
echo "Product Description ".$row->prod_desc;
echo "<br/>";
echo "Product Cost ".$row->prod_cost;
echo "<br/>";
 }
?> 

<br/><br/>
<b>Closed Products</b><br/>
<?php
 $ctr=0; foreach ($closed_products as $row) { $ctr++; 
echo "<br/>";
echo "Product Name ".$row->prod_name;
echo "<br/>";
echo "Product Description ".$row->prod_desc;
echo "<br/>";
echo "Product Cost ".$row->prod_cost;
echo "<br/>";
 } 
?>

