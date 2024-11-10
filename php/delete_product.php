<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

$pdo = new PDO("mysql:host=localhost;dbname=lmar_hardware", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$product_id = $_GET['id'];

// Delete product from the database
$stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
$stmt->execute(['id' => $product_id]);

header("Location: inventory.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <link rel="stylesheet" href="css/style.css">
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

    <div class="main-content">
        <h1>Product Deleted Successfully</h1>
        <a href="inventory.php" class="btn btn-primary">Back to Inventory</a>
    </div>
</body>

</html>