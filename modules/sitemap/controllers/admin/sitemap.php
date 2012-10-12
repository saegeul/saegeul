<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Sitemap extends MX_Controller {

	// DB isert user information
	protected $username;
	protected $email;
	protected $uid;

	// class construct
	public function __construct() {
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->library('tank_auth');

		// get session data
		$this->username = $this->tank_auth->get_username();
		$this->uid = $this->tank_auth->get_user_id();
		$this->email = $this->tank_auth->get_useremail();

		// check direct acess
		if($this->uid == "")
			redirect('member/login', 'refresh');
	}

	public function siteMap(){
		$data['action'] = 'SiteMap';
		$this->load->model('Sitemap/Sitemap_model','sitemap');

		$result = $this->sitemap->getSiteList();
		$data['siteMapList'] = $result['list'];

		$this->load->library('sg_layout');

		$this->sg_layout->layout('admin/layout');
		$this->sg_layout->module('sitemap');

		$this->sg_layout->add('admin/header');
		$this->sg_layout->add('admin/sidebar');
		$this->sg_layout->add('admin/siteMap');
		$this->sg_layout->add('admin/footer');

		$this->sg_layout->show($data);
	}

	public function saveMenu(){
		$this->load->model('Sitemap/Sitemap_model','sitemap');

		$parent_site_srl = $this->input->get_post('site_srl');

		$data->menuName = $this->input->get_post('menuName');
		$data->moduleOrLinUrl = $this->input->get_post('moduleOrLinUrl');
		$data->moduleValue = $this->input->get_post('moduleValue');
		$data->moduleId = $this->input->get_post('moduleId');
		$data->menuIsValid = $this->input->get_post('menuIsValid');

		$module = $this->grouppingParam($data);

		$args->site_name = isset($module->site_name)?$module->site_name:"";
		$args->site_module = isset($module->site_module)?$module->site_module:"";
		$args->site_module_id = isset($module->site_module_id)?$module->site_module_id:"";
		$args->site_url = isset($module->site_url)?$module->site_url:"";
		$args->parent_site_srl = $parent_site_srl?$parent_site_srl:0;
		$args->is_Valid = isset($module->is_valid)?$module->is_valid:"";
		$args->reg_date = standard_date('DATE_ATOM',time());
		$args->uid = $this->uid;
		$args->username = $this->username;
		$args->email = $this->email;
		$args->ip_address = $this->input->ip_address();

		// insert file information in DB
		$ret_data = $this->sitemap->insert($args) ;

		return json_encode(array($ret_data));
	}

	public function grouppingParam($param){
		$ret;
		switch ($param->moduleOrLinUrl) {
			case 1:
				if($param->moduleValue == "document")
					$ret->site_url = base_url() . "document/admin/document/document_list";
				else if($param->moduleValue == "file")
					$ret->site_url = base_url() . "filebox/admin/filebox/uploadForm";
				else if($param->moduleValue == "page")
					$ret->site_url = base_url() . "page/admin/page/createPage";
				$ret->site_module_id = $param->moduleId;
				$ret->site_module = $param->moduleValue;
				break;
			case 2:
				if($param->moduleValue == "document")
					$ret->site_url = base_url() . "document/admin/document/document_list";
				else if($param->moduleValue == "file")
					$ret->site_url = base_url() . "filebox/admin/filebox/uploadForm";
				else if($param->moduleValue == "page")
					$ret->site_url = base_url() . "page/admin/page/createPage";
				break;
			case 3:
				$ret->site_module = "link";
				$ret->site_url = $param->moduleValue;
				break;
			default:
				break;
		}
		$ret->is_valid = $param->menuIsValid;
		$ret->site_name = $param->menuName;

		return $ret;
	}

	public function deleteMenu(){
		$site_srl = $this->input->get_post('site_srl');

		// load sitemap model
		$this->load->model('Sitemap/Sitemap_model','sitemap');
		// insert file information in DB
		$ret_data = $this->sitemap->delete($site_srl) ;

		return json_encode(array($ret_data));
	}

	public function getMenu(){
		$site_srl = $this->input->get_post('site_srl');

		// load sitemap model
		$this->load->model('Sitemap/Sitemap_model','sitemap');
		$menu_obj = $this->sitemap->getSite($site_srl);

		echo json_encode($menu_obj);
	}

	public function getChildMenu(){
		$parent_site_srl = $this->input->get_post('parent_site_srl');

		// load sitemap model
		$this->load->model('Sitemap/Sitemap_model','sitemap');
		$result = $this->sitemap->getChildSiteList($parent_site_srl);

		$data['list'] = $result['list'];

		echo json_encode($data);
	}

	public function modifyMenu(){
		$this->load->model('Filebox/Filebox_model','filebox') ;

		// get modify data
		$file_srl = $this->input->get_post('file_srl');
		$data['original_file_name'] = $this->input->get_post('original_file_name');
		$data['isvalid'] = $this->input->get_post('isvalid');
		$data['tag'] = $this->input->get_post('tag');

		$this->filebox->update($data,$file_srl);

		if($this->input->get_post('tag') != ""){
			$args;
			$args->tag = $data['tag'];
			$args->file_srl = $file_srl;
			$args->reg_date = standard_date('DATE_ATOM',time());//date("Y-m-d H:i:s",time());
			$args->username = $this->username;
			$args->email = $this->email;
			$args->uid = $this->uid;

			// insert file information in DB
			$ret_data = $this->filebox->insert_tag($args,'filetag') ;
		}

		echo json_encode('success');
	}
}