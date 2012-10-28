<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Filebox extends MX_Controller {

	// DB isert user information
	protected $username;
	protected $email;
	protected $uid;

	// class construct
	public function __construct() {
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->library('tank_auth');

		// get session data
		$this->username = $this->tank_auth->get_username();
		$this->uid = $this->tank_auth->get_user_id();
		$this->email = $this->tank_auth->get_useremail();

	}

	// uploadForm : view
	public function uploadForm(){
		$data['action'] = "uploadForm";
		$this->load->library('sg_layout');

		$this->sg_layout->layout('admin/layout');
		$this->sg_layout->module('filebox');

		$this->sg_layout->add('admin/header');
		$this->sg_layout->add('admin/sidebar');
		$this->sg_layout->add('admin/uploadForm');
		$this->sg_layout->add('admin/footer');

		$this->sg_layout->show($data);
	}

	// uploadForm : click event process
	public function process(){
		// load uploadhnadler library
		$this->load->library('uploadhandler');

		// set header
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Content-Disposition: inline; filename="files.json"');
		$this->output->set_header('X-Content-Type-Options: nosniff');
		$this->output->set_header('Access-Control-Allow-Origin: *');
		$this->output->set_header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		$this->output->set_header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		// create directory
		!is_dir('files') ? mkdir('files',0777) : null;
		!is_dir('files/temp') ? mkdir('files/temp',0777) : null;
		!is_dir('files/filebox') ? mkdir('files/filebox',0777) : null;
		!is_dir('files/filebox/img') ? mkdir('files/filebox/img',0777) : null;
		!is_dir('files/filebox/binary') ? mkdir('files/filebox/binary',0777) : null;

		// process
		$ret = $this->_process($this->input->server('REQUEST_METHOD'));

		echo $ret;
	}

	// uploadForm : process
	public function _process($request_method){
		$_method = $this->input->get_post('_method');

		if(($_method && $_method === 'DELETE') || $request_method=='DELETE'){
			$file_srl = $this->input->get_post('file_srl');
			return $this->_delete($file_srl);

		} else if( $request_method == 'POST'){
			return $this->_upload();

		} else if($request_method == 'GET'){
			// 			return $this->_today();
		} else {
			header('HTTP/1.1 405 Method Not Allowed');
		}
	}

	// uploadForm : upload
	public function _upload(){
		// upload file
		if(!($upload_data = $this->uploadhandler->upload())){
			return null;
		}

		// load filebox model
		$this->load->model('Filebox/Filebox_model','filebox');

		$args->file_type = $upload_data['file_type'];
		$args->full_path = $upload_data['full_path'];
		$args->file_path = $upload_data['file_path'];
		$args->original_file_name = $upload_data['orig_name'];
		$args->encrypted_file_name = $upload_data['file_name'];
		$args->file_size_kb = $upload_data['file_size'];
		$args->is_image = $upload_data['is_image'] ;
		$args->image_width = $upload_data['image_width'];
		$args->image_height = $upload_data['image_height'];
		$args->image_thumb_path = $upload_data['image_thumb_path'];
		$args->image_type = $upload_data['image_type'];
		$args->reg_date = standard_date('DATE_ATOM',time());
		$args->uid = $this->uid;
		$args->username = $this->username;
		$args->email = $this->email;
		$args->ip_address = $this->input->ip_address();

		// insert file information in DB
		$ret_data = $this->filebox->insert($args) ;

		// pilter return data
		$ret = $this->_param_filter($ret_data) ;

		return json_encode(array($ret));
	}

	// uploadForm : delete
	public function _delete($file_srl){
		$this->load->model('Filebox/Filebox_model','filebox') ;
		$remove_obj = $this->filebox->delete($file_srl) ;

		if($remove_obj == null){
			return FALSE ;
		}

		return TRUE ;
	}

	// uploadForm : get
	public function _today(){
		$this->load->model('Filebox/Filebox_model','filebox') ;

		$fileList = $this->filebox->getFileList() ;
		$arr = array()   ;
		foreach($fileList['list'] as $key => $file){
			$arr[] = $this->_param_filter($file) ;
		}

		return json_encode($arr) ;
	}

	// return data information
	public function _param_filter($data){
		$ret->id = $data->file_srl ;
		$ret->name = $data->original_file_name ;
		$ret->size = filesize($data->full_path);
		$ret->type = $data->file_type ;
		$ret->url = base_url().$data->full_path ;
		$ret->thumbnail_url = base_url().$data->image_thumb_path;
		$ret->delete_url = base_url().'admin/filebox/process?file_srl='.$ret->id;
		$ret->delete_type = 'DELETE' ;

		return $ret ;
	}

	// uploadList : view
	public function fileList($page=1,$list_count=10){
		$data['action'] = 'fileList';
		$this->load->model('Filebox/Filebox_model','filebox');

		$search_param = null;
		$data['search_key'] = '';
		$data['search_keyword'] = '';

		if($this->input->get_post('search_key') && $this->input->get_post('search_keyword')){
			$search_param = array();
			$data['search_key'] =  $search_param['search_key'] = $this->input->get_post('search_key');
			$data['search_keyword'] = $search_param['search_keyword'] = $this->input->get_post('search_keyword');
		}
		$result = $this->filebox->getFileList($page,$list_count,$search_param);

		$data['fileList'] = $result['list'];
		$data['pagination'] = $result['pagination'];

		$this->load->library('sg_layout');
		$this->sg_layout->layout('admin/layout');
		$this->sg_layout->module('filebox');

		$this->sg_layout->add('admin/header');
		$this->sg_layout->add('admin/sidebar');
		$this->sg_layout->add('admin/fileList');
		$this->sg_layout->add('admin/footer');

		$this->sg_layout->show($data) ;
	}

	// fileList : delete
	public function delete(){
		$file_srl = $this->input->get_post('file_srl');

		$this->load->model('Filebox/Filebox_model','filebox') ;
		$file_obj = $this->filebox->getFile($file_srl) ;

		if(is_file($file_obj->full_path))
			if(unlink($file_obj->full_path))
				$this->_delete($file_srl);


		echo json_encode('success');
	}

	// uploadList : download file
	public function download($file_srl){
		$this->load->model('Filebox/Filebox_model','filebox') ;

		$file_obj = $this->filebox->getFile($file_srl) ;

		// update DB
		$new_down_cnt = number_format($file_obj->down_cnt) + 1;
		$data = array('down_cnt' => $new_down_cnt);
		$this->filebox->update($data,$file_srl);

		// download
		$this->load->helper('download');
		$data = file_get_contents($file_obj->full_path);
		force_download($file_obj->original_file_name , $data);
	}

	// uploadList : get file
	public function getFile(){
		$file_srl = $this->input->get_post('file_srl');

		$this->load->model('Filebox/Filebox_model','filebox');
		$file_obj = $this->filebox->getFile($file_srl);
		$file_obj->base_url = base_url();

		echo json_encode($file_obj);
	}

	// uploadList : modify file
	public function modify(){
		$this->load->model('Filebox/Filebox_model','filebox') ;

		// get modify data
		$file_srl = $this->input->get_post('file_srl');
		$data['original_file_name'] = $this->input->get_post('original_file_name');
		$data['isvalid'] = $this->input->get_post('isvalid');
		$data['tag'] = $this->input->get_post('tag');

		$this->filebox->update($data,$file_srl);

		if($data['tag'] != ""){
			$args  = array();
			$pairs    = explode(",", $data['tag']);
			foreach ($pairs as $pair) {

				$args[] = array(
						'tag' => $pair,
						'file_srl' => $file_srl,
						'reg_date' => standard_date('DATE_ATOM',time()),
						'username' => $this->username,
						'email' => $this->email,
						'uid' => $this->uid
				);
			}
			$ret_data = $this->filebox->insert_tag($args,'filetag') ;
		}

		echo json_encode('success');
	}

	public function tagCloud(){
		$data['action'] = "tagCloud";

		$this->load->library('sg_layout');

		$this->sg_layout->layout('admin/layout');
		$this->sg_layout->module('filebox');

		$this->sg_layout->add('admin/header');
		$this->sg_layout->add('admin/sidebar');
		$this->sg_layout->add('admin/tagCloud');
		$this->sg_layout->add('admin/footer');

		$this->sg_layout->show($data);
	}

	public function getTag(){
		// get DB library
		$this->load->model('Filebox/Filebox_model','filebox') ;
		// get files in DB
		$data['result']=$this->filebox->select_tag($this->uid,'filetag');
		$data['base_url'] = base_url();
		$success = $data;

		echo json_encode($success);
	}

	public function getImageList(){
		$page = $this->input->get_post('page');
		$page = 1 ;
		$list_count = 10 ;

		$this->load->model('Filebox/Filebox_model','filebox') ;

		if($this->input->get_post('key') && $this->input->get_post('keyword')){
			$search_param['option'] = $this->input->get('key');
			$search_param['value'] = $this->input->get('keyword');
			$result = $this->filebox->getImageList($page,$list_count,$search_param);
		}else {
			$result = $this->filebox->getImageList($page,$list_count);
		}

		$result_list = $result['list'] ;

		$this->load->helper('image') ;

		foreach($result_list as $key => $row){
			$result_list[$key]->thumbnail_url = thumbImage('filebox',$row->file_srl,$row->full_path,110,90) ;
		}

		$data = array() ;
		$data['items'] = $result['list'];
		$data['pagination'] = $result['pagination'];
		$data['base_url'] = base_url();
		echo json_encode($data);
	}
}
