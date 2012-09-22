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

    public function document_list(){
        $this->load->library('admin_tmpl') ; 

        $section = array(
            'header'=>'admin/header',
            'sidebar'=>'admin/sidebar',
            'body'=>'admin/document_list',
            'footer'=>'admin/footer'
        ) ; 

        $str= $this->admin_tmpl->parse($section); 

        echo $str ;
    }

    public function writeform(){ 
        $this->load->library('admin_tmpl') ; 

        $section = array(
            'header'=>'admin/header',
            //'sidebar'=>'admin/sidebar',
            'body'=>'admin/writeform',
            'footer'=>'admin/footer'
        ) ; 

        $str= $this->admin_tmpl->parse($section); 

        echo $str ;
    }
    

    public function tempwriteform() {
        $this->load->view('tempwriteform') ; 
    }        

    public function photoform($page=1) {
        $this->load->model('filebox/Filebox_model','filebox');
        // page setting
        $page_view = 5; // a page recode number
        $base_url = base_url(); // base url
        $act_url = $base_url . "document/admin/photoform"; // act url
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
        $data['result']=$this->filebox->select_entry($start_idx, $page_view, $data);
        // get page tocal count
        $data['total_record'] = count($this->filebox->total_entry_count($data));
        $data['total_page'] = ceil($data['total_record'] / $page_view);
        // url
        $data['base_url'] = $base_url;
        $data['act_url'] = $act_url;

        // view
        //$this->load->view('admin/photoform', $data) ;
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

    public function save(){ 
    } 

    public function remove(){ 
    }
} 
/* End of file document.php */
/* Location : ./modules/document/document.php */
?>
