    <script src="http://localhost:3000/socket.io/socket.io.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <script src = "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
                 var socket = io.connect('http://localhost:3000');               
                    
              <?php
                if ($loggedin=='true'){
                    $userid_final = $userid;
                }
                else{
                    $userid_final = 0;                    
                }
                 $ctr=0; foreach ($live_products as $row) { $ctr++;                  
                    echo "$('#bid_".$row['auction_id']."').click(function(){";
                    echo "socket.emit('Userbid',{auction_id:".$row['auction_id'].",user_id:".$userid_final."});";
                    echo "});";
              
                    echo "socket.on('updateTimer_".$row['auction_id']."',function(timerVal){";                    
                    echo "$('#timer_".$row['auction_id']."').text(timerVal);});";
                    
                    echo "socket.on('CurrentMaxValue_".$row['auction_id']."',function(maxVal){";                    
                    echo "$('#CurrentMaxValue_".$row['auction_id']."').text(maxVal);});";
                    
                    echo "socket.on('CurrentWinningBidder_".$row['auction_id']."',function(BidderVal){";                    
                    echo "$('#CurrentWinningBidder_".$row['auction_id']."').text(BidderVal);});";
                 }
              ?>
                socket.on('userMsg',function(MsgText){
                    alert(MsgText);
                });      
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


<b>Live Products</b><br/>
<?php

 $ctr=0; foreach ($live_products as $row) { $ctr++; 
echo "<br/>"; 
echo "Product Name ". $row['prod_name'];
echo "<br/>";
echo "Product Description ".$row['prod_desc'];
echo "<br/>";
echo "Product MRP ".$row['prod_MRP'];
echo "<br/>";
echo "Coins Per Bid ".$row['coins_per_bid'];
echo "<br/><br/>";


echo "Current Value Rs";
echo '<div><span id="CurrentMaxValue_'.$row['auction_id'].'">'.$row['current_max_value'].'</span></div>';
echo "Current Winning Bidder";
echo '<div><span id="CurrentWinningBidder_'.$row['auction_id'].'"></span></div>';
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
echo "Product MRP ".$row['prod_MRP'];
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
echo "Product MRP ".$row['prod_MRP'];
echo "<br/>";
 } 
?>

