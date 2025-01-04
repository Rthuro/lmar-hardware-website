<?php

    require_once "../backend/classes/product.class.php";
    require_once "../backend/classes/product_size.class.php";
    require_once "../backend/classes/cart.class.php";
    require_once "../backend/classes/account.class.php";
    require_once "../backend/classes/orders.class.php";


    session_start();

    $productObj = new Product();
    $productSizeObj = new ProductSize();
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

                if (!empty($userCart)) {
                    // Create a single order first
                    $orderObj->customer_id = $userId['id'];
                    $orderObj->payment = $paymentTotal;
                    $orderObj->contact_num = $phone;
                
                    if ($payment == "delivery") {
                        $orderObj->address = $loc . " , " . $address;
                        $orderObj->location_name = $loc;
                        $deliveryFee = $orderObj->getDeliveryFee();
                        $orderObj->delivery_option = 'delivery';
                        $orderObj->pickup_date = null;
                        $orderObj->delivery_date = $date;
                    } else if ($payment == "pickup") {
                        $orderObj->location_name = null;
                        $orderObj->address = null;
                        $orderObj->delivery_option = 'pickup';
                        $orderObj->pickup_date = $date;
                        $orderObj->delivery_date = null;
                    }
                
                
                    if ($orderObj->createOrder()) { // Create the order ONCE
                        $orderId = $orderObj->getLastInsertedId(); // Get the ID of the newly created order
                
                        foreach ($userCart as $prod) {
                            $getProd = $productObj->fetchRecord($prod['product_id']);
                            $productSizeObj->size_id = $prod['size_id'];
                            $getSize = $productSizeObj->fetchProdSizeBySizeId();
                
                            $orderObj->id = $orderId['id']; 
                            $orderObj->product_id = $getProd['id'];
                            $orderObj->size_id = $getSize[0]['size_id'];
                            $orderObj->quantity = $prod['quantity'];
                            $orderObj->price = $getSize[0]['price']; 
                
                            $orderObj->createOrderItems(); 
                
                            $productSizeObj->size_id = $prod['size_id'];
                            $productSizeObj->stock = intval($getSize[0]['stock']) - intval($prod['quantity']);
                            $productSizeObj->modifyProdStock();
                
                            $cartObj->id = $prod['id'];
                            $cartObj->delete($prod['id']);
                        }
                
                        if($payment == "delivery"){
                            header('location: account.php?type=To+Deliver');
                        } else if ($payment == "pickup"){
                            header('location: account.php?type=Pick+Up');
  
                        }
                        
                    }
                }
       
       
       
            }

     } else {
        header('location: landing_page.php');
     }

     if(isset($_SESSION['account']) && $cartIsEmpty){
        header('location: landing_page.php');
     }

    include_once './includes/header.php';
    $subtotal = 0;

?>


<div class="flex flex-col items-center max-w-[1050px]  h-fit py-8 mx-auto">
    <p class="text-lg text-center mb-8">Check Out</p>
    <div class="max-w-[400px] flex flex-col my-6 gap-3 border shadow-md rounded-md ">
    <?php
     if(!empty($userCart)){
      
        foreach($userCart as $prod){  
        $getProd = $productObj->fetchRecord( $prod['product_id']);
        $productSizeObj->size_id = $prod['size_id'];
        $getSize = $productSizeObj->fetchProdSizeBySizeId();
                    ?>
            
                    <div class="flex flex-col border-b py-2 ">
                        <div class="flex items-center justify-around">
                        <img src="/backend/product/<?=$getProd['product_img']?>" width="50" height="50" alt="<?= $getProd['product_name'] ?>">
                        <p class="text-sm" > 
                        <?= $prod['quantity'] ?>X 
                        <?=$getProd['product_name']?> 
                        <?= (!empty($getSize[0]['size']) && $getSize[0]['size'] !== 'no size')? $getSize[0]['size']: ""  ;?>
                        </p>
                        <p class="text-sm font-medium" data-item-price="<?= $getSize[0]['price'] * $prod['quantity'] ?>">PHP <?php 
                                    $subtotal += $getSize[0]['price'] *  $prod['quantity'];
                                    echo $getSize[0]['price'] *  $prod['quantity']; 
                                    ?></p>
                        <input type="hidden" data-item-id="<?= $prod['product_id'] ?>" data-item-qty="<?= $prod['quantity'] ?>" data-item-size-id="<?= $prod['size_id'] ?>" data-item-price="<?= $getSize[0]['price']  ?>">
                  </div>
                </div>
            <?php } ?>

        <div class="flex flex-col gap-2 border-b">
            <label for="payment" class="text-sm font-medium px-3">Payment Method</label>
            <p class="text-xs text-gray-500 px-3">We only accepted payment in person, either pick up or after delivered</p>
            <form action="" method="post" class="flex flex-col gap-3 p-3">
                <div class="flex items-center">
                    <input type="radio" name="payment" value="pickup" id="pickUpRadio" <?= (isset($payment) && $payment == 'pickup')? 'checked': "" ?> >
                    <label for="payment" class="text-sm" >Pick Up</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" id="deliveryRadio" name="payment" value="delivery" id="delivery" >
                    <label for="payment"class="text-sm" >Delivery</label>
                </div>
                <div>
                    <label for="phone" class="text-sm font-medium block my-1">Phone number:</label>
                    <input type="tel" id="phone" name="phone" placeholder="1234-567-8910" value="<?= (isset($phone))? $phone: "" ?>" class="border px-2 py-1 w-full" required>
                </div>
                <div id="forDelivery" class="flex-col hidden">
                    <label for="loc" class="text-sm font-medium py-1">Select nearby location</label>
                    <select id="locationDropdown" name="loc" id="" class="border my-2 px-2 py-1" >
                        <option value="" >Select location</option>
                        <?php foreach($fetchLoc as $loc) { ?>
                        <option data-delivery-fee="<?= $loc['deliveryFee']?>" value="<?= $loc['name']?> " > <?= $loc['name']?></option>
                        <?php } ?>
                    </select>
                    <label for="address"  class="text-sm font-medium py-1">Address</label>
                    <textarea name="address" id="" class="border resize-y p-1"  ></textarea>
                </div>
                <div class="">
                    <label for="date" class="text-sm font-medium block mb-1">Pick a date</label>
                    <input type="date" id="date" name="date" min="<?= $currentDate ?>" class="border"  required>
                </div>
                <div class="flex justify-between border-t pt-3">
                    <p class="text-sm">SubTotal</p>
                    <p class="text-sm font-medium" id="subTotal" data-subtotal="<?= $subtotal ?>" >PHP <?= $subtotal?></p>
                </div>
                <div class="flex justify-between">
                    <p class="text-sm">Delivery Fee</p>
                    <p class="text-sm font-medium" id="displayDeliveryfee"> </p>
                </div>
                <div class="flex justify-between border-t pt-3">
                    <p class="text-sm">Total</p>
                    <p class="text-sm font-medium">PHP <span id="setTotalAmount"><?= $subtotal ?></span></p>
                    <input type="hidden" id="getTotalAmount" name="total" value=" <?= $subtotal?>" >
                </div>
                <input class=" rounded-sm bg-black px-3 py-1 text-white" type="submit" value="Place order" name="placeorder">
            </form>
        </div>
    <?php }  ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() { // Wait for DOM to load before manipulating
       

       
        document.getElementById('locationDropdown').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const subTotal = document.getElementById('subTotal').getAttribute('data-subtotal');
            const fee = selectedOption.getAttribute('data-delivery-fee');
            document.getElementById('displayDeliveryfee').textContent = `PHP ${fee}`;
            document.getElementById('setTotalAmount').textContent = `${parseInt(fee) + parseInt(subTotal)}`;
            document.getElementById('getTotalAmount').value = parseInt(fee) + parseInt(subTotal);
        });

        let deliveryRadio = document.getElementById('deliveryRadio');
        let pickUpRadio = document.getElementById('pickUpRadio');
        const forDelivery = document.getElementById('forDelivery');

        deliveryRadio.addEventListener('change', function() { 
            if (this.checked) { 
                forDelivery.classList.replace('hidden', 'flex');
                document.getElementById('displayDeliveryfee').style.display = "block"; //use block instead of flex

            } else { 
                forDelivery.classList.replace('flex', 'hidden');
            }
        });
        pickUpRadio.addEventListener('change', function() { 
            if (this.checked) { 
                forDelivery.classList.replace('flex', 'hidden');
                const subTotal = document.getElementById('subTotal').getAttribute('data-subtotal');
                document.getElementById('displayDeliveryfee').style.display = "none";
                document.getElementById('setTotalAmount').textContent = `${subTotal}`;
                document.getElementById('getTotalAmount').value = parseInt(subTotal);
            } 
        });
    });
</script>


<?= include_once "./includes/footer.php"; ?>
