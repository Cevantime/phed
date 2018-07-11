<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Right
 *
 * @author thibault
 */
class Linkusergroup extends DATA_Model {
	
	public static $TABLE_NAME = 'links_users_groups';
	
	public static $PRIMARY_COLUMNS = array('user_id','group_id');

	public function getTableName() {
		return self::$TABLE_NAME;
	}
	
	public function getPrimaryColumns() {
		return self::$PRIMARY_COLUMNS;
	}
	
	public function link($userId, $groupId){
		$link = $this->getRow(array('user_id'=>$userId,'group_id'=>$groupId));
		if(!$link) {
			$this->insert(array('user_id'=>$userId,'group_id'=>$groupId));
		}
	}
}
