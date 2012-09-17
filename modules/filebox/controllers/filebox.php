<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Filebox extends MX_Controller {

	protected $sid; // author
	protected $module_srl; // db isert data

	public function __construct() {
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('date');
	}

	public function index(){

	}

	// uploadForm view
	public function uploadForm(){

		$this->load->view('upload_form') ;
	}

	public function process(){

		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Content-Disposition: inline; filename="files.json"');
		$this->output->set_header('X-Content-Type-Options: nosniff');
		$this->output->set_header('Access-Control-Allow-Origin: *');
		$this->output->set_header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		$this->output->set_header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		$this->sid = 'root';
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

	// upload files
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
			// get DB library
			$this->load->model('Filebox_model');
			// DB insert Data
			$insert_data;
			$insert_data->file_type = $data['file_type'];
			$insert_data->sid = $this->sid;
			$insert_data->source_file_name = do_hash($data['file_name'] . time(), 'md5') . $data['file_ext'];
			$insert_data->upload_file_name = $data['file_name'];
			$insert_data->file_size = $data['file_size'];
			$insert_data->module_srl = $this->module_srl;
			$insert_data->reg_date = standard_date('DATE_ATOM',time());//date("Y-m-d H:i:s",time());
			$insert_data->ip_address = $this->input->ip_address();
			// insert data into db
			$this->Filebox_model->insert_entry($insert_data);

			if($data['file_type'] == "image/png" || $data['file_type'] == "image/jpg" || $data['file_type'] == "image/jpeg" || $data['file_type'] == "image/gif"){
				$save_dir = "filebox/files/img/".date("Ymd");
				$save_thumb_dir = "filebox/files/img/".date("Ymd")."/thumbs/";

				// file move
				if(is_file($data['full_path'])){ // img move
					//check if the $name folder exists, if not create it
					if( ! is_dir($save_dir))
					{
						mkdir($save_dir,0777);
						mkdir($save_thumb_dir,0777);
					}
					$dest = $save_dir . "/" . $insert_data->source_file_name;
					rename($data['full_path'], $dest);
						
					// Thumbnail create
					$config['new_image'] = $save_thumb_dir;
					$config['image_library'] = 'gd2';
					$config['source_image'] = $dest;
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 120;
					$config['height'] = 90;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
				}
			}else{ // file move
				$save_dir = "filebox/files/file/".date("Ymd");
				$save_thumb_dir = "";

				// file move
				if(is_file($data['full_path'])){
					//check if the $name folder exists, if not create it
					if( ! is_dir($save_dir))
					{
						mkdir($save_dir,0777);
					}
					$dest = $save_dir . "/" . $insert_data->source_file_name;
					rename($data['full_path'], $dest);
				}
			}
				
			// jason encode
			$info = new stdClass();
			$info->name = $data['file_name'];
			$info->size = filesize($dest);
			$info->type = $data['file_type'];
			$info->url = base_url() . $dest;
			$info->thumbnail_url = base_url() . $save_thumb_dir . $insert_data->source_file_name; //I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$name
			$info->delete_url =  base_url() . 'filebox/process/?file='.$insert_data->source_file_name;
			$info->delete_type = 'DELETE';
				
			// return ajax
			echo json_encode(array($info));
		} else {
			// return ajax
			$error = array('error' => $this->upload->display_errors('',''));
			echo json_encode(array($error));
		}
	}

	public function get() {
		//DB Get
		$this->load->model('Filebox_model'); // 모델 - 호출
		$data = $this->Filebox_model->get_entry($this->sid);
		$files = array();
		foreach($data as $key => $value){
			$folder = date ('Ymd', strtotime ($value->reg_date));
			$img_fold_url = 'filebox/files/img/' . $folder . '/';
			$file_fold_url = 'filebox/files/file/' . $folder . '/';
			if(is_file($img_fold_url . $value->source_file_name)){
				$file = new stdClass();
				$file->name = $value->source_file_name;
				$file->size = filesize($img_fold_url . $value->source_file_name);
				$file->url = base_url() . $img_fold_url . $value->source_file_name;
				$file->thumbnail_url = base_url() . $img_fold_url . 'thumbs/' . $value->source_file_name;
				$file->delete_url = base_url() . 'filebox/process/?file='.$value->source_file_name;
				$file->delete_type = 'DELETE';

				$files[$key] = $file;
			}else if(is_file($file_fold_url . $value->source_file_name)){
				$file = new stdClass();
				$file->name = $value->source_file_name;
				$file->size = filesize($file_fold_url . $value->source_file_name);
				$file->url = base_url() . $file_fold_url . $value->source_file_name;
				$file->thumbnail_url = base_url() . $file_fold_url . 'thumbs/' . $value->source_file_name;
				$file->delete_url = base_url() . 'filebox/process/?file='.$value->source_file_name;
				$file->delete_type = 'DELETE';

				$files[$key] = $file;
			}
		}
		echo json_encode($files);
	}

	public function delete() {
		//Get the name in the url
		$file = $this->input->get('file', TRUE);

		//DB Get
		$this->load->model('Filebox_model'); // 모델 - 호출
		$data = $this->Filebox_model->view_entry($file);

		$success;
		foreach($data as $key => $value){
			$folder = date ('Ymd', strtotime ($value->reg_date));
			$delete_img_url = 'filebox/files/img/' . $folder . '/' .$file;
			$delete_file_url = 'filebox/files/file/' . $folder . '/' .$file;
			$delete_img_thumb_url = 'filebox/files/img/' . $folder . '/thumbs/' .$file;
			if(is_file($delete_img_url) && is_file($delete_img_thumb_url)){
				if(unlink($delete_img_url) && unlink($delete_img_thumb_url)){
					$success = $this->Filebox_model->delete_entry($value->file_srl);
				}
			}elseif (is_file($delete_file_url)){
				if(unlink($delete_file_url)){
					$success = $this->Filebox_model->delete_entry($value->file_srl);
				}
			}
		}
		echo json_encode(array($success));
	}

	public function fileModify(){
		$success;

		$this->load->model('Filebox_model'); // 모델 - 호출
		$data['mod_no'] = $this->input->get('mod_no');
		$data['mod_name'] = $this->input->get('mod_name');
		$data['mod_comment'] = $this->input->get('mod_comment');
		$data['mod_isvalid'] = $this->input->get('mod_isvalid');

		if($this->Filebox_model->update_entry($data))
			$success = "success";

		echo json_encode($success);
	}

	public function fileList($page=1){

		$this->load->model('Filebox_model'); // 모델 - 호출

		// 세팅 - 설정
		$page_view = 5; // 한 페이지에 보여줄 레코드 수
		$base_url = base_url(); // base_url
		$act_url = $base_url . "filebox/fileList";
		$page_per_block = 5; // 페이징 이동 개수 ( 1 .. 5)

		$data = "";


		if($page < 1){
			$page = 1;
			$data['page'] = 1;
		}else{
			$data['page'] = $page;
		}

		if($this->input->get('key') && $this->input->get('keyword')){
			$data['key'] = $this->input->get('key');
			$data['keyword'] = $this->input->get('keyword');
		}else {
			$data['key'] = "";
			$data['keyword']= "";
		}

		$start_idx = ($page - 1) * $page_view;

		$data['result']=$this->Filebox_model->select_entry($start_idx, $page_view, $data);
		$data['total_record'] = count($this->Filebox_model->total_entry_count($data));
		$data['total_page'] = ceil($data['total_record'] / $page_view);

		// 폼 - 정의
		$data['base_url'] = $base_url;
		$data['act_url'] = $act_url;

		// 뷰 - 출력
		$this->load->view('upload_list', $data);

	}

	public function getDownCnt(){

		$this->load->model('Filebox_model'); // 모델 - 호출
		$this->load->helper('download');

		$file = $this->input->get('file', TRUE);
		$temp = $this->Filebox_model->view_entry($file);
		$success;

		foreach($temp as $key => $value){
			$folder = date ('Ymd', strtotime ($value->reg_date));
			$download_file_url = 'filebox/files/file/' . $folder . '/' .$file;
			$download_img_url = 'filebox/files/img/' . $folder . '/' .$file;
			if(is_file($download_file_url)){
				$success->down_cnt = number_format($value->down_cnt) + 1;
			}else if(is_file($download_img_url)){
				$success->down_cnt = number_format($value->down_cnt) + 1;
			}
		}
		echo json_encode($success);
	}

	public function fileDownload(){

		$this->load->model('Filebox_model'); // 모델 - 호출
		$this->load->helper('download');

		$file = $this->input->get('file', TRUE);
		$temp = $this->Filebox_model->view_entry($file);
		$download_file_url;

		foreach($temp as $key => $value){
			$folder = date ('Ymd', strtotime ($value->reg_date));
			$download_file_url = 'filebox/files/file/' . $folder . '/' .$file;
			$download_img_url = 'filebox/files/img/' . $folder . '/' .$file;
			if(is_file($download_file_url)){
				$data['mod_no'] = $value->file_srl;
				$data['mod_down_cnt'] = number_format($value->down_cnt) + 1;
				$this->Filebox_model->down_update_entry($data);
				$download_file = file_get_contents($download_file_url); // Read the file's contents
			}else if(is_file($download_img_url)){
				$data['mod_no'] = $value->file_srl;
				$data['mod_down_cnt'] = number_format($value->down_cnt) + 1;
				$this->Filebox_model->down_update_entry($data);
				$download_file = file_get_contents($download_img_url); // Read the file's contents
			}
		}

		force_download($file, $download_file);
	}

	//filebox get image
	public function getFileList(){

		$this->load->model('Filebox_model'); // 모델 - 호출

		// 세팅 - 설정
		$page_view = 9; // 한 페이지에 보여줄 레코드 수
		$base_url = base_url(); // base_url
		$act_url = $base_url . "filebox/getFileList";
		$page_per_block = 9; // 페이징 이동 개수 ( 1 .. 5)

		$data = "";

		$page = $this->input->get('page')?$this->input->get('page'):"";

		if($page < 1){
			$page = 1;
			$data['page'] = 1;
		}else{
			$data['page'] = $page;
		}

		if($this->input->get('key') && $this->input->get('keyword')){
			$data['key'] = $this->input->get('key');
			$data['keyword'] = $this->input->get('keyword');
		}else {
			$data['key'] = "";
			$data['keyword']= "";
		}

		$start_idx = ($page - 1) * $page_view;

		$data['result']=$this->Filebox_model->select_entry($start_idx, $page_view, $data);
		$data['total_record'] = count($this->Filebox_model->total_entry_count($data));
		$data['total_page'] = ceil($data['total_record'] / $page_view);

		// 폼 - 정의
		$data['base_url'] = $base_url;
		$data['act_url'] = $act_url;

		foreach($data['result'] as $key => $value){
			$folder = date ('Ymd', strtotime ($value->reg_date));
			$file_fold_url = 'filebox/files/file/' . $folder . '/';
			$img_fold_url = 'filebox/files/img/' . $folder . '/';
			if(is_file($file_fold_url . $value->source_file_name)){
				$file = new stdClass();
				$file->name = $value->source_file_name;
				$file->size = filesize($file_fold_url . $value->source_file_name);
				$file->url = base_url() . $file_fold_url . $value->source_file_name;
				$file->thumbnail_url = base_url() . "/modules/auth/views/assets/img/no_image.png";

				$files[$key] = $file;
			}else if(is_file($img_fold_url . $value->source_file_name)){
				$file = new stdClass();
				$file->name = $value->source_file_name;
				$file->size = filesize($img_fold_url . $value->source_file_name);
				$file->url = base_url() . $img_fold_url . $value->source_file_name;
				$file->thumbnail_url = base_url() . $img_fold_url . 'thumbs/' . $value->source_file_name;

				$files[$key] = $file;
			}
		}

		$data['result'] = $files;
		$success = $data;
		echo json_encode($success);

	}
}

/* End of file filebox.php */
/* location : ./modules/filebox/filebox.php*/
