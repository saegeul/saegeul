<?php
include_once("KTOpenApiBase.php");

class KTOpenApiParam {
	var $m_name	          ;
	var $m_type           ;
	var $m_desc           ;

	function KTOpenApiParam($node)
	{
		$this->m_name = $node->getAttribute("name");
		$this->m_type = $node->getAttribute("type");
		$this->m_desc = $node->getAttribute("desc");
	}

	function getName() { return $this->m_name; }
	function getType() { return $this->m_type; }
	function getDesc() { return $this->m_desc; }
};

class KTOpenApiType {
	var $m_id			;
	var $m_base  		;
	var $m_params		;
	var	$m_base_type	;

	function KTOpenApiType($node)
	{
		$this->m_id     = $node->getAttribute("id");
		$this->m_base   = $node->getAttribute("base");

		$this->m_params = array();
		$params = $node->getChildNode("param");

		if (is_array($params) ) {
			foreach($params as $p) {
				array_push($this->m_params, new KTOpenApiParam($p));	
			}
		} else if ($params != null) {
			array_push($this->m_params, new KTOpenApiParam($params));	
		}
	}

	function getId()         { return $this->m_id;             }
	function getBase()       { return $this->m_base;           }
	function getBaseType()   { return $this->m_base_type;      }
	function getParams($bIncludeBase = false)     
	{ 
		if ($bIncludeBase) {	
			$ret = array();
			if ($this->m_base_type) {
				$ret = $this->m_base_type->getParams();
			}
			return array_merge($ret, $this->m_params);
		} 
		return $this->m_params;
	}
	function setBaseType($t) { $this->m_base_type = $t;        }
};

class KTOpenApiCallback {
	var $m_id			  ;
	var $m_name			  ;
	var $m_cb_msg_format  ;
	var $m_params         ;

	function KTOpenApiCallback($node)
	{
		$this->m_id             = $node->getAttribute("id"            );
		$this->m_name	        = $node->getAttribute("name"          );
		$this->m_cb_msg_format  = $node->getChildContent("cb_msg_format" );

		$this->m_params = array();
		$cb_params = $node->getChildNode("cb_params");
		$params = $cb_params->getChildNode("param");
		
		if (is_array($params) ) {
			foreach($params as $param) {
				array_push($this->m_params, new KTOpenApiParam($param));	
			}
		} else if($params != null) {
			array_push($this->m_params, new KTOpenApiParam($params));	
		}
	}

	function getId()            { return $this->m_id;             }
	function getName()		    { return $this->m_name;           }
	function getCbMsgFormat()   { return $this->m_cb_msg_format;  }
	function getParams() 	    { return $this->m_params;         }
};

class KTOpenApi {
	var $m_group_id		  ;
	var $m_id             ;
	var $m_name           ;
	var $m_type           ;
	var $m_is_idpay       ;
	var $m_is_pay         ;
	var $m_oauth_required ;

	var $m_rest_uri       ;
	var $m_http_method    ;

	var $m_input_type_ref ;
	var $m_output_type_ref;

	var $m_input_type     ;
	var $m_output_type    ;

	function KTOpenApi($node, $group_id)
	{
		$this->m_group_id       = $group_id;
		$this->m_id             = $node->getAttribute("id"            );
		$this->m_name	        = $node->getAttribute("name"          );
		$this->m_type           = $node->getAttribute("type"          );
		$this->m_is_pay         = $node->getAttribute("is_pay"        );
		$this->m_oauth_required = $node->getAttribute("oauth_required");

		$this->m_rest_uri       = $node->getChildContent("rest_uri"   );
		$this->m_http_method    = $node->getChildAttribute("rest_uri"   , "method");
		$this->m_input_type_ref = $node->getChildAttribute("input" , "type_ref"   );
		$this->m_output_type_ref= $node->getChildAttribute("output", "type_ref"   );

		// echo "m_is_idpay : " . $this->m_is_pay;

		$this->m_is_idpay = false;
		if ($this->m_is_pay == null || $this->m_is_pay == "false") {
			$this->m_is_pay = false;
		} else if ($this->m_is_pay == "idPay" ) {
			$this->m_is_idpay = true;
			$this->m_is_pay   = false;
		}

		if ($this->m_oauth_required == null || $this->m_oauth_required == "false") {
			$this->m_oauth_required = false;
		} else {
			$this->m_oauth_required = true;
		}
		if ($this->m_id == null ) {
			$this->m_id = $this->m_name;
		}
	}

	function getId()            { return $this->m_id;             }
	function getName()		    { return $this->m_name;           }
	function getType()          { return $this->m_type;           }
	function isIdPay() 	        { return $this->m_is_idpay; 	  }
	function isPay() 	        { return $this->m_is_pay;         }
	function isRequiredOauth()  { return $this->m_oauth_required; }
	function getRestUri()       { return $this->m_rest_uri;       }
	function getHttpMethod()    { return $this->m_http_method;    }
	function getInputTypeRef()  { return $this->m_input_type_ref; }
	function getOutputTypeRef() { return $this->m_output_type_ref;}
	function getInputType()     { return $this->m_input_type;     }
	function getOutputType()    { return $this->m_output_type;    }
	function setInputType($t)   { $this->m_input_type = $t;       }
	function setOutputType($t)  { $this->m_output_type = $t;      }

};

class KTOpenApiGroup {
	var $m_id           ;
	var $m_name        	;
	var $m_context_name ;
	var $m_apis         ;

	function KTOpenApiGroup($node)
	{
		$this->m_id           = $node->getAttribute("id"          );
		$this->m_name	      = $node->getAttribute("name"        );
		$this->m_context_name = $node->getAttribute("context_name");

		$this->m_apis         = array();

		$apis = $node->getChildNode("api");
		if (is_array($apis) ) {
			foreach($apis as $api) {
				$api_id = $api->getAttribute("id");
				if ( $api_id == null ) {
					$api_id = $api->getAttribute("name");
				}
				$this->m_apis[$api_id] = new KTOpenApi($api, $this->m_id);
			}
		} else {
			$api_id = $apis->getAttribute("id");
			if ( $api_id == null ) {
				$api_id = $apis->getAttribute("name");
			}
			$this->m_apis[$api_id] = new KTOpenApi($apis, $this->m_id);
		}
	}

	function getId()            { return $this->m_id;             }
	function getName()		    { return $this->m_name;           }
	function getContextName()   { return $this->m_context_name;   }
	function getApis()          { return $this->m_apis;           }
	function getApiInfo($id)    { return $this->m_apis[$id];      }
	function getApiList(&$ret)		
	{
		foreach($this->m_apis as $k => $api) {
			$ret[$k] = $api->getName();
		}
	}
};

class KTOpenApiOauth {
	var $m_version			;
	var $m_signature_method	;
	var $m_oauth_root       ;
	var $m_request_token_url;
	var $m_authorize_url    ;
	var $m_access_token_url	;

	function KTOpenApiOauth($node)
	{
		$this->m_version          = $node->getAttribute("version" );

		$this->m_signature_method = $node->getChildContent("signature_method" );
		$this->m_oauth_root       = $node->getChildContent("oauth_root"       );
		$this->m_request_token_url= $node->getChildContent("request_token_url");
		$this->m_authorize_url    = $node->getChildContent("authorize_url"    );
		$this->m_access_token_url = $node->getChildContent("access_token_url" );
	}
	function getVersion()         { return $this->m_version;           }
	function getSignatureMethod() { return $this->m_signature_method;  }
	function getOauthRoot()		  { return $this->m_oauth_root;        }
	function getRequestTokenUrl() { return $this->m_request_token_url; }
	function getAuthorizeUrl() 	  { return $this->m_authorize_url;     }
	function getAccessTokenUrl()  { return $this->m_access_token_url;  }
};

class KTOpenApiOee {
	var $m_host         ;
	var $m_port         ;
	var $m_ssl_port    	;
	var $m_api_root	    ;
	var $m_authz_method ;

	function KTOpenApiOee($node) 
	{
		$this->m_host       = $node->getChildContent("host"    );
		$this->m_port       = $node->getChildContent("port"    );
		$this->m_ssl_port   = $node->getChildContent("ssl_port");
		$this->m_api_root   = $node->getChildContent("api_root");
		$this->m_authz_method   = $node->getChildContent("authz_method");
	}

	function getHost()      { return $this->m_host;       }
	function getPort()      { return $this->m_port;       }
	function getSslPort()   { return $this->m_ssl_port;   }
	function getApiRoot()   { return $this->m_api_root;   }
	function getAuthzMethod()   { return $this->m_authz_method;   }
};

class Node {
	var $m_attrs	;
	var $m_childs	;
	var $m_content	;

	function Node($attrs)
	{
		$this->m_attrs   = $attrs;
		$this->m_childs  = array();
		$this->m_content = null;
	}

	function addChild($name, $node)
	{
		if (array_key_exists($name, $this->m_childs)) {
			$chNode = $this->m_childs[$name];
			if (!is_array($chNode)) {
				$this->m_childs[$name] = array($chNode);
			}
			array_push($this->m_childs[$name], $node);
		} else {
			$this->m_childs[$name] = $node;
		}
	}

	function setContent($content) { $this->m_content = $content; }

	function getAttribute($name) { 
        
        if(isset($this->m_attrs[$name])){
            return $this->m_attrs[$name]; 
        }else{
            return null ; 
        }
    }

	function getChildNode($name) {
        if(isset($this->m_childs[$name])){
            return $this->m_childs[$name]; 
        }else{ 
            return null ; 
        }
    }

	function getChildNodes() { return $this->m_childs; }

	function getContent() { return $this->m_content; }

	function getChildContent($name) 
	{ 
		$ch = $this->m_childs[$name];
		if ( $ch ) {
			return $ch->getContent();
		}		
		return null;
	}

	function getChildAttribute($name, $attr_name) 
	{ 
		$ch = $this->m_childs[$name];
		if ( $ch ) {
			return $ch->getAttribute($attr_name);
		}		
		return null;
	}
};

class KTOpenApiLoader extends KTOpenApiBase {
	var $m_bLoaded		; 	// Loaded Flag
	var $m_sdkVersion	;	// SDK Version 정??
	var $m_xmlPath		;	// SDK Spec file path

	var	$m_oeeInfo		;
	var $m_oauthInfo	;
	var $m_apiGroups	;
	var $m_callbacks	;
	var $m_types		;
	
	// for Parsing
	var $m_rNode   		;
	var $m_pNode  		;
	var $m_cNode   		;
	var $m_gStack  		;
	
	/**
	 * Constructor
	 *
	 * @see
	 */
	function KTOpenApiLoader()
	{
	}
	
	/**
	 * initialize instance variable
	 *
	 * @see
	 */
	function initVars()
	{
		KTOpenApiBase::initVars();
		
		$this->m_xmlPath 	= "";
		$this->m_sdkVersion	= "";		
		$this->m_bLoaded 	= false;
	}

	function startHandler(&$p, &$name, $attrs)
	{
		array_push($this->m_gStack, $this->m_pNode);
		$this->m_pNode = $this->m_cNode;

		$this->m_cNode = new Node($attrs);

		if ($this->m_pNode != null ) {
			$nm = str_replace("n1:", "", $name);  
			$this->m_pNode->addChild($nm, $this->m_cNode);
		} else {
			$this->m_rNode = $this->m_cNode;
		}
	}

	function tagContent($p, $content)
	{
		$this->m_cNode->setContent($content);
	}

	function endHandler(&$p, &$name)
	{
		$this->m_cNode = $this->m_pNode;
		$this->m_pNode = array_pop($this->m_gStack);
	}

	/**
	 * SDK ???? ???? ?琯?
	 *
	 * @params 
	 *   - String	$sdkVersion		SDK ???? ??트??
	 *	 - String	$xmlPath		XML ???? Path
	 * @return	Boolean
	 *   - true		Success
	 *	 - false	Failure
	 * @see
	 */	 
	function load($sdkVersion, $xmlPath)
	{
		$this->m_sdkVersion = $sdkVersion;
		
		// Make sdk specification file path
		$this->m_xmlPath = $xmlPath . "/KTApiSpec_" . $sdkVersion . ".xml";
		
		/**
		 * SDK Spec File Parsing
		 * 
		 * 1. Oauth 정?? Parsing
		 * 2. Oee 정?? Parsing
		 * 3. apis Parsing
		 * 4. callbacks Parsing
		 * 5. types Parsing
		 */

		$this->m_rNode   = null;
		$this->m_pNode   = null;
		$this->m_cNode   = null;
		$this->m_gStack  = array();
		$contents = file_get_contents($this->m_xmlPath); 
		$parser = xml_parser_create(''); 
		xml_set_object($parser, $this);
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); 
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
		xml_set_element_handler($parser, 'startHandler', 'endHandler');
		xml_set_character_data_handler($parser, 'tagContent');
		xml_parse($parser, trim($contents)); 
		xml_parser_free($parser); 

		// print_r($this->m_rNode);

		$this->m_oauthInfo = new KTOpenApiOauth($this->m_rNode->getChildNode("oauth"));
		$this->m_oeeInfo   = new KTOpenApiOee($this->m_rNode->getChildNode("oee"));


		// apis parsing
		$apis = $this->m_rNode->getChildNode("apis");

		$this->m_apiGroups = array();
		$api_groups = $apis->getChildNode("api_group");
		if (is_array($api_groups) ) {
			foreach($api_groups as $grp) {
				$group_id = $grp->getAttribute("id");
				$this->m_apiGroups[$group_id] = new KTOpenApiGroup($grp);
			}
		} else if ( $api_groups != null ) {
			$group_id = $api_groups->getAttribute("id");
			$this->m_apiGroups[$group_id] = new KTOpenApiGroup($api_groups);
		}

		// callbacks parsing
		$callbacks = $this->m_rNode->getChildNode("callbacks");
		if ( $callbacks != null ) {
			$this->m_callbacks = array();

			$cb_nodes = $callbacks->getChildNode("callback");
			if (is_array($cb_nodes) ) {
				foreach($cb_nodes as $cb) {
					$cb_id = $cb->getAttribute("id");
					$this->m_callbacks[$cb_id] = new KTOpenApiCallback($cb);
				}
			} else if ($cb_nodes != null ) {
				$cb_id = $cb_nodes->getAttribute("id");
				$this->m_callbacks[$cb_id] = new KTOpenApiCallback($cb_nodes);
			}
		}

		// types parsing
		$types = $this->m_rNode->getChildNode("types");
		$this->m_types = array();

		$typeNodes = $types->getChildNode("type");
		if (is_array($typeNodes) ) {
			foreach($typeNodes as $t) {
				$type_id = $t->getAttribute("id"); 
				$this->m_types[$type_id] = new KTOpenApiType($t);
			}
		} else if ( $typeNodes != null ) {
			$type_id = $typeNodes->getAttribute("id");
			$this->m_types[$type_id] = new KTOpenApiType($typeNodes);
		}

		$this->m_rNode   = null;
		$this->m_pNode   = null;
		$this->m_cNode   = null;
		$this->m_gStack  = null;

		$this->m_bLoaded = true;

		return true;
	}

	
	/**
	 * SDK Version 정?? ????
	 *
	 * @return	String		SDK version 정??
	 * @see
	 */
	function getVersion() { return $this->m_sdkVersion; }
	
	/**
	 * Open Platform ???? 환?? 정?? ????
	 *
	 * @return	String		Open Platform ???? 환?? 정??
	 * @see
	 */
	function getOeeInfo() { return $this->m_oeeInfo; }
	
	/**
	 * Open Platform Oauth 정?? ????
	 *
	 * @return	String		Open Platform Oauth 정??
	 * @see
	 */
	function getOauthInfo()	 { return $this->m_oauthInfo; }

	function getApiGroupList()		
	{
		$ret = array();
		foreach($this->m_apiGroups as $k => $grp) {
			$ret[$k] = $grp->getName();
		}

		return $ret;
	}

	/**
	 * API Group 정?? ????
	 *
	 * @params	group_id			API Group ID
	 * @return	KTOpenApiGroup		Open API Group 정??
	 * @see
	 */
	function getApiGroup($group_id)	 
	{ 
		return $this->m_apiGroups[$group_id];
	}
	
	/**
	 * API ????트 조회
	 *
	 * @return	Array<id, name>	API ????트 정??
	 * @see
	 */
	function getApiList()	 { 
		$ret = array();
		
		foreach($this->m_apiGroups as $k => $v) {
			$v->getApiList($ret);
		}
		
		return $ret; 
	}
	function getApiInfoList() { 
		$ret = array();
		foreach($this->m_apiGroups as $k => $v) {
			$ret = array_merge($ret , $v->getApis());
		}

		return $ret; 
	}


	/**
	 * API Group?? API ????트 조회
	 *
	 * @params	group_id			API Group ID
	 * @return	Array<id, name>	API ????트 정??
	 * @see
	 */
	function getGroupApiList($group_id)	 { 
		$grp = $this->m_apiGroups[$group_id];
		if ($grp == null) return null; 

		$ret = array();
		$grp->getApiList($ret);
		
		return $ret; 
	}
	
	/**
	 * API 정?? 조회
	 *
	 * @params	group_id			API Group ID
	 * @params	id					API ID
	 * @return	KTOpenApi			API 정??
	 * @see
	 */
	function getApiInfo($id)	 { 


		$all_api_list = $this->getApiInfoList(); 

		$api = $all_api_list[$id];

		if ($api == null ) {
			echo "Not found api info\r\n";
			return null;
		}

		if ($api->getInputType() == null ) {
			$input_type  = $this->getTypeInfo($api->getInputTypeRef());
			$api->setInputType($input_type);
		}
		
		if ($api->getOutputType() == null ) {
			$output_type = $this->getTypeInfo($api->getOutputTypeRef());
			$api->setOutputType($output_type);
		}	
		return $api;
	}
	
	/**
	 * Callback 정?? 조회
	 *
	 * @params	id		Callback ID
	 * @return	Hash	Callback 정??
	 * @see
	 */
	function getCallbackInfo($id)	 { 
		$cb =  $this->m_callbacks[$id];
		if ($cb == null) {
			echo "Not found callback\r\n";
			return nil;
		}
		return $cb;
	}

	/**
	 * Type 정?? 조회
	 *
	 * @params	id		??/???? Type ID
	 * @return	Hash	Type 정??
	 * @see
	 */
	function getTypeInfo($id)	 { 
		$type = $this->m_types[$id]; 
		if ($type->getBase() != null && $type->getBaseType() == null) {
			$base_type = $this->getTypeInfo($type->getBase());
			$type->setBaseType($base_type);
		}
		return $type;
	}	
}
?>
