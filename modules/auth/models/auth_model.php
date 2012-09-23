<?
class Auth_model extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	function insert_entry($insert_data)
	{
		$this->db->insert('oauthtoken', $insert_data);
	}

	function view_entry($uid, $cloud_enterprise)
	{
		$this->db->select('*');
		$this->db->from('oauthtoken');
		$this->db->where('uid', $uid);
		$this->db->where('cloud_enterprise', $cloud_enterprise);

		$query = $this->db->get();
		return $query->result();
	}
	
	function update_entry($data)
	{
		$value->oauth_token = $data['mod_oauth_token'];
		$value->oauth_secret_token = $data['mod_oauth_secret_token'];
		$value->oauth_verifier = $data['mod_oauth_verifier'];
		return $this->db->update('oauthtoken', $value, array('uid' => $data['uid'], 'cloud_enterprise' => $data['cloud_enterprise']));
	}

	function delete_entry($oauth_id)
	{
		$this->db->delete('oauthtoken', array('oauth_id' => $oauth_id));
	}

	function get_entry($uid)
	{
		$this->db->select('*');
		$this->db->from('oauthtoken');
		$this->db->where('uid', $uid);
		$this->db->order_by("oauth_id", "desc");

		$query = $this->db->get();
		return $query->result();
	}
}
?>