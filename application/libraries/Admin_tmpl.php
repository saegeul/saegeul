<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin_tmpl { 
    var $header = './../../admin/views/header' ;
    var $footer = './../../admin/views/footer' ; 
    
    public function __construct(){ 

    } 

    public function parse($section,$data=null){
        $CI = &get_instance() ; 

        $header = $CI->load->view($this->header,$data,true);
        $footer = $CI->load->view($this->footer,$data,true);

        $body = '' ;

        foreach($section as $key => $row){
            $body .= $CI->load->view($row,$data,true);
        }

        return $header.$body.$footer ;
    } 
}

/* End of file Admin_tmpl.php */
/* Location: ./application/libraries/Admin_tmpl.php */
