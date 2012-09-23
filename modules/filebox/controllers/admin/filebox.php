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

		$this->username = "root";
		$this->email = "root@saegeul.com";
		$this->uid = '1';
	}

	// index
	public function index(){

	}

	// upload_form : view
	public function uploadForm(){
		$this->load->library('admin_tmpl') ;

		$section = array(
				'header'=>'admin/header',
				'sidebar'=>'admin/sidebar',
				'body'=>'admin/upload_form',
				'footer'=>'admin/footer'
		) ;

		$str= $this->admin_tmpl->parse($section);

		echo $str ;

	}

	// upload_form : click event process
	public function process(){

		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Content-Disposition: inline; filename="files.json"');
		$this->output->set_header('X-Content-Type-Options: nosniff');
		$this->output->set_header('Access-Control-Allow-Origin: *');
		$this->output->set_header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		$this->output->set_header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		$this->module_srl = 'filebox';

		switch ($this->input->server('REQUEST_METHOD')) {
			case 'OPTIONS':
				break;
			case 'HEAD':

			case 'GET': // get files
				$this->get();
				break;
			case 'POST': // upload files
				if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
					$this->delete();
				} else {
					$this->post();
				}
				break;
			case 'DELETE': // delete files
				$this->delete();
				break;
			default: // error
				$this->output->set_header('HTTP/1.1 405 Method Not Allowed');
		}
	}

	// upload_form : upload files
	public function post() {

		if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
			return $this->delete();
		}

		// create directory
		if( ! is_dir('filebox'))
			mkdir('filebox',0777);
		if( ! is_dir('filebox/files'))
			mkdir('filebox/files',0777);
		if( ! is_dir('filebox/temp'))
			mkdir('filebox/temp',0777);
		if( ! is_dir('filebox/files/file'))
			mkdir('filebox/files/file',0777);
		if( ! is_dir('filebox/files/img'))
			mkdir('filebox/files/img',0777);

		$config['upload_path'] = 'filebox/temp/'; // temporary upload path
		$config['allowed_types'] = '*'; // allow all types
		$config['max_size']	= '100000'; // 10Mb

		$this->load->library('upload', $config); // upload configuration

		// file upload
		if($this->upload->do_upload())
		{
			// file upload
			$data = $this->upload->data();
			// get security library
			$this->load->helper('security');
			$source_file_name = do_hash($data['file_name'] . time(), 'md5') . $data['file_ext'];

			$save_dir = "";
			$save_thumb_dir = "";
				
			if($data['file_type'] == "image/png" || $data['file_type'] == "image/jpg" || $data['file_type'] == "image/jpeg" || $data['file_type'] == "image/gif"){
				// img directory
				$save_dir = "filebox/files/img/".date("Ymd");
				// img thumb directory
				$save_thumb_dir = "filebox/files/img/".date("Ymd")."/thumbs/";

				// file move
				if(is_file($data['full_path'])){ // img move
					//check if the $name folder exists, if not create it
					if( ! is_dir($save_dir))
					{
						mkdir($save_dir,0777);
						mkdir($save_thumb_dir,0777);
					}
					// moving data
					$dest = $save_dir . "/" . $source_file_name;
					// move
					rename($data['full_path'], $dest);

					$exts = explode(".",$source_file_name) ;
					$file_thumb_name = $exts[0];
					$file_thumb_type = $exts[1];

					// thumbnail create
					$config['new_image'] = $save_thumb_dir . $file_thumb_name . "_110*90" . "." .$file_thumb_type;
						
					$config['image_library'] = 'gd2';
					$config['source_image'] = $dest;
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 110;
					$config['height'] = 90;
					$this->load->library('image_lib');
					$image_lib = $this->image_lib;
					$image_lib->initialize($config);
					$image_lib->resize();
					$image_lib->clear();
				}
			}else{ // file move
				$save_dir = "filebox/files/file/".date("Ymd");

				// file move
				if(is_file($data['full_path'])){
					//check if the $name folder exists, if not create it
					if( ! is_dir($save_dir))
					{
						mkdir($save_dir,0777);
					}
					// moving data
					$dest = $save_dir . "/" . $source_file_name;
					// move
					rename($data['full_path'], $dest);
				}
			}
			if(is_file($dest)){
				// get DB library
				$this->load->model('Filebox_model','filebox');
				// DB insert Data
				$insert_data;
				$insert_data->file_type = $data['file_type'];
				$insert_data->upload_file_name = $data['file_name'];
				$insert_data->source_file_name = $source_file_name;
				$insert_data->file_size = $data['file_size'];
				$insert_data->file_url = $dest;
				$insert_data->reg_date = standard_date('DATE_ATOM',time());//date("Y-m-d H:i:s",time());
				$insert_data->ip_address = $this->input->ip_address();
				$insert_data->username = $this->username;
				$insert_data->email = $this->email;
				$insert_data->uid = $this->uid;
				// insert data into db
				$this->filebox->insert_entry($insert_data);

				// jason encode
				$info = new stdClass();
				$info->name = $data['file_name'];
				$info->size = filesize($dest);
				$info->type = $data['file_type'];
				$info->url = base_url() . $dest;

				$exts = explode(".",$insert_data->source_file_name) ;
				$file_thumb_name = $exts[0];
				$file_thumb_type = $exts[1];

				// thumbnail url
				$file_thumb_url = $save_thumb_dir . $file_thumb_name . "_110*90" . "." .$file_thumb_type;

				if(is_file($file_thumb_url)){
					$info->thumbnail_url = base_url() . $file_thumb_url;
				}else{
					$info->thumbnail_url = base_url() . "/modules/clouddrive/views/assets/img/no_image.png";
				}
				$info->delete_url =  base_url() . 'filebox/process/?file='.$insert_data->source_file_name;
				$info->delete_type = 'DELETE';
			}
			// return ajax
			echo json_encode(array($info));
		} else {
			// return ajax
			$error = array('error' => $this->upload->display_errors('',''));
			echo json_encode(array($error));
		}
	}

	// upload_form : get filebox
	public function get() {
		// get DB library
		$this->load->model('Filebox_model','filebox');
		$data = $this->filebox->get_entry($this->uid);
		$files = array();
		foreach($data as $key => $value){
			// date folder
			$folder = date ('Ymd', strtotime ($value->reg_date));
			// image folder
			$img_fold_url = 'filebox/files/img/' . $folder . '/';
			// file folder
			$file_fold_url = 'filebox/files/file/' . $folder . '/';
			// db get data check image or file
			if(is_file($img_fold_url . $value->source_file_name)){
				$file = new stdClass();
				$file->name = $value->source_file_name;
				$file->size = filesize($img_fold_url . $value->source_file_name);
				$file->url = base_url() . $img_fold_url . $value->source_file_name;

				// thumbnail
				$exts = explode(".",$value->source_file_name) ;
				$file_thumb_name = $exts[0];
				$file_thumb_type = $exts[1];

				// thumbnail url
				$file_thumb_url = $img_fold_url . 'thumbs/' . $file_thumb_name . "_110*90" . "." .$file_thumb_type;

				$file->thumbnail_url = base_url() . $file_thumb_url;
				$file->delete_url = base_url() . 'filebox/process/?file='.$value->source_file_name;
				$file->delete_type = 'DELETE';

				$files[$key] = $file;
			}else if(is_file($file_fold_url . $value->source_file_name)){
				$file = new stdClass();
				$file->name = $value->source_file_name;
				$file->size = filesize($file_fold_url . $value->source_file_name);
				$file->url = base_url() . $file_fold_url . $value->source_file_name;
				$file->thumbnail_url = base_url() . "/modules/clouddrive/views/assets/img/no_image.png";
				$file->delete_url = base_url() . 'filebox/process/?file='.$value->source_file_name;
				$file->delete_type = 'DELETE';

				$files[$key] = $file;
			}
		}
		echo json_encode($files);
	}

	// upload_form : delete file
	public function delete() {
		// get the name in the url
		$file = $this->input->get('file', TRUE);

		// get DB library
		$this->load->model('Filebox_model','filebox');
		$data = $this->filebox->view_entry($file);

		$success;
		foreach($data as $key => $value){
			$folder = date ('Ymd', strtotime ($value->reg_date));
			$delete_img_url = 'filebox/files/img/' . $folder . '/' .$file;
			$delete_file_url = 'filebox/files/file/' . $folder . '/' .$file;
			// thumbnail
			$exts = explode(".",$file) ;
			$file_thumb_name = $exts[0];
			$file_thumb_type = $exts[1];
			
			// thumbnail url
			$delete_img_thumb_url = 'filebox/files/img/' . $folder . '/' . 'thumbs/' . $file_thumb_name . "_110*90" . "." .$file_thumb_type;
			
			if(is_file($delete_img_url) && is_file($delete_img_thumb_url)){
				if(unlink($delete_img_url) && unlink($delete_img_thumb_url)){
					$success = $this->filebox->delete_entry($value->file_srl);
				}
			}elseif (is_file($delete_file_url)){
				if(unlink($delete_file_url)){
					$success = $this->filebox->delete_entry($value->file_srl);
				}
			}
		}
		echo json_encode(array($success));
	}

	// upload_list : view
	public function fileList($page=1){
		// get DB library
		$this->load->model('Filebox_model', 'filebox');

		// page setting
		$page_view = 5; // a page recode number
		$base_url = base_url(); // base url
		$act_url = $base_url . "filebox/admin/filebox/fileList"; // act url
		$page_per_block = 5; // a page recode moveing number

		// return data setting
		$data = "";

		if($page < 1){
			$page = 1;
			$data['page'] = 1;
		}else{
			$data['page'] = $page;
		}

		$start_idx = ($page - 1) * $page_view;

		// search keyworld
		if($this->input->get('key') && $this->input->get('keyword')){
			$data['key'] = $this->input->get('key');
			$data['keyword'] = $this->input->get('keyword');
		}else {
			$data['key'] = "";
			$data['keyword']= "";
		}

		// get files in DB
		$data['result']=$this->filebox->select_entry($start_idx, $page_view, $data);
		// get page tocal count
		$data['total_record'] = count($this->filebox->total_entry_count($data));
		$data['total_page'] = ceil($data['total_record'] / $page_view);
		// url
		$data['base_url'] = $base_url;
		$data['act_url'] = $act_url;

		// view

		$layout = array() ;
		$this->load->library('admin_tmpl') ;

		$section = array(
				'header'=>'admin/header',
				'sidebar'=>'admin/sidebar',
				'body'=>'admin/upload_list',
				'footer'=>'admin/footer'
		) ;

		$str= $this->admin_tmpl->parse($section,$data);

		echo $str ;
	}

	// upload_list : modify DB
	public function fileModify(){
		$success;
		// get DB library
		$this->load->model('Filebox_model','filebox');
		// modify data
		$data['mod_no'] = $this->input->get('mod_no');
		$data['mod_name'] = $this->input->get('mod_name');
		$data['mod_isvalid'] = $this->input->get('mod_isvalid');
		$data['mod_tag'] = $this->input->get('mod_tag');

		if($this->filebox->update_entry($data)){
			$insert_data;
			$insert_data->tag = $data['mod_tag'];
			$insert_data->file_srl = $data['mod_no'];
			$insert_data->reg_date = standard_date('DATE_ATOM',time());//date("Y-m-d H:i:s",time());
			$insert_data->username = $this->username;
			$insert_data->email = $this->email;
			$insert_data->uid = $this->uid;
			$this->filebox->insert_tag($insert_data);
			$success = "success";
				
		}
		// return json
		echo json_encode($success);
	}

	// upload_list : get current download count
	public function getDownCnt(){
		// get DB library
		$this->load->model('Filebox_model','filebox');

		$file = $this->input->get('file', TRUE);
		$temp = $this->filebox->view_entry($file);
		$success;

		foreach($temp as $key => $value){
			// date folder
			$folder = date ('Ymd', strtotime ($value->reg_date));
			// download_file_url
			$download_file_url = 'filebox/files/file/' . $folder . '/' .$file;
			// download_img_url
			$download_img_url = 'filebox/files/img/' . $folder . '/' .$file;
				
			if(is_file($download_file_url)){
				$success->down_cnt = number_format($value->down_cnt) + 1;
			}else if(is_file($download_img_url)){
				$success->down_cnt = number_format($value->down_cnt) + 1;
			}
		}

		echo json_encode($success);
	}

	// upload_list : download file
	public function fileDownload(){
		// get DB library
		$this->load->model('Filebox_model','filebox');
		$this->load->helper('download');

		$file = $this->input->get('file', TRUE);
		$temp = $this->filebox->view_entry($file);
		$download_file_url;

		foreach($temp as $key => $value){
			$folder = date ('Ymd', strtotime ($value->reg_date));
			$download_file_url = 'filebox/files/file/' . $folder . '/' .$file;
			$download_img_url = 'filebox/files/img/' . $folder . '/' .$file;
			if(is_file($download_file_url)){
				$data['mod_no'] = $value->file_srl;
				$data['mod_down_cnt'] = number_format($value->down_cnt) + 1;
				$this->filebox->down_update_entry($data);
				$download_file = file_get_contents($download_file_url); // Read the file's contents
			}else if(is_file($download_img_url)){
				$data['mod_no'] = $value->file_srl;
				$data['mod_down_cnt'] = number_format($value->down_cnt) + 1;
				$this->filebox->down_update_entry($data);
				$download_file = file_get_contents($download_img_url); // Read the file's contents
			}
		}

		force_download($file, $download_file);
	}

	//filebox get image
	public function getFileList(){
		// get DB library
		$this->load->model('Filebox_model','filebox');

		// page setting
		$page_view = 9; // page setting
		$base_url = base_url(); // base_url
		$act_url = $base_url . "filebox/admin/filebox/fileList"; // page setting
		$page_per_block = 9; // page setting

		// return data setting
		$data = "";

		$page = $this->input->get('page')?$this->input->get('page'):"";

		if($page < 1){
			$page = 1;
			$data['page'] = 1;
		}else{
			$data['page'] = $page;
		}

		$start_idx = ($page - 1) * $page_view;

		// search keyworld
		if($this->input->get('key') && $this->input->get('keyword')){
			$data['key'] = $this->input->get('key');
			$data['keyword'] = $this->input->get('keyword');
		}else {
			$data['key'] = "";
			$data['keyword']= "";
		}

		// get files in DB
		$data['result']=$this->filebox->select_entry($start_idx, $page_view, $data);
		// get page tocal count
		$data['total_record'] = count($this->filebox->total_entry_count($data));
		$data['total_page'] = ceil($data['total_record'] / $page_view);

		// url
		$data['base_url'] = $base_url;
		$data['act_url'] = $act_url;

		foreach($data['result'] as $key => $value){
			// date folder
			$folder = date ('Ymd', strtotime ($value->reg_date));
			// image folder
			$file_fold_url = 'filebox/files/file/' . $folder . '/';
			// file folder
			$img_fold_url = 'filebox/files/img/' . $folder . '/';
			// db get data check image or file
			if(is_file($file_fold_url . $value->source_file_name)){
				$file = new stdClass();
				$file->name = $value->source_file_name;
				$file->upload_name =  mb_substr($value->upload_file_name, 0, 12, 'UTF-8');
				$file->size = filesize($file_fold_url . $value->source_file_name);
				$file->url = base_url() . $file_fold_url . $value->source_file_name;
				$file->thumbnail_url = base_url() . "/modules/clouddrive/views/assets/img/no_image.png";

				$files[$key] = $file;
			}else if(is_file($img_fold_url . $value->source_file_name)){
				$file = new stdClass();
				$file->name = $value->source_file_name;
				$file->upload_name =  mb_substr($value->upload_file_name, 0, 12, 'UTF-8');
				$file->size = filesize($img_fold_url . $value->source_file_name);
				$file->url = base_url() . $img_fold_url . $value->source_file_name;
				
				// thumbnail
				$exts = explode(".",$value->source_file_name) ;
				$file_thumb_name = $exts[0];
				$file_thumb_type = $exts[1];
				
				// thumbnail url
				$file_thumb_url = $img_fold_url . 'thumbs/' . $file_thumb_name . "_110*90" . "." .$file_thumb_type;

				$file->thumbnail_url = base_url() . $file_thumb_url;

				$files[$key] = $file;
			}
		}

		$data['result'] = $files;
		$success = $data;
		// return json
		echo json_encode($success);

	}
}

/* End of file filebox.php */
/* location : ./modules/filebox/filebox.php*/
