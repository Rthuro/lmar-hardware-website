<?php
   
    require_once "../backend/classes/cart.class.php";
    require_once "../backend/classes/orders.class.php";
    require_once "../backend/classes/account.class.php";
    require_once "../backend/classes/product.class.php";
    require_once "../backend/classes/product-image.class.php";


    $productObj = new Product();
    $productImgObj = new ProductImage();
    $accountObj = new Account();
    $cartObj = new Cart();
    $orderObj = new Order();

    session_start();

     if(isset($_SESSION['account'])){
        $username = $_SESSION['account']['username'];
        $email = $_SESSION['account']['email'];
     } else {
        header('location: landing_page.php');
        exit();
     }

     $userId = $accountObj->fetch($email);

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
                <a href="" >Delete Account</a>    
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

                    <input type="submit" name="type"  value="To Receive" class="basis-2/6 p-3 <?= (isset($_GET['type']) && $_GET['type'] == "To Receive")? 'text-white bg-customOrange': '' ?>" >

                    <input type="submit" name="type" value="Completed" class="basis-2/6 p-3 <?= (isset($_GET['type']) && $_GET['type'] == "Completed")? 'text-white bg-customOrange': '' ?>" >

                    <input type="submit" name="type" value="Cancelled" class="basis-2/6 p-3 <?= (isset($_GET['type']) && $_GET['type'] == "Cancelled")? 'text-white bg-customOrange': '' ?>" >

                </form>
            <div class="flex flex-col gap-2 w-full h-full">
                <?php 
                     if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['type'])){

                        switch($_GET['type']){
                            case "Pick Up":
                                    $orderObj->customer_id = $userId['id'];
                                    $array = $orderObj ->getPickUpOrderCustomer();
                                        if(!empty($array)){
                                            foreach($array as $pickUp){ 
                                                $getProd = $productObj->fetchRecord( $pickUp['product_id']);
                                                $getProdImg = $productImgObj->fetchImage( $pickUp['product_id']); 
                                                $getSize = $productObj->getSizesBySizeId( $pickUp['size_id']);
                                                ?>
                                                <div class="flex items-center justify-around w-full py-2 border-b">
                                                  <img src="/backend/product/<?=$getProdImg['img']?>" width="80" height="80" alt="<?= $getProd['product_name'] ?>">
                                                  <a href="product.php?id=<?=$prod['product_id']?>" >
                                                   <?=$pickUp['quantity']?>X 
                                                    <?=$getProd['product_name']?> 
                                                    <?= (!empty($getSize[0]['size']))? $getSize[0]['size']: ""  ;?> </a>
                                                  <p class="bg-customOrange text-xs text-white px-3 py-1 rounded-full">
                                                    <?=  $pickUp['status']?>
                                                  </p>
                                                    <p class="text-lg font-medium">PHP <?=$pickUp['payment']?> </p>
                                                    
                                                </div>
                                         <?php   } 
                                        } else {
                                            ?>      
                                            <div class="flex flex-col items-center justify-center h-full">
                                                <img src="./assets/img/out-of-stock.png" alt="" srcset="">
                                                <p class="text-lg">No orders yet</p>
                                            </div>
                                          <?php
                                        }
                                    break;
                            case "To Deliver":
                                $orderObj->customer_id = $userId['id'];
                                $array = $orderObj ->getDeliveryCustomer();
                                    if(!empty($array)){
                                        foreach($array as $pickUp){ 
                                            $getProd = $productObj->fetchRecord( $pickUp['product_id']);
                                            $getProdImg = $productImgObj->fetchImage( $pickUp['product_id']); 
                                            $getSize = $productObj->getSizesBySizeId( $pickUp['size_id']);
                                            ?>
                                            <div class="flex items-center justify-around w-full py-2 border-b">
                                              <img src="/backend/product/<?=$getProdImg['img']?>" width="80" height="80" alt="<?= $getProd['product_name'] ?>">
                                              <a href="product.php?id=<?=$prod['product_id']?>" >
                                               <?=$pickUp['quantity']?>X 
                                                <?=$getProd['product_name']?> 
                                                <?= (!empty($getSize[0]['size']))? $getSize[0]['size']: ""  ;?> </a>
                                              <p class="bg-customOrange text-xs text-white px-3 py-1 rounded-full">
                                                <?=  $pickUp['status']?>
                                              </p>
                                                <p class="text-lg font-medium">PHP <?=$pickUp['payment']?> </p>
                                                
                                            </div>
                                     <?php   } 
                                        } else {
                                            ?>      
                                            <div class="flex flex-col items-center justify-center h-full">
                                                 <img src="./assets/img/out-of-stock.png" alt="" srcset="">
                                                <p class="text-lg">No orders yet</p>
                                            </div>
                                          <?php
                                        }
                                    break;
                            case "To Receive":
                                    $array = $cartObj ->fetchCart();
                                            if(!empty($array)){
                                               echo " not empty ";
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
                                    $array = $cartObj ->fetchCart();
                                            if(!empty($array)){
                                               echo " not empty ";
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
                             $array = $cartObj ->fetchCart();
                                     if(!empty($array)){
                                        echo " not empty ";
                                     } else {
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