<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class LoginManager {
	
	private $_ci;
	private $_cookie;
	private $_user;
	private $_userModel;
	
	public function __construct($userModel = 'memberspace/user') {
		if(!$userModel) {
			$userModel = 'memberspace/user';
		}
		$this->_ci =& get_instance();
		$this->_ci->load->helper('cookie');
		$this->_ci->load->helper('flashmessages/flashmessages');
		$this->_ci->load->library('session');
		
		$this->setUserModel($userModel);
        
	}
	
	public function setUserModel($userModel = 'memberspace/user'){
		if($this->_userModel == $userModel) {
			return;
		}
		$this->_ci->load->model($userModel);
		$exp = explode('/', $userModel);
		$modelName = end($exp);
		$this->_user = $this->_ci->{$modelName};
		$this->_userModel = $userModel;
		$this->connectUserIfAny();
	}


	public function changeUserModel($userModel = 'memberspace/user') {
		$this->setUserModel($userModel);
	}
	
	public function requireLogin($redirect = 'login') {
		$this->connectUserIfAny();
		if(!$this->isConnected()){
			$this->_ci->session->set_userdata('login_redirect_url', current_url());
			redirect($redirect);
		}
		return true;
	}
	
	public function getUser() {
		return $this->_user;
	}
	
	public function connectUserIfAny() {
		if($this->isConnected()) return;
		$user_id = $this->_ci->session->userdata('user_id');
		if(!$user_id){
			$user_id = get_cookie('user_id');
		}
		if($user_id) {
			$this->_user->connect($user_id);
		}
	}
	
	public function isConnected($user_id=null) {
		$connected = $this->_user->isConnected();
		if($user_id !== null) {
			$connected &= $this->_user->id == $user_id;
		}
		return $connected;
	}

	public function getCookie() {
		if(!$this->_cookie){
			$this->_cookie = Modules::load_multiple('login_cookie', 'memberspace', 'config/', 'config');
		}
		return $this->_cookie;
	}
	
	public function disconnect() {
		$cookie = $this->getCookie();
		delete_cookie($cookie);
		session_destroy();
	}
	
	public function connectUserFromPost($post = null) {
		$this->_ci->load->library('form_validation');
		if($post){
			$this->_ci->form_validation->set_data($post);
		}
		$rules = Modules::load_multiple('form_validation', 'memberspace', 'config/','config');
		if(!isset($rules['login'])){
			return;
		}
		$validation_rules = $rules['login'];
		$this->_ci->form_validation->set_rules($validation_rules);
		if(!$this->_ci->form_validation->run()){
			add_error($this->_ci->form_validation->error_string());
			return ;
		}
		
		if(!$post) {
			unset($_POST['login-user']);
			$post = $_POST;
		}
		$user = $this->_user->checkUser($post['login'],$post['password']);
		if(!$user) {
			add_error(translate('Les données de connexion sont invalides.'));
			return ;
		}
		
		$this->_user->connect($user->id);
		
		add_success(translate('Vous vous êtes connecté avec succès !'));
		
		if(isset($post['rememberme']) && $post['rememberme']){
			$cookie = $this->getCookie();
			$cookie['value'] = $user->id;
			set_cookie($cookie);
		}
		
		if($this->_ci->session->userdata('login_redirect_url')){
			redirect($this->_ci->session->userdata('login_redirect_url'));
		}
		else {
			redirect(current_url());
		}
	}
}