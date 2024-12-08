
<?php

    require_once "../classes/orders.class.php";
    include_once "../includes/header.php";

    $orderObj = new Order();

    $recent_orders = $orderObj->displayDeliveries();
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
                        <th>Customer Name</th>
                        <th>Contact</th>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Delivery Date</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($recent_orders) > 0){
                           foreach ($recent_orders as $order){ ?>
                    <tr>
                        <td><?= $order['username'] ?></td>
                        <td><?= $order['contact_num'] ?></td>
                        <td><?= $order['product_name'] ?></td>
                        <td><?= $order['size'] ?></td>
                        <td><?= $order['quantity'] ?></td>
                        <td><?= $order['delivery_date'] ?></td>
                        <td><?= $order['status'] ?></td>
                        <td><?= $order['order_date'] ?></td>
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