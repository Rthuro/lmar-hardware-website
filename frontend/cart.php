<?php

    require_once "../backend/classes/product.class.php";
    require_once "../backend/classes/product_size.class.php";
    require_once "../backend/classes/cart.class.php";
    require_once "../backend/classes/account.class.php";


    session_start();

    $productObj = new Product();
    $productSizeObj = new ProductSize();
    $cartObj = new Cart();
    $accountObj = new Account();

    $cartIsEmpty = false;
    $quantity = $prodTotal = "";

     if(isset($_SESSION['account'])){
        $username = $_SESSION['account']['username'];
        $email = $_SESSION['account']['email'];
        $userId = $accountObj->fetch($email);
        
        $cartObj->user_id = $userId['id'];
        $userCart = $cartObj->fetchCart();

        if(empty($userCart)){
            $cartIsEmpty = true;
        }

        if(isset($_GET['id'])){
            $cartObj->id = $_GET['id'];
           

            if( $cartObj->delete()){
                header('Location: cart.php');
            }
        } 

     } 

    if (isset($_POST['placeorder'])) {
        header('Location: place_order.php');
    }

    include_once './includes/header.php';
    $subtotal = 0.00;

?>

<div class="flex flex-col max-w-[1050px]  h-screen py-8  mx-auto">
    <p class="text-lg text-center mb-8">Shopping Cart</p>

        <?php if(!isset($_SESSION['account'])){ ?>
            <div class="flex flex-col items-center justify-center h-fit gap-3 mt-8">
                <img src="./assets/img/out-of-stock.png" alt="" srcset="">
                <p class="text-lg">Create an account to add product </p>
                <a href="login_page.php" class="rounded-sm bg-customOrange px-3 py-1 text-white">Log in now</a>
            </div>
            <?php } else { ?>

        <form action="" method="post" class="w-full  flex flex-col gap-3 xs:px-6">
            <table class=" table-fixed w-full">
                <thead>
                    <tr class="pb-2">
                        <td >Product</td>
                        <td ></td>
                        <td class="text-center">Price</td>
                        <td class="text-center">Quantity</td>
                        <td class="text-center">Total</td>
                    </tr>
                </thead>
                 <tbody>
                    <?php if(!$cartIsEmpty){ 
                    
                    foreach($userCart as $prod){        
                    $getProd = $productObj->fetchRecord( $prod['product_id']);
                    $productSizeObj->size_id = $prod['size_id'];
                    $getSize = $productSizeObj->fetchProdSizeBySizeId();
                    ?>
                        <tr class="border-y xs:text-xs lg:text-md"> 
                            <td class="py-1" >
                                <img src="/backend/product/<?=$getProd['product_img']?>" class="lg:size-[80px] xs:size-[50px]" alt="<?= $getProd['product_name'] ?>">
                            </td>
                            <td class="">
                                <a href="product.php?id=<?=$prod['product_id']?>"  >
                                            <?=$getProd['product_name']?> 
                                    <?= (!empty($getSize[0]['size']) && $getSize[0]['size'] !== 'no size')? $getSize[0]['size']: ""  ;?></a>
                             <a href="cart.php?id=<?=$prod['id']?>" class=" block text-xs text-red-500 hover:underline ">Remove</a>

                            </td>
                            <td class="text-gray-500">
                           
                            <p class="text-center">PHP <?= $prod['price'] ?></p>
                            </td>
                            <td class="" >
                            
                            <p class="text-center"><?= $prod['quantity'] ?></p>
                              <input type="hidden" name="cart_id" value="<?=$prod['id']?>" >
                            </td>
                            <td class="text-gray-500">
                            <p class="text-center">
                                <?php 
                                $subtotal += intval($prod['price']) * $prod['quantity'];

                                echo "PHP " . number_format($subtotal, 2);
                                ?>
                            </p>
                            
                            </td>

                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
            <?php if($cartIsEmpty){ ?>
                <div class="flex flex-col items-center justify-center h-fit gap-3 mt-8">
                    <img src="./assets/img/out-of-stock.png" alt="" srcset="">
                    <p class="text-lg">Cart is empty </p>
                </div>
            <?php } ?>
            <div class="flex w-full justify-end items-center  ">
                <span class="mr-3">Subtotal:</span>
                <span class="text-lg text-gray-600">PHP <?=number_format($subtotal, 2)?></span>
            </div>
            <div class="flex w-full justify-end gap-3">
                <!-- <input class=" rounded-sm bg-black px-3 py-1 text-white" type="submit" value="Update" name="update"> -->
                 <?php if($cartIsEmpty){ ?>
                     <input class=" rounded-sm bg-gray-400 px-3 py-1 text-white" type="submit" value="Check Out" name="placeorder" disabled> 
                <?php } else { ?>
                     <input class=" rounded-sm bg-customOrange px-3 py-1 text-white" type="submit" value="Check Out" name="placeorder">
                <?php } ?>
            </div>
        </form>       
    <?php }  ?>

</div>


  


<?=  include_once './includes/footer.php';?>
