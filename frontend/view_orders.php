<?php

    require_once "../backend/classes/account.class.php";
    require_once "../backend/classes/orders.class.php";


    session_start();

    $accountObj = new Account();
    $orderObj = new Order();

    $cartIsEmpty = false;
    $quantity = $prodTotal = $total = $deliveryFee = $paymentErr = $subtotal = "";

    function formatDate($order_date){
        $dateTime = new DateTime($order_date);
        $formattedOrderDate = $dateTime->format('F j, Y, g:i a');
        return $formattedOrderDate;
    }

    if(isset($_SESSION['account'])){
        $username = $_SESSION['account']['username'];
        $email = $_SESSION['account']['email'];
        $userId = $accountObj->fetch($email);

     } else {
        header('location: landing_page.php');
     }

    if(isset($_GET['orderId']) ){
        $orderObj->customer_id = $userId['id'];
        $userOrder = $orderObj->displayInViewOrders($_GET['orderId']);
        $orderItems = $orderObj->fetchOrderItems($userOrder['id']);
        $date = formatDate($userOrder['order_date']);
        $orderObj->location_name = $userOrder['location'];
        $location = $orderObj->fetchLocationByName();
    }

    include_once './includes/header.php';
    $subtotal = 0;

?>


<div class="flex flex-col items-center max-w-[1050px]  h-fit py-8 mx-auto">
    <div class="max-w-[450px] flex flex-col my-6 gap-3 border shadow-md rounded-md ">
    <?php
     if(!empty($userOrder)){ ?>
                <div class=" flex-col flex gap-3 ">
                     
                    <?php if($userOrder['status'] == 'cancelled'){ ?>
                        <div class="flex-col flex py-3 px-4 gap-1">
                            <p class="text-xl text-red-700 font-medium"><?= $userOrder['delivery_option'] == 'delivery'? 'Delivery':'Pickup' ?> Order Cancelled</p>
                            <p class="text-sm">Place order on <?= $date?></p>
                        </div>
                    <?php } else { ?>
                        <div class="flex-col flex pt-3 px-4 gap-1">
                            <p class="text-xl text-green-700 font-medium"><?= $userOrder['delivery_option'] == 'delivery'? 'Delivery':'Pickup' ?> Order Completed</p>
                            <p class="text-sm">Place order on <?= $date?></p>
                        </div>
                    <?php } ?>
                    <div class="border-y flex flex-col gap-1 p-3">
                             <p class="font-medium ">Customer Information</p>
                             <div class="flex gap-2 items-center">
                                <p class=" text-sm"><?= $userId['email']?></p>
                                <p class="text-gray-600 text-xs"><?= $userOrder['contact_num']?></p>
                             </div>
                             <p class="text-sm text-gray-600 "><?= !empty($userOrder['address'])?  $userOrder['address']:'' ?>
                            </p>
                        </div>
                        <?php
                        foreach($orderItems as $items){
                            ?>
                            <div class="flex flex-col justify-between gap-1 w-full px-2">
                                <div class="flex gap-2 items-center justify-between">
                                    <img src="/backend/product/<?= $items['product_img'] ?>" alt="" srcset="" class=" size-12">
                                    <a href="product.php?id=<?= $items['product_id'] ?>" class="text-wrap text-end text-sm flex-2"><?= $items['product_name'] ?> <?= $items['size'] ?></a>
                                </div>
                            <div class="flex items-center justify-between">
                                 <p class="text-gray-600 text-sm"><?= $items['quantity']?>X</p>
                                <p class="font-medium text-end text-sm"> PHP
                                <?= $items['price']*$items['quantity'] ?>
                                </p>
                            </div>
                            
                            </div>
                            <?php
                        }
                        ?>
                        <div class="flex flex-col justify-end gap-2 px-2 py-3 border-t">
                            <?php if($userOrder['delivery_option'] == 'delivery'){ ?>
                                <p class=" text-end text-sm ">Delivery Fee: PHP
                                        <?= $location['deliveryFee'] ?>
                                </p>
                            <?php } ?>
                                <p class="font-medium text-end ">Total: PHP
                                        <?= $userOrder['payment'] ?>
                                </p>
                        </div>
                        
                    </div>
              
                
                <?php
           }   ?>

        
    </div>
</div>

<?= include_once "./includes/footer.php"; ?>
