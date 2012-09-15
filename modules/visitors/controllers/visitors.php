<?php
class Visitors extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		
		$this->load->model('visitors_model', '', TRUE);
		$data = "";
		$data['result'] = $this->visitors_model->visit();
	
		$this->load->view('guestbook', $data);

	}
	
	function write(){
		
		$this->load->helper('date');
		
		$passwd = $_POST['passwd'];
		$name = $_POST['name'];
		$comment = $_POST['comment'];
		
		$this->load->model('visitors_model', '', TRUE );
		$this->visitors_model->write($passwd, $name, $comment);
		
		$data = "";
		$data['result'] = $this->visitors_model->visit();
		$this->load->view('guestbook', $data);
	}
	
	function modify_view(){
		
		$idx = $_POST['idx'];
		$this->load->model('visitors_model', '', TRUE);
		$data = "";
		$data['result'] = $this->visitors_model->modify_view($idx);
		$this->load->view('modify', $data);
	}
	
	function modify(){
		
		$passwd = $_POST['passwd'];
		$name = $_POST['name'];
		$comment = $_POST['comment'];
		$idx = $_POST['idx'];
		
		$this->load->model('visitors_model', '', TRUE);
		$this->visitors_model->modify($passwd, $name, $comment, $idx);
		
		$data = "";
		$data['result'] = $this->visitors_model->visit();
		$this->load->view('guestbook', $data);
	}
	
	function delete(){
		$idx = $_POST['idx'];
		$this->load->model('visitors_model', '', TRUE);
		$data = "";
		$data['result'] = $this->visitors_model->delete($idx);
		
		$data = "";
		$data['result'] = $this->visitors_model->visit();
		$this->load->view('guestbook', $data);
	}
	
}
?>