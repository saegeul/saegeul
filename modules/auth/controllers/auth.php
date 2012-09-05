<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Auth extends MX_Controller {

    public function auth(){

    }

    public function callback(){

    }

    public function test(){
        $api_key = '4a4e6a208e1d864aadf9c9751fab02b4' ; 
        $secret_key = '0851290adc6adb8d536c05d08f27f722' ; 
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

        $provider = $this->oauth->getProvider() ;
            $consumer = $this->oauth->getConsumer() ;

            $api_token = $provider->getAPIToken('92ee57b9f57baf6a3cfef08340cf353c','2117ef26dc3a7074f507afae828816d4') ; 

            print_r($api_token) ; 




    }

    public function oauth(){
        $api_key = '4a4e6a208e1d864aadf9c9751fab02b4' ; 
        $secret_key = '0851290adc6adb8d536c05d08f27f722' ; 
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
            $this->oauth->token('oauth_token_secret',$response['oauth_token_secret']) ; 
            $this->oauth->token('oauth_token',$response['oauth_token']) ; 

            $request_header = array() ; 

            $request_header['oauth_token'] = $this->oauth->token('oauth_token') ; 
            $request_header['oauth_verifier'] =  $params['oauth_verifier'] ; 
            $request_header['oauth_token_secret'] = $this->oauth->token('oauth_token_secret') ; 

            print_r($request_header) ; 

            $provider = $this->oauth->getProvider() ;
            $consumer = $this->oauth->getConsumer() ;

            //$api_token = $provider->getAPIToken($consumer->get('api_key'),$consumer->get('secret_key')) ; 
            $api_token = $provider->getAPIToken($consumer->get('api_key'),$consumer->get('secret_key')) ; 

            

            $request_body = array('api_token'=>$api_token) ; 
            $response = $this->oauth->api_call('getUserInfo',$request_header,$request_body,'POST') ;

            print_r($response) ; 

        }else{ 
            $response = $this->oauth->request_token(array(),'POST') ;
            $this->oauth->token('oauth_token_secret',$response['oauth_token_secret']) ; 
            $this->oauth->authorize($response) ; 
        } 
       
    } 
} 

/* End of file Oauth.php */
/* Location : ./modules/oauth/oauth.php */
