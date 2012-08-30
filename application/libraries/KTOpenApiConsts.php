<?php
// Constant define
define("DEF_ID_PAY_AUTH"			, "idPayAuth"  			);
define("DEF_USER_AUTH"			, "userAuth"   			);
define("DEF_USER_PAY_AUTH"		, "userPayAuth"			);
define("DEF_KTOAUTH_CONTEXT"		, "ktoauth_context"		);
define("DEF_KTOAUTH_ACCESS_TOKEN"	, "ktoauth_access_token");

define("DEF_OAUTH_REQUEST_TOKEN"	,"R");
define("DEF_OAUTH_ACCESS_TOKEN"	,"A");


// Oauth Step define
define("DEF_OAUTH_STEP_REQUEST_TOKEN", 0);
define("DEF_OAUTH_STEP_AUTHORIZE", 	 1);
define("DEF_OAUTH_STEP_ACCESS_TOKEN",	 2);
define("DEF_OAUTH_STEP_ACCESS_API",	 3);
define("DEF_STEP_ACCESS_API",	 4);

define("DEF_GKEY", "GKEY");
define("DEF_DKEY", "DKEY");
define("DEF_UKEY", "UKEY");

// response format define
define("DEF_XML_FMT", ".xml");
define("DEF_JSON_FMT", ".json");
define("DEF_WEB_FMT", "");

// Error code define
define("HTTP_STATUS_401"      	, "401");
define("HTTP_STATUS_404"      	, "404");
define("HTTP_STATUS_500"      	, "500");
define("KT_ERR_NOTFOUND_API"      , "900");
define("KT_ERR_NOT_AVAILABLE_GKEY", "901");
define("KT_ERR_REQUEST_TOKEN"     , "902");

// Error Msg define
$KT_ERR_MSG = array (
	"HTTP_STATUS_401"           => "Unauthorized.",
	"HTTP_STATUS_404"           => "?Ø´? ???ñ½º¸? Ã£À» ?? ???À´Ï´?.",
	"HTTP_STATUS_500"           => "Internal Server Error",
	"KT_ERR_NOTFOUND_API"       => "API Á¤???? Ã£À» ?? ???À´Ï´?.",
	"KT_ERR_NOT_AVAILABLE_GKEY" => "?Ï¹? Å°?? ?????? ?? ???? API ?Ô´Ï´?.",
	"KT_ERR_REQUEST_TOKEN"      => "Oauth Request Token ?????? ?????? ?ß»??ß½À´Ï´?."
);

 
?>
