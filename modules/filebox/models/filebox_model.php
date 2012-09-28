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
			$this->db->like($search_param['option'],$search_param['value']);
			$query = $this->db->get($this->table);
			$total_rows = $this->db->count_all_results();
		}

		$pagination['page'] = $page ;
		$pagination['list_count'] = $list_count;
		$pagination['total_rows'] = $total_rows;
		$pagination['page_count'] = ceil($total_rows / $list_count);

		$result['list'] = $query->result();
		$result['pagination'] = $pagination;

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
}