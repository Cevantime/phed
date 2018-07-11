<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Confirmation extends MX_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function basic() {
		$this->load->view('memberspace/confirmation/basic');
	}
	
	public function bootstrap() {
		$this->load->view('memberspace/confirmation/bootstrap');
	}
	
	public function confirm($userId,$key) {
		$this->load->model('user');
		$user = $this->user->getRow(array($this->db->dbprefix('users').'.id'=>$userId));
		if(!$user){
			$this->load->view('memberspace/confirmation/confirm-error', array(
				'message'=>translate('Votre inscription n\'a pas pu être confirmée. Il est possible '
					. 'que l\'url de redirection utilisée soit corrompue.')
			));
		} else {
			$wantedKey = md5($user->login.'_'.$user->password);
			if($wantedKey == $key){
				$this->user->update(array('confirmed'=>1),array($this->db->dbprefix('users').'.id'=>$user->id));
				$this->load->view('memberspace/confirmation/confirm-success');
			} else {
				$this->load->view('memberspace/confirmation/confirm-error', array(
					'message'=>translate('Votre inscription n\'a pas pu être confirmée '
							. 'car la clé de vérification fournie n\'est pas valide.')
				));
			}
		}
	}
}
