<?php

require_once 'database.php';

class Product {
    public $id = '';
    public $code = '';
    public $name = '';
    public $category_id = '';
    public $price = '';

    protected $db;

    function __construct() {
        $this->db = new Database();
    }

    function add() {
        $sql = "INSERT INTO products (code, name, category_id, price) VALUES (:code, :name, :category_id, :price);";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':code', $this->code);
        $query->bindParam(':name', $this->name);
        $query->bindParam(':category_id', $this->category_id);
        $query->bindParam(':price', $this->price);
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
        $sql = "UPDATE products SET code = :code, name = :name, category_id = :category_id, price = :price WHERE id = :id;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':code', $this->code);
        $query->bindParam(':name', $this->name);
        $query->bindParam(':category_id', $this->category_id);
        $query->bindParam(':price', $this->price);
        $query->bindParam(':id', $this->id);
        return $query->execute();
    }

    function fetchRecord($recordID) {
        $sql = "SELECT * FROM products WHERE id = :recordID;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':recordID', $recordID);
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
        $sql = "SELECT COUNT(*) FROM products WHERE code = :code";
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

    function fetchRecentOrders(){
        $sql = "SELECT orders.*, products.product_name FROM orders LEFT JOIN products ON orders.product_id = products.id ORDER BY orders.order_date DESC LIMIT 5;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

   
}
