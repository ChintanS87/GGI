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


    


    <!--Inner Banner Start-->
    <div class="innner_banner">
        <div class="container">
            <h3>Buy Coins</h3>
            <span>Select Package or Grab your own deal!</span><br/>
        </div>
    </div>
    <!--Inner Banner End-->
    <div class="kode_content_wrap">
        <section class="team_schedule_page">
            <div class="container">
                <aside class="col-md-12">
                    <!--Overview Contant Start-->
                    <div class="kf_overview_contant">
                        <!--Heading 1 Start-->
                        <h6 class="kf_hd1 margin_0">
                            <span>Choose a Credit Coin Package</span>
                            <p style="line-height:29px; text-align:right; font-style: italic; font-weight:bold; padding-top:11px; padding-right:10px; ">Select a package of your choice!</p>
                        </h6>
                        <!--Heading 1 End-->
                    </div>
                    <!--Overview Contant End-->

                    <!--Overview Form Start-->
                    <div style="margin-top:15px;" class="kf_overview_contant">
                        <aside class="col-md-4">
                            <div class="roster_sidebar">
                                <div class="kf_h5">
                                    <h5>Bronze</h5>
                                </div>
                                <div class="kf_roster_dec">
                                    <figure style="background-color:#fff;">
                                        <img style="height:150px; width:150px;" src="images/mascota.png" alt="">
                                    </figure>
                                    <div class="text">
                                            <span>500</span>
                                        <div class="text_overflow">
                                            <h3><a href="#">
                                               COINS
                                            </a></h3>
                                            <!-- <em>1st shooting Gaurd</em> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="kf_plyer_rating">
                                    <span><strong>INR</strong></span>
                                    <span><b>10,000/-</b></span>
                                    <span><input class="input-btn" value="buy now" type="button"></span>
                                </div>
                            </div>
                        </aside>
                        <aside class="col-md-4">
                            <div class="roster_sidebar">
                                <div class="kf_h5">
                                    <h5>Silver</h5>
                                </div>
                                <div class="kf_roster_dec">
                                    <figure style="background-color:#fff;">
                                        <img style="height:150px; width:150px;" src="images/mascotb1.png" alt="">
                                    </figure>
                                    <div class="text">
                                            <span>1000</span>
                                        <div class="text_overflow">
                                            <h3><a href="#">
                                               COINS
                                            </a></h3>
                                            <!-- <em>1st shooting Gaurd</em> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="kf_plyer_rating">
                                    <span><strong>INR</strong></span>
                                    <span><b>10,000/-</b></span>
                                    <span><input class="input-btn" value="buy now" type="button"></span>

                                </div>
                            </div>
                        </aside>
                        <aside class="col-md-4">
                            <div class="roster_sidebar">
                                <div class="kf_h5">
                                    <h5>Gold</h5>
                                </div>
                                <div class="kf_roster_dec">
                                    <figure style="background-color:#fff;">
                                        <img style="height:150px; width:150px;" src="images/mascotc.png" alt="">
                                    </figure>
                                    <div class="text">
                                            <span>2000</span>
                                        <div class="text_overflow">
                                            <h3><a href="#">
                                               COINS
                                            </a></h3>
                                            <!-- <em>1st shooting Gaurd</em> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="kf_plyer_rating">
                                    <span><strong>INR</strong></span>
                                    <span><b>10,000/-</b></span>
                                    <span><input class="input-btn" value="buy now" type="button"></span>
                                </div>
                            </div>
                        </aside>
                   </div>
                    <!--Overview Form End-->
                </aside>
                

                <div class="kode_content_wrap">
        <section class="nextmatch_page">
            <div class="container">

            <h6 class="kf_h4">
                                        <span>COIN COUNTER</span>
                                        <em>Buy coins as needed!</em>
                                    </h6>


                <div class="kf_ticketdetail">
                    <div style="background-color:black;" class="ticketdetail_hd">
                        <div class="tkt_date">
                            <span><i class="fa fa-database"></i>You can buy any specific number of coins here!</span>
                        </div>
                         <div class="tkt_date">
                            <span><i class="fa fa-credit-card"></i>Check the amount &amp; Click Buy Now!</span>
                        </div> 
                    </div>
                    <ul class="kf_table2">
                        <li>
                            <!-- <div class="tkt_pkg">
                                <span>
                                    <i class="fa fa-ticket"></i>
                                    <strong>Standard Ticket</strong>
                                    <small>This ticket is for unlimited persons.</small>
                                </span>
                            </div>  -->
                        
                            <div class="tkt_qty">
                                <label>Coins to buy  :</label>
                                <div class="numbers-row">
                                    <input class="kf_trigger" name="family" id="totalpersons" value="0" type="text">
                                <div class="inc button">+</div><div class="dec button">-</div></div>
                                <a style="padding:0; margin-left:0;" href="#" class="kf_cart"> <i class="fa fa-thumbs-up "></i> </a>
                            </div>
                                <div style="min-width:20%;" class="tkt_pkg">
                                <span style="color: #333;font-size: 24px;font-weight: bold;font-style: normal;text-transform: uppercase;font-family: 'Open Sans', sans-serif;">₹ 00.00</span>
                            </div>
                            <div class="tkt_btn">
                                <a href="#" class="input-btn ">Buy now</a>
                            </div>
                        </li>
                       
                    </ul>
                </div>
             
            
            </div>
        </section>
    </div>

            </div>
        </section>
    </div>
    <!--Main Content Wrap End-->
    <!--ticker Wrap Start-->
    <div class="kf_ticker-wrap twitter_ticker">
        <div class="container">
            <div class="kf_ticker">
                <span><i class="fa fa-twitter"></i></span>
                <div class="kf_ticker_slider">
                    <ul class="ticker">
                        <li><p>One Lines Posts & Updates for Users can be flashed here in 0ne or 2 liners as summary <a href="#">https://t.co/nifHgDnXes</a></p></li>
                        <li><p>Promotional Activity for marketting purpose can be set here as one liners<a href="#">https://t.co/nifHgDnXes</a></p></li>
                        <li><p>Encouraging Quotes for sucess and risks can be flashed here just as motivational element for users <a href="#">https://t.co/nifHgDnXes</a></p></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

