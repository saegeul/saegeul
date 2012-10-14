<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 

class Gallery extends MX_Controller { 
	protected $sid;
	
    public function __construct(){
    	$this->load->database();
    	$this->load->helper('url');
    	$this->load->helper('date');
    }

    public function index(){ 
    	$this->load->model('Gallery_model'); // 모델 - 호출
    	$data['result'] = $this->Gallery_model->get_entry();
    	
        $this->load->view('gallery', $data);
    }

    public function photo(){ 
    	$this->sid = 'root';
    	$this->module_srl = 'filebox';
    	
    	//DB Get
    	$this->load->model('Gallery_model'); // 모델 - 호출
    	$this->load->view('gallery') ;  
    } 


} 
/* End of file admin.php */
/* Location : ./modules/admin/admin.php */