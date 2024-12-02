<?php
   
    require_once '../backend/classes/product.class.php';

    $productObj = new Product();
    $products = $productObj->showAll('','');

    session_start();
    if(isset($_SESSION['account'])){
        $username = $_SESSION['account']['username'];
        $email = $_SESSION['account']['email'];
     } 
     include_once 'includes/header.php';
?>

<body>

    <!-- <div class="hidden gap-1 items-center justify-center justify-self-center w-full mt-[110px]  max-[1030px]:flex min-[1030px]:mt-[180px] min-[1030px]:justify-start min-[1030px]:pl-[22%] ">
        <div class="">
            <button id="filter_Bttn" class="flex items-center gap-1 bg-white px-3 py-2 rounded-sm border border-black "><img src="./assets/icons/filter (1).svg" alt="" class="size-5"><p class="font-medium">Filters</p></button>
            <form id="filter_mobileCont" action="" method="get" class="hidden flex-col fixed top-0 left-0 w-[50%] max-w-[355px] bottom-0 filter border-[1px] bg-white p-4 z-50 ">
                <div  class="flex items-center justify-between pb-2">
                    <p class="text-[28px] ">Filters</p>
                    <img id="filter_xBttn" src="../assets/icons/x.svg" alt="">
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
        </div>
      
        <form action="" method="get" class="flex  items-center justify-center  w-[65%] min-[1030px]:hidden my-3 ">
            <input type="text" name="" id="" placeholder="Search..." class=" w-full px-[1.6rem] py-[0.5rem] text-[1rem] rounded-l bg-white border border-[#d3d3d3] ">
            <button type="submit" value="" class="px-[1.6rem] py-[0.6rem] bg-[#FB951C] rounded-r ml-[-2px] ">
                <img src="./assets/icons/magnifying-glass.png" alt="search icon by Taufik Glyph on flaticon" class="size-auto">
            </button>
        </form>
    </div>

    <div  class=" flex  justify-center w-[1350px] h-fit  mb-[50px] mt-[200px]    ">
        <div class=" flex justify-center mx-auto  w-full gap-4">
            <form action="" method="get" class="filter w-[300px] border-[1px] h-fit bg-white p-4  max-[1030px]:hidden  min-[1031px]:flex   ">
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
            <section class="productGrid grid-flow-col-dense grid gap-2 w-fit max-[640px]:gap-1 ">
                        <div class="productPageContainer ">
                            <img class=""  src="./assets/product_img/11.png" />
                            <a class="variant">Building Materials</a> 
                            <div class="productPageDetails" >
                                <a class="heading ">Concrete Hollow Block</a>
                                <p class="price" >PHP 19.00</p>
                                <p class="sold" >1k sold</p>
                            </div>
                        </div>
                        <div class="productPageContainer ">
                            <img class=""  src="./assets/product_img/11.png" />
                            <a class="variant">Building Materials</a> 
                            <div class="productPageDetails" >
                                <a class="heading ">Concrete Hollow Block</a>
                                <p class="price" >PHP 19.00</p>
                                <p class="sold" >1k sold</p>
                            </div>
                        </div>
                        <div class="productPageContainer ">
                            <img class=""  src="./assets/product_img/11.png" />
                            <a class="variant">Building Materials</a> 
                            <div class="productPageDetails" >
                                <a class="heading ">Concrete Hollow Block</a>
                                <p class="price" >PHP 19.00</p>
                                <p class="sold" >1k sold</p>
                            </div>
                        </div>
                        <div class="productPageContainer ">
                            <img class=""  src="./assets/product_img/11.png" />
                            <a class="variant">Building Materials</a> 
                            <div class="productPageDetails" >
                                <a class="heading ">Concrete Hollow Block</a>
                                <p class="price" >PHP 19.00</p>
                                <p class="sold" >1k sold</p>
                            </div>
                        </div>
                            <div class="productPageContainer ">
                                <img class=""  src="./assets/product_img/11.png" />
                                <a class="variant">Building Materials</a> 
                                <div class="productPageDetails" >
                                    <a class="heading font-poppins">Concrete Hollow Block</a>
                                    <p class="price" >PHP 19.00</p>
                                    <p class="sold" >1k sold</p>
                                </div>
                            </div>
                            <div class="productPageContainer ">
                                <img class=""  src="./assets/product_img/11.png" />
                                <a class="variant">Building Materials</a> 
                                <div class="productPageDetails" >
                                    <a class="heading ">Concrete Hollow Block</a>
                                    <p class="price" >PHP 19.00</p>
                                    <p class="sold" >1k sold</p>
                                </div>
                            </div>
                            <div class="productPageContainer ">
                                <img class=""  src="./assets/product_img/11.png" />
                                <a class="variant">Building Materials</a> 
                                <div class="productPageDetails" >
                                    <a class="heading ">Concrete Hollow Block</a>
                                    <p class="price" >PHP 19.00</p>
                                    <p class="sold" >1k sold</p>
                                </div>
                            </div>
                            <div class="productPageContainer ">
                                <img class=""  src="./assets/product_img/11.png" />
                                <a class="variant">Building Materials</a> 
                                <div class="productPageDetails" >
                                    <a class="heading ">Concrete Hollow Block</a>
                                    <p class="price" >PHP 19.00</p>
                                    <p class="sold" >1k sold</p>
                                </div>
                            </div>

                            <div class="productPageContainer ">
                                <img class=""  src="./assets/product_img/11.png" />
                                <a class="variant">Building Materials</a> 
                                <div class="productPageDetails" >
                                    <a class="heading ">Concrete Hollow Block</a>
                                    <p class="price" >PHP 19.00</p>
                                    <p class="sold" >1k sold</p>
                                </div>
                            </div>
                    </section>
        </div>
       
    </div> -->

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

    <div class="flex items-start justify-center gap-6 my-8">
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
   
        <div class="flex items-start gap-2">

        </div>
    </div>
   
    <?php
        include_once './includes/footer.php';
    ?>
    <script src="./utils/products.js"></script>
</body>
</html>