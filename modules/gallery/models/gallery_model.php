<?

class Gallery_model extends CI_Model {
	var $file_type = '';
	var $sid = '';
	var $source_file_name = '';
	var $upload_file_name = '';
	var $file_size = '';
	var $reg_date = '';
	var $ip_address = '';

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	function get_entry()
	{
		$this->db->select('*');
		$this->db->from('filebox');

		$query = $this->db->get();
		
		return $query->result();
	}

}

?>