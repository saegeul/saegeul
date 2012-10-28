<?php 
class Openapi_model extends CI_Model {
	
	var $table = 'openapi';

	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
		
	public function insert($args){
		$this->db->insert($this->table, $args);
	}
	
	public function getApiList($page=1,$list_count=10,$search_param=null){
		$this->db->limit($list_count , ($page-1)*$list_count );
	
		if($search_param == null) {
			$query = $this->db->get($this->table);
			//$total_rows = $this->db->count_all($this->table);
			$total_rows = $this->db->count_all_results($this->table);
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
	
	public function delete($openapi_id){
		$api_obj = null;
		if($openapi_id > 0 ){
			$this->db->where('openapi_id',$openapi_id);
			$this->db->delete($this->table);
		}
	
		return $api_obj;
	}
	
	function update($data,$openapi_id)
	{
		if($this->db->update($this->table,$data,array('openapi_id' => $openapi_id))){
			return $openapi_id;
		}
		return null;
	}
	
}
	

?>