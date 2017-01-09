var app     =     require("express")();
var mysql   =     require("mysql");
var http    =     require('http').Server(app);
var io      =     require("socket.io")(http);
/* Creating POOL MySQL connection.*/
var pool    =    mysql.createPool({
      connectionLimit   :   100,
      host              :   'localhost',
      user              :   'root',
      password          :   '',
      database          :   'gograbit',
      debug             :   false
});
//var async = require('async');
//var sync = require('synchronize');
//var wait = require('wait.for');

var currentSystemBidUser;


http.listen(3000,function(){
    console.log("Listening on 3000");
});
app.get("/",function(req,res){
    res.sendFile(__dirname + '/index.html');
});






/*  This is auto initiated event when Client connects to Your Machine.*/
io.on('connection',function(socket){  
    console.log("A user is connected");
        
    socket.on('Userbid',function(data){
        UserBid(data);
    });
    socket.on('UserAutobid',function(data){
        UserAutoBid(data);
    });    
    
});







pool.getConnection(function(err,connection){
    if (err) {
      console.log('Error in Main pool getConnection '+err);  
      //callback(false);
      return;
    }
    connection.query("Select * from product_details p, auction_details a where p.product_id=a.product_id and a.is_active='Y'",function(err,rows)
    {
        connection.release();
        if(!err) {                
            initialiseCountdown(rows.length,rows);
            //callback(true);
        }
        else{ console.log('Error in Main connection query '+err); }
    });
    connection.on('error', function(err) {
          console.log('Error in Main Connection '+err);
          //callback(false);
          return;
    });
});



function initialiseCountdown(noOfLiveAuctions, arrLiveAuctions) {
    var myCounter= new Array();
    for (var i = 0; i < noOfLiveAuctions; i++) {  
        //var myCounter = "myCounter_"+arrLiveAuctions[i].auction_id;                        
        var updatetimer = 'updateTimer_'+arrLiveAuctions[i].auction_id;        
        var auction_id = arrLiveAuctions[i].auction_id;
        var product_cost = arrLiveAuctions[i].prod_cost;
        var coins_per_bid = arrLiveAuctions[i].coins_per_bid;
        var SysBid = arrLiveAuctions[i].auction_system_bid;
        var AllowFreeUserWin = arrLiveAuctions[i].auction_allow_free_user_win;
        var auction_secs = arrLiveAuctions[i].auction_time_secs;        
        
        myCounter[auction_id]  = new Countdown({  
            seconds:auction_secs,
            onUpdateStatus: function(sec){
                //if hours are added to the bid system..keeping commented code 
                //hours = Math.floor(totalSeconds / 3600);
                //totalSeconds %= 3600;        
                minutes = Math.floor(sec / 60);
                seconds = sec % 60;
                if (minutes < 10){ minsText = "0"+ minutes; } else { minsText = minutes;}
                if (seconds < 10){ secsText = "0"+ seconds; } else { secsText = seconds;}        
                io.emit(updatetimer,minsText +':'+secsText);
            },
            onCounterEnd: function(){
                io.emit(updatetimer,'Checking...');
                checkCTCSysBid(myCounter[auction_id],updatetimer,auction_id, product_cost,coins_per_bid, SysBid,AllowFreeUserWin,auction_secs);                                
            }
        });         
        myCounter[auction_id].start(auction_secs); 
    }    
}


/* System Bidding and Checks - start */

function checkCTCSysBid(myCounter,updatetimer,auction_id, product_cost,coins_per_bid,SysBid,AllowFreeUserWin,auction_secs)
{ 
    var total_coins;
    var total_collected;
    var blnCTC;
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in checkCTCSysBid pool getConnection '+err);  
          //return false;
        }
        connection.query("Select count(*) as bidCount from user_bids where system_user='N' and auction_id ="+auction_id,function(err,rows)
        {            
            connection.release();
            if(!err) {
                total_coins = rows[0].bidCount * coins_per_bid;
                total_collected = total_coins * 3;                
                if (total_collected >= product_cost){
                    //return true;
                    blnCTC = true;
                    checkWinningUserType(myCounter,updatetimer,auction_id, product_cost,coins_per_bid,SysBid,AllowFreeUserWin,auction_secs,blnCTC);
                }
                else{
                    //return false;
                    blnCTC = false;
                    checkWinningUserType(myCounter,updatetimer,auction_id, product_cost,coins_per_bid,SysBid,AllowFreeUserWin,auction_secs,blnCTC);                                                         
                }                
            }
            else{ 
                console.log('error in checkCTCSysBid connection query '+err);
            }
        });
    });        
}


function checkWinningUserType(myCounter,updatetimer,auction_id, product_cost,coins_per_bid,SysBid,AllowFreeUserWin,auction_secs,blnCTC){
    var WinningUserType="";
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in checkWinningUserType pool getConnection '+err);  
          //return false;
        }
        connection.query("SELECT user_id FROM user_bids WHERE auction_id ="+auction_id+" ORDER BY bid_id DESC LIMIT 1",function(err,rows)
        {            
            if(!err) {
                if(rows.length > 0){
                    var useridfromQuery = rows[0].user_id;                                       
                    connection.query("SELECT user_type FROM user_details WHERE user_id in ("+useridfromQuery+")",function(err,rows)
                    {                        
                        connection.release();
                        if(!err) {
                            if (rows.length > 0){
                                WinningUserType = rows[0].user_type;
                                onCounterEndFunction(myCounter,updatetimer,auction_id, product_cost,coins_per_bid,SysBid,AllowFreeUserWin,auction_secs,blnCTC,WinningUserType);    
                            }
                            else{
                                onCounterEndFunction(myCounter,updatetimer,auction_id, product_cost,coins_per_bid,SysBid,AllowFreeUserWin,auction_secs,blnCTC,WinningUserType);        
                            }                                
                        }
                        else{ 
                            console.log('error in checkWinningUserType connection query2 '+err);
                            //return false; 
                        }                                                                
                    });                                        
                }
                else{
                    onCounterEndFunction(myCounter,updatetimer,auction_id, product_cost,coins_per_bid,SysBid,AllowFreeUserWin,auction_secs,blnCTC,WinningUserType);                        
                }
            }
            else{ 
                console.log('error in checkWinningUserType connection query '+err);                  
                //return false; 
            }
        });
    });            
}




function onCounterEndFunction(myCounter,updatetimer,auction_id, product_cost,coins_per_bid,SysBid,AllowFreeUserWin,auction_secs,blnCTC,WinningUserType){
    console.log("System bid value is "+SysBid);
    console.log("blnCTC value is "+blnCTC);
    console.log("WinningUserType value is "+WinningUserType);
   
    //if SysBid is true
    if (SysBid === 'Y'){        
        // if CTC is recovered
        if(blnCTC){
            //if free user is winning
            if (WinningUserType === 'F'){
                if(AllowFreeUserWin === 'Y'){
                    //close the bid
                    CloseBid(auction_id);
                    io.emit(updatetimer,'This Bid is Closed');
                    //to do - disable the bid button
                }
                else{
                    //system bid
                    SystemBid(auction_id,myCounter,product_cost,auction_secs,coins_per_bid);
                }                            
            }
            //if paid user is winning
            if (WinningUserType === 'P'){
                //close the bid
                 CloseBid(auction_id);
                 io.emit(updatetimer,'This Bid is Closed');
                 //to do - disable the bid button                
            }
            //if System user is winning
            if (WinningUserType === 'S'){
                //to do - check last 10 bids for this auction if all are system then close the bid
            }
        }
        else{
            //Do System Bid
            SystemBid(auction_id,myCounter,product_cost,auction_secs,coins_per_bid);
        }
    }
    else{
        // close bid
        CloseBid(auction_id);
        io.emit(updatetimer,'This Bid is Closed');
        //to do - disable the bid button
    }    
}


function SystemBid(auction_id,myCounter,product_cost,auction_secs,coins_per_bid){
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in System Bid pool getConnection '+err);  
          //return false;
        }
        var x;      
        x = Math.floor((Math.random() * 5) + 1);
        //check to ensure that the same system user is not bidding again
        while (x === currentSystemBidUser){
            x = Math.floor((Math.random() * 5) + 1);           
        }
        
        currentSystemBidUser = x;
                        
        connection.query("INSERT INTO `user_bids`(`auction_id`, `user_id`, `system_user`, `added_date`, `updated_date`) VALUES ("+auction_id+","+x+",'Y',now(),now())",function(err,rows)
        {
            connection.release();
            if(!err) {
                reset_timer(auction_id, myCounter,product_cost,auction_secs,coins_per_bid);
                //return true;
            }
            else{
                console.log('error in System Bid connection query '+err); 
                //return false;                 
            }
        });
    });       
}


function updateMaxValue(){
    if(current_max_value < max_value){
        pool.getConnection(function(err,connection){
            if (err) {
              console.log('error Bid Click');  
              //return false;
            }            
            connection.query("Update auction_details SET current_max_value=current_max_value+"+incrementValue+" Where auction_id="+auction_id,function(err,rows)
            {
                connection.release();
                if(!err) {

                }
                else{
                    console.log('error Bid Click'); 
                    //return false;                 
                }
            });  
        });    
        display_max_value=current_max_value + incrementValue;
    }                  

    io.emit('CurrentMaxValue_'+auction_id, display_max_value);
    io.emit('CurrentWinningBidder_'+auction_id, username);    
}



function reset_timer(auction_id,myCounter,product_cost,auction_secs,coins_per_bid){    
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in reset timer pool getConnection '+err);  
          //return false;
        }        
        connection.query("Select count(*) as bidCount from user_bids where system_user='N' and auction_id ="+auction_id,function(err,rows)
        {
            connection.release();
            if(!err) {
                total_coins = rows[0].bidCount * coins_per_bid;
                total_collected = total_coins * 3;                
                percentCTC = 100*total_collected/ product_cost;
                if(percentCTC < 25){
                    NewSeconds = auction_secs;
                }else if (percentCTC >= 25 && percentCTC< 50){
                    NewSeconds = 0.75 * auction_secs;
                }else if(percentCTC >= 50 && percentCTC< 75){
                    NewSeconds = 0.5 * auction_secs;
                }else if(percentCTC >= 75 && percentCTC< 100){
                    NewSeconds = 0.25 * auction_secs;
                }else if(percentCTC >= 100 && percentCTC < 125){
                    NewSeconds = 0.15 * auction_secs;
                }else if(percentCTC >= 125){
                    NewSeconds = 0.10 * auction_secs;
                }
                 
                myCounter.start(NewSeconds);
                //return true;
            }
            else{
                console.log('error in reset timer connection query '+err); 
                //return false;                 
            }
        });
    });               
}


function CloseBid(auction_id){
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in Close Bid pool getConnection '+err);  
          //return false;
        }
        
        connection.query("UPDATE auction_details SET is_active='C' WHERE auction_id ="+auction_id,function(err,rows)
        {
            connection.release();
            if(!err) {                                                
                //return true;
            }
            else{
                console.log('error in Close Bid connection query '+err); 
                //return false;                 
            }
        });
    });      
}

/* System Bidding and Checks - end */








/* User AutoBidding - start */

function UserAutoBid(data){
    var auction_id = data.auction_id;
    var user_id = data.user_id;
    
    if (user_id === 0){
        io.emit('userMsg','Please Login to Start bidding');
    }else{
        pool.getConnection(function(err,connection){
            if (err) {
              console.log('error AutoBid Click');  
              //return false;
            }        
            connection.query("INSERT INTO `autobid`(`auction_id`, `user_id`, `active_flag`,`bid_flag`, `added_date`, `updated_date`) VALUES ("+auction_id+","+user_id+",'Y','Y',now(),now())",function(err,rows)
            {
                connection.release();
                if(!err) {
                    if(rows.length === 1){
                        console.log(rows);
                        return rows;
                    }
                }
                else{
                    console.log('error AutoBid Click'); 
                    //return false;                 
                }
            });             
        });  

    }
}

/* User AutoBidding - end */





/* User Bidding - start */

function UserBid(data){
    var auction_id = data.auction_id;
    var user_id = data.user_id;
    
    if (user_id === 0){
        io.emit('userMsg','Please Login to Start bidding');
    }else{
        BidClkgetAucDtls(auction_id, user_id);        
    }
}


function BidClkgetAucDtls(auction_id, user_id){
    var coins_per_bid;
    var max_value;
    var current_max_value;
    var display_max_value;
    var product_cost;
    var auction_secs;
    var incrementValue;
    
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in BidClkgetAucDtls pool getConnection '+err);  
          //return false;
        }        
        connection.query("Select * from auction_details a, product_details p where p.product_id = a.product_id and a.auction_id ="+auction_id,function(err,rows)
        {
            connection.release();
            if(!err) {
                if(rows.length === 1){
                    coins_per_bid = rows[0].coins_per_bid;
                    max_value = rows[0].max_value;
                    current_max_value = rows[0].current_max_value;
                    display_max_value = rows[0].current_max_value;                       
                    product_cost = rows[0].prod_cost;
                    auction_secs = rows[0].auction_time_secs;
                    incrementValue = rows[0].increment_value;
                    
                    BidClkgetUserDtls(auction_id,user_id,coins_per_bid,max_value,current_max_value,display_max_value,product_cost,auction_secs,incrementValue);
                }
            }
            else{
                console.log('error in BidClkgetAucDtls connection query '+err);
                //return false;                 
            }
        });             
    });    
}

function BidClkgetUserDtls(auction_id,user_id,coins_per_bid,max_value,current_max_value,display_max_value,product_cost,auction_secs,incrementValue){
    var user_coins;
    var username;    
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in BidClkgetUserDtls pool getConnection '+err);  
          //return false;
        }     
        connection.query("Select * from user_details where user_id ="+user_id,function(err,rows)
        {
            connection.release();
            if(!err) {
                if(rows.length === 1){
                    user_coins = rows[0].user_coins;
                    username = rows[0].first_name;
                    
                    BidClick(auction_id,user_id,coins_per_bid,max_value,current_max_value,display_max_value,product_cost,auction_secs,incrementValue,user_coins,username);
                }
            }
            else{
                console.log('error in BidClkgetUserDtls connection query '+err); 
                //return false;                 
            }
        });       
    });    
}

function BidClick(auction_id,user_id,coins_per_bid,max_value,current_max_value,display_max_value,product_cost,auction_secs,incrementValue,user_coins,username){
    var myCounter = "myCounter_"+auction_id;

    if (user_coins >= coins_per_bid){
        pool.getConnection(function(err,connection){
            if (err) {
              console.log('error Bid Click');  
              //return false;
            }        
            connection.query("Update user_details SET user_coins=user_coins-"+coins_per_bid+" Where user_id="+user_id,function(err,rows)
            {
                connection.release();
                if(!err) {

                }
                else{
                    console.log('error Bid Click'); 
                    //return false;                 
                }
            });
        });
        pool.getConnection(function(err,connection){
            if (err) {
              console.log('error Bid Click');  
              //return false;
            }        
            connection.query("INSERT INTO `user_bids`(`auction_id`, `user_id`, `system_user`, `added_date`, `updated_date`) VALUES ("+auction_id+","+user_id+",'N',now(),now())",function(err,rows)
            {
                connection.release();
                if(!err) {

                }
                else{
                    console.log('error Bid Click'); 
                    //return false;                 
                }
            });
        });
        
        if(current_max_value < max_value){
            pool.getConnection(function(err,connection){
                if (err) {
                  console.log('error Bid Click');  
                  //return false;
                }            
                connection.query("Update auction_details SET current_max_value=current_max_value+"+incrementValue+" Where auction_id="+auction_id,function(err,rows)
                {
                    connection.release();
                    if(!err) {

                    }
                    else{
                        console.log('error Bid Click'); 
                        //return false;                 
                    }
                });  
            });    
            display_max_value=current_max_value + incrementValue;
        }                  
       

        //call reset timer
        reset_timer(auction_id, myCounter[auction_id],product_cost,auction_secs,coins_per_bid);
        
        io.emit('CurrentMaxValue_'+auction_id, display_max_value);
        io.emit('CurrentWinningBidder_'+auction_id, username);
        
    }
    else{
        io.emit('userMsg','You do not have enough coins to bid for this Auction. Please purchase new coins to continue bidding.');
    }
}

/* User Bidding - end */






/* original function code*/
function Countdown(options) {
  var x;  
  var timer,
  instance = this,
  seconds = options.seconds || 10,
  updateStatus = options.onUpdateStatus || function () {},
  counterEnd = options.onCounterEnd || function () {};

  function decrementCounter() {
    updateStatus(seconds);
    if (seconds === x) {
      counterEnd();
      instance.stop();
    }
    seconds--;
  }

  this.start = function (startSec) {
    x = Math.floor((Math.random() * 6) + 1);      
    clearInterval(timer);
    timer = 0;
    //seconds = options.seconds;
    seconds = startSec;
    timer = setInterval(decrementCounter, 1000);
  };

  this.stop = function () {
    clearInterval(timer);
  };
}




/*
function Countdown(options) {
  var x;  
  this.timer;
  
  this.seconds = options.seconds;
  this.updateStatus = options.onUpdateStatus;
  this.counterEnd = options.onCounterEnd;

  function decrementCounter() {
    this.updateStatus(this.seconds);
    if (this.seconds === x) {
      this.counterEnd();
      this.stop();
    }
    this.seconds--;
  }

  this.start = function (startSec) {
    x = Math.floor((Math.random() * 6) + 1);      
    clearInterval(this.timer);
    this.timer = 0;
    //seconds = options.seconds;
    this.seconds = startSec;
    this.timer = setInterval(decrementCounter, 1000);
  };

  this.stop = function () {
    clearInterval(this.timer);
  };
}
*/