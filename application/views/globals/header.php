<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Go Grab It</title>

    <!--CSS-->
    
    <!-- Bootstrap core CSS -->
    <link href="<?= base_url(); ?>statics/css/bootstrap.css" rel="stylesheet"/>
    <!-- Slick Slider CSS -->
    <link href="<?= base_url(); ?>statics/css/slick.css" rel="stylesheet"/>
    <link href="<?= base_url(); ?>statics/css/slick-theme.css" rel="stylesheet"/>
    <!-- DL Menu CSS -->
    <link href="<?= base_url(); ?>statics/js/dl-menu/component.css" rel="stylesheet">
    <!-- ICONS CSS -->
    <link href="<?= base_url(); ?>statics/css/font-awesome.css" rel="stylesheet">
	<link href="<?= base_url(); ?>statics/css/svg-icons.css" rel="stylesheet">
    <!-- Pretty Photo CSS -->
    <link href="<?= base_url(); ?>statics/css/prettyPhoto.css" rel="stylesheet">
    <!-- Jquery UI CSS -->
    <link href="<?= base_url(); ?>statics/css/range-slider.css" rel="stylesheet">
    <!-- Typography CSS -->
    <link href="<?= base_url(); ?>statics/css/typography.css" rel="stylesheet">
    <!-- Widget CSS -->
    <link href="<?= base_url(); ?>statics/css/widget.css" rel="stylesheet">
    <!-- Shortcodes CSS -->
    <link href="<?= base_url(); ?>statics/css/shortcodes.css" rel="stylesheet">
	<!-- Custom Main StyleSheet CSS -->
    <link href="<?= base_url(); ?>statics/css/style.css" rel="stylesheet">
	<!-- Color CSS -->
    <link href="<?= base_url(); ?>statics/css/color.css" rel="stylesheet">
    <!-- Responsive CSS -->
    <link href="<?= base_url(); ?>statics/css/responsive.css" rel="stylesheet">
    

    <!--Javascript-->
     <script src="<?= base_url(); ?>statics/vendor/jquery/dist/jquery.min.js"></script>
     <script src="<?= base_url(); ?>statics/vendor/bootstrap/dist/js/bootstrap.min.js"></script>        
     <script src="<?= base_url(); ?>statics/js/main.js"></script>
     <!--<script src="<?= base_url(); ?>statics/vendor/async/dist/async.js"></script>-->




    <!--
     <link rel="stylesheet" href="<?= base_url(); ?>statics/css/bootstrap.min.css">
     <link rel="stylesheet" href="<?= base_url(); ?>statics/zebra/public/css/default.css">
     <link rel="stylesheet" href="<?= base_url(); ?>statics/flipclock/compiled/flipclock.css">
     <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
     <link rel="stylesheet" href="<?= base_url(); ?>statics/slick/slick/slick.css">
     <link rel="stylesheet" href="<?= base_url(); ?>statics/css/style.css">
     -->
     <!--
     <link rel="Shortcut Icon" href="<?= base_url(); ?>statics/images/favicon.ico">

     <script src="<?= base_url(); ?>statics/zebra/public/javascript/zebra_datepicker.js"></script>
     <script src="<?= base_url(); ?>statics/flipclock/compiled/flipclock.min.js"></script>
     <script src="<?= base_url(); ?>statics/slick/slick/slick.min.js"></script>
     -->
     
     
     <!--Google Analytics Javascript-->
     <script>
         /*
         (function (i, s, o, g, r, a, m) {
             i['GoogleAnalyticsObject'] = r;
             i[r] = i[r] || function () {
                 (i[r].q = i[r].q || []).push(arguments)
             }, i[r].l = 1 * new Date();
             a = s.createElement(o),
                     m = s.getElementsByTagName(o)[0];
             a.async = 1;
             a.src = g;
             m.parentNode.insertBefore(a, m)
         })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

         ga('create', 'UA-65988616-1', 'auto');
         ga('send', 'pageview');
*/
     </script>    
    
</head>

<body>
<?php
if ($loggedin=='true')
{
    foreach($user_coins as $row) {        
        $coinsDisplay = $row->coins;
    }
}

?>
    
<!--kode Wrapper Start-->  
<div class="kode_wrapper"> 
	<!--Header 2 Wrap Start-->
    <header class="kode_header_2">
        <!--Header 2 Top Bar Start-->
        <div style="background-color:black;position:fixed;z-index:1000" class="kf_top_bar">
            <div class="container">
                <div class="pull-left">
                    <ul class="kf_social2">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                    </ul>
                </div>
                <div class="kf_right_dec">
                    <ul class="kf_topdec">
                        <li> 
                            <div class="kf_lung">
                               <span>Coins :</span>
                                <div class="dropdown">
                                    <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php
                                        echo $coinsDisplay;
                                        
                                        ?>
                                    </button>
                                    <ul style="text-align:center; padding: 15px 0px;" class="dropdown-menu" aria-labelledby="dLabel">
                                        <li style="text-align:center; width:100%;" >HI! GRABBY</li>
                                        <li style="text-align:center; width:100%;"> <img src="images/mascotb.png"/> </li>
                                        <li style="text-align:center; width:100%; padding: 10px 0px;">YOU HAVE 100 COINS</li>
                                        <!--<li style="text-align:center; display:inline; margin:0px auto;">100  COINS</li>-->
                                        <li style="text-align:center; width:100%;"><input class="input-btn" value="Buy Coins" type="button"></li>
                                    </ul>
                                </div> 
                            </div>
                        </li>
                        <li><a href="#"><i class="fa fa-gift"></i>Daily Free</a></li>
                        <li><a href="#"><i class="fa-exclamation-circle" aria-hidden="true"></i>How It Works</a></li>
                    </ul>
                    <ul class="kf_user">
                        <li><a href="#"><i class="fa fa-lock"></i>Register</a></li>
                        <li><a href="#">Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--Header 2 Top Bar End-->
        <div class="container">
            <!--Logo Bar Start-->
            <div  class="kode_logo_bar">
                <!--Logo Start-->
                <div style="z-index:10000;" class="logo">
                    <a href="index.html">
                        <img src="<?= base_url(); ?>statics/images/ggi-logo-b.png" alt="">
                    </a>
                </div>
                <!--Logo Start-->
                <!--Navigation Wrap Start-->
                <div class="kode_navigation"><!-- style="padding-top:15px;"-->
                    <!--Navigation Start-->
                    <ul class="nav">
                                <li><a href="#">Buy Coins</a></li>
                                <li><a href="#">Referral</a></li>
                                <li><a href="#">Meet Winners</a></li>
                    </ul>
                    <!--Navigation End-->
                </div>
                <!--Navigation Wrap End-->
            </div>
            <!--Logo Bar End-->
        </div>
    </header>
    <!--Header 2 Wrap End-->        