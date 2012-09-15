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

	function get_entry($sid)
	{
		$this->db->select('*');
		$this->db->from('imagebox');
		$this->db->where('sid', $sid);
		$this->db->order_by("img_srl", "desc");

		$query = $this->db->get();
		return $query->result();
	}

	function select_entry($list_num,$offset,$data)
	{
		$this->db->select('*');
		$this->db->from('imagebox');

		if($data['key'] && $data['keyword'])
		{
			$this->db->like($data['key'], $data['keyword']);
		}
		$this->db->order_by("img_srl", "desc");
		$this->db->limit($offset, $list_num);

		$query = $this->db->get();
		return $query->result();
	}

	function total_entry_count($data)
	{
		$this->db->select('*');
		$this->db->from('imagebox');

		if($data['key'] && $data['keyword'])
		{
			$this->db->like($data['key'], $data['keyword']);
		}
		$this->db->order_by("img_srl", "desc");

		$query = $this->db->get();
		return $query->result();
	}

	function update_entry($data)
	{
		$value->upload_img_name = $data['mod_name'];
		$value->comment = $data['mod_comment'];
		$value->isvalid = $data['mod_isvalid'];

		return $this->db->update('imagebox', $value, array('img_srl' => $data['mod_no']));
	}
	
	function down_update_entry($data)
	{
		$value->down_cnt = $data['mod_down_cnt'];
		return $this->db->update('imagebox', $value, array('img_srl' => $data['mod_no']));
	}
}
?>