<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 

class Gallery extends MX_Controller { 
	protected $sid;
	
    public function __construct(){
    	$this->load->database();
    	$this->load->helper('url');
    	$this->load->helper('date');
    }

    public function index(){ 
        
    }

    public function photo(){ 
    	$this->sid = 'root';
    	$this->module_srl = 'filebox';
    	
    	//DB Get
    	$this->load->model('Gallery_model'); // 모델 - 호출
    	$data = $this->Gallery_model->get_entry($this->sid);
    	$files = array();
    	foreach($data as $key => $value){
    		$folder = date ('Ymd', strtotime ($value->reg_date));
    		$fold_url = 'filebox/files/img/' . $folder . '/';
    		if(is_file($fold_url . $value->source_img_name)){
    			$file = new stdClass();
    			$file->name = $value->source_img_name;
    			$file->size = filesize($fold_url . $value->source_img_name);
    			$file->url = base_url() . $fold_url . $value->source_img_name;
    			$file->thumbnail_url = base_url() . $fold_url . 'thumbs/' . $value->source_img_name;
    			$files[$key] = $file;
    		}
    	}
    	
    	$this->load->view('gallery',$files) ; 
    } 

    public function save(){ 

    } 

    public function remove(){ 

    } 
} 
/* End of file admin.php */
/* Location : ./modules/admin/admin.php */
