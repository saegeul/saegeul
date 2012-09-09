<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Member extends MX_Controller {

    function __construct(){
        parent::__construct() ; 

        $this->load->library('form_validation') ;
		$this->load->helper('security') ;
		$this->load->library('tank_auth') ;
        $this->load->helper('url') ; 
		$this->lang->load('tank_auth') ;

    }

    public function test(){ 
        $this->load->library('email') ; 
        $this->email->to('ijaehee@gmail.com') ; 
        $this->email->from('ijaehee@gmail.com') ; 
        $this->email->subject('ijaehee@gmail.com') ; 
        $this->email->message('ijaehee@gmail.com') ; 
        $this->email->send() ; 
        //print_r($this->email) ; 
    }

    public function activate() {
		$user_id		= $this->uri->segment(3);
		$new_email_key	= $this->uri->segment(4);

		// Activate user
		if ($this->tank_auth->activate_user($user_id, $new_email_key)) {		// success
			$this->tank_auth->logout();
			$this->_show_message($this->lang->line('auth_message_activation_completed').' '.anchor('/auth/login/', 'Login'));

		} else {																// fail
			$this->_show_message($this->lang->line('auth_message_activation_failed'));
		}
	}


    public function send_again() {
		if (!$this->tank_auth->is_logged_in(FALSE)) {							// not logged in or activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->change_email(
						$this->form_validation->set_value('email')))) {			// success

					$data['site_name']	= $this->config->item('website_name', 'tank_auth');
					$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

					$this->_send_email('activate', $data['email'], $data);

					$this->_show_message(sprintf($this->lang->line('auth_message_activation_email_sent'), $data['email']));

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/send_again_form', $data);
		}
	}

    public function logout()
	{
		$this->tank_auth->logout();

		$this->_show_message($this->lang->line('auth_message_logged_out'));
	}

    public function login(){
        if ($this->tank_auth->is_logged_in()) { // logged in

        }else if($this->tank_auth->is_logged_in(FALSE)){

        } 
        $this->load->view('loginform') ; 
    }

    public function do_login(){ 
        if ($this->tank_auth->is_logged_in()) { // logged in
			redirect(''); 
		} elseif ($this->tank_auth->is_logged_in(FALSE)) { // logged in, not activated
            $this->load->view('admin/member/activation') ; 
		} 

        if(!$this->_validation_check('login')){
            redirect('admin/member/login') ; 
        } 

        $login_id = $this->security->xss_clean($this->input->post('login_id'));

        $is_success = $this->_do_login($login_id) ;

        if($is_success){ 
            redirect('admin/rss/feedlist') ; 
        }else{// success 
            $errors = $this->tank_auth->get_error_message();
			if (isset($errors['banned'])) {	// banned user
                $this->_show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);
			} elseif (isset($errors['not_activated'])) {// not activated user
			    redirect('/auth/send_again/');
		    } else {// fail
			    foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
		    } 
            redirect('admin/member/login') ; 
        }
    }

    public function join(){
        $this->load->library('tank_auth');  
        $this->load->view('joinform') ; 
    } 

    function _validation_check($action){ 
        $validation_rules = array( 
            'username'=>array('msg'=>'Username','filter'=> 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash'), 
            'email'=>array('msg'=>'Emal','filter'=> 'trim|required|xss_clean|valid_email'),
            'login_id' => array('msg'=>'Login','filter'=>'trim|required|xss_clean'),
            'password'=> array('msg'=>'Password','filter'=>'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash'),
            'confirm_password'=>array('msg'=>'Confirm_password','filter'=>'trim|required|xss_clean|matches[password]') ,
            'recaptcha_response_field'=>array('msg'=>'Confirmation Code','filter'=>'trim|xss_clean|required|callback__check_recaptcha') ,
            'captcha'=>array('msg'=>'Confirmation Code','filter'=>'trim|xss_clean|required|callback__check_captcha') 
        );

        if($action=='join'){
            $validation_field = array('username','email','password') ; 

			$captcha_registration	= $this->config->item('captcha_registration', 'tank_auth');
			$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');

			if ($captcha_registration) {
                $use_recaptcha ? array_push($validation_field,'recaptcha_response_field'):array_push($validation_field,'captcha');
            }

        }else if($action=='login'){ 
            $login_id = $this->security->xss_clean($this->input->post('login_id'));

            $validation_field = array('login_id','password') ; 
            $use_recaptcha = $this->config->item('use_recaptcha', 'tank_auth'); 
            if($this->tank_auth->is_max_login_attempts_exceeded($login_id)){ 
                $use_recaptcha ? array_push($validation_field,'recaptcha_response_field'):array_push($validation_field,'captcha');
            } 
        } 

        foreach($validation_field as $field){
            $rule = $validation_rules[$field] ;
            $this->form_validation->set_rules($field,$rule['msg'],$rule['filter']); 
        } 

        return $this->form_validation->run() ; 
    }

    function _check_logged_in(){
        if ($this->tank_auth->is_logged_in()) {// logged in
			redirect(''); 
		}
        
        if ($this->tank_auth->is_logged_in(FALSE)) {// logged in, not activated
			redirect('/auth/send_again/'); 
		}
    }

    public function do_join(){
        if($this->tank_auth->is_logged_in()){ 
           // 이미 로그인 되어있다면?  
        } 
        
        if (!$this->config->item('allow_registration', 'tank_auth')) {// registration is off
			$this->_show_message($this->lang->line('auth_message_registration_disabled')); 
		} 

        $email_activation = $this->config->item('email_activation', 'tank_auth');
        $use_username = $this->config->item('use_username', 'tank_auth'); 

	    if (!$this->_validation_check('join')) {// validation false
            $this->load->view('admin/member/joinform') ; 
        } 

        $data = $this->tank_auth->create_user(
		    $this->form_validation->set_value('username') ,
		    $this->form_validation->set_value('email'),
			$this->form_validation->set_value('password'),
			$email_activation) ; 

        if (is_null($data)) { 
	        $data['errors'] = array();
            $errors = $this->tank_auth->get_error_message();
			foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
        } 

        if($email_activation){ 
            $this->_email_activation($data); 
        } 
    }

    function _send_email($type, $email, &$data) {
		$this->load->library('email');
		$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->to($email);
		$this->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $this->config->item('website_name', 'tank_auth')));
		$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
		$this->email->send();
	}


    function _email_activation(&$data){
        $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600; 
	    $this->_send_email('activate', $data['email'], $data); 
		unset($data['password']); // Clear password (just for any case) 
    } 
    
    function _create_recaptcha() {
		$this->load->helper('recaptcha');

		// Add custom theme so we can get only image
		$options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

		// Get reCAPTCHA JS and non-JS HTML
		$html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'));

		return $options.$html;
	} 

    function _create_captcha() {
		$this->load->helper('captcha');

		$cap = create_captcha(array(
			'img_path'		=> './'.$this->config->item('captcha_path', 'tank_auth'),
			'img_url'		=> base_url().$this->config->item('captcha_path', 'tank_auth'),
			'font_path'		=> './'.$this->config->item('captcha_fonts_path', 'tank_auth'),
			'font_size'		=> $this->config->item('captcha_font_size', 'tank_auth'),
			'img_width'		=> $this->config->item('captcha_width', 'tank_auth'),
			'img_height'	=> $this->config->item('captcha_height', 'tank_auth'),
			'show_grid'		=> $this->config->item('captcha_grid', 'tank_auth'),
			'expiration'	=> $this->config->item('captcha_expire', 'tank_auth'),
		));

		// Save captcha params in session
		$this->session->set_flashdata(array(
				'captcha_word' => $cap['word'],
				'captcha_time' => $cap['time'],
		));

		return $cap['image'];
	}
	
	function _check_recaptcha() {
		$this->load->helper('recaptcha');

		$resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'tank_auth'),
				$_SERVER['REMOTE_ADDR'],
				$_POST['recaptcha_challenge_field'],
				$_POST['recaptcha_response_field']);

		if (!$resp->is_valid) {
			$this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

    function _do_login(){
        $login_by_username = ($this->config->item('login_by_username', 'tank_auth') AND $this->config->item('use_username', 'tank_auth')); 
        $login_by_email = $this->config->item('login_by_email', 'tank_auth');; 

        $is_success = $this->tank_auth->login(
		    $this->form_validation->set_value('login_id'),
			$this->form_validation->set_value('password'),
			$this->form_validation->set_value('remember'),
			$login_by_username,
			$login_by_email) ;

        return $is_success ; 
    }

    function _check_captcha($code) {
		$time = $this->session->flashdata('captcha_time');
		$word = $this->session->flashdata('captcha_word');

		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);

		if ($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
			return FALSE;

		} elseif (($this->config->item('captcha_case_sensitive', 'tank_auth') AND
				$code != $word) OR
				strtolower($code) != strtolower($word)) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

    function _show_message($message) {
		$this->session->set_flashdata('message', $message);
		redirect('/auth/');
	} 
} 

/* End of file member.php */
/* Location: ./application/controllers/admin/member.php */
