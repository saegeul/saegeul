<?

class Gallery_model extends CI_Model {
	var $table = 'filebox';
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

	public function getFileList($page=1,$list_count=10,$search_param=null){
		$this->db->order_by("file_srl", "desc");
		$this->db->limit($list_count , ($page-1)*$list_count );
	
		if($search_param == null) {
			$query = $this->db->get($this->table);
			$total_rows = $this->db->count_all($this->table);
		}else{
			$this->db->like($search_param['search_key'],$search_param['search_keyword']);
			$query = $this->db->get($this->table);
	
			$this->db->like($search_param['search_key'],$search_param['search_keyword']);
			$total_rows = $this->db->count_all_results($this->table);
		}
	
		$pagination['page'] = $page ;
		$pagination['list_count'] = $list_count ;
		$pagination['total_rows'] = $total_rows ;
		$pagination['page_count'] = ceil($total_rows / $list_count) ;
	
		$result['list'] = $query->result() ;
		$result['pagination'] = $pagination ;
	
		return $result ;
	}
}

?>