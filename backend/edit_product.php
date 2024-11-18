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
    die("Could not connect to the database: " . $e->getMessage());
}

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    echo "Invalid product ID.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_code = $_POST['product_code'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stocks = $_POST['stocks'];

    $stmt = $pdo->prepare("UPDATE products SET product_code = ?, product_name = ?, category = ?, price = ?, stocks = ? WHERE id = ?");
    $stmt->execute([$product_code, $product_name, $category, $price, $stocks, $product_id]);

    header("Location: inventory.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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

    <div class="container">
        <div class="form-box">
            <h1>Edit Product: <?= htmlspecialchars($product['product_name'] ?? 'Unnamed Product') ?></h1>
            <form action="edit_product.php?id=<?= $product_id ?>" method="POST">
                <label for="product_code">Product Code:</label>
                <input type="text" name="product_code" value="<?= htmlspecialchars($product['product_code'] ?? '') ?>"
                    required>

                <label for="product_name">Name:</label>
                <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name'] ?? '') ?>"
                    required>

                <label for="category">Category:</label>
                <input type="text" name="category" value="<?= htmlspecialchars($product['category'] ?? '') ?>" required>

                <label for="price">Price:</label>
                <input type="number" name="price" value="<?= htmlspecialchars($product['price'] ?? 0) ?>" required>

                <label for="stocks">Stock:</label>
                <input type="number" name="stocks" value="<?= htmlspecialchars($product['stocks'] ?? 0) ?>" required>

                <input type="submit" value="Update Product">
            </form>
        </div>
    </div>
</body>

</html>