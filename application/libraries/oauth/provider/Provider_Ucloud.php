<?php 
class Provider_Ucloud extends Provider {
	var $url_prefix = 'https://openapi.ucloud.com/ucloud/oauth/1.0a/';

	function __construct($provider,$oauth_config){
		parent::__construct($provider,$oauth_config);
	}

	function _getRequestTokenURL(){
		return $url = $this->url_prefix.'request_token' ;
	}

	function _getAccessTokenURL(){
		return $url = $this->url_prefix.'access_token' ;
	}


	function _getAuthorizeURL(){
		return $url = $this->url_prefix.'authorize' ;
	}

	function _getAPIUrl($api_name){
		$url_prefix = 'https://openapi.ucloud.com/ucloud/api/1.0/';

		$url = $url_prefix.'ucloud/basic/getuserinfo.json' ;
		if($api_name == 'getUserInfo'){
			$url = $url_prefix.'ucloud/basic/getuserinfo.json' ;
		}else if($api_name == 'getContents'){
			$url = $url_prefix.'ucloud/basic/getContents.json' ;
		}else if($api_name == 'createfiletoken'){
			$url = $url_prefix.'ucloud/basic/createfiletoken.json' ;
		}else if($api_name == 'getsyncfolder'){
			$url = $url_prefix.'ucloud/basic/getsyncfolder.json' ;
		}else if($api_name == 'createfile'){
			$url = $url_prefix.'ucloud/basic/createfile.json' ;
		}else if($api_name == 'createfiletoken'){
			$url = $url_prefix.'ucloud/basic/createfiletoken.json' ;
		}else if($api_name == 'deletefile'){
			$url = $url_prefix.'ucloud/basic/deletefile.json' ;
		}else if($api_name == 'createfolder'){
			$url = $url_prefix.'ucloud/basic/createfolder.json' ;
		}else if($api_name == 'deletefolder'){
			$url = $url_prefix.'ucloud/basic/deletefolder.json' ;
		}

		return $url ;
	}

	public function api_call(& $consumer,$api_name,$request_header,$request_body,$method='GET'){
		$param = array() ;
		$url = $this->_getAPIUrl($api_name);
		get_instance()->load->helper('string');

		//$param['oauth_callback'] = $consumer->get('callback_url') ;
		$param['oauth_consumer_key'] = $consumer->get('api_key') ;
		//         $param['api_token'] = $request_body['api_token'] ;
		$param['oauth_nonce'] = random_string('alnum', 32);
		$param['oauth_signature_method'] = $this->getSignatureMethod() ;
		$param['oauth_timestamp'] = time();
		$param['oauth_token'] =  $request_header['oauth_token'];
		$param['oauth_version'] =  $this->getOAuthVersion() ;
		//$param['oauth_verifier'] =  $request_header['oauth_verifier'];

		$base_string = OAuthUtil::base_string($method,$url,$param=array_merge($param,$request_body)) ;
		$key_arr = array(($consumer->get('secret_key')),($request_header['oauth_token_secret']))  ;


		$key = OAuthUtil::urlencode($key_arr) ;
		$key = implode('&',$key_arr) ;

		$param['oauth_signature'] = OAuthUtil::make_signature($base_string,$key) ;

		$response = OAuthUtil::call($url,$method,$param,$request_body) ;
		//$response = OAuthUtil::parse_param($response) ;

		return $response ;
	}

	public function getRequestToken(& $consumer,$params,$method='GET'){
		$param = array() ;
		$url = $this->_getRequestTokenURL();
		get_instance()->load->helper('string');

		$param['oauth_callback'] = $consumer->get('callback_url') ;
		$param['oauth_consumer_key'] = $consumer->get('api_key') ;
		$param['oauth_nonce'] = random_string('alnum', 32);
		$param['oauth_signature_method'] = $this->getSignatureMethod() ;
		$param['oauth_timestamp'] = time();
		$param['oauth_version'] =  $this->getOAuthVersion() ;

		$base_string = OAuthUtil::base_string($method,$url,$param ) ;

		$key_arr = array($consumer->get('secret_key'),'' )  ;

		$key = OAuthUtil::urlencode($key_arr) ;
		$key = implode('&',$key) ;

		$param['oauth_signature'] = OAuthUtil::make_signature($base_string,$key) ;

		$response = OAuthUtil::call($url,$method,$param) ;

		return OAuthUtil::parse_param($response) ;
	}

	public function getAccessToken(& $consumer,$params=array(),$method='GET'){
		$param = array() ;
		$url = $this->_getAccessTokenURL();
		get_instance()->load->helper('string');

		$param['oauth_callback'] = $consumer->get('callback_url') ;
		$param['oauth_consumer_key'] = $consumer->get('api_key') ;
		$param['oauth_nonce'] = random_string('alnum', 32);
		$param['oauth_signature_method'] = $this->getSignatureMethod() ;
		$param['oauth_timestamp'] = time();
		$param['oauth_token'] =  $params['oauth_token'];
		$param['oauth_version'] =  $this->getOAuthVersion() ;
		$param['oauth_verifier'] =  $params['oauth_verifier'];

		$base_string = OAuthUtil::base_string($method,$url,$param ) ;

		$key_arr = array($consumer->get('secret_key'),$params['oauth_token_secret'] )  ;

		$key = OAuthUtil::urlencode($key_arr) ;
		$key = implode('&',$key) ;

		$param['oauth_signature'] = OAuthUtil::make_signature($base_string,$key) ;

		$response = OAuthUtil::call($url,$method,$param) ;

		$response = OAuthUtil::parse_param($response) ;
		$response['api_token'] = $this->getAPIToken($consumer->get('api_key'),$consumer->get('secret_key')) ;

		return $response ;
	}

	public function getAPIToken($api_key,$secret_key){
		$ts = time() ;
		$base_string = $api_key.';'.$ts ;

		$signature=base64_encode(hash_hmac('sha1', $base_string, $secret_key, TRUE));
		return OAuthUtil::urlencode(base64_encode($api_key.';'.$ts.';'.$signature));
	}

	public function authorize($param){
		get_instance()->load->helper('url') ;

		redirect($this->_getAuthorizeUrl().'?oauth_token='.$param['oauth_token']) ;
	}
}
/* end of Provider_Ucloud.php */
