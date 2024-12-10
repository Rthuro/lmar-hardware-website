<?php

    require_once "../classes/product.class.php";
    require_once "../classes/product_size.class.php";
    require_once "../tools/functions.php";
    include_once "../includes/header.php";

    $productObj = new Product();
    $productSizeObj = new ProductSize();

    $error = $success = $e = $id = $product_code = $product_name  = $size = $category = $price = $stocks = $data = $categoryId = $description = $record = $getProdSizes = "";

    $categories = $productObj->fetchCategory();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
       
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $record = $productObj->fetchRecord($id); 
            if (!empty($record)) {
                $product_name = $record['product_name'];
                $category = $record['category'];

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
    }
    
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_prod'])){ 
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
                        $_SESSION['outputMsg']['success'] = "Product information successfully updated";
                        header("location: /backend/dashboard/inventory.php");
               
                }  else {
                    $error = "Product name already exist";
                 }
               
             }  catch (PDOException $e) {
                        $error = "Error: " . $e->getMessage();
            }
    
        }



?>

<?php
require_once "../classes/product.class.php";
require_once "../classes/product_size.class.php";
require_once "../tools/functions.php";
include_once "../includes/header.php";

$productObj = new Product();
$productSizeObj = new ProductSize();

$error = $success = "";
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$id) {
    $_SESSION["outputMsg"]["error"] = 'Invalid Product ID';
    header("Location: /backend/dashboard/inventory.php");
    exit;
}

$categories = $productObj->fetchCategory();
$record = $productObj->fetchRecord($id);

if (empty($record)) {
    $_SESSION["outputMsg"]["error"] = 'Product not found';
    header("Location: /backend/dashboard/inventory.php");
    exit;
}

// Initialize form values from the fetched record
$product_name = $record['product_name'];
$category = $record['category'];
$description = $record['description'] ?? "";

// Fetch sizes for the product
$productSizeObj->product_id = $id;
$getProdSizes = $productSizeObj->fetchProdSizeById();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_prod'])) {
    $product_name = clean_input($_POST['product_name']);
    $category = clean_input($_POST['category']);
    $description = clean_input($_POST['description']);

    try {
        $productObj->id = $id;
        $productObj->product_name = $product_name;
        $productObj->category = $category;
        $productObj->description = $description;

        if ($productObj->update()) {
            $_SESSION['outputMsg']['success'] = "Product information successfully updated";
            header("Location: /backend/dashboard/inventory.php");
            exit;
        } else {
            $error = "Failed to update the product. The name might already exist.";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
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
<div class="main-content">
    <div class="header">
        <h1 class="text-2xl text-center">Edit Product</h1>
    </div>
    <div class="flex flex-col justify-start">
        <form action="?id=<?= htmlspecialchars($id) ?>" method="POST">
            <label for="product_name">Name:</label>
            <input type="text" name="product_name" value="<?= htmlspecialchars($product_name) ?>" required>

            <label for="category">Category:</label>
            <select name="category" required>
                <?php foreach ($categories as $categoryName): ?>
                    <option value="<?= htmlspecialchars($categoryName['id']) ?>"
                        <?= $category == $categoryName['id'] ? "selected" : "" ?>>
                        <?= htmlspecialchars($categoryName['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="description">Description:</label>
            <input type="text" name="description" value="<?= htmlspecialchars($description) ?>">

            <input type="submit" value="Edit Product" name="edit_prod" class="w-full bg-[#ff8c00] py-2 px-6 rounded-md">
        </form>

        <p class="text-2xl font-medium text-white">Product Size</p>
        <table>
            <thead>
            <tr>
                <th>Size</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($getProdSizes)): ?>
                <?php foreach ($getProdSizes as $prodSize): ?>
                    <tr>
                        <td><?= htmlspecialchars($prodSize['size']) ?></td>
                        <td><?= htmlspecialchars($prodSize['stock']) ?></td>
                        <td><?= htmlspecialchars($prodSize['price']) ?></td>
                        <td>
                            <a href="../product_size/edit_size.php?id=<?= htmlspecialchars($prodSize['size_id']) ?>">Edit</a>
                            <a href="../product_size/delete_size.php?id=<?= htmlspecialchars($prodSize['size_id']) ?>"
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