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

        $this->body = $this->load->view('step1',$data,true) ; 
        echo $this->header.$this->body.$this->footer ;
    }

    public function checkDatabase(){
        $this->body = $this->load->view('step2','',true) ; 
        echo $this->header.$this->body.$this->footer ;
    }

    public function checkAdmin(){ 
        $this->body = $this->load->view('step3','',true) ; 
        echo $this->header.$this->body.$this->footer ; 
    }

    public function setupDatabase(){
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

        $this->load->helper('url'); 

        redirect('./install/checkAdmin'); 
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
                       if(strpos($schema_list[$k],'xml')){
                           $result = explode('.',$schema_list[$k]); 
                           $file_list[$result[0]] =$path.'/'.$schema_list[$k] ;  
                       }
                   }
               } 
           } 
        }

        $this->load->library('sg_dbutil') ; 
        
        foreach($file_list as $key => $file_path){ 
            $f = read_file($file_path) ; 

            $result = $this->sg_dbutil->schema_parse($f) ; 
            $this->sg_dbutil->create_table($key , $result['columns']) ; 
        } 
         
    }

    function make_table($result){ 
        $fields = array() ; 
        $primary_key = array() ; 

        foreach($result as $key => $row){ 
            $column_name = $row['name'] ; 
            $column_type = $row['type'] ; 
            $column_size = $row['size'] ; 
            $unsigned = isset($row['unsigned'])? $row['unsigned'] : false  ; 
            $not_null = isset($row['not_null'])? $row['not_null'] : false ;  
            $auto_increment = isset($row['auto_increment'])? $row['auto_increment'] : false ;  
            $default = isset($row['default'])? $row['default'] : null ;  

            $fields[$column_name] = array( 
                'type' => $column_type,
                'constraint' =>$column_size,
                'null'=> $not_null , 
                'auto_increment' => '',
                'unsigned' => '',
                'default' => '' 
            ); 

            if($row['primary_key'] == 'true'){ 
                $primary_key[] = $column_name ; 
            }
        } 

        $this->dbforge->add_field($fields) ; 
        $this->dbforge->add_key($primary_key,true) ; 
        $this->dbforge->create_table($table_name,true) ; 
    }
}

/* End of file install.php */
/* Location : ./modules/install/install.php */
