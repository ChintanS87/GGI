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
                    //bid click
                    echo "$('#bid_".$row['auction_id']."').click(function(){";
                    echo "socket.emit('Userbid',{auction_id:".$row['auction_id'].",user_id:".$userid_final."});";
                    echo "});";


                    //autobid on click
                    echo "$('#autobid_".$row['auction_id']."').click(function(){";
                    ?>                            
                         if($('#autobid_count_<?php echo $row['auction_id']?>').val()=== '')
                         {
                             alert("Please enter number of times autobid is to be done");
                         }
                         else
                         {
                             var autobidCount = $('#autobid_count_<?php echo $row['auction_id']?>').val();
                             socket.emit('UserAutobidOn',{auction_id:<?php echo $row['auction_id']?>,user_id:<?php echo $userid_final?>,autobidCount:autobidCount});
                         }                                   
                    <?php        
                    echo "});";                    



                    //autobid off click
                    echo "$('#autobid_off_".$row['auction_id']."').click(function(){";
                    echo "socket.emit('UserAutobidOff',{auction_id:".$row['auction_id'].",user_id:".$userid_final."});";
                    echo "});";

                    
                    
                    //receive data UpdateTimer, CurrentMaxValue and CurrentWinningBidder
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
/*
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
*/
?>


<!--<b>Live Products</b><br/>-->
<?php
/*
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


echo '<input type="text" name="autobid_count_'.$row['auction_id'].'" id="autobid_count_'.$row['auction_id'].'" value=""/></div>';
echo '<input type="button" name="autobid_'.$row['auction_id'].'" id="autobid_'.$row['auction_id'].'" value="Auto Bid"/></div>';

echo '<input type="button" name="autobid_off_'.$row['auction_id'].'" id="autobid_off_'.$row['auction_id'].'" value="Turn Off Auto Bid"/></div>';

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
  
 */
?>






















    <!--Banner Map Wrap Start-->
    <div class="kode_banner_1">
        <div class="main_banner">
            <div>
                <!--Banner Thumb START-->
                <div class="thumb">
                    <img src="<?= base_url(); ?>statics/extra-images/banner1.jpg" alt="">
                    <div class="container">
                        <div class="banner_caption text-left">
                            <span style="color:#a98815;">Welcome to <span style="color:#10151c;">Go Grab It - Its a Bid Deal!</span><br/> An Amazing Online Bidding Experience.</span>     
                            <h1 style="color:#10151c;">
                                Refer A Friend!
                            </h1>
                            <p style="color:#a98815;">A summary of Refer a Friend Concept will be explained here.</p>
                            <a href="#" class="btn-1" style="color:#10151c;">Refer A Friend</a>
                        </div>
                    </div>
                </div>
                <!--Banner Thumb End-->
            </div>
            <div>
                <!--Banner Thumb START-->
                <div class="thumb">
                    <img src="<?= base_url(); ?>statics/extra-images/banner2.png" alt="">
                    <div class="container">
                        <div class="banner_caption text-left">
                            <span style="color:#a98815;">Welcome to <span style="color:#10151c;">Go Grab It - Its a Bid Deal!</span><br/> An Amazing Online Bidding Experience.</span>   
                            <h1 style="color:#10151c; font-size:24px;">
                                1. Refer a Friend.<br/>
                                2. Win Free Coins.<br/>
                                3. Start Bidding.<br/>
                                4. Redeem Your Price.
                            </h1>
                            <p style="color:#a98815;">A Quick Tour on Bidding will be explianed here.</p>  
                            <a href="#" class="btn-1" style="color:#10151c;">Start Bidding</a>
                        </div>
                    </div>
                </div>
                <!--Banner Thumb End-->
            </div>
            <div>
                <!--Banner Thumb START-->
                <div class="thumb">
                    <img src="<?= base_url(); ?>statics/extra-images/banner3.jpg" alt="">
                    <div class="container">
                        <div class="banner_caption text-left">
                            <span style="color:#a98815;">Welcome to <span style="color:#10151c;">Go Grab It - Its a Bid Deal!</span><br/> An Amazing Online Bidding Experience.</span>   
                            <h1 style="color:#10151c;">
                                How it Works!
                            </h1>
                            <p style="color:#a98815;">A Summary on Bidding will be explianed here.</p>  
                            <a href="#" class="btn-1" style="color:#10151c;">Start Bidding</a>
                        </div>
                    </div>
                </div>
                <!--Banner Thumb End-->
            </div>
        </div>
    </div>
    <!--Banner Map Wrap End-->
    <div class="kf_ticker-wrap">
        <div class="container">
            <div class="kf_ticker">
                <span>Latest Updates</span>
                <div class="kf_ticker_slider">
                    <ul class="ticker">
                        <li><p>Bid to win an iPhone 7! Max Bidding Price to be INR 30,000/- Auction on 17.01.2017 midnight! Set a reminder <em><a href="">here</a></em> today!</p></li>
                        <li><p>Mr. Chirag Jhaveri won a vacation worth 2 lakhs to Paris for a couple for 7 days & 8 nights, just a few minutes ago! </p></li>
                        <li><p>Take part in this Facebook contest & win free credits to grab your dream! Mr. Grabby shows you how <em><a href="">here</a></em>!  </p></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    <!--Main Content Wrap Start-->
    <div class="kode_content_wrap">
        <section style="padding-top:60px;" class="kf_overview margin-0">
            <div class="container">
                <div class="kf_overview_nav">
                    <ul class="row" role="tablist">
                        <li role="presentation" class="active col-md-4">
                            <a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">
                            <span style="font-size:26px;" >LIVE</span>
							<em>Auctions</em>                            
                            </a>
                        </li>
                        <li role="presentation" class="col-md-4">
                            <a href="#roster" aria-controls="roster" role="tab" data-toggle="tab">
                            <span style="font-size:26px;">UPCOMING</span>
							<em>Auctions</em>                            
                            </a>
                        </li>
                        <li role="presentation" class="col-md-4">
                            <a href="#standing" aria-controls="standing" role="tab" data-toggle="tab">
                            <span style="font-size:26px;">CLOSED</span>
							<em>Auctions</em>                            
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content"><!--TAB 1 Current Auction -->
                    <div role="tabpanel" class="tab-pane active" id="overview">
                        <div class="overview_wrap">
                            <div class="section widget_page" style="padding:10px 0px 10px;">
                                    <!--<div class="container">-->
                                <div class="row">

<?php

 $ctrLive=1; foreach ($live_products as $row) {  
 ?>
                                    <!--Widget Code 1 Added Here -->
                                    <aside class="col-md-4">
                                        <div class="widget roster_sidebar">
                                            <!--Heading 1 Start-->
                                            <h6 class="kf_hd1 margin_0">
                                                <span><?php echo $row['prod_name'] ?></span>
                                                <b style="font-size:14px; color:#333; line-height:50px; float:right; padding-right:10px;">MRP INR <?php echo $row['prod_MRP']?>/-</b>
                                            </h6>
                                            <!--Heading 1 End-->
                                            <div style="padding:10px 10px 10px 10px;" class="kf_border">  
                                                <!--Slider Widget Start-->
                                                <div class="slider_widget">
                                                    <div>
                                                        <div class="slider_thumb">
                                                            <figure>
                                                                <img src="<?= base_url(); ?>statics/extra-images/<?php echo $row['prod_image1']?>" alt=""/>
                                                            </figure>
                                                            <div class="text">
                                                                <h6><a href="#" tabindex="0">Specification</a></h6>
                                                                <span style="text-transform:none; font-size:13px; line-height:14px;">
                                                                    <?php echo $row['prod_desc'] ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="slider_thumb">
                                                            <figure>
                                                                <img src="<?= base_url(); ?>statics/extra-images/<?php echo $row['prod_image2']?>" alt=""/>
                                                            </figure>
                                                            <div class="text">
                                                                <h6><a href="#" tabindex="0">Specification</a></h6>
                                                                <span style="text-transform:none; font-size:13px; line-height:14px;">
                                                                    <?php echo $row['prod_desc'] ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="slider_thumb">
                                                            <figure>
                                                                <img src="<?= base_url(); ?>statics/extra-images/<?php echo $row['prod_image3']?>" alt=""/>
                                                            </figure>
                                                            <div class="text">
                                                                <h6><a href="#" tabindex="0">Specification</a></h6>
                                                                <span style="text-transform:none; font-size:13px; line-height:14px;">
                                                                    <?php echo $row['prod_desc'] ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Slider Widget END-->
                                            </div>

                                           

                                            <div style="" class="kf_border-2">
                                                <div style="background-color:#333;" class="kf_plyer_rating">
                                                    <span style="font-size:12px; padding:6px 10px 0px;">
                                                        <strong>Bid Price</strong>
                                                    </span>
                                                    <span style="font-size:12px; padding:6px 0px 0px;">
                                                        <strong>Max Bid Price</strong>
                                                    </span>
                                                    <span style="font-size:12px; padding:6px 20px 0px;">
                                                        <strong>MRP</strong>
                                                    </span>
                                                </div>
                                                <div style="padding:5px 25px; background-color:#333;" class="kf_rangeslider">
                                                    <div class="rangsldr-meta">
                                                        <span style="width:33%; font-size:12px; color:#e1cc0f; text-align:left;"><b>INR 15.8</b></span>
                                                        <span style="width:33%; font-size:12px; color:#e1cc0f; text-align:center;"><b>INR 18K</b></span>
                                                        <span style="width:33%; font-size:12px; color:#e1cc0f; text-align:right;"><b>INR 45K</b></span>
                                                    </div>
                                                    <div class="slider-range"></div>
                                                </div>
                                            </div>



                                            <!--Widget COUNT Down Start-->
                                            <!--
                                            <ul style="border:1px solid #d7d8d8; border-top: 0px; padding:3px 0px 3px 0px;" class="kf_countdown countdown">
                                                <li style="width:33%;">
                                                    <span style="font-size:22px;" class="hours">00</span>
                                                    <p class="hours_ref">hours</p>
                                                </li>                                                
                                                <li style="width:33%;">
                                                    <span style="font-size:22px;" class="minutes">09</span>
                                                    <p class="minutes_ref">minutes</p>
                                                </li>
                                                <li style="width:33%;">
                                                    <span style="font-size:22px;" class="seconds last">25</span>
                                                    <p class="seconds_ref">seconds</p>
                                                </li>                                                                                                    
                                            </ul>
                                            --> 


                                            <ul style="border-style:solid; border-color:#d7d8d8; border-width: 0px 1px 1px 1px;" class="kf_table2 kf_tableaside">
                                                <li>
                                                    <div class="user-price">
                                                        <?php
                                                            echo '<span id="timer_'.$row['auction_id'].'"></span>';
                                                        ?>
                                                    </div>
                                                    <div class="user-price">
                                                        <span>
                                                            HOURS MINUTES SECONDS
                                                        </span>
                                                    </div>
                                                </li>    
                                            </ul>                                            
                                            
                                            <!--Widget COUNT Down End-->


                                            <ul style="border-style:solid; border-color:#d7d8d8; border-width: 0px 1px 1px 1px;" class="kf_table2 kf_tableaside">
                                                <li>
                                                    <div class="user-price">
                                                        <span>
                                                            <em style="color:#e1cc0f;" >Auction Price</em>
                                                            <?php echo '<span id="CurrentMaxValue_'.$row['auction_id'].'">INR '.$row['current_max_value'].'</span>'; ?>
                                                        </span>
                                                    </div>
                                                    <div class="user-price"><!--team_logo bid-user-->
                                                        <span>
                                                            <em style="color:#e1cc0f;" >Current Winner</em>
                                                            <img style="border-radius:100%;" src="<?= base_url(); ?>statics/extra-images/admin.jpg" alt="">
                                                            <a href="#"><?php echo '<span id="CurrentWinningBidder_'.$row['auction_id'].'">'.$row['first_name'].'</span>'; ?></a>
                                                        </span>
                                                    </div>
                                                </li>    
                                            </ul>

                                            








                                            <div style="" class="kf_border-2">
                                                <div style="border-style:solid; border-color:#d7d8d8; border-width: 0px 1px 1px 1px; background:#e7eaf0 none repeat scroll 0 0;" class="kf_plyer_rating">
                                                    <div class="team_logo bid-user">
                                                        <span><img style="border-radius:100%;" src="<?= base_url(); ?>statics/extra-images/coin.png" alt=""><a href="#">X <?php echo $row['coins_per_bid'] ?></a></span>
                                                        
                                                        
                                                        <?php
                                                            echo '<span><input type="button" name="bid_'.$row['auction_id'].'" id="bid_'.$row['auction_id'].'" value="Bid Now"/></span>';
                                                        ?> 
                                                        <?php
                                                            echo '<input type="text" name="autobid_count_'.$row['auction_id'].'" id="autobid_count_'.$row['auction_id'].'" value="" size="1" />';

                                                            echo '<span><input type="button" name="autobid_'.$row['auction_id'].'" id="autobid_'.$row['auction_id'].'" value="Auto Bid"/></span>';
                                                            
                                                            //echo '<input type="button" name="autobid_off_'.$row['auction_id'].'" id="autobid_off_'.$row['auction_id'].'" value="Turn Off Auto Bid"/>';                                                            
                                                        ?>    
                                                        
                                                        
                                                        
                                                        
                                                        <!--<span style="background-color:#e1cc0f;"><img style="border-radius:100%;" src="<?= base_url(); ?>statics/extra-images/order.png" alt=""><a style="color:#10151c;" href="#">BID</a></span>-->

                                                        <!--
                                                        <div style="width:33%;" class="user-auto radio_style3">
                                                            <label>
                                                                <ul class="kf_table">
                                                                    <li style="display:inline !important;">
                                                                        <span style="padding:18px 5px 15px 5px; width:auto; text-align:left;" class="radio">
                                                                            <input name="car_parking" value="90" type="radio">
                                                                            <span style="padding:6px;" class="radio-value" aria-hidden="true"></span>
                                                                        </span>
                                                                    </li>
                                                                    <li style="display:inline !important;">
                                                                        <span>Autobid</span>
                                                                    </li>
                                                                    <li style="display:inline !important;">
                                                                        <div style="padding:0px 0px 0px 5px; line-height:34px;" class="kf_info">
                                                                            <a style="width:15px; height: 15px; border:1px solid #000; line-height:13px; font-size:10px; color:#000;" class="kf_tip" href="#">
                                                                                <span style="padding:0px; line-height:3; color:#fff; font-size:10px; width:auto; height:30px;">More Info</span>
                                                                                <i class="fa fa-info"></i>
                                                                            </a>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </label>
                                                        </div>
                                                        -->
                                                    </div>
                                                </div>
                                           </div>


                                        </div>
                                    </aside>
                                    <!--Widget Code 1 Added Here -->

                                    
<?php 
$ctrLive++;
}
 ?>                                    


                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- TAB 1 Current Auctions End -->                   
                
                
                
                
                
                
                
                
                
                
                

                
            </div>
        </section>  
    </div>
    <!--Main Content Wrap End-->

    
    
    
    
    <!--Result Slider Start-->
    <div class="result_slide_wrap">
        <div class="result_slider">
            <div>
                <!--Result Thumb Start-->
                <div style="margin-bottom:0px;" class="kf_featured_thumb">
                    <figure>
                        <a href=""><img src="<?= base_url(); ?>statics/extra-images/video-1.jpg" alt=""></a>
                    </figure>
                </div> 
                <!--Result Slider Thumb End--> 
            </div>
            <div>
                <!--Result Thumb Start-->
                <div style="margin-bottom:0px;" class="kf_featured_thumb">
                    <figure>
                        <a href=""><img src="<?= base_url(); ?>statics/extra-images/video-2.jpg" alt=""></a>
                    </figure>
                </div> 
                <!--Result Slider Thumb End--> 
            </div>
            <div>
                <!--Result Thumb Start-->
                <div style="margin-bottom:0px;" class="kf_featured_thumb">
                    <figure>
                        <img src="<?= base_url(); ?>statics/extra-images/video-3.jpg" alt="">
                    </figure>
                </div> 
                <!--Result Slider Thumb End--> 
            </div>
        </div>
    </div>
    <!--Result Slider End-->



    
    
    
    
    
    
    
    



 