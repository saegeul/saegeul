<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 

class Document extends MX_Controller { 

    protected $sid;
    protected $module_srl;

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('date');
    }

    public function view(){ 
        $this->load->model('Document_model','document_model'); 
        $d = $this->document_model->getDocument(13); 

        if(count($d) > 0){
            echo urldecode($d[0]->content); 
        } 
    }

    public function save(){
        $this->username = "root";
		$this->email = "root@saegeul.com";
		$this->uid = '1';
        $this->load->model('Document_model','document_model') ; 
        
        $insert_data;
		$insert_data->reg_date = standard_date('DATE_ATOM',time());//date("Y-m-d H:i:s",time());
		$insert_data->ip_address = $this->input->ip_address();
		$insert_data->content = $this->input->post('content');
		$insert_data->title = $this->input->post('title');
		$insert_data->username = 'jaehee' ; 
		$insert_data->email = 'jaehee@saegeul.com' ; 
		$insert_data->uid = 1 ; 

		$this->document_model->insert($insert_data); 
        $this->load->helper('url') ; 

        redirect('/document/admin/document/document_list') ; 
    }

    public function sample_list(){
        $arr = array() ; 
        $obj['description'] = 'afasdfasf'; 
        $obj['name'] = 'hello'; 
        $arr[] = $obj; 
        $obj2['description'] = 'afasdfasf'; 
        $obj2['name'] = 'hello'; 
        $arr[] = $obj2;

        $result['page'] = 1; 
        $result['items'] = $arr; 

        echo json_encode($result) ; 
    }

    public function index(){
        $layout = array() ; 
        $this->load->library('admin_tmpl') ; 

        $section = array(
            'header'=>'admin/header',
            'sidebar'=>'admin/sidebar',
            'body'=>'admin/body',
            'footer'=>'admin/footer'
        ) ; 

        $str= $this->admin_tmpl->parse($section); 

        echo $str ; 

    }

    public function document_list($page=1){
        //$this->load->library('admin_tmpl') ; 
        $this->load->library('sg_layout') ; 
        $this->load->model('Document_model','document');

        $this->sg_layout->layout('admin/layout') ; 
        $this->sg_layout->module('document') ; 
        $this->sg_layout->add('admin/header') ; 
        $this->sg_layout->add('admin/sidebar') ; 
        $this->sg_layout->add('admin/document_list') ; 
        $this->sg_layout->add('admin/footer') ; 
/*
        $section = array(
            'header'=>'admin/header',
            'sidebar'=>'admin/sidebar',
            'body'=>'admin/document_list',
            'footer'=>'admin/footer'
        ) ; 
*/

        $page_view = 10; // a page recode number
        $base_url = base_url(); // base url
        $act_url = $base_url . "document/admin/document/document_list"; // act url
        $page_per_block = 5; // a page recode moveing number

        // return data setting
        $data = "";

        if($page < 1){
            $page = 1;
            $data['page'] = 1;
        }else{
            $data['page'] = $page;
        }

        $start_idx = ($page - 1) * $page_view;

        // search keyworld
        if($this->input->get('key') && $this->input->get('keyword')){
            $data['key'] = $this->input->get('key');
            $data['keyword'] = $this->input->get('keyword');
        }else {
            $data['key'] = "";
            $data['keyword']= "";
        }


        // get files in DB
        $data['result']=$this->document->getDocumentList($start_idx, $page_view, $data);
        // get page tocal count
        $data['total_record'] = count($this->document->total_entry_count($data));
        $data['total_page'] = ceil($data['total_record'] / $page_view);
        // url
        $data['base_url'] = $base_url;
        $data['act_url'] = $act_url;

        //$str= $this->admin_tmpl->parse($section,$data); 

        $this->sg_layout->show($data) ; 
        //$str= $this->admin_tmpl->parse($section,$data); 


        //echo $str ;
    }

    public function writeform(){ 
/*
        $this->load->library('admin_tmpl') ; 

        $section = array(
            'header'=>'admin/header',
            //'sidebar'=>'admin/sidebar',
            'body'=>'admin/writeform',
            'footer'=>'admin/footer'
        ) ; 

        $str= $this->admin_tmpl->parse($section); 

        echo $str ;
*/
        $this->load->library('sg_layout') ; 
        $this->load->model('Document_model','document');

        $this->sg_layout->layout('admin/layout') ; 
        $this->sg_layout->module('document') ; 
        $this->sg_layout->add('admin/header') ; 
       // $this->sg_layout->add('admin/sidebar') ; 
        $this->sg_layout->add('admin/writeform') ; 
        $this->sg_layout->add('admin/footer') ; 

        $this->sg_layout->show() ; 
    }
    

    public function tempwriteform() {
        $this->load->view('tempwriteform') ; 
    }        

    public function photoform($page=1) {
        $this->load->model('Document_model','document');
        // page setting
        $data = "";
        $data['page_view'] = $page_view = 18; // a page recode number
        $base_url = base_url(); // base url
        $act_url = $base_url . "document/admin/photoform"; // act url
        $page_per_block = 5; // a page recode moveing number
        $start_idx = ($page - 1) * $page_view;
/*
        $prev_page = $page - 1;
        $next_page = $page + 1;
        $first_page = ((integer)(($page-1)/$page_per_block) * $page_per_block) + 1;
        $last_page = $first_page + $page_per_block - 1;
        $etc ="";
        if($last_page > $total_page){
            $last_page = $total_page;
        }
        if($key != "" && $keyword != ""){
        $etc = "?key=" . $key . "&keyword=" . $keyword;
        }
        if($page < 1){
            $page = 1;
            $data['page'] = 1;
        }else{
            $data['page'] = $page;
        }

        $start_idx = ($page - 1) * $page_view;
        // search keyworld 
        if($this->input->get('key') && $this->input->get('keyword')){
            $data['key'] = $this->input->get('key');
            $data['keyword'] = $this->input->get('keyword');
        }else {
            $data['key'] = "";
            $data['keyword']= "";
        }
*/
        // get files in DB
        $data['result']=$this->document->select_image();
        // get page tocal count
        $data['total_record'] = count($data['result']);
        $data['total_page'] =ceil($data['total_record'] / $page_view);
        // url
        $data['base_url'] = $base_url;
        $data['act_url'] = $act_url;


        // get files in DB
        //$data['result']=$this->document->select_url();
        echo json_encode($data);
    }

    public function fileform() {
        $this->load->view('fileform') ;
    }

    public function mapform() {
        $this->load->view('mapform') ;
    }

    public function googleform() {
        $this->load->view('googleform') ;
    }

    public function twitterform() {
        $this->load->view('twitterform') ;
    }

    public function facebookform() {
        $this->load->view('facebookform') ;
    } 

    public function remove(){ 
    }
} 
/* End of file document.php */
/* Location : ./modules/document/document.php */
?>
