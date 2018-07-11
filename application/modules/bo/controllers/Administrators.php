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
class Administrators extends BO_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('bo/userManager');
	}

	public function index() {
		$this->all();
	}
	
	public function all($adminModel = 'bo/admin')  {
		$adminModel = $this->filterModel($adminModel);
		$start = $this->input->get('page_start');
		$this->checkIfUserCan('see',$adminModel,'*');
		$this->load->model($adminModel);
		$model = pathinfo($adminModel)['filename'];
		$id_pagination = 'administrators-list';
		$admins = $this->mypagination->paginate($id_pagination,$this->$model, $start, 10);
		$this->layout->assign('administrators', $admins);
		$this->layout->assign('id_pagination_administrators_list', $id_pagination);
		$this->layout->view('bo/administrators/all', array('modelName'=>$adminModel));
	}
	
	public function add($adminModel = 'bo/admin') {
		$adminModel = $this->filterModel($adminModel);
		$this->usermanager->setUserModel($adminModel);
		$datas = $this->usermanager->save(null,'bo/administrators' );
		$this->layout->view('bo/administrators/save', array('popSaveAdmin'=> $datas,'modelName'=>$adminModel));
	}
	
	public function edit($id,$adminModel = 'bo/admin') {
		$adminModel = $this->filterModel($adminModel);
		$this->usermanager->setUserModel($adminModel);
		$datas = $this->usermanager->save($id,'bo/administrators');
		$this->layout->view('bo/administrators/save', array('popSaveAdmin'=> $datas, 'isEditAdmin'=>true,'modelName'=>$adminModel));
	}
	
	public function delete($id,$adminModel = 'bo/admin') {
		$adminModel = $this->filterModel($adminModel);
		$this->usermanager->setUserModel($adminModel);
		$this->usermanager->delete($id,'bo/administrators/all/'.  str_replace('/', '-', $adminModel));
	}
	
	private function filterModel($model) {
		return str_replace('-', '/', $model);
	}
}

?>
