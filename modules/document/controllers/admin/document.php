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
        $this->load->model('Document_model','document_model') ; 

        $insert_data;
        $insert_data->reg_date = standard_date('DATE_ATOM',time());//date("Y-m-d H:i:s",time());
        $insert_data->ip_address = $this->input->ip_address();
        $insert_data->content = $this->input->post('content');
        $insert_data->title = $this->input->post('title');
        $insert_data->description = $this->input->post('description') ; 
        

        $this->load->library('tank_auth');

		// get session data
		$insert_data->username = $this->tank_auth->get_username();
		$insert_data->uid = $this->tank_auth->get_user_id();
		$insert_data->email = $this->tank_auth->get_useremail();


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

    public function document_list($page=1,$list_count=5){
        $data['action'] = 'document_list';
        $this->load->model('Document_model','document');

        $search_param = null;
        $is_trash = 0;
        $data['search_key'] = '';
        $data['search_keyword'] = '';

        if($this->input->get_post('search_key') && $this->input->get_post('search_keyword')){
            $search_param = array(); 
            $data['search_key'] =  $search_param['search_key'] = $this->input->get_post('search_key');
            $data['search_keyword'] = $search_param['search_keyword'] = $this->input->get_post('search_keyword');
        }
        $result = $this->document->getDocumentList($page,$list_count,$search_param,$is_trash);

        $data['document_list'] = $result['list'];
        $data['pagination'] = $result['pagination'];

        $this->load->library('sg_layout');
        $this->sg_layout->layout('admin/layout') ; 
        $this->sg_layout->module('document') ; 
        $this->sg_layout->add('admin/header') ; 
        $this->sg_layout->add('admin/sidebar') ; 
        $this->sg_layout->add('admin/document_list') ; 
        $this->sg_layout->add('admin/footer') ; 

        $this->sg_layout->show($data) ;
    }

    //public function trash($doc_id=null,$is_trash=1) {
    public function trash() {


        $this->load->model('Document_model','document');
        $doc_id = $this->input->get_post('doc_id');
        $is_trash = $this->input->get_post('is_trash');
        $data = array('is_trash' => $is_trash);
        $this->document->setTrash($data,$doc_id);
        
        if( $is_trash ) {  
            $this->document_list();
        } else {
            $this->recyclebin_list();
        }
    }
    public function delete(){
        $this->load->model('Document_model','document');
        $doc_id = $this->input->get_post('doc_id');
        $remove_odj = $this->document->delete($doc_id) ;
        
        $this->recyclebin_list();

    }


    public function recyclebin_list($page=1,$list_count=5){
        $data['action'] = 'recyclebin_list';
        $this->load->model('Document_model','document');

        $search_param = null;
        $is_trash = 1;
        $data['search_key'] = '';
        $data['search_keyword'] = '';

        if($this->input->get_post('search_key') && $this->input->get_post('search_keyword')){
            $search_param = array(); 
            $data['search_key'] =  $search_param['search_key'] = $this->input->get_post('search_key');
            $data['search_keyword'] = $search_param['search_keyword'] = $this->input->get_post('search_keyword');
        }
        $result = $this->document->getDocumentList($page,$list_count,$search_param,$is_trash);

        $data['fileList'] = $result['list'];
        $data['pagination'] = $result['pagination'];

        $this->load->library('sg_layout');
        $this->sg_layout->layout('admin/layout') ; 
        $this->sg_layout->module('document') ; 
        $this->sg_layout->add('admin/header') ; 
        $this->sg_layout->add('admin/sidebar') ; 
        $this->sg_layout->add('admin/recyclebin_list') ; 
        $this->sg_layout->add('admin/footer') ; 

        $this->sg_layout->show($data) ;
    }

    public function writeform(){ 
        $data['action'] = 'writeform';

        $this->load->library('sg_layout') ; 
        $this->load->model('Document_model','document');

        $this->sg_layout->layout('admin/layout') ; 
        $this->sg_layout->module('document') ; 
        $this->sg_layout->add('admin/header') ; 
        $this->sg_layout->add('admin/sidebar') ; 
        $this->sg_layout->add('admin/writeform') ; 
        $this->sg_layout->add('admin/footer') ; 

        $this->sg_layout->show($data) ; 
    }

    public function correctform($doc_id=1){
        $data = array() ; 

        $data['action'] = 'writeform';

        $this->load->library('sg_layout') ; 
        $this->load->model('Document_model','document');

        $this->sg_layout->layout('admin/layout') ; 
        $this->sg_layout->module('document') ; 
        $this->sg_layout->add('admin/header') ; 
        $this->sg_layout->add('admin/sidebar') ; 
        $this->sg_layout->add('admin/correctform') ; 
        $this->sg_layout->add('admin/footer') ; 

        $result = $this->document->getDocument($doc_id);
        
        $data['document'] = $result;


        $this->sg_layout->show($data) ;
    }

    public function modify_document($doc_id=null)
    {
        $data['action'] = 'writeform';

        $this->load->library('sg_layout') ; 
        $this->load->model('Document_model','document');

        $this->sg_layout->layout('admin/layout') ; 
        $this->sg_layout->module('document') ; 
        $this->sg_layout->add('admin/header') ; 
        $this->sg_layout->add('admin/sidebar') ; 
        $this->sg_layout->add('admin/writeform') ; 
        $this->sg_layout->add('admin/footer') ; 

        $doc_id = $this->input->get_post('doc_id'); 
        $result = $this->document->getDoc($doc_id);
        $data['content'] = $result['content'];

        $this->sg_layout->show($data) ; 

    }
    

    public function tempwriteform() {
        $this->load->view('tempwriteform') ; 
    }        

    public function getPhoto($page=1,$list_count=10) {

        $this->load->model('Document_model','document');
        $page = $this->input->get_post('page');
        if($this->input->get_post('key') && $this->input->get_post('keyword')){
            $search_param['option'] = $this->input->get('key');
            $search_param['value'] = $this->input->get('keyword');
            $result = $this->document->getImageList($page,$list_count,$search_param);
        }else {
            $result = $this->document->getImageList($page,$list_count);
        }
        $data['fileList'] = $result['list'];
        $data['pagination'] = $result['pagination'];
        $data['base_url'] = base_url();
        echo json_encode($data);

    }

    public function getFile($page=1,$list_count=10) {

        $this->load->model('Document_model','document');
        $page = $this->input->get_post('page');
        if($this->input->get_post('key') && $this->input->get_post('keyword')){
            $search_param['option'] = $this->input->get('key');
            $search_param['value'] = $this->input->get('keyword');
            $result = $this->document->getFileList($page,$list_count,$search_param);
        }else {
            $result = $this->document->getFileList($page,$list_count);
        }
        $data['fileList'] = $result['list'];
        $data['pagination'] = $result['pagination'];
        $data['base_url'] = base_url();
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
