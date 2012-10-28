<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Auth extends MX_Controller {
	// DB isert user information
	protected $username;
	protected $email;
	protected $uid;

	public function __construct() {
		parent::__construct();

		$this->load->database();
		$this->load->helper('date');
		$this->load->helper('url');
		$this->load->library('session');
		
		$this->load->library('tank_auth');
		$this->username = $this->tank_auth->get_username();
		$this->uid = $this->tank_auth->get_user_id();
		$this->email = $this->tank_auth->get_useremail();
	}

	public function resisterKtApi(){
		$this->load->model('Auth_model','auth');
		$args->api_key = $this->input->get_post('api_key');
		$args->secret_key = $this->input->get_post('secretkey');
		$args->username = $this->username;
		$args->email = $this->email;
		$args->uid = $this->uid;
		$args->reg_date = standard_date('DATE_ATOM',time());;
		$args->ip_address = $this->input->ip_address();
		
		// insert file information in DB
		$ret_data = $this->auth->insert($args);
		
		redirect('admin/clouddrive/checkOauth', 'refresh');
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
				'callback_url'=>base_url().'admin/clouddrive/ucloudView',
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

		redirect(base_url().'admin/clouddrive/ucloudView', 'refresh');
	}

	// kt ucloud oauth
	public function oauth(){
		$api_key = $this->session->userdata('session_kt_api_key');
		$secret_key = $this->session->userdata('session_kt_secret_key');
		
		if($api_key == false || $secret_key == false)
				redirect(base_url().'admin/clouddrive/checkOauth', 'refresh');
		
		// setting session
		$this->session->set_userdata('cloud_enterprise', "KTUcloud");
		
		$this->session->unset_userdata('session_kt_ucloud_oauth_token');
		$this->session->unset_userdata('session_kt_ucloud_oauth_verifier');
		$this->session->unset_userdata('session_kt_ucloud_oauth_token_secret');

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
