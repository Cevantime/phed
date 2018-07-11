<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author thibault
 */
class Linkgroupright extends DATA_Model {
	
	public static $TABLE_NAME = 'links_groups_rights';
	
	public static $PRIMARY_COLUMNS = array('group_id','right_id');

	public function getTableName() {
		return self::$TABLE_NAME;
	}
	
	public function getPrimaryColumns() {
		return self::$PRIMARY_COLUMNS;
	}
	
	public function link($groupId, $rightId){
		$link = $this->getRow(array('group_id'=>$groupId,'right_id'=>$rightId));
		if(!$link) {
			$this->insert(array('group_id'=>$groupId,'right_id'=>$rightId));
		}
	}

}
