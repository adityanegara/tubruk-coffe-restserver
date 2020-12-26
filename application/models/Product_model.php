<?php

class Product_Model extends CI_Model{
    public function getProduct($id = null){
        if($id == null){
            return $this->db->get('product')->result_array();
            
        }else{
            return $this->db->get_where('product', ['id' => $id])->result_array();
        
        }
    }

    public function createProduct($data){
        $this->db->insert('product', $data);
        return $this->db->affected_rows();
    }

    public function updateProduct($data, $id){
        $this->db->update('product', $data,  ['id'=>$id]);
        return $this->db->affected_rows();
    }

    public function deleteProduct($id){
        $this->db->delete('product', ['id' => $id]);
        return $this->db->affected_rows();
    }


}