
<?php

    require_once "../classes/product.class.php";

    include_once "../includes/header.php";

    $productObj = new Product();

    $recent_orders = $productObj->fetchRecentOrders();
?>

<style>
    .recent-orders{
        margin-top: 12px;
    }
    #dashboard{
        background-color: #ff8c00;
    }

    .dashboard{
        background-color: #ff8c00;
        color: white;
    }

</style>

<body>

    <?php include_once "../includes/sidebar.php" ?>

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
            <div class="card" onclick="location.href='delivery.php'">
                <h3>Deliveries</h3>
                <p>Track and manage deliveries</p>
            </div>
            <div class="card" onclick="location.href='pickups.php'">
                <h3>Pickups</h3>
                <p>Track and manage pickup orders</p>
            </div>
        </div>

        <div class="recent-orders">
            <div class="flex justify-between items-end mt-4">
                <p class="text-4xl">Recent Orders</p>
                <button class="btn bg-[#ff8c00] py-2 px-6 rounded-md" onclick="window.location.href='orders.php'">View All</button>
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
                    <?php if (count($recent_orders) > 0){
                           foreach ($recent_orders as $order){ ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['id']); ?></td>
                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['product_id']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($order['quantity']); ?></td><td><?php echo htmlspecialchars($order['delivery_option']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($order['status'])); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                        <td><a href="../order/view_order.php?id=<?= $order['id'];?>">View</a></td>
                    </tr>
                    <?php } } else { ?>
                    <tr>
                        <td colspan="7" class="text-center">No recent orders.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>