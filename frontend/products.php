<?php
   
   require_once "../backend/classes/product.class.php";
   require_once "../backend/classes/product_size.class.php";
   require_once "../backend/tools/functions.php";

    $productObj = new Product();
    $productSizeObj = new ProductSize();

    session_start();
    if(isset($_SESSION['account'])){
        $username = $_SESSION['account']['username'];
        $email = $_SESSION['account']['email'];
     } 
   
    $search_term = isset($_GET['search']) ? clean_input($_GET['search']): '';
    $filter_category = isset($_GET['category']) ? clean_input($_GET['category']): '';

    $categories = $productObj->fetchCategory();
    // $products = $productObj->showAll($search_term, $filter_category);

    $productsPerPage = 9; 
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
    $start = ($currentPage - 1) * $productsPerPage;

    $totalProducts = $productObj->getTotalProducts();
    $totalPages = ceil($totalProducts / $productsPerPage);

    $products = $productObj->getProducts($start, $productsPerPage, $search_term,  $filter_category);

     include_once 'includes/header.php';
?>

<body>

    <div class=" items-center justify-center lg:hidden xs:flex">
         <button id="filter_Bttn" class="flex items-center gap-1  px-3 py-2 rounded-sm    text-gray-950 ">
            <i data-lucide="filter" class="size-5"></i>
            <p class="font-medium">Filters</p>
        </button>
            <form id="filter_mobileCont" action="" method="get" class="hidden flex-col fixed top-0 left-0 w-[50%] max-w-[355px] bottom-0 filter border-[1px] bg-white p-4 z-50 ">
                <div  class="flex items-center justify-between pb-2">
                    <p class="text-[28px] ">Filters</p>
                    <button id="filter_xBttn"><i  data-lucide="x"></i></button>
                </div>
                <label for="availability" class="block text-[18px] pl-1 pb-1 border-b-[1px]">Availability</label>
                <div class="block pl-2 mt-2 mb-1 ">
                    <input type="radio" name="availability" id="inStock">
                    <label for="inStock">In stock</label>
                </div>
            
                <div class="block pl-2" >
                    <input type="radio" name="availability" id="outOfStock">
                    <label for="outOfStock">Out of stock</label>
                </div>
                <label for="priceRange" class="block text-[18px] pl-1 my-2 ">Price </label>
                <input type="range" name="priceRange" id="priceRange" min="0" max="10000" step="10" class="w-full block ">
                <div class="flex justify-between items-center mt-1">
                    <p id="minPrice">PHP</p>
                    <p id="maxPrice">PHP 10,000</p>
                </div>
                <div class="flex flex-col justify-between mt-6 gap-2">
                    <input type="submit" value="Filter" name="filter" class="py-2  o-y-btn rounded-[2px] cursor-pointer ">
                    <input type="submit" value="Clear All" name="clearFilter" class="py-2  outline-o-btn cursor-pointer ">

                </div>
            </form>

            <form action="" method="get" class="flex  items-center justify-center  w-[65%] lg:hidden my-3 ">
                 <input type="text" name="" id="" placeholder="Search..." class=" w-9/12 px-6 py-2 text-md rounded-l bg-white border focus:outline-gray-200 focus:bg-slate-50   ">
                    <button type="submit" value="" class="px-6 py-2 bg-gray-950 rounded-r -ml-1 ">
                            <i data-lucide="search" class="size-6 text-white"></i>
                </button>
        </form>
    </div>

    <div class="flex items-start justify-center max-w-[1050px] mx-auto gap-6 my-8 flex-1">
            <form action="" method="get" class="flex flex-col w-[250px] border-[1px] h-fit bg-white p-4  xs:hidden  lg:flex   ">
                                <p class="text-[28px] pb-2">Filters</p>
                                <label for="availability" class="block text-[18px] pl-1 pb-1 border-b-[1px]">Availability</label>
                                <div class="block pl-2 mt-2 mb-1 ">
                                    <input type="radio" name="availability" id="inStock">
                                    <label for="inStock">In stock</label>
                                </div>
                            
                                <div class="block pl-2" >
                                    <input type="radio" name="availability" id="outOfStock">
                                    <label for="outOfStock">Out of stock</label>
                                </div>
                                <label for="priceRange" class="block text-[18px] pl-1 my-2 ">Price </label>
                                <input type="range" name="priceRange" id="priceRange2" min="0" max="10000" step="10" class="w-full block ">
                                <div class="flex justify-between items-center mt-1">
                                    <p id="minPrice2">PHP</p>
                                    <p id="maxPrice">PHP 10,000</p>
                                </div>
                                <div class="flex flex-col justify-between mt-6 gap-2">
                                    <input type="submit" value="Filter" name="filter" class="py-2  o-y-btn rounded-[2px] cursor-pointer ">
                                    <input type="submit" value="Clear All" name="clearFilter" class="py-2  outline-o-btn cursor-pointer ">

                                </div>
        </form>
   
       
            <?php if(empty($products)){ ?>
                <p class="text-xl text-gray-500 text-center w-full my-32"> Products not found</p>
            <?php } else { ?>
            <div class="grid  grid-cols-3 grid-rows-3 gap-2  mb-7 h-fit z-0">
            <?php foreach ($products as $product):
                $productSizeObj->product_id = $product['id']; 
                $prodPrice = $productSizeObj->fetchPriceToDisplay("landing_page");
                ?>
                    <a href="product.php?id=<?= $product['id'] ?>" class="product relative flex flex-col gap-2  w-[250px] hover:shadow-lg cursor-pointer overflow-hidden">
                                <img class="size-[250px]"  src="/backend/product/<?= $product['product_img'] ?>" alt="<?=$product['product_name']?>">
                                <div class="py-2 px-3 flex flex-col gap-1">
                                    <span class=" text-xs text-customOrange"><?=$product['category_name']?></span>
                                     <span class="prodName text-lg "><?= $product['product_name'] ?></span>
                                     <span class=" text-sm text-gray-700" >PHP <?= $prodPrice['minPrice'] ?></span>
                                </div>
                    </a>  
                <?php endforeach; ?>
               </div>
             <?php }  ?>
    </div>
    <div class="flex items-center justify-center mx-auto max-w-[1050px]">
        <?php if ($totalPages >= 1){ ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="rounded-md border border-black/80  active:bg-black py-2 px-4 active:text-white <?= ($i == $currentPage) ? 'active' : '' ?>" ><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            <?php }else{ ?>
                <p>No products found.</p>
            <?php } ?>
    </div>
    


   
    <?php
        include_once './includes/footer.php';
    ?>
    <script src="./utils/products.js"></script>
</body>
</html>