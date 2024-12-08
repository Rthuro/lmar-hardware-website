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

    if(isset($_GET['id'])){
       $product =  $productObj->fetchRecord($_GET['id']);
       $productSizeObj->product_id = $_GET['id'];
       $getSize = $productSizeObj->fetchProdSizeById();

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
        }
       
    }
    
    include_once "./includes/header.php";
    
?>

<div class="flex max-w-[1050px] mx-auto items-center py-6">
   <img src="/backend/product/<?=$product['product_img']?>" width="500" height="500" alt="<?=$product['product_name']?>">
   <div class="flex flex-col w-1/2 mt-8  p-6 ">
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
                <select name="product_size" id="productSizeDropdown"  class="w-[200px] border p-2 mb-2" required >

                <?php foreach($getSize as $arr){ ?>
                         <option value="<?= $arr['size_id'] ?>"
                         data-price-min="<?= $arr['price'] ?>" 
                         data-stock="<?= $arr['stock'] ?>"  
                         <?= isset($productName_size) && $productName_size == $arr['size_id'] ? "selected" : "" ?>>
                            <?= $arr['size'] ?>
                        </option>

                    <?php } ?>
                </select>
           <?php } ?>

           <label for="quantity" class="my-1">Quantity</label>
            <input id="quantityInput" type="number" name="quantity" value="<?= (isset( $quantity))? $quantity: "" ?>" min="1" placeholder="Quantity" class="border p-2 max-w-[200px]  select-none focus:outline-none "  >
            
            <p id="stockDisplay" class=" text-gray-600 my-2 "></p>
            <input type="hidden" name="product_id" value="<?=$product['id']?>" >
            <input type="submit" value="Add To Cart" name="add_cart" class="max-w-[400px] bg-customOrange text-white w-full py-2 px-4 my-3">
            <p class="text-red-600"><?= (!empty($error)? $error:"") ?></p>
        </form>
   </div>
</div>

<script>

    document.getElementById('productSizeDropdown').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const minPrice = selectedOption.getAttribute('data-price-min');
    const stock = selectedOption.getAttribute('data-stock');

    // Update price display
    document.getElementById('minPrice').textContent = minPrice;

    // Update stock display
    document.getElementById('stockDisplay').textContent = `Stocks: ${stock}`;

    // Update max attribute of quantity input
    document.getElementById('quantityInput').setAttribute('max', stock);
    });

</script>
<?= include_once "./includes/footer.php"; ?>

