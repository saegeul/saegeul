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

    public function index($step='step1'){ 
        $this->{'_'.$step}(); 
    }

    function _defaultSetting(){
        $directory = array(
            './fiebox' 
        ); 

        foreach($directory as $dir){ 
            FileHandler::makeDir($dir) ; 
        } 
    }

    public function setupDatabase(){
        $params = array(
            'database_host'=>'localhost',
            'database_user'=>'root',
            'database_password'=>'root', 
            'database_name'=>'saegeul', 
            'dbprefix'=>'SG_'
        ); 

        $this->load->helper('file') ; 
        $f = read_file('./modules/install/database.txt') ; 
        
        foreach($params as $key => $value){
            $f = str_replace('{'.$key.'}', $value ,$f); 
        } 

        write_file(APPPATH.'config/database.php',$f) ; 
    }

    public function _step1(){
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

        $this->body = $this->load->view('step1',$data,true) ; 
        echo $this->header.$this->body.$this->footer ; 
    } 

    public function _step2(){
        $this->body = $this->load->view('step2','',true) ; 
        echo $this->header.$this->body.$this->footer ; 
    } 

    public function _step3(){
        $this->body = $this->load->view('step3','',true) ; 
        echo $this->header.$this->body.$this->footer ; 
    }

    public function setupDatabaseTable(){
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
                       array_push($file_list,$path.'/'.$schema_list[$k]) ; 
                   }
               } 
           } 
        }

        $this->load->library('xml_to_db') ; 
        $this->xml_to_db->make_table($file_list) ; 

        //print_r($file_list) ; 
    }
}

/* End of file install.php */
/* Location : ./modules/install/install.php */
