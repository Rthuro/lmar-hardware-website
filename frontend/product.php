<?php

    require_once "../backend/classes/product.class.php";
    require_once "../backend/classes/product-image.class.php";
    require_once "../backend/classes/cart.class.php";
    require_once "../backend/classes/account.class.php";

    session_start();

    if(isset($_SESSION['account'])){
        $username = $_SESSION['account']['username'];
        $email = $_SESSION['account']['email'];
     } 

    $productObj = new Product();
    $productImgObj = new ProductImage();
    $cartObj = new Cart();
    $accountObj = new Account();

    if(isset($_GET['id'])){
       $product =  $productObj->fetchRecord($_GET['id']);
       $productImg = $productImgObj->fetchImage($_GET['id']);
       $productSize = $productImgObj->getSizesByProductId($_GET['id']);

        if(empty($product)){
            exit('Product does not exist!');
        }
    } else {
        exit('Product does not exist!');
    }

   
    $error = $userId  = '';
    $quantity = 1; 

    if(!empty($email)){
        $userId = $accountObj->fetch($email);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $quantity = $_POST['quantity'];

        $prodSize = (isset($_POST['product_size']))? $_POST['product_size']: null;

        if(isset($_POST['add_cart']) && isset($_SESSION['account'])){

                $cartObj->user_id = $userId['id'];
                $cartObj->product_id = $_GET['id'];
                $cartObj->size_id = $prodSize;

                $checkIfExist = $cartObj ->check();
                $checkNoSizeExist = $cartObj ->checkNoSize();
               // var_dump($prodSize);
                //var_dump($checkNoSizeExist);

                if( $checkIfExist ){
                    $cartObj->id = $checkIfExist['id'];
                    $cartObj->quantity =  $quantity + $checkIfExist['quantity'];

                    $cartObj ->update();
                    header('location: cart.php');
                } else if($checkNoSizeExist){
                    $cartObj->id = $checkNoSizeExist['id'];
                    $cartObj->quantity =  $quantity + $checkNoSizeExist['quantity'];


                    $cartObj ->update();
                    header('location: cart.php');
                } else {
                    
                    $cartObj->quantity =  $quantity;

                    if($cartObj->add()){
                        header('location: cart.php');
                    } else {
                        $error = "something went wrong";
                    }
                }    
        } else if (!isset($_SESSION['account'])) {
            header('location: cart.php');
        }
       
    }
    
    include_once "./includes/header.php";
    
?>

<div class="flex max-w-[1050px] mx-auto items-center py-6">
   <img src="/backend/product/<?=$productImg['img']?>" width="500" height="500" alt="<?=$product['product_name']?>">
   <div class="flex flex-col w-1/2 mt-8  p-6 ">
        <p class="text-2xl font-medium text-wrap"><?=$product['product_name']?></p>
        <p id="priceDisplay" class=" text-gray-600 text-lg mb-4 mt-3 ">PHP <?=$product['price']?> </p>
        <form action="" method="post" class="w-full flex flex-col">

            <?php if(!empty($productSize)){ ?>
                <select name="product_size" id="productSizeDropdown"  class="w-[200px] border p-2 mb-2" required >

                    <?php foreach($productSize as $arr){ ?>
                         <option value="<?= $arr['id'] ?>" data-price=<?= $arr['price'] ?> <?= isset($productName_size) && $productName_size == $arr['id'] ? "selected" : "" ?>>
                            <?= $arr['size'] ?>
                        </option>

                    <?php } 
                    ?>
                
                </select>
           <?php } ?>

           <label for="quantity" class="my-1">Quantity</label>
            <input type="number" name="quantity" value="<?= (isset( $quantity))? $quantity: "" ?>" min="1" max="<?=$product['stocks']?>" placeholder="Quantity" class="border p-2 max-w-[200px]  select-none focus:outline-none "  >
            
            <p class=" text-gray-600 my-2 ">Stocks: <?=$product['stocks']?></p>
            <input type="hidden" name="product_id" value="<?=$product['id']?>" >
            <input type="submit" value="Add To Cart" name="add_cart" class="max-w-[400px] bg-customOrange text-white w-full py-2 px-4 my-3">
            <p class="text-red-600"><?= (!empty($error)? $error:"") ?></p>
        </form>
   </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sizeDropdown = document.getElementById('productSizeDropdown');
        const priceDisplay = document.getElementById('priceDisplay');
        

        sizeDropdown.addEventListener('change', function () {
            const selectedOption = sizeDropdown.options[sizeDropdown.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            priceDisplay.textContent = `PHP ${price}`;
        });
    });
</script>
<?= include_once "./includes/footer.php"; ?>

