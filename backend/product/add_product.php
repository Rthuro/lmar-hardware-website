<?php

    require_once "../classes/product.class.php";
    require_once "../classes/product-image.class.php";
    require_once "../tools/functions.php";
    include_once "../includes/header.php";

    $productObj = new Product();

    $error = $success = $e = $product_code = $product_name = $size = $category = $price = $stocks = $data = $categoryId = $image = $imageTemp = $imageErr = "";

    $categories = $productObj->fetchCategory();
   
    $productImgObj = new ProductImage();

    if($_SERVER['REQUEST_METHOD'] == "POST" ){

    
        if(isset($_POST['add_prod'])){

            $product_code = clean_input($_POST['product_code']);
            $product_name = clean_input($_POST['product_name']);
            $category = clean_input($_POST['category']);
            $price = clean_input($_POST['price']);
            $stocks = clean_input($_POST['stocks']);

            $image = $_FILES['product_image']['name'];
            $imageTemp = $_FILES['product_image']['tmp_name'];
            $folder = "productImages/";
            $target = $folder. uniqid() . $image;

            if($price <= 0){
                $error = "Price should be greater than 0";
            }
    
            if($stocks <= 0){
                $error = "Stocks should be greater than 0";
            }

            try{
                $productInfo = $productObj->codeExists($product_code);
    
                if($productInfo){
                    $error = "Product code: ". $product_code . " - " . $productInfo['product_name'] . " already exist";
                } else {
                    $productObj->product_code = $product_code;
                    $productObj->product_name = $product_name;
                    $productObj->category = $category;
                    $productObj->price = $price;
                    $productObj->stocks = $stocks;
    
                    try{
                        $addProd =$productObj->add();
                        $insertedId = $productObj->getLastInsertedId() ?? 0;
    
                        move_uploaded_file($imageTemp,  $target);
                        $productImgObj->file_path = $target;
                        $productImgObj->addImage($insertedId['id']);
    
                        $success = "Successfully add product ". $product_name . " - [ ". $product_code ." ] ";
                        
                    }  catch (PDOException $e) {
                        $error = "Error: " . $e->getMessage();
                    }
                    
                }
            }  catch (PDOException $e) {
                $error = "Error: " . $e->getMessage();
            }
        } else if (isset($_POST['add_size'])){
            
            $productName_size = clean_input($_POST['productName_size']);
            $size = clean_input($_POST['size']);
            $sizePrice = clean_input($_POST['sizePrice']);
            $productObj->size = $size;
            $productObj->sizePrice = $sizePrice;
            if( $sizePrice <=0 ){
             $error = "Size price should be greater than 0";
            }
            try{

                $checkDup = $productObj->checkSizeDup($productName_size);

                if(empty($checkDup)){
                    $addSize = $productObj->addProductSize($productName_size);

                    if($addSize){
                        $success= "Successfully add product size ";
                    }

                } else {
                    $error = "Size: ". $size . " for the product already exists.";
                }

            }  catch (PDOException $e) {
                $error = "Error: " . $e->getMessage();
            }
        }

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
            <h1 class=" text-2xl text-center">Add New Product</h1>
        </div>
         <div class="flex items-start justify-center">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="product_image" >Image:</label>
                <input type="file" id="product_image" name="product_image" accept=".jpg, .jpeg, .png" required>

                <label for="product_code">Product Code:</label>
                <input type="text" name="product_code"  value="<?= (isset($product_code))? $product_code:"" ?>" required>

                <label for="product_name">Name:</label>
                <input type="text" name="product_name" value="<?= (isset($product_name))? $product_name:"" ?>" required>

                <label for="category">Category:</label>
                <select name="category" required>
                    <?php foreach($categories as $categoryName){ ?>

                         <option value="<?= $categoryName['id'] ?>" <?= (isset($category) && $category == $categoryName['id']) ? "selected" : "" ?>>
                            <?= $categoryName['name'] ?>
                        </option>

                    <?php }  ?>

                    </php>
                </select>

                <label for="price">Price:</label>
                <input type="number" name="price" value="<?= (isset($price))? $price:"" ?>" required>

                <label for="stocks">Stocks:</label>
                <input type="number" name="stocks" value="<?= (isset($stocks))? $stocks:"" ?>" required>

                <input type="submit" value="Add Product" name="add_prod" class="w-full bg-[#ff8c00] py-2 px-6 rounded-md" >
            </form>

            <form method="POST">
                <p class="text-lg font-medium mb-2">Add product size</p>
                <label for="productName_size">Select product:</label>
                <?php  $products = $productObj->fetchProdNames()  ?>
                <select name="productName_size" required>
                    <?php foreach($products as $arr){ ?>

                         <option value="<?= $arr['id'] ?>" <?= (isset($productName_size) && $productName_size == $arr['id']) ? "selected" : "" ?>>
                            <?= $arr['product_name'] ?>
                        </option>

                    <?php }  ?>

                    </php>
                </select>
                <label for="size">Size:</label>
                <input type="text" name="size" value="<?= (isset($size))? $size:" " ?>" required>
                
                <label for="sizePrice">Size Price:</label>
                <input type="text" name="sizePrice" value="<?= (isset($sizePrice))? $sizePrice:" " ?>" required>
                <input type="submit" value="Add Product Size" name="add_size" class="w-full bg-[#ff8c00] py-2 px-6 rounded-md" >
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

    </script>
</body>
</html>