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

	function insert_entry($insert_data)
	{
		$this->db->insert('filebox', $insert_data);
	}

	function view_entry($source_file_name)
	{
		$this->db->select('*');
		$this->db->from('filebox');
		$this->db->where('source_file_name', $source_file_name);

		$query = $this->db->get();
		return $query->result();
	}

	function delete_entry($file_srl)
	{
		$this->db->delete('filebox', array('file_srl' => $file_srl));
	}

	//function get_entry($uid)
	function get_entry()
	{
		$this->db->select('*');
		$this->db->from('filebox');

		$query = $this->db->get();
		return $query->result();
	}

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

	function total_entry_count($data)
	{
		$this->db->select('*');
		$this->db->from('filebox');

		if($data['key'] && $data['keyword'])
		{
			$this->db->like($data['key'], $data['keyword']);
		}
		$this->db->order_by("file_srl", "desc");

		$query = $this->db->get();
		return $query->result();
	}
	

}
?>