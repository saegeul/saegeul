<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ; 

class setting extends MX_Controller {
	// DB isert user information
	protected $username;
	protected $email;
	protected $uid;

	function __construct()
	{
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

	public function index(){
		$this->site();

	}

	public function email(){
		$this->load->library('sg_layout') ;

		$this->sg_layout->layout('admin/layout') ;
		$this->sg_layout->module('admin_mgr') ;

		$this->sg_layout->add('setting/header') ;
		$this->sg_layout->add('setting/sidebar') ;
		$this->sg_layout->add('setting/email') ;
		$this->sg_layout->add('setting/footer') ;
		 
		$this->load->model('admin_model') ;

		$data = array() ;


		$data['set_info']='';


		foreach ($this->admin_model->getEmailInfo() as $row)
		{

			$data['set_info']=$row;
		}

		 

		$data['action'] = 'email' ;
		$this->sg_layout->show($data) ;
	}

	public function setupEmail(){
			
		$params = array(
				'email'=>'',
				'email_protocol'=>'',
				'email_path'=>'',
				'smtp_port'=>'',
				'smtp_host'=>'',
				'smtp_pass'=>''
		);

			
		$email = $this->input->post('email') ;
		$email_protocol = $this->input->post('email_protocol') ;
		$email_path = $this->input->post('email_lib_path') ;
		$smtp_port = $this->input->post('smtp_port') ;
		$smtp_host = $this->input->post('smtp_host') ;
		$smtp_pass = $this->input->post('smtp_pass') ;


		$params['email'] = $email ;
		$params['email_protocol'] = $email_protocol ;
		$params['email_path'] = $email_path ;
		$params['smtp_port'] = $smtp_port ;
		$params['smtp_host'] = $smtp_host ;
		$params['smtp_pass'] = $smtp_pass ;

		$this->load->model('admin_model') ;
		$this->admin_model->save_emailset($params);

		$this->load->helper('file') ;
		$f = read_file('./modules/admin_mgr/files/email.txt') ;

		foreach($params as $key => $value){
			$f = str_replace('{'.$key.'}', $value ,$f);
		}

		write_file(APPPATH.'config/email.php',$f) ;
			
		$this->load->library('sg_layout') ;

		$this->sg_layout->layout('admin/layout') ;
		$this->sg_layout->module('admin_mgr') ;

		$this->sg_layout->add('setting/header') ;
		$this->sg_layout->add('setting/sidebar') ;
		$this->sg_layout->add('setting/general_message') ;
		$this->sg_layout->add('setting/footer') ;
		$data = array() ;
		$data['action'] = 'email' ;
		$this->sg_layout->show($data) ;
			
	}

    public function site(){
		$this->load->library('sg_layout') ;

		$this->sg_layout->layout('admin/layout') ;
		$this->sg_layout->module('admin_mgr') ;

		$this->sg_layout->add('setting/header') ;
		$this->sg_layout->add('setting/sidebar') ;
		$this->sg_layout->add('setting/site') ;
		$this->sg_layout->add('setting/footer') ;

		$this->load->model('admin_model') ;

		$data = array() ;
		
		$ret_data = $this->admin_model->getsiteInfo();
		// pilter return data
		$ret = $this->getSiteInfo($ret_data);

		$data['set_info']=$ret;
		
// 		foreach ($this->admin_model->getsiteInfo() as $row)
// 		{

// 			$data['set_info']=$row;
// 		}


		$data['action'] = 'site' ;


		$this->sg_layout->show($data) ;
	}
	
	public function getSiteInfo($param){
		$ret->title = isset($param[0]->title)?$param[0]->title:"" ;
		$ret->site_url = isset($param[0]->site_url)?$param[0]->site_url:"" ;
		$ret->on_register = isset($param[0]->on_register)?$param[0]->on_register:"";
		
		return $ret ;
	}

	public function setupSite(){

		$params = array(
				'title'=>'',
				'site_url'=>'',
				'on_register'=>''
					
		);


		$site_name = $this->input->post('site_name') ;
		$site_url = $this->input->post('site_url') ;
		$join_available = $this->input->post('join_available') ;

		$params['title'] = $site_name ;
		$params['site_url'] = $site_url ;
		$params['on_register'] = $join_available ;
			
		$this->load->model('admin_model') ;
		$this->admin_model->save_siteset($params);

		/* $this->load->helper('file') ;
		 $f = read_file('./modules/admin/files/email.txt') ;

		foreach($params as $key => $value){
		$f = str_replace('{'.$key.'}', $value ,$f);
		}

		write_file(APPPATH.'config/email.php',$f) ;
		*/
		$this->load->library('sg_layout') ;

		$this->sg_layout->layout('admin/layout') ;
		$this->sg_layout->module('admin_mgr') ;

		$this->sg_layout->add('setting/header') ;
		$this->sg_layout->add('setting/sidebar') ;
		$this->sg_layout->add('setting/general_message') ;
		$this->sg_layout->add('setting/footer') ;

		$data = array() ;
		$data['action'] = 'site' ;
		$this->sg_layout->show($data) ;

	}


	public function refreshTable(){
		$table_name = $this->input->post('table_name') ;
		$table_path = $this->input->post('table_path') ;

		$this->load->database();
		$this->load->dbforge() ;

		if($this->db->table_exists($table_name)){
			$this->dbforge->drop_table($table_name) ;
		}

		$this->load->helper('file') ;
		$this->load->library('sg_dbutil') ;

		$f = read_file($table_path) ;
		$result = $this->sg_dbutil->schema_parse($f) ;
		$this->sg_dbutil->create_table($table_name , $result['columns']) ;

	}

	public function deleteTable(){
		$table_name = $this->input->post('table_name') ;

		$this->load->database();
		$this->load->dbforge() ;

		if($this->db->table_exists($table_name)){
			$this->dbforge->drop_table($table_name) ;
		}
	}

	public function openapi(){
		$this->load->library('sg_layout') ;

		$this->sg_layout->layout('admin/layout') ;
		$this->sg_layout->module('admin_mgr') ;

		$this->sg_layout->add('setting/header') ;
		$this->sg_layout->add('setting/sidebar') ;
		$this->sg_layout->add('setting/openapi') ;
		$this->sg_layout->add('setting/footer') ;

		$data = array() ;
		$data['action'] = 'openapi' ;
		$result = $this->getOpenApiList();
		$data['api_key_list'] = $result['openApiList'];

		$this->sg_layout->show($data) ;
	}

	public function dbtable(){

		$this->load->helper('directory') ;
		$this->load->helper('file') ;
		$map = directory_map('./modules',2);


		$schema_list = array() ;
		$file_list = array() ;

		foreach($map as $key => $row){ //modules list
			$dir_max = count($row) ;
			$path = './modules/'.$key.'/schemas' ;

			for($i=0 ; $i < $dir_max ;$i++){
				if($row[$i] == 'schemas'){
					$schema_list = directory_map($path) ;
					for($k = 0 ; $k < count($schema_list) ;$k++){
						if(strpos($schema_list[$k],'xml')){
							$result = explode('.',$schema_list[$k]);
							$file_list[$result[0]] = array('path' => $path.'/'.$schema_list[$k] ,
									'table' => $result[0],
									'is_exists' => false
							);
						}
					}
				}
			}
		}

		$this->load->library('sg_dbutil') ;

		$data = array() ;

		foreach($file_list as $key => $row){
			$file_list[$key]['is_exists'] =  $this->sg_dbutil->is_exists($row['table']) ;
		}

		$data['schema_list']= $file_list ;
		//$this->_register_admin() ;
		$this->load->library('sg_layout') ;

		$this->sg_layout->layout('admin/layout') ;
		$this->sg_layout->module('admin_mgr') ;

		$this->sg_layout->add('setting/header') ;
		$this->sg_layout->add('setting/sidebar') ;
		$this->sg_layout->add('setting/dbtable') ;
		$this->sg_layout->add('setting/footer') ;

		$data['action'] = 'dbtable' ;

		$this->sg_layout->show($data) ;
	}

	public function getOpenApiList($page=1,$list_count=30){
		$this->load->model('Openapi/Openapi_model','openapi');

		$search_param = null;
		$data['search_key'] = '';
		$data['search_keyword'] = '';

		if($this->input->get_post('search_key') && $this->input->get_post('search_keyword')){
			$search_param = array();
			$data['search_key'] =  $search_param['search_key'] = $this->input->get_post('search_key');
			$data['search_keyword'] = $search_param['search_keyword'] = $this->input->get_post('search_keyword');
		}
		$result = $this->openapi->getApiList($page,$list_count,$search_param);

		$data['openApiList'] = $result['list'];
		$data['pagination'] = $result['pagination'];

		return $data;
	}

	function resisterOpenApi() {
		$this->load->model('Openapi/Openapi_model','openapi');
		
		$args->provider = $this->input->get('provider');
		$args->api_key = $this->input->get('api_key');
		$args->secret_key = $this->input->get('secret_key');
		$args->username = $this->username;
		$args->email = $this->email;
		$args->uid = $this->uid;
		$args->regdate = standard_date('DATE_ATOM',time());;
		$args->ip_address = $this->input->ip_address();

		// insert file information in DB
		$ret_data = $this->openapi->insert($args);

		return json_encode(array($ret_data));
	}
	
	public function deleteOpenApi(){
		$openapi_id = $this->input->get_post('openapi_id');
	
		// load sitemap model
		$this->load->model('Openapi/Openapi_model','openapi');
		// insert file information in DB
		$ret_data = $this->openapi->delete($openapi_id) ;
	
		return json_encode(array($ret_data));
	}
	
	public function modifyOpenApi() {
		$this->load->model('Openapi/Openapi_model','openapi');

		// get modify data
		$openapi_id = $this->input->get_post('openapi_id');
		$data['provider'] = $this->input->get_post('provider');
		$data['api_key'] = $this->input->get_post('api_key');
		$data['secret_key'] = $this->input->get_post('secret_key');

		$this->openapi->update($data,$openapi_id);

		echo json_encode('success');
	}
	
	public function blog(){
		$this->load->library('sg_layout') ;
	
		$this->sg_layout->layout('admin/layout') ;
		$this->sg_layout->module('admin_mgr') ;
	
		$this->sg_layout->add('setting/header') ;
		$this->sg_layout->add('setting/sidebar') ;
		$this->sg_layout->add('setting/blog') ;
		$this->sg_layout->add('setting/footer') ;
			
		$this->config->load('blog', FALSE, TRUE);
	
		$data = array() ;	
		$data['listCount'] = $this->config->item('listCount');
		$data['rssCount'] = $this->config->item('rssCount');
		$data['facebookId'] = $this->config->item('facebookId');
		$data['commentCount'] = $this->config->item('commentCount');
		$data['commentWidth'] = $this->config->item('commentWidth');
		$data['theme'] = $this->config->item('theme');
		$data['naverApiKey'] = $this->config->item('naverApiKey');
	
		$data['action'] = 'blog' ;
		$this->sg_layout->show($data) ;
	}
	
	public function setBlog() {
		$params = array(
				'listCount'=>'',
				'rssCount'=>'',
				'facebookId'=>'',
				'commentCount'=>'',
				'commentWidth'=>'',
				'theme'=>'',
				'naverApiKey'=>''
		);
		
		$listCount = $this->input->get_post('list_count');
		$rssCount = $this->input->get_post('rss_count');
		$facebookId = $this->input->get_post('facebook_id');
		$commentCount = $this->input->get_post('comment_count');
		$commentWidth = $this->input->get_post('comment_width');
		$theme = $this->input->get_post('theme');
		$naverApiKey = $this->input->get_post('naverApiKey');
		
		$params['listCount'] = $listCount;
		$params['rssCount'] = $rssCount;
		$params['facebookId'] = $facebookId;
		$params['commentCount'] = $commentCount;
		$params['commentWidth'] = $commentWidth;
		$params['theme'] = $theme;
		$params['naverApiKey'] = $naverApiKey;
		
		$this->load->helper('file') ;
		$f = read_file('./modules/admin_mgr/files/blog.txt') ;
		
		foreach($params as $key => $value){
			$f = str_replace('{'.$key.'}', $value ,$f);
		}
		
		write_file(APPPATH.'config/blog.php',$f) ;
		echo json_encode('success');
	}
}

/* End of file setting.php */
/* Location : ./modules/admin/setting.php */
