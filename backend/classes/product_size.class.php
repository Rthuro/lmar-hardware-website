
<?php 
    require_once 'product.class.php';

    class ProductSize extends Product{
        public $size_id = '';
        public $product_id = '';
        public $size = '';
        public $stock = '';
        public $price = '';

        function addSize(){
            $sql = "INSERT INTO product_size ( product_id, size, stock, price ) VALUES (:product_id, :size, :stock, :price)";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':product_id', $this->product_id);
            $query->bindParam(':size', $this->size);
            $query->bindParam(':stock', $this->stock);
            $query->bindParam(':price', $this->price);
            return $query->execute();
        }
        
        function updateSize(){
            $sql = "UPDATE product_size SET size = :size , stock = :stock, price = :price WHERE size_id = :size_id;";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':size', $this->size);
            $query->bindParam(':size_id', $this->size_id);
            $query->bindParam(':stock', $this->stock);
            $query->bindParam(':price', $this->price);
            return $query->execute();
        }
        function fetchProdSizeById(){
            $sql = "SELECT * from product_size WHERE product_id = :product_id";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':product_id', $this->product_id);
            $data = null;

            if($query->execute()){
                $data = $query->fetchAll();
                return $data;
            }
            return $data;
        }
        function fetchProdSizeBySizeId(){
            $sql = "SELECT * from product_size WHERE size_id = :size_id";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':size_id', $this->size_id);
            $data = null;

            if($query->execute()){
                $data = $query->fetchAll();
                return $data;
            }
            return $data;
        }

        function fetchAllProdSize(){
            $sql = "SELECT * from product_size;";
            $query = $this->db->connect()->prepare($sql);
            $data = null;

            if($query->execute()){
                $data = $query->fetchAll();
                return $data;
            }
            return $data;
        }

        function deleteSize(){
            $sql = "DELETE FROM product_size WHERE size_id = :size_id";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':size_id', $this->size_id);
            return $query->execute();
        }

        function checkSizeDup($prodId){
        $sql = "SELECT * FROM product_size WHERE product_id = :product_id AND size = :size ;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        $query->bindParam(':product_id', $prodId);
        $query->bindParam(':size', $this->size);
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
         }

         function fetchPriceToDisplay($display){
        
            if($display === "landing_page"){
                $sql = "SELECT MIN(price) as minPrice from product_size WHERE product_id = :product_id";
            } else if ($display === "product"){
                $sql = "SELECT MIN(price) as minPrice, MAX(price) as maxPrice from product_size WHERE product_id = :product_id";
            }
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':product_id', $this->product_id);
            $data = null;

            if($query->execute()){
                $data = $query->fetch();
                return $data;
            }
            return $data;
        }
    

        function modifyProdStock(){
            $sql = "UPDATE product_size SET stock = :stock WHERE size_id = :size_id";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':stock', $this->stock);
            $query->bindParam(':size_id', $this->size_id);
            return $query->execute();
        }


    }
