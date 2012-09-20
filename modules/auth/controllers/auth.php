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

	// kt ucloud oauth
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

		// check oauth token
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

			$provider = $this->oauth->getProvider() ;
			$consumer = $this->oauth->getConsumer() ;

			$api_token = $provider->getAPIToken($consumer->get('api_key'),$consumer->get('secret_key')) ;

			$request_body = array('api_token'=>$api_token) ;
			$response = $this->oauth->api_call('getsyncfolder',$request_header,$request_body,'POST') ;

			$data['result'] = $response;

			$this->load->view('ucloud/ucloud',$data);

		}else{
			// login kt ucloud
			$response = $this->oauth->request_token(array(),'POST') ;
			$this->oauth->token('oauth_token_secret',$response['oauth_token_secret']) ;
			$this->oauth->authorize($response) ;
		}
			
	}
}

/* End of file Oauth.php */
/* Location : ./modules/oauth/oauth.php */
