<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Blog extends MX_Controller {
    public function __construct(){
        $this->load->library('sg_layout') ; 
        $this->sg_layout->layout('simpleblog/layout') ; 
        $this->sg_layout->module('blog') ; 
    }

    public function index($document_id){ 
        $this->load->database() ; 
        $this->load->model('document/document_model','document_model'); 
        $document = $this->document_model->getDocument($document_id) ; 

        print_r($document) ; 
    }

    public function page($page = 1){
        $this->load->database() ; 
        $this->load->model('document/document_model','document_model'); 
        $result = $this->document_model->getDocumentList($page,10,null); 

        $data = array() ; 

        $data['document_list'] = $result['list'] ; 
        $data['pagination'] = $result['pagination'] ;

        $this->sg_layout->add('header') ; 
        $this->sg_layout->add('welcome') ; 
        $this->sg_layout->add('sidebar') ; 
        $this->sg_layout->add('footer') ; 
        $this->sg_layout->addHeaderData($data) ; 

         

        $this->sg_layout->show($data) ;
    }

    public function welcome() {
         
    }



    public function entry($id) {
        $this->load->database() ; 
        $this->load->model('document/Document_model','document_model'); 
        $document = $this->document_model->getDocument($id); 

        $data = array() ; 
        $data['document'] = $document ; 

        $this->sg_layout->add('header') ; 
        $this->sg_layout->add('readpage') ; 
        $this->sg_layout->add('sidebar') ; 
        $this->sg_layout->add('footer') ; 
        $this->sg_layout->addHeaderData($data) ;
        $this->sg_layout->show($data) ;

        //$this->load->view('readpage',$data) ;
    }
} 
