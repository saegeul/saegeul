<?php
include_once("KTOpenApiLoader.php");
include_once("KTOpenApiOauthHandler.php");

class KTOpenApiHandler extends KTOpenApiBase {
	var	$m_specLoader	        ;
	var $m_restHandler	        ;
	var $m_oauthHandler	        ;

	var $m_oee					;
	var $m_oauth				;

	// context variables
	var $m_bSSL					;
	var $m_api_id				;
	var $m_params				;
	var $m_xauth_params			;
	var $m_format				;	
	var $m_oauth_token			;
	var $m_oauth_token_secret	;
	var $m_oauth_token_type	    ;
	var $m_authType				;	// Oauth ���� ����
	var $m_bRequiredOauth		;

	// authorization key variables
	var $m_authKey				;
	var $m_authSecret			;
	var $m_oauthKey				;
	var $m_oauthSecret			;

	var $m_appType				;
	var $m_domain				;

	function KTOpenApiHandler($authKey, $authSecret)
	{
		$this->m_authKey 	= $authKey   ;
		$this->m_authSecret	= $authSecret;
		$this->m_oauthKey 	= $authKey   ;
		$this->m_oauthSecret	= $authSecret;
		if ($authKey == null) {
			$this->restoreContext();
		}
	}

	function setApiKey($authKey, $authSecret)
	{
		$this->m_authKey 	= $authKey   ;
		$this->m_authSecret	= $authSecret;

		if ( $this->m_restHandler != null ) {
			$this->m_restHandler->setKey($this->m_authKey,$this->m_authSecret);
		}
		if ( $this->m_oauthHandler != null ) {
			$this->m_oauthHandler->setKey($this->m_authKey,$this->m_authSecret);
		}
	}

	function initialize($sdkVersion, $xmlPath, $appType = DEF_WEB_APP)
	{
		$this->m_appType = $appType;

		// restore oauth_token
		$this->restoreToken();	

		// Create Loader
		$this->m_specLoader = new KTOpenApiLoader();
		if ($this->m_specLoader == null) {
			return false;
		}

		// SDK Spec loading
		$ret = $this->m_specLoader->load($sdkVersion, $xmlPath);
		if (!$ret) {
			return false;
		}

		$this->m_oee   = $this->m_specLoader->getOeeInfo();
		$this->m_oauth = $this->m_specLoader->getOauthInfo();

		// create Rest Handler
		$this->m_restHandler = new KTOpenApiRestHandler($this->m_authKey, 
														$this->m_authSecret);
		if ( $this->m_restHandler == null ) {
			return false;
		}
		$this->m_restHandler->setOeeInfo($this->m_oee);

		// create Oauth Handler 
		$this->m_oauthHandler = new KTOpenApiOauthHandler($this->m_oauthKey, 
														  $this->m_oauthSecret, 
														  $this->m_appType);
		if ( $this->m_oauthHandler == null ) {
			return false;
		}
		$this->m_oauthHandler->setKey($this->m_authKey,$this->m_authSecret);
		$this->m_oauthHandler->setOeeInfo($this->m_oee);
		$this->m_oauthHandler->setOauthInfo($this->m_oauth);

		return true;
	}

	function makeApiToken()
	{
		if( $this->m_restHandler == null) return null;
		return $this->m_restHandler->makeAuthToken();
	}

	/**
	 * �Է� �Ķ���Ϳ� Oauth Verifier�� �ִ��� üũ
	 *
	 * @return	boolean	
	 *   - false		Oauth Verifier�� ����
	 *   - true			Oauth Verifier�� ����
	 * @see
	 */
	function hasOauthVerifier()	 { 		
		global $_GET;	
		return array_key_exists("oauth_verifier", $_GET);
	}

	function hasAccessToken() {
		if($this->m_oauth_token_type == DEF_OAUTH_ACCESS_TOKEN) {
			return true;
		} 
		return false;
	}

	function getAccessToken() {
		$result = array();

		$result["oauth_token"] = $this->m_oauth_token;
		$result["oauth_token_secret"] = $this->m_oauth_token_secret;

		return $result;
	}

	function setAccessToken($oauth_token,$oauth_token_secret) {
	        $this->m_oauth_token        = $oauth_token;
	        $this->m_oauth_token_secret = $oauth_token_secret;
	        $this->m_oauth_token_type   = "A";
	}
	
	function clearAccessToken() {
		if( hasAccessToken() == false ) return false;

		$this->m_oauth_token        = "";
		$this->m_oauth_token_secret = "";
        $this->m_oauth_token_type   = "";
		
		return true;
	}

	/**
	 * Oauth Token ������ ���ǿ��� �������� ���
	 *
	 * @see
	 */
	function restoreToken()	 { 
		global $_SESSION;

		$context  = $_SESSION[DEF_KTOAUTH_CONTEXT];
		if ($context != null) {
	        $this->m_oauth_token        = $context["oauth_token"       ];
	        $this->m_oauth_token_secret = $context["oauth_token_secret"];
	        $this->m_oauth_token_type   = $context["oauth_token_type"  ];
		}
	}

	/**
	 * Oauth Token ������ ���ǿ��� �����ϴ� ���
	 *
	 * @see
	 */
	function saveToken($token_type, $token, $token_secret) {
		global $_SESSION;

		$this->m_oauth_token = $token;
		$this->m_oauth_token_type = $token_type;
		$this->m_oauth_token_secret = $token_secret;

		$context  = $_SESSION[DEF_KTOAUTH_CONTEXT];
		if ($context != null) {
			$context["oauth_token"       ] = $this->m_oauth_token         ;
			$context["oauth_token_secret"] = $this->m_oauth_token_secret  ;
			$context["oauth_token_type"  ] = $this->m_oauth_token_type    ;
		} else {
			$context = array();
			$context["oauth_token"       ] = $this->m_oauth_token         ;
			$context["oauth_token_secret"] = $this->m_oauth_token_secret  ;
			$context["oauth_token_type"  ] = $this->m_oauth_token_type    ;
		}

		$_SESSION[DEF_KTOAUTH_CONTEXT] = $context;
	}

	/**
	 * Context ������ ���ǿ� �����ϴ� ���
	 *
	 * @see
	 */
	function saveContext() {
		global $_SESSION;

		// ������ Context�� �����Ѵ�.
		$context = array();
		$context["api_id"            ] = $this->m_api_id              ;
		$context["params"            ] = $this->m_params	          ;
		$context["xauth_params"      ] = $this->m_xauth_params	      ;
		$context["format"            ] = $this->m_format	          ;
		$context["auth_type"         ] = $this->m_authType	          ;
		$context["oauth_token"       ] = $this->m_oauth_token         ;
		$context["oauth_token_secret"] = $this->m_oauth_token_secret  ;
		$context["oauth_token_type"  ] = $this->m_oauth_token_type    ;
		$context["auth_key"          ] = $this->m_authKey         	  ;
		$context["auth_secret"       ] = $this->m_authSecret          ;
		$context["oauth_key"         ] = $this->m_oauthKey         	  ;
		$context["oauth_secret"      ] = $this->m_oauthSecret          ;
		$context["ssl_flag"       	 ] = $this->m_bSSL                ;

		$_SESSION[DEF_KTOAUTH_CONTEXT] = $context;
	}

	
	/**
	 * Context ������ ���ǿ��� �������� ���
	 *
	 * @see
	 */
	function restoreContext()	 { 
		global $_SESSION;

		$context  = $_SESSION[DEF_KTOAUTH_CONTEXT];
		if ($context != null) {
			$this->m_api_id             = $context["api_id"            ];
	    $this->m_params             = $context["params"            ];
	    $this->m_xauth_params       = $context["xauth_params"      ];
	    $this->m_format             = $context["format"            ];
	    $this->m_authType           = $context["auth_type"         ];
	    $this->m_oauth_token        = $context["oauth_token"       ];
	    $this->m_oauth_token_secret = $context["oauth_token_secret"];
	    $this->m_oauth_token_type   = $context["oauth_token_type"  ];
			$this->m_authKey            = $context["auth_key"          ]; 
			$this->m_authSecret         = $context["auth_secret"       ]; 
			$this->m_oauthKey           = $context["oauth_key"          ]; 
			$this->m_oauthSecret        = $context["oauth_secret"       ]; 
			$this->m_bSSL               = $context["ssl_flag"          ]; 

		}
	}

	/**
	 * Oauth API ȣ�� URL ��
	 *
	 * @params 
	 *   - String	$url		url
	 *   - String	$params		Parameter Hashmap
	 * @return		String		full url String
	 * @see
	 */
	function makeOauthUrl($url, $bSSL, $params = null) 
	{ 				
		$protocol = "http";
		$host       = $this->m_oee->getHost();
		$port       = $this->m_oee->getPort();
		$oauth_root = $this->m_oauth->getOauthRoot();
		if($bSSL) {
			$port = $this->m_oee->getSslPort();
			$protocol = "https";
		}

		if ($port != "80" && $port != "443") {
			$port = ":" . $port;
		} else {
			$port = "";
		}

		$fullUrl = $protocol . "://" . $host . $port . $oauth_root . $url;
		if ( $params != null ) {
			$qstr = $this->makeQueryString($params);

			if ($qstr != "") {
				$fullUrl = $fullUrl . "?" . $qstr;
			}
		}

		return $fullUrl;
	}

	function _call($api_id, $params, $xauth_params, $bSSL, $format=DEF_JSON_FMT)
	{
		$api  = null;
		$step = DEF_STEP_ACCESS_API;
		$xauth = false;
		// get api information
		if ( $api_id != null ) {
			$this->m_api_id   		= $api_id  		;
			$this->m_params   		= $params  		;
			$this->m_format   		= $format  		;
			$this->m_bSSL	  		= $bSSL	 		;
			$this->m_xauth_params   = $xauth_params ;

			$api = $this->m_specLoader->getApiInfo($api_id);
			if ( $api == null ) { // API ������ ������
				return $this->makeErrResult(KT_ERR_NOTFOUND_API);
			}

			if ( $this->m_xauth_params != NULL && sizeof($this->m_xauth_params) > 0 ) {
				$xauth = true;
			}	

			$this->m_bRequiredOauth = false;

			if ($api->isIdPay()) {
				$this->m_bRequiredOauth = true;
				$this->m_authType = DEF_ID_PAY_AUTH;
			} else if ($api->isRequiredOauth()) {
				$this->m_bRequiredOauth = true;
				$this->m_authType = DEF_USER_AUTH;
			}

			// Oauth ���� �ʿ� 
			if ( $this->m_bRequiredOauth == true ) {
				if ($this->hasAccessToken()) {
					$step = DEF_OAUTH_STEP_ACCESS_API;
				} else if ( $this->hasOauthVerifier() ) {
					// Oauth Verifier�� �ԷµǾ�����
					$step = DEF_OAUTH_STEP_ACCESS_TOKEN;
					$this->restoreContext();
					$this->m_oauth_verifier = $_GET["oauth_verifier"];
				} else {
					$step = DEF_OAUTH_STEP_REQUEST_TOKEN;
				}
			}
		} else if ( $this->hasOauthVerifier() ) { // Oauth Verifier�� �ԷµǾ�����
			$step = DEF_OAUTH_STEP_ACCESS_TOKEN;
			$this->restoreContext();
			$this->m_oauth_verifier = $_GET["oauth_verifier"];
		} else {
			return $this->makeErrResult(KT_ERR_NOTFOUND_API);
		}

		// Oauth ó��
		if ($step == DEF_OAUTH_STEP_REQUEST_TOKEN ) {
			// make callback url
			$callback = "http://" . $_SERVER["SERVER_NAME"];
			if ($_SERVER["SERVER_PORT"] != 80) {
				$callback = $callback . ":" . $_SERVER["SERVER_PORT"];
			}
			$callback = $callback . $_SERVER["PHP_SELF"];
			$qstr = $_SERVER["QUERY_STRING"];
			if ($qstr != null) {
				$callback = $callback . $this->format . "?" . $qstr;
			}

			// OPC�κ��� Request Token�� ȹ���Ѵ�.
			// make RequestToken URL
			$url = $this->m_oauth->getRequestTokenUrl();
			$url = $this->makeOauthUrl($url,$this->m_bSSL);

			$other_params = array();
			if ($this->m_authType == DEF_ID_PAY_AUTH) {
				// add idpay ��� �Ķ����
				$other_params["cpipcode"] = $params["cpipcode"];
				$other_params["svccode" ] = $params["svccode" ];
				$other_params["comment" ] = $params["comment" ];
				$other_params["price"   ] = $params["price"   ];
			}
			$other_params["auth_comment"] = $params["auth_comment"];
			$result = $this->m_oauthHandler->getRequestToken($url,
															 $callback, 
															 $other_params,
															 $this->m_authType);
			if ($result["oauth_token"] == null ) {
				$this->setErrorCode(KT_ERR_REQUEST_TOKEN);
				return false;
			}
			
			$this->m_oauth_token 		= $result["oauth_token"       ];
			$this->m_oauth_token_secret = $result["oauth_token_secret"];
			$this->m_oauth_token_type   = DEF_OAUTH_REQUEST_TOKEN;

			if ($xauth == false) {	
			// echo "SSSSSSSSSSSSSSSSSSSSSS\n";
			// print_r($this);
				$this->saveContext();

				// Authorize URL�� Redirect 
				$authorize_url = $this->m_oauth->getAuthorizeUrl();

				$url = $this->makeOauthUrl($authorize_url,true /*$this->m_bSSL*/, array("oauth_token" => $this->m_oauth_token));

				header("Location: " . $url);
				exit;
			}
			$step = DEF_OAUTH_STEP_ACCESS_TOKEN;
		} 
		
		if ($step == DEF_OAUTH_STEP_ACCESS_TOKEN) {
			$xauth_username = NULL;
			$xauth_password = NULL;
			if ($xauth == true) {
				$xauth_username = $this->m_xauth_params["username"];
				$xauth_password = $this->m_xauth_params["password"];
			}
			// make AccessToken URL
			$url = $this->m_oauth->getAccessTokenUrl();
			$url = $this->makeOauthUrl($url,$this->m_bSSL);

			$result = $this->m_oauthHandler->getAccessToken($url,
															$this->m_oauth_token, 
															$this->m_oauth_token_secret, 
															$this->m_oauth_verifier, 
															$this->m_authType,
															$xauth_username,
															$xauth_password);

			if ($result["oauth_token"] != null && $result["oauth_token_secret"] != null)
			{
				$this->saveToken(DEF_OAUTH_ACCESS_TOKEN, 
								$result["oauth_token"], 
								$result["oauth_token_secret"]);
				$step = DEF_OAUTH_STEP_ACCESS_API;
			}
			else
			{
				$this->saveToken(null, null, null);
				$_SESSION[DEF_KTOAUTH_CONTEXT] = null;
				if( $result["result_code"] != "469" ) { // fail authentication 2012.06.13
					$result = array();
					$result["result_code"] = "490";
					$result["result_msg"] = "retrieve access token fail!";
				}
				return $result;
			}

			$api = $this->m_specLoader->getApiInfo($this->m_api_id);
		}

		if ($step == DEF_OAUTH_STEP_ACCESS_API) { 
			$result = $this->m_oauthHandler->call($api,
											   $this->m_params, 
											   $this->m_authType, 
											   $this->m_oauth_token, 
											   $this->m_oauth_token_secret,
											   $this->m_bSSL);
			if ($result["result_code"] == "459" ||
				$result["result_code"] == "461" ||
				$result["result_code"] == "462") {
				// clear oauth token and retry
				$this->saveToken(null, null, null);
			}
		} else {
			$result = $this->m_restHandler->call($api, $this->m_params, $this->m_format, $this->m_bSSL);
		}

		return $result;
	}

	function call($api_id, $params, $xauth_params, $bSSL, $format=DEF_JSON_FMT)
	{
		return $this->_call($api_id, $params, $xauth_params, $bSSL, $format);
	}
};
?>
