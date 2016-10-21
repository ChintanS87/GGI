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
        if ($this->tank_auth->is_logged_in()) {
                $this->form_validation->set_rules('refer_num', 'Mobile Number', 'trim|required|xss_clean|numeric|min_length[10]|max_length[10]');
                if ($this->form_validation->run()) {
                    
// Replace with your username
$user = "rajul";
// Replace with your API KEY (We have sent API KEY on activation email, also available on panel)
$password = "rajul";
// Replace with the destination mobile Number to which you want to send sms
//$msisdn = $this->input->post('refer_num');
$msisdn = "9821211721";
// Replace if you have your own Six character Sender ID, or check with our support team.
$sid = "SMSHUB";
// Replace with client name
$NAME = "Anurag Sharrma";
// Replace if you have OTP in your template.
$OTP = "6765R";
// Replace with your Message content
$msg = "Dear .$NAME., Your OTP for gograbit.in is : ##OTP##";
$msg = urlencode($msg);
// Keep 0 if you don’t want to flash the message
$fl = "0";
// if you are using transaction sms api then keep gwid = 2 or if promotional then remove this parameter
$gwid = "2";
// For Plain Text, use "txt" ; for Unicode symbols or regional Languages like hindi/tamil/kannada use "uni"
$type = "txt";
$ch =
curl_init("http://cloud.smsindiahub.in/vendorsms/pushsms.aspx?user=".$user."&password=".$password."&ms
isdn=".$msisdn."&sid=".$sid."&msg=".$msg."&fl=".$fl."&gwid=".$gwid."");
 curl_setopt($ch, CURLOPT_HEADER, 0);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 $output = curl_exec($ch);
 curl_close($ch);
// Display MSGID of the successful sms push
echo $output;
echo "done";
die();
                }

                     $this->load->view('/globals/header');
                     $this->load->view('/refer');
            } else {
                redirect('/auth/login/');                
            }
            
        
    }
    
            
}

/* End of file refer.php */
/* Location: ./application/controllers/refer.php */