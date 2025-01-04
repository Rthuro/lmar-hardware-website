<?php

    session_start();

     if(isset($_SESSION['account'])){
        $username = $_SESSION['account']['username'];
        $email = $_SESSION['account']['email'];
     } 

     include_once './includes/header.php';
     require_once "../backend/classes/product.class.php";
     require_once "../backend/classes/product_size.class.php";

     $productObj = new Product();
     $productSizeObj = new ProductSize();
     $topProducts = $productObj->displayTopProd();

    
?>
    <form action="" method="get" class=" mt-8 mb-6 items-center justify-center justify-self-center w-full py-3 lg:hidden  xs:flex ">
        <input type="text" name="" id="" placeholder="Search..." class=" w-9/12 px-6 py-2 text-md rounded-l bg-white border focus:outline-gray-200 focus:bg-slate-50   ">
        <button type="submit" value="" class="px-6 py-2 bg-gray-950 rounded-r -ml-1 ">
            <i data-lucide="search" class="size-6 text-white"></i>
        </button>
    </form>

    <section id="banner" class="flex w-full  lg:h-fit   ">
        <div class=" flex items-center lg:flex-nowrap md:flex-wrap justify-center w-full h-full mx-12 lg:flex-row xs:flex-col    ">
            <div class="flex flex-1 flex-col  gap-2 max-w-[950px] lg:items-start  xs:items-center ">
                <p class="lg:text-start  xs:text-center text-wrap font-bold sm:text-8xl  xs:text-5xl text-gray-950 ">Welcome to <span class="text-[#FB951C]">LMAR</span> Hardware</p>
                <p class="md:text-lg  xs:text-sm lg:text-start xs:text-center text-wrap text-[#1d1d1d]">Browse and shop easily to your next door hardware.</p>
                <div class="flex items-center gap-2 my-4 xs:flex-col sm:flex-row">
                    <button id="order_nowBtn" class=" text-white bg-[#fb951c] rounded py-2 px-4 w-[170px]">Order now</button>
                    <button id="view_prodBtn" class="text-white bg-gray-950 rounded py-2 px-4 gap-2 flex items-center w-[170px]">View products
                        <i data-lucide="arrow-right" class="size-5"></i>
                    </button>
                </div>
            </div>
            <img src="./assets/img/banner.png" class="object-contain  lg:size-[500px] xs:size-[350px] object-center">  
        </div>
    </section>
   
    <section class="flex items-start justify-center gap-8 mx-auto max-w-[1050px] h-fit my-8 flex-wrap">
        <div class="flex flex-col h-full  basis-72 gap-2  px-6 py-4 bg-customOrange  rounded-md shadow-md">
            <div class="flex items-center gap-1 border-b-2 border-gray-800 pb-2 ">
                        <i data-lucide="clock"></i>
                        <p class="text-2xl  font-semibold ">Open hours</p>
            </div>
            <div class="flex flex-col items-start">
                <p class="text-md font-medium"> Monday to Saturday</p>
                <p class="text-md font-medium">8:00 am - 5:00 pm</p>
            </div>
        </div>
        <div class="flex flex-col basis-72 gap-2  px-6 py-4 bg-customOrange  rounded-md shadow-md">
            <div class="flex items-center gap-1 border-b-2 border-gray-800 pb-2  ">
                        <i data-lucide="map-pin"></i>
                        <p class="text-2xl gap-2 font-semibold ">Location</p>
            </div>
            <p class="text-md font-medium text-wrap">Luyahan Housing, Villa Hermosa
                Pasonanca, Zamboanga City</p>
        
        </div>
        <div class="flex flex-col h-full  basis-72 gap-2 px-6 py-4 bg-customOrange rounded-md shadow-md">
            <div class="flex items-center gap-1 border-b-2 border-gray-800 pb-2 ">
                        <i data-lucide="send"></i>
                        <p class="text-2xl  font-semibold ">Contact us</p>
            </div>
            <div class="flex flex-col items-start">
                <p class="text-md font-medium">Orders & Enquiries</p>
                <p class="text-md font-medium underline">+612912344567</p>
            </div>
        </div>
       
    </section>

        <section class="flex flex-col items-center justify-center justify-self-center py-6 h-fit mx-auto max-w-[1050px]  xs:px-3 ">
            <p  class="text-center w-full text-3xl font-bold ">Shop by Categories</p>
            <div id="categoryContainer" class="grid lg:grid-cols-5 lg:grid-rows-2 md:grid-cols-3 md:grid-rows-3 min-[320px]:grid-cols-2 min-[320px]:grid-rows-2 h-fit w-full mx-auto my-8 gap-1 ">
                <!-- Category list goes here from landing_page.js -->
            </div>
       </section>

       <p class="text-3xl text-center mx-auto max-w-[1050px] font-semibold my-3">Top products</p>

        <div class="flex items-start justify-evenly max-w-[1050px] flex-wrap mx-auto mb-7 h-fit">
            <?php if(empty($topProducts)){ ?>
                <p class="text-xl text-gray-500 text-center w-full my-32"> Products not found</p>
            <?php } else { ?>
            <?php foreach ($topProducts as $product):
                $productSizeObj->product_id = $product['id']; 
                $prodPrice = $productSizeObj->fetchPriceToDisplay("product");
                ?>
                    <a href="product.php?id=<?= $product['id'] ?>" class="product relative flex flex-col gap-2  md:w-[250px] sm:w-[200px] xs:w-[160px] hover:shadow-lg cursor-pointer overflow-hidden">
                                <img  class="w-full md:h-[250px] sm:h-[180px] xs:h-[160px]"  src="/backend/product/<?= $product['product_img'] ?>" alt="<?=$product['product_name']?>">
                                <div class="py-2 px-3 flex flex-col gap-1">
                                    <span class=" text-xs text-customOrange"><?=$product['category_name']?></span>
                                     <span class="prodName text-lg truncate text-ellipsis "><?= $product['product_name'] ?></span>
                                     <p class="text-sm text-gray-700">
                                        PHP <?= $prodPrice['minPrice'] ?>
                                        <?= ($prodPrice['maxPrice'] == $prodPrice['minPrice']) ? "" : " - <span id='maxPrice'>" . $prodPrice['maxPrice'] . "</span>" ?>
                                    </p>
                                </div>
                    </a>  
                <?php endforeach; ?>
             <?php }  ?>
        </div>
     
            
    <div class="flex justify-end max-w-[1050px] mx-auto my-3">
        <button id="view_allBtn" class="text-white bg-[#1d1d1d] rounded py-2 px-4 gap-2 flex items-center mr-3">View all</button>
    </div>
    <?php
        include_once './includes/footer.php';

    ?>

    <script src="./utils/landing_page.js"></script>

</body>
</html>

