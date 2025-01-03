<?php

require_once 'database.php';

class Product {
    public $id = '';
    public $product_name = '';
    public $product_img = '';
    public $category = '';
    public $description = '';
    protected $db;

    function __construct() {
        $this->db = new Database();
    }

    function add() {
        $sql = "INSERT INTO products (product_name, product_img, category, description) VALUES (:product_name, :product_img, :category, :description);";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':product_name', $this->product_name);
        $query->bindParam(':product_img', $this->product_img);
        $query->bindParam(':category', $this->category);
        $query->bindParam(':description', $this->description);
        return $query->execute();
    }

    function update(){
        $sql = "UPDATE products SET product_name = :product_name, category = :category, description = :description WHERE id = :id ;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':id', $this->id);
        $query->bindParam(':product_name', $this->product_name);
        $query->bindParam(':category', $this->category);
        $query->bindParam(':description', $this->description);
        return $query->execute();
    }
    
    function delete(){
        $sql = "DELETE FROM products WHERE id = :id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':id', $this->id);
        return $query->execute();
        
    }

    function showAll($keyword='', $category='') {
        $sql = "SELECT  p.*, c.name as category_name FROM products p INNER JOIN categories c ON p.category = c.id 
        WHERE p.product_name LIKE CONCAT('%', :keyword, '%') AND (c.name LIKE CONCAT('%', :category, '%')) GROUP BY p.id ORDER BY p.product_name ASC;";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':keyword', $keyword);
        $query->bindParam(':category', $category);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }


    function checkProductDup(){
        $sql = "SELECT * FROM products WHERE product_name = :product_name;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':product_name', $this->product_name);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }

     function fetchRecord($id) {
        $sql = "SELECT * FROM products WHERE id = :id;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':id', $id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }
    function fetchCategory() {
        $sql = "SELECT * FROM categories ORDER BY name ASC;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    function fetchCategoryById($id) {
        $sql = "SELECT * FROM categories WHERE id = :id ;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':id', $id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    function fetchCategoryByName($name) {
        $sql = "SELECT * FROM categories WHERE name = :name ;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':name', $name);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    function editCategory($id, $name) {
        $sql = "UPDATE categories SET name = :name WHERE id = :id ;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':name', $name);
        $query->bindParam(':id', $id);
        return $query->execute();
    }
    function addCategory( $name) {
        $sql = "INSERT INTO categories (name) VALUES (:name) ;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':name', $name);
        return $query->execute();
    }
    function deleteCategory( $id) {
        $sql = "DELETE FROM categories WHERE id = :id ;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':id', $id);
        return $query->execute();
    }


     function displayTopProd(){
        $sql = "SELECT p.*, c.name as category_name FROM products p  INNER JOIN categories c ON p.category = c.id LIMIT 4;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function getProducts($start, $limit, $search = '',  $filter_category= '') {
        $sql = "SELECT p.*,c.name as category_name FROM products p INNER JOIN categories c ON p.category = c.id  WHERE p.product_name LIKE CONCAT('%', :search, '%') AND c.name LIKE CONCAT('%', :category, '%') LIMIT :start, :limit";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':start', $start, PDO::PARAM_INT);
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
        $query->bindParam(':search', $search);
        $query->bindParam(':category', $filter_category);

        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    function getTotalProducts() {
        $sql = "SELECT COUNT(*) AS total FROM products";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }

 

    

    
}
