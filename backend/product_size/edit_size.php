<?php
    
    require_once "../tools/functions.php";
    require_once "../classes/product_size.class.php";

    include_once "../includes/header.php";


    $productSizeObj = new ProductSize();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $productSizeObj->size_id = $id;
            $record = $productSizeObj->fetchProdSizeBySizeId();

            if (empty($record)) {
                $_SESSION["outputMsg"]["error"] = 'No product found';
                header("location: /backend/dashboard/inventory.php");
                exit;

            } 
        } else {
            $_SESSION["outputMsg"]["error"] = 'No product found';
            header("location: /backend/dashboard/inventory.php");
            exit;
        }
    }
     if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_prodSize'])){
        $id = $_GET['id'];
        $size_name = clean_input($_POST['size_name']);
        $sizePrice = clean_input($_POST['sizePrice']);
        $stock = clean_input($_POST['stock']);

            try{

                $productSizeObj->size_id = $id;
                $productSizeObj->size = $size_name;
                $productSizeObj->stock = $stock;
                $productSizeObj->price = $sizePrice;
                
                
                if($productSizeObj->updateSize()){
                    $_SESSION["outputMsg"]["success"] = "Product Size successfully updated";
                    header("location: /backend/dashboard/inventory.php");
                } else {
                    $error = "Failed updating product size";

                }
            }  catch (PDOException $e) {
                $error = "Error: " . $e->getMessage();
          }
    }

?>

<body>
<?php include_once "../includes/sidebar.php" ?>
<div class=" main-content">
        <div class="header">
            <h1 class=" text-2xl text-center">Edit Product</h1>
        </div>
<div class="flex flex-col justify-start ">
   
    <form action="" method="post" class="w-[450px]">
    <p class="text-semibold text-2xl text-customOrange text-center">Edit Product Size</p>
            
    <label for="size_name">Size Name:</label>
    <input type="text" name="size_name" value="<?= $record[0]['size'] ?>" required>
    <label for="sizePrice" class="mt-3">Size Price:</label>
    <input type="number" name="sizePrice" value="<?=  $record[0]['price'] ?>" min="1" required>
    <label for="stock" class="mt-3">Stock:</label>
    <input type="number" name="stock" value="<?=  $record[0]['stock'] ?>" min="1" required>

    <div class="flex items-center gap-3 mt-3 w-full">
        <input type="submit" name="edit_prodSize" value="Save changes"
            class="py-2 px-4 text-white bg-customOrange rounded-md text-center flex-1">
        <button type="button" id="closeModal" class="py-2 px-4 bg-red-700 text-white rounded-md flex-1">Cancel</button>
    </div>
</form>
</div>
</div>
</body>
