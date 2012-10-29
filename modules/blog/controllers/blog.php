<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Blog extends MX_Controller {
    var $site_info ; 
	public function __construct(){
		$this->load->library('sg_layout') ;
		$this->sg_layout->layout('simpleblog/layout') ;
		$this->sg_layout->module('blog') ;

        $this->site_info = $this->getSiteInfo() ; 
	}

    public function getSiteInfo(){
		$this->load->model('admin_mgr/admin_model') ;
		$ret_data = $this->admin_model->getsiteInfo();
		$ret->title = $ret_data [0]->title ;
		$ret->site_url = $ret_data[0]->site_url ;
		$ret->on_register = $ret_data[0]->on_register;
		
		return $ret ;
	}

    public function rss(){ 
		$this->load->helper('file') ;
		$f = read_file('./modules/blog/files/rss_tmpl.txt') ; 

        $params = array() ; 
        $params['site_title'] = $this->site_info->title; 
		$params['site_url'] = base_url().'blog'  ;
		$params['site_description'] = $this->site_info->title;
		$params['pubDate'] = date("Y-m-d H:i:s"); 

        $items ='' ; 

        $this->load->model('document/document_model') ; 

        $result = $this->document_model->getDocumentList(1,30)  ; 

        $list = $result['list'] ; 

        $item_str = '' ; 

        foreach($list as $key => $row){
            $title = $row->title ; 
            $description = htmlspecialchars($row->content) ; 
            $link = base_url().'blog/read/'.$row->doc_id ; 
            $pubDate = $row->reg_date ; 

            $item_str = $item_str.sprintf("<item><title>%s</title><description>%s</description><link>%s</link><pubDate>%s</pubDate></item>",$title,$description,$link,$pubDate) ;  
        }

        //$item_str = sprintf("<item><title>%s</title><description>%s</description><link>%s</link><pubDate>%s</pubDate></item>",'hi','hi','http://www.naver.com','pubdate') ; 

        $params['items'] = $item_str ; 


        foreach($params as $key => $value){
			$f = str_replace('{'.$key.'}', $value ,$f);
		}

        print_r($f) ; 
    }

    public function search(){
        $this->load->database() ;
		
		$this->config->load('blog', FALSE, TRUE);
		$listCount = ($this->config->item('listCount')==FALSE)?10:$this->config->item('listCount');
		
        $param = array() ; 
	    $param['search_key'] = 'title' ; 	
	    $param['search_keyword'] = $this->input->get_post('search_keyword') ; 

		$this->load->model('document/document_model','document_model');
		$result = $this->document_model->getDocumentList($page=1,100,$param);

		$data = array() ;

        $data['search_keyword'] = $this->input->get_post('search_keyword') ; 

		$data['document_list'] = $result['list'] ;
		$data['pagination'] = $result['pagination'] ;
		$data['site_info'] = $this->site_info; 

		$this->sg_layout->add('header') ;
		$this->sg_layout->add('search_result') ;
		$this->sg_layout->add('sidebar') ;
		$this->sg_layout->add('footer') ;
		$this->sg_layout->addHeaderData($data) ;

		$this->sg_layout->show($data) ;
    }

	public function index(){
	    $this->page(1) ; 	
	}

	public function page($page = 1){
		$this->load->database() ;
		
		$this->config->load('blog', FALSE, TRUE);
		$listCount = ($this->config->item('listCount')==FALSE)?10:$this->config->item('listCount');
		
		
		$this->load->model('document/document_model','document_model');
		$result = $this->document_model->getDocumentList($page,$listCount,null);

		$data = array() ;

		$data['document_list'] = $result['list'] ;
		$data['pagination'] = $result['pagination'] ;
		$data['site_info'] = $this->site_info; 

		$this->sg_layout->add('header') ;
		$this->sg_layout->add('welcome') ;
		$this->sg_layout->add('sidebar') ;
		$this->sg_layout->add('footer') ;
		$this->sg_layout->addHeaderData($data) ;

		$this->sg_layout->show($data) ;
	}

	public function welcome() {
		 
	}



	public function read($id) {
		$this->load->database() ;
		$this->load->model('document/Document_model','document_model');
		$document = $this->document_model->getDocument($id);

		$data = array() ;
		$data['site_info'] = $this->site_info; 
		$data['document'] = $document ;

        $facebook_info->comment_count = $this->config->item('commentCount','blog'); 
        $facebook_info->appId = $this->config->item('facebookId','blog'); 
        $data['facebook_info'] = $facebook_info ; 
        $this->config->item('theme','blog');

		$this->sg_layout->add('header') ;
		$this->sg_layout->add('readpage') ;
		$this->sg_layout->add('sidebar') ;
		$this->sg_layout->add('footer') ;
		$this->sg_layout->addHeaderData($data) ;
		$this->sg_layout->show($data) ;

         

		//$this->load->view('readpage',$data) ;
	}

	public function sendTrackBack($param){
		$this->load->library('trackback');
		 
		$tb_data = array(
				'url'       => $param->url,
				'title'     => $param->title,
				'excerpt'   => $param->excerpt,
				'blog_name' => $param->blog_name,
				'charset'   => 'utf-8'
		);
		 
		if ( ! $this->trackback->send($tb_data))
		{
			return $this->trackback->display_errors();
		}
		else
		{
			return $this->processTrackBack($tb_data);
		}
	}

	public function processTrackBack($doc_id){
		$this->load->library('trackback');
		$this->load->helper('date');

		$data = array(
				'doc_id'   => $doc_id,
				'url'        => $this->trackback->data('url'),
				'title'      => $this->trackback->data('title'),
				'excerpt'    => $this->trackback->data('excerpt'),
				'blog_name'  => $this->trackback->data('blog_name'),
				'reg_date'    => standard_date('DATE_ATOM',time()),
				'ip_address' => $this->input->ip_address()
		);

		$this->load->model('Document/Trackback_model','track');		
		$ret_data = $this->track->insert($data) ;

		return $this->trackback->send_success();
	}
}
