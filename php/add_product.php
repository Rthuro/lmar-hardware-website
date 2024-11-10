<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

// Establish database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=lmar_hardware", "root", ""); // Adjust the credentials as necessary
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_code = $_POST['product_code'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    // Check if stocks is set and not empty
    if (isset($_POST['stocks']) && !empty($_POST['stocks'])) {
        $stocks = $_POST['stocks'];
    } else {
        // Handle the error appropriately
        $error = "Error: Stocks cannot be null.";
    }

    if (!isset($error)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO products (product_code, product_name, category, price, stocks) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$product_code, $name, $category, $price, $stocks]);
            // Redirect only after successful insert
            header("Location: inventory.php");
            exit();
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

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f4f4f4;
        margin-left: 350px;
    }

    .form-box {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        width: 100%;
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
        background-color: #f8f8f8;
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

    <div class="container">
        <div class="form-box">
            <h1>Add New Product</h1>
            <form action="add_product.php" method="POST">
                <label for="product_code">Product Code:</label>
                <input type="text" name="product_code" required>

                <label for="product_name">Name:</label>
                <input type="text" name="name" required>

                <label for="category">Category:</label>
                <select name="category" required>
                    <option value="">Select Category</option>
                    <option value="Hand Tools">Hand Tools</option>
                    <option value="Power Tools">Power Tools</option>
                    <option value="Fasteners">Fasteners</option>
                    <option value="Building Materials">Building Materials</option>
                    <option value="Electrical Supplies">Electrical Supplies</option>
                    <option value="Plumbing Supplies">Plumbing Supplies</option>
                    <option value="Paint and Supplies">Paint and Supplies</option>
                    <option value="Garden and Outdoor Supplies">Garden and Outdoor Supplies</option>
                    <option value="Safety Equipment">Safety Equipment</option>
                    <option value="Storage and Organization">Storage and Organization</option>
                    <option value="Seasonal Items">Seasonal Items</option>
                    <option value="Miscellaneous Supplies">Miscellaneous Supplies</option>
                </select>

                <label for="price">Price:</label>
                <input type="number" name="price" required>

                <label for="stocks">Stocks:</label>
                <input type="number" name="stocks" required>

                <input type="submit" value="Add Product">
            </form>
        </div>
    </div>
</body>

</html>