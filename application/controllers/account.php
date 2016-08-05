<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account extends __APP__
{
    
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');                
	}

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

        
        public function facebook_auth($redirect_uri = '') {

            
            
            
            
            
            

		$user_id = $this->amplifier->getUser();		
		$user_profile = array();
		
		if($user_id) {
			try {
				$user_profile = $this->amplifier->api('/'.$user_id); 
			} catch (FacebookApiException $e) {
				error_log($e);
			}
			
			if(array_key_exists('email', $user_profile)) { 

			} else {
				$login_params = array(
						'redirect_uri' => site_url('auth/login'),
						'scope' => $this->config->item('fb_app_scope'),
				);
				
				echo 'Please wait while we redirect you...';
				echo '<script> top.location.href="' . $this->amplifier->getLoginUrl($login_params) . '";</script>';
				die();
			}			
		} else {
			$login_params = array(
					'redirect_uri' => site_url('auth/login'),
					'scope' => $this->config->item('app_scope'),
			);
				
			echo 'Please wait while we redirect you...';
			echo '<script> top.location.href="' . $this->amplifier->getLoginUrl($login_params) . '";</script>';
			die();
		}		
		redirect('account/step2');
 
	}
        
        public function step2()
        {
            echo 'login successful';
        }
        
        
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
