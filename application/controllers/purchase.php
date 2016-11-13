<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Purchase extends __APP__
{

    
	public function index()
	{
            if (!$this->tank_auth->is_logged_in()) {
                    redirect('/auth/login/');
            } else {
                redirect('/purchase/purchasecoins/');
            }
	}
        
       
        public function purchasecoins()
        {
            if (!$this->tank_auth->is_logged_in()) {
                    redirect('/auth/login/');
            } else {
                $redirectpage = 'false';
                
                $this->data['user_id'] = $this->tank_auth->get_user_id();
                $this->data['username'] = $this->tank_auth->get_username();

                $this->form_validation->set_rules('purchase_form_amount', 'Amount', 'trim|required|xss_clean|numeric');
                $this->form_validation->set_rules('purchase_form_coins', 'Coins', 'trim|required|xss_clean|numeric');

                if ($this->form_validation->run()) {
                    $this->data['purchase_form_coins'] = $this->input->post('purchase_form_coins');                                        
                    $this->data['amount'] = $this->input->post('purchase_form_amount');
                    
                    
                    $this->data['txnid'] = 'GGI'.substr(hash('sha256', mt_rand() . microtime()), 0, 20).mt_rand(100,999);                    
                    $this->data['userinfo'] = $this->user_details->where('user_id',$this->data['user_id'])->get();
                    foreach($this->data['userinfo'] as $row) {        
                        $this->data['firstname'] = $row->first_name;
                        $this->data['phone'] = $row->contact_number;
                    }        
                    
                    $query = $this->db->query("Select email from users where id=".$this->data['user_id']."");                                    
                    $row = $query->row();
                    if (isset($row))
                    {
                         $this->data['email'] = $row->email;
                    }
                    $this->data['productinfo'] = $this->data['purchase_form_coins'].' Coins';
                    
                    
                    $this->data['surl'] = base_url().'index.php/purchase/payum_payment_success';
                    $this->data['furl'] = base_url().'index.php/purchase/payum_payment_failure';
                    $this->data['key'] = 'Sv6Ywd7n';
                    $this->data['SALT'] = 'GguFpaTo3k';

                    $redirectpage = 'true';
                    
                    $user_payments_insert = array('user_id' => $this->tank_auth->get_user_id(),
                                                    'txn_id' => $this->data['txnid'],
                                                    'amount'=> $this->data['amount'],
                                                    'txn_status'=>'I',
                                                    'txn_coins'=> $this->data['purchase_form_coins'],
                                                    'added_date' => date('Y-m-d H:i:s'),
                                                    'updated_date' => date('Y-m-d H:i:s')
                                                    );                                        
                    $this->db->insert('user_payments',$user_payments_insert);                    
                }
                else {
                    $redirectpage = 'false';
                }

                if ($redirectpage=='false'){
                    $this->load->view('/globals/header', $this->data);
                    $this->load->view('purchase', $this->data);                        
                }
                else if($redirectpage=='true') {
                    $this->load->view('/globals/header', $this->data);
                    $this->load->view('payum', $this->data);                        
                }                
            }            
        }
        
        
        public function payum_payment()
        {   //function not used...was for payum ref         
            $this->data['amount'] = '1';
            $this->data['firstname'] = 'Rajul';
            $this->data['email'] = 'rajuldm@gmail.com';
            $this->data['phone'] = '9820031191';
            $this->data['productinfo'] = 'Test Product';
            $this->data['surl'] = base_url().'purchase/payum_payment_success.php';
            $this->data['furl'] = base_url().'purchase/payum_payment_failure.php';

            $this->data['key'] = 'Sv6Ywd7n';
            $this->data['SALT'] = 'GguFpaTo3k';
            $this->data['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        }
        
        
        public function payum_payment_success()
        {
            $status=$_POST["status"];
            $firstname=$_POST["firstname"];
            $amount=$_POST["amount"];
            $txnid=$_POST["txnid"];
            $posted_hash=$_POST["hash"];
            $key=$_POST["key"];
            $productinfo=$_POST["productinfo"];
            $email=$_POST["email"];
            $salt="GguFpaTo3k";

            
            If (isset($_POST["additionalCharges"])) {
                $additionalCharges=$_POST["additionalCharges"];
                $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
             }
             else {	  
                $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
             }
                                        
            $hash = hash("sha512", $retHashSeq);

            if ($hash != $posted_hash) {
                 echo "Invalid Transaction. Please try again";
             }
             else {
                    $query = $this->db->query("Select * from user_payments where user_id=".$this->tank_auth->get_user_id()." and txn_id='".$txnid."'");                                    
                    $row = $query->row();
                    if (isset($row))
                    {
                         $this->data['txn_coins'] = $row->txn_coins;
                    }                    
                    $user_coins_insert = array('user_id' => $this->tank_auth->get_user_id(),
                                                    'coins' => $this->data['txn_coins'],
                                                    'source'=> 'PUR',
                                                    'pur_txn_id'=> $txnid,
                                                    'added_date' => date('Y-m-d H:i:s'),
                                                    'updated_date' => date('Y-m-d H:i:s')
                                                    );                                        
                    $this->db->insert('user_coins',$user_coins_insert);

                    $this->payments->where('user_id',$this->tank_auth->get_user_id())->where('txn_id',$txnid)->update('txn_status','P');

                    $this->user_details->where('user_id',$this->tank_auth->get_user_id())->update(array('user_type' => 'P', 'user_coins' => 'user_coins +'.$this->data['txn_coins']), FALSE);
                    
                   echo "<h3>Thank You. Your order status is ". $status .".</h3>";
                   echo "<h4>Your Transaction ID for this transaction is ".$txnid.".</h4>";
                   echo "<h4>We have received a payment of Rs. " . $amount . ". Your order will soon be shipped.</h4>";
             }            
        }
        
        
        
        public function payum_payment_failure()
        {
            $status=$_POST["status"];
            $firstname=$_POST["firstname"];
            $amount=$_POST["amount"];
            $txnid=$_POST["txnid"];
            $posted_hash=$_POST["hash"];
            $key=$_POST["key"];
            $productinfo=$_POST["productinfo"];
            $email=$_POST["email"];
            $salt="GguFpaTo3k";

            If (isset($_POST["additionalCharges"])) {
               $additionalCharges=$_POST["additionalCharges"];
                $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
            }
            else {	  
                $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
            }

            $hash = hash("sha512", $retHashSeq);

            if ($hash != $posted_hash) {
                    echo "Invalid Transaction. Please try again";
            }
            else {
                //$this->payments->where('user_id',$this->tank_auth->get_user_id())->where('txn_id',$txnid)->update('txn_status','P');
                
                echo "<h3>Your order status is ". $status .".</h3>";
                echo "<h4>Your transaction id for this transaction is ".$txnid.". You may try making the payment by clicking the link below.</h4>";
            }                         
        }
        
        
}

/* End of file purchase.php */
/* Location: ./application/controllers/purchase.php */