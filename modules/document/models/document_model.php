<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Document_model extends CI_Model {

    var $table = 'documents';
    var $table2 = 'filebox';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct(); 
        $this->load->database();
    }

    public function insert($args){ 
        $this->db->insert('documents', $args);
    }

    public function getDocument($docu_id) {
        $this->db->select('*');
        $this->db->from('documents');
        $this->db->where('doc_id', $docu_id);

        $query = $this->db->get();
        return $query->result();
    }

    public function getDocumentList($page=1,$list_count=10,$search_param=null){
        $this->db->order_by("doc_id", "desc");
        $this->db->limit($list_count , ($page-1)*$list_count );

        if($search_param == null) {
            $query = $this->db->get($this->table);
            $total_rows = $this->db->count_all($this->table);
        }else{
            $this->db->like($search_param['search_key'],$search_param['search_keyword']);
            $query = $this->db->get($this->table);

            $this->db->like($search_param['search_key'],$search_param['search_keyword']);
            $total_rows = $this->db->count_all_results($this->table);
        }

        $pagination['page'] = $page ;
        $pagination['list_count'] = $list_count ; 
        $pagination['total_rows'] = $total_rows ; 
        $pagination['page_count'] = ceil($total_rows / $list_count) ; 

        $result['list'] = $query->result() ; 
        $result['pagination'] = $pagination ; 

            return $result ;
    }

    function total_entry_count($data)
    {
        $this->db->select('*');
        $this->db->from('SG_documents');

        if($data['key'] && $data['keyword'])
        {
            $this->db->like($data['key'], $data['keyword']);
        }
        $this->db->order_by("doc_id", "desc");

        $query = $this->db->get();
        return $query->result();
    }

    function getImageList($page=1,$list_count=10,$search_param=null){
        //$this->db->from('SG_filebox');
        $this->db->order_by("file_srl", "desc");
            $this->db->limit($list_count , ($page-1)*$list_count );
            
            if($search_param == null) {
                $query = $this->db->get($this->table2);
                $total_rows = $this->db->count_all($this->table2);
            }else{
            $this->db->like($search_param['search_key'],$search_param['search_keyword']);
            $query = $this->db->get($this->table2);

        $this->db->like($search_param['search_key'],$search_param['search_keyword']);
        $total_rows = $this->db->count_all_results();
            }
            
            $pagination['page'] = $page ;
        $pagination['list_count'] = $list_count ; 
        $pagination['total_rows'] = $total_rows ; 
        $pagination['page_count'] = ceil($total_rows / $list_count) ; 

        $result['list'] = $query->result() ; 
        $result['pagination'] = $pagination ; 
            
            return $result ;
    }


    function select_image()
    {
        $this->db->select('*');
        $this->db->from('SG_filebox');

        $query = $this->db->get();
        return $query->result();
    }
}
?>
