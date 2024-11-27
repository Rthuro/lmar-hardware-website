<?php
    include_once 'header.php';
    require_once "../backend/database.php";

    try {
        $stmt = $pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching orders: " . $e->getMessage();
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Products | LMAR Hardware</title>
    <link rel="stylesheet" href="./tailwind.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="./assets/img/lmar_logo.png" type="image/x-icon">
</head>
<body>
    
    <div class="hidden gap-1 items-center justify-center justify-self-center w-full mt-[110px]  max-[1030px]:flex min-[1030px]:mt-[180px] min-[1030px]:justify-start min-[1030px]:pl-[22%] ">
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
       
    </div>

    <footer class=" flex flex-col  justify-center items-center self-center w-full  max-w-[1450px] h-fit mb-10 mx-auto px-6 ">
        <div class="flex flex-col justify-center gap-[16px] border-b-2 border-black w-full h-[300px] px-2">
            <div class="flex items-center">
                 <img src="./assets/img/lmar_logo_black_nobg.png" alt="" class="ml-[-12px] w-[64px] object-contain">
                 <p class="text-[18px]  font-poppins font-bold leading-4 ml-[-9px]">LMAR <br> Hardware</p>
            </div>
           
            <div class="flex flex-col items-start ">
                <p><strong>Address:</strong></p>
                <p>Luyahan Housing, Pasonanca Zamboanga City</p>
            </div>
            <div class="flex flex-col items-start">
                <p><strong>Contact:</strong></p>
                <p>+612912344567</p>
            </div>
        </div>
        <div class="flex flex-row justify-between w-full py-[16px] px-2 max-[640px]:flex-col">
            <p>2023 LMAR Hardware. All rights reserved.</p>
            <div >
                <a href="" class="underline mx-[4px]">Privacy Policy</a>
                <a href="" class="underline mx-[4px]">Terms of Service</a>
                <a href="" class="underline mx-[4px]">Cookies Settings</a>
            </div>
        </div>
    </footer>
    <script src="./utils/products.js"></script>
</body>
</html>