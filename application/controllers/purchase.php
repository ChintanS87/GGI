<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Purchase extends __APP__
{

    
	public function index()
	{
            if (!$this->tank_auth->is_logged_in()) {
                    redirect('/auth/login/');
            } else {
                    $this->data['user_id']	= $this->tank_auth->get_user_id();
                    $this->data['username']	= $this->tank_auth->get_username();


                    //$this->data['search_results'] = $this->auction->get();
                    $this->load->view('purchase', $this->data);
            }
	}
        
       
        public function purchase_coins()
        {
            $payment_amount = $this->uri->segment(3);
            $coins = $this->uri->segment(4);
            
            $user_payments_insert = array('user_id' => $this->tank_auth->get_user_id(),
                                            'amount'=>$payment_amount,
                                            'added_date' => date('Y-m-d H:i:s'),
                                            'updated_date' => date('Y-m-d H:i:s')
                                            );                                        
            $this->db->insert('user_payments',$user_payments_insert);
            
            
            $this->data['current_coins_count'] = $this->user_details->where('user_id',$this->tank_auth->get_user_id())->get();
            foreach($this->data['current_coins_count'] as $row)
            {
                $current_coins_count = $row->user_coins;
            }
            $total_coins_count = $current_coins_count + $coins;
            $this->user_details->where('user_id',$this->tank_auth->get_user_id())->update('user_coins',$total_coins_count);
            
            redirect('/home/');
        }
}

/* End of file purchase.php */
/* Location: ./application/controllers/purchase.php */