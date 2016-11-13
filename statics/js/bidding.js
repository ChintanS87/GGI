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
    
    
});







pool.getConnection(function(err,connection){
    if (err) {
      console.log('error');  
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
    });
    connection.on('error', function(err) {
          console.log('error');
          //callback(false);
          return;
    });
});

function initialiseCountdown(noOfLiveAuctions, arrLiveAuctions) {         
    for (var i = 0; i < noOfLiveAuctions; i++) {        
        var myCounter = "myCounter_"+arrLiveAuctions[i].auction_id;
        var updatetimer = 'updateTimer_'+arrLiveAuctions[i].auction_id;        
        var auction_id = arrLiveAuctions[i].auction_id;
        var product_cost = arrLiveAuctions[i].prod_cost;
        var coins_per_bid = arrLiveAuctions[i].coins_per_bid;
        var SysBid = arrLiveAuctions[i].auction_system_bid;
        var AllowFreeUserWin = arrLiveAuctions[i].auction_allow_free_user_win;
        var auction_secs = arrLiveAuctions[i].auction_time_secs;
        
        myCounter  = new Countdown({  
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
                //if system bid is on
                if (SysBid === 'Y'){
                    var blnCTCSysBid = checkCTCSysBid(auction_id, product_cost,coins_per_bid);
                    // if CTC is recovered
                    if(blnCTCSysBid){
                        var WinningUserType = checkWinningUserType(auction_id);
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
        });         
        myCounter.start(auction_secs);
    }            
}


function SystemBid(auction_id,myCounter,product_cost,auction_secs,coins_per_bid){
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error System Bid');  
          //return false;
        }
        
        connection.query("INSERT INTO `user_bids`(`auction_id`, `user_id`, `system_user`, `added_date`, `updated_date`) VALUES ("+auction_id+",2,'Y',now(),now())",function(err,rows)
        {
            connection.release();
            if(!err) {
                reset_timer(auction_id, myCounter,product_cost,auction_secs,coins_per_bid);
                //return true;
            }
            else{
                console.log('error System Bid'); 
                //return false;                 
            }
        });
    });       
}


function UserBid(data){
    var auction_id = data.auction_id;
    var user_id = data.user_id;
    
    if (user_id === ''){
        alert('Please Login to Start bidding');
    }else{
        
    }
}


function reset_timer(auction_id,myCounter,product_cost,auction_secs,coins_per_bid){    
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error System Bid');  
          //return false;
        }
        
        connection.query("Select count(*) as bidCount from user_bids where system_user='N' and auction_id ="+auction_id,function(err,rows)
        {
            connection.release();
            if(!err) {
                total_coins = rows[0].bidCount * coins_per_bid;
                total_collected = total_coins * 3;                
                percentCTC = 100*total_collected / product_cost;
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
                console.log('error System Bid'); 
                //return false;                 
            }
        });
    });               
}



function CloseBid(auction_id){
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error Close Bid');  
          //return false;
        }
        
        connection.query("UPDATE auction_details SET is_active='C' WHERE auction_id ="+auction_id,function(err,rows)
        {
            connection.release();
            if(!err) {                                                
                //return true;
            }
            else{
                console.log('error Close Bid'); 
                //return false;                 
            }
        });
    });      
}


function checkWinningUserType(auction_id){
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error');  
          return false;
        }
        
        connection.query("SELECT * FROM user_details WHERE user_id in (SELECT user_id FROM user_bids WHERE auction_id ="+auction_id+" ORDER BY bid_id DESC LIMIT 1)",function(err,rows)
        {
            connection.release();
            if(!err) {                                                
                return rows[0].user_type;
            }
            else{ return false; }
        });
    });            
}


function checkCTCSysBid(auction_id, product_cost,coins_per_bid)
{       
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error');  
          return false;
        }
        connection.query("Select count(*) as bidCount from user_bids where system_user='N' and auction_id ="+auction_id,function(err,rows)
        {
            connection.release();
            if(!err) {                
                total_coins = rows[0].bidCount * coins_per_bid;
                total_collected = total_coins * 3;                
                if (total_collected >= product_cost){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{ return false; }
        });
    });        
}



function Countdown(options) {
  var timer,
  instance = this,
  seconds = options.seconds || 10,
  updateStatus = options.onUpdateStatus || function () {},
  counterEnd = options.onCounterEnd || function () {};

  function decrementCounter() {
    updateStatus(seconds);    
    if (seconds === 0) {
      counterEnd();
      instance.stop();
    }
    seconds--;
  }

  this.start = function (startSec) {
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
