<?php
   
    require_once "../backend/classes/cart.class.php";
    require_once "../backend/classes/orders.class.php";
    require_once "../backend/classes/account.class.php";
    require_once "../backend/classes/product.class.php";
    require_once "../backend/classes/product_size.class.php";


    $productObj = new Product();
    $productSizeObj = new ProductSize();
    $accountObj = new Account();
    $cartObj = new Cart();
    $orderObj = new Order();
   

    $userId = $date = $order_id = $order_item_id = '';
    $dateTime = new DateTime($date);
    session_start();

     if(isset($_SESSION['account'])){
        $username = $_SESSION['account']['username'];
        $email = $_SESSION['account']['email'];
        $logUser = $accountObj->fetch($email);
        if(!empty($logUser)){
            $userId = $logUser['id'];
        }
     } else {
        header('location: landing_page.php');
        exit();
     }

     if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel_order'])){
            $order_id = $_POST['order_id'];
            $status = 'cancelled';

            if($orderObj->updateOrderStatus($order_id, $status)){
                $order = $orderObj->fetchOrderById($order_id);
                foreach($order as $arr){
                    $updateStock = $arr['quantity'] + $arr['stock'];
                    $orderObj->size_id = $arr['size_id'];
                    $orderObj->updateProdStockIfCancelled($updateStock);
                }
                header('location: account.php');
            }

     }

     include_once "./includes/header.php";
?>

    <div class="flex lg:items-start lg:justify-center gap-6 my-8 lg:flex-row xs:flex-col-reverse xs:items-center xs:justify-start">
        <div class="flex flex-col items-start border gap-3 lg:w-fit xs:w-11/12">
            <div class="flex items-center gap-4 py-3 px-6 border-b w-full" >
                <i data-lucide="circle-user-round" class=" font-medium size-10"></i>
                <div class="flex flex-col items-start">
                    <p class="font-semibold"><?= $username ?></p>
                    <p class="text-sm text-gray-500"><?= $email ?></p>
                </div>
            </div>
           
            <div class="flex items-center text-red-700 justify-start w-full py-2 px-3 gap-1">
                <i data-lucide="trash" class=" size-4"></i>
                <a href="delete-account.php?id=<?= $userId ?>" onclick="return confirm('Are you sure you want to delete this account?');">Delete Account</a>    
            </div>
            <a href="./account/logout.php" class="flex items-center justify-center bg-customOrange w-full py-3 gap-1">
                <i data-lucide="log-out" class="size-5"></i>
                <p  >Logout</p>    
            </a>
        </div>
        <div class="flex flex-col lg:w-3/5 border shadow-md h-screen xs:w-11/12">
                <form action="" method="get" class="flex items-center w-full justify-around shadow-sm border-b xs:flex-wrap lg:flex-nowrap">

                    <input type="submit" name="type" value="Pick Up" class="basis-2/6 p-3 <?= (isset($_GET['type']) && $_GET['type'] == "Pick Up")? 'text-white bg-customOrange': '' ?>" >

                    <input type="submit" name="type"  value="To Deliver" class="basis-2/6 p-3 <?= (isset($_GET['type']) && $_GET['type'] == "To Deliver")? 'text-white bg-customOrange': '' ?>" >

                    <input type="submit" name="type" value="Completed" class="basis-2/6 p-3 <?= (isset($_GET['type']) && $_GET['type'] == "Completed")? 'text-white bg-customOrange': '' ?>" >
                    
                    <input type="submit" name="type" value="Cancelled" class="basis-2/6 p-3 <?= (isset($_GET['type']) && $_GET['type'] == "Cancelled")? 'text-white bg-customOrange': '' ?>" >

                </form>
            <div class="flex flex-col gap-2 w-full h-full overflow-y-auto">
                <?php 
                     if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['type'])){

                        switch($_GET['type']){
                            case "Pick Up":
                                if(!empty($userId)){
                                    $orderObj->customer_id = $userId;
                                    $userOrder = $orderObj->displayPickUps();
                                }
                
                                if(!empty($userOrder)){
                                    foreach($userOrder as $order){
                                            $orderItems = $orderObj->fetchOrderItems($order['id']);
                                            $date = $order['pickup_date'];
                                            $formattDate = $dateTime->format('F j, Y');
                                            ?>
                                            <div class="w-full py-3 px-3 border-b">
                                                <form action="" method="post" class=" flex-col flex gap-3">
                                                    <?php
                                                    foreach($orderItems as $items){
                                                        ?>
                                                        <div class="flex justify-between items-center w-full">
                                                            <div class="flex gap-2 items-center">
                                                            <img src="/backend/product/<?= $items['product_img'] ?>" alt="" srcset="" class=" size-12">
                                                            <a href="product.php?id=<?= $items['product_id'] ?>" class="text-wrap flex-2"><?= $items['product_name'] ?> <?= ($items['size'] !=='no size')? $items['size']:'' ?></a>
                                                            <p class="text-gray-600"><?= $items['quantity']?>X</p>
                                                            </div>
                            
                                                        <p class="font-medium">Total: PHP
                                                        <?= $items['price']*$items['quantity'] ?>
                                                        </p>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="flex items-center justify-between">
                                                    <p class="font-medium text-gray-700">
                                                        Pick-up date: <?= $formattDate ?>
                                                    </p>
                                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                    <input type="submit" value="Cancel Order" name="cancel_order" class=" py-2 px-4 bg-customOrange text-white rounded-md">
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                            
                                            <?php
                                    }
                                }  else {
                                    ?>      
                                    <div class="flex flex-col items-center justify-center h-full">
                                         <img src="./assets/img/out-of-stock.png" alt="" srcset="">
                                        <p class="text-lg">No orders yet</p>
                                    </div>
                                  <?php
                                }
                                    break;
                            case "To Deliver":
                                if(!empty($userId)){
                                    $orderObj->customer_id = $userId;
                                    $userOrder = $orderObj->displayDeliveries();
                                }
                                if(!empty($userOrder)){
                                    foreach($userOrder as $order){
                                            $orderItems = $orderObj->fetchOrderItems($order['id']);
                                            $date = $order['delivery_date'];
                                            $formattDate = $dateTime->format('F j, Y');
                                            ?>
                                            <div class="w-full py-3 px-3 border-b">
                                                <form action="" method="post" class=" flex-col flex gap-3">
                                                    <p class=" py-1 px-3 text-sm bg-green-700 text-white w-fit rounded-full self-end"><?=$order['status']?></p>
                                                    <?php
                                                    foreach($orderItems as $items){
                                                        ?>
                                                        <div class="flex justify-between items-center w-full">
                                                            <div class="flex gap-2 items-center">
                                                            <img src="/backend/product/<?= $items['product_img'] ?>" alt="" srcset="" class=" size-12">
                                                            <a href="product.php?id=<?= $items['product_id'] ?>" class="text-wrap flex-2"><?= $items['product_name'] ?> <?= ($items['size'] !=='no size')? $items['size']:'' ?></a>
                                                            <p class="text-gray-600"><?= $items['quantity']?>X</p>
                                                            </div>

                                                        <p class="font-medium">Total: PHP
                                                        <?= $items['price']*$items['quantity'] ?>
                                                        </p>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="flex items-center justify-between">
                                                    <p class="font-medium text-gray-700">
                                                        Delivery date: <?= $formattDate ?>
                                                    </p>
                                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                    <input type="submit" value="Cancel Order"  name="cancel_order" class=" py-2 px-4 bg-customOrange text-white rounded-md">
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                            
                                            <?php
                                    }
                                } else {
                                    ?>      
                                    <div class="flex flex-col items-center justify-center h-full">
                                         <img src="./assets/img/out-of-stock.png" alt="" srcset="">
                                        <p class="text-lg">No orders yet</p>
                                    </div>
                                  <?php
                                }
                                    break;
                        case "Completed":
                            if(!empty($userId)){
                                $orderObj->customer_id = $userId;
                                $userOrder = $orderObj->displayCompleted();
                            }
                            if(!empty($userOrder)){
                                foreach($userOrder as $order){
                                    if($order['status'] == 'completed' ){
                                        $orderItems = $orderObj->fetchOrderItems($order['id']);
                                        $date = $order['order_date'];
                                        $formattDate = $dateTime->format('F j, Y H:i:s');
                                        ?>
                                        <div class="w-full py-3 px-3 border-b">
                                            <div class=" flex-col flex gap-3 ">
                                                <p class=" text-sm text-green-700 text-end ">Completed</p>
                                                <?php
                                                foreach($orderItems as $items){
                                                    ?>
                                                    <div class="flex justify-between items-center w-full max-[640px]:text-sm ">
                                                        <div class="flex gap-2 items-center">
                                                        <img src="/backend/product/<?= $items['product_img'] ?>" alt="" srcset="" class=" size-12">
                                                        <a href="product.php?id=<?= $items['product_id'] ?>" class="text-wrap flex-2 xs:w-40 md:w-fit"><?= $items['product_name'] ?> <?= $items['size'] ?></a>
                                                        <p class="text-gray-600"><?= $items['quantity']?>X</p>
                                                         </div>
                                                        <p class=" text-end"> PHP
                                                        <?= $items['price']*$items['quantity'] ?>
                                                        </p>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <div class="flex justify-between items-center">
                                                    <p class="font-medium text-end">Order Placed:
                                                            <?= $formattDate  ?>
                                                    </p>
                                                    <p class="font-medium text-end">Total: PHP
                                                            <?= $order['payment'] ?>
                                                    </p>
                                                </div>
                                                
                                               
                                            </div>
                                        </div>
                                        
                                        <?php
                                    } 
                                }
                            } else {
                                ?>      
                                <div class="flex flex-col items-center justify-center h-full">
                                     <img src="./assets/img/out-of-stock.png" alt="" srcset="">
                                    <p class="text-lg">No orders yet</p>
                                </div>
                              <?php
                            }
                                break;
                       case "Cancelled":
                                    if(!empty($userId)){
                                        $orderObj->customer_id = $userId;
                                        $userOrder = $orderObj->getCancelledOrders();
                                    }
                                    if(!empty($userOrder)){
                                        foreach($userOrder as $order){
                                            if($order['status'] == 'cancelled' ){
                                                $orderItems = $orderObj->fetchOrderItems($order['id']);
                                                $date = $order['order_date'];
                                                $formattDate = $dateTime->format('F j, Y H:i:s');
                                                ?>
                                                <div class="w-full py-3 px-3 border-b ">
                                                    <div class=" flex-col flex gap-3 ">
                                                     <p class=" text-sm text-red-500 text-end ">Cancelled</p>

                                                        <?php
                                                        foreach($orderItems as $items){
                                                            ?>
                                                            <div class="flex justify-between items-center w-full  max-[640px]:text-sm">
                                                                <div class="flex gap-2 items-center">
                                                                <img src="/backend/product/<?= $items['product_img'] ?>" alt="" srcset="" class=" size-12">
                                                                <a href="product.php?id=<?= $items['product_id'] ?>" class="text-wrap flex-2 xs:w-40 md:w-fit"><?= $items['product_name'] ?> <?= $items['size'] ?></a>
                                                                <p class="text-gray-600"><?= $items['quantity']?>X</p>
                                                                </div>
        
                                                            <p class="font-medium text-end"> PHP
                                                            <?= $items['price']*$items['quantity'] ?>
                                                            </p>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        <div class="flex justify-between items-center">
                                                            <p class="font-medium text-end">Order Placed:
                                                                    <?= $formattDate  ?>
                                                            </p>
                                                            <p class="font-medium text-end">Total: PHP
                                                                    <?= $order['payment'] ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <?php
                                            }
                                        }
                                    }  else {
                                        ?>      
                                        <div class="flex flex-col items-center justify-center h-full">
                                             <img src="./assets/img/out-of-stock.png" alt="" srcset="">
                                            <p class="text-lg">No orders yet</p>
                                        </div>
                                      <?php
                                    }
                                break;
                            default:
                            echo "No matching case found.";
                        }
                       
                    }                
                ?>
            </div>
        </div>
    </div>

<?php
    include_once "./includes/footer.php";
?>