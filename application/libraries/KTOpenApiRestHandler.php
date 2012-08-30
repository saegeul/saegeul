<?php
include_once("KTOpenApiBase.php");

class KTOpenApiRestHandler extends KTOpenApiBase {
	var $m_authKey		;	// ���� Key ���� 
	var $m_authSecret	;	// ���� Secret ����
	var $m_oee			;

	/**
	 * Constructor
	 *
	 * @see
	 */
	function KTOpenApiRestHandler($authKey = "", $authSecret = "")
	{
		$this->m_authKey    = $authKey;			
		$this->m_authSecret = $authSecret;			
	}

	function setKey($authKey = "", $authSecret = "")
	{
		$this->m_authKey    = $authKey;			
		$this->m_authSecret = $authSecret;			
	}
	
	/**
	 * Open Platform ����ȯ�� ���� ����
	 *
	 * @see
	 */
	function setOeeInfo($oee)
	{
		$this->m_oee = $oee;
	}
		
	/**
	 * Timestamp ����
	 *
	 * @return	String	DateTime 20100912011234
	 * @see
	 */
	#function makeTimestamp() { return date('YmdHis'); }
	function makeTimestamp() { return mktime(); }

	/**
	 * Signature ����
	 *
	 * @params 
	 *   - String	$baseStr	Sign�� �⺻ ��Ʈ��
	 * @return	String	Signed String
	 * @see
	 */
	function makeSignature($baseStr)
	{ 		
		return base64_encode(hash_hmac("sha1", $baseStr, $this->m_authSecret, true)); 
	}

	/**
	 * API ���� Token ����
	 *
	 * @params 
	 *   - String	$apiId		API ID
	 * @return		String 		API ���� Token
	 * @see
	 */
	function makeAuthToken()
	{ 	
		$authz_method = $this->m_oee->getAuthzMethod();
		if ($authz_method == "sign") {
			// Timestamp ����			
			$ts			= $this->makeTimestamp();
			
			// Base String ����
			$baseStr	= $this->m_authKey . ";" . $ts;
			
			// API Signature ����
			$signature	= $this->makeSignature($baseStr);
			
			// Make Token 
			$api_token = $this->m_authKey . ";" . $ts . ";" . $signature;


			return urlencode(base64_encode($api_token));
		}
		return $this->m_authKey;
	}
	/*
	function makeAuthToken($apiId)
	{ 	
		// Timestamp ����			
		$ts			= $this->makeTimestamp();
		
		// Base String ����
		$baseStr	= $this->m_authKey .  ";"  . $apiId .  ";" . $ts;
		
		// API Signature ����
		$signature	= $this->makeSignature($baseStr);
		
		// Make Token 
		$api_token = $this->m_authKey . ";" . $apiId . ";" . $ts . ";" . $signature;


		return urlencode(base64_encode($api_token));
	}
	*/
	

	/**
	 * API ȣ�� REST URL ����
	 *
	 * @params 
	 *   - String	$uri		API REST URI
	 *   - String	$params		Parameter Hashmap
	 * @return	String	API Query String
	 * @see
	 */
	function makeRestUrl($uri, &$params, $format, $bSSL) 
	{ 				
		$url = "http" ;
		$host     = $this->m_oee->getHost();
		$port     = $this->m_oee->getPort();
		if ( $bSSL ) {
			$port = $this->m_oee->getSslPort();
			$url = "https";
		}
		$api_root = $this->m_oee->getApiRoot();

		
		if ($port != "80" && $port != "443") {
			$port = ":" . $port;
		} else {
			$port = "";
		}

		// uri���� ��ġ�� �κ��� ã�� �Ķ���͸� binding �Ѵ�.
		// binding�� �Ķ���ʹ� �����Ѵ�.

		// bwh202 ���� �ʿ�
		$bindUri = $uri;

		$url = $url . "://" . $host . $port . $api_root . $bindUri . $format ;

		return $url;
	}

	function obj2Array($val) {
		$ret = array();
		foreach($val as $k => $v) {
			if (is_array($v)) {
				$sret = array();
				foreach($v as $v1) {
					if (is_object($v1)) {
						array_push($sret, $this->obj2Array($v1));
					} else {
						array_push($sret, $v1);
					}
				}
				$ret[$k] = $sret;
			} else if (is_object($v)) {
				$ret[$k] = $this->obj2Array($v);
			} else {
				$ret[$k] = $v;
			}
		}
		return $ret;
	}
	
	/**
	 * REST API ȣ�� ����� Map���� �����ϴ� ���
	 *
	 * @params 
	 *   - String	$result  	API ȣ���� Body(name=value&name=value)
	 * @return	HashMap			API ȣ���� HashMap
	 * @see
	 */
	function makeResult($result, $format = DEF_WEB_FMT) 
	{ 				
		$ret = array();

		if ($format == DEF_JSON_FMT ) {
			$ret = $this->obj2Array(json_decode($result));
		} else {
			foreach(explode('&', $result) as $val) {
				$kk = explode('=', $val);
				$ret[$kk[0]] = urldecode($kk[1]);
			}
		} 


		return $ret; 
	}

	/**
	 * REST API ȣ�� ���
	 *
	 * @params 
	 *   - String	$url			REST URL
	 *   - String	$params			Parameter Hashmap
	 *   - String	$http_method	HTTP Method
	 * @return	HashMap		API ȣ�� ���
	 * @see
	 */
	function callRestApi($url, $params, $http_method, $format, $bSSL) 
	{ 	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
		# only https(SSL) client options
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_URL, $url);
		if ( $http_method == "POST" ) {
			$qstr = $this->makeQueryString($params);
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
			$this->m_errorMsg = curl_error($ch);
		}
		    
		curl_close($ch);

		if ($http_result_code != 200 && ( $http_result == null ||  $http_result == '')) {
			return $this->makeErrResult($http_result_code);
		}
		return $this->makeResult($http_result, $format); 
	}
	
	/**
	 * API ȣ�� ���
	 *
	 * @params 
	 *   - KTOpenApi	$api		API ����
	 *   - String		$params		Parameter Hashmap
	 *   - String		$format		Response Format
	 * @return			HashMap		API ȣ�� ���
	 * @see
	 */
	function call($api, $params, $format, $bSSL)
	{ 	
		// API ���� �Ķ���� ����
		#$authToken = $this->makeAuthToken($api->getId());
		$authToken = $this->makeAuthToken($api->getRestUri());

		
		$kk = explode(',', $api->getHttpMethod());
		$http_method = $kk[0];

		// Make Rest URL
		$url = $this->makeRestUrl($api->getRestUri(), $params, $format, $bSSL);
		$url  = $url . "?api_token=" . $authToken;
		if ($http_method == "GET" || $http_method == "DELETE") {
			$qstr = $this->makeQueryString($params);
			if ( $qstr ) {
				$url  = $url . "&" . $qstr;
			}
		}

		return $this->callRestApi($url, $params, $http_method, $format, $bSSL);
	}
};

?>
