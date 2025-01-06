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

     $categories = $productObj->fetchCategory();
     // $products = $productObj->showAll($search_term, $filter_category);
     $maxPrice = $productObj->getMaxSizePrice();
     $totalProd = $productObj->getTotalProducts(); 

    $search_term = isset($_GET['search']) ? clean_input($_GET['search']): '';
    $filter_category = isset($_GET['category']) ? clean_input($_GET['category']): '';
    $filter_price =  isset($_GET['price'])&& $_GET['price']>0 ? clean_input($_GET['price']): null;
    
    if(isset($_GET['clear'])){
        header('location: products.php');
        exit();
    }

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

    $productsPerPage = 15; 
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
    $start = ($currentPage - 1) * $productsPerPage;

    $totalProducts = $productObj->getTotalProducts($search_term, $filter_category, $filter_price);
    $totalPages = ceil($totalProducts / $productsPerPage);

    $products = $productObj->getProducts($start, $productsPerPage, $search_term,  $filter_category, $filter_price);
    
    include_once 'includes/header.php';

    
?>

<body>

    <div class=" items-center justify-center lg:hidden xs:flex">
         <button id="filter_Bttn" type="button" class="flex items-center gap-1  px-3 py-2 rounded-sm   text-gray-950 ">
            <i data-lucide="filter" class="size-5"></i>
            <p class="font-medium">Filters</p>
        </button>
            <form id="filter_mobileCont" action="" method="get" class="hidden flex-col fixed top-0 left-0 w-[50%] max-w-[355px] bottom-0 filter border-[1px] bg-white p-4 z-50 ">
                <div  class="flex items-center justify-between pb-2">
                    <p class="text-[28px] ">Filters</p>
                    <button id="filter_xBttn" type="button"><i  data-lucide="x"></i></button>
                </div>
                <p>Result <?= $totalProducts ?> of <?= $totalProd ?> products</p>
                    <?php if(isset($_GET['category'])){ ?>
                            <input type="hidden" name="category" value="<?= isset($_GET['category'])? $_GET['category']:'' ?>">
                    <?php } 
                     if(isset($_GET['search'])){ ?>
                            <input type="hidden" name="search" value="<?= isset($_GET['search'])? $search_term:'' ?>">
                    <?php } 
                     if(isset($_GET['page'])){ ?>
                            <input type="hidden" name="page" value="<?= isset($_GET['page'])? $currentPage:'' ?>">
                    <?php } ?>
                <label for="priceRange" class="block text-[18px] pl-1 my-2 ">Price </label>
                <input type="range" name="price" id="priceRange" min="0" max="<?= !empty($maxPrice)? $maxPrice['maxPrice']:'' ?>" step="10" class="w-full block " value="<?= isset($_GET['price'])? $_GET['price']:0 ?>">
                <div class="flex justify-between items-center mt-1">
                    <p id="minPrice">PHP <?= isset($_GET['price'])? (int)$_GET['price']:0 ?></p>
                    <p id="maxPrice">PHP <?= !empty($maxPrice)? $maxPrice['maxPrice']:'' ?></p>
                </div>
                <div class="flex flex-col justify-between mt-6 gap-2">
                        <input type="submit" value="Filter" class="py-2  o-y-btn rounded-[2px] cursor-pointer ">
                        <input type="submit" name="clear" value="Clear Filter" id="clearFilter" class="py-2  outline-o-btn cursor-pointer ">
                </div>
            </form>

            <form action="" method="get" class="flex  items-center justify-center  w-[65%] lg:hidden my-3 ">
                 <input type="text" name="search" id="" placeholder="Search..." class=" w-9/12 px-6 py-2 text-md rounded-l bg-white border focus:outline-gray-200 focus:bg-slate-50   ">
                    <button type="submit" value="" class="px-6 py-2 bg-gray-950 rounded-r -ml-1 ">
                            <i data-lucide="search" class="size-6 text-white"></i>
                </button>
        </form>
    </div>

    <div class="flex items-start justify-center max-w-[1050px] mx-auto gap-6 my-8 flex-1">
            <form  method="get" class="flex flex-col w-[250px] border-[1px] h-fit bg-white p-4  xs:hidden  lg:flex   ">
                                <p class="text-[28px] pb-2">Filters</p>
                                <p>Result <?= $totalProducts ?> of <?= $totalProd ?> products</p>
                                <?php if(isset($_GET['category'])){ ?>
                                <input type="hidden" name="category" value="<?= isset($_GET['category'])? $_GET['category']:'' ?>">
                                <?php } 
                                if(isset($_GET['search'])){ ?>
                                        <input type="hidden" name="search" value="<?= isset($_GET['search'])? $search_term:'' ?>">
                                <?php } 
                                if(isset($_GET['page'])){ ?>
                                        <input type="hidden" name="page" value="<?= isset($_GET['page'])? $currentPage:'' ?>">
                                <?php } ?>
                                
                                
                                <label for="price" class="block text-[18px] pl-1 my-2 ">Price </label>
                                <input type="range" name="price" id="priceRange2" min="0" max="<?= !empty($maxPrice)? $maxPrice['maxPrice']:'' ?>" step="10" class="w-full block " value="<?= isset($_GET['price'])? $_GET['price']:0 ?>">
                                <div class="flex justify-between items-center mt-1">
                                    <p id="minPrice2">PHP <?= isset($_GET['price'])? (int)$_GET['price']:0 ?></p>
                                    <p id="maxPrice">PHP <?= !empty($maxPrice)? $maxPrice['maxPrice']:'' ?></p>
                                </div>
                                <div class="flex flex-col justify-between mt-6 gap-2">
                                    <input type="submit" value="Filter" class="py-2  o-y-btn rounded-[2px] cursor-pointer ">
                                    <input type="submit" name="clear" value="Clear Filter" id="clearFilter" class="py-2  outline-o-btn cursor-pointer ">
                                </div>
            </form>
   
       
            <?php if(empty($products)){ ?>
                <p class="text-xl text-gray-500 text-center w-full my-32"> Products not found</p>
            <?php } else { ?>
            <div class="grid  md:grid-cols-3 xs:grid-cols-2 grid-rows-3 md:gap-2 xs:gap-1  mb-7 h-fit z-0 content-center">
            <?php foreach ($products as $product):
                $productSizeObj->product_id = $product['id']; 
                $prodPrice = $productSizeObj->fetchPriceToDisplay("product");
                $getSize = $productSizeObj->fetchProdSizeById();
                
                $checkStock = checkIfProdAvailable($getSize);
                ?>
                    <a href="product.php?id=<?= $product['id'] ?>" class="product relative flex flex-col gap-2  md:w-[250px] sm:w-[200px] xs:w-[160px] hover:shadow-lg cursor-pointer overflow-hidden">
                                <img class="w-full md:h-[250px] sm:h-[180px] xs:h-[160px]"  src="/backend/product/<?= $product['product_img'] ?>" alt="<?=$product['product_name']?>">
                                <div class="py-2 px-3 flex flex-col gap-1">
                                <?php if(!$checkStock){ ?>
                                         <div class="absolute top-0 bottom-0 left-0 right-0 bg-white/40"></div>
                                <?php } ?>
                                    <span class=" text-xs text-customOrange"><?=$product['category_name']?></span>
                                     <span class="prodName text-lg truncate text-ellipsis "><?= $product['product_name'] ?></span>
                                     <p class="text-sm text-gray-700">
                                        PHP <?= $prodPrice['minPrice'] ?>
                                        <?= ($prodPrice['maxPrice'] == $prodPrice['minPrice']) ? "" : " - <span id='maxPrice'>" . $prodPrice['maxPrice'] . "</span>" ?>
                                    </p>
                                    
                                </div>  
                                
                    </a>  
                <?php endforeach; ?>
               </div>
             <?php }  ?>
    </div>

    <div class="flex items-center justify-center mx-auto max-w-[1050px]">
        <?php if ($totalPages >= 1){ ?>
                <form method="get" class="pagination">
                    <?php if(isset($_GET['category'])){ ?>
                                <input type="hidden" name="category" value="<?= isset($_GET['category'])? $_GET['category']:'' ?>">
                                <?php } 
                                if(isset($_GET['search'])){ ?>
                                        <input type="hidden" name="search" value="<?= isset($_GET['search'])? $search_term:'' ?>">
                                <?php } 
                                if(isset($_GET['price'])){ ?>
                                <input type="hidden" name="price" value="<?= isset($_GET['price'])? $_GET['price']:null ?>">
                     <?php } 
                      for ($i = 1; $i <= $totalPages; $i++): ?>
                        <input type="submit" name="page" value="<?= $i ?>" class=" w-fit rounded-md border border-black/80  py-2 px-4  <?= ($i == $currentPage) ? ' text-white bg-black' : '' ?>" >
                    <?php endfor; ?>

                </form >
            <?php } ?>
    </div>
    


   
    <?php
        include_once './includes/footer.php';
    ?>
    <script src="./utils/products.js"></script>
</body>
</html>