<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 

class Install extends MX_Controller { 
    var $header ; 
    var $body ; 
    var $footer ; 

    public function __construct(){
        $this->load->helper('url') ; 
        $this->header = $this->load->view('header','',true) ; 
        $this->footer = $this->load->view('footer','',true) ; 
    } 

    public function index(){ 
        $this->load->helper('url') ; 
        redirect('install/checkEnvironment'); 
    }

    function _defaultSetting(){
        $directory = array(
            './fiebox' 
        ); 

        foreach($directory as $dir){ 
            FileHandler::makeDir($dir) ; 
        } 
    }

    public function checkEnvironment(){ 
        $checklist = array() ; 

        $checklist['permission'] = false ; 
        $checklist['xml'] = false ; 
        $checklist['gd'] = false ; 
        $checklist['php_version'] = false ; 

        if(is_writable('./')||is_writable('./filebox')) $checklist['permission']=true ;

        if(phpversion() >= '5.0.0') $checklist['php_version'] = true ; 
        if(function_exists('imagecreatefromgif')) $checklist['gd'] = true ; 
        if(function_exists('xml_parser_create')) $checklist['xml'] = true ; 

        $data['checklist'] = $checklist ; 
        $data['step'] = 'checkEnvironment';

        $this->body = $this->load->view('step1',$data,true) ; 

        $this->header = $this->load->view('header',$data,true) ; 
        echo $this->header.$this->body.$this->footer ;
    }

    public function checkDatabase(){ 
        $data['step'] = 'checkDatabase';
        $this->body = $this->load->view('step2','',true) ; 
        $this->header = $this->load->view('header',$data,true) ; 
        echo $this->header.$this->body.$this->footer ;
    } 

    public function setupDatabase(){
        $data = array() ; 
        $data['step'] = 'checkDatabase' ; 

        $this->load->library('form_validation') ; 

		$this->form_validation->set_rules('database_host', 'Database HOST', 'required|xss_clean');
		$this->form_validation->set_rules('database_user', 'Database USER', 'required|xss_clean|alpha_dash');
		$this->form_validation->set_rules('database_password', 'Database Password', 'required|xss_clean|alpha_dash');
		$this->form_validation->set_rules('database_name', 'Database Name', 'required|xss_clean|alpha_dash');

        $this->input->post('database_host') ; 
        $this->input->post('database_user') ; 
        $this->input->post('database_password') ; 
        $this->input->post('database_name') ; 

        if($this->form_validation->run()){
            $this->_setupDatabase() ; 
            redirect('install/checkAdmin');
        }else{
            $data['errors'] =  $this->form_validation->error_string() ; 
            $this->body = $this->load->view('step2',$data,true) ; 
            $this->header = $this->load->view('header',$data,true) ; 
            echo $this->header.$this->body.$this->footer ;
        }
    }
    

    public function checkAdmin(){ 
        $data['step'] = 'checkAdmin';
        $this->body = $this->load->view('step3','',true) ; 
        $this->header = $this->load->view('header',$data,true) ; 
        echo $this->header.$this->body.$this->footer ; 
    }

    public function _setupDatabase(){
        $params = array(
            'database_host'=>'localhost',
            'database_user'=>'',
            'database_password'=>'', 
            'database_name'=>'', 
            'dbprefix'=>'SG_'
        ); 

        $database_host = $this->input->post('database_host')==''? 'localhost':$this->input->post('database_host') ; 
        $database_user = $this->input->post('database_user') ; 
        $database_password = $this->input->post('database_password') ; 
        $database_name = $this->input->post('database_name') ; 
        $dbprefix = 'SG_';

        $params['database_host'] = $database_host ; 
        $params['database_user'] = $database_user ; 
        $params['database_password'] = $database_password ; 
        $params['database_name'] = $database_name ; 
        $params['dbprefix'] = $dbprefix ; 


        $this->load->helper('file') ; 
        $f = read_file('./modules/install/files/database.txt') ; 
        
        foreach($params as $key => $value){
            $f = str_replace('{'.$key.'}', $value ,$f); 
        } 

        write_file(APPPATH.'config/database.php',$f) ; 
    } 
    


    public function _setupDatabaseTable(){
        $this->load->helper('directory') ; 
        $this->load->helper('file') ; 
        $map = directory_map('./modules',2); 

        $schema_list = array() ; 
        $file_list = array() ; 

        foreach($map as $key => $row){ //modules list 
           $dir_max = count($row) ;  
           $path = './modules/'.$key.'/schemas' ;

           for($i=0 ; $i < $dir_max ;$i++){ 
               if($row[$i] == 'schemas'){ 
                   $schema_list = directory_map($path) ; 
                   for($k = 0 ; $k < count($schema_list) ;$k++){ 
                       if(strpos($schema_list[$k],'xml')){
                           $result = explode('.',$schema_list[$k]); 
                           $file_list[$result[0]] =$path.'/'.$schema_list[$k] ;  
                       }
                   }
               } 
           } 
        }

        $this->load->library('sg_dbutil') ; 

        $data = array() ; 
        $data['result']= array() ; 
        
        foreach($file_list as $key => $file_path){ 
            $f = read_file($file_path) ; 
            $result = $this->sg_dbutil->schema_parse($f) ; 
            $data['result'][$key] = $this->sg_dbutil->create_table($key , $result['columns']) ; 

        } 

        $this->_register_admin() ; 
        $this->load->view('complete',$data) ; 
    } 

    public function setupAdmin(){
		$this->load->library('tank_auth');

        $data = array() ; 
        $data['step'] = 'checkAdmin'; 
        $this->load->library('form_validation') ; 
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]'); 

		$this->form_validation->set_rules('username', 'User ID', 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash'); 
		
		$email_activation = $this->config->item('email_activation', 'tank_auth');
		
		if ($this->form_validation->run()) {
            $this->_setupDatabaseTable() ; 
        }else{ 
            $data['errors'] =  $this->form_validation->error_string() ; 
            $this->body = $this->load->view('step3',$data,true) ; 
            $this->header = $this->load->view('header',$data,true) ; 
            echo $this->header.$this->body.$this->footer ; 
        }
		$this->load->model('users') ;
        
        $this->users->siteset_init();
    }

    function _register_admin(){
        $this->load->library('tank_auth') ; 
        $use_username = $this->config->item('use_username', 'tank_auth');
        $this->load->library('form_validation') ; 
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash'); 
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
		

		$data['errors'] = array();
		
		$email_activation = $this->config->item('email_activation', 'tank_auth');
		
		if ($this->form_validation->run()) {								// �좏슚��泥댄겕 �듦낵
			if (!is_null($data = $this->tank_auth->create_user(
					$this->form_validation->set_value('username'),
					$this->form_validation->set_value('email'),
					$this->form_validation->set_value('password'),
					$email_activation))) {									// success 
		
				$data['site_name'] = $this->config->item('website_name', 'tank_auth');
                $this->load->model('users') ; 
                $this->users->setAdminByEmail($data['email']) ; 
				
			} else {
				$errors = $this->tank_auth->get_error_message();
				foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
			}
		} 
    } 
}

/* End of file install.php */
/* Location : ./modules/install/install.php */
