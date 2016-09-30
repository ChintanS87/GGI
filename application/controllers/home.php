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
        $live_products_array = array();           
        $this->data['live_auctions'] = $this->auction->where('is_active','Y')->get();
        foreach($this->data['live_auctions'] as $row) {        
            array_push($live_products_array, $row->product_id) ;
        }        
        $this->data['live_products'] = $this->product->where_in('product_id',$live_products_array)->get();
        


        $auction2 = new Auction();
        $product2 = new Product();
        $upcoming_products_array = array();           
        $this->data['upcoming_auctions'] = $auction2->where('is_active','U')->get();
        foreach($this->data['upcoming_auctions'] as $row) {        
            array_push($upcoming_products_array, $row->product_id) ;
        }        
        $this->data['upcoming_products'] = $product2->where_in('product_id',$upcoming_products_array)->get();

        
        $auction3 = new Auction();
        $product3 = new Product();        
        $closed_products_array = array();           
        $this->data['closed_auctions'] = $auction3->where('is_active','C')->get();
        foreach($this->data['closed_auctions'] as $row) {        
            array_push($closed_products_array, $row->product_id) ;
        }        
        $this->data['closed_products'] = $product3->where_in('product_id',$closed_products_array)->get();

        
        
        if (!$this->tank_auth->is_logged_in()) {
                  $this->data['loggedin']= 'false';   
            } else {
                $this->data['loggedin']= 'true';
                $data['user_id'] = $this->tank_auth->get_user_id();
		//$data['username'] = $this->tank_auth->get_username();
                $this->data['user_coins'] = $this->user_details->select('user_coins')->where('user_id',$data['user_id'])->get(); 
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