<?php
class Sitemap_model extends CI_Model {
	var $table = 'sitemap';

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

	public function getSite($site_srl){
		if($site_srl > 0){
			$query = $this->db->get_where($this->table , array('site_srl'=>$site_srl));
			$arr = $query->result();
			if(count($arr)){
				return $arr[0];
			}
		}

		return null;
	}

	public function getChildSiteList($parent_site_srl){
		$query = $this->db->get_where($this->table , array('parent_site_srl'=>$parent_site_srl));
		$result['list'] = $query->result();

		return $result ;
	}

	public function getSiteList(){
		$this->db->where('parent_site_srl',0);
		//$this->db->order_by("site_srl", "desc");
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