<?php

if (!function_exists('user_can')) {

	function user_can($action = '*', $type = '*', $object_key = '*') {

		$CI = & get_instance();
		$CI->load->library('memberspace/loginManager');
		$user = $CI->loginmanager->getUser();
		return $user && $user->can($action, $type, $object_key);
	}

}
if (!function_exists('user_is')) {

	function user_is($role) {
		$CI = & get_instance();
		$CI->load->library('memberspace/loginManager');
		$user = $CI->loginmanager->getUser();
		return $user && $user->is($role);
	}

}