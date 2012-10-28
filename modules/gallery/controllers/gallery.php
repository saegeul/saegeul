<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 

class Gallery extends MX_Controller { 
	protected $sid;
	
    public function __construct(){
    	$this->load->database();
    	$this->load->helper('url');
    	$this->load->helper('date');
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
