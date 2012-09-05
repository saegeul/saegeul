<?php
    class Consumer {
        var $api_key ;
        var $secret_key ; 
        var $callback_url ; 
        var $oauth_config ; 

        function __construct($consumer_config,$oauth_config){
            $this->set('api_key',$consumer_config['api_key']) ; 
            $this->set('secret_key',$consumer_config['secret_key']) ; 
            $this->set('callback_url',$consumer_config['callback_url']) ; 
            $this->set('oauth_config',$oauth_config) ; 
        }

        public function set($key,$val){ 
            $this->{$key} = $val ; 
        }

        public function get($key){
            return $this->{$key} ; 
        }

        public function requestTo(& $provider,$token_type,$params,$method='GET'){
            if($token_type == 'request_token'){ 
                return $provider->getRequestToken($this,$params,$method) ;
            }else if($token_type == 'access_token'){ 
                return $provider->getAccessToken($this,$params,$method) ; 
            } 
        } 
    } 

    /* end of Consumer.php */
