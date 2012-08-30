<?php
include_once("KTOpenApiRestHandler.php");

/**
 * RFC3986 Encoding
 *
 * @params 
 *   - String	$input		스트링
 * @return	String	encoded string
 * @see
 */
function urlencode_rfc3986($input) 
{ 		
	if (is_array($input)) {
		return array_map('urlencode_rfc3986', $input);
	} else if (is_scalar($input)) {
		return str_replace(
		  '+',    
		  ' ',
		  str_replace('%7E', '~', rawurlencode($input))
		);
	}
	return '';
}

class KTOpenApiOauthHandler extends KTOpenApiRestHandler {
	var $m_oauth	;		// Oauth 정보	
	var $m_oauthKey;
	var $m_oauthSecret;

	/**
	 * Constructor
	 *
	 * @see
	 */
	function KTOpenApiOauthHandler($authKey, $authSecret, $appType = DEF_WEB_APP)
	{
		KTOpenApiRestHandler::KTOpenApiRestHandler($authKey, $authSecret);

		$this->m_oauthKey = $authKey;
		$this->m_oauthSecret = $authSecret;
	}
	
	function setOauthInfo($oauth)
	{
		$this->m_oauth = $oauth;
	}	
	
	/**
	 *  nonce 생성
	 *
	 * @return	String	nonce
	 * @see
	 */
	function makeNonce() 
	{ 
		$mt = microtime();
		$rand = mt_rand();
		return md5($mt . $rand); 
	}

	
	/**
	 * Oauth Parameter 생성 기능
	 *
	 * @params 
	 *   - $add_params		HashMap		Oauth 추가 Parameter
	 * @return	HashMap		Oauth Parameter
	 * @see
	 */
	function makeOauthParams($add_params)
	{
		// Nonce 생성
		$oauth_nonce		= $this->makeNonce();

		// Timestamp 생성
		$oauth_timestamp	= time();

		// Make oauth parameters		
		$oauth_params = array();
		$oauth_params["oauth_consumer_key"    ] = urlencode_rfc3986($this->m_oauthKey);
		$oauth_params["oauth_nonce"           ] = urlencode_rfc3986($oauth_nonce);
		$oauth_params["oauth_timestamp"       ] = urlencode_rfc3986($oauth_timestamp);
		$oauth_params["oauth_signature_method"] = urlencode_rfc3986($this->m_oauth->getSignatureMethod());
		$oauth_params["oauth_version"         ] = urlencode_rfc3986($this->m_oauth->getVersion());
		
		return array_merge($oauth_params, $add_params);
	}
	
	/**
	 * Oauth Signature 생성을 위한 Base String 생성 기능
	 *
	 * @params 
	 *   - $url				String		Request URL
	 *   - $http_method		String		Request HTTP Method
	 *   - $oauth_params	HashMap		Oauth Parameter
	 *   - $other_params	HashMap		Other Parameter
	 * @return	String		Base String 
	 * @see
	 */
	function makeBaseString($url, $http_method, $oauth_params, $other_params)
	{
		// Merge oauth_params and params
		$temp_params = array_merge($oauth_params, $other_params);

		// sort by parameter name
		ksort($temp_params);
		
		// make parameter string
		$param_str = "";

		$first = true;
		foreach ($temp_params as $k => $v) {
		    if ( $first == false ) {
		        $param_str = $param_str . "&";
		    }
		    $param_str = $param_str . urlencode_rfc3986($k) . '=' . urlencode_rfc3986($v);
		    $first = false;
		}

		/* make base string */
		$base_str = $http_method . "&" .
                    	urlencode_rfc3986(strtolower($url)) . "&" .
                        urlencode_rfc3986($param_str);

		$base_str = str_replace('%2525', '%25', $base_str);

		return $base_str;
	}

	/**
	 * Oauth Signature 생성
	 *
	 * @params 
	 *   - String	$baseStr	Sign할 기본 스트링
	 *   - String	$key		Secret 키
	 * @return	String	Signed String
	 * @see
	 */
	function makeOauthSignature($baseStr, $key) 
	{ 		
		$signature = hash_hmac("sha1", $baseStr, $key, true);
		return urlencode_rfc3986(base64_encode($signature)); 
	}
	
	/**
	 * Oauth Header 생성 기능
	 *
	 * @params 
	 *   - $oauth_params	HashMap		Oauth Parameter
	 * @return	String		Header String 
	 * @see
	 */
	function makeHeader($oauth_params) { 
		ksort($oauth_params);
		
		$header = '';
		$first = true;
		foreach ($oauth_params as $k => $v) {
		    if ( $first == false ) {
		        $header = $header . ",";
		    }
		    $header = $header . $k . '="' . $v . '"';
		    $first = false;
		}
		
		$header = 'OAuth ' . $header;
		
		return $header;
	}
	
	/**
	 * Oauth REST API 호출 기능
	 *
	 * @params 
	 *   - String	$url			REST URL
	 *   - String	$params			Parameter Hashmap
	 *   - String	$http_method	HTTP Method
	 * @return		HashMap		API 호출 결과
	 * @see
	 */
	function callOauthApi($url, $http_method, $header, $other_params, $format) 
	{ 	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/x-www-form-urlencoded',
		    'Authorization: ' . $header));
		
		# only https(SSL) client options
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_URL, $url);
		if ( $http_method == "POST" ) {
			$qstr = $this->makeQueryString($other_params);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $qstr);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		} else {
			curl_setopt($ch, CURLOPT_HTTPGET, 1);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    
		$http_result 	  = curl_exec($ch);
		$http_result_code = curl_getinfo($ch ,CURLINFO_HTTP_CODE);
		        
		if ($http_result === false) {
			$m_errorMsg = curl_error($ch);
		}
		    
		curl_close($ch);
		# if ($http_result_code != 200 )
		# {
		# 	echo "result>>".$http_result."<br/>";
		# }
		
		if ($http_result_code != 200 && ( $http_result == null ||  $http_result == '')) {
			return $this->makeErrResult($http_result_code);
		}
				
		return $this->makeResult($http_result, $format); 
	}
	
	/**
	 * OPC에 Request Token을 획득하는 기능
	 *
	 * @params 
	 *   - $url     		String		Request Token URL
	 *   - $callback		String		Callback URL
	 *   - $other_params	HashMap		Other Parameter
	 *   - $authType		String		인증 유형
	 * @return	String		Request Token 정보 
	 * @see
	 */
	 
	function getRequestToken($url, $callback, $other_params, $authType) { 
		$http_method = "GET";

		// Make oauth parameters		
		$add_params = array();
		$add_params["oauth_callback"] = $callback;
		#$add_params["oauth_callback"] = urlencode_rfc3986($callback);

		$oauth_params = $this->makeOauthParams($add_params);

		// Make Base String
		$base_str = $this->makeBaseString($url, $http_method, $oauth_params, $other_params);

		// Make Secret Key
		$key = urlencode_rfc3986($this->m_oauthSecret) . "&";
		
		// Make Signature
		$oauth_signature = $this->makeOauthSignature($base_str, $key);

		$oauth_params["realm"          ] = urlencode_rfc3986($authType);
		$oauth_params["oauth_signature"] = $oauth_signature;

		// Make Header
		$header = $this->makeHeader($oauth_params);

		$qstr = $this->makeQueryString($other_params);
		if ( $qstr ) {
			$url  = $url . "?" . $qstr;
		}

		return $this->callOauthApi($url, $http_method, $header, $other_params, DEF_WEB_FMT);
	}

	/**
	 * OPC에서 Access Token을 획득하는 기능
	 *
	 * @params 
	 *   - $url        			String		Request Token
	 *   - $oauth_token			String		Request Token
	 *   - $oauth_token_secret	String		Request Token Secret
	 *   - $oauth_verifier		String		Oauth Token verifier
	 *   - $authType			String		인증 유형
	 *   - $xauth_username		String		Xauth login id
	 *   - $xauth_password		String		Xauth password
	 * @return	String			Request Token 정보 
	 * @see
	 */
	 
	function getAccessToken($url, $oauth_token, $oauth_token_secret, $oauth_verifier, $authType, $xauth_username = NULL, $xauth_password = NULL) { 
		$http_method = "POST";

		// Make oauth parameters		
		$add_params = array();
		$add_params["oauth_token"   ] = urlencode_rfc3986($oauth_token   );
		$add_params["oauth_verifier"] = urlencode_rfc3986($oauth_verifier);

		// for XAuth
		if ($xauth_username != NULL && $xauth_password) {
			$add_params["x_auth_mode"    ] = urlencode_rfc3986("client_auth");
			$add_params["x_auth_username"] = urlencode_rfc3986($xauth_username);
			$add_params["x_auth_password"] = urlencode_rfc3986($xauth_password);
		}
		
		$oauth_params = $this->makeOauthParams($add_params);
		$other_params = array();
		
		// Make Base String
		$base_str = $this->makeBaseString($url, $http_method, $oauth_params, $other_params);
		
		// Make Secret Key
		$key = urlencode_rfc3986($this->m_oauthSecret) . "&" . urlencode_rfc3986($oauth_token_secret);
		
		// Make Signature
		$oauth_signature = $this->makeOauthSignature($base_str, $key);

		$oauth_params["realm"          ] = urlencode_rfc3986($authType);
		$oauth_params["oauth_signature"] = $oauth_signature;
		
		// Make Header
		$header = $this->makeHeader($oauth_params);
		
		return $this->callOauthApi($url, $http_method, $header, $other_params, DEF_WEB_FMT);
	}

	function call($api, $params, $authType, $oauth_token, $oauth_token_secret, $bSSL)
	{
		// API 인증 파라미터 생성
		$authToken = $this->makeAuthToken();
		
		// HTTP Method가 GET/DELETE의 경우 Query String 생성
		$kk = explode(',', $api->getHttpMethod());
		$http_method = $kk[0];

		// Make Rest URL
		$url = $this->makeRestUrl($api->getRestUri(),  $params, DEF_JSON_FMT, $bSSL);

		// Make oauth parameters		
		$add_params = array();
		$add_params["oauth_token"   ] = urlencode_rfc3986($oauth_token   );
		
		$oauth_params = $this->makeOauthParams($add_params);
		
		$tparams = array_merge(array("api_token" => $authToken), $params);
		// Make Base String
		$base_str = $this->makeBaseString($url, $http_method, $oauth_params, $tparams);

		// Make Secret Key
		$key = urlencode_rfc3986($this->m_oauthSecret) . "&" .urlencode_rfc3986($oauth_token_secret);
		
		// Make Signature
		$oauth_signature = $this->makeOauthSignature($base_str, $key);

		$oauth_params["realm"          ] = urlencode_rfc3986($authType);
		$oauth_params["oauth_signature"] = $oauth_signature;
		
		// Make Header
		$header = $this->makeHeader($oauth_params);
		$url = $url . "?api_token=" . $authToken;
		if ($http_method == "GET" || $http_method == "DELETE") {
			$qstr = $this->makeQueryString($params);
			if ( $qstr ) {
				$url  = $url . "&" . $qstr;
			}
		}
		
		return $this->callOauthApi($url, $http_method, $header, $params, DEF_JSON_FMT);

	}

};

?>
