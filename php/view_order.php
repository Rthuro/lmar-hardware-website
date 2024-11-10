<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

// Check if order ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: orders.php");
    exit();
}

$order_id = $_GET['id'];

// Establish database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=lmar_hardware", "root", ""); // Adjust the credentials as necessary
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit();
}

// Fetch order details
try {
    $stmt = $pdo->prepare("SELECT orders.*, products.product_name FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE orders.id = ?");
    $stmt->execute([$order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo "Order not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error fetching order details: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order - LMAR Hardware Admin</title>
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
        <div class="header">
            <h1>View Order #<?php echo htmlspecialchars($order['id']); ?></h1>
            <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
        </div>

        <div class="order-details">
            <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
            <p><strong>Product:</strong> <?php echo htmlspecialchars($order['product_name']); ?></p>
            <p><strong>Quantity:</strong> <?php echo htmlspecialchars($order['quantity']); ?></p>
            <p><strong>Delivery Option:</strong> <?php echo htmlspecialchars(ucfirst($order['delivery_option'])); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($order['status'])); ?></p>
            <p><strong>Order Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>
            <?php if ($order['delivery_option'] == 'pickup'): ?>
            <p><strong>Pickup Date:</strong> <?php echo htmlspecialchars($order['pickup_date']); ?></p>
            <?php else: ?>
            <p><strong>Delivery Date:</strong> <?php echo htmlspecialchars($order['delivery_date']); ?></p>
            <?php endif; ?>
            <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($order['address'])); ?></p>
        </div>

        <button class="btn" onclick="window.location.href='orders.php'">Back to Orders</button>
    </div>
</body>

</html>