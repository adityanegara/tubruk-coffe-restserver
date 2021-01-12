<?php

class Auth_model extends CI_Model{
    public function getUser($id = null){
        if($id == null ){
            $data['users'] =  $this->db->get('users')->result_array();
            $data['affacted_rows'] = $this->db->affected_rows();
            $data['query'] = $this->db->last_query();
            return $data;
        }else{
            $data['users'] =  $this->db->get_where('users', ['id' => $id])->result_array();
            $data['affacted_rows'] = $this->db->affected_rows();
            $data['query'] = $this->db->last_query();
            return $data;
        }
    }

    public function getUserByEmail($email){
        return $this->db->get_where('users', ['email' => $email])->row_array();
    }

    public function getToken($token){
        return  $this->db->get_where('verification_token', ['token' => $token])->row_array();
    }

    public function activateUserEmail($email){
        $this->db->set('email_verified', 1);
        $this->db->where('email', $email);
        $this->db->update('users');
    }

    public function deleteToken($email){
        $this->db->delete('verification_token', ['email' => $email]);
    }

    public function createUser($data){
        $this->db->insert('users', $data);
        $data['user'] = $this->db->insert_id();
        $data['affacted_rows'] = $this->db->affected_rows();
        return $data;
    }

    public function insertToken($token){
        $this->db->insert('verification_token', $token);
    }


}
  


