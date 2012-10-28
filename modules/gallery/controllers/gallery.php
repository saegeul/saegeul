<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 

class Gallery extends MX_Controller { 
	protected $sid;
	
    public function __construct(){
    	$this->load->database();
    	$this->load->helper('url');
    	$this->load->helper('date');
    }

    public function index1(){ 
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

    public function getPhoto($page=1,$list_count=10) {
        $this->load->model('Gallery_model','gallery');
        $page = $this->input->get_post('page');
        $result = $this->gallery->getImageList($page,$list_count);
        $data['fileList'] = $result['list'];
        $data['pagination'] = $result['pagination'];
        $data['base_url'] = base_url();
        echo json_encode($data);

    }

    public function index($page=1,$list_count=10){
    	$data['action'] = 'fileList';
    	$this->load->model('Filebox/Filebox_model','filebox');
    
    	$result = $this->filebox->getFileList($page,$list_count);
    
    	$data['fileList'] = $result['list'];
    	$data['pagination'] = $result['pagination'];
    
    	$this->load->library('sg_layout');
    	$this->sg_layout->layout('admin/layout');
    	$this->sg_layout->module('gallery');
    
    	$this->sg_layout->add('header');
    	$this->sg_layout->add('sidebar');
    	$this->sg_layout->add('gallery');
    	$this->sg_layout->add('footer');
    
    	$this->sg_layout->show($data) ;
    }
    

} 
/* End of file admin.php */
/* Location : ./modules/admin/admin.php */
