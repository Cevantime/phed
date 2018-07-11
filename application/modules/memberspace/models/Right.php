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
class Right extends DATA_Model {

	public static $TABLE_NAME = 'rights';
	public $_userRights = array();
	public $_useSession;

	public function getTableName() {
		return self::$TABLE_NAME;
	}

	public function getUserRights($user) {

		if (isset($this->_userRights[$user->id])) {
			return $this->_userRights[$user->id];
		}
		$userId = $user->id;

		// try to get rights from session if using session
		
		if ($this->useSession()) {
			// user rights are presents in session, return them
			$this->load->library('session');
			$rights = $this->session->userdata('user_rights_' . $userId);

			if ($rights) {
				return $rights;
			}
		}

		// fetch rights in db

		$this->load->model('memberspace/linkuserright');
		$this->load->model('memberspace/linkgroupright');
		$this->load->model('memberspace/user');
		$userGroups = $this->user->getGroups($userId);
		$groupIds = array();
		if ($userGroups) {
			foreach ($userGroups as $group) {
				$groupIds[] = $group->id;
			}
		}
		$userOwnRights = $this->getThrough(Linkuserright::$TABLE_NAME, 'user', $userId);
		$userGroupRights = $this->getThrough(Linkgroupright::$TABLE_NAME, 'group', $groupIds);
		if (!$userOwnRights)
			$userOwnRights = array();
		if (!$userGroupRights)
			$userGroupRights = array();
		$rights = array_merge($userOwnRights, $userGroupRights);
		$this->_userRights[$user->id] = $rights;

		// store rights in session if using session
		if($this->useSession()) {
			$this->session->set_userdata('user_rights_'.$userId, $rights);
		}

		return $rights;
	}

	public function useSession() {
		if (!$this->_useSession) {
			$config = Modules::load_multiple('rights', 'memberspace', 'config/', 'config');
			$this->_useSession = $config['rights_use_session'] !== FALSE;
		}
		return $this->_useSession;
	}

	public function getGroupRights($groupId) {
		$this->load->model('memberspace/linkgroupright');
		return $this->getThrough(Linkgroupright::$TABLE_NAME, 'group', $groupId);
	}

	public function allowUserTo($userId, $action, $type = '*', $value = '*') {
		$right_id = $this->createAndSaveRight($action, $type, $value);
		$this->load->model('memberspace/linkuserright');
		$this->linkuserright->link($userId, $right_id);

		// clear user rights in session if any
		if($this->useSession()) {
			$this->session->unset_userdata('user_rights_' . $userId);
		}
	}

	private function createAndSaveRight($action, $type = '*', $value = '*') {
		$right = $this->getRow(array('name' => $action, 'type' => $type, 'object_key' => $value));
		if (!$right) {
			return $this->insert(array('name' => $action, 'type' => $type, 'object_key' => $value));
		}

		return $right->id;
	}

	public function allowGroupTo($groupId, $action, $type = '*', $value = '*') {
		$rightId = $this->createAndSaveRight($action, $type, $value);
		$this->load->model('memberspace/linkgroupright');
		$this->linkgroupright->link($groupId, $rightId);
		
		// if using session clear any rights from it
		if($this->useSession()) {
			foreach ($_SESSION as $key => $value) {
				if(strpos($key, 'user_rights_') !== FALSE) {
					$this->session->unset_userdata($key);
				}
			}
		}
	}

	public function userCan($user, $action, $type = '*', $value = '*') {
		$rights = $this->getUserRights($user);
		foreach ($rights as $right) {
			if ($this->rightAllows($user, $right, $action, $type, $value)) {
				return true;
			}
		}
		return false;
	}

	public function rightAllows($user, $right, $action, $type, $value) {
		return $this->checkAction($action, $right->name) && $this->checkType($type, $right->type) && $this->checkValue($user, $type, $value, $right->object_key);
	}

	public function checkAction($action, $rightAction) {
		return $rightAction == '*' OR in_array($action, explode(',', $rightAction));
	}

	public function checkType($type, $rightType) {
		return $this->checkAction($type, $rightType);
	}

	private function checkValue($user, $type, $object_key, $right_value) {
		if ($right_value == '*')
			return true;
		$varreg = '([0-9a-zA-Z]+)';
		$classreg = '([0-9a-z/A-Z]+)';
		$regex = '#^' . $varreg . '?\[' . $classreg . '\]::' . $varreg . '\((.*?)\)$#';
		if (preg_match($regex, $right_value, $matches)) {
			$type = $matches[1];
			$class = $matches[2];
			$method = $matches[3];
			$args = explode(',', $matches[4]);
			foreach ($args as $k => $v) {
				if ($v === '{object}') {
					$args[$k] = $object_key;
				} else if ($v === '{user}') {
					$args[$k] = $user;
				}
			}
			$this->load->$type($class);
			$exploded = explode('/', $class);
			$classRad = end($exploded);
			$obj = $this->$classRad;
			if (call_user_func_array(array($obj, $method), $args) === TRUE) {
				return TRUE;
			}
		} else if(is_object($object_key)){
				
			$this->load->model($type);
			$exploded = explode('/', $type);
			$classRad = end($exploded);
			$primaries = $this->$classRad->getPrimaryColumns();
			if (count($primaries) > 1) {
				$object_key = '{' . implode(';', array_map(function($r) use ($object_key) {
									return $object_key->$r;
								}, $primaries)) . '}';
			} else {
				$object_key = $object_key->{$primaries[0]};
				
			}
			return in_array($object_key, explode(',', $right_value));
		}
		return FALSE;
	}

}
