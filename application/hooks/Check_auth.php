<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Check_auth extends CI_Controller {
    public function check_auth(){ 
        $ci = &get_instance() ; 
        $ci->load->library('tank_auth') ; 
        $ci->load->helper('url') ; 
        $url = uri_string() ; 

        if (strpos($url,'admin') === 0 ){
            if(!$ci->tank_auth->is_logged_in()) {// not_logged_in 
                echo modules::run('member/do_login') ; 
                exit() ; 
            }
		}
    } 
}

/* End of file Check_auth.php */
/* Location: ./application/hooks/Check_auth.php */
