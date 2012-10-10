<?php
class Site_model extends CI_Model {
	var $table = 'site';

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function insert($data){
		if($this->db->insert($this->table,$data)){
			$id = $this->db->insert_id();
			$data->site_srl = $id;

			return $data;
		}

		return null;
	}

	public function getFile($site_srl){
		if($file_srl > 0){
			$query = $this->db->get_where($this->table , array('site_srl'=>$site_srl));
			$arr = $query->result();
			if(count($arr)){
				return $arr[0];
			}
		}

		return null;
	}

	public function getSiteList(){
		$this->db->order_by("site_srl", "desc");
		$query = $this->db->get($this->table);
		$result['list'] = $query->result() ;

		return $result ;
	}

	public function delete($site_srl){
		$file_obj = null;
		if($site_srl > 0 ){
			$this->db->where('site_srl',$site_srl);
			$this->db->delete($this->table);
		}

		return $file_obj;
	}

	function update($data,$site_srl)
	{
		if($this->db->update($this->table,$data,array('site_srl' => $site_srl))){
			return $site_srl;
		}
		return null;
	}
}