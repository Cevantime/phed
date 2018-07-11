<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class FlashMessage extends DATA_Model {
	
	const TABLE_NAME = 'flash_messages';
	
	const TYPE_SUCCESS = 'success';
	const TYPE_WARNING = 'warning';
	const TYPE_ERROR = 'error';
	const TYPE_INFO = 'info';
	
	public function getTableName() {
		return self::TABLE_NAME;
	}
	
	public function getSessionsMessages($session_id) {
		return $this->get(array('session_id' => $session_id),'array');
	}
	
	public function createNewMessage($session_id, $msg, $type = null) {
		if(!$type) $type = self::TYPE_INFO;
		$row = $this->buildRow(array('session_id'=>$session_id,'content'=>$msg,'type'=>$type));
		$this->save($row);
		return $row;
	}
	
	public function deleteSessionsFlashMessages($session_id) {
		return $this->delete(array('session_id'=>$session_id));
	}

}
