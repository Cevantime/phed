<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class FlashMessages extends MX_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('flashmessages/flashMessagesManager');
	}
	
	public function slidedownstyle(){
		$flashMessages = $this->collectMessages();
		$this->load->view('flashmessages/slidedownstyle', array('flashMessages'=>$flashMessages));
	}

	public function basicpopupstyle() {
		$flashMessages = $this->collectMessagesGroupByTypes();
		
		$this->load->view('flashmessages/basicpopupstyle', array('flashMessages'=>$flashMessages));
	}
	
	public function prettypopupstyle() {
		$flashMessages = $this->collectMessagesGroupByTypes();
		$this->load->view('flashmessages/prettypopupstyle', array('flashMessages'=>$flashMessages));
	}
	
	public function basicstyle() {
		$flashMessages = $this->collectMessagesGroupByTypes();
		$this->load->view('flashmessages/basicstyle', array('flashMessages' => $flashMessages));
	}

	private function collectMessages() {
		return $this->flashmessagesmanager->collectMessages();
	}
	
	private function collectMessagesGroupByTypes() {
		$msgs = $this->collectMessages();
		return $this->groupMessagesByType($msgs);
	}
	
	private function groupMessagesByType($messages) {
		$groups = array();
		if($messages){
			foreach($messages as $message) {
				$groups[$message['type']][] = $message;
			}
		}
		return $groups;
	}
}
