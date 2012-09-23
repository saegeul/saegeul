<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Auth extends MX_Controller {
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
		$this->cloud_enterprise = "KTUcloud";
	}

	public function auth(){

	}

	public function call(){
		$this->load->helper('url') ;
		$this->load->library('session');
		
		// get session
		$api_key = $this->session->userdata('session_kt_api_key');
		$secret_key = $this->session->userdata('session_kt_secret_key');

		$callback_url = 'http://localhost:8888';
		$this->load->library('oauth',array(
				'api_key'=>$api_key,
				'secret_key'=>$secret_key,
				'callback_url'=>base_url().'clouddrive/admin/clouddrive/ucloudView',
				'signature_method'=>'HMAC-SHA1',
				'provider'=>'Ucloud',
				'oauth_version'=>'1.0'
		)) ;

		// get DB library
		$this->load->model('Auth_model','auth');
		$data['uid'] = $this->uid;
		$data['cloud_enterprise'] = $this->session->userdata('cloud_enterprise');
		$data['mod_oauth_token'] = $this->input->get_post('oauth_token');
		$data['mod_oauth_secret_token'] = $this->oauth->token('oauth_token_secret');
		$data['mod_oauth_verifier'] = $this->input->get_post('oauth_verifier');
		$this->auth->update_entry($data);

		// session setting
		$this->session->set_userdata('session_kt_ucloud_oauth_token', $this->input->get_post('oauth_token'));
		$this->session->set_userdata('session_kt_ucloud_oauth_verifier', $this->input->get_post('oauth_verifier'));
		$this->session->set_userdata('session_kt_ucloud_oauth_token_secret', $this->oauth->token('oauth_token_secret'));

		redirect(base_url().'clouddrive/admin/clouddrive/ucloudView', 'refresh');
	}

	// kt ucloud oauth
	public function oauth(){
		$this->load->helper('url') ;
		$this->load->library('session');
		// get DB library
		$this->load->model('Auth_model','auth');
		
		$cloud_enterprise ="KTUcloud";
		// get api_key , secret_key
		$data = $this->auth->view_entry($this->uid,$cloud_enterprise);
		
		foreach($data as $key => $value){
			$api_key = $value->api_key;
			$secret_key = $value->secret_key;
		}

		// setting session
		$this->session->set_userdata('session_kt_api_key', $api_key);
		$this->session->set_userdata('session_kt_secret_key', $secret_key);
		$this->session->set_userdata('cloud_enterprise', $cloud_enterprise);
		
		// uclod oauth
		$callback_url = 'http://localhost:8888';
		$this->load->library('oauth',array(
				'api_key'=>$api_key,
				'secret_key'=>$secret_key,
				'callback_url'=>base_url().'auth/call',
				'signature_method'=>'HMAC-SHA1',
				'provider'=>'Ucloud',
				'oauth_version'=>'1.0'
		)) ;
		if(!$this->input->get_post('oauth_token')){
			//login kt ucloud
			$response = $this->oauth->request_token(array(),'POST') ;
			$this->oauth->token('oauth_token_secret',$response['oauth_token_secret']) ;
			$this->oauth->authorize($response) ;
		}
	}
}

/* End of file Oauth.php */
/* Location : ./modules/oauth/oauth.php */
