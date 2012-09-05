<?php
class Provider { 
    var $oauth_config ; 

    function __construct($provider,$oauth_config){
        $this->oauth_config=$oauth_config ; 
    } 

    function getSignatureMethod(){
        return $this->oauth_config['signature_method'] ; 
    }

    function getOAuthVersion() { 
        return $this->oauth_config['oauth_version'] ; 
    } 
}
/* end of Provider.php */
