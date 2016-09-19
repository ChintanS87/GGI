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
            echo $row->user_coins;
        }
    //echo anchor('/auth/register/', 'Register Now');
    echo "<br/><br/>";
    echo anchor('/purchase/', 'Buy Coins');
    echo "<br/><br/>";
    echo anchor('', 'Refer a friend');
    echo "<br/><br/>";    
}
else
{
    echo anchor('/auth/login/', 'Login');
    echo "<br/><br/>";
    echo anchor('/auth/register/', 'Register Now');
    echo "<br/><br/>";
    echo anchor('', 'Refer a friend');
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





<h1>Countdown Clock</h1>
<div id="clockdiv">
  <div>
    <span class="days"></span>
    <div class="smalltext">Days</div>
  </div>
  <div>
    <span class="hours"></span>
    <div class="smalltext">Hours</div>
  </div>
  <div>
    <span class="minutes"></span>
    <div class="smalltext">Minutes</div>
  </div>
  <div>
    <span class="seconds"></span>
    <div class="smalltext">Seconds</div>
  </div>
</div>