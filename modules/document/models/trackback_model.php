<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Trackback_model extends CI_Model {

	var $table = 'trackbacks';

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
	}
	
	function insert($data)
	{
		if($this->db->insert($this->table,$data)){
			$id = $this->db->insert_id();
			$data->tb_id = $id;
		
			return $data;
		}
		
		return null;
	}
	
}
?>