<?php 
    class OAuthUtil {

        public static function parse_header($param = array() ){
            $header = array()  ; 

            foreach($param as $key => $value){ 
                $header[]=OAuthUtil::urlencode($key).'="'.OAuthUtil::urlencode($value).'"';
            }

            return 'OAuth '.implode(',',$header) ; 
        }

        public static function parse_param($params){
			$params = explode('&', trim($params));
	
		    $ret = array();
	
			foreach ($params as $param) {
				list($key, $value) = explode('=', $param, 2); 
                $ret[$key] = $value ; 
			} 
			return $ret;
        }

        public static function call($url,$method,$param,$request_body=array()){ 
            $header = OAuthUtil::parse_header($param);

		    $ch = curl_init($url);
            
            $method=='POST' ? $options[CURLOPT_POST]=TRUE : '' ; 
            $method=='POST' ? $options[CURLOPT_POSTFIELDS]= http_build_query($request_body): '' ;

			$options[CURLOPT_HTTPHEADER] = array(
                'Authorization: ' . $header 
            ); 

            $options[CURLOPT_SSL_VERIFYPEER] = FALSE ;
            $options[CURLOPT_SSL_VERIFYHOST] = FALSE ;
            $options[CURLOPT_RETURNTRANSFER] = TRUE ;

		    if ( ! curl_setopt_array($ch, $options)) {
			    throw new Exception('Failed to set CURL options, check CURL documentation: http://php.net/curl_setopt_array');
		    }

		    $response = curl_exec($ch);

		    // Get the response information
		    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		    if ($code AND ($code < 200 OR $code > 299)) {
			    $error = $response;
		    }
		    elseif ($response === FALSE) {
			    $error = curl_error($ch);
		    }
		    curl_close($ch);

		    if (isset($error)) {
			    throw new Exception(sprintf('Error fetching remote %s [ status %s ] %s', $url, $code, $error));
		    }

		    return $response;
        }

        public static function base_string($method,$url,$params){
            ksort($params) ; 
            $arr = array() ; 

            foreach($params as $key => $value){ 
                $arr[] = OAuthUtil::urlencode($key).'='.OAuthUtil::urlencode($value) ;
            }


            $parameter = implode('&',$arr) ; 


		    // method & url & sorted-parameters
		    return implode('&', array($method,OAuthUtil::urlencode($url),OAuthUtil::urlencode($parameter)));

        }

        public static function make_signature($base_string,$key){ 
		    return base64_encode(hash_hmac('sha1', $base_string, $key, TRUE));
        }

        public static function urlencode($input){
            if (is_array($input)) {
			    return array_map(array('OAuthUtil', 'urlencode'), $input);
		    }

            return str_replace('+',' ',str_replace('%7E','~',rawurlencode($input))); 
        }

        public static function urldecode($input){
            if (is_array($input)) {
			    return array_map(array('OAuth', 'urldecode'), $input);
		    }

		    return rawurldecode($input);
        } 
    }

    /* end of OAuthUtil.php */
