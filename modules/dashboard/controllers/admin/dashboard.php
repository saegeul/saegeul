<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 
class Dashboard extends MX_Controller {

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

	}

	public function index(){

	}

	public function siteCurrentStatus(){

		$data['action'] = "siteCurrentStatus";

		$result = $this->userList($page=1,$list_count=1,$level="admin");
		$data['admin'] = $result['userList'];
		$data['site'] = $this->getSiteInfo();
		$data['email'] = $this->getEmailInfo();

		$this->load->library('sg_layout');

		$this->sg_layout->layout('admin/layout');
		$this->sg_layout->module('dashboard');

		$this->sg_layout->add('admin/header');
		$this->sg_layout->add('admin/sidebar');
		$this->sg_layout->add('admin/siteStatus');
		$this->sg_layout->add('admin/footer');

		$this->sg_layout->show($data);
	}

	public function moduleCurrentStatus(){
		$data['action'] = "moduleCurrentStatus";

		$data['module'] = $this->getModuleInfo();

		$this->load->library('sg_layout');

		$this->sg_layout->layout('admin/layout');
		$this->sg_layout->module('dashboard');

		$this->sg_layout->add('admin/header');
		$this->sg_layout->add('admin/sidebar');
		$this->sg_layout->add('admin/moduleStatus');
		$this->sg_layout->add('admin/footer');

		$this->sg_layout->show($data);
	}

	public function userList($page=1,$list_count=10,$level=""){
		$this->load->model('member/users','user');

		$search_param = null;

		if($this->input->get_post('search_key') && $this->input->get_post('search_keyword')){
			$search_param = array();
			$data['search_key'] =  $search_param['search_key'] = $this->input->get_post('search_key');
			$data['search_keyword'] = $search_param['search_keyword'] = $this->input->get_post('search_keyword');
		}else{
			$data['search_key'] =  $search_param['search_key'] = $level==""?"":"level";
			$data['search_keyword'] = $search_param['search_keyword'] = $level==""?"":$level;
		}
		$result = $this->user->getUserList($page,$list_count,$search_param);

		$data['userList'] = $result['list'];
		$data['pagination'] = $result['pagination'];

		return $data;
	}

	public function getSiteInfo(){
		$this->load->model('admin_mgr/admin_model','site');

		$result = $this->site->getSiteInfo();

		return $result;
	}

	public function getEmailInfo(){
		$this->load->model('admin_mgr/admin_model','site');

		$result = $this->site->getEmailInfo();

		return $result;
	}

	public function getModuleInfo(){
		$this->load->helper('directory') ;
		$this->load->helper('file') ;
		$this->load->library('sg_dbutil') ;
		$map = directory_map('./modules',2);
		$module_list = array() ;
		$cnt = 0;
		foreach($map as $key => $row){ //modules list
			$module_info = array();
			$module_info['module_name'] = $key;
			$module_info['module_schema'] = "";
			$module_info['module_schema_cnt'] = 0;
			$module_info['module_schema_is_exists'] = 0;
			$path = './modules/'.$key.'/schemas' ;
			for($i=0 ; $i < count($row) ;$i++){
				if($row[$i] == 'schemas'){
					$xml_cnt = 0;
					$schema_list = directory_map($path);
					for($j = 0 ; $j < count($schema_list) ;$j++){
						if(strpos($schema_list[$j],'xml')){
							$module_info['module_schema_cnt'] = ++$xml_cnt;
							$result = explode('.',$schema_list[$j]);
							$module_info['module_schema'] = $module_info['module_schema'] . $result[0];
							if($j < count($schema_list) - 1)
								$module_info['module_schema'] = $module_info['module_schema'] . " , ";
							if($this->sg_dbutil->is_exists($result[0])==true)
								++$module_info['module_schema_is_exists'];
						}
					}
				}
			}
			$module_list[++$cnt] = $module_info;
		}
		return $module_list;
	}
}
