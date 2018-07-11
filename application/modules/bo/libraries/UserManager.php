<?php

/**
 * Description of UserManager
 *
 * @author cevantime
 */
class UserManager {
	
	public $userModel;
	public $defaultConfig;
	public $config;
	
	public function __construct() {
		$this->defaultConfig = array(
			'update-forbidden' => translate('Vous ne pouvez pas modifier cet utilisateur'),
			'insert-forbidden' => translate('Vous ne pouvez pas ajouter cet utilisateur'),
			'update-success' => translate("L'utilisateur a bien été mis à jour"),
			'insert-success' => translate("L'utilisateur a bien été ajouté"),
			'delete-forbidden' => translate('Vous n\'avez pas le droit de supprimer cet utilisateur'),
			'delete-success' => translate('L\'utilisateur a bien été supprimé')
		);
		$this->config = $this->defaultConfig;
	}
	
	public function setUserModel($userModel) {
		$config = Modules::load_multiple('user-management', 'bo', 'config/', 'config');
		$this->userModel = $userModel;
		if(isset($config[$userModel]) && is_array($config[$userModel])) {
			$this->config = array_merge($this->defaultConfig, $config[$userModel]);
		} else {
			$this->config = $this->defaultConfig;
		}
	}
	
	public function save($id = null, $redirect = null) {
		$CI =& get_instance();
		$userModel = $this->userModel;
		$model = pathinfo($userModel)['filename'];
		$CI->load->helper('memberspace/authorization');
		$CI->load->helper('flashmessages/flashmessages');
		$CI->load->model($userModel);
		$CI->load->helper('form');
		$datas = $CI->$model->getId($id,'array');
        if( ! $datas) $datas = [];
		if(isset($_POST) && isset($_POST['save-user'])) {
			$datas = array_merge($datas,$_POST);
			unset($_POST['save-user']);
			$is_update = false;
			if(isset($_POST['id']) && $_POST['id']) {
				$is_update = true;
				if(!user_can('update',$userModel, $_POST['id'])){
					add_error($this->config['update-forbidden']);
					return $datas;
				}
			} else {
				if(!user_can('add',$userModel)) {
					add_error($this->config['insert-forbidden']);
					return $datas;
				}
			}
			if($CI->$model->fromPost()) {
				if($is_update) {
					add_success($this->config['update-success']);
				} else {
					add_success($this->config['insert-success']);
				}
				if($redirect) {
					redirect($redirect);
				}
				redirect('bo/users/all/'.  str_replace('/', '-', $userModel));
			} else {
				add_error($CI->form_validation->error_string());
			}
			
		}
		return $datas;
	}
	
	public function delete($id, $redirect = null) {
		$CI =& get_instance();
		$userModel = $this->userModel;
		$CI->load->helper('memberspace/authorization');
		if(user_can('delete',$userModel,$id)){
			$CI->load->model('memberspace/user');
			$CI->user->deleteId($id);
			add_success($this->config['delete-success']);
		} else {
			add_error($this->config['delete-forbidden']);
		}
		if($redirect) {
			redirect($redirect);
		}
		redirect('bo/users/all/'.  str_replace('/', '-', $userModel));
	}
	
}
