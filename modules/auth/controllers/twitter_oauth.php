<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Twitter_auth extends MX_Controller {
    public function __construct(){
        parent::__construct(); 
        $this->load->database() ; 
    }

    public function oauth(){

    }

    public function callback(){

    }

    public function oauth(){
		$api_key = '38629799a8e9388c6ce742ed71fb6233' ;
		$secret_key = '29b30a42991c73e76032c5f20b4b7858' ;
		$callback_url = 'http://localhost:8888';
		$this->load->helper('url') ;

		$this->load->library('oauth',array(
				'api_key'=>$api_key,
				'secret_key'=>$secret_key,
				'callback_url'=>base_url().'clouddrive/admin/clouddrive/ucloudView',
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
