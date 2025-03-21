<?php
    require_once "database.php";

    class Cart{
        public $id = " ";
        public $user_id = " ";
        public $product_id = " ";
        public $size_id = " ";
        public $quantity = " ";
        public $price = " ";

        protected $db;

        function __construct(){
            $this->db = new Database();
        }

        function add(){

            $sql = "INSERT INTO cart (user_id, product_id, size_id, quantity, price) VALUES (:user_id, :product_id, :size_id, :quantity, :price);";
            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':user_id', $this->user_id);
            $query->bindParam(':product_id', $this->product_id);
            $query->bindParam(':size_id', $this->size_id);
            $query->bindParam(':quantity', $this->quantity);

            $getSizePrice = "SELECT price FROM product_size WHERE size_id =:size_id";
            $result = $this->db->connect()->prepare($getSizePrice);
            $result->bindParam(':size_id', $this->size_id);

            $data=null;
            if($result->execute()){
                $data = $result->fetch();
                $this->price = $data['price'];
            }

            $query->bindParam(':price', $this->price);
            
            return $query->execute();
        }

        function delete(){
            $sql = "DELETE FROM cart WHERE id = :id  ";
            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':id', $this->id);

            return $query->execute();

        }

        function fetchCart(){
            $sql = "SELECT * FROM cart WHERE user_id = :user_id;";
            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':user_id', $this->user_id);
            $data = null;

            if ($query->execute()) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        }

        function check(){
            $sql = "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id AND size_id = :size_id;";
            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':user_id', $this->user_id);
            $query->bindParam(':product_id', $this->product_id);
            $query->bindParam(':size_id', $this->size_id);
            $data = null;

            if ($query->execute()) {
                $data = $query->fetchAll();
            }
            return $data;
        }



        function update() {
            $sql = "UPDATE cart SET quantity = :quantity WHERE id = :id";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':id', $this->id);
            $query->bindParam(':quantity', $this->quantity);
            return $query->execute();
        }
    }

?>