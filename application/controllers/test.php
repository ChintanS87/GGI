<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
use \Amplifier\Amplifier;
class Test extends CI_Controller
{
    
public function sendemail(){
        $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'relay-hosting.secureserver.net',
        'smtp_port' => '25',
        'smtp_user' => 'hajiali@shrimadrajchandramission.org',
        'smtp_pass' => 'GURUPREM',
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('hajiali@shrimadrajchandramission.org', 'GoGrabIt');
        $this->email->to('rajuldm@gmail.com');
        $this->email->subject('Test Mail');
        $this->email->message('Test Codeigniter mail');
        if (!$this->email->send()) {
          show_error($this->email->print_debugger()); }
        else {
          echo 'Your e-mail has been sent!';
        }
      }
      

    public function facebook_auth() {
        $redirect_uri = 'test/facebook_auth';

        $user = $this->amplifier->getUser();
        $user_profile = false;
        if ($user) {
            try {
                    $user_profile = $this->amplifier->api('/me');
                } catch (FacebookApiException $e) {
                    error_log('Facebook Exception: ' . $e);
                }

            $extended_perms = $this->amplifier->get_extended_perms();
            if (!isset($extended_perms['data'][0]['permission'])) {				
				$login_params = array(
                    'redirect_uri' => site_url($redirect_uri),
                    'scope' => $this->config->item('fb_app_scope'),
                );
                $login_url = $this->amplifier->getLoginUrl($login_params);
                  
                //print_r($extended_perms);
                //echo '<br/>'.var_dump(isset($extended_perms['data'][0]['permission']));
                        
                echo '<script> top.location.href="' . $login_url . '";</script>';
                die();
            } else {
/*                
                $query_web_reg = $this->db->where('email', $user_profile['email'])->where('facebook_uid','')->where('level',1)->from('users')->order_by('id','desc')->get(1);
                if ($query_web_reg->num_rows() == 0) {
                    
                    $query = $this->db->where('facebook_uid', $user_profile['id'])->from('users')->get();
                    if ($query->num_rows() == 0) {
                        $insert_data = array(
                            'facebook_uid' => $user_profile['id'],
                            'name' => $user_profile['name'],
                            'email' => $user_profile['email']
                        );
                        $this->db->insert('users', $insert_data);
                    } else {
                        $user_data = $query->row();
                        if ($user_data->email == "") {
                            $update_data = array(
                                'email' => $user_profile['email']
                            );
                            $this->db->where('facebook_uid', $user_profile['id'])->update('users', $update_data);
                        }
                    }

                    $query = $this->db->where('facebook_uid', $user_profile['id'])->from('users')->get();
                    $this->user->get_by_facebook_uid($user_profile['id']);
                    $profile = new Profile();
                    $profile->name = $user_profile['name'];
                    $profile->save($this->user);                                       
                }
*/

            }
            
            
            /* repeat what happens in tank auth */
            $this->session->set_userdata(array(
            		'user_id' => $this->user->id,
            		'username' => $this->user->email,
            		'status' => ($this->user->activated == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
            ));
            $this->users->update_login_info($this->user->id, $this->config->item('login_record_ip', 'tank_auth'), $this->config->item('login_record_time', 'tank_auth'));
            
            
            
        } elseif($this->input->get('error') == 'access_denied') {
        	$login_params = array(
        			'redirect_uri' => site_url($redirect_uri),
        			'scope' => $this->config->item('fb_app_scope'),
        	);
        	$this->session->set_userdata('access_denied', true);
        	redirect('home/index');
        } else {
            /* redirect to login uri */
            $login_params = array(
                'redirect_uri' => site_url($redirect_uri),
                'scope' => $this->config->item('fb_app_scope'),
            );
            ?>
            <html>
            	<head>
                    <meta property="fb:app_id" content="310534155952669" />
                    <meta property="og:image" content="<?php echo base_url(); ?>/statics/img/story.png" />					
            	</head>
            	<body>
            	<?php echo '<script> top.location.href="' . $this->amplifier->getLoginUrl($login_params) . '";</script>'; ?>
            	</body>
            </html>
            <?php 
            die();
        }

        redirect('home/index');
        
    }      
      
    

    
	public function facebook_auth_original($redirect_uri = '') {

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
				/* user is not valid, redirect to login uri */
				
				$login_params = array(
						'redirect_uri' => site_url('auth/login'),
						'scope' => $this->config->item('fb_app_scope'),
				);
				
				echo 'Please wait while we redirect you...';
				echo '<script> top.location.href="' . $this->amplifier->getLoginUrl($login_params) . '";</script>';
				die();
				
			}
			
		} else {
			
			/* redirect to login uri */
			$login_params = array(
					'redirect_uri' => site_url('account/login'),
					'scope' => $this->config->item('app_scope'),
			);
				
			echo 'Please wait while we redirect you...';
			echo '<script> top.location.href="' . $this->amplifier->getLoginUrl($login_params) . '";</script>';
			die();
		}
		
		redirect('home/index');
	}    
    
    
      
}


