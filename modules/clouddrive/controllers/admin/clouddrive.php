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

	public function ucloudView(){
		$api_key = '38629799a8e9388c6ce742ed71fb6233' ;
		$secret_key = '29b30a42991c73e76032c5f20b4b7858' ;
		$callback_url = 'http://localhost:8888';
		$this->load->helper('url') ;
		$this->load->library('session');

		$this->load->library('oauth',array(
				'api_key'=>$api_key,
				'secret_key'=>$secret_key,
				'callback_url'=>base_url().'clouddrive/admin/clouddrive/ucloudView',
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
			
			// session
			$this->session->set_userdata('session_oauth_token', $this->input->get_post('oauth_token'));
			$this->session->set_userdata('session_oauth_token_secret', $this->oauth->token('oauth_token_secret'));

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

			// view
			$layout = array() ;
			$this->load->library('admin_tmpl') ;

			$section = array(
					'header'=>'admin/header',
					'sidebar'=>'admin/sidebar',
					'body'=>'admin/clouddrive',
					'footer'=>'admin/footer'
			) ;

			$str= $this->admin_tmpl->parse($section,$data);
				
			echo $str;
		}
	}

	// check oauth
	public function checkOauth(){
		$this->load->library('session');

		$session_temp = $this->session->all_userdata();

		$data = array();
		// check access token
		$data['oauth_token'] =  $this->session->userdata('session_oauth_token');
		// check access token token secrete
		$data['oauth_token_secret'] = $this->session->userdata('session_oauth_token_secret');

		// view
		$layout = array() ;
		$this->load->library('admin_tmpl') ;

		$section = array(
				'header'=>'admin/header',
				'sidebar'=>'admin/sidebar',
				'body'=>'admin/checkoauth.php',
				'footer'=>'admin/footer'
		) ;

		$str= $this->admin_tmpl->parse($section,$data);

		echo $str ;
	}
}

/* End of file Oauth.php */
/* Location : ./modules/oauth/oauth.php */
