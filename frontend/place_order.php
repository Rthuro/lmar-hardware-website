<?php

    require_once "../backend/classes/product.class.php";
    require_once "../backend/classes/cart.class.php";
    require_once "../backend/classes/product-image.class.php";
    require_once "../backend/classes/account.class.php";
    require_once "../backend/classes/orders.class.php";


    session_start();

    $productObj = new Product();
    $productImgObj = new ProductImage();
    $cartObj = new Cart();
    $accountObj = new Account();
    $orderObj = new Order();

    $cartIsEmpty = false;
    $quantity = $prodTotal = $total = $deliveryFee = $paymentErr = $subtotal = "";
    $currentDate = date('Y-m-d');

     if(isset($_SESSION['account'])){
        $username = $_SESSION['account']['username'];
        $email = $_SESSION['account']['email'];
        $userId = $accountObj->fetch($email);
       
        
        $cartObj->user_id = $userId['id'];
        $userCart = $cartObj->fetchCart();
        $fetchLoc = $orderObj->fetchLocation();


        if(empty($userCart)){
            $cartIsEmpty = true;
        }

        if(empty($userCart)){
            $cartIsEmpty = true;
        }

        if(isset($_GET['id'])){
            $cartObj->id = $_GET['id'];
           

            if( $cartObj->delete()){
                header('Location: cart.php');
            }
        } 

        if(isset($_POST['placeorder']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

            $payment = $_POST['payment'];
            $phone = $_POST['phone'];
            $loc = $_POST['loc'];
            $address = $_POST['address'];
            $date = $_POST['date'];
            $paymentTotal = $_POST['total'];
            
            // var_dump($payment, $phone, $loc, $address, $date, $paymentTotal);

                foreach($userCart as $prod){  
                    $getProd = $productObj->fetchRecord( $prod['product_id']);
                    $getProdImg = $productImgObj->fetchImage( $prod['product_id']); 
                    $getSize = $productObj->getSizesBySizeId( $prod['size_id']);
                    
                    $orderObj->product_id = $getProd['id'];
                    $orderObj->size_id = (!empty($getSize[0]['id']))? $getSize[0]['id']: null  ;
                    $orderObj->quantity = $prod['quantity'];
                    $orderObj->customer_id = $userId['id'];
                    $orderObj->payment =   $paymentTotal ;
                    $orderObj->address = $loc ." , ". $address;
                    $orderObj->contact_num = $phone;
                
                    if( $payment == "delivery"){
                        $orderObj->delivery_option ='delivery';
                        $orderObj->pickup_date = null;
                        $orderObj->delivery_date = $date;
                        
                        if(  $orderObj->createOrder()){

                            $productObj->stocks = $getProd['stocks'] - $prod['quantity'];
                            $productObj->id =  $prod['product_id'];
                            $productObj->modifyProdStock();

                            $cartObj->id = $prod['id'];
                            $cartObj->delete( $prod['id']);

                            header('location: cart.php');
                        }
    
                    } else if ( $payment == "pickup"){
                        $orderObj->delivery_option ='pickup';
                        $orderObj->pickup_date =  $date;
                        $orderObj->delivery_date = null;
    
                        if( $orderObj->createOrder()){
                            $productObj->stocks = $getProd['stocks'] - $prod['quantity'];
                            $productObj->id =  $prod['product_id'];
                            $productObj->modifyProdStock();

                            $cartObj->id = $prod['id'];
                            $cartObj->delete( $prod['id']);

                            header('location: cart.php');
                        }

                    }
       

                }
            
        }

     } else {
        header('location: landing_page.php');
     }


    include_once './includes/header.php';
    $subtotal = 0.00;

?>


<div class="flex flex-col items-center max-w-[1050px]  h-fit py-8 mx-auto">
    <p class="text-lg text-center mb-8">Check Out</p>
    <div class="max-w-[400px] flex flex-col my-6 gap-3 rounded-md border shadow-sm">
        <p class="text-sm font-medium p-3 border-b">Shopping Cart</p>
        <div class="flex flex-col border-b py-2 ">
            <?php
            if(!empty($userCart)){
            foreach($userCart as $prod){  
            $getProd = $productObj->fetchRecord( $prod['product_id']);
            $getProdImg = $productImgObj->fetchImage( $prod['product_id']); 
            $getSize = $productObj->getSizesBySizeId( $prod['size_id']);
                    ?>
                <div class="flex items-center justify-around">
                <img src="/backend/product/<?=$getProdImg['img']?>" width="50" height="50" alt="<?= $getProd['product_name'] ?>">
                <p class="text-sm" > 
                <?= $prod['quantity'] ?>X 
                <?=$getProd['product_name']?> 
                <?= (!empty($getSize[0]['size']))? $getSize[0]['size']: ""  ;?>
                </p>
                <p class="text-sm font-medium"><?php 
                            $price =  (!empty($getSize[0]['price']))? $getSize[0]['price']: $getProd['price'];
                            $quant =  $prod['quantity'];
                            $subtotal += intval($price) * intval($quant);

                            echo "PHP " . number_format($subtotal, 2);
                ?></p>
                </div>
            <?php } } ?>
        </div>
        <div class="flex flex-col gap-2 border-b">
            <label for="payment" class="text-sm font-medium px-3">Payment Method</label>
            <p class="text-xs text-gray-500 px-3">We only accepted payment in person, either pick up or after delivered</p>
            <form action="" method="post" class="flex flex-col gap-3 p-3">
                <div class="flex items-center">
                    <input type="radio" name="payment" value="pickup" id="" <?= (isset($payment) && $payment == 'pickup')? 'checked': "" ?> >
                    <label for="payment" class="text-sm" >Pick Up</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" name="payment" value="delivery" id="delivery" >
                    <label for="payment"class="text-sm" >Delivery</label>
                </div>
                <div>
                    <label for="phone" class="text-sm font-medium block my-1">Phone number:</label>
                    <input type="tel" id="phone" name="phone" placeholder="1234-567-8910" value="<?= (isset($phone))? $phone: "" ?>" class="border px-2 py-1 w-full" required>
                </div>
                <div id="forDelivery" class="flex flex-col ">
                    <label for="loc" class="text-sm font-medium py-1">Select nearby location</label>
                    <select name="loc" id="" class="border my-2 px-2 py-1" required>
                        <?php foreach($fetchLoc as $loc) { ?>
                        <option value="<?= $loc['name']?> " > <?= $loc['name']?></option>
                        <?php } ?>
                    </select>
                    <label for="address" class="text-sm font-medium py-1">Address</label>
                    <textarea name="address" id="" class="border resize-y p-1" required ></textarea>
                </div>
                <div class="">
                <label for="date" class="text-sm font-medium block mb-1">Pick a date</label>
                <input type="date" id="date" name="date" min="<?= $currentDate ?>" class="border"  required>
                </div>
                <!-- <div class="flex justify-between border-t pt-3">
                    <p class="text-sm">SubTotal</p>
                    <p class="text-sm font-medium">PHP= ?></p>
                </div> -->
                <!-- <div class="flex justify-between">
                    <p class="text-sm">Delivery Fee</p>
                    <p class="text-sm font-medium">PHP </p>
                </div> -->
                <div class="flex justify-between border-t pt-3">
                    <p class="text-sm">Total</p>
                    <p class="text-sm font-medium">PHP <?= number_format($subtotal, 2) ?></p>
                    <input type="hidden" name="total" value=" <?= $subtotal?>" >
                </div>
                <input class=" rounded-sm bg-black px-3 py-1 text-white" type="submit" value="Place order" name="placeorder">
            </form>
        </div>
    </div>
</div>


<?= include_once "./includes/footer.php"; ?>
