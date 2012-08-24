<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 

class Admin extends MX_Controller { 
    var $layout = array() ; 

    public function __construct(){
        $layout['header'] = 'header'; 
        $layout['body'] = ''; 
        $layout['footer'] = 'footer'; 
    }

    public function index(){ 
        $this->load->view('header') ; 
    }

    public function module($module_name='',$action=''){ 
        $header = $this->load->view('header','',true) ; 
        $footer = $this->load->view('footer','',true) ; 

        $body =  Modules::run($module_name.'/'.$action) ; 

        echo $header.$body.$footer; 
    } 

    public function save(){ 

    } 

    public function remove(){ 

    } 
} 
/* End of file admin.php */
/* Location : ./modules/admin/admin.php */
