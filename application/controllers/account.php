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
                echo 'user id retrieved';
                die();
                try {
                        $user_profile = $this->amplifier->api('/'.$user_id); 
                    } catch (FacebookApiException $e) {
                            error_log($e);
                    }
			
                    if(array_key_exists('email', $user_profile)) {

                        /* user is valid */
                        $query = $this->db->where('facebook_uid', $user_profile['id'])->from('users')->get();
                        if ($query->num_rows() == 0) {
                            $insert_data = array(
                                            'facebook_uid' => $user_profile['id'],
                                            'email' => $user_profile['email'],
                                            'username' => $user_profile['email'],
                                            'password' => uniqid(),
                                            'last_ip' => $this->input->ip_address()
                            );

                            $this->db->insert('users', $insert_data);

                            $profile_insert_data = array(
                                            'user_id' => $this->db->insert_id(),
                                            'first_name' => $user_profile['first_name'],
                                            'last_name' => $user_profile['last_name']
                                    );
                            $this->db->insert('user_details', $profile_insert_data);

                            /* Please fill your profile emial */
                            /*
                            $this->load->library('email');
                            $this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
                            $this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
                            $this->email->to($this->user->email);
                            $this->email->subject("Thank You for registering, please complete your profile");
                            $this->email->message($this->load->view('email/registration_complete-html', array('name' => $profile_insert_data['name']), TRUE));
                            $this->email->send();
                             * 
                             */
                        } else {
                            $user_data = $query->row();
                            if ($user_data->email == "") {
                                    $update_data = array(
                                            'email' => $user_profile['email']
                                    );
                                    $this->db->where('facebook_uid', $user_profile['id'])->update('users', $update_data);
                            }
                        }
                        /* populate user model */
                        $this->user->where('facebook_uid', $user_profile['id'])->get();

                        /* login user like a normal user */
                        /* repeat what happens in tank auth */
                        $this->session->set_userdata(array(
                                        'user_id' => $this->user->id,
                                        'username' => $this->user->email,
                                        'status' => 1,
                        ));

                        /*$this->load->model('tank_auth/users', 'users_model');
                        $this->users_model->update_login_info($this->user->id, $this->config->item('login_record_ip', 'tank_auth'), $this->config->item('login_record_time', 'tank_auth'));
                        */
                    } else {
                        /* user is not valid, redirect to login uri */				
                        $login_params = array(
                                        'redirect_uri' => site_url('account/facebook_auth'),
                                        'scope' => $this->config->item('fb_app_scope'),
                        );

                        echo 'Please wait while we redirect you...';
                        echo '<script> top.location.href="' . $this->amplifier->getLoginUrl($login_params) . '";</script>';
                        die();				
                    }			
            } else {			
                /* redirect to login uri */
                $login_params = array(
                                'redirect_uri' => site_url('account/facebook_auth'),
                                'scope' => $this->config->item('fb_app_scope'),
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
