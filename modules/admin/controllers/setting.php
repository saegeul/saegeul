<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 

class setting extends MX_Controller { 
    public function index(){
        $layout = array() ; 
        $this->load->library('admin_tmpl') ; 

        $section = array(
            'header'=>'setting/header',
            'sidebar'=>'setting/sidebar',
            'body'=>'setting/site',
            'footer'=>'setting/footer'
        ) ; 

        $str= $this->admin_tmpl->parse($section); 

        echo $str ; 

    }

    public function email(){ 
        $layout = array() ; 
        $this->load->library('admin_tmpl') ; 

        $section = array(
            'header'=>'setting/header',
            'sidebar'=>'setting/sidebar',
            'body'=>'setting/email',
            'footer'=>'setting/footer'
        ) ; 

        
        $str= $this->admin_tmpl->parse($section); 

        echo $str ; 
    }

    public function site(){

    }

    public function refreshTable(){
        $table_name = $this->input->post('table_name') ;
        $table_path = $this->input->post('table_path') ;

        $this->load->database(); 
        $this->load->dbforge() ; 

        if($this->db->table_exists($table_name)){ 
            $this->dbforge->drop_table($table_name) ; 
        } 

        $this->load->helper('file') ; 
        $this->load->library('sg_dbutil') ; 

        $f = read_file($table_path) ; 
        $result = $this->sg_dbutil->schema_parse($f) ; 
        $this->sg_dbutil->create_table($table_name , $result['columns']) ;

    }

    public function deleteTable(){ 
        $table_name = $this->input->post('table_name') ;

        $this->load->database(); 
        $this->load->dbforge() ; 

        if($this->db->table_exists($table_name)){ 
            $this->dbforge->drop_table($table_name) ; 
        } 
    }

    public function dbtable(){

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
                            $file_list[$result[0]] = array('path' => $path.'/'.$schema_list[$k] , 
                                                            'table' => $result[0], 
                                                            'is_exists' => false 
                                                    ); 
                       }
                   }
               } 
           } 
        }

        $this->load->library('sg_dbutil') ; 

        $data = array() ; 
        
        foreach($file_list as $key => $row){ 
            $file_list[$key]['is_exists'] =  $this->sg_dbutil->is_exists($row['table']) ;
        } 

        $data['schema_list']= $file_list ;
        //$this->_register_admin() ; 
        $layout = array() ; 
        $this->load->library('admin_tmpl') ; 

        $section = array(
            'header'=>'setting/header',
            'sidebar'=>'setting/sidebar',
            'body'=>'setting/dbtable',
            'footer'=>'setting/footer'
        ) ; 

        
        $str= $this->admin_tmpl->parse($section,$data); 

        echo $str ; 
    }
}

/* End of file setting.php */
/* Location : ./modules/admin/setting.php */ 
