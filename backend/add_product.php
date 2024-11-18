<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=lmar_hardware", "root", ""); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit();
}

$error = $product_code = $name = $category = $price = $stocks = $data = $categoryId = "";
try {
    $stmt = $pdo->prepare("SELECT * FROM categories");
    $data = null;
    if($stmt -> execute()){
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_code = $_POST['product_code'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stocks = $_POST['stocks'];

    // Check if stocks is set and not empty
    if (isset($_POST['stocks']) && !empty($_POST['stocks'])) {
        $stocks = $_POST['stocks'];
    } else {
        // Handle the error appropriately
        $error = "Error: Stocks cannot be null.";
    }

    if (empty($error)) {
        try {
            $stmt = $pdo->prepare("SELECT id from categories WHERE name=:category");
            $stmt->bindParam(":category", $category);
            if($stmt->execute()){
                $row = $stmt->fetch(PDO::FETCH_ASSOC); 
                 $categoryId = $row ? $row['id'] : null;
            }

            if(!empty($categoryId)){
                  $stmt = $pdo->prepare("INSERT INTO products (product_code, product_name, category, price, stocks) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$product_code, $name, $categoryId, $price, $stocks]);

                header("Location: inventory.php");
                exit();
            }

            
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    body {
        margin: 0;
        font-family: 'Arial', sans-serif;
        background-color: #f9f9f9;
    }
    .contentContainer{
        display: flex;
        flex-direction: column;
        align-items: center;
        gap:12px;
        background-color: none;
    }
    .form-box {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        width: fit-content;
    }

    .form-box h1 {
        text-align: center;
        color: #222;
        margin-bottom: 20px;
    }

    .form-box label {
        font-size: 14px;
        font-weight: bold;
        color: #333;
        display: block;
        margin-bottom: 8px;
        color:#fff;
    }

    .form-box input[type="text"],
    .form-box input[type="number"],
    .form-box select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        background-color: black;
    }

    .form-box input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #ff6600;
        border: none;
        border-radius: 5px;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .form-box input[type="submit"]:hover {
        background-color: #e65c00;
    }

    .form-box select {
        padding: 12px;
    }
    .error{
        text-align: center;
        width: fit-content;
        color:rgba(255,44,44);
        background: rgba(255,44,44,0.1);
        border: 1px solid rgba(255,44,44);
        border-radius: 4px;
        padding: 12px;
    }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>LMAR Hardware</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="deliveries.php">Deliveries</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="contentContainer">
    <p class="error"><?= (!empty($e))? $e:"" ?></p>
    <div class="form-box">
        <p class="error"><?= (!empty($error))? $error:"" ?></p>
         <div class="form-box">
            <h1>Add New Product</h1>
            <form action="add_product.php" method="POST">
                <label for="product_code">Product Code:</label>
                <input type="text" name="product_code"  value="<?= isset($product_code)? $product_code:"" ?>" required>

                <label for="product_name">Name:</label>
                <input type="text" name="name" value="<?= isset($name)? $name:"" ?>" required>

                <label for="category">Category:</label>
                <select name="category" required>
                    <?php foreach($data as $categoryName){ ?>

                         <option value="<?= $categoryName['name'] ?>" <?= isset($category) && $category == $categoryName['name'] ? "selected" : "" ?>>
                            <?= $categoryName['name'] ?>
                        </option>

                    <?php }  ?>

                    </php>
                </select>

                <label for="price">Price:</label>
                <input type="number" name="price" value="<?= isset($price)? $price:"" ?>" required>

                <label for="stocks">Stocks:</label>
                <input type="number" name="stocks" value="<?= isset($stocks)? $stocks:"" ?>" required>

                <input type="submit" value="Add Product" >
            </form>
        </div>
     </div>
       
</body>

</html>