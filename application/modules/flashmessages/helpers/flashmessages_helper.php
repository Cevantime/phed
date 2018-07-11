<?php

if(!function_exists('add_message')) {
	
	function add_message($message, $type=null) {
		$CI =& get_instance();
		$CI->load->library('flashmessages/flashMessagesManager');
		$CI->flashmessagesmanager->pushNewMessage($message, $type);
	}
	
}

if(!function_exists('add_success')) {
	
	function add_success($message) {
		$CI =& get_instance();
		$CI->load->library('flashmessages/flashMessagesManager');
		$CI->flashmessagesmanager->pushNewMessage($message, FlashMessage::TYPE_SUCCESS);
	}
	
}
if(!function_exists('add_error')) {
	
	function add_error($message) {
		$CI =& get_instance();
		$CI->load->library('flashmessages/flashMessagesManager');
		$CI->flashmessagesmanager->pushNewMessage($message, FlashMessage::TYPE_ERROR);
	}
	
}
if(!function_exists('add_warning')) {
	
	function add_warning($message) {
		$CI =& get_instance();
		$CI->load->library('flashmessages/flashMessagesManager');
		$CI->flashmessagesmanager->pushNewMessage($message, FlashMessage::TYPE_WARNING);
	}
	
}

