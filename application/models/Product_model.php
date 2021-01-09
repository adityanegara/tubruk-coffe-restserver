<?php

class Product_Model extends CI_Model{
    public function getProduct($id = null, $limit = null, $start = null, $keyword = null){
        if($id == null && $limit == null && $start == null ){
            $data['product'] =   $this->db->get('product')->result_array();
            $data['affacted_rows'] = $this->db->affected_rows();
            $data['query'] = $this->db->last_query();
            return $data;
        }else if($limit != null && $start != null){
            if($keyword != null){
                $data['product'] = $this->db->like('name', $keyword);
            }
            $data['product'] = $this->db->get('product', $limit, $start)->result_array();
            $data['affacted_rows'] = $this->db->affected_rows();
            $data['query'] = $this->db->last_query();
            return $data;
        }
        else{
            $data['product'] =  $this->db->get_where('product', ['id' => $id])->result_array();
            if($data['product'][0]['category'] != 'coffee'){
                $data['affacted_rows'] = $this->db->affected_rows();
                $data['query'] = $this->db->last_query();
                return $data;
            }else{
                $this->db->select('*');
                $this->db->from('product');
                $this->db->join('coffee', 'product.id = coffee.product_id');
                $this->db->where('coffee.product_id', $id);
                $data['product'] = $this->db->get()->result_array();
                $data['affacted_rows'] = $this->db->affected_rows();
                $data['query'] = $this->db->last_query();
                return $data;
            }
        }
    }

    public function countProduct($keyword = null){
        $this->db->like('name', $keyword);
        $this->db->from('product');
        $data['product'] =  $this->db->count_all_results();
        $data['affacted_rows'] = $this->db->affected_rows();
        $data['query'] = $this->db->last_query();
        return $data;
    }

    public function createProduct($data){
        $this->db->insert('product', $data);
        $productId = $this->db->insert_id();
        return $productId;
    }

    public function createProductCoffee($dataCoffee){
        $this->db->insert('coffee', $dataCoffee);
        return $this->db->affected_rows();
    }

    public function updateProduct($data, $id){
        $this->db->update('product', $data,  ['id'=>$id]);
        return $this->db->affected_rows();
    }

    public function updateProductCoffee($dataCoffee){
        $this->db->update('coffee', $dataCoffee, ['coffee.product_id' => $dataCoffee['product_id']]);
        return $this->db->affected_rows();
    }

    public function deleteProduct($id){
        $this->db->delete('product', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteCoffee($productId){
        $this->db->delete('coffee', ['product_id' => $productId]);
        return $this->db->affected_rows();
    }

  


}