<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 

class Document extends MX_Controller { 
    public function writeform(){ 
        $this->load->view('writeform') ; 
    }
    public function save(){ 
    } 
    public function remove(){ 
    }
    public function somepage(){
    	$this->load->view('somepage') ;
    }
    public function testpage(){
    	$this->load->view('testpage') ;
    }
} 
/* End of file document.php */
/* Location : ./modules/document/document.php */
