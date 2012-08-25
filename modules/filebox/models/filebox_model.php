<?
class Filebox_model extends CI_Model {
	
	var $img_type = '';
	var $sid = '';
	var $source_img_name = '';
	var $upload_img_name = '';
	var $img_size = '';
	var $reg_date = '';
	var $ip_address = '';

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	function insert_entry($insert_data)
	{
		$this->db->insert('imagebox', $insert_data);
	}
	
	function view_entry($source_img_name)
	{
		$this->db->select('*');
		$this->db->from('imagebox');
		$this->db->where('source_img_name', $source_img_name);
		
		$query = $this->db->get();
		return $query->result();
	}
	
	function delete_entry($img_srl)
	{
		$this->db->delete('imagebox', array('img_srl' => $img_srl));
	}
	
	function select_entry($sid)
	{
		$this->db->select('*');
		$this->db->from('imagebox');
		$this->db->where('sid', $sid);
		$this->db->order_by("reg_date", "desc");
	
		$query = $this->db->get();
		return $query->result();
	}
	
}
?>