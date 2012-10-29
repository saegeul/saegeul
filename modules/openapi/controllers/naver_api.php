<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Naver_api extends MX_Controller { 
    public function __construct(){

    }


    public function search(){
        $search_keyword = urlencode($this->input->get_post('search_keyword'));
        $NAVER_API_KEY ='94856a7222b21977747dc427adeb3959'; 

        //$list_count = 20 ; 
        $url = 'http://openapi.naver.com/search?key='.$NAVER_API_KEY.'&target=blog&display=20&query='.$search_keyword ; 

        $page = $this->input->get_post('page') ; 

        if($page){
            $url=$url.'&start='.($page-1)*$list_count; 
        } 


        $ch = curl_init() ; 
        curl_setopt($ch,CURLOPT_URL,$url) ; 
        curl_setopt($ch,CURLOPT_POST,0) ; 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1) ; 
        $data = curl_exec($ch) ; 

        $result = $this->xml_to_object($data) ; 


        /*$data = json_decode($data) ;

        $response = array() ; 
        $items = $data->data->items ; 

        $store = array() ; 


        foreach($items as $key => $item){ 
            $obj->title = $item->title ;
            $obj->description = $item->description ;
            $obj->youtube_link = $item->player->default ; 
            $obj->thumbnail_url = $item->thumbnail->hqDefault ; 
            $obj->content = $item->content->{"5"} ; 

            $store[] = $obj ; 

            unset($obj) ; 
        }*/

        $response = array() ; 

        $response['items'] = $result ; 

        echo json_encode($response) ;
    } 

    function xml_to_object($feed){

        $xml = @simplexml_load_string($feed) ; 

        $xml = $xml->channel ; 

        if((is_object($xml==false)|| (sizeof($xml)) <= 0 )){
            return false ; 
        } 

        $tmp = $xml->item ; 

        $arr = array() ; 

        foreach($xml->item as $item){ 
            $data = new stdClass ; 

            $data->title = strval($item->title );
            $data->description = strval($item->description) ; 
            $data->link = strval($item->link) ; 
            $data->bloggerlink = strval($item->bloggerlink) ; 
            $data->bloggername = strval($item->bloggername) ; 

            $arr[] = $data ; 
        }

        return $arr ; 
    }
}
