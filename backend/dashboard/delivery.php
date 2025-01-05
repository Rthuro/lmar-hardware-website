
<?php

    require_once "../classes/orders.class.php";
    include_once "../includes/header.php";

    $orderObj = new Order();

    function formatDate($order_date){
        $dateTime = new DateTime($order_date);
        $formattedOrderDate = $dateTime->format('F j, Y, g:i a');
        return $formattedOrderDate;
    }
    function formatDeliveryDate($order_date){
        $dateTime = new DateTime($order_date);
        $formattedOrderDate = $dateTime->format('F j, Y');
        return $formattedOrderDate;
    }
        $keyword = isset($_GET['search']) ? $_GET['search']: '';
        $status = isset($_GET['filter_status']) ? $_GET['filter_status']: '';
        $ordersPerPage = 5; 
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
        $start = ($currentPage - 1) * $ordersPerPage;
        $totalOrders = $orderObj->getTotalOrders($keyword,$status,'delivery');
        $totalPages = ceil($totalOrders / $ordersPerPage);

        $recent_orders = $orderObj->showAllOrders($keyword,$status, 'delivery', '', $start, $ordersPerPage);
?>

<style>
   
    /* Active Link Styling */
    .sidebar a.active {
        background-color: #e67e00; /* Darker orange for active link */
    }

   
</style>



<body>

    <?php include_once "../includes/sidebar.php" ?>

    <div class="main-content">
        <div class="header">
            <h1>Delivery</h1>
        </div>

        <div class="flex gap-5 flex-wrap items-center">
            <div class="bg-[#1e1e1e] py-[30px] px-[20px] rounded-[12px] shadow-2xl flex flex-col items-start transition-transform duration-300 my-3 w-[250px] gap-3" >
                    <p class=" text-xs bg-white/10 text-white  rounded-full py-1 px-2">monthly</p>
                    <p class=" text-2xl text-customOrange">Total Orders</p>
                    <p class=" text-xl "><?= $orderObj->getOrdersByMonth(idate("m"), '','delivery') ?></p>
            </div>
            <div class="bg-[#1e1e1e] py-[30px] px-[20px] rounded-[12px] shadow-2xl flex flex-col items-start transition-transform duration-300 my-3 w-[250px] gap-3" >
                <p class=" text-xs bg-white/10 text-white  rounded-full py-1 px-2">monthly</p>
                <p class=" text-2xl text-customOrange">Pending</p>
                <p class=" text-xl ">
                    <?= $orderObj->getOrdersByMonth(idate("m"), 'pending','delivery') ?></p>
        
            </div>
            <div class="bg-[#1e1e1e] py-[30px] px-[20px] rounded-[12px] shadow-2xl flex flex-col items-start transition-transform duration-300 my-3 w-[250px] gap-3" >
                <p class=" text-xs bg-white/10 text-white  rounded-full py-1 px-2">monthly</p>
                <p class=" text-2xl text-customOrange">To Deliver</p>
                <p class=" text-xl ">
                    <?= $orderObj->getOrdersByMonth(idate("m"), 'to deliver','delivery') ?></p>
        
            </div>
            <div class="bg-[#1e1e1e] py-[30px] px-[20px] rounded-[12px] shadow-2xl flex flex-col items-start transition-transform duration-300 my-3 w-[250px] gap-3" >
                <p class=" text-xs bg-white/10 text-white  rounded-full py-1 px-2">monthly</p>
                <p class=" text-2xl text-customOrange">Cancelled</p>
                <p class=" text-xl "><?= $orderObj->getOrdersByMonth(idate("m"), 'cancelled','delivery') ?></p>
            </div>
            <div class="bg-[#1e1e1e] py-[30px] px-[20px] rounded-[12px] shadow-2xl flex flex-col items-start transition-transform duration-300 my-3 w-[250px] gap-3" >
                <p class=" text-xs bg-white/10 text-white  rounded-full py-1 px-2">monthly</p>
                <p class=" text-2xl text-customOrange">Completed</p>
                <p class=" text-xl "><?= $orderObj->getOrdersByMonth(idate("m"), 'completed','delivery') ?></p>
            </div>
        </div>

        <div class="recent-orders">
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
                            <option value="to_deliver" <?= isset($_GET['filter_status']) && $_GET['filter_status'] == 'to deliver'? 'selected': '' ?>>To Deliver</option>
                            <option value="cancelled" <?= isset($_GET['filter_status']) && $_GET['filter_status'] == 'cancelled'? 'selected': '' ?>>Cancelled</option>
                            <option value="completed" <?= isset($_GET['filter_status']) && $_GET['filter_status'] == 'completed'? 'selected': '' ?>>Completed</option>
                        </select>
                        <input type="submit" value="Filter" name="filter" class="btn bg-[#ff8c00] py-2 px-6 rounded-md">
                    </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Contact</th>
                        <th>Address</th>
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
                            <td><?= $order['address'] ?></td> <td><?= $order['product_name'] ?></td>
                            <td><?= $order['size'] ?></td>
                            <td><?= $order['quantity'] ?></td>
                            <td><?= formatDeliveryDate($order['delivery_date']) ?></td>
                            <td><?= $order['status'] ?></td>
                            <td><?= formatDate($order['order_date']) ?></td>
                            <td><a href="view_order.php?id=<?= $order['id'];?>">View</a></td>
                        </tr>
                        <?php } } else { ?>
                        <tr>
                            <td colspan="10" class="text-center">No recent orders.</td>
                        </tr>
                        <?php } ?>
                    </tbody>
            </table>
            <div class="flex items-center justify-start mx-auto h-fit py-5">
            <?php if ($totalPages >= 1){ ?>
                <form method="get" class=" shadow-none m-0 p-0 bg-transparent">
                    <?php if(isset($_GET['filter_status'])){ ?>
                        <input type="hidden" name="filter_status" value="<?= isset($_GET['filter_status'])? $_GET['filter_status']:'' ?>">
                        <?php } 
                        if(isset($_GET['search'])){ ?>
                            <input type="hidden" name="search" value="<?= isset($_GET['search'])? $_GET['search']:'' ?>">
                        <?php } 
                      for ($i = 1; $i <= $totalPages; $i++): ?>
                        <input type="submit" name="page" value="<?= $i ?>" class="text-customOrange rounded-md border border-customOrange py-2 px-4  <?= ($i == $currentPage) ? ' text-white bg-customOrange' : '' ?>" >
                    <?php endfor; ?>

                </form>
            <?php } ?>
         </div>
        </div>
    </div>
</body>

</html>