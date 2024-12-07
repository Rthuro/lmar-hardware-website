<?php

require_once 'product.class.php';

class ProductImage extends Product{
    public $file_path = '';

    function addImage($prodId) {
        $sql = "INSERT INTO product_image (product_id, img) VALUES (:product_id, :img);";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':product_id',$prodId);
        $query->bindParam(':img', $this->file_path);
        return $query->execute();
    }

    function fetchImage($id){
        $sql = "SELECT * FROM product_image WHERE product_id=:id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':id', $id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }
}