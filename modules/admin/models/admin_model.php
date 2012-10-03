<?php 
class Admin_model extends CI_Model {
	

	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	

	function save_emailset($data){
		$this->db->insert('email_config', $data);
		
		
	}
}
	

?>