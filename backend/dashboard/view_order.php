<?php 

    require_once "../classes/product.class.php";
    require_once "../classes/product_size.class.php";
    require_once "../classes/orders.class.php";
    
    $orderObj = new Order();
    $delivery = false;
    $pickup = false;
    $currentDate = date('Y-m-d');
    

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
       
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $record = $orderObj->fetchOrderById( $_GET['id']); 
            if (!empty($record)) {
                $order_id = $record[0]['id'];
                $order_status = $record[0]['status'];
                $payment = $record[0]['payment'];
                $contact = $record[0]['contact_num'];
                $username = $record[0]['username'];
                $email = $record[0]['email'];
                $order_date = $record[0]['order_date'];
                $delivery_option = $record[0]['delivery_option'];

                $dateTime = new DateTime($order_date);
                $formattedOrderDate = $dateTime->format('F j, Y, g:i a');
               
                if($delivery_option === 'delivery'){
                    $delivery = true;
                    $location = $record[0]['location'];
                    $address = $record[0]['address'];
                    $delivery_date = $record[0]['delivery_date'];
                } else if($delivery_option === 'pickup'){
                    $pickup = true;
                    $pickup_date = $record[0]['pickup_date'];
                }
               

            } else {
                $_SESSION["outputMsg"]["error"] = 'No orders found';
                header("location: /backend/dashboard/orders.php");
                exit;
            }
        } else {
            $_SESSION["outputMsg"]["error"] = 'No orders found';
            header("location: /backend/dashboard/orders.php");
            exit;
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_order'])){
        $status = $_POST['status'];
        // $pickup = $_POST['pickup_date'];
        // $delivery = $_POST['delivery_date'];

       
        if( $orderObj->updateOrderStatus($_GET['id'], $status)){
            if($status === 'cancelled'){
                foreach($record as $cancelled){
                    $orderObj->size_id = $cancelled['size_id'];
                    $updateStock = $cancelled['stock'] + $cancelled['quantity'];
                    $updateRes = $orderObj->updateProdStockIfCancelled($updateStock);
                }
            }
            $_SESSION["outputMsg"]["success"] = 'Successfully update order status';
            header("location: /backend/dashboard/orders.php");
        }
       
        
    }

    include_once "../includes/header.php";
?>

<style>
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
    
        <?php if (!empty($error)) { 
            ?> <p id="err" class="err flex justify-center fixed top-0 left-0 right-0 py-5 bg-red-600 text-white z-40"><?= $error ?></p> <?php }
        ?>
        <?php if (!empty($e)) { 
            ?> <p id="err" class="err flex justify-center fixed top-0 left-0 right-0 py-5 bg-red-600 text-white z-40">
                <?= $e ?>
            </p> <?php }
        ?>
         <?php if (!empty($success)) { 
            ?> <p id="succ" class="succ flex justify-center fixed top-0 left-0 right-0 py-5 bg-green-600 text-white z-50">
                <?= $success ?>[0]
            </p> <?php }
        ?>
    <?php include_once "../includes/sidebar.php" ?>
    <div class=" main-content">
     <div class="flex items-start">
         <form action="" method="post">
                <p class="text-2xl mb-3" >Order details</p>
                <label for="status">Order Status:</label>
                <select name="status" id="" >
                         <option value="pending" <?= ($order_status == "pending")? "selected":'' ?>>Pending</option>
                          <?php if($delivery){ ?>
                                <option value="to deliver" <?= ($order_status == "to deliver")? "selected":'' ?>>To Deliver</option> 
                              <?php }?>
                        <option value="completed" 
                        <?= ($order_status == "completed")? "selected":'' ?> >Completed</option>
                        <option value="cancelled" 
                        <?= ($order_status == "cancelled")? "selected":'' ?> >Cancelled</option>
                </select>
                <label for="order_id">Order ID:</label>
                <input type="number" name="order_id" id="" value="<?= $order_id ?>" readonly>
                <label for="order_date">Order Placed:</label>
                <input type="text" name="order_date" id=""  value="<?= $formattedOrderDate ?>">
                <div class="flex gap-3">
                    <div class="flex flex-col">
                        <label for="delivery_option">Delivery Option:</label>
                        <input type="text" name="delivery_option" id="" value="<?= $delivery_option ?>" readonly>
                    </div>
                    <div class="flex flex-col">
                        <?php if($pickup){ ?>
                            <label for="pickup_date">Pickup Date:</label>
                            <input type="date" name="pickup_date" id=""  value="<?= $pickup_date ?>" readonly>
                        <?php }?>
                        <?php if($delivery){ ?>
                            <label for="delivery_date">Delivery Date:</label>
                        <input type="date" name="delivery_date" id="" value="<?= $delivery_date ?>" readonly>
                        <?php }?>
                    </div>
                </div>
                <?php if($delivery){ ?>
                    <label for="location">Location:</label>
                    <input type="text" name="location" id="" value="<?= $location ?>" readonly>
                    <label for="address">Address:</label>
                    <input type="text" name="address" id="" value="<?= $address ?>" readonly>
                <?php }?>
                
                <label for="total" class="text-nowrap">Total Amount:</label>
                <input type="number" name="total" id="" value="<?= $payment ?>"  readonly>
              
                <?php if($order_status === "completed"){ ?>
                    <input type="button" value="Order Completed " name="" class="w-full bg-green-600 py-2 px-6 rounded-md my-3" disabled >
                <?php } else if($order_status === "cancelled") { ?>
                    <input type="button" value="Order Cancelled " name="" class="w-full bg-red-600 py-2 px-6 rounded-md my-3" disabled >
               <?php } else { ?>
                    <input type="submit" value="Update Order Status " name="update_order" class="w-full bg-[#ff8c00] py-2 px-6 rounded-md my-3" >
                <?php } ?>
            </form>
            <div class="flex flex-col flex-1">
                <form action="">
                    <p class="text-2xl mb-3" >Customer details</p>
                    <div class="flex gap-3">
                        <input type="text" name="username" id="" value="<?= $username ?>" readonly>
                        <input type="text" name="email" id="" value="<?= $email ?>" readonly>
                    </div>
                    <label for="contact" class="text-nowrap">Contact Number:</label>
                    <input type="tel" name="contact" id="" value="<?= $contact ?>"  readonly>
                </form>
                <table>
                    <thead>
                        <tr>
                            <td>Product</td>
                            <td>Size</td>
                            <td>Quantity</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($record as $order){ ?>
                            <tr>
                                <td><?= $order['product_name'] ?></td>
                                <td><?= $order['size'] ?></td>
                                <td><?= $order['quantity'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>   
            </div>
           
        </div>
    </div>
    <script>
       

        const err = document.getElementById('err');
        const succ = document.getElementById('succ');

        if(err !== null){
            err.addEventListener( ('click'), ()=>{
            err.classList.replace("flex", "hidden");
        } )
        }
       

        if(succ !== null){
            succ.addEventListener( ('click'), ()=>{
            succ.classList.replace("flex", "hidden");
             } )
        }  


    </script>
</body>
</html>