<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ;
class Guest extends MX_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('date');
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
		else
		{
			$this->load->model('Email_model');

			$insert_data;
			$insert_data['usermail'] = $email;
			$insert_data['reg_date'] = standard_date('DATE_ATOM',time());
			$insert_data['title'] = $title;

			$this->Email_model->insert_entry($insert_data);

			echo "success";
		}
		//$this->load->view('mailform');
		//echo $this->email->print_debugger();

	}
	function maillog(){
		$this->load->model('Email_model');

		$data['total_rows'] = $this->Email_model->countall();
		$data['per_page'] = 5;

		$data['page_num'] = $this->uri->segment(3,0);
		$data['total_rows'] = $this->Email_model->countall();
		$data['result'] = $this->Email_model->get_limit($data['per_page'], $data['page_num']);

			
		$this->load->library('pagination');

		$config['base_url'] = '/saegeul/guest/maillog';
		$config['total_rows'] = $data['total_rows'];
		$config['per_page'] = $data['per_page'];

		$config['full_tag_open'] = '<div class="pagination pagination-centered"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = 'Previous';
		$config['prev_tag_open'] = '<li class="prev">'; 
		$config['prev_tag_close'] = '</li>'; 
		$config['next_link'] = 'Next'; 
		$config['next_tag_open'] = '<li>'; 
		$config['next_tag_close'] = '</li>'; 
		$config['last_tag_open'] = '<li>'; 
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">'; 
		$config['cur_tag_close'] = '</a></li>'; 
		$config['num_tag_open'] = '<li>'; 
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$data['page_links'] = $this->pagination->create_links();
		$this->load->view('maillog_view', $data);

	}
}