<?php

    require_once "../classes/product.class.php";
    require_once "../classes/product_size.class.php";
    require_once "../tools/functions.php";
    include_once "../includes/header.php";

    $productObj = new Product();
    $productSizeObj = new ProductSize();

    $error = $success = $category_name = $e = $id = $product_code = $product_name  = $size = $category = $price = $stocks = $data = $categoryId = $description = $record = $getProdSizes = "";

    $categories = $productObj->fetchCategory();

    if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $record = $productObj->fetchRecord($id); 
            if (!empty($record)) {
                $product_name = $record['product_name'];
                $category = $record['category'];
                $description = $record['description'];

                foreach ($categories as $categoryName){
                    if($category == $categoryName['id']){
                        $category_name = $categoryName['name'];
                        break;
                    }
                }

                $productSizeObj->product_id = $record['id'];
                $getProdSizes = $productSizeObj->fetchProdSizeById();

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
    
    
        if($_SERVER['REQUEST_METHOD'] == 'POST' ){
            if(isset($_POST['edit_prod'])){ 
                $product_name = clean_input($_POST['product_name']) ?? "";
                $category = clean_input($_POST['category']) ?? "";
                $description = clean_input($_POST['description']);
                try{
                        $id = $_GET['id'];
                        $productObj->id = $id;
                        $productObj->product_name = $product_name;
                        $productObj->category = $category;
                        $productObj->description = $description;

                        if( $productObj->update()){
                            header("location: view_product.php?id=". $id );
                
                    }  else {
                        $error = "Product name already exist";
                    }
                
                }  catch (PDOException $e) {
                            $error = "Error: " . $e->getMessage();
                }
        
            } else if(isset($_POST['add_size'])){
                $prodId = clean_input($_POST['productName_size']);
                $size= clean_input($_POST['size']);
                $price = clean_input($_POST['sizePrice']);
                $stock = clean_input($_POST['stock']); 
        
                $productSizeObj->size = $size;
                try{
        
                    $checkDup = $productSizeObj->checkSizeDup($prodId);
                    if(empty($checkDup)){

                        $productSizeObj->product_id = $prodId;
                        $productSizeObj->stock= $stock;
                        $productSizeObj->price = $price;

                        if($productSizeObj->addSize()){
                            $success= "Successfully add product size ";
                            header("location: view_product.php?id=". $id );
                        }
        
                    } else {
                        $error = "Size: ". $size . " for the product already exists.";
                    }
        
                }  catch (PDOException $e) {
                    $e = "Error: " . $e->getMessage();
                }
            } else if( isset($_POST['edit_prodSize'])){
                $sizeId = clean_input($_POST['size_id']);
                $size_name = clean_input($_POST['size_name']);
                $sizePrice = clean_input($_POST['sizePrice']);
                $stock = clean_input($_POST['stock']);
        
                    try{
        
                        $productSizeObj->size_id = $sizeId;
                        $productSizeObj->size = $size_name;
                        $productSizeObj->stock = $stock;
                        $productSizeObj->price = $sizePrice;
                        
                        
                        if($productSizeObj->updateSize()){
                            $_SESSION["outputMsg"]["success"] = "Product Size successfully updated";
                            header("location: view_product.php?id=". $id );
                        } else {
                            $error = "Failed updating product size";
                        }
                    }  catch (PDOException $e) {
                        $error = "Error: " . $e->getMessage();
                  }
            }
        }



?>

<body>
<?php if (!empty($error)): ?>
    <p id="err" class="err flex justify-center fixed top-0 left-0 right-0 py-5 bg-red-600 text-white z-40"><?= $error ?></p>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <p id="succ" class="succ flex justify-center fixed top-0 left-0 right-0 py-5 bg-green-600 text-white z-50"><?= $success ?></p>
<?php endif; ?>
<?php include_once "../includes/sidebar.php"; ?>
<?php 
        if( !empty($_GET['modal']) ){ 
            if($_GET['modal'] == 'edit_product'){  ?>
                <div class="fixed top-0 right-0 left-0 bottom-0 flex items-center justify-center bg-black/40">
                    <div class=" bg-[#1e1e1e] shadow-md rounded-lg w-[500px] h-fit p-4">
                        <p class=" text-lg ">Edit Product</p>
                        <form action="" method="post" class="flex flex-col w-[450px] shadow-none m-0 p-0 bg-transparent ">
                            <label for="product_name">Name:</label>
                            <input type="text" name="product_name" value="<?= $product_name ?>" required>

                            <label for="category">Category:</label>
                            <select name="category" required>
                                <?php foreach ($categories as $categoryName): ?>
                                    <option value="<?= $categoryName['id'] ?>"
                                        <?= $category == $categoryName['id'] ? "selected" : "" ?>>
                                        <?= $categoryName['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <label for="description">Description:</label>
                            <input type="text" name="description" value="<?= $description ?>">

                            <div class="flex gap-3">
                                <input type="submit" name="edit_prod" value="Save changes" class="flex-1 bg-[#ff8c00] py-2 px-6 my-4 rounded-md">
                                <a href="view_product.php?id=<?= $id ?>" class="flex-1 text-center bg-red-600 py-2 px-6 my-4 rounded-md">Cancel</a>
                            </div>
                            
                        </form>
                    </div>
                </div>
      <?php  } else if($_GET['modal'] == 'new_size') { ?>
        <div class="fixed top-0 right-0 left-0 bottom-0 flex items-center justify-center bg-black/40">
                    <div class=" bg-[#1e1e1e] shadow-md rounded-lg w-[500px] h-fit p-4">
                        <p class=" text-lg ">Add Product Size</p>
                        <form action="" method="post" class="flex flex-col w-[450px] shadow-none m-0 p-0 bg-transparent ">
                            <input type="hidden" name="productName_size" value="<?= $id ?>">
                            <label for="size">Size:</label>
                            <p class="text-sm mb-2">"no size" for product with no size</p>
                            <input type="text" name="size" value="" required>
                            
                            <label for="sizePrice">Size Price:</label>
                            <input type="text" name="sizePrice" value=""min="1" required>

                            <label for="stock">Stocks:</label>
                            <input type="number" name="stock" value="" min="1" required>
                            <div class="flex gap-3">
                                <input type="submit" name="add_size" value="Add Size" class="flex-1 bg-[#ff8c00] py-2 px-6 my-4 rounded-md">
                                <a href="view_product.php?id=<?= $id ?>" class="flex-1 text-center bg-red-600 py-2 px-6 my-4 rounded-md">Cancel</a>
                            </div>
                        </form>
                    </div>
        </div>
      <?php } else if($_GET['modal'] == 'edit_size'){ 
        $size_id = $_GET['size_id'];
        $productSizeObj->size_id = $size_id;
        $size_record = $productSizeObj->fetchProdSizeBySizeId(); ?>
        <div class="fixed top-0 right-0 left-0 bottom-0 flex items-center justify-center bg-black/40">
                    <div class=" bg-[#1e1e1e] shadow-md rounded-lg w-[500px] h-fit p-4">
                        <p class=" text-lg ">Edit Product Size</p>
                        <form action="" method="post" class="flex flex-col w-[450px] shadow-none m-0 p-0 bg-transparent ">
                        <label for="size_name">Size Name:</label>
                        <input type="text" name="size_name" value="<?= $size_record[0]['size'] ?>" required>
                        <label for="sizePrice" class="mt-3">Size Price:</label>
                        <input type="number" name="sizePrice" value="<?=  $size_record[0]['price'] ?>" min="1" required>
                        <label for="stock" class="mt-3">Stock:</label>
                        <input type="number" name="stock" value="<?=  $size_record[0]['stock'] ?>" min="1" required>
                        <input type="hidden" name="size_id" value="<?= $size_id ?>">
                            <div class="flex gap-3">
                                    <input type="submit" name="edit_prodSize" value="Save changes" class="flex-1 bg-[#ff8c00] py-2 px-6 my-4 rounded-md">
                                    <a href="view_product.php?id=<?= $id ?>" class="flex-1 text-center bg-red-600 py-2 px-6 my-4 rounded-md">Cancel</a>
                            </div>
                        </form>
                    </div>
        </div>
      <?php } } ?>
<div class="main-content">
    <div class="header">
        <h1 class="text-2xl text-center"><?= $product_name ?></h1>
    </div>
    <div class="flex flex-col justify-start">
        <form action="" method="" class="flex flex-col">
            <a href="view_product.php?modal=edit_product&id=<?= $id ?>" class="flex items-center self-end gap-2 text-green-600">Edit <i data-lucide="pencil-line" class=" size-5"></i></a>
            <label for="product_name">Name:</label>
            <input type="text" name="product_name" value="<?= $product_name ?>" disabled>
            <label for="category" class=" mt-2 ">Category:</label>
            <input type="text" name="category_name" value="<?= $category_name ?>" disabled>
            <label for="description" class=" mt-2 ">Description:</label>
            <input type="text" name="description" value="<?= $description ?>" disabled>
        </form>

        <div class="flex justify-between items-center">
            <p class="text-2xl font-medium text-white">Product Size</p>
            <a href="view_product.php?modal=new_size&id=<?= $id ?>" class="btn bg-[#ff8c00] py-2 px-6 rounded-md" >
                Add Product Size
            </a>
        </div>
        <table>
            <thead>
            <tr>
                <th>Size</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($getProdSizes)): ?>
                <?php foreach ($getProdSizes as $prodSize): ?> 
                    <tr>
                        <td><?= $prodSize['size']?></td>
                        <td><?=$prodSize['stock'] ?></td>
                        <td><?= $prodSize['price'] ?></td>
                        <td><?php echo ($prodSize['stock'] == 0)? 'out of stock': ($prodSize['stock'] > 10 ? 'in stock': 'low on stock' ); ?></td>
                        <td>
                            <a href="view_product.php?id=<?= $id ?>&modal=edit_size&size_id=<?= $prodSize['size_id'] ?>">Edit</a>
                            <a href="../product_size/delete_size.php?id=<?= $prodSize['size_id'] ?>"
                               onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No product size available.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once "../includes/footer.php"; ?>
<script>
    const err = document.getElementById('err');
    const succ = document.getElementById('succ');

    if (err) {
        err.addEventListener('click', () => {
            err.classList.replace("flex", "hidden");
        });
    }

    if (succ) {
        succ.addEventListener('click', () => {
            succ.classList.replace("flex", "hidden");
        });
    }
</script>
</body>
</html>


</html>