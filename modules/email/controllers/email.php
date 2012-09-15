<?php
class Email extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->view('mailform');
	}

	function send()
	{
		$title = $_POST['title'];
		$senduser = $_POST['senduser'];
		$email = $_POST['email'];
		$body = $_POST['body'];

		//echo "send";
		$this->load->library('email');

		$this->email->from($email, $senduser);
		$this->email->to('jihye8944@naver.com');

		$this->email->subject($title);
		$this->email->message($body);
			
		if ( ! $this->email->send())
		{
	    	// Generate error
	    	echo "error";
		}
		
		echo "메일보내기 성공!";
		//echo $this->email->print_debugger();
		
	}
}