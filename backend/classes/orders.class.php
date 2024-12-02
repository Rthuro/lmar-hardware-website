<?php
    require_once 'database.php';
    
    class Order {
        public $product_id = " ";
        public $address = " ";
        public $quantity = " ";
        public $customer_name = " ";
        public $delivery_option = " ";
        public $pickup_date = " ";
        public $delivery_date = " ";
        protected $db;

        function __construct() {
            $this->db = new Database();
        }

        function createOrder(){
            $sql = "INSERT INTO orders ( product_id,quantity, customer_name, address, delivery_option, pickup_date, delivery_date) VALUES (:product_id,:quantity, :customer_name, :address, :delivery_option, :pickup_date, :delivery_date ); ";

             $query = $this->db->connect()->prepare($sql);
             $query->bindParam(':product_id', $this->product_id);
             $query->bindParam(':quantity', $this->quantity);
             $query->bindParam(':customer_name', $this->customer_name);
             $query->bindParam(':address', $this->address);
             $query->bindParam(':delivery_option', $this->delivery_option);
             $query->bindParam(':pickup_date', $this->pickup_date);
             $query->bindParam(':pickup_date', $this->delivery_date);

             return $query->execute();
        }

        function updateOrderStatus($customer, $orderId){
            $sql = "UPDATE orders SET status = :status WHERE customer_name = :customer_name AND product_id = :product_id;";
            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':customer_name', $customer);
            $query->bindParam(':product_id', $orderId);

            return $query->execute();
        }

        
    }

?>