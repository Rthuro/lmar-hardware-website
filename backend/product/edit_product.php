<?php

    require_once "../classes/product.class.php";
    require_once "../classes/product-image.class.php";
    require_once "../tools/functions.php";

    include_once "../includes/header.php";

    $productObj = new Product();

    $error = $success = $e = $id = $product_code = $product_name  = $size = $category = $price = $stocks = $data = $categoryId = $record = "";

    $categories = $productObj->fetchCategory();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
       
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $record = $productObj->fetchRecord($id); 
            if (!empty($record)) {
                $product_code = $record['product_code'];
                $product_name = $record['product_name'];
                $category = $record['category'];
                $price = $record['price'];
                $stocks = $record['stocks'];

            } else {
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
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $product_name = clean_input($_POST['product_name']) ?? "";
        $category = clean_input($_POST['category']) ?? "";
        $price = clean_input($_POST['price']) ?? "";
        $stocks = clean_input($_POST['stocks']) ?? "";

        if(isset($_POST['edit_prod'])){
            try{
                $id = $_GET['id'];
                $record = $productObj->fetchRecord($id); 
                if (!empty($record)) {
                    $product_code = $record['product_code'];
                }
               
    
                if(isset($_POST['edit_prod'])){
                  
                    $productObj->id = $id;
                    $productObj->product_code = $product_code;
                    $productObj->product_name = $product_name;
                    $productObj->category = $category;
                    $productObj->size = $size;
                    $productObj->price = $price;
                    $productObj->stocks = $stocks;
    
                    if( $productObj->edit()){
                        $_SESSION['outputMsg']['success'] = "Product information successfully updated";
                        header("location: /backend/dashboard/inventory.php");
    
                  } else {
                     $error = "Failed updating product information";
                  }
                }
               
             }  catch (PDOException $e) {
                        $error = "Error: " . $e->getMessage();
            }
    
        }

        if(isset($_POST['delete_size'])){
           $size =  $_POST['product_size'];

           if($productObj->deleteSize($size)){
            $_SESSION['outputMsg']['success'] = "Product size successfully deleted";
            header("location: /backend/dashboard/inventory.php");
           } else {
              $error = "Failed to delete product size";
           }
           try{

           }  catch (PDOException $e) {
                        $error = "Error: " . $e->getMessage();
            }
        }
        
        $formSubmitted = true;
    } else {
        $formSubmitted = false;
    }
    

?>

<body>
    
        <?php if (!empty($error)) { 
            ?> <p id="err" class="err flex justify-center fixed top-0 left-0 right-0 py-5 bg-red-600 text-white z-40"><?= $error ?></p> <?php }
        ?>
        <?php if (!empty($e)) { 
            ?> <p id="err" class="err flex justify-center fixed top-0 left-0 right-0 py-5 bg-red-600 text-white z-40">
                <?= $e ?>
            </p> <?php }
        ?>
         <?php if (!empty($success)) { 
            ?> <p id="succ" class="succ flex justify-center fixed top-0 left-0 right-0 py-5 bg-green-600 text-white z-50">
                <?= $success ?>
            </p> <?php }
        ?>
    <?php include_once "../includes/sidebar.php" ?>
    <div class=" main-content">
        <div class="header">
            <h1 class=" text-2xl text-center">Edit Product</h1>
        </div>
         <div class="flex items-start justify-center">
            <form action="" method="POST">
                    <label for="product_code">Product Code:</label>
                    <input type="text"  value="<?= isset($product_code)? $product_code:"" ?>"  >

                    <label for="product_name">Name:</label>
                    <input type="text" name="product_name" value="<?= isset($product_name)? $product_name:"" ?>" required>

                    <label for="category">Category:</label>
                    <select name="category" required>
                        <?php foreach($categories as $categoryName){ 
                            ?>
                            <option value="<?= $categoryName['id'] ?>" <?= isset($category) && $category == $categoryName['id']? "selected" : "" ?>>
                                <?= $categoryName['name'] ?>
                            </option>

                        <?php }  ?>

                        </php>
                    </select>

                    <label for="price">Price:</label>
                    <input type="number" name="price" value="<?= isset($price)? $price:"" ?>" required>

                    <label for="stocks">Stocks:</label>
                    <input type="number" name="stocks"  value="<?= isset($stocks)? $stocks:"" ?>" required>
                    <input type="submit" value="Save changes" name="edit_prod" class="w-full bg-[#ff8c00] py-2 px-6 rounded-md text-white"  onclick="return confirm('Are you sure?')">

                </form>
                       
                <form method="POST">
                <p class="text-lg font-medium mb-2">Delete Product Size</p>
                <label for="product_size">Product Size:</label>
                <?php  $productSize = $productObj->getSizesByProductId($_GET['id'])  ?>
                <select name="product_size" required>
                    <?php if(!empty($productSize)){ foreach($productSize as $arr){ ?>

                         <option value="<?= $arr['id'] ?>" <?= isset($productName_size) && $productName_size == $arr['id'] ? "selected" : "" ?>>
                            <?= $arr['size'] ?>
                        </option>

                    <?php } } 
                    ?>
                
                </select>
                <input type="submit" value="Delete Product Size" name="delete_size" class="w-full bg-red-600 py-2 px-6 rounded-md"  onclick="return confirm('Are you sure?')" >
            </form>
           
         
        </div>
    </div>
    <script>
       

        const err = document.getElementById('err');
        const succ = document.getElementById('succ');

        if(err !== null){
            err.addEventListener( ('click'), ()=>{
            err.classList.replace("flex", "hidden");
        } )
        }
       

        if(succ !== null){
            succ.addEventListener( ('click'), ()=>{
            succ.classList.replace("flex", "hidden");
             } )
        }  

        const modal = document.getElementById('confirmationModal');
        const openModalButton = document.getElementById('openModal');
        const closeModalButton = document.getElementById('closeModal');

        

        openModalButton.addEventListener('click', () => {
            modal.classList.remove('hidden'); 
            modal.classList.add('flex');
        });
       
        closeModalButton.addEventListener('click', () => {
            modal.classList.remove('flex'); 
            modal.classList.add('hidden');
        });

    </script>
</body>
</html>