<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Clouddrive extends MX_Controller {

	// DB isert user information
	protected $username;
	protected $email;
	protected $uid;

	public function __construct() {
		parent::__construct();

		$this->load->database();
		$this->username = "root";
		$this->email = "root@saegeul.com";
		$this->uid = '1';
	}

	public function callback(){

	}

	public function getFolder(){
		$api_key = '38629799a8e9388c6ce742ed71fb6233' ;
		$secret_key = '29b30a42991c73e76032c5f20b4b7858' ;
		$callback_url = 'http://localhost:8888';
		$this->load->helper('url') ;

		$this->load->library('oauth',array(
				'api_key'=>$api_key,
				'secret_key'=>$secret_key,
				'callback_url'=>base_url().'auth/oauth/',
				'signature_method'=>'HMAC-SHA1',
				'provider'=>'Ucloud',
				'oauth_version'=>'1.0'
		)) ;

		$folder_id = $this->input->get_post('folder_id') ;

		$params = array();
		$params['oauth_token'] = $this->input->get_post('oauth_token') ;
		$params['oauth_token_secret'] = $this->oauth->token('oauth_token_secret');
		$params['oauth_verifier'] = $this->input->get_post('oauth_verifier') ;

		$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
		$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
		$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

		$request_header = array() ;

		$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
		$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
		$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

		$provider = $this->oauth->getProvider() ;
		$consumer = $this->oauth->getConsumer() ;

		$api_token = $provider->getAPIToken($consumer->get('api_key'),$consumer->get('secret_key')) ;

		if($folder_id){
			$request_body = array('api_token'=>$api_token,'folder_id'=>$folder_id) ;
			$response = $this->oauth->api_call('getContents',$request_header,$request_body,'POST') ;
		}else {
			$request_body = array('api_token'=>$api_token) ;
			$response = $this->oauth->api_call('getUserInfo',$request_header,$request_body,'POST') ;
		}
		$data['result'] = $response;
		$this->load->view('auth',$data);
	}

	public function getFolderData(){
		$api_key = '38629799a8e9388c6ce742ed71fb6233' ;
		$secret_key = '29b30a42991c73e76032c5f20b4b7858' ;
		$callback_url = 'http://localhost:8888';
		$this->load->helper('url') ;

		$this->load->library('oauth',array(
				'api_key'=>$api_key,
				'secret_key'=>$secret_key,
				'callback_url'=>base_url().'auth/oauth/',
				'signature_method'=>'HMAC-SHA1',
				'provider'=>'Ucloud',
				'oauth_version'=>'1.0'
		)) ;

		$folder_id = $this->input->get_post('folder_id') ;

		$params = array();
		$params['oauth_token'] = $this->input->get_post('oauth_token') ;
		$params['oauth_token_secret'] = $this->oauth->token('oauth_token_secret');
		$params['oauth_verifier'] = $this->input->get_post('oauth_verifier') ;

		$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
		$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
		$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

		$request_header = array() ;

		$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
		$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
		$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

		$provider = $this->oauth->getProvider() ;
		$consumer = $this->oauth->getConsumer() ;

		$api_token = $provider->getAPIToken($consumer->get('api_key'),$consumer->get('secret_key')) ;

		if($folder_id){
			$request_body = array('api_token'=>$api_token,'folder_id'=>$folder_id) ;
			$response = $this->oauth->api_call('getContents',$request_header,$request_body,'POST') ;
		}else {
			$request_body = array('api_token'=>$api_token) ;
			$response = $this->oauth->api_call('getUserInfo',$request_header,$request_body,'POST') ;
		}
		$success = $response;
		echo json_encode($success);
	}

	public function getFile(){
		$api_key = '38629799a8e9388c6ce742ed71fb6233' ;
		$secret_key = '29b30a42991c73e76032c5f20b4b7858' ;
		$callback_url = 'http://localhost:8888';
		$this->load->helper('url') ;

		$this->load->library('oauth',array(
				'api_key'=>$api_key,
				'secret_key'=>$secret_key,
				'callback_url'=>base_url().'auth/oauth/',
				'signature_method'=>'HMAC-SHA1',
				'provider'=>'Ucloud',
				'oauth_version'=>'1.0'
		)) ;

		$file_id = $this->input->get_post('file_id') ;
		$file_name = $this->input->get_post('file_name') ;
		$transfer_mode = "DN";

		$params = array();
		$params['oauth_token'] = $this->input->get_post('oauth_token') ;
		$params['oauth_token_secret'] = $this->oauth->token('oauth_token_secret');
		$params['oauth_verifier'] = $this->input->get_post('oauth_verifier') ;

		$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
		$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
		$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

		$request_header = array() ;

		$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
		$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
		$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

		$provider = $this->oauth->getProvider() ;
		$consumer = $this->oauth->getConsumer() ;

		$api_token = $provider->getAPIToken($consumer->get('api_key'),$consumer->get('secret_key')) ;

		$request_body = array('api_token'=>$api_token,'file_id'=>$file_id,'transfer_mode'=>$transfer_mode) ;
		$response = $this->oauth->api_call('createfiletoken',$request_header,$request_body,'POST') ;


		$temp = json_decode($response);

		$upload_file_url = $temp->redirect_url . "?api_token=" . $api_token . "&file_token=" . $temp->file_token;
		$this->load->helper('download');

		$download_file = file_get_contents($upload_file_url); // Read the file's contents

		force_download($file_name, $download_file);

	}

	public function moveUcloud(){
		$api_key = '38629799a8e9388c6ce742ed71fb6233' ;
		$secret_key = '29b30a42991c73e76032c5f20b4b7858' ;
		$callback_url = 'http://localhost:8888';
		$this->load->helper('url') ;
		$this->load->model('filebox/filebox_model', 'filebox');

		$this->load->library('oauth',array(
				'api_key'=>$api_key,
				'secret_key'=>$secret_key,
				'callback_url'=>base_url().'auth/oauth/',
				'signature_method'=>'HMAC-SHA1',
				'provider'=>'Ucloud',
				'oauth_version'=>'1.0'
		)) ;

		$success = "";
		$data = $this->input->get_post('data') ;
		$upload_folder = $this->input->get_post('upload_folder') ;
		$decodeData = json_decode($data);

		$params = array();
		$params['oauth_token'] = $this->input->get_post('oauth_token') ;
		$params['oauth_token_secret'] = $this->oauth->token('oauth_token_secret');
		$params['oauth_verifier'] = $this->input->get_post('oauth_verifier') ;

		$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
		$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
		$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

		$request_header = array() ;

		$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
		$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
		$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

		$provider = $this->oauth->getProvider() ;
		$consumer = $this->oauth->getConsumer() ;

		$api_token = $provider->getAPIToken($consumer->get('api_key'),$consumer->get('secret_key')) ;

		for ($i = 0; $i < count($decodeData); $i++) {
			$temp = $this->filebox->view_entry($decodeData[$i]);
			$upload_file_url;

			foreach($temp as $key => $value){
				$folder = date ('Ymd', strtotime ($value->reg_date));
				$file_fold_url = 'filebox/files/file/' . $folder . '/';
				$img_fold_url = 'filebox/files/img/' . $folder . '/';
				if(is_file($file_fold_url  . $decodeData[$i])){
					$upload_file_url = $file_fold_url  . $decodeData[$i];
				}else if(is_file($img_fold_url  . $decodeData[$i])){
					$upload_file_url = $img_fold_url  . $decodeData[$i];
				}
				if(is_file($upload_file_url)){
					$request_body = array('api_token'=>$api_token,'folder_id'=>$upload_folder,'file_name'=>$value->upload_file_name,'mediaType'=>$value->file_type) ;
					$response = $this->oauth->api_call('createfile',$request_header,$request_body,'POST') ;

					$temp_upload_file = json_decode($response);

					if($temp_upload_file->result_code == 201){
						$transfer_mode = 'UP';
						$request_body = array('api_token'=>$api_token,'file_id'=>$temp_upload_file->file_id,'transfer_mode'=>$transfer_mode) ;
						$response = $this->oauth->api_call('createfiletoken',$request_header,$request_body,'POST') ;
							
						$temp_upload_file_re = json_decode($response);

						if($temp_upload_file_re->result_code == 200){
							$this->load->helper('download');
							// 							$data = file_get_contents($upload_file_url);

							$params = array(
									'http' => array(
											'method' => 'PUT',
											'content' => file_get_contents($upload_file_url)
									)
							);
							$upload_url = $temp_upload_file_re->redirect_url . "?api_token=" . $api_token . "&file_token=" . $temp_upload_file_re->file_token;

							$ctx = stream_context_create($params);
							$response = @file_get_contents($upload_url, false, $ctx);
							if($response == '')
								$success = "success";

						}
					}
				}
			}
		}
		echo json_encode($success);
	}

	public function deleteFile(){
		$api_key = '38629799a8e9388c6ce742ed71fb6233' ;
		$secret_key = '29b30a42991c73e76032c5f20b4b7858' ;
		$callback_url = 'http://localhost:8888';
		$this->load->helper('url') ;
		$this->load->model('filebox/filebox_model', 'filebox');

		$this->load->library('oauth',array(
				'api_key'=>$api_key,
				'secret_key'=>$secret_key,
				'callback_url'=>base_url().'auth/oauth/',
				'signature_method'=>'HMAC-SHA1',
				'provider'=>'Ucloud',
				'oauth_version'=>'1.0'
		)) ;

		$data = $this->input->get_post('data') ;
		$decodeData = json_decode($data);

		$params = array();
		$params['oauth_token'] = $this->input->get_post('oauth_token') ;
		$params['oauth_token_secret'] = $this->oauth->token('oauth_token_secret');
		$params['oauth_verifier'] = $this->input->get_post('oauth_verifier') ;

		$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
		$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
		$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

		$request_header = array() ;

		$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
		$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
		$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

		$provider = $this->oauth->getProvider() ;
		$consumer = $this->oauth->getConsumer() ;

		$api_token = $provider->getAPIToken($consumer->get('api_key'),$consumer->get('secret_key')) ;

		for ($i = 0; $i < count($decodeData); $i++) {
			$request_body = array('api_token'=>$api_token,'file_id'=>$decodeData[$i]) ;
			$response = $this->oauth->api_call('deletefile',$request_header,$request_body,'POST') ;
			$temp_delete_file = json_decode($response);
			if($temp_delete_file->result_code == 204){
				$success="success";
			}else{
				$request_body = array('api_token'=>$api_token,'folder_id'=>$decodeData[$i]) ;
				$response = $this->oauth->api_call('deletefolder',$request_header,$request_body,'POST') ;
				$temp_delete_folder = json_decode($response);
				if($temp_delete_folder->result_code == 204){
					$success="success";
				}
			}
		}
		echo json_encode($success);
	}

	public function moveFilebox(){
		$api_key = '38629799a8e9388c6ce742ed71fb6233' ;
		$secret_key = '29b30a42991c73e76032c5f20b4b7858' ;
		$callback_url = 'http://localhost:8888';
		$this->load->helper('url') ;
		$this->load->helper('download') ;
		$this->load->helper('date') ;
		$this->load->helper('security');

		$this->load->library('oauth',array(
				'api_key'=>$api_key,
				'secret_key'=>$secret_key,
				'callback_url'=>base_url().'auth/oauth/',
				'signature_method'=>'HMAC-SHA1',
				'provider'=>'Ucloud',
				'oauth_version'=>'1.0'
		)) ;

		$success = "";
		$upload_folder = $this->input->get_post('upload_folder') ;
		$data_id = $this->input->get_post('data_id') ;
		$data_name = $this->input->get_post('data_name') ;
		$decodeData_id = json_decode($data_id);
		$decodeData_name = json_decode($data_name);
		$transfer_mode = "DN";

		$params = array();
		$params['oauth_token'] = $this->input->get_post('oauth_token') ;
		$params['oauth_token_secret'] = $this->oauth->token('oauth_token_secret');
		$params['oauth_verifier'] = $this->input->get_post('oauth_verifier') ;

		$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
		$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
		$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

		$request_header = array() ;

		$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
		$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
		$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

		$provider = $this->oauth->getProvider() ;
		$consumer = $this->oauth->getConsumer() ;

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

		for ($i = 0; $i < count($decodeData_id); $i++) {
			$dest = "";
			$api_token = $provider->getAPIToken($consumer->get('api_key'),$consumer->get('secret_key')) ;

			$request_body = array('api_token'=>$api_token,'file_id'=>$decodeData_id[$i],'transfer_mode'=>$transfer_mode) ;
			$response = $this->oauth->api_call('createfiletoken',$request_header,$request_body,'POST') ;

			$temp = json_decode($response);
			$upload_file_url = $temp->redirect_url . "?api_token=" . $api_token . "&file_token=" . $temp->file_token;
			$download_file = file_get_contents($upload_file_url); // Read the file's contents
			if($download_file){
				$file_name = $decodeData_name[$i];
				file_put_contents("filebox/temp/".$file_name, $download_file);
				$file_url = "filebox/temp/".$file_name;
				$exts = explode(".",$file_name) ;
				$file_type = $exts[1];
				$source_file_name = do_hash($file_name . time(), 'md5') . "." . $file_type;
				if($file_type == "png" || $file_type == "jpg" || $file_type == "jpeg" || $file_type == "gif"){
					// img directory
					$save_dir = "filebox/files/img/".date("Ymd");
					// img thumb directory
					$save_thumb_dir = "filebox/files/img/".date("Ymd")."/thumbs/";
					// file type modify
					$file_type_detail = "image/" . $file_type;
					// file move
					if(is_file($file_url)){ // img move
						//check if the $name folder exists, if not create it
						if( ! is_dir($save_dir))
						{
							mkdir($save_dir,0777);
							mkdir($save_thumb_dir,0777);
						}
						// moving data
						$dest = $save_dir . "/" . $source_file_name;
						// move
						rename($file_url, $dest);
							
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
					// file type modify
					$file_type_detail = "application/" . $file_type;
					// file move
					if(is_file($file_url)){
						//check if the $name folder exists, if not create it
						if( ! is_dir($save_dir))
						{
							mkdir($save_dir,0777);
						}
						// moving data
						$dest = $save_dir . "/" . $source_file_name;
						// move
						rename($file_url, $dest);
					}
				}
				if(is_file($dest)){

					// get DB library
					$this->load->model('filebox/filebox_model', 'filebox');
					// DB insert Data
					$insert_data;
					$insert_data->file_type = $file_type_detail;
					$insert_data->upload_file_name = $file_name;
					$insert_data->source_file_name = $source_file_name;
					$insert_data->file_size = filesize($dest);;
					$insert_data->reg_date = standard_date('DATE_ATOM',time());//date("Y-m-d H:i:s",time());
					$insert_data->ip_address = $this->input->ip_address();
					$insert_data->username = $this->username;
					$insert_data->email = $this->email;
					$insert_data->uid = $this->uid;
					// insert data into db
					$this->filebox->insert_entry($insert_data);
					// return;
					$success="success";
				}
			}
		}
		echo json_encode($success);
	}

	public function createFolder(){
		$api_key = '38629799a8e9388c6ce742ed71fb6233' ;
		$secret_key = '29b30a42991c73e76032c5f20b4b7858' ;
		$callback_url = 'http://localhost:8888';
		$this->load->helper('url') ;
		$this->load->model('filebox/filebox_model', 'filebox');

		$this->load->library('oauth',array(
				'api_key'=>$api_key,
				'secret_key'=>$secret_key,
				'callback_url'=>base_url().'auth/oauth/',
				'signature_method'=>'HMAC-SHA1',
				'provider'=>'Ucloud',
				'oauth_version'=>'1.0'
		)) ;

		$folder_id = $this->input->get_post('upload_folder') ;
		$folder_name = $this->input->get_post('addFolderName') ;

		$params = array();
		$params['oauth_token'] = $this->input->get_post('oauth_token') ;
		$params['oauth_token_secret'] = $this->oauth->token('oauth_token_secret');
		$params['oauth_verifier'] = $this->input->get_post('oauth_verifier') ;

		$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
		$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
		$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

		$request_header = array() ;

		$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
		$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
		$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

		$provider = $this->oauth->getProvider() ;
		$consumer = $this->oauth->getConsumer() ;

		$api_token = $provider->getAPIToken($consumer->get('api_key'),$consumer->get('secret_key')) ;

		$request_body = array('api_token'=>$api_token,'folder_id'=>$folder_id,'folder_name'=>$folder_name) ;
		$response = $this->oauth->api_call('createfolder',$request_header,$request_body,'POST') ;

		$success = $response;
		echo json_encode($success);

	}
}

/* End of file Oauth.php */
/* Location : ./modules/oauth/oauth.php */
