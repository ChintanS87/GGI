<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller
{
    
public function sendemail(){
        $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'hajiali@shrimadrajchandramission.org',
        'smtp_pass' => 'GURUPREM',
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('hajiali@shrimadrajchandramission.org', 'Deepak');
        $this->email->to('deepakdm8@gmail.com');
        $this->email->subject('Test Mail');
        $this->email->message('Test Codeigniter mail');
        if (!$this->email->send()) {
          show_error($this->email->print_debugger()); }
        else {
          echo 'Your e-mail has been sent!';
        }
      }
}


