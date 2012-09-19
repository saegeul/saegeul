<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sg_dbutil {
    var $CI ;

    public function getSchemaPathList(){ 
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
                            array_push($file_list,$path.'/'.$schema_list[$k]) ; 
                       }
                   }
               } 
           } 
        }

        return  $file_list ; 
    }

    public function schema_parse($str){
        $result = array(
            'columns'=>array()
        ) ; 


        preg_match_all('/<column\s*([^>]*)\s*\/?>/' , $str , $columns, PREG_SET_ORDER) ; 

        foreach($columns as $column){ 
            $rawAttributes = $column[1] ; 

            preg_match_all('/([^=\s]+)="([^"]+)"/',$rawAttributes,$attributes,PREG_SET_ORDER) ; 

            $attribute = array() ; 
            foreach($attributes as $attr){
                $key = $attr[1] ; 
                $value = $attr[2] ; 
                $attribute[$key] = $value ; 
            }

            $result['columns'][] = $attribute ; 
        }

        return $result ; 
    }

    public function __construct(){
        $this->CI=&get_instance() ; 
        $this->CI->load->database(); 
        $this->CI->load->dbforge() ; 
    }

    public function generate_field($field){
       
        $config = array(
                    'type'=>$field['type'], 
                    'name'=>$field['name'] 
                ) ; 

        isset($field['size'])           ? $config['constraint'] = $field['size'] : ''; 
        isset($field['default'])        ? $config['default'] = $field['default'] : ''; 
        isset($field['auto_increment']) ? $config['auto_increment'] = true : ''; 
        isset($field['unsigned'])       ? $config['unsigned'] = $field['unsigned'] : ''; 
        isset($field['not_null'])       ? $config['null'] = false : $config['null'] = true; 
         
        return $config ; 
    }

    public function create_table($table_name,$fields){
        $field_array = array() ; 
        $this->CI->load->dbforge() ; 

        foreach($fields as $key => $field){ 
            $a_field = $this->generate_field($field); 
            $column_name = $a_field['name'] ; 
            unset($a_field['name']) ; 
            $field_array[$column_name] = $a_field ; 

            if(isset($field['primary_key'])){
                $this->CI->dbforge->add_key($column_name,true) ; 
            } 
        } 

        if(! $this->CI->db->table_exists($table_name)){ 
            $this->CI->dbforge->add_field($field_array) ; 
            $this->CI->dbforge->create_table($table_name) ; 

            return true ;
        }

        return false ; 
    }
}


/* End of file Sg_dbutil.php */
/* Location: ./application/libraries/Sg_dbutil.php */
