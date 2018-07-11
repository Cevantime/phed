<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Register extends MX_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('flashmessages');
		$this->load->helper('form');
	}

	public function bootstrap($userModel = 'memberspace/user', $mailRedirect = 'memberspace/confirmation/confirm', $redirect = null) {
		$datas = $this->save($userModel,$mailRedirect, $redirect);
		$modelName = $modelName = pathinfo($userModel)['filename'];
		$this->load->view('memberspace/register/bootstrap', array('pop'=>$datas,'modelName'=>$modelName));
	}
	public function basic($userModel = 'memberspace/user', $mailRedirect = 'memberspace/confirmation/confirm', $redirect = null) {
		$datas = $this->save($userModel,$mailRedirect, $redirect);
		$modelName = $modelName = pathinfo($userModel)['filename'];
		$this->load->view('memberspace/register/basic', array('pop'=>$datas,'modelName'=>$modelName));
	}

	public function save($userModel = 'memberspace/user',$mailRedirect = 'memberspace/confirmation/confirm', $redirect = null) {
		
		$post = $this->input->post();
		
		$modelName = pathinfo($userModel)['filename'];
		
		if(!$post || !isset($post['save-'.$modelName])){
			return array();
		}
		
		unset($_POST['save-'.$modelName]);
		
		$this->load->library('form_validation');
		
		
		if(isset($post['id']) && !user_can('update', $userModel, $post['id'])){
			return $post;
		}
		
		$this->load->model($userModel);
		
		$userId = $this->$modelName->fromPost();
		
		if($userId === false){
			add_error($this->form_validation->error_string());
			return $post;
		}
		
		if(!isset($post['id'])) {
			$this->sendMailConfirmation($userId, $mailRedirect);
			add_success('Vous avez bien été inscrit !');
		} else {
			add_success('Vous avez bien mis à jour vos informations');
		}
		
		if($redirect){
			redirect($redirect);
		}
		
		return $post;
	}
	
	private function sendMailConfirmation($userId, $mailRedirect) {
		$this->load->model('user');
		$this->load->library('mailManager');
		$this->load->model('configuration');
		$subject = $this->configuration->getValue('mail_confirmation_subject','Confirmation de votre inscription');
		$user = $this->user->getId($userId);
		if(!$user) {
			add_error('Le mail de confirmation n\'a pas pu être envoyé car l\'utilisateur n\'a pas été trouvé en base');
			return;
		}
		$keyConfirm = md5($user->login.'_'.$user->password);

		$message = $this->load->view('memberspace/confirmation/mail/custom', 
				array(
					'login' => $user->login,
					'urlRedirection' => base_url($mailRedirect.'/'.$user->id.'/'.$keyConfirm),
					'nomFrom' => $this->configuration->getValue('mail_confirmation_nom_from', 'Tout l\'&eacutequipe de Have A Site'),
					'title' => 'Confirmation de votre inscription'
				), true);
		$this->mailmanager->sendMail($subject,$message,$user->email); 
	}
}
