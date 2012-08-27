<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 

class Install extends MX_Controller { 
    var $header ; 
    var $body ; 
    var $footer ; 

    public function __construct(){
        $this->header = $this->load->view('header','',true) ; 
        $this->footer = $this->load->view('footer','',true) ; 
    } 

    public function index($step='1step'){ 
        if($step == '1step'){
            $this->_step1() ; 
        }else if($step == '2step'){
            $this->_step2() ; 
        } 
    }

    public function _step1(){
        $this->body = $this->load->view('step1','',true) ; 
        echo $this->header.$this->body.$this->footer ; 
    } 

    public function _step2(){
        $this->body = $this->load->view('step2','',true) ; 
        echo $this->header.$this->body.$this->footer ; 
    } 
}

/* End of file install.php */
/* Location : ./modules/install/install.php */
