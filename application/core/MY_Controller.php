<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use \Amplifier\Amplifier;
/* fix to supperess timezone warning */
date_default_timezone_set('Asia/Kolkata');

class __APP__ extends CI_Controller {

	protected $data;
	protected $user;
	
	function __construct() {
		parent::__construct();
		$this->__init();
	}
	
	private function __init() {

		/* load libraries, we are avoiding autoload.php because of cli issues */
		$this->load->database();
		$this->load->library('session');
		$this->load->library('datamapper');
		$this->load->library('tank_auth');
		$this->load->library('uri');
		$this->load->library('user_agent');
                $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters(' <p class="redColor small"><small>', '</small></p> ');
		//$this->load->library('amplifier', array('appId' => $this->config->item('fb_app_id'), 'secret' => $this->config->item('fb_app_secret'), 'fileUpload' => true));

		
		/* helpers */
		$this->load->helper('url');
		$this->load->helper('form');
		
		/* configs */
		$this->load->config('app');
                $this->amplifier = new Amplifier(
				array(
					'appId' => $this->config->item('fb_app_id'),
					'secret' => $this->config->item('fb_app_secret'),
				)
			);  
                
                

                $this->data = array();
                
                $this->product = new Product();
                $this->auction = new Auction();
                $this->user_details = new User_Details();
                $this->payments = new Payments();

/*                
		$this->user = new User();
		$this->user->get_by_id($this->tank_auth->get_user_id());
		$this->user->profile->get();
		$this->data['user'] = $this->user;
*/

		$this->data['system_message'] = null;
		
	}
	
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
