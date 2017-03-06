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



/* declaring global variables */
var currentSystemBidUser;
var myCounter= new Array();
var ObjAuction = new Array();
var ObjProduct = new Array();


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
    socket.on('UserAutobidOn',function(data){
        UserAutoBid(data);
    });    
    socket.on('UserAutobidOff',function(data){
        AutoBidOff(data);
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
    for (var i = 0; i < noOfLiveAuctions; i++) {              
        var auction_id = arrLiveAuctions[i].auction_id;
        //startCountdown(auction_id,arrLiveAuctions,i);
        startCountdown(auction_id,arrLiveAuctions[i]);
    }    
}


function startCountdown(auction_id,arrLiveAuctions){
//    ObjAuction[auction_id] = {"auction_id":arrLiveAuctions[i].auction_id,"auction_start":arrLiveAuctions[i].auction_start, "auction_end":arrLiveAuctions[i].auction_end, "is_active":arrLiveAuctions[i].is_active, "coins_per_bid":arrLiveAuctions[i].coins_per_bid, "max_value":arrLiveAuctions[i].max_value, "increment_value":arrLiveAuctions[i].increment_value, "auction_secs":arrLiveAuctions[i].auction_time_secs, "SysBid":arrLiveAuctions[i].auction_system_bid, "AllowFreeUserWin":arrLiveAuctions[i].auction_allow_free_user_win,"autobid_flag":arrLiveAuctions[i].autobid_flag,"winningBidder":0,"timerDiv":arrLiveAuctions[i].timerDiv};
//    ObjProduct[auction_id] = {"product_id": arrLiveAuctions[i].product_id,"prod_name": arrLiveAuctions[i].prod_name,"prod_desc": arrLiveAuctions[i].prod_desc,"product_cost": arrLiveAuctions[i].prod_cost,"prod_MRP": arrLiveAuctions[i].prod_MRP};                

    ObjAuction[auction_id] = {"auction_id":arrLiveAuctions.auction_id,"auction_start":arrLiveAuctions.auction_start, "auction_end":arrLiveAuctions.auction_end, "is_active":arrLiveAuctions.is_active, "coins_per_bid":arrLiveAuctions.coins_per_bid, "max_value":arrLiveAuctions.max_value, "increment_value":arrLiveAuctions.increment_value, "auction_secs":arrLiveAuctions.auction_time_secs, "SysBid":arrLiveAuctions.auction_system_bid, "AllowFreeUserWin":arrLiveAuctions.auction_allow_free_user_win,"autobid_flag":arrLiveAuctions.autobid_flag,"winningBidder":0,"timerDiv":arrLiveAuctions.timerDiv};
    ObjProduct[auction_id] = {"product_id": arrLiveAuctions.product_id,"prod_name": arrLiveAuctions.prod_name,"prod_desc": arrLiveAuctions.prod_desc,"product_cost": arrLiveAuctions.prod_cost,"prod_MRP": arrLiveAuctions.prod_MRP};                

    myCounter[auction_id]  = new Countdown({
        auctionId: ObjAuction[auction_id].auction_id,
        seconds: ObjAuction[auction_id].auction_secs,
        onUpdateStatus: function(sec){
            //if hours are added to the bid system..keeping commented code 
            //hours = Math.floor(totalSeconds / 3600);
            //totalSeconds %= 3600; 

            var minutes;
            var seconds;
            var minsText;
            var secsText;

            minutes = Math.floor(sec / 60);
            seconds = sec % 60;
            if (minutes < 10){ minsText = "0"+ minutes; } else { minsText = minutes;}
            if (seconds < 10){ secsText = "0"+ seconds; } else { secsText = seconds;}

            io.emit(ObjAuction[auction_id].timerDiv,minsText +':'+secsText);
            //console.log("UpdateTimer:"+ObjAuction[auction_id].timerDiv+ " Value:"+minsText +':'+secsText);
        },
        onCounterEnd: function(){
            io.emit(ObjAuction[auction_id].timerDiv,'Checking...');

            if(ObjAuction[auction_id].autobid_flag === 'Y')
            {
                CheckAutoBidUser(auction_id);
            }
            else{
                checkCTCSysBid(auction_id);                                                                    
            }                
        }
    });         
    myCounter[auction_id].start(ObjAuction[auction_id].auction_secs);       
}




/* Autobidding Functions on Counter End - Start */

function CheckAutoBidUser(auction_id){
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in CheckAutoBidUser pool getConnection '+err);  
          //return false;
        }
        connection.query("Select * from autobid Where auction_id = "+auction_id+" and active_flag = 'Y' and current_autobids < no_autobids and bid_flag = (Select min(bid_flag) from autobid where auction_id = "+auction_id+" and active_flag = 'Y' and current_autobids < no_autobids) Order By id ASC Limit 1",function(err,rows)
        {            
            connection.release();
            if(!err) {
                if(rows.length >0){
                    if(ObjAuction[auction_id].winningBidder === rows[0].user_id)
                    {
                        SystemBid(auction_id);
                    }
                    else{
                        CheckUserBalanceForAutoBid(auction_id,rows[0].id,rows[0].user_id);                        
                    }
                }
                else{
                    CloseAuctionAutoBid(auction_id);
                }
            }
            else{ 
                console.log('error in CheckAutoBidUser connection query '+err);
            }
        });
    });    
}


function CloseAuctionAutoBid(auction_id){
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in CloseAuctionAutoBid pool getConnection '+err);  
          //return false;
        }
        connection.query("Update auction_details Set autobid_flag='N' Where auction_id="+auction_id,function(err,rows)
        {            
            connection.release();
            if(!err) {
                ObjAuction[auction_id].active_flag = 'N';
                SystemBid(auction_id);
            }
            else{ 
                console.log('error in CloseAuctionAutoBid connection query '+err);
            }
        });
    });        
}


function CheckUserBalanceForAutoBid(auction_id,autobid_id,user_id){
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in CheckUserBalanceForAutoBid pool getConnection'+err);  
          //return false;
        }        
        connection.query("Select * From user_details where user_id ="+user_id,function(err,rows)
        {
            //connection.release();
            if(!err) {
                var reqCoins = ObjAuction[auction_id].coins_per_bid;
                var userCoins = rows[0].user_coins;
                
                if(userCoins >= reqCoins){
                    System_UserAutoBidClick(auction_id,autobid_id,user_id);
                }                
                else{
                    connection.query("Update autobid Set active_flag='N' Where id="+autobid_id,function(err,rows)
                    {
                        connection.release();
                        if(!err) {
                            CheckAutoBidUser(auction_id);
                        }
                        else{
                            console.log('error in CheckUserBalanceForAutoBid connection query2 '+err);  
                            //return false;                 
                        }
                    });             
                }
            }
            else{
                console.log('error in CheckUserBalanceForAutoBid connection query '+err);  
                //return false;                 
            }
        });             
    });          
}


function System_UserAutoBidClick(auction_id,autobid_id,user_id){
    BidClkgetAucDtls(auction_id, user_id);
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in System_UserAutoBidClick pool getConnection'+err);  
          //return false;
        }        
        connection.query("Update auction_autobid_counter Set autobid_counter=autobid_counter+1 Where auction_id="+auction_id,function(err,rows)
        {
            //connection.release();
            if(!err) {                
                connection.query("Select * From auction_autobid_counter Where auction_id="+auction_id,function(err,rows)
                {
                    connection.release();
                    if(!err) {
                        UpdateAutobid(auction_id,autobid_id,user_id,rows[0].autobid_counter);
                    }
                    else{
                        console.log('error in System_UserAutoBidClick connection query2 '+err);  
                        //return false;                 
                    }
                });                             
            }
            else{
                console.log('error in System_UserAutoBidClick connection query '+err);  
                //return false;                 
            }
        });             
    });          
}


function UpdateAutobid(auction_id,autobid_id,user_id,autobid_counter){
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in UpdateAutobid pool getConnection'+err);  
          //return false;
        }        
        connection.query("Update autobid Set current_autobids=current_autobids+1, bid_flag="+autobid_counter+" Where id="+autobid_id,function(err,rows)
        {
            //connection.release();
            if(!err) {                
                connection.query("Select * From autobid Where id="+autobid_id,function(err,rows)
                {
                    //connection.release();
                    if(!err) {
                        if(rows[0].no_autobids === rows[0].current_autobids){
                            connection.query("Update autobid Set active_flag='N' Where id="+autobid_id,function(err,rows)
                            {
                                connection.release();
                                if(!err) {

                                }
                                else{
                                    console.log('error in UpdateAutobid connection query3 '+err);  
                                    //return false;                 
                                }
                            });                                                                                     
                        }
                    }
                    else{
                        console.log('error in UpdateAutobid connection query2 '+err);  
                        //return false;                 
                    }
                });                             
            }
            else{
                console.log('error in UpdateAutobid connection query '+err);  
                //return false;                 
            }
        });             
    });              
}
/* Autobidding Functions on Counter End - End */



/* System Bidding and Checks - start */
function checkCTCSysBid(auction_id)
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
                total_coins = rows[0].bidCount * ObjAuction[auction_id].coins_per_bid;
                total_collected = total_coins * 3;     //3 is cost per coin           
                if (total_collected >= ObjProduct[auction_id].product_cost){
                    //return true;
                    blnCTC = true;
                }
                else{
                    //return false;
                    blnCTC = false;
                }    
                checkWinningUserType(auction_id,blnCTC);
            }
            else{ 
                console.log('error in checkCTCSysBid connection query '+err);
            }
        });
    });        
}


function checkWinningUserType(auction_id,blnCTC){
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
                            }
                            onCounterEndFunction(auction_id,blnCTC,WinningUserType);
                        }
                        else{ 
                            console.log('error in checkWinningUserType connection query2 '+err);
                            //return false; 
                        }                                                                
                    });                                        
                }
                else{
                    onCounterEndFunction(auction_id,blnCTC,WinningUserType);                
                }
            }
            else{ 
                console.log('error in checkWinningUserType connection query '+err);                  
                //return false; 
            }
        });
    });            
}




function onCounterEndFunction(auction_id,blnCTC,WinningUserType){   
    //if SysBid is true
    if (ObjAuction[auction_id].SysBid === 'Y'){        
        // if CTC is recovered
        if(blnCTC){
            //if free user is winning
            if (WinningUserType === 'F'){
                if(ObjAuction[auction_id].AllowFreeUserWin === 'Y'){
                    //close the bid
                    CloseBid(auction_id);
                    io.emit(ObjAuction[auction_id].timerDiv,'This Bid is Closed');
                    //to do - disable the bid button
                }
                else{
                    //system bid
                    SystemBid(auction_id);
                }                            
            }
            //if paid user is winning
            if (WinningUserType === 'P'){
                //close the bid
                 CloseBid(auction_id);
                 io.emit(ObjAuction[auction_id].timerDiv,'This Bid is Closed');
                 //to do - disable the bid button                
            }
            //if System user is winning
            if (WinningUserType === 'S'){
                //to do - check last 10 bids for this auction if all are system then close the bid
            }
        }
        else{
            //Do System Bid
            SystemBid(auction_id);
        }
    }
    else{
        // close bid
        CloseBid(auction_id);
        io.emit(ObjAuction[auction_id].timerDiv,'This Bid is Closed');
        //to do - disable the bid button
    }    
}


function SystemBid(auction_id){
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in System Bid pool getConnection '+err);  
          //return false;
        }
        var x;      
        x = Math.floor((Math.random() * 5) + 1);
        //check to ensure that the same system user is not bidding again
        while (x === ObjAuction[auction_id].winningBidder){
            x = Math.floor((Math.random() * 5) + 1);           
        }
        
        ObjAuction[auction_id].winningBidder = x;
                        
        connection.query("INSERT INTO `user_bids`(`auction_id`, `user_id`, `system_user`, `added_date`, `updated_date`) VALUES ("+auction_id+","+x+",'Y',now(),now())",function(err,rows)
        {
            connection.release();
            if(!err) {
                SystemBidGetAucDtls(auction_id,x);
                //reset_timer(auction_id);
            }
            else{
                console.log('error in System Bid connection query '+err); 
                //return false;                 
            }
        });
    });       
}


function SystemBidGetAucDtls(auction_id, user_id){
    var current_max_value;
    
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in SystemBidGetAucDtls pool getConnection '+err);  
          //return false;
        }        
        connection.query("Select * from auction_details where auction_id ="+auction_id,function(err,rows)
        {
            connection.release();
            if(!err) {
                if(rows.length === 1){
                    current_max_value = rows[0].current_max_value;
                    
                    SystemBidGetUserDtls(auction_id,user_id,current_max_value);
                }
            }
            else{
                console.log('error in SystemBidGetAucDtls connection query '+err);
                //return false;                 
            }
        });             
    });    
}

function SystemBidGetUserDtls(auction_id,user_id,current_max_value){
    var ObjUser;

    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in SystemBidGetUserDtls pool getConnection '+err);  
          //return false;
        }     
        connection.query("Select * from user_details where user_id ="+user_id,function(err,rows)
        {
            connection.release();
            if(!err) {
                if(rows.length === 1){
                    ObjUser = {"username":rows[0].first_name,"user_coins":rows[0].user_coins};
                    
                    SystemBidUpdateWinner(auction_id,user_id,current_max_value,ObjUser);
                }
            }
            else{
                console.log('error in SystemBidGetUserDtls connection query '+err); 
                //return false;                 
            }
        });       
    });    
}


function SystemBidUpdateWinner(auction_id,user_id,current_max_value,ObjUser){
        var display_max_value;
        
        if(current_max_value < ObjAuction[auction_id].max_value){
            pool.getConnection(function(err,connection){
                if (err) {
                  console.log('error SystemBidUpdateWinner');  
                  //return false;
                }            
                connection.query("Update auction_details SET current_winning_bidder="+user_id+", current_max_value=current_max_value+"+ObjAuction[auction_id].increment_value+" Where auction_id="+auction_id,function(err,rows)
                {
                    connection.release();
                    if(!err) {

                    }
                    else{
                        console.log('error SystemBidUpdateWinner'); 
                        //return false;                 
                    }
                });  
            });    
            
            console.log("Before");
            console.log("Sys Bid Display "+display_max_value);            
            console.log("Sys Bid Increment "+ObjAuction[auction_id].increment_value);
            console.log("Sys Bid Current "+current_max_value);            
            
            display_max_value= current_max_value + ObjAuction[auction_id].increment_value;
            
            console.log("After");
            console.log("Sys Bid Display "+display_max_value);            
            console.log("Sys Bid Increment "+ObjAuction[auction_id].increment_value);
            console.log("Sys Bid Current "+current_max_value);            
        }
        else{ display_max_value = current_max_value; }
       
 
        //call reset timer
        reset_timer(auction_id);
        
        ObjAuction[auction_id].winningBidder = user_id;
        
        io.emit('CurrentMaxValue_'+auction_id, display_max_value);
        io.emit('CurrentWinningBidder_'+auction_id, ObjUser.username);        
    
}





function reset_timer(auction_id){
    var total_coins;
    var total_collected;
    var percentCTC;
    var NewSeconds;
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in reset timer pool getConnection '+err);  
          //return false;
        }        
        connection.query("Select count(*) as bidCount from user_bids where system_user='N' and auction_id ="+auction_id,function(err,rows)
        {
            connection.release();
            if(!err) {                
                total_coins = rows[0].bidCount * ObjAuction[auction_id].coins_per_bid;
                total_collected = total_coins * 3;      //3 is the cost per coin          
                percentCTC = 100*total_collected/ ObjProduct[auction_id].product_cost;
                if(percentCTC < 25){
                    NewSeconds = ObjAuction[auction_id].auction_secs;
                }else if (percentCTC >= 25 && percentCTC< 50){
                    NewSeconds = 0.75 * ObjAuction[auction_id].auction_secs;
                }else if(percentCTC >= 50 && percentCTC< 75){
                    NewSeconds = 0.5 * ObjAuction[auction_id].auction_secs;
                }else if(percentCTC >= 75 && percentCTC< 100){
                    NewSeconds = 0.25 * ObjAuction[auction_id].auction_secs;
                }else if(percentCTC >= 100 && percentCTC < 125){
                    NewSeconds = 0.15 * ObjAuction[auction_id].auction_secs;
                }else if(percentCTC >= 125){
                    NewSeconds = 0.10 * ObjAuction[auction_id].auction_secs;
                }
                 
                myCounter[auction_id].start(NewSeconds);
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
    var current_max_value;
    
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in BidClkgetAucDtls pool getConnection '+err);  
          //return false;
        }        
        connection.query("Select * from auction_details where auction_id ="+auction_id,function(err,rows)
        {
            connection.release();
            if(!err) {
                if(rows.length === 1){
                    current_max_value = rows[0].current_max_value;
                    
                    BidClkgetUserDtls(auction_id,user_id,current_max_value);
                }
            }
            else{
                console.log('error in BidClkgetAucDtls connection query '+err);
                //return false;                 
            }
        });             
    });    
}

function BidClkgetUserDtls(auction_id,user_id,current_max_value){
    var ObjUser;

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
                    ObjUser = {"username":rows[0].first_name,"user_coins":rows[0].user_coins};
                    
                    BidClick(auction_id,user_id,current_max_value,ObjUser);
                }
            }
            else{
                console.log('error in BidClkgetUserDtls connection query '+err); 
                //return false;                 
            }
        });       
    });    
}

function BidClick(auction_id,user_id,current_max_value,ObjUser){
    var display_max_value;
    if (ObjUser.user_coins >= ObjAuction[auction_id].coins_per_bid){
        pool.getConnection(function(err,connection){
            if (err) {
              console.log('error Bid Click Update User deatils');  
              //return false;
            }        
            connection.query("Update user_details SET user_coins=user_coins-"+ObjAuction[auction_id].coins_per_bid+" Where user_id="+user_id,function(err,rows)
            {
                connection.release();
                if(!err) {

                }
                else{
                    console.log('error Bid Click Update User Details'); 
                    //return false;                 
                }
            });
        });
        pool.getConnection(function(err,connection){
            if (err) {
              console.log('error Bid Click Insert User Bids');  
              //return false;
            }        
            connection.query("INSERT INTO `user_bids`(`auction_id`, `user_id`, `system_user`, `added_date`, `updated_date`) VALUES ("+auction_id+","+user_id+",'N',now(),now())",function(err,rows)
            {
                connection.release();
                if(!err) {
                    
                }
                else{
                    console.log('error Bid Click Insert User Bids'); 
                    //return false;                 
                }
            });
        });
        
        if(current_max_value < ObjAuction[auction_id].max_value){
            pool.getConnection(function(err,connection){
                if (err) {
                  console.log('error Bid Click Update Auction Details');  
                  //return false;
                }            
                connection.query("Update auction_details SET current_winning_bidder="+user_id+", current_max_value=current_max_value+"+ObjAuction[auction_id].increment_value+" Where auction_id="+auction_id,function(err,rows)
                {
                    connection.release();
                    if(!err) {

                    }
                    else{
                        console.log('error Bid Click Update Auction Details'); 
                        //return false;                 
                    }
                });  
            });    
            display_max_value=current_max_value + ObjAuction[auction_id].increment_value;
            console.log("User Bid Current "+display_max_value);            
            console.log("User Bid Increment "+ObjAuction[auction_id].increment_value);
            console.log("User Bid Display "+current_max_value);
        }
        else{ display_max_value = current_max_value; }
       
       
        //call reset timer
        reset_timer(auction_id);
        
        ObjAuction[auction_id].winningBidder = user_id;
        
        io.emit('CurrentMaxValue_'+auction_id, display_max_value);
        io.emit('CurrentWinningBidder_'+auction_id, ObjUser.username);        
    }
    else{
        io.emit('userMsg','You do not have enough coins to bid for this Auction. Please purchase new coins to continue bidding.');
    }
}

/* User Bidding - end */




/* User AutoBidding - start */

/* Turn on Autobid - Start */
function UserAutoBid(data){        
    var user_id = data.user_id;
    
    if (user_id === 0){
        io.emit('userMsg','Please Login to Start bidding');
    }else{
        CheckActiveAutobidsForUserAuc(data);
    }
}


function CheckActiveAutobidsForUserAuc(data){
    var auction_id = data.auction_id;
    var user_id = data.user_id;

    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in CheckActiveAutobidsForUserAuc pool getConnection'+err);  
          //return false;
        }        
        connection.query("Select * From autobid Where auction_id="+auction_id+" and user_id="+user_id+" and active_flag='Y'",function(err,rows)
        {
            connection.release();
            if(!err) {
                if(rows.length === 0){
                    CheckUserBalance(data);
                }                
                else{
                    io.emit('userMsg','You have already set Autobid for this Auction');
                }
            }
            else{
                console.log('error in CheckActiveAutobidsForUserAuc connection query'+err);  
                //return false;                 
            }
        });             
    });         
}



function CheckUserBalance(data){
    var auction_id = data.auction_id;
    var user_id = data.user_id;
    var autobidCount = data.autobidCount;

    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in CheckUserBalance pool getConnection'+err);  
          //return false;
        }        
        connection.query("Select * From user_details where user_id ="+user_id,function(err,rows)
        {
            connection.release();
            if(!err) {
                var reqCoins = ObjAuction[auction_id].coins_per_bid * autobidCount;
                var userCoins = rows[0].user_coins;
                
                if(userCoins >= reqCoins){
                    SetUserAutoBid(data);
                }                
                else{
                    io.emit('userMsg','You do not have enough coins to Autobid '+autobidCount+' times for this auction');
                }
            }
            else{
                console.log('error in CheckUserBalance connection query'+err);  
                //return false;                 
            }
        });             
    });      
}


function SetUserAutoBid(data){
    var auction_id = data.auction_id;
    var user_id = data.user_id;
    var autobidCount = data.autobidCount;
    
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in SetUserAutoBid pool getConnection '+err);  
          //return false;
        }        
        connection.query("INSERT INTO `autobid`(`auction_id`, `user_id`, `active_flag`,`bid_flag`,`no_autobids`,`current_autobids`, `added_date`, `updated_date`) VALUES ("+auction_id+","+user_id+",'Y',0,"+autobidCount+",0,now(),now())",function(err,rows)
        {
            connection.release();
            if(!err) {

            }
            else{
                console.log('error in SetUserAutoBid connection query '+err);
                //return false;                 
            }
        });             
    });      

    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in SetUserAutoBid pool getConnection2 '+err);  
          //return false;
        }        
        connection.query("Update auction_details Set autobid_flag='Y' where auction_id="+auction_id,function(err,rows)
        {
            connection.release();
            if(!err) {

            }
            else{
                console.log('error in SetUserAutoBid connection query2 '+err);
                //return false;                 
            }
        });             
    });
    
    ObjAuction[auction_id].autobid_flag = 'Y';
}
/* Turn on Autobid - End */



/* Turn off Autobid - Start */
function AutoBidOff(data){
    var user_id = data.user_id;
    
    if (user_id === 0){
        io.emit('userMsg','Please Login to Start bidding');
    }else{
        TurnOffUserAutoBids(data);
    }    
}

function TurnOffUserAutoBids(data){
    var auction_id = data.auction_id;
    var user_id = data.user_id;
    
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in TurnOffUserAutoBids pool getConnection2 '+err);  
          //return false;
        }        
        connection.query("Select * From autobid where auction_id="+auction_id+" and user_id="+user_id+" and active_flag='Y'",function(err,rows)
        {
            //connection.release();
            if(!err) {
                var noRecords = rows.length;
                
                if (noRecords === 0)
                { io.emit('userMsg','No active autobids'); }
                else
                {
                    var recordid = rows[0].id;
                    connection.query("Update autobid Set active_flag='N' Where id="+recordid,function(err,rows)
                    {                        
                        connection.release();
                        if(!err) {
                            CheckAnyActiveAutoBids(data);
                        }
                        else{ 
                            console.log('error in TurnOffUserAutoBids connection query2 '+err);
                            //return false; 
                        }                                                                
                    });                                                                                
                }
            }
            else{
                console.log('error in TurnOffUserAutoBids connection query '+err);
                //return false;                 
            }
        });             
    });    
}


function CheckAnyActiveAutoBids(data){
    var auction_id = data.auction_id;
    
    pool.getConnection(function(err,connection){
        if (err) {
          console.log('error in CheckAnyActiveAutoBids pool getConnection2 '+err);  
          //return false;
        }        
        connection.query("Select * From autobid where auction_id="+auction_id+" and active_flag='Y'",function(err,rows)
        {
            //connection.release();
            if(!err) {
                if(rows.length > 0){
                    //leave autobid flag as true 'Y' in ObjAuction and in auction_details
                }
                else{
                    ObjAuction[auction_id].autobid_flag = 'N';
                    connection.query("Update auction_details Set autobid_flag='N' Where auction_id="+auction_id,function(err,rows)
                    {                        
                        connection.release();
                        if(!err) {
                            
                        }
                        else{ 
                            console.log('error in CheckAnyActiveAutoBids connection query2 '+err);
                            //return false; 
                        }                                                                
                    });                                                                                                    
                }                
            }
            else{
                console.log('error in CheckAnyActiveAutoBids connection query '+err);
                //return false;                 
            }
        });             
    });        
}

/* Turn off Autobid - End */


/* User AutoBidding - end */






/* original function code*/
function Countdown(options) {
  var x;  
  var timer,
  instance = this,
  auctionId = options.auctionId,
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
    if(ObjAuction[auctionId].autobid_flag === 'Y'){ x = 0; }
    else{ x = Math.floor((Math.random() * 6) + 1); }     
      
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
  this.x;  
  this.timer;
  
  this.auctionId = options.auctionId;
  this.seconds = options.seconds;
  this.updateStatus = options.onUpdateStatus;
  this.counterEnd = options.onCounterEnd;

  this.decrementCounter = function () {
    this.updateStatus(this.seconds);
    if (this.seconds === this.x) {
      this.counterEnd();
      this.stop();
    }
    this.seconds--;
  }

  this.start = function (startSec) {
    if(ObjAuction[this.auctionId].autobid_flag === 'Y'){ this.x = 0; }
    else{ this.x = Math.floor((Math.random() * 6) + 1); }     
      
    clearInterval(this.timer);
    this.timer = 0;
    //seconds = options.seconds;
    this.seconds = startSec;
    this.timer = setInterval(this.decrementCounter, 1000);
  };

  this.stop = function () {
    clearInterval(this.timer);
  };
}

*/ 