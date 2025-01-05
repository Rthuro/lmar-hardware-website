
<?php

    require_once "../classes/orders.class.php";
    include_once "../includes/header.php";

    $orderObj = new Order();

  

    function formatDate($order_date){
        $dateTime = new DateTime($order_date);
        $formattedOrderDate = $dateTime->format('F j, Y, g:i a');
        return $formattedOrderDate;
    }

        $keyword = isset($_GET['search']) ? $_GET['search']: '';
        $status = isset($_GET['filter_status']) ? $_GET['filter_status']: '';
        $delivery_option  = isset($_GET['filter_deliveryOption']) ? $_GET['filter_deliveryOption']: '' ;  

        $recent_orders = $orderObj->showAllOrders($keyword,$status,$delivery_option,'dashboard','','');
?>

<style>

    .sidebar a.active {
        background-color: #e67e00; 
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
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50" style="fill: #e67e00;">
                    <path d="M19 3H5c-1.1 0-1.99.89-1.99 1.99L3 19c0 1.1.89 1.99 1.99 1.99h16c1.1 0 1.99-.89 1.99-1.99V5c0-1.1-.89-1.99-1.99-1.99zM5 5h14v14H5z"/>
                </svg>
                <h3>Inventory</h3>
            </div>
           
            <div class="card" onclick="location.href='orders.php'">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50" style="fill: #e67e00;">
                    <path d="M3 3h18v2H3zm0 4h18v2H3zm0 4h18v2H3zm0 4h18v2H3z"/>
                </svg>
                <h3>Orders</h3>
                
            </div>
            <div class="card" onclick="location.href='delivery.php'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50" style="fill: #e67e00;">
                    <path d="M2 5v14h20V5H2zm18 12h-4v-2h4zm-6-4h-4V9h4zm-6-1H4V7h4z"/>
                </svg>

                <h3>Deliveries</h3>
              
            </div>

            <div class="card" onclick="location.href='pickups.php'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50" style="fill: #e67e00;">
                    <path d="M7 2C6.45 2 6 2.45 6 3V19C6 19.55 6.45 20 7 20H17C17.55 20 18 19.55 18 19V3C18 2.45 17.55 2 17 2H7ZM8 3H16V5H8V3ZM9 6H15C15.55 6 16 6.45 16 7V18C16 18.55 15.55 19 15 19H9C8.45 19 8 18.55 8 18V7C8 6.45 8.45 6 9 6Z"/>
                </svg>



                <h3>Pickups</h3>
            </div>
        </div>
         <p class="text-4xl my-6">Recent Orders</p>
             <div class="flex items-center gap-3 justify-between ">
                <form action="" method="get" class="flex items-center m-0 p-0 bg-transparent shadow-none gap-3  flex-1">
                   
                    <div class="flex items-center relative">
                     <input type="text" name="search" class="search-input m-0 w-[800px]" placeholder="Search..." value="<?= isset($_GET['search'])? $_GET['search']: '' ?>">
                        <button type="submit" class="absolute right-3 top-0 bottom-0"> 
                            <i data-lucide="search" class="size-6 text-white"></i>
                      </button>
                    </div>

                        <select name="filter_status" id="" class="mb-0  w-fit">
                            <option value="" selected>Order status </option>
                            <option value="pending" <?= isset($_GET['filter_status']) && $_GET['filter_status'] == 'pending'? 'selected': '' ?>>Pending</option>
                            <option value="cancelled" <?= isset($_GET['filter_status']) && $_GET['filter_status'] == 'cancelled'? 'selected': '' ?>>Cancelled</option>
                            <option value="completed" <?= isset($_GET['filter_status']) && $_GET['filter_status'] == 'completed'? 'selected': '' ?>>Completed</option>
                        </select>
                        <select name="filter_deliveryOption" id="" class="mb-0 w-fit">
                            <option value="" selected>Delivery Option </option>
                            <option value="pickup" <?= isset($_GET['filter_deliveryOption']) && $_GET['filter_deliveryOption'] == 'pickup'? 'selected': '' ?>>Pickup</option>
                            <option value="delivery" <?= isset($_GET['filter_deliveryOption']) && $_GET['filter_deliveryOption'] == 'delivery'? 'selected': '' ?>>Delivery</option>
                        </select>
                        <input type="submit" value="Filter" name="filter" class="btn bg-[#ff8c00] py-2 px-6 rounded-md">
                    </form>
                <button class="btn bg-[#ff8c00] py-2 px-6 rounded-md flex-2" onclick="window.location.href='orders.php'">View All</button>
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
                        <td><?= formatDate($order['order_date'])  ?></td>
                        <td><a href="view_order.php?id=<?= $order['id'];?>">View</a></td>
                    </tr>
                    <?php } } else { ?>
                    <tr>
                        <td colspan="10" class="text-center">No recent orders.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
    </div>
    <?php include_once "../includes/footer.php" ?>
</body>
</html>