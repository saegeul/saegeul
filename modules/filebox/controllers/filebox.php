<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Filebox extends MX_Controller { 

    public function index(){

    }

    public function uploadForm(){
        $this->load->view('upload_form') ; 
    } 

    public function process(){ 

        $this->load->library('uploadhandler') ; 
		
		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');
		
		switch ($_SERVER['REQUEST_METHOD']) {
		    case 'OPTIONS':
		        break;
		    case 'HEAD':
		    case 'GET':
		        //$upload_handler->get();
                $this->uploadhandler->get() ; 
		        break;
		    case 'POST':
		        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
		            //$upload_handler->delete();
                    $this->uploadhandler->delete() ; 
		        } else {
		            //$upload_handler->post();
                    $this->uploadhandler->post() ; 
		        }
		        break;
		    case 'DELETE':
		        //$upload_handler->delete();
                $this->uploadhandler->delete() ; 
		        break;
		    default:
		        header('HTTP/1.1 405 Method Not Allowed');
		}
    }
}

/* End of file filebox.php */
/* location : ./modules/filebox/filebox.php*/
