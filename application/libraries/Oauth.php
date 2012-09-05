<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once('oauth/OAuthUtil.php') ; 
class Oauth {
    var $version ; 
    var $consumer ;
    var $provider ; 
    var $signature_method = 'HMAC-SHA1' ; 

    function __construct($config=array()){
        $api_key = $config['api_key'] ;
        $secret_key = $config['secret_key'] ;
        $callback_url = $config['callback_url'] ;
        $provider = $config['provider'] ;
        $signature_method = $config['signature_method'] ;

        include_once('oauth/Consumer.php') ; 
        include_once('oauth/provider/Provider_Factory.php') ; 

        $oauth_config = array(
            'signature_method'=>$signature_method ,
            'oauth_version' => $config['oauth_version'] 
        ); 

        $this->consumer = new Consumer($config,$oauth_config) ; 
        $this->provider = Provider_Factory::factory($provider,$oauth_config); 
    }

    public function getUserData(){

    }

    public function setUserData(){

    }

    public function request_token($params=array(),$method='GET'){
        $response = $this->consumer->requestTo($this->provider,'request_token',$params,$method) ; 
        return $response ; 
    }

    public function access_token($params=array(),$method='GET'){
        $response = $this->consumer->requestTo($this->provider,'access_token',$params,$method);

        return $response ; 

    }

    public function api_call($api_name,$request_header,$request_body,$method='GET'){
        $response = $this->provider->api_call($this->consumer,$api_name,$request_header,$request_body,$method); 

        return $response ; 
    }

    public function authorize($param){
        $this->provider->authorize($param) ; 
    }

    public function getConsumer(){ 
        return $this->consumer ; 
    }

    public function getProvider(){ 
        return $this->provider ; 
    }

    public function token($key,$value=null){
        $CI = get_instance() ;
        $CI->load->library('session') ; 
        if($value){
            return $CI->session->set_userdata($key,$value); 
        }

        return $CI->session->userdata($key) ; 
    }
}

/* End of file Tank_auth.php */
/* Location: ./application/libraries/Tank_auth.php */
