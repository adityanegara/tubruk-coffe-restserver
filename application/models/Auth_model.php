<?php

class Auth_model extends CI_Model{
    public function getProduct($id = null){
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

    public function createUser($data){
        $this->db->insert('users', $data);
        $data['user'] = $this->db->insert_id();
        $data['affacted_rows'] = $this->db->affected_rows();
        return $data;
    }

}
  


