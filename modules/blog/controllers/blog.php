<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Blog extends MX_Controller {
    public function __construct(){

    }

    public function welcome($id=1) {
        $this->load->database() ; 
        $this->load->model('document/Document_model','document_model'); 
        $d = $this->document_model->getDocument($id); 

        $data['docu'] = urldecode($d[0]->content);
        $data['title'] = urldecode($d[0]->title);

        $this->load->view('blog',$data) ; 
    }
} 
