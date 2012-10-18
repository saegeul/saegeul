<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users
 *
 * This model represents user authentication data. It operates the following tables:
 * - user account data,
 * - user profiles
 *
 * @package	Tank_auth
 * @author	Ilya Konyukhov (http://konyukhov.com/soft/)
 */
class Users extends CI_Model
{
	private $table_name			= 'users';			// user accounts
	private $profile_table_name	= 'user_profiles';	// user profiles

	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->table_name			= $ci->config->item('db_table_prefix', 'tank_auth').$this->table_name;
		$this->profile_table_name	= $ci->config->item('db_table_prefix', 'tank_auth').$this->profile_table_name;
	}

	/**
	 * Get user record by Id
	 *
	 * @param	int
	 * @param	bool
	 * @return	object
	 */
	function get_user_by_id($user_id, $activated)
	{
		$this->db->where('id', $user_id);
		$this->db->where('activated', $activated ? 1 : 0);

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}

	/**
	 * Get user record by login (username or email)
	 *
	 * @param	string
	 * @return	object
	 */
	function get_user_by_login($login)
	{
		$this->db->where('LOWER(username)=', strtolower($login));
		$this->db->or_where('LOWER(email)=', strtolower($login));

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}

	/**
	 * Get user record by username
	 *
	 * @param	string
	 * @return	object
	 */
	function get_user_by_username($username)
	{
		$this->db->where('LOWER(username)=', strtolower($username));

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}

	/**
	 * Get user record by email
	 *
	 * @param	string
	 * @return	object
	 */
	function get_user_by_email($email)
	{
		$this->db->where('LOWER(email)=', strtolower($email));

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}

	/**
	 * Check if username available for registering
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_username_available($username)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(username)=', strtolower($username));

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 0;
	}

	/**
	 * Check if email available for registering
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_email_available($email)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(email)=', strtolower($email));
		$this->db->or_where('LOWER(new_email)=', strtolower($email));

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 0;
	}

	/**
	 * Create new user record
	 *
	 * @param	array
	 * @param	bool
	 * @return	array
	 */
	function create_user($data, $activated = TRUE)
	{
		$data['created'] = date('Y-m-d H:i:s');
		$data['activated'] = $activated ? 1 : 0;

		if ($this->db->insert($this->table_name, $data)) {
			$user_id = $this->db->insert_id();
			if ($activated)	$this->create_profile($user_id);
			return array('user_id' => $user_id);
		}
		return NULL;
	}

	/**
	 * Activate user if activation key is valid.
	 * Can be called for not activated users only.
	 *
	 * @param	int
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function activate_user($user_id, $activation_key, $activate_by_email)
	{
		$this->db->select('1', FALSE);
		$this->db->where('id', $user_id);
		if ($activate_by_email) {
			$this->db->where('new_email_key', $activation_key);
		} else {
			$this->db->where('new_password_key', $activation_key);
		}
		$this->db->where('activated', 0);
		$query = $this->db->get($this->table_name);

		if ($query->num_rows() == 1) {

			$this->db->set('activated', 1);
			$this->db->set('new_email_key', NULL);
			$this->db->where('id', $user_id);
			$this->db->update($this->table_name);

			$this->create_profile($user_id);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Purge table of non-activated users
	 *
	 * @param	int
	 * @return	void
	 */
	function purge_na($expire_period = 172800)
	{
		$this->db->where('activated', 0);
		$this->db->where('UNIX_TIMESTAMP(created) <', time() - $expire_period);
		$this->db->delete($this->table_name);
	}

	/**
	 * Delete user record
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_user($user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->delete($this->table_name);
		if ($this->db->affected_rows() > 0) {
			$this->delete_profile($user_id);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Set new password key for user.
	 * This key can be used for authentication when resetting user's password.
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function set_password_key($user_id, $new_pass_key)
	{
		$this->db->set('new_password_key', $new_pass_key);
		$this->db->set('new_password_requested', date('Y-m-d H:i:s'));
		$this->db->where('id', $user_id);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Check if given password key is valid and user is authenticated.
	 *
	 * @param	int
	 * @param	string
	 * @param	int
	 * @return	void
	 */
	function can_reset_password($user_id, $new_pass_key, $expire_period = 900)
	{
		$this->db->select('1', FALSE);
		$this->db->where('id', $user_id);
		$this->db->where('new_password_key', $new_pass_key);
		$this->db->where('UNIX_TIMESTAMP(new_password_requested) >', time() - $expire_period);

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 1;
	}

	/**
	 * Change user password if password key is valid and user is authenticated.
	 *
	 * @param	int
	 * @param	string
	 * @param	string
	 * @param	int
	 * @return	bool
	 */
	function reset_password($user_id, $new_pass, $new_pass_key, $expire_period = 900)
	{
		$this->db->set('password', $new_pass);
		$this->db->set('new_password_key', NULL);
		$this->db->set('new_password_requested', NULL);
		$this->db->where('id', $user_id);
		$this->db->where('new_password_key', $new_pass_key);
		$this->db->where('UNIX_TIMESTAMP(new_password_requested) >=', time() - $expire_period);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Change user password
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function change_password($user_id, $new_pass)
	{
		$this->db->set('password', $new_pass);
		$this->db->where('id', $user_id);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Set new email for user (may be activated or not).
	 * The new email cannot be used for login or notification before it is activated.
	 *
	 * @param	int
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function set_new_email($user_id, $new_email, $new_email_key, $activated)
	{
		$this->db->set($activated ? 'new_email' : 'email', $new_email);
		$this->db->set('new_email_key', $new_email_key);
		$this->db->where('id', $user_id);
		$this->db->where('activated', $activated ? 1 : 0);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Activate new email (replace old email with new one) if activation key is valid.
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function activate_new_email($user_id, $new_email_key)
	{
		$this->db->set('email', 'new_email', FALSE);
		$this->db->set('new_email', NULL);
		$this->db->set('new_email_key', NULL);
		$this->db->where('id', $user_id);
		$this->db->where('new_email_key', $new_email_key);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Update user login info, such as IP-address or login time, and
	 * clear previously generated (but not activated) passwords.
	 *
	 * @param	int
	 * @param	bool
	 * @param	bool
	 * @return	void
	 */
	function update_login_info($user_id, $record_ip, $record_time)
	{
		$this->db->set('new_password_key', NULL);
		$this->db->set('new_password_requested', NULL);

		if ($record_ip)		$this->db->set('last_ip', $this->input->ip_address());
		if ($record_time)	$this->db->set('last_login', date('Y-m-d H:i:s'));

		$this->db->where('id', $user_id);
		$this->db->update($this->table_name);
	}

	/**
	 * Ban user
	 *
	 * @param	int
	 * @param	string
	 * @return	void
	 */
	function ban_user($user_id, $reason = NULL)
	{
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, array(
				'banned'		=> 1,
				'ban_reason'	=> $reason,
		));
	}

	/**
	 * Unban user
	 *
	 * @param	int
	 * @return	void
	 */
	function unban_user($user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, array(
				'banned'		=> 0,
				'ban_reason'	=> NULL,
		));
	}

	/**
	 * Create an empty profile for a new user
	 *
	 * @param	int
	 * @return	bool
	 */
	private function create_profile($user_id)
	{
		$this->db->set('user_id', $user_id);
		return $this->db->insert($this->profile_table_name);
	}

	/**
	 * Delete user profile
	 *
	 * @param	int
	 * @return	void
	 */
	private function delete_profile($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete($this->profile_table_name);
	}

	//admin �섏씠吏�뿉���뚯썝紐⑸줉��異쒕젰�섍린 �꾪빐 �뚯썝�뺣낫瑜�紐⑤몢 諛섑솚
	function admin_db(){ 
		
		$this->db->select('*');
		$this->db->from('users');
		
		$query = $this->db->get();
		return $query->result(); 
	}

	function select_entry($list_num,$offset,$data)
	{
		$this->db->select('*');
		$this->db->from('users');

		if($data['key'] && $data['keyword'])
		{
			$this->db->like($data['key'], $data['keyword']);
		}
		$this->db->order_by("id", "desc");
		$this->db->limit($offset, $list_num);

		$query = $this->db->get();
		return $query->result();
	}

	function total_entry_count($data)
	{
		$this->db->select('*');
		$this->db->from('users');

		
		if($data['key'] && $data['keyword'])
		{
			$this->db->like($data['key'], $data['keyword']);
		}
		$this->db->order_by("id", "desc");

		$query = $this->db->get();
		return $query->result();
	}

	//�좏깮���좎���沅뚰븳��臾댁뾿�몄� 泥댄겕(admin,manager,member,guest)
	function check_level($user_id){ 
		$this->db->select('level');
		$this->db->from('users');
		$this->db->where('id', $user_id);
		
		$query = $this->db->get();
		
		$row = $query->row(1);
		
		return $row->level; 
	}

	function min_admin($id){
		//level��admin��紐⑤뱺 �좎�瑜�寃�깋
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('level', 'admin');
		
		$query = $this->db->get();
		$row = $query->row(1);
		

		if($query->num_rows() == 1){
			//level 媛믪씠 admin���좎�媛��섎굹�닿퀬
			if($row->id ==$id){
				//�꾩옱 �섏젙�섎젮���좎�媛�諛붾줈 洹��섎굹��愿�━�먯씪 寃쎌슦 蹂�꼍 遺덇���				
				echo ("<script>alert('愿�━�먮뒗 理쒖냼 1紐��댁긽�댁뼱���⑸땲��')</script>");
				
				return false;
			}
			else{
				return true;
			}

		}
		else{
			return true;
				
		}
	}

	//諛쏆븘��媛믪쑝濡�沅뚰븳媛믪쓣 蹂�꼍
	function admin_set($id,$admin){ 

		$this->db->set('level',$admin );
		$this->db->where('id', $id);
		$this->db->update($this->table_name); 

	}

	//沅뚰븳蹂�꼍 踰꾪듉���뚮�����愿�━��>�좎�, �좎�->愿�━��濡�蹂�꼍
	function admin_value($id){
		$this->db->select('level');
		$this->db->from('users');
		$this->db->where('id', $id);
		$query = $this->db->get();
		

		$row = $query->row(1);
		if($row->level == 'admin'){
			//愿�━�먮� �좎�濡�蹂�꼍
			return 'user';
		}
		else {
			//�좎�瑜�愿�━�먮줈 蹂�꼍
			return 'admin';
		}

	}
	
	
	function req_change_password($user_id){
		$this->db->set('password_change_requested',1 );
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name);
		
		
	}
	
	function req_change_password_0($user_name){
		$this->db->set('password_change_requested',0 );
		$this->db->where('username', $user_name);
		$this->db->update($this->table_name);
	
	
	}
	
	function check_first_login($username){
		$this->db->select('password_change_requested');
		$this->db->from('users');
		$this->db->where('username', $username);
		$query = $this->db->get();
		
		
		$row = $query->row(1);
		
		if($row->password_change_requested){
			return true;
			
		}else{
			return false;
		}
		
	}

    function setAdminByEmail($email){
        $this->db->set('level','admin' );
        $this->db->set('activated',1);
		$this->db->where('email', $email);
		$this->db->update($this->table_name);
    } 
    
    function getUserList($page=1,$list_count=10,$search_param=null){
    	$this->db->order_by("id", "desc");
    	$this->db->limit($list_count , ($page-1)*$list_count );
    	 
    	if($search_param == null) {
    		$query = $this->db->get($this->table_name);
    		$total_rows = $this->db->count_all($this->table_name);
    	}else{
    		$this->db->like($search_param['search_key'],$search_param['search_keyword']);
    		$query = $this->db->get($this->table_name) ;
    		 
    		$this->db->like($search_param['search_key'],$search_param['search_keyword']);
    		$total_rows = $this->db->count_all_results($this->table_name);
    	}
    	 
    	$pagination['page'] = $page ;
    	$pagination['list_count'] = $list_count ;
    	$pagination['total_rows'] = $total_rows ;
    	$pagination['page_count'] = ceil($total_rows / $list_count) ;
    	 
    	$result['list'] = $query->result() ;
    	$result['pagination'] = $pagination ;
    	 
    	return $result ;
    }
    
    function check_emailset()
    {
    	$query = $this->db->get('email_config');
    
    
    	return $query->num_rows();
    }
    
function getSiteInfo(){
		$query = $this->db->get('site_config');
		return $query->result();
	}
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */
