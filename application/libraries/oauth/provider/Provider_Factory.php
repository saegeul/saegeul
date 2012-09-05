<?php
include_once('Provider.php'); 
class Provider_Factory {
    public static function factory($provider_name,$oauth_config){
        if(include_once 'Provider_'.$provider_name.'.php'){ 

            $class = 'Provider_'.$provider_name ; 
            return new $class($provider_name,$oauth_config); 
        }else { 
            throw new Exception($provider_name." Provider not found") ; 
        } 
    }
}

/* end of Provider_Factory.php */ 
