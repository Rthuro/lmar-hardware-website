<?php
    require_once "database.php";

    class Cart{
        public $user_id = " ";
        public $product_code = " ";

        protected $db;

        function __construct(){
            $this->db = new Database();
        }

        function add(){
            $sql = "INSERT INTO cart (user_id, product_code) VALUES (:user_id, :product_code);";
            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':user_id', $this->user_id);
            $query->bindParam(':product_code', $this->product_code);

            return $query->execute();
        }

        function delete(){
            $sql = "DELETE FROM cart WHERE product_code = :product_code AND user_id = :user_id; ";
            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':user_id', $this->user_id);
            $query->bindParam(':product_code', $this->product_code);

            return $query->execute();

        }

        function fetchCart(){
            $sql = "SELECT c.*, p.* FROM cart c JOIN products p ON p.product_code = c.product_code WHERE user_id = :user_id;";
            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':user_id', $this->user_id);
            $data = null;

            if ($query->execute()) {
                $data = $query->fetchAll();
            }
            return $data;
        }
    }

?>