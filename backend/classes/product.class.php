<?php

require_once 'database.php';

class Product {
    public $id = '';
    public $product_code = '';
    public $product_name = '';
    public $category = '';
    public $size = '';
    public $price = '';
    public $stocks = '';
    public $sizePrice = '';

    protected $db;

    function __construct() {
        $this->db = new Database();
    }

    function add() {
        $sql = "INSERT INTO products (product_code, product_name, category, price, stocks) VALUES (:product_code, :product_name, :category, :price, :stocks);";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':product_code', $this->product_code);
        $query->bindParam(':product_name', $this->product_name);
        $query->bindParam(':category', $this->category);
        $query->bindParam(':price', $this->price);
        $query->bindParam(':stocks', $this->stocks);
        return $query->execute();
    }

    function showAll($keyword='', $category='') {
        $sql = "SELECT i.*, p.*, c.name as category_name, SUM(IF(s.change_type='addition', quantity, 0)) as stock_in, SUM(IF(s.change_type='subtraction', quantity, 0)) as stock_out FROM products p 
        INNER JOIN categories c ON p.category = c.id 
        LEFT JOIN product_image i ON p.id = i.product_id LEFT JOIN stock_transactions s ON p.id = s.product_id WHERE (p.product_code LIKE CONCAT('%', :keyword, '%') OR p.product_name LIKE CONCAT('%', :keyword, '%')) AND (c.name LIKE CONCAT('%', :category, '%')) GROUP BY p.id ORDER BY p.product_name ASC;";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':keyword', $keyword);
        $query->bindParam(':category', $category);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }

    function edit() {
        $sql = "UPDATE products SET product_code = :code, product_name = :name, category = :category_id, price = :price, stocks = :stocks WHERE id = :id;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':code', $this->product_code);
        $query->bindParam(':name', $this->product_name);
        $query->bindParam(':category_id', $this->category);
        $query->bindParam(':price', $this->price);
        $query->bindParam(':stocks', $this->stocks);
        $query->bindParam(':id', $this->id);
        return $query->execute();
    }

    function checkForEdit($code, $id){
        $sql = "SELECT COUNT(*) FROM products WHERE id = :id AND product_code = :code ;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':id', $id);
        $query->bindParam(':code', $code);

        if ($query->execute()) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
            return $data !== false;
        }
        return false;  
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

    function delete($recordID) {
        $sql = "DELETE FROM products WHERE id = :recordID;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':recordID', $recordID);
        return $query->execute();
    }

    function codeExists($code, $excludeID = null) {
        $sql = "SELECT COUNT(*) FROM products WHERE product_code = :code";
        if ($excludeID) {
            $sql .= " AND id != :excludeID";
        }
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':code', $code);
        if ($excludeID) {
            $query->bindParam(':excludeID', $excludeID);
        }
        $query->execute();
        $count = $query->fetchColumn();
        return $count > 0;
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

    function fetchCategoryName($id) {
        $sql = "SELECT name FROM categories WHERE id = :id;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':id', $id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }

    function fetchRecentOrders(){
        $sql = "SELECT orders.*, products.product_name FROM orders LEFT JOIN products ON orders.product_id = products.id ORDER BY orders.order_date DESC LIMIT 5;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function displayTopProd(){
        $sql = "SELECT p.*, c.name as category_name, pi.img FROM products p  INNER JOIN categories c ON p.category = c.id JOIN product_image pi ON p.id = pi.product_id LIMIT 4;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function getLastInsertedId(){
        $sql = "SELECT LAST_INSERT_ID() as id ;";
        $query = $this->db->connect()->prepare($sql);
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }

    function fetchProdNames(){
        $sql = "SELECT * FROM products;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function addProductSize($prodId){
        $sql = "INSERT INTO product_size (product_id, size, price) VALUES (:product_id, :size, :price);";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':product_id', $prodId);
        $query->bindParam(':size', $this->size);
        $query->bindParam(':price', $this->sizePrice);
        return $query->execute();
    }

    function deleteSize($sizeId) {
        $sql = "DELETE FROM product_size WHERE id = :id;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':id', $sizeId);
        return $query->execute();
    }

    function checkSizeDup($prodId){
        $sql = "SELECT * FROM product_size WHERE product_id = :product_id AND size = :size;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        $query->bindParam(':product_id', $prodId);
        $query->bindParam(':size', $this->size);
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function getSizesByProductId($prodId) {
        $sql = "SELECT * FROM product_size WHERE product_id = :product_id;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':product_id', $prodId);
        $data = null;

        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function getSizesBySizeId($sizeId) {
        $sql = "SELECT * FROM product_size WHERE id = :id;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':id', $sizeId);
        $data = null;
        
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function forProdPage() {
        $sql = "SELECT COUNT(*) AS total FROM products WHERE 1=1"; // Add conditions dynamically if needed
        $query = $this->db->connect()->prepare($sql);
    
        if ($query->execute()) {
            return $query->fetchColumn(); // Return the total count directly
        }
        return 0; // Default if no products found
    }

    function modifyProdStock(){
        $sql = "UPDATE products SET stocks = :stocks WHERE id = :id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':stocks', $this->stocks);
        $query->bindParam(':id', $this->id);
        return $query->execute();
    }
}
