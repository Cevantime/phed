<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author thibault
 */
class Login extends MX_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('layout/layout');
		$this->load->model('memberspace/user');
		$this->layout->setLayout('bo/layout/login_bo');
	}
	
	public function index() {
		if($this->session->user_id){
			$this->user->load($this->session->user_id);
			if($this->user->can('access','backoffice')){
				redirect('bo/home');
			}
		}
		if($this->input->post()){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('login','login','required');
			$this->form_validation->set_rules('password','password','required');
			
			if($this->form_validation->run()) {
				$post = $this->input->post();
				if($user = $this->user->checkUser($post['login'], $post['password'])){
					
					$this->session->set_userdata('user_id',$user->id);
					$this->user->load($user->id);
                    
					if($this->user->can('access','backoffice')){
						redirect('bo/home');
					} else {
						$this->addError('vous ne pouvez pas accéder au back office');
					}
				} else {
					$this->addError('login ou mot de passe non trouvé');
				}
			} else {
				$this->addError($this->form_validation->error_string());
			}
			
		}
		$this->layout->view('bo/login');
	}
	
	private function addMessage($type, $message){
		$this->load->library('flashmessages/flashMessagesManager');
		$this->flashmessagesmanager->pushNewMessage($message,$type);
	}

	protected function addError($message) {
		$this->addMessage('error', $message);
	}

	protected function addSuccess($message) {
		$this->addMessage('succes', $message);
	}

	protected function addWarnings($message) {
		$this->addMessage('warning', $message);
	}
}
