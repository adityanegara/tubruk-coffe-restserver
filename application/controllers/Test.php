<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function email(){
		$this->email->from('testingaditnegara@gmail.com', 'Test Aditya Negara');
		$this->email->to('aditnegara51@gmail.com');
		$this->email->subject('Email Test');
		$data['link'] = "https://test";
		$data['objective'] = "Test your email";
		$this->email->message($this->load->view('email_message', $data, true));
		$this->email->send();
	}

	public function body(){
		$data['link'] = "test link";
		$this->load->view('test', $data);
	}
}
