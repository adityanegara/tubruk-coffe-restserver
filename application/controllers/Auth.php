<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Auth extends RestController {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');   
    }
    
    public function index_get(){
        $id = $this->get('id');
        $users = $this->Auth_model->getProduct($id);
        if($users['users'] != null){
            $this->response( [
                'status' => true,
                'query' => $users['query'],
                'affacted_rows' => $users['affacted_rows'],
                'data' => $users['users']
                ], RestController::HTTP_OK );
        }else{
            $this->response( [
                'status' => false,
                'messege' => 'users not found!'
            ], RestController::HTTP_NOT_FOUND );
        }
    
    }
    

    public function index_post(){
        $data = [
            'first_name' => htmlspecialchars($this->input->post('first_name', true)),
            'last_name' => htmlspecialchars($this->input->post('last_name', true)),
            'email' => htmlspecialchars($this->input->post('email'), true),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'roles' => 2,
            'email_verified' => 0
        ];
        $user =  $this->Auth_model->createUser($data);
        if($user['user'] != null){
            $this->response( [
                'status' => true,
                'affacted_rows' => $user['affacted_rows'],
                'data' => $user['user']
                ], RestController::HTTP_OK );
        }else{
            $this->response( [
                'status' => false,
                'messege' => 'Failed to create new user!'
            ], RestController::HTTP_BAD_REQUEST );
        }
    }
}








