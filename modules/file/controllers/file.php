<?php
class File extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));

	}

	function index()
	{
		$this->load->view('file');
	}

	function do_upload()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			echo 'aa';
// 			$error = array('error' => $this->upload->display_errors());
// 			$this->load->view('file', $error);
		}
		else
		{
			echo 'bb';
// 			$data = array('upload_data' => $this->upload->data());
// 			$this->load->view('upload', $data);
		}
	}
}
?>