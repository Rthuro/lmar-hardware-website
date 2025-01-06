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
        $sql = "SELECT p.*, c.name as category_name, SUM(oi.quantity) AS total_quantity_sold  FROM products p  INNER JOIN categories c ON p.category = c.id LEFT JOIN order_items oi ON p.id = oi.product_id LEFT JOIN orders o ON oi.order_id = o.id WHERE o.status = 'completed' GROUP BY p.id ORDER BY total_quantity_sold DESC LIMIT 4;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function getProducts($start, $limit, $search = '', $filter_category = '', $filter_price = null) {
        $sql = "SELECT p.*, c.name AS category_name 
                FROM products p 
                INNER JOIN categories c ON p.category = c.id 
                INNER JOIN product_size ps ON p.id = ps.product_id 
                WHERE p.product_name LIKE CONCAT('%', :search, '%') 
                AND c.name LIKE CONCAT('%', :category, '%')";
    
        if (!is_null($filter_price)) {
            $sql .= " AND ps.price <= :price ";
        }
    
        $sql .= " GROUP BY p.id ORDER BY ps.price DESC LIMIT :start, :limit ";
    
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':start', $start, PDO::PARAM_INT);
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
        $query->bindParam(':search', $search);
        $query->bindParam(':category', $filter_category);
    
        if (!is_null($filter_price)) {
            $query->bindParam(':price', $filter_price);
        }
    
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    function getTotalProducts($search = '', $filter_category = '', $filter_price = null) {
        $sql = "SELECT COUNT(DISTINCT p.id) AS total 
                FROM products p 
                INNER JOIN categories c ON p.category = c.id 
                INNER JOIN product_size ps ON p.id = ps.product_id 
                WHERE p.product_name LIKE CONCAT('%', :search, '%') 
                AND c.name LIKE CONCAT('%', :category, '%')";
    
        if (!is_null($filter_price)) {
            $sql .= " AND ps.price <= :price";
        }
    
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':search', $search);
        $query->bindParam(':category', $filter_category);
    
        if (!is_null($filter_price)) {
            $query->bindParam(':price', $filter_price);
        }
    
        $query->execute();
        return $query->fetchColumn();
    }

    function fetchAllProducts(){
        $sql = "SELECT COUNT(*) as total FROM products";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if($query->execute()){
            $data = $query->fetchColumn();
        }
       return $data; 
    }
    
    function getMaxSizePrice(){
        $sql = "SELECT MAX(price) as maxPrice FROM product_size";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if($query->execute()){
            $data = $query->fetch();
            return $data;
        }
        return $data;
    }
  
    function getProductsInventory($start, $limit, $search = '', $filter_category = '', $filter_price = null) {
        $sql = "SELECT p.*, c.name AS category_name 
                FROM products p 
                INNER JOIN categories c ON p.category = c.id 
             
                WHERE p.product_name LIKE CONCAT('%', :search, '%') 
                AND c.name LIKE CONCAT('%', :category, '%') GROUP BY p.id  LIMIT :start, :limit ";
    
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':start', $start, PDO::PARAM_INT);
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
        $query->bindParam(':search', $search);
        $query->bindParam(':category', $filter_category);

    
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    function getTotalProductsInventory($search = '', $filter_category = '', $filter_price = null) {
        $sql = "SELECT COUNT(DISTINCT p.id) AS total 
                FROM products p 
                INNER JOIN categories c ON p.category = c.id  
                WHERE p.product_name LIKE CONCAT('%', :search, '%') 
                AND c.name LIKE CONCAT('%', :category, '%')";
    
       
    
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':search', $search);
        $query->bindParam(':category', $filter_category);
    
    
        $query->execute();
        return $query->fetchColumn();
    }

    function getLastInsertedId(){
        $sql = "SELECT LAST_INSERT_ID() as id ;";
        $query = $this->db->connect()->prepare($sql);
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }
}
