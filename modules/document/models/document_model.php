<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Document_model extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
        function index()
        {

        }
/*
	function select_entry($list_num,$offset,$data)
	{
		$this->db->select('*');
		$this->db->from('filebox');

		if($data['key'] && $data['keyword'])
		{
			$this->db->like($data['key'], $data['keyword']);
		}
		$this->db->order_by("file_srl", "desc");
		$this->db->limit($offset, $list_num);

		$query = $this->db->get();
		return $query->result();
	}
*/

	function select_image()
	{
		$this->db->select('*');
		$this->db->from('SG_filebox');

		$query = $this->db->get();
		return $query->result();
	}
}
?>
