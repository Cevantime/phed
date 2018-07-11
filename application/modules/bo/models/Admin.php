<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author thibault
 */

require_once APPPATH.'/modules/memberspace/models/User.php';

class Admin extends User {
	
	public static $TABLE_NAME = 'users_admin';

	public function getTableName() {
		return self::$TABLE_NAME;
	}
	
	public function insert($datas = null) {
		$id = parent::insert($datas);
		$this->load->model('memberspace/right');
		$this->user->addToGroup('administrators', $id);
		return $id;
	}
	
	public function validationRulesForInsert($datas) {
		$rules = parent::validationRulesForInsert($datas);
		return array_merge(
				$rules,
				array(
					array(
						'field' => 'name',
						'label' => translate('Nom'),
						'rules' => 'required|min_length[2]'
					),
					array(
						'field' => 'forname',
						'label' => translate('Prenom'),
						'rules' => 'required|min_length[2]'
					)
				)
		);
	}
	public function validationRulesForUpdate($datas) {
		$rules = parent::validationRulesForUpdate($datas);
		return array_merge(
				$rules,
				array(
					array(
						'field' => 'name',
						'label' => translate('Nom'),
						'rules' => 'required|min_length[2]'
					),
					array(
						'field' => 'forname',
						'label' => translate('Prenom'),
						'rules' => 'required|min_length[2]'
					)
				)
		);
	}
}
