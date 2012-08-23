<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Filebox extends MX_Controller { 

    public function index(){

    }

    public function uploadForm(){
        $this->load->view('upload_form') ; 
    } 
}

/* End of file filebox.php */
/* location : ./modules/filebox/filebox.php*/
