<?php


if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class FILEBROWSER_Controller extends MX_Controller {
	public function __construct() {
		$this->load->helper('memberspace/connection');
		if(!is_connected()) {
			die(translate('Vous ne pouvez pas accéder à vos fichiers si vous n\'êtes pas connecté.'));
		}
		parent::__construct();
		$this->load->library('layout/layout');
		$this->load->helper('memberspace/authorization');
		$this->load->helper('images/image');
		$this->load->database();
	}
}