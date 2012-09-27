<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Document_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct(); 
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

    public function getDocumentList($list_num,$offset,$data){ 
   // public function getDocumentList(){ 
        $this->db->select('*');
        $this->db->from('SG_documents');

        if($data['key'] && $data['keyword'])
        {
            $this->db->like($data['key'], $data['keyword']);
        }
        $this->db->limit($offset, $list_num);

        $this->db->order_by("doc_id", "desc");
        $query = $this->db->get();
        return $query->result();
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


function select_image()
{
    $this->db->select('*');
    $this->db->from('SG_filebox');

    $query = $this->db->get();
    return $query->result();
}
}
?>
