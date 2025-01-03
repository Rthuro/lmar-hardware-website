<?php

    require_once "../classes/product.class.php";
    require_once "../tools/functions.php";
    require_once "../classes/product_size.class.php";
    include_once "../includes/header.php";

    $productObj = new Product();
    $productSizeObj = new ProductSize();

    $error = $success = $e =  $product_name = $size = $category = $price = $stocks = $data = $categoryId = $image = $imageTemp = $imageErr = "";
    $prodId =  $size = $stock = $sizePrice = "";

    $search_term = isset($_GET['search']) ? clean_input($_GET['search']): '';
    $filter_category = isset($_GET['category']) ? clean_input($_GET['category']): '';

    $categories = $productObj->fetchCategory();
    $products = $productObj->showAll($search_term, $filter_category);

    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add_prod'])){

        $product_name = clean_input($_POST['product_name']);
        $category = clean_input($_POST['category']);
        $image = $_FILES['product_image']['name'];
        $imageTemp = $_FILES['product_image']['tmp_name'];
        $folder = "productImages/";
        $target = $folder. uniqid() . $image;

        try{
            $productObj->product_name = $product_name;
            $productInfo = $productObj->checkProductDup();

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
    
?>

<style>
        #inventory{
            background-color: #ff8c00;
        }
      .addprod{
        display: block;
        width: fit-content;
        margin:8px 0;
      }
    .search-bar {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-input {
        padding: 10px;
        width: 250px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .btn-search {
        padding: 10px 20px;
        background-color: #ff9800;
        border: none;
        color: white;
        cursor: pointer;
        border-radius: 5px;
    }

    .inventory{
        background-color: #ff8c00;
        color: white;
    }

    .product-img {
    width: 100px; 
    height: auto;
    object-fit: cover;
    border-radius: 5px; 
}


</style>

<body>

    <?php include_once "../includes/sidebar.php" ?>
    <?php 
        if( !empty($_GET['modal']) ){ 
            if($_GET['modal'] == 'add_product'){  ?>
                <div class="fixed top-0 right-0 left-0 bottom-0 flex items-center justify-center bg-black/40">
                    <div class=" bg-[#1e1e1e] shadow-md rounded-lg w-[500px] h-fit p-4 ">
                        <p class=" text-lg ">Add New Product</p>
                        <form action="" method="post" class="flex flex-col w-[450px] shadow-none m-0 p-0 bg-transparent ">
                            <label for="product_image" >Image:</label>
                            <input type="file" id="product_image" name="product_image" accept=".jpg, .jpeg, .png" required>

                            <label for="product_name">Name:</label>
                            <input type="text" name="product_name" value=""  required>

                            <label for="category">Category:</label>
                            <select name="category" required>
                                <?php foreach($categories as $categoryName){ ?>

                                    <option value="<?= $categoryName['id'] ?>" <?= (isset($category) && $category == $categoryName['id']) ? "selected" : "" ?>>
                                        <?= $categoryName['name'] ?>
                                    </option>

                                <?php }  ?>

                                </php>
                            </select>

                            <div class="flex gap-3">
                                <input type="submit" name="add_prod" value="Save changes" class="flex-1 bg-[#ff8c00] py-2 px-6 my-4 rounded-md">
                                <a href="inventory.php" class="flex-1 text-center bg-red-600 py-2 px-6 my-4 rounded-md">Cancel</a>
                            </div>
                            
                        </form>
                    </div>
                </div>
      <?php  } } ?>
    <div class="main-content">

        <div class="header">
                <h1 class="text-4xl">Inventory Management</h1>
        </div>

        <div class="flex items-center justify-between">
            <form method="GET" action="" class="search-bar shadow-none m-0 p-0 bg-transparent">
                <input type="text" name="search" class="search-input" placeholder="Search by product name"
                    value="<?= htmlspecialchars($search_term) ?>">
                <select name="category" class="search-input">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['name'] ?>"
                        <?= $filter_category == $category['name'] ? 'selected' : '' ?>>
                        <?= $category['name'] ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn-search">Search</button>
            </form>
            <a class="btn bg-[#ff8c00] py-2 px-6 rounded-md" href="inventory.php?modal=add_product">
                    Add Product
            </a>
        </div>

        <table border="1">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): 
                    ?>
                <tr>
                    <td><img src="../product/<?= $product['product_img'] ?>" alt="Product Image" class="product-img"></td>
                    <td><?= $product['product_name'] ?></td>
                    <td><?= $product['category_name'] ?></td>
                    <td>
                        <a href="../product/view_product.php?id=<?= $product['id'] ?>">View</a>
                        <a href="../product/delete_product.php?id=<?= $product['id'] ?>"
                            onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>  
                <tr>
                    <td colspan="6">No products found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
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