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

class Post extends DATA_Model {
	
	public static $TABLE_NAME = 'posts';

	public function getTableName() {
		return self::$TABLE_NAME;
	}
	
	public function getOwnedBy($user_id = null) {
		if(!$user_id) {
			$user_id = $this->getData('user_id');
		}
		$this->db->where('user_id = '.$user_id);
		return $this->getList();
	}
		
	public function insert($datas = null) {
		if ($datas == null) {
			$datas = $this->toArray();
			$this->clear();
		}
		$time = time();
		$datas['creation_time'] = $time;
		$datas['update_time'] = $time;
		return parent::insert($datas);
	}
	
	public function update($datas = null, $where = null){
		if ($datas == null) {
			$datas = $this->toArray();
			$this->clear();
		}
		$time = time();
		unset($datas['creation_time']);
		$datas['update_time'] = $time;
		return parent::update($datas, $where);
	}
	
	public function validationRulesForInsert($datas) {
		return array(
			'content'=>array(
				'field' => 'content',
				'label' => translate('Contenu'),
				'rules' => 'required|min_length[20]',
			)
		);
	}
	
	public function validationRulesForUpdate($datas) {
		return array(
			'content'=>array(
				'field' => 'content',
				'label' => translate('Contenu'),
				'rules' => 'min_length[20]',
			),
			'id'=>array(
				'field' => 'id',
				'label' => 'Id',
				'rules' => array(
					'required',
					'numeric',
					array($this, 'exists')
				)
			)
		);
	}
}
