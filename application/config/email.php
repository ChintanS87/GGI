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
/* config for sending mails from gmail account*/

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.googlemail.com';
$config['smtp_user'] = 'hajiali@shrimadrajchandramission.org';
$config['smtp_pass'] = 'GURUPREM';
$config['smtp_port'] = '465';
$config['charset']    = 'utf-8';
$config['newline']    = "\r\n";
$config['mailtype'] = 'html'; // or html
$config['validation'] = false; // bool whether to validate email or not




/* config for sending mails from godaddy account
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'localhost';
$config['smtp_user'] = 'rajul@holisticitsoln.com';
$config['smtp_pass'] = 'Deepak52';
$config['smtp_port'] = '25';
$config['charset']    = 'utf-8';
$config['newline']    = "\r\n";
$config['mailtype'] = 'html'; // or html
$config['validation'] = false; // bool whether to validate email or not
*/

/* End of file email.php */
/* Location: ./application/config/email.php */