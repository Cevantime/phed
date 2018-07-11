<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . 'modules/bo/controllers/Users.php';

class AdminUser extends Users
{

    public function index($userModel = 'memberspace/user') {
		$this->all($userModel);
	}
	
	public function all($userModel = 'memberspace/user'){
        parent::all('pheduser');
	}
	
	public function add($userModel = 'memberspace/user') {
		parent::add('pheduser');
	}
	
	public function edit($id,$userModel = 'memberspace/user') {
		parent::edit($id, 'pheduser');
	}
    
    public function delete($id,$userModel = 'memberspace/user') {
		parent::delete($id, 'pheduser');
	}
	

}
