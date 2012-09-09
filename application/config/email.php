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
$config['mailtype'] = 'html';
$config['charset'] = 'euc-kr';
$config['newline'] = "\r\n";
$config['smtp_host']='smtp.naver.com';
$config['smtp_user']='minix86@naver.com';
$config['smtp_pass']='704068';
$config['smtp_port']='465';
$config['protocol']='smtp';

/* End of file email.php */
/* Location: ./application/config/email.php */