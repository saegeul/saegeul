<?php
class Filebox_model extends CI_Model {
	var $table = 'filebox';

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function insert($data){
		if($this->db->insert($this->table,$data)){
			$id = $this->db->insert_id();
			$data->file_srl = $id;

			return $data;
		}

		return null;
	}

	public function getFile($file_srl){
		if($file_srl > 0){
			$query = $this->db->get_where($this->table , array('file_srl'=>$file_srl));
			$arr = $query->result();
			if(count($arr)){
				return $arr[0];
			}
		}

		return null;
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

	public function delete($file_srl){
		$file_obj = null;
		if($file_srl > 0 ){
			$file_obj = $this->getFile($file_srl);
			$this->db->where('file_srl',$file_srl);
			$this->db->delete($this->table);
		}

		return $file_obj;
	}

	function update($data,$file_srl)
	{
		if($this->db->update($this->table,$data,array('file_srl' => $file_srl))){
			return $file_srl;
		}
		return null;
	}

	public function insert_tag($data,$table){
		foreach($data as $key => $tag) {
			$this->db->insert($table,$tag);
		}
		return $data;
	}

	function select_tag($uid,$table)
	{
		$this->db->select('*');
		$this->db->select('count(*) as total');

		$this->db->from($table);
		$this->db->where('uid', $uid);
		$this->db->group_by("tag");
		$query = $this->db->get();

		return $query->result();
	}
}