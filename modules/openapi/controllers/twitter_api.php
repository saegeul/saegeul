<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Twitter_api extends MX_Controller { 
    public function __construct(){

    }

    public function search(){
        $search_keyword = urlencode($this->input->get_post('search_keyword'));
        $url = 'http://search.twitter.com/search.json?q='.$search_keyword ; 

        $page = $this->input->get_post('page') ; 

        if($page){
            $url=$url.'&page='.$page ; 
        }

        //$url = urlencode($url) ; 

        $ch = curl_init() ; 
        curl_setopt($ch,CURLOPT_URL,$url) ; 
        curl_setopt($ch,CURLOPT_POST,0) ; 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1) ; 
        $data = curl_exec($ch) ; 
        //echo $data ; 

        $data = json_decode($data) ;

        $response = array() ; 
        $response['items'] = $data->results ; 

        echo json_encode($response) ; 
    }
}
