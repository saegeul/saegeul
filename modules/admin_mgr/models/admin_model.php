<?php 
class Admin_model extends CI_Model {
	

	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	

	function save_emailset($data){
		$this->db->empty_table('email_config');
		$this->db->insert('email_config', $data);
				
	}
	
	function save_siteset($data){
		$this->db->empty_table('site_config');
		$this->db->insert('site_config', $data);
	
	}
	
	function getSiteInfo(){
		$query = $this->db->get('site_config');
		$row = $query->row(1);
	
		return $row;
		
	}
	
	function getEmailInfo(){
		$query = $this->db->get('email_config');
		$row = $query->row(1);
	
		return $row;
	}
	
	
}
	

?>