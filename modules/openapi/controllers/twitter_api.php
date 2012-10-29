<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Twitter_api extends MX_Controller { 
    public function __construct(){
		$this->load->library('session');

    }

    public function search(){
        $search_keyword = urlencode($this->input->get_post('search_keyword'));
        $url = 'http://search.twitter.com/search.json?q='.$search_keyword ; 

        $page = $this->input->get_post('page') ; 

        if($page){
            $url=$url.'&page='.$page ; 
        }

        //$url = urlencode($url) ; 

        $ch = curl_init() ; 
        curl_setopt($ch,CURLOPT_URL,$url) ; 
        curl_setopt($ch,CURLOPT_POST,0) ; 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1) ; 
        $data = curl_exec($ch) ; 
        //echo $data ; 

        $data = json_decode($data) ;

        $response = array() ; 
        $response['items'] = $data->results ; 

        echo json_encode($response) ; 
    }

    public function callback(){
        $this->load->helper('url') ;
		$this->load->library('session');

		$this->load->model('openapi/openapi_model') ; 
        $keys = $this->openapi_model->getKeys('twitter') ; 

		$api_key = $keys->api_key;
		$secret_key = $keys->secret_key;
		
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
		//$data['uid'] = $this->uid;
		//$data['cloud_enterprise'] = $this->session->userdata('cloud_enterprise');
		$data['mod_oauth_token'] = $this->input->get_post('oauth_token');
		$data['mod_oauth_secret_token'] = $this->oauth->token('oauth_token_secret');
		$data['mod_oauth_verifier'] = $this->input->get_post('oauth_verifier');
		$this->auth->update_entry($data);

		// session setting
		/*$this->session->set_userdata('session_kt_ucloud_oauth_token', $this->input->get_post('oauth_token'));
		$this->session->set_userdata('session_kt_ucloud_oauth_verifier', $this->input->get_post('oauth_verifier'));
		$this->session->set_userdata('session_kt_ucloud_oauth_token_secret', $this->oauth->token('oauth_token_secret'));*/

		redirect(base_url().'admin/clouddrive/ucloudView', 'refresh');
    }

    public function oauth(){

        $this->load->model('openapi/openapi_model') ; 
        $keys = $this->openapi_model->getKeys('twitter') ; 

		$api_key = $keys->api_key;
		$secret_key = $keys->secret_key;
		
		
		// setting session
		//$this->session->set_userdata('oauth_provider', "KTUcloud");
		
		$this->session->unset_userdata('session_twitter_oauth_token');
		$this->session->unset_userdata('session_twitter_oauth_verifier');
		$this->session->unset_userdata('session_twitter_oauth_token_secret');

		// uclod oauth
		$callback_url = base_url().'openapi/twitter_api/callback'; 
		$this->load->library('oauth',array(
				'api_key'=>$api_key,
				'secret_key'=>$secret_key,
				'callback_url'=>$callback_url,
				'signature_method'=>'HMAC-SHA1',
				'provider'=>'Twitter',
				'oauth_version'=>'1.0'
		)) ;
		if(!$this->input->get_post('oauth_token')){
			$response = $this->oauth->request_token(array(),'POST') ;
			$this->oauth->token('oauth_token_secret',$response['oauth_token_secret']) ;
			$this->oauth->authorize($response) ;
		}
	}
}
