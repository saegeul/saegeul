<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Filebox extends MX_Controller {

	protected $sid;
	protected $module_srl;

	public function __construct() {
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('date');
	}

	public function index(){

	}

	public function uploadForm(){
		$this->load->view('upload_form') ;
	}

	public function process(){

		$this->sid = 'root';
		$this->module_srl = 'filebox';

		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Content-Disposition: inline; filename="files.json"');
		$this->output->set_header('X-Content-Type-Options: nosniff');
		$this->output->set_header('Access-Control-Allow-Origin: *');
		$this->output->set_header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		$this->output->set_header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		switch ($this->input->server('REQUEST_METHOD')) {
			case 'OPTIONS':
				break;
			case 'HEAD':
			case 'GET':
				$this->get();
				break;
			case 'POST':
				if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
					$this->delete();
				} else {
					$this->post();
				}
				break;
			case 'DELETE':
				$this->delete();
				break;
			default:
				$this->output->set_header('HTTP/1.1 405 Method Not Allowed');
		}
	}

	public function post() {

		if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
			return $this->delete();
		}

		$config['upload_path'] = 'filebox/temp/';
		$config['allowed_types'] = 'gif|jpg|png|JPG|GIF|PNG';
		$config['max_size']	= '3000';

		$this->load->library('upload', $config);

		// file upload
		if($this->upload->do_upload())
		{
			// file upload
			$data = $this->upload->data();
			// Data security
			$this->load->helper('security');

			// DB insert
			$this->load->model('Filebox_model'); // 모델 - 호출
			$insert_data;
			$insert_data->img_type = $data['file_type'];
			$insert_data->sid = $this->sid;
			$insert_data->source_img_name = do_hash($data['file_name'] . time(), 'md5') . $data['file_ext'];
			$insert_data->upload_img_name = $data['file_name'];
			$insert_data->img_size = $data['file_size'];
			$insert_data->module_srl = $this->module_srl;
			$insert_data->reg_date = standard_date('DATE_ATOM',time());//date("Y-m-d H:i:s",time());
			$insert_data->ip_address = $this->input->ip_address();

			$this->Filebox_model->insert_entry($insert_data);

			// file move
			$save_dir = "filebox/files/img/".date("Ymd");
			$save_thumb_dir = "filebox/files/img/".date("Ymd")."/thumbs/";
			$dest = $save_dir . "/" . $insert_data->source_img_name;
			if(is_file($data['full_path'])){
				//check if the $name folder exists, if not create it
				if( ! is_dir($save_dir))
				{
					mkdir($save_dir,0777);
					mkdir($save_thumb_dir,0777);
				}
				rename($data['full_path'], $dest);
				// Thumbnail create
				$config['new_image'] = $save_thumb_dir;
				$config['image_library'] = 'gd2';
				$config['source_image'] = $dest;
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 193;
				$config['height'] = 94;
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();

				// jason encode
				$info = new stdClass();
				$info->name = $data['file_name'];
				$info->size = filesize($dest);
				$info->type = $data['file_type'];
				$info->url = base_url() . $dest;
				$info->thumbnail_url = base_url() . $save_thumb_dir . $insert_data->source_img_name; //I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$name
				$info->delete_url =  base_url() . 'filebox/process/?file='.$insert_data->source_img_name;
				$info->delete_type = 'DELETE';

				echo json_encode(array($info));
			}
		} else {
			$error = array('error' => $this->upload->display_errors('',''));
			echo json_encode(array($error));
		}
	}

	public function get() {
		//DB Get
		$this->load->model('Filebox_model'); // 모델 - 호출
		$data = $this->Filebox_model->select_entry($this->sid);
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
				$file->delete_url = base_url() . 'filebox/process/?file='.$value->source_img_name;
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
			$delete_file_url = 'filebox/files/img/' . $folder . '/' .$file;
			$delete_file_thumb_url = 'filebox/files/img/' . $folder . '/thumbs/' .$file;
			if(is_file($delete_file_url) && is_file($delete_file_thumb_url)){
				if(unlink($delete_file_url) && unlink($delete_file_thumb_url)){
					$success = $this->Filebox_model->delete_entry($value->img_srl);
				}
			}
		}
		echo json_encode(array($success));
	}
}

/* End of file filebox.php */
/* location : ./modules/filebox/filebox.php*/
