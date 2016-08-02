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
            $this->data = array();
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$this->data['user_id']	= $this->tank_auth->get_user_id();
			$this->data['username']	= $this->tank_auth->get_username();
                        
                        
                        //$this->data['search_results'] = $this->auction->get();
			$this->load->view('home', $this->data);
		}
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */