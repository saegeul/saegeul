<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Auth extends MX_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->database();
	}

	public function auth(){

	}

	public function callback(){

	}

	//     public function test(){
	//         $api_key = '4a4e6a208e1d864aadf9c9751fab02b4' ;
	//         $secret_key = '0851290adc6adb8d536c05d08f27f722' ;
	//         $callback_url = 'http://localhost:8888';
	//         $this->load->helper('url') ;

	//         $this->load->library('oauth',array(
	//                                         'api_key'=>$api_key,
	//                                         'secret_key'=>$secret_key,
	//                                         'callback_url'=>base_url().'auth/oauth/',
	//                                         'signature_method'=>'HMAC-SHA1',
	//                                         'provider'=>'Ucloud',
	//                                         'oauth_version'=>'1.0'
	//         )) ;

	//         $provider = $this->oauth->getProvider() ;
	//             $consumer = $this->oauth->getConsumer() ;

	//             $api_token = $provider->getAPIToken('92ee57b9f57baf6a3cfef08340cf353c','2117ef26dc3a7074f507afae828816d4') ;

	//             print_r($api_token) ;




	//     }

	public function oauth(){
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

		if($this->input->get_post('oauth_token')){
			$params = array();
			$params['oauth_token'] = $this->input->get_post('oauth_token') ;
			$params['oauth_token_secret'] = $this->oauth->token('oauth_token_secret');
			$params['oauth_verifier'] = $this->input->get_post('oauth_verifier') ;

			$response = $this->oauth->access_token($params,'POST') ;
			$this->oauth->token('oauth_token_secret',isset($response['oauth_token_secret'])?$response['oauth_token_secret']:"") ;
			$this->oauth->token('oauth_token',isset($response['oauth_token'])?$response['oauth_token']:"") ;

			$request_header = array() ;

			$request_header['oauth_token'] = $this->oauth->token('oauth_token') ;
			$request_header['oauth_verifier'] =  $params['oauth_verifier'] ;
			$request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ;

			//             print_r($request_header) ;

			$provider = $this->oauth->getProvider() ;
			$consumer = $this->oauth->getConsumer() ;

			$api_token = $provider->getAPIToken($consumer->get('api_key'),$consumer->get('secret_key')) ;

			$request_body = array('api_token'=>$api_token) ;
			$response = $this->oauth->api_call('getsyncfolder',$request_header,$request_body,'POST') ;

			$data['result'] = $response;

			$this->load->view('auth',$data);

		}else{
			$response = $this->oauth->request_token(array(),'POST') ;
			$this->oauth->token('oauth_token_secret',$response['oauth_token_secret']) ;
			$this->oauth->authorize($response) ;
		}
			
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

	public function uploadFile(){
		$api_key = '38629799a8e9388c6ce742ed71fb6233' ;
		$secret_key = '29b30a42991c73e76032c5f20b4b7858' ;
		$callback_url = 'http://localhost:8888';
		$this->load->helper('url') ;
		$this->load->model('filebox/filebox_model', 'filebox'); // 모델 - 호출

		$this->load->library('oauth',array(
				'api_key'=>$api_key,
				'secret_key'=>$secret_key,
				'callback_url'=>base_url().'auth/oauth/',
				'signature_method'=>'HMAC-SHA1',
				'provider'=>'Ucloud',
				'oauth_version'=>'1.0'
		)) ;

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
				$upload_file_url = 'filebox/files/img/' . $folder . '/' . $decodeData[$i];
				if(is_file($upload_file_url)){
					$request_body = array('api_token'=>$api_token,'folder_id'=>$upload_folder,'file_name'=>$decodeData[$i],'mediaType'=>$value->img_type) ;
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
}

/* End of file Oauth.php */
/* Location : ./modules/oauth/oauth.php */
