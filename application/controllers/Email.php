<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');     
    }
    
	public function index()
	{
		echo "email";
	}

	public function verify(){
        $email = $this->input->get('email');
		$token = $this->input->get('token');
		if($this->Auth_model->getUserByEmail($email) == true){
			$verification_token = $this->Auth_model->getToken($token);
				if($verification_token == true){
					if(time()- $verification_token['date_created'] < (60*60*24)){
						$this->Auth_model->activateUserEmail($email);
						$this->Auth_model->deleteToken($email);
						echo "Email Has Been Activated";
						die;
					}else{
						$this->Auth_model->deleteUser($email);
						$this->Auth_model->deleteToken($email);
						echo "Token Expired";
						die;
					}
			}else{
				echo "Wrong Token";
				die;
			}
		}else{
			echo "Email not found";
			die;
		}
       
	}

	
}
