<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Site extends MX_Controller {

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

	public function setSiteMap(){
		$data['action'] = 'siteMap';
		$this->load->model('Site/Site_model','site');

		$result = $this->site->getSiteList();
		$data['siteList'] = $result['list'];

		$this->load->library('sg_layout');

		$this->sg_layout->layout('admin/layout');
		$this->sg_layout->module('site');

		$this->sg_layout->add('admin/header');
		$this->sg_layout->add('admin/sidebar');
		$this->sg_layout->add('admin/siteMap');
		$this->sg_layout->add('admin/footer');

		$this->sg_layout->show($data);
	}

	public function saveMenu(){
		// load filebox model
		$this->load->model('Site/Site_model','site');

		$data->module_sel = $this->input->get_post('module_sel');
		$data->menu_name = $this->input->get_post('menu_name');
		$data->module_val = $this->input->get_post('module_val');

		$module = $this->setSiteModule($data);

		$args->site_name = $module->site_name;
		$args->site_module = $module->site_module;
		$args->site_url = $module->site_url;
		$args->reg_date = standard_date('DATE_ATOM',time());;
		$args->uid = $this->uid;
		$args->username = $this->username;
		$args->email = $this->email;
		$args->ip_address = $this->input->ip_address();

		// insert file information in DB
		$ret_data = $this->site->insert($args) ;

		return json_encode(array($ret_data));
	}
	
	public function deleteMenu(){
		// load filebox model
		$this->load->model('Site/Site_model','site');
	
		$site_srl = $this->input->get_post('site_srl');
	
		// insert file information in DB
		$ret_data = $this->site->delete($site_srl) ;
	
		return json_encode(array($ret_data));
	}
	
	public function setSiteModule($param){
		$ret;
		switch ($param->module_sel) {
			case 1:
				if($param->module_val == "document")
					$ret->site_url = base_url() . "document/admin/document/document_list";
				else if($param->module_val == "file")
					$ret->site_url = base_url() . "filebox/admin/filebox/uploadForm";
				else if($param->module_val == "page")
					$ret->site_url = base_url() . "page/admin/page/createPage";
				break;
			case 2:
				if($param->module_val == "document")
					$ret->site_url = base_url() . "document/admin/document/document_list";
				else if($param->module_val == "file")
					$ret->site_url = base_url() . "filebox/admin/filebox/uploadForm";
				else if($param->module_val == "page")
					$ret->site_url = base_url() . "page/admin/page/createPage";
				break;
			case 3:
				$ret->site_module = "LinkURL/" . $param->module_val;
				break;
			default:
				break;
		}
		$ret->site_url = $param->module_val;
		$ret->site_name = $param->menu_name;

		return $ret;
	}
}