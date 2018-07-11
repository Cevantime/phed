<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author thibault
 */
class Users extends BO_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('bo/userManager');
	}

	public function index($userModel = 'memberspace/user') {
		$this->all($userModel);
	}
	
	public function all($userModel = 'memberspace/user'){
		$userModel = $this->filterModel($userModel);
		$start = $this->input->get('page_start');
		$this->checkIfUserCan('see',$userModel,'*');
		$this->load->model($userModel);
		$model = pathinfo($userModel)['filename'];
		$id_pagination = 'users-list';
		$users = $this->mypagination->paginate($id_pagination,$this->$model, $start, 10);
		$this->layout->assign('users', $users);
		$this->layout->assign('id_pagination_users_list', $id_pagination);
		$this->layout->view('bo/users/all', array('modelName'=>$userModel));
	}
	
	public function add($userModel = 'memberspace/user') {
		$userModel = $this->filterModel($userModel);
		$this->usermanager->setUserModel($userModel);
		$datas = $this->usermanager->save(null);
		$this->layout->view('bo/users/save', array('popSaveUser'=> $datas,'modelName'=>$userModel));
	}
	
	public function edit($id,$userModel = 'memberspace/user') {
		$userModel = $this->filterModel($userModel);
		$this->usermanager->setUserModel($userModel);
		$datas = $this->usermanager->save($id);
		$this->layout->view('bo/users/save', array('popSaveUser'=> $datas, 'isEditUser'=>true,'modelName'=>$userModel));
	}
	
	public function delete($id,$userModel = 'memberspace/user') {
		$this->usermanager->setUserModel($userModel);
		$this->usermanager->delete($id, 'bo/users/all/'.  str_replace('/', '-', $userModel));
	}
	
	protected function filterModel($model) {
		return str_replace('-', '/', $model);
	}
}

?>
