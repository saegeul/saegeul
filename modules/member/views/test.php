<?php 

$this->load->library('email');

$this->email->from('mini86@naver.com', 'gon');
$this->email->to('leewangon@gmail.com');
//$this->email->cc('another@another-site.com');
//$this->email->bcc('them@their-site.com');

$this->email->subject('Email Test');
$this->email->message('Testing the email class.');

$this->email->send();

echo $this->email->print_debugger();



?>