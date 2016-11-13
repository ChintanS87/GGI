<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends __APP__
{
    /*
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');
	}
    */
    
    public function index()
    {
        $this->db->select('*');
        $this->db->from('product_details p');
        $this->db->join('auction_details a', 'a.product_id = p.product_id');
        $this->db->where('a.is_active','Y');
        $query_live = $this->db->get();
        $this->data['live_products'] = $query_live->result_array();
        //$this->data['num_of_live_products'] = $query_live->num_rows();
        
        
        $this->db->select('*');
        $this->db->from('product_details p');
        $this->db->join('auction_details a', 'a.product_id = p.product_id');
        $this->db->where('a.is_active','U');
        $query_upcoming = $this->db->get();
        $this->data['upcoming_products'] = $query_upcoming->result_array();
 
        
        
        $this->db->select('*');
        $this->db->from('product_details p');
        $this->db->join('auction_details a', 'a.product_id = p.product_id');
        $this->db->where('a.is_active','C');
        $query_closed = $this->db->get();
        $this->data['closed_products'] = $query_closed->result_array();        
         

                 
        
        
        if (!$this->tank_auth->is_logged_in()) {
                  $this->data['loggedin']= 'false';   
            } else {
                $this->data['loggedin']= 'true';
                $data['user_id'] = $this->tank_auth->get_user_id();
		//$data['username'] = $this->tank_auth->get_username();
                                
                $this->data['userid'] = $this->tank_auth->get_user_id();
                $this->data['user_coins'] = $this->user_coins->select_sum('coins')->where('user_id',$data['user_id'])->get();
            }
            
        $this->load->view('/globals/header', $this->data);    
        $this->load->view('home', $this->data);
    }
    

    
    /*
	public function index()
	{
            if (!$this->tank_auth->is_logged_in()) {
                    redirect('/auth/login/');
            } else {
                    $this->data['user_id']	= $this->tank_auth->get_user_id();
                    $this->data['username']	= $this->tank_auth->get_username();


                    //$this->data['search_results'] = $this->auction->get();
                    $this->load->view('home', $this->data);
            }
	}
        
      */  
        
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */