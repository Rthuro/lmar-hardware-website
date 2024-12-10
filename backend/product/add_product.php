<?php

    require_once "../classes/product.class.php";
    require_once "../classes/product_size.class.php";
    require_once "../tools/functions.php";
    include_once "../includes/header.php";

    $productObj = new Product();
    $productSizeObj = new ProductSize();

    $error = $success = $e =  $product_name = $size = $category = $price = $stocks = $data = $categoryId = $image = $imageTemp = $imageErr = "";
    $prodId =  $size = $stock = $sizePrice = "";
    $categories = $productObj->fetchCategory();
   

    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add_prod'])){

            $product_name = clean_input($_POST['product_name']);
            $category = clean_input($_POST['category']);
            $image = $_FILES['product_image']['name'];
            $imageTemp = $_FILES['product_image']['tmp_name'];
            $folder = "productImages/";
            $target = $folder. uniqid() . $image;

            try{
                $productInfo = $productObj->checkProductDup($product_name);
    
                if($productInfo){
                    $error = "Product name: ". $product_name . " already exist";
                } else {
                    move_uploaded_file($imageTemp,  $target);
                    $productObj->product_img = $target;
                    $productObj->product_name = $product_name;
                    $productObj->category = $category;
    
                    try{
                        $addProd =$productObj->add();
                        $success = "Successfully add product ". $product_name ;
                        
                    }  catch (PDOException $e) {
                        $error = "Error: " . $e->getMessage();
                    }
                    
                }
            }  catch (PDOException $e) {
                $error = "Error: " . $e->getMessage();
            }

    }

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add_size'])){
        $prodId = clean_input($_POST['productName_size']);
        $size= clean_input($_POST['size']);
        $price = clean_input($_POST['sizePrice']);
        $stock = clean_input($_POST['stock']); 

        $productSizeObj->product_id = $prodId;
        $productSizeObj->size = $size;
        $productSizeObj->stock= $stock;
        $productSizeObj->price = $price;

        try{

            $checkDup = $productSizeObj->checkSizeDup($prodId);
            if(empty($checkDup)){

                $addSize = $productSizeObj->addSize();

                if($addSize){
                    $success= "Successfully add product size ";
                }

            } else {
                $error = "Size: ". $size . " for the product already exists.";
            }

        }  catch (PDOException $e) {
            $e = "Error: " . $e->getMessage();
        }
    }

?>

<body>
    
        <?php if (!empty($error)) { ?> <p id="err" class="err flex justify-center fixed top-0 left-0 right-0 py-5 bg-red-600 text-white z-40"><?= $error ?></p> 
        <?php } ?>
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

                <input type="submit" value="Add Product" name="add_prod" class="w-full bg-[#ff8c00] py-2 px-6 rounded-md" >
            </form>
            
            <form method="POST">
                <p class="text-lg font-medium mb-2">Add product size</p>
                <label for="productName_size">Select product:</label>
                <?php  $products = $productObj->showAll()  ?>
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
                <input type="text" name="sizePrice" value="<?= (isset($price))? $price:" " ?>"min="1" required>

                <label for="stock">Stocks:</label>
                <input type="number" name="stock" value="<?= (isset($stock))? $stock:"" ?>" min="1" required>

                <input type="submit" value="Add Product Size" name="add_size" class="w-full bg-[#ff8c00] py-2 px-6 rounded-md"  >
    
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