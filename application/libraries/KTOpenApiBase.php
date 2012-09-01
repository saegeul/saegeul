<?php
include_once("KTOpenApiConsts.php");

class KTOpenApiBase 
{
	var $m_errorCode;		// ?????ڵ?
	var $m_errorMsg	;		// ?????޽???
	
	/**
	 * Constructor
	 *
	 * @see
	function KTOpenApiBase()
	{
		$this->initVars();
	}
	
	/**
	 * initialize instance variable
	 *
	 * @see
	 */
	function initVars()
	{
		$this->m_errorCode = 0;
		$this->m_errorMsg  = "";		
	}
	
	/**
	 * ???? ?ڵ? ????
	 *
	 * @return	integer
	 *   - 0		no error
	 *	 - other	error
	 * @see
	 */
	function getErrorCode() 
	{ 
		return $this->m_errorCode; 
	}
	
	/**
	 * ???? ?޽??? ????
	 *
	 * @return	string		???? ?޽???
	 * @see
	 */
	function getErrorMsg()
	{
		return $this->m_errorMsg;
	}

	function makeErrResult($errCode)
	{
		global $KT_ERR_MSG;

		return array(
					"result_code"	=> $errCode,
					"result_msg"	=> iconv("EUC-KR", "UTF-8", $KT_ERR_MSG[$errCode])
			   );
	}

	function setErrorCode($errCode)
	{
		global $KT_ERR_MSG;
		$this->m_errorCode = $errCode;
		$this->m_errorMsg  = iconv("EUC-KR", "UTF-8", $KT_ERR_MSG[$errCode]);
	}

	/**
	 * API Query String ????
	 *
	 * @params 
	 *   - String	$params		Parameter Hashmap
	 * @return	String	API Query String
	 * @see
	 */
	function makeQueryString($params) 
	{
		$qstr = "";
		foreach($params as $k => $v) {
			if (is_array($v)) {
				foreach($v as $tti => $ttv) {
					$qstr = $qstr ."&". urlencode($k."[".$tti."]") . "=" . urlencode($ttv);
					//echo "qstr>>".$qstr."<br/>";
				}
			}
			else {
				$qstr = $qstr."&" . urlencode($k) . "=" . urlencode($v);
			}
		}
		return substr($qstr,1); 
	}
};

?>
