<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Refer extends __APP__
{
    
    function __construct()
    {
            parent::__construct();

            $this->load->helper('url');
            $this->load->library('tank_auth');
    }
    
    
    public function index()
    {                
        if ($this->tank_auth->is_logged_in()) 
        {
            $this->data['success_msg']="";
            $this->data['error_msg'] ="";
            $this->form_validation->set_rules('refer_num', 'Mobile Number', 'trim|required|xss_clean|numeric|min_length[10]|max_length[10]');

            if ($this->form_validation->run()) {                                
                $this->data['referer_info'] = $this->user_details->where('user_id',$this->tank_auth->get_user_id())->get();
                foreach($this->data['referer_info'] as $row) {        
                    $this->data['referer_mobile'] = $row->contact_number;
                }
                                
                
                if($this->data['referer_mobile'] == $this->input->post('refer_num'))
                {
                    $this->data['error_msg'] ="The referal number cannot be the same as the user's number";  
                } else{
                    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $start = rand(0, strlen($characters));
                    $ref_char = substr($characters,$start,2);
                    $ref_num = mt_rand(1000,9999);
                    $this->data['OTP'] = $ref_char.$ref_num;

                    $referals_insert = array('referer_user_id' => $this->tank_auth->get_user_id(),
                                                        'referer_mobile' => $this->data['referer_mobile'],
                                                        'referal_code'=> $this->data['OTP'],
                                                        'referred_mobile'=> $this->input->post('refer_num'),
                                                        'referal_status'=> 'O',
                                                        'added_date' => date('Y-m-d H:i:s'),
                                                        'updated_date' => date('Y-m-d H:i:s')
                                                        );                                        
                    $this->db->insert('referals',$referals_insert);        
                    
                    
                    
                    $user = "rajul";
                    $password = "rajul";
                    $msisdn = $this->input->post('refer_num');
                    $sid = "SMSHUB";
                    $OTP = $this->data['OTP'];
                    $msg = "Dear Rajul, your password is ".$OTP.".";
                    $msg = urlencode($msg);
                    // Keep 0 if you don’t want to flash the message
                    $fl = "0";
                    // if you are using transaction sms api then keep gwid = 2 or if promotional then remove this parameter
                    $gwid = "2";
                    // For Plain Text, use "txt" ; for Unicode symbols or regional Languages like hindi/tamil/kannada use "uni"
                    $type = "txt";
                    $ch = curl_init("http://cloud.smsindiahub.in/vendorsms/pushsms.aspx?user=".$user."&password=".$password."&msisdn=".$msisdn."&sid=".$sid."&msg=".$msg."&fl=".$fl."&gwid=".$gwid."");
                    
                    curl_setopt($ch, CURLOPT_HEADER, 0);                     
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                     $output = curl_exec($ch);
                     curl_close($ch);
                    // Display MSGID of the successful sms push
                    //echo $output;
                     
                    $this->data['success_msg']="Referal code sent successfully to ".$this->input->post('refer_num');
                }
            }
                 $this->load->view('/globals/header');
                 $this->load->view('refer',$this->data);
        } else {
            redirect('/auth/login/');                
        }                    
    }
    
            
}

/* End of file refer.php */
/* Location: ./application/controllers/refer.php */