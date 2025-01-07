<?php

    require_once "../backend/classes/product.class.php";
    require_once "../backend/classes/cart.class.php";
    require_once "../backend/classes/account.class.php";
    require_once "../backend/classes/product_size.class.php";

    session_start();

    if(isset($_SESSION['account'])){
        $username = $_SESSION['account']['username'];
        $email = $_SESSION['account']['email'];
     } 

    $productObj = new Product();
    $productSizeObj = new ProductSize();
    $cartObj = new Cart();
    $accountObj = new Account();

    function checkIfProdAvailable($getSize){
        $inStock = false;
        foreach($getSize as $size){
            if($size['stock'] > 0){
                $inStock = true;
                break;
            } else {
                $inStock = false;
            }
        }
        return $inStock;
    }

    if(isset($_GET['id'])){
       $product =  $productObj->fetchRecord($_GET['id']);
       $productSizeObj->product_id = $_GET['id'];
       $getSize = $productSizeObj->fetchProdSizeById();

        if(empty($product)){
            header('location: products.php');
        }
        
        $checkStock = checkIfProdAvailable($getSize);
    } else {
        header('location: products.php');
    }

   
    $error = $userId = $prodErr = $prodSize = '';
    $quantity = 1; 

    if(!empty($email)){
        $userId = $accountObj->fetch($email);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $quantity = $_POST['quantity'];
        $prodSize = (isset($_POST['product_size']))? $_POST['product_size']: null;

        if(isset($_POST['add_cart']) && isset($_SESSION['account']) && !empty($prodSize) ){

                $cartObj->user_id = $userId['id'];
                $cartObj->product_id = $_GET['id'];
                $cartObj->size_id = $prodSize;

                $checkIfExist = $cartObj ->check();
               // var_dump($prodSize);
                //var_dump($checkNoSizeExist);

                if( !empty($checkIfExist) ){
                    $cartObj->id = $checkIfExist[0]['id'];
                    $cartObj->quantity =  $quantity + $checkIfExist[0]['quantity'];

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
        } else {
            $prodErr = "Product not available.";
        }
       
    }
    
    include_once "./includes/header.php";
    
?>

<div class="flex max-w-[1050px] mx-auto md:flex-row xs:flex-col xs:items-center  py-6">
   <img src="/backend/product/<?=$product['product_img']?>" width="500" height="500" alt="<?=$product['product_name']?>">
   <div class="flex flex-col lg:w-1/2 mt-8  lg:p-6 xs:w-full xs:px-8 ">
        <p class="text-2xl font-medium text-wrap"><?=$product['product_name']?></p>
        <form action="" method="post" class="w-full flex flex-col">
            <?php if(!empty($getSize)){ 
                 $prodPrice = $productSizeObj->fetchPriceToDisplay("product");?>
               <p id="priceDisplay" class="text-gray-600 text-lg mb-1 mt-3">
                    PHP <span id="minPrice"><?= $prodPrice['minPrice'] ?></span>
                </p>
                <p class="text-gray-600 text-sm mb-4 mt-1">
                    Product price range: PHP <?= $prodPrice['minPrice'] ?>
                    <?= ($prodPrice['maxPrice'] == $prodPrice['minPrice']) ? "" : " - <span id='maxPrice'>" . $prodPrice['maxPrice'] . "</span>" ?>
                </p>

                <?php if(count($getSize) == 1 && $getSize[0]['size'] == 'no size'){ ?>
                    <input type="hidden" name="product_size" value="<?= $getSize[0]['size_id'] ?>">
                  <?php   } else { ?>
                      <select name="product_size" id="productSizeDropdown"  class="w-[200px] border p-2 mb-2" required >
                    <?php
                    foreach($getSize as $arr){  ?>
                         <option value="<?= $arr['size_id'] ?>"
                         data-price-min="<?= $arr['price'] ?>" 
                         data-stock="<?= $arr['stock'] ?>"  
                         <?= isset($productName_size) && $productName_size == $arr['size_id'] ? "selected" : "" ?> <?= $arr['stock'] == 0 ? "disabled" : "" ?>>
                            <?= $arr['size'] ?>
                        </option>
                    <?php } ?>
                </select>
                <?php } ?>
           <?php } ?>

           <label for="quantity" class="my-1">Quantity</label>
            <input id="quantityInput" type="number" name="quantity" value="<?= (isset( $quantity))? $quantity: "" ?>" min="1" placeholder="Quantity" class="border p-2 max-w-[200px]  select-none focus:outline-none "  >
            
            <p id="stockDisplay" class=" text-gray-600 my-2 "></p>
            <input type="hidden" name="product_id" value="<?=$product['id']?>" >
            <?php if($checkStock){ ?>
             <input type="submit" value="Add To Cart" name="add_cart" class=" md:max-w-[400px] xs:w-full bg-customOrange text-white w-full py-2 px-4 my-3" id="addCartBtn" >
            <?php }else { ?>
                <input type="submit" value="out of stock" class=" md:max-w-[400px] xs:w-full bg-gray-400 text-white py-2 px-4 my-3" id="addCartBtn" disabled>
            <?php } ?>
            <p class="text-red-600"><?= (!empty($error)? $error:"") ?></p>
            <p class="text-red-600"><?= (!empty($prodErr)? $prodErr:"") ?></p>
        </form>
   </div>
</div>
<div class="flex flex-col gap-3 max-w-[1050px] mx-auto py-3">
            <p class="text-xl font-medium pb-2 border-b">Description</p>
            <textarea rows="20" class="text-sm text-black/60 bg-white resize-none select-none" disabled><?= $product['description'] ?></textarea>
    </div>

<script>

    document.getElementById('productSizeDropdown').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const minPrice = selectedOption.getAttribute('data-price-min');
    const stock = selectedOption.getAttribute('data-stock');

    document.getElementById('minPrice').textContent = minPrice;
    document.getElementById('stockDisplay').textContent = `Stocks: ${stock}`;
    document.getElementById('quantityInput').setAttribute('max', stock);

    
        
    });

</script>
<?= include_once "./includes/footer.php"; ?>

