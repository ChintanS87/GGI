<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/
/*
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.googlemail.com';
$config['smtp_user'] = 'hajiali@shrimadrajchandramission.org';
$config['smtp_pass'] = 'GURUPREM';
$config['smtp_port'] = '465';
$config['charset']    = 'utf-8';
$config['newline']    = "\r\n";
$config['mailtype'] = 'html'; // or html
$config['validation'] = false; // bool whether to validate email or not
*/

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'relay-hosting.secureserver.net';
$config['smtp_user'] = 'hajiali@shrimadrajchandramission.org';
$config['smtp_pass'] = 'GURUPREM';
$config['smtp_port'] = '465';
$config['charset']    = 'utf-8';
$config['newline']    = "\r\n";
$config['mailtype'] = 'html'; // or html
$config['validation'] = false; // bool whether to validate email or not
/* End of file email.php */
/* Location: ./application/config/email.php */