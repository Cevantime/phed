<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

$CI =& get_instance();
$post = $CI->input->post();
$CI->load->model('memberspace/post');

$is_update = isset($post['id'], $post['save-post']);

$config = array(
	'memberspace/post' => array(
		array(
			'field' => 'content',
			'label' => translate('Contenu'),
			'rules' => (!$is_update ? 'required|' : '').'min_length[20]',
		),
		
	)
);

if($is_update){
	$config['memberspace/post'][] = array(
			'field' => 'id',
			'label' => 'Id',
			'rules' => array(
				'required',
				'numeric',
				array($CI->post, 'exists')
			)
	);
}

// config login

$is_login = isset($post['login-user']);

if ($is_login) {
	$config['login'] = array(
		array(
			'field' => 'login',
			'label' => translate('Nom d\'Utilisateur'),
			'rules' => 'required'
		),
		array(
			'field' => 'password',
			'label' => translate('Mot de passe'),
			'rules' => 'required',
		),
		array(
			'field' => 'rememberme',
			'label' => translate('Se souvenir de moi'),
			'rules' => 'in_list[0,1]',
		)
	);
}
