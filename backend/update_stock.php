<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

$pdo = new PDO("mysql:host=localhost;dbname=lmar_hardware", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$product_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stock = $_POST['stock'];
    $stmt = $pdo->prepare("UPDATE products SET stock = ? WHERE id = ?");
    $stmt->execute([$stock, $product_id]);

    header("Location: inventory.php");
}

$product = $pdo->query("SELECT * FROM products WHERE id = $product_id")->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Stock</title>
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
        <h1>Update Stock for <?= $product['product_name'] ?></h1>

        <form action="update_stock.php?id=<?= $product_id ?>" method="POST">
            <label for="stock">New Stock Amount:</label><br>
            <input type="number" name="stock" value="<?= $product['stocks'] ?>" required><br><br>

            <input type="submit" value="Update Stock" class="btn btn-primary">
        </form>
    </div>
</body>

</html>