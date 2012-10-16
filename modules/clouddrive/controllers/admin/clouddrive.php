<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Clouddrive extends MX_Controller {

	// DB isert user information
	protected $username;
	protected $email;
	protected $uid;

	protected $api_key;
	protected $secret_key;
	protected $oauth_token;
	protected $oauth_verifier;
	protected $oauth_token_secret;

	protected $request_header;
	protected $api_token;

	public function __construct() {
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('download');
		$this->load->library('tank_auth');
		$this->load->library('session');

		// load uploadhnadler library
		$this->load->library('uploadhandler');

		$this->username = $this->tank_auth->get_username();
		$this->uid = $this->tank_auth->get_user_id();
		$this->email = $this->tank_auth->get_useremail();

		// get session
		$this->api_key = $this->session->userdata('session_kt_api_key');
		$this->secret_key = $this->session->userdata('session_kt_secret_key');
		$this->oauth_token = $this->session->userdata('session_kt_ucloud_oauth_token');
		$this->oauth_verifier = $this->session->userdata('session_kt_ucloud_oauth_verifier');
		$this->oauth_token_secret = $this->session->userdata('session_kt_ucloud_oauth_token_secret');

		$this->load->library('oauth',array(
				'api_key'=>$this->api_key,
				'secret_key'=>$this->secret_key,
				'callback_url'=>base_url().'admin/clouddrive/ucloudView',
				'signature_method'=>'HMAC-SHA1',
				'provider'=>'Ucloud',
				'oauth_version'=>'1.0'
		)) ;

		$this->setRequest();
	}

	public function setRequest(){
		if(isset($this->oauth_token)){
			$params = array();
			$params['oauth_token'] = $this->oauth_token ;
			$params['oauth_token_secret'] = $this->oauth->token('oauth_token_secret');
			$params['oauth_verifier'] = $this->oauth_verifier ;

			$response = $this->oauth->access_token($params,'POST') ;
			$this->oauth->token('oauth_token_secret',isset($response['oauth_token_secret'])?$response['oauth_token_secret']:"") ;
			$this->oauth->token('oauth_token',isset($response['oauth_token'])?$response['oauth_token']:"") ;

			$this->request_header = array() ;

			$this->request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
			$this->request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
			$this->request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

			$provider = $this->oauth->getProvider() ;
			$consumer = $this->oauth->getConsumer() ;

			$this->api_token = $provider->getAPIToken($consumer->get('api_key'),$consumer->get('secret_key')) ;

		}
	}

	public function ucloudView(){
		$data['action'] = 'ucloudView';
		
		$request_body = array('api_token'=>$this->api_token) ;
		$response = $this->oauth->api_call('getsyncfolder',$this->request_header,$request_body,'POST') ;
		$data['result'] = $response;

		$this->load->library('sg_layout');
			
		$this->sg_layout->layout('admin/layout');
		$this->sg_layout->module('clouddrive');
			
		$this->sg_layout->add('admin/header');
		$this->sg_layout->add('admin/sidebar');
		$this->sg_layout->add('admin/clouddrive');
		$this->sg_layout->add('admin/footer');
			
		$this->sg_layout->show($data);

	}

	// check oauth
	public function checkOauth(){
		if($this->api_key=="" && $this->secret_key==""){
			// get DB library
			$this->load->model('auth/Auth_model','auth');
			// get api_key , secret_key
			$data = $this->auth->view_entry($this->uid);
			if(count($data) != 0){
				// setting session
				$this->session->set_userdata('session_kt_api_key', $data[0]->api_key);
				$this->session->set_userdata('session_kt_secret_key', $data[0]->secret_key);

				$this->api_key = $this->session->userdata('session_kt_api_key');
				$this->secret_key = $this->session->userdata('session_kt_secret_key');
			}
		}
		$data['action'] = 'checkOauth';
		// check api key
		$data['api_key'] =  $this->api_key;
		// check secrete key
		$data['secret_key'] = $this->secret_key;
		// check access token
		$data['oauth_token'] =  $this->oauth_token;
		// check access token token secrete
		$data['oauth_token_secret'] = $this->oauth_token_secret;

		$this->load->library('sg_layout');
			
		$this->sg_layout->layout('admin/layout');
		$this->sg_layout->module('clouddrive');
			
		$this->sg_layout->add('admin/header');
		$this->sg_layout->add('admin/sidebar');
		$this->sg_layout->add('admin/checkoauth');
		$this->sg_layout->add('admin/footer');
			
		$this->sg_layout->show($data);
	}

	public function getKtCloudData(){
		$folder_id = $this->input->get_post('folder_id');

		if($folder_id){
			$request_body = array('api_token'=>$this->api_token,'folder_id'=>$folder_id) ;
			$response = $this->oauth->api_call('getContents',$this->request_header,$request_body,'POST') ;
		}else {
			$request_body = array('api_token'=>$this->api_token) ;
			$response = $this->oauth->api_call('getUserInfo',$this->request_header,$request_body,'POST') ;
		}
		$success = $response;
		echo json_encode($success);
	}

	public function fileBoxList($page=1,$list_count=6){
		$this->load->model('Filebox/Filebox_model','filebox');
		$page = $this->input->get_post('page');
		if($this->input->get_post('key') && $this->input->get_post('keyword')){
			$search_param['option'] = $this->input->get('key');
			$search_param['value'] = $this->input->get('keyword');
			$result = $this->filebox->getFileList($page,$list_count,$search_param);
		}else {
			$result = $this->filebox->getFileList($page,$list_count);
		}

		$data['fileList'] = $result['list'];
		$data['pagination'] = $result['pagination'];
		$data['base_url'] = base_url();
		echo json_encode($data);
	}

	public function createKtCloudFolder(){
		$folder_id = $this->input->get_post('upload_folder') ;
		$folder_name = $this->input->get_post('addFolderName') ;

		$request_body = array('api_token'=>$this->api_token,'folder_id'=>$folder_id,'folder_name'=>$folder_name) ;
		$response = $this->oauth->api_call('createfolder',$this->request_header,$request_body,'POST') ;

		$success = $response;
		echo json_encode($success);

	}

	public function movefileBoxToKtCloud(){
		$data = $this->input->get_post('data');
		$upload_folder = $this->input->get_post('upload_folder');
		$decodeData = json_decode($data);

		for ($i = 0; $i < count($decodeData); $i++) {
			$file_srl = $decodeData[$i];
			$this->load->model('Filebox/Filebox_model','filebox');
			$file_obj = $this->filebox->getFile($file_srl);
			$upload_file_url = $file_obj->full_path;
			if(is_file($upload_file_url)){
				$request_body = array('api_token'=>$this->api_token,'folder_id'=>$upload_folder,'file_name'=>$file_obj->original_file_name,'mediaType'=>$file_obj->file_type);
				$response = $this->oauth->api_call('createfile',$this->request_header,$request_body,'POST') ;
				$temp_upload_file = json_decode($response);
				if($temp_upload_file->result_code == 201){
					$transfer_mode = 'UP';
					$request_body = array('api_token'=>$this->api_token,'file_id'=>$temp_upload_file->file_id,'transfer_mode'=>$transfer_mode) ;
					$response = $this->oauth->api_call('createfiletoken',$this->request_header,$request_body,'POST') ;
					$temp_upload_file_re = json_decode($response);
					if($temp_upload_file_re->result_code == 200){
						$params = array(
								'http' => array(
										'method' => 'PUT',
										'content' => file_get_contents($upload_file_url)
								)
						);
						$upload_url = $temp_upload_file_re->redirect_url . "?api_token=" . $this->api_token . "&file_token=" . $temp_upload_file_re->file_token;
						$ctx = stream_context_create($params);
						$response = @file_get_contents($upload_url, false, $ctx);
						if($response == '')
							$success = "success";
					}
				}

			}
		}
		echo json_encode($success);
	}

	public function moveKtCloudTofileBox(){
		$upload_folder = $this->input->get_post('upload_folder') ;
		$data_id = $this->input->get_post('data_id') ;
		$data_name = $this->input->get_post('data_name') ;
		$decodeData_id = json_decode($data_id);
		$decodeData_name = json_decode($data_name);
		$transfer_mode = "DN";
		// create directory
		!is_dir('files') ? mkdir('files',0777) : null;
		!is_dir('files/temp') ? mkdir('files/temp',0777) : null;
		!is_dir('files/filebox') ? mkdir('files/filebox',0777) : null;
		!is_dir('files/filebox/img') ? mkdir('files/filebox/img',0777) : null;
		!is_dir('files/filebox/binary') ? mkdir('files/filebox/binary',0777) : null;
			
		for ($i = 0; $i < count($decodeData_id); $i++) {
			$request_body = array('api_token'=>$this->api_token,'file_id'=>$decodeData_id[$i],'transfer_mode'=>$transfer_mode) ;
			$response = $this->oauth->api_call('createfiletoken',$this->request_header,$request_body,'POST') ;
			$temp = json_decode($response);
			if(isset($temp->redirect_url)){
				$upload_file_url = $temp->redirect_url . "?api_token=" . $this->api_token . "&file_token=" . $temp->file_token;
				$download_file = file_get_contents($upload_file_url); // Read the file's contents
				$file_name = $decodeData_name[$i];
				file_put_contents("files/temp/".$file_name, $download_file);
				$file_path = "files/temp/".$file_name;
					
				$success = $this->moveTempToFileBox($file_path);
			}
		}
		echo json_encode($success);
	}

	public function moveTempToFileBox($file_path) {
		// upload file
		if(!($upload_data = $this->uploadhandler->move($file_path))){
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
		$args->reg_date = standard_date('DATE_ATOM',time());;
		$args->uid = $this->uid;
		$args->username = $this->username;
		$args->email = $this->email;
		$args->ip_address = $this->input->ip_address();

		// insert file information in DB
		$ret_data = $this->filebox->insert($args) ;

		return $ret_data;
	}

	public function deleteKtCloudData(){
		$data = $this->input->get_post('data') ;
		$decodeData = json_decode($data);

		for ($i = 0; $i < count($decodeData); $i++) {
			$folde_or_file_id = $decodeData[$i];
			$request_body = array('api_token'=>$this->api_token,'file_id'=>$folde_or_file_id) ;
			$response = $this->oauth->api_call('deletefile',$this->request_header,$request_body,'POST') ;
			$temp_delete_file = json_decode($response);
			if($temp_delete_file->result_code == 204){
				$success="success";
			}else{
				$request_body = array('api_token'=>$this->api_token,'folder_id'=>$folde_or_file_id) ;
				$response = $this->oauth->api_call('deletefolder',$this->request_header,$request_body,'POST') ;
				$temp_delete_folder = json_decode($response);
				if($temp_delete_folder->result_code == 204){
					$success="success";
				}
			}
		}
		echo json_encode($success);
	}

	public function downloadKtCloudFile(){
		$file_id = $this->input->get_post('file_id') ;
		$file_name = $this->input->get_post('file_name') ;
		$transfer_mode = "DN";
		$request_body = array('api_token'=>$this->api_token,'file_id'=>$file_id,'transfer_mode'=>$transfer_mode) ;
		$response = $this->oauth->api_call('createfiletoken',$this->request_header,$request_body,'POST') ;
		$temp = json_decode($response);
		$upload_file_url = $temp->redirect_url . "?api_token=" . $this->api_token . "&file_token=" . $temp->file_token;
		$download_file = file_get_contents($upload_file_url); // Read the file's contents
		force_download($file_name, $download_file);
	}
}

/* End of file Oauth.php */
/* Location : ./modules/oauth/oauth.php */
