<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class PostManager {
	
	public static $ACCEPTED_IMG_TYPES = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
	
	private $_validation_rules;
	private $_upload_paths;
	private $_ci_form_validation;
	private $_ci_upload;
	private $_ci;
	
	private $postmodel,$basepostmodel,$postmodelname;
	
	public function __construct($basemodel = 'memberspace/post') {
		$CI =& get_instance();
		$this->_ci = $CI;
		$this->_ci->load->library('form_validation');
		$this->_ci_form_validation = $this->_ci->form_validation;
		$this->_ci->load->library('upload');
		$this->_ci_upload = $CI->upload;
		$this->_ci->load->library('flashmessages/flashMessagesManager');
		$this->_validation_rules = Modules::load_multiple('form_validation', 'memberspace', 'config/', 'config');
		$this->_upload_paths = Modules::load_multiple('upload_paths','memberspace', 'config/', 'config');
		$this->setCurrentPostModel($basemodel);
	}


	/**
	 * returns instance containing basic form_upload validation and upload instances
	 * in an array (0 => $form_valiation, 1 => $upload
	 */
	public function validateDatas(&$datas = null) {
		$this->_ci_form_validation->reset_validation();
		$rules = $this->getCurrentValidationRules();
		
		if($datas) {
			$this->_ci_form_validation->set_datas($datas);
		}
		
		$this->_ci_form_validation->set_rules($rules);
		
		$run = $this->_ci_form_validation->run();
		if(!$datas){
			if(isset($_POST['save-'.$this->postmodelname]))unset($_POST['save-'.$this->postmodelname]);
		}
		$files = $_FILES;
		if($run){
			$path = $this->getCurrentUploadPath();
			$this->_ci_upload->initialize(array('upload_path' => './'.$path,'allowed_types'=>'*', 'file_name'=>  uniqid()));
			foreach ($files as $key => $filedata){
				if($this->_ci_upload->do_upload($key)) {
					if($datas){
						$datas[$key] = $path.'/'.$this->_ci_upload->file_name;
					} else {
						$_POST[$key] = $path.'/'.$this->_ci_upload->file_name;
					}
				}
				else {
					$this->_ci->flashmessagesmanager->pushNewMessage($this->_ci_upload->display_errors(), FlashMessage::TYPE_WARNING);
				}
			}
		}
		
		return $run;
		
	}
	
	public function saveDatas($datas) {
		return $this->postmodel->save($datas);
	}
	
	public function getLastValidationErrors() {
		return $this->_ci_form_validation->error_string();
	}
	
	public function getAllValidationRules() {
		return $this->_validation_rules;
	}
	
	public function getValidationRules($key) {
		$rules = $this->getAllValidationRules();
		return isset($rules[$key]) ? $rules[$key] : array();
	}
	
	public function getCurrentValidationRules(){
		return $this->getValidationRules($this->basepostmodel);
	}
	
	public function getCurrentUploadPath() {
		return isset($this->_upload_paths[$this->basepostmodel]) ? $this->_upload_paths[$this->basepostmodel] : 'uploads/posts';
	}
	
	public function getPostModelName() {
		return $this->postmodelname;
	}

	public function setCurrentPostModel($basemodel) {
		$this->_ci->load->model($basemodel);
		$this->basepostmodel = $basemodel;
		$explode = explode('/', $basemodel);
		$this->postmodelname = end($explode);
		$this->postmodel = $this->_ci->{$this->postmodelname};
	}
	
	public function getAPostModelAsArray($id) {
		return $this->postmodel->getId($id, 'array');
	}
	
	public function registerModelUploadPath($basemodel,$uploadPath) {
		$this->_upload_paths[$basemodel] = $uploadPath;
	}
	
	public function registerModelRules($basemodel,$rules) {
		$this->_validation_rules[$basemodel] = $rules;
	}
	
}
