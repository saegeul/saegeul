<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Youtube_api extends MX_Controller { 
    public function __construct(){

    }

    public function search(){
        $search_keyword = urlencode($this->input->get_post('search_keyword'));
        $list_count = 20 ; 
        $url = 'http://gdata.youtube.com/feeds/api/videos?alt=jsonc&v=2&q='.$search_keyword ; 

        $page = $this->input->get_post('page') ; 

        if($page){
            $url=$url.'&start-index='.($page-1)*$list_count; 
        }


        $ch = curl_init() ; 
        curl_setopt($ch,CURLOPT_URL,$url) ; 
        curl_setopt($ch,CURLOPT_POST,0) ; 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1) ; 
        $data = curl_exec($ch) ; 

        $data = json_decode($data) ;

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
        }

        $response['items'] = $store ; 

        

        echo json_encode($response) ; 
    }
}
