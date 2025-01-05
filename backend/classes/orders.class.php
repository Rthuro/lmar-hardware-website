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
        public $location_name = " ";
        public $pickup_date = " ";
        public $delivery_date = " ";
        public $payment = " ";
        public $price = " ";
        public $order_item_id = " ";
        protected $db;

        function __construct() {
            $this->db = new Database();
        }

        function showAllOrders($keyword='', $status = '', $delivery_option = '', $location,$start,$limit) {
            $sql = "SELECT  o.*, oi.*, s.size, p.product_name, u.username FROM orders o 
            LEFT JOIN order_items oi ON o.id = oi.order_id 
            LEFT JOIN product_size s ON oi.size_id = s.size_id 
            LEFT JOIN products p ON oi.product_id = p.id  
            LEFT JOIN users u ON o.customer_id = u.id
            WHERE (p.product_name LIKE CONCAT('%', :keyword, '%') 
            OR u.username LIKE  CONCAT('%', :keyword, '%'))
            AND o.status LIKE  CONCAT('%', :status, '%') 
            AND o.delivery_option LIKE  CONCAT('%', :delivery_option, '%') 
            ORDER BY o.order_date DESC ";

             if(!empty($location) && $location == 'dashboard'){
                $sql .= "LIMIT 10";
            }

            if(!empty($start) && !empty($limit)){
                $sql .= "LIMIT :start, :limit";
            }
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':keyword', $keyword);
            $query->bindParam(':status', $status);
            $query->bindParam(':delivery_option', $delivery_option);

            if(!empty($start) && !empty($limit)){   
            $query->bindParam(':start', $start, PDO::PARAM_INT);
            $query->bindParam(':limit', $limit, PDO::PARAM_INT);
            }

            $data = null;

            if ($query->execute()) {
                $data = $query->fetchAll();
            }
            return $data;
        }
        function getTotalOrders($keyword = '', $status = '', $delivery_option='') {
            $sql = "SELECT COUNT(DISTINCT o.id) AS total 
                    FROM orders o 
                    LEFT JOIN order_items oi ON o.id = oi.order_id 
                    LEFT JOIN product_size s ON oi.size_id = s.size_id 
                    LEFT JOIN products p ON oi.product_id = p.id  
                    LEFT JOIN users u ON o.customer_id = u.id
                    WHERE (p.product_name LIKE CONCAT('%', :keyword, '%') 
                    OR u.username LIKE  CONCAT('%', :keyword, '%'))
                    AND o.status LIKE  CONCAT('%', :status, '%') 
                    AND o.delivery_option LIKE  CONCAT('%', :delivery_option, '%'); ";
        
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':keyword', $keyword);
            $query->bindParam(':status', $status);
            $query->bindParam(':delivery_option', $delivery_option);

            $query->execute();
            return $query->fetchColumn();
        }

        function createOrder(){
            $sql = "INSERT INTO orders ( customer_id, payment, address,location, contact_num, delivery_option, pickup_date, delivery_date) VALUES (:customer_id, :payment, :address,:location, :contact_num, :delivery_option, :pickup_date, :delivery_date ); ";

             $query = $this->db->connect()->prepare($sql);
             $query->bindParam(':customer_id', $this->customer_id);
             $query->bindParam(':payment', $this->payment);
             $query->bindParam(':address', $this->address);
             $query->bindParam(':location', $this->location_name);
             $query->bindParam(':contact_num', $this->contact_num);
             $query->bindParam(':delivery_option', $this->delivery_option);
             $query->bindParam(':pickup_date', $this->pickup_date);
             $query->bindParam(':delivery_date', $this->delivery_date);

             return $query->execute();
        }

        function createOrderItems(){
            $sql = "INSERT INTO order_items ( order_id, product_id, size_id, quantity, price) VALUES ( :order_id, :product_id, :size_id, :quantity, :price ); ";
             $query = $this->db->connect()->prepare($sql);
            
             $query->bindParam(':order_id', $this->id);
             $query->bindParam(':product_id', $this->product_id);
             $query->bindParam(':size_id', $this->size_id);
             $query->bindParam(':quantity', $this->quantity);
             $query->bindParam(':price', $this->price);

             return $query->execute();
        }

        function updateOrderStatus($orderId, $status){
            $sql = "UPDATE orders SET status = :status WHERE id = :id;";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':id', $orderId);
            $query->bindParam(':status', $status);

            return $query->execute();
        }
        function updateOrderPickupSced($pickup, $id){
            $sql = "UPDATE orders SET pickup_date = :pickup WHERE id = :id;";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':pickup', $pickup);
            $query->bindParam(':id', $id);

            return $query->execute();
        }
        function updateOrderDeliverySced($delivery, $id){
            $sql = "UPDATE orders SET delivery_date = :delivery WHERE id = :id;";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':delivery', $delivery);
            $query->bindParam(':id', $id);

            return $query->execute();
        }

        function fetchLocation (){
                $sql = "SELECT * FROM location; ";
                $query = $this->db->connect()->prepare($sql);
                $data = null;
                if ($query->execute()) {
                    $data = $query->fetchAll(PDO::FETCH_ASSOC);
                }
                return $data;
        }

        function editLocation ($name, $deliveryFee, $id){
            $sql = "UPDATE location SET name = :name , deliveryFee = :deliveryFee WHERE id = :id; ";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':name', $name);
            $query->bindParam(':deliveryFee', $deliveryFee);
            $query->bindParam(':id', $id);
            
            return $query->execute();
        
         }
         function addLocation ($name, $deliveryFee){
            $sql = "INSERT INTO location (name, deliveryFee ) VALUES ( :name , :deliveryFee ); ";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':name', $name);
            $query->bindParam(':deliveryFee', $deliveryFee);
            
            return $query->execute();
        
         }
         function deleteLocation ($id){
            $sql = "DELETE FROM location WHERE id = :id; ";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':id', $id);
            return $query->execute();
        
         }
       
        function fetchLocationById ($id){
            $sql = "SELECT * FROM location WHERE id = :id; ";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam('id', $id);

            $data = null;
            if ($query->execute()) {
                $data = $query->fetch();
            }

            return $data;
        
        }
        function fetchLocationByName (){
            $sql = "SELECT * FROM location WHERE name = :name; ";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam('name', $this->location_name);

            $data = null;
            if ($query->execute()) {
                $data = $query->fetch();
            }

            return $data;
        
        }
        function getDeliveryFee (){
            $sql = "SELECT deliveryFee FROM location WHERE name = :name";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':name', $this->location_name);

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
            $sql = "SELECT o.*,oi.* FROM orders o JOIN order_items oi ON o.id = oi.order_id WHERE o.customer_id = :customer_id AND o.delivery_option ='pickup' ";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':customer_id',$this->customer_id);

            $data = null;
            if ($query->execute()) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        }

        function getDeliveryCustomer(){
            $sql = "SELECT o.*,oi.* FROM orders o JOIN order_items oi ON o.id = oi.order_id WHERE o.customer_id = :customer_id AND o.delivery_option ='delivery' ";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':customer_id',$this->customer_id);

            $data = null;
            if ($query->execute()) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        }

        function getCompletedOrders(){
            $sql = "SELECT o.*,oi.* FROM orders o JOIN order_items oi ON o.id = oi.order_id WHERE o.customer_id = :customer_id AND status = 'completed' ";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':customer_id',$this->customer_id);

            $data = null;
            if ($query->execute()) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        }
        function getCancelledOrders(){
            $sql = "SELECT 
                    u.username,
                    o.id, 
                    o.contact_num, 
                    o.delivery_option, 
                    o.status, 
                    o.delivery_date, 
                    o.order_date, 
                    oi.quantity, 
                    p.product_name, 
                    s.size
                FROM orders o
                LEFT JOIN order_items oi ON o.id = oi.order_id
                LEFT JOIN users u ON o.customer_id = u.id
                LEFT JOIN products p ON oi.product_id = p.id
                LEFT JOIN product_size s ON oi.size_id = s.size_id
                WHERE o.customer_id = :customer_id AND status = 'cancelled' ";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':customer_id',$this->customer_id);

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

        function displayOnDashboard(){
            $sql = "SELECT 
                    u.username,
                    o.id, 
                    o.contact_num, 
                    o.delivery_option, 
                    o.status, 
                    o.order_date, 
                    oi.quantity, 
                    p.product_name, 
                    s.size
                FROM orders o
                LEFT JOIN order_items oi ON o.id = oi.order_id
                LEFT JOIN users u ON o.customer_id = u.id
                LEFT JOIN products p ON oi.product_id = p.id
                LEFT JOIN product_size s ON oi.size_id = s.size_id
                ORDER BY o.order_date DESC; ";
            $query = $this->db->connect()->prepare($sql);
            $data = null;
            if ($query->execute()) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        }

        function displayDeliveries(){
            $sql = "SELECT 
                    u.username,
                    o.id, 
                    o.contact_num, 
                    o.delivery_option, 
                    o.status, 
                    o.delivery_date, 
                    o.order_date, 
                    oi.quantity, 
                    p.product_name, 
                    s.size
                FROM orders o
                LEFT JOIN order_items oi ON o.id = oi.order_id
                LEFT JOIN users u ON o.customer_id = u.id
                LEFT JOIN products p ON oi.product_id = p.id
                LEFT JOIN product_size s ON oi.size_id = s.size_id
                WHERE o.delivery_option = 'delivery' AND o.customer_id = :customer_id AND (o.status = 'pending' OR o.status = 'to deliver') ORDER BY o.order_date ASC; ";
            $query = $this->db->connect()->prepare($sql);
            $query ->bindParam(':customer_id', $this->customer_id);
            $data = null;
            if ($query->execute()) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        }
        function displayPickUps(){
            $sql = "SELECT * FROM orders WHERE delivery_option = 'pickup' AND customer_id = :customer_id AND status = 'pending' ORDER BY order_date ASC; ";
            $query = $this->db->connect()->prepare($sql);
            $query ->bindParam(':customer_id', $this->customer_id);
            $data = null;
            if ($query->execute()) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        }

        function displayCompleted(){
            $sql = "SELECT * FROM orders WHERE customer_id = :customer_id AND status = 'completed' ORDER BY order_date DESC; ";
            $query = $this->db->connect()->prepare($sql);
            $query ->bindParam(':customer_id', $this->customer_id);
            $data = null;
            if ($query->execute()) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        }

        function fetchOrderById($id){
            $sql = "SELECT 
                u.username,
                u.email,
                o.id, 
                o.contact_num, 
                o.location, 
                o.address, 
                o.payment, 
                o.delivery_option, 
                o.status, 
                o.pickup_date, 
                o.delivery_date, 
                o.order_date, 
                oi.quantity, 
                oi.size_id, 
                p.product_name, 
                s.size,
                s.stock
            FROM orders o
            LEFT JOIN order_items oi ON o.id = oi.order_id
            LEFT JOIN users u ON o.customer_id = u.id
            LEFT JOIN products p ON oi.product_id = p.id
            LEFT JOIN product_size s ON oi.size_id = s.size_id
            WHERE o.id = :id";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':id', $id);
            $data = null;
            if ($query->execute()) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;

        }

        function updateProdStockIfCancelled($stock){
            $sql = 'UPDATE product_size SET stock = :stock WHERE size_id = :size_id;';
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':stock', $stock);
            $query->bindParam(':size_id', $this->size_id);

            return $query->execute();
        }

        function getOrderItems(){
            $sql = 'SELECT oi.*, s.* FROM order_items oi JOIN product_size s ON oi.size_id = s.size_id WHERE oi.order_item_id = :id;';
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':id', $this->order_item_id);
            return $query->execute();
        }

        function fetchOrder(){
            $sql = "SELECT * FROM orders WHERE customer_id = :customer_id;";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':customer_id', $this->customer_id);
            $data = null;
            if ($query->execute()) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        }

        function fetchOrderItems($order_id){
            $sql = "SELECT oi.*, p.product_name, p.product_img, s.size FROM order_items oi 
            JOIN products p ON oi.product_id = p.id JOIN product_size s ON oi.size_id = s.size_id
            WHERE oi.order_id = :id;";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':id', $order_id);
            $data = null;
            if ($query->execute()) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;

        }

        function getOrdersByMonth($currMonth, $status='', $option = ''){
            $sql = "SELECT COUNT(*) as total FROM orders WHERE MONTH(order_date) = :month AND delivery_option LIKE CONCAT('%', :option, '%') AND status LIKE CONCAT('%', :status, '%')";

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':month', $currMonth, PDO::PARAM_INT);
            $query->bindParam(':option', $option);
            $query->bindParam(':status', $status);

            $query->execute();
            return $query->fetchColumn();
        }

        
    }

?>