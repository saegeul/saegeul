<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 

class setting extends MX_Controller { 
    public function index(){
       $this->site();

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
    
    public function setupEmail(){
    	
    	$params = array(
    			'email'=>'',
    			'email_protocol'=>'',
    			'email_path'=>'',
    			'smtp_port'=>'',
    			'smtp_host'=>'',
    			'smtp_pass'=>''
    	    	);
    
    	
    	$email = $this->input->post('email_addr') ;
    	$email_protocol = $this->input->post('email_protocol') ;
    	$email_path = $this->input->post('email_lib_path') ;
    	$smtp_port = $this->input->post('email_smtp_port') ;
    	$smtp_host = $this->input->post('email_smtp_host') ;
    	$smtp_pass = $this->input->post('email_pw') ;
    	    	
    
    	$params['email'] = $email ;
    	$params['email_protocol'] = $email_protocol ;
    	$params['email_path'] = $email_path ;
    	$params['smtp_port'] = $smtp_port ;
    	$params['smtp_host'] = $smtp_host ;
    	$params['smtp_pass'] = $smtp_pass ;
    	 
    	 $this->load->model('admin_model') ;
    	 $this->admin_model->save_emailset($params); 
    
    	$this->load->helper('file') ;
    	$f = read_file('./modules/admin/files/email.txt') ;
    
    	foreach($params as $key => $value){
    		$f = str_replace('{'.$key.'}', $value ,$f);
    	}
    
    	write_file(APPPATH.'config/email.php',$f) ;
    	
    	$this->load->library('admin_tmpl') ;
    	
    	$section = array(
    			'header'=>'setting/header',
    			'sidebar'=>'setting/sidebar',
    			'body'=>'setting/general_message',
    			'footer'=>'setting/footer'
    	) ;
    	
    	$str= $this->admin_tmpl->parse($section);
    	
    	echo $str ;
    	
    	
    	
    }
    
    
    
    
    

    public function site(){
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
    
    public function setupSite(){
    	 
    	$params = array(
    			'title'=>'',
    			'site_url'=>'',
    			'on_register'=>''
    			
    	);
    
    	 
    	$site_name = $this->input->post('site_name') ;
    	$site_url = $this->input->post('site_url') ;
    	$join_available = $this->input->post('join_available') ;
    
    	$params['title'] = $site_name ;
    	$params['site_url'] = $site_url ;
    	$params['on_register'] = $join_available ;
    	
    	$this->load->model('admin_model') ;
      $this->admin_model->save_siteset($params);
    
    	/* $this->load->helper('file') ;
    	$f = read_file('./modules/admin/files/email.txt') ;
    
    	foreach($params as $key => $value){
    		$f = str_replace('{'.$key.'}', $value ,$f);
    	}
    
    	write_file(APPPATH.'config/email.php',$f) ;
     */	 
    	 $this->load->library('admin_tmpl') ;
    	
    	$section = array(
    			'header'=>'setting/header',
    			'sidebar'=>'setting/sidebar',
    			'body'=>'setting/general_message',
    			'footer'=>'setting/footer'
    	) ;
    	
    	$str= $this->admin_tmpl->parse($section);
    	
    	echo $str ;
    	 
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

function showshow($message)
{

	$this->session->set_flashdata('message', $message);
	


	
	$this->load->library('admin_tmpl') ;
	 
	$section = array(
			'header'=>'setting/header',
			'sidebar'=>'setting/sidebar',
			'body'=>'setting/general_message',
			'footer'=>'setting/footer'
	) ;
	 
	$str= $this->admin_tmpl->parse($section, array('message' => $message));
	 
	echo $str ;
	 
	 
	
}

/* End of file setting.php */
/* Location : ./modules/admin/setting.php */ 
