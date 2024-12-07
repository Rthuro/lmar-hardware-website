<?php
    require_once 'database.php';
    
    class Order {
        public $id = " ";
        public $product_id = " ";
        public $size_id = " ";
        public $address = " ";
        public $contact_num = " ";
        public $quantity = " ";
        public $customer_id = " ";
        public $delivery_option = " ";
        public $pickup_date = " ";
        public $delivery_date = " ";
        public $location = " ";
        public $payment = " ";
        protected $db;

        function __construct() {
            $this->db = new Database();
        }

        function createOrder(){
            $sql = "INSERT INTO orders ( product_id,size_id, quantity, customer_id, payment, address, contact_num, delivery_option, pickup_date, delivery_date) VALUES (:product_id,:size_id, :quantity, :customer_id, :payment, :address, 
            :contact_num, :delivery_option, :pickup_date, :delivery_date ); ";

             $query = $this->db->connect()->prepare($sql);
             $query->bindParam(':product_id', $this->product_id);
             $query->bindParam(':size_id', $this->size_id);
             $query->bindParam(':quantity', $this->quantity);
             $query->bindParam(':customer_id', $this->customer_id);
             $query->bindParam(':payment', $this->payment);
             $query->bindParam(':address', $this->address);
             $query->bindParam(':contact_num', $this->contact_num);
             $query->bindParam(':delivery_option', $this->delivery_option);
             $query->bindParam(':pickup_date', $this->pickup_date);
             $query->bindParam(':delivery_date', $this->delivery_date);

             return $query->execute();
        }

        function updateOrderStatus($customer, $orderId){
            $sql = "UPDATE orders SET status = :status WHERE customer_id = :customer_id AND id = :id;";
            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':customer_id', $customer);
            $query->bindParam(':cart_id', $orderId);

            return $query->execute();
        }

        function fetchLocation (){
                $sql = "SELECT * FROM location";
                $query = $this->db->connect()->prepare($sql);
                $data = null;
                if ($query->execute()) {
                    $data = $query->fetchAll(PDO::FETCH_ASSOC);
                }
                return $data;
            
        }
        function getDeliveryFee ($name){
            $sql = "SELECT deliveryFee FROM location WHERE name = :name";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':name', $name);

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
        
        function getPickUpOrderCustomer(){
            $sql = "SELECT * FROM orders WHERE customer_id = :customer_id AND delivery_option ='pickup' ";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':customer_id',$this->customer_id);

            $data = null;
            if ($query->execute()) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        }

        function getDeliveryCustomer(){
            $sql = "SELECT * FROM orders WHERE customer_id = :customer_id AND delivery_option ='delivery' ";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':customer_id',$this->customer_id);

            $data = null;
            if ($query->execute()) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        }

        
    }

?>