
<?php

    require_once "../classes/orders.class.php";
    include_once "../includes/header.php";

    $orderObj = new Order();

    $recent_orders = $orderObj->displayOnDashboard();
?>

<style>
    .recent-orders{
        margin-top: 12px;
    }
    .sidebar {
        width: 250px;
        height: 100vh;
        background-color: #1e1e1e;
        padding-top: 20px;
        position: fixed;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Optional shadow */
    }

    .sidebar h2 {
        color:#e67e00 ;
        text-align: center;
        font-size: 22px;
        margin-bottom: 30px;
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
    }

    .sidebar ul li {
        margin: 10px 0;
    }

    .sidebar a {
        color: white;
        padding: 15px;
        text-decoration: none;
        display: block;
        font-size: 18px;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    /* Active Link Styling */
    .sidebar a.active {
        background-color: #e67e00; /* Darker orange for active link */
    }

    /* Hover Effect */
    .sidebar a:hover {
        background-color: #e67e00; /* Darker orange for hover */
    }

</style>

<body>

    <?php include_once "../includes/sidebar.php" ?>
    <?php if (isset($_SESSION['outputMsg']['error'])) { 
            ?> <p id="err" class="err flex justify-center fixed top-0 left-0 right-0 py-5 bg-red-600 text-white z-40"><?= $_SESSION['outputMsg']['error'] ?></p> <?php 
            unset($_SESSION['outputMsg']['error']);
            }
        ?>
         <?php if (isset($_SESSION['outputMsg']['success'])) { 
            ?> <p id="succ" class="succ flex justify-center fixed top-0 left-0 right-0 py-5 bg-green-600 text-white z-50">
                <?= $_SESSION['outputMsg']['success'] ?>
            </p> <?php 
            unset($_SESSION['outputMsg']['success']);
         }
        ?>
    <div class="main-content">
        <div class="header">
            <h1>Admin Dashboard</h1>
        </div>

        <div class="dashboard-grid">
            
           <div class="card" onclick="location.href='inventory.php'">
                <!-- Inventory SVG Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50" style="fill: #e67e00;">
                    <path d="M19 3H5c-1.1 0-1.99.89-1.99 1.99L3 19c0 1.1.89 1.99 1.99 1.99h16c1.1 0 1.99-.89 1.99-1.99V5c0-1.1-.89-1.99-1.99-1.99zM5 5h14v14H5z"/>
                </svg>
                <h3>Inventory</h3>
            </div>
           
            <div class="card" onclick="location.href='orders.php'">
                <!-- Orders SVG Icon -->
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50" style="fill: #e67e00;">
                    <path d="M3 3h18v2H3zm0 4h18v2H3zm0 4h18v2H3zm0 4h18v2H3z"/>
                </svg>
                <h3>Orders</h3>
                
            </div>
            <div class="card" onclick="location.href='delivery.php'">
                <!-- Deliveries SVG Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50" style="fill: #e67e00;">
                    <path d="M2 5v14h20V5H2zm18 12h-4v-2h4zm-6-4h-4V9h4zm-6-1H4V7h4z"/>
                </svg>

                <h3>Deliveries</h3>
              
            </div>

            <div class="card" onclick="location.href='pickups.php'">
                <!-- Pickups SVG Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50" style="fill: #e67e00;">
                    <path d="M7 2C6.45 2 6 2.45 6 3V19C6 19.55 6.45 20 7 20H17C17.55 20 18 19.55 18 19V3C18 2.45 17.55 2 17 2H7ZM8 3H16V5H8V3ZM9 6H15C15.55 6 16 6.45 16 7V18C16 18.55 15.55 19 15 19H9C8.45 19 8 18.55 8 18V7C8 6.45 8.45 6 9 6Z"/>
                </svg>



                <h3>Pickups</h3>
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
                        <th>Delivery Option</th>
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
                        <td><?= $order['delivery_option'] ?></td>
                        <td><?= $order['status'] ?></td>
                        <td><?= $order['order_date'] ?></td>
                        <td><a href="view_order.php?id=<?= $order['id'];?>">View</a></td>
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