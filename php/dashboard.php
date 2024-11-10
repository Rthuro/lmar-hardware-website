<?php
session_start();
require_once "database.php";

// Redirect to login if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

// Establish database connection


// Fetch recent orders (e.g., last 5)
try {
    $stmt = $pdo->prepare("SELECT * FROM orders ORDER BY order_date DESC LIMIT 5");
    $stmt->execute();
    $recent_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching orders: " . $e->getMessage();
    exit();
}

// Fetch recent orders with product names
try {
    $stmt = $pdo->prepare("SELECT orders.*, products.product_name FROM orders LEFT JOIN products ON orders.product_id = products.id ORDER BY orders.order_date DESC LIMIT 5");
    $stmt->execute();
    $recent_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching orders: " . $e->getMessage();
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - LMAR Hardware</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
    .recent-orders{
        margin-top: 12px;
    }
    #dashboard{
        background-color: #ff8c00;
    }

</style>

<body>
    <div class="sidebar">
        <h2>LMAR Hardware</h2>
        <ul>
            <li><a id="dashboard" href="dashboard.php">Dashboard</a></li>
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="deliveries.php">Deliveries</a></li>
            <li><a href="pickup.php">Pickups</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Admin Dashboard</h1>
        </div>

        <div class="dashboard-grid">
            <div class="card" onclick="location.href='inventory.php'">
                <h3>Inventory</h3>
                <p>Manage stocks and product details</p>
            </div>
            <div class="card" onclick="location.href='orders.php'">
                <h3>Orders</h3>
                <p>View and approve pending orders</p>
            </div>
            <div class="card" onclick="location.href='deliveries.php'">
                <h3>Deliveries</h3>
                <p>Track and manage deliveries</p>
            </div>
            <div class="card" onclick="location.href='pickup.php'">
                <h3>Pickups</h3>
                <p>Track and manage pickup orders</p>
            </div>
            <div class="card" onclick="location.href='feedback.php'">
                <h3>Feedback</h3>
                <p>View customer feedback</p>
            </div>
        </div>

        <!-- Recent Orders Section -->
        <div class="recent-orders">
            <div class="header-section">
                <h2>Recent Orders</h2>
                <button class="btn btn-primary" onclick="window.location.href='orders.php'">View All</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($recent_orders) > 0): ?>
                    <?php foreach ($recent_orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['id']); ?></td>
                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['product_id']); /* Ideally, you'd join with products table to get product name */ ?>
                        </td>
                        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($order['status'])); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                        <td><a href="view_order.php?id=<?php echo $order['id']; ?>">View</a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="7">No recent orders found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>