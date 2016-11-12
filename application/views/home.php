    <script src="http://localhost:3000/socket.io/socket.io.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <script src = "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
                 var socket = io.connect('http://localhost:3000');               
                    
              <?php
                 $ctr=0; foreach ($live_products as $row) { $ctr++;                  
                    echo "$('#bid_".$row['auction_id']."').click(function(){";
                    echo "socket.emit('resetTimer_".$row['auction_id']."',$('#timer_".$row['auction_id']."').val());";
                    echo "});";
              
                    echo "socket.on('updateTimer_".$row['auction_id']."',function(timerVal){";                    
                    echo "$('#timer_".$row['auction_id']."').text(timerVal);});";
                 }
              ?>
                      
                /*
                $('#bid_1').click(function(){
                    socket.emit('resetTimer_1',$('#timer_1').val());
                });
                socket.on('updateTimer',function(timerVal){
                    $('#timer').text(timerVal);
                });
                */                
        }); 
           
    </script>


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


<?php

    $strArray = "";
    $ctr_live_prod=0; 
    foreach ($live_products as $row) { 
        $ctr_live_prod++; 
        $strArray = $strArray .'{';
        $strArray = $strArray .'"auction_id":'.$row['auction_id'].',';
        $strArray = $strArray .'"auction_time_secs":'.$row['auction_time_secs'];
        if($ctr_live_prod == $num_of_live_products) { $strArray = $strArray .'}'; }
        else { $strArray = $strArray .'},'; }
                                                
        //$row['coins_per_bid']
        //$row['prod_cost']        
     }
    echo $strArray;
?>
    
    
<span id="timer"></span><br/>

<b>Live Products</b><br/>
<?php

 $ctr=0; foreach ($live_products as $row) { $ctr++; 
echo "<br/>"; 
echo "Product Name ". $row['prod_name'];
echo "<br/>";
echo "Product Description ".$row['prod_desc'];
echo "<br/>";
echo "Product Cost ".$row['prod_cost'];
echo "<br/>";

echo '<div><span id="timer_'.$row['auction_id'].'"></span><br/>';
echo '<input type="button" name="bid_'.$row['auction_id'].'" id="bid_'.$row['auction_id'].'" value="Bid Now"/></div>';
 }
 ?>


<br/><br/> 
<b>Upcoming Products</b><br/>
<?php
 $ctr=0; foreach ($upcoming_products as $row) { $ctr++; 
echo "<br/>";
echo "Product Name ".$row['prod_name'];
echo "<br/>";
echo "Product Description ".$row['prod_desc'];
echo "<br/>";
echo "Product Cost ".$row['prod_cost'];
echo "<br/>";
 }
?> 

<br/><br/>
<b>Closed Products</b><br/>
<?php
 $ctr=0; foreach ($closed_products as $row) { $ctr++; 
echo "<br/>";
echo "Product Name ".$row['prod_name'];
echo "<br/>";
echo "Product Description ".$row['prod_desc'];
echo "<br/>";
echo "Product Cost ".$row['prod_cost'];
echo "<br/>";
 } 
?>

