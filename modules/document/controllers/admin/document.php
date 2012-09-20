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
        $layout = array() ; 
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
        $layout = array() ; 
        $layout['header'] = $this->load->view('./../../admin/views/header','',true);
        $layout['body'] = $this->load->view('admin/writeform','',true);
        $layout['footer'] = $this->load->view('./../../admin/views/footer','',true);

        echo $layout['header'].$layout['body'].$layout['footer'] ; 
    }

    public function tempwriteform() {
        $this->load->view('tempwriteform') ; 
    }        
    public function photoform() {
        $this->load->model('Document_model'); // ???? - È£??

        // ???? - ??Á¤
        $base_segment = 3; // CI????Â¡ ???×¸?Æ® ?Ö¼?À§Ä¡??
        $page_view = 12; // ?? ???????? ?????? ???Úµ? ??

        $base_url = base_url(); // base_url
        $act_url = $base_url . "document/photoform";

        $page_per_block = 5; // ????Â¡ ?Ìµ? ???? ( 1 .. 5)

        $data = "";

        if(!$this->uri->segment($base_segment)) {
            $data['page'] = $page = 1;
        } else {
            $data['page'] = $page = $this->uri->segment(3,0);
        }

        if($this->input->post('key') && $this->input->post('keyword')){
            $data['key'] = $this->input->post('key');
            $data['keyword'] = $this->input->post('keyword');
        }else {
            $data['key'] = "";
            $data['keyword']= "";
        }
            $start_idx = ($page - 1) * $page_view;
        $data['result']=$this->Document_model->select_entry($start_idx, $page_view, $data);
        $data['total_record'] = count($this->Document_model->total_entry_count($data));
        $data['total_page'] = ceil($data['total_record'] / $page_view);

        // ?? - Á¤??
        $data['base_url'] = $base_url;
        $data['act_url'] = $act_url;
        // ?? - ????
        $this->load->view('photoform',$data) ;
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
