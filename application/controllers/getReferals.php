<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class getReferals extends __APP__
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

        } else {
            redirect('/auth/login/');                
        }                    
    }
    
    

    public function fetchData()
    {                
            $contact_number = $this->input->post('contact_number');
                        
            $strOutput ="";
            $query = $this->db->query("Select r.id as ReferalId, r.referal_code as ReferalCode, r.referer_mobile as RefererMobile, u.first_name as FirstName from user_details u, referals r where u.user_id = r.referer_user_id and u.contact_number = r.referer_mobile and r.referal_status='O' and r.referred_mobile ='".$contact_number."'");                                    
            if ($query->num_rows() > 0)
            {
               foreach ($query->result() as $row)
               {
                  $strOutput = $strOutput."<input type='radio' name='referal' value='".$row->ReferalId."'>".$row->ReferalCode." [ ".$row->FirstName. " - Mobile Number - ". $row->RefererMobile. "]";
               }
            }
            else{
                $strOutput = "No referals for this number";
            }

            echo $strOutput;

            
            //$this->load->view('/globals/header');
            //$this->load->view('refer',$this->data);            
    }    

    
            
}

/* End of file refer.php */
/* Location: ./application/controllers/refer.php */