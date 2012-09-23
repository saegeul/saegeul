<?php
class Email_model extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	function insert_entry($insert_data)
	{	
		$this->db->insert('maillog', $insert_data);
	}
	
	function countall()
	{
		return $this->db->count_all_results('maillog');
	}
	
	function get_limit($limit, $offset)
	{
		$query = $this->db->get('maillog', $limit, $offset);
		if( $query->num_rows() > 0)
			return $query->result();
		else
			return FALSE;
	}
	
}
?>