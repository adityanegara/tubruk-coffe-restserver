<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Product extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Product_model');
        
    }

    

   public function index_get(){
       $id = $this->get('id');
       if($id == null){
            $product = $this->Product_model->getProduct();
       }else{
            $product = $this->Product_model->getProduct($id);
       }
       if($product == true){
        $this->response( [
            'status' => true,
            'data' => $product
            ], RestController::HTTP_OK );
       }else{
        $this->response( [
            'status' => false,
            'messege' => 'product not found!'
        ], RestController::HTTP_NOT_FOUND );
       }
   }

   public function index_post(){
       $data = [
           'name' => $this->post('name'),
           'price' => $this->post('price'),
           'weight' => $this->post('weight'),
           'quantity' => $this->post('quantity'),
           'product_image' => $this->post('product_image'),
           'background_image' => $this->post('background_image'),
           'category' => $this->post('category'),
           'description' => $this->post('description')
       ];
        $productId = $this->Product_model->createProduct($data);
        if($productId > 0){
            if($data['category'] == "coffee"){
                $dataCoffee = [
                    'product_id' => $productId,
                    'coffee_origin' => $this->post('coffee_origin'),
                    'roast_level' => $this->post('roast_level'),
                    'taste_like' => $this->post('taste_like'),
                    'altitude' => $this->post('altitude'),
                    'coffee_variety' => $this->post('coffee_variety'),
                    'processing' => $this->post('processing')
                ];
                $this->Product_model->createProductCoffee($dataCoffee);
            }
            $this->response( [
                'status' => true,
                'messege' => 'New product has been created!'
            ], RestController::HTTP_CREATED );
        }else{
            $this->response( [
                'status' => false,
                'messege' => 'Failed to create new product!'
            ], RestController::HTTP_BAD_REQUEST );
        } 
   }

    public function index_put(){
        $id = $this->put('id');
        $data = [
            'name' => $this->put('name'),
            'price' => $this->put('price'),
            'weight' => $this->put('weight'),
            'quantity' => $this->put('quantity'),
            'product_image' => $this->put('product_image'),
            'background_image' => $this->put('background_image'),
            'category' => $this->put('category'),
            'description' => $this->put('description')
        ];
        
        if($this->Product_model->updateProduct($data, $id) > 0){
            $this->response( [
                'status' => true,
                'messege' => 'Product has been updated'
            ], RestController::HTTP_OK );
        }else{
            $this->response( [
                'status' => true,
                'messege' => 'Failed to update  product'
            ], RestController::HTTP_BAD_REQUEST );
        }
    }
    
    public function index_delete(){
        $id = $this->delete('id');
        if($id === null){
            $this->response( [
                'status' => false,
                'messege' => 'Delete : provide an id!'
            ], RestController::HTTP_BAD_REQUEST );
        }else{
            if($this->Product_model->deleteProduct($id) > 0){
                $this->response( [
                    'status' => true,
                    'messege' => 'Product Deleted'
                ], RestController::HTTP_OK );
            }else{
                $this->response( [
                    'status' => false,
                    'messege' => 'Delete: ID not found!'
                ], RestController::HTTP_NOT_FOUND );
            }
        }
    }

    public function coffee_get(){
        $productId = $this->get('id');
        $productCoffee = $this->Product_model->getCoffeProduct($productId);
        if($productCoffee == true){
            $this->response( [
                'status' => true,
                'data' => $productCoffee
                ], RestController::HTTP_OK );
        }else{
            $this->response( [
                'status' => false,
                'messege' => 'product coffee not found!'
            ], RestController::HTTP_NOT_FOUND );
        }

    }

   
}