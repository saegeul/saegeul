<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 

class Admin extends MX_Controller { 

    public function index(){ 
        $this->load->view('header') ; 
        $this->load->view('body') ; 
        $this->load->view('footer') ; 
    }

    public function save(){ 
    } 

    public function remove(){ 
    }
} 
/* End of file document.php */
/* Location : ./modules/admin/admin.php */
