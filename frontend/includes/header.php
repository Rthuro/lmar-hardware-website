<?php
     require_once "../backend/classes/account.class.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./tailwind.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="./assets/img/lmar_logo.png" type="image/x-icon">
    <title>LMAR Hardware</title>
    <script src="../node_modules/lucide/dist/umd/lucide.js"></script>
    <style>
        .product:hover img {
            transform: scale(1.05);
            transition: transform 1s;
        }

        .product:hover div .prodName{
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header class="flex flex-col bg-white  xs:border-0">
        <nav class="flex items-center justify-between py-6  bg-white w-full px-6 border-b  ">
            <div class="relative lg:hidden xs:flex"> 
                <button id="burger_menuBttn" class="flex items-center ">
                    <i data-lucide="menu"></i>
                </button>
                  <div id="burger_menu" class=" fixed top-[88px] bottom-0 left-0 right-0 ">
                     <ul class="menu_items flex flex-col items-start justify-start py-3 px-4 bg-white w-full h-full">
                         <li><a href="landing_page.php">Home</a></li>
                         <li><a href="products.php">All Products</a></li>
                         <li class="relative cursor-pointer">
                            <p id="burger_category" class="flex items-center justify-between">Category 
                                <i data-lucide="chevron-down" class="size-4" id="iconDown"></i> 
                            </p>
                            <div id="burger_categoryList" class="hidden flex-col items-start justify-start mt-1 w-full">
                                <a href="">Hand Tools</a>
                                <a href="">Measuring Tools</a>
                                <a href="">Cutting Tools</a>
                                <a href="">Fastening Tools</a>
                                <a href="">Grinding Tools</a>
                                <a href="">Clamping Tools</a>
                                <a href="">Finishing Tools</a>
                                <a href="">Wood Materials</a>
                                <a href="">Building Materials</a>
                            </div>
                         </li>
                         <li class="flex items-center  gap-1 text-customOrange">
                         <?php
                            if (!isset($_SESSION['account'])) {
                            ?>
                                <a href="login_page.php" class="flex items-center gap-1">
                                    <i data-lucide="circle-user-round"></i> Login
                                </a>
                            <?php
                            } else {
                            ?>
                                <a href="account.php" class="flex items-center gap-1">
                                    <i data-lucide="circle-user-round"></i>
                                    <p class="font-semibold text-lg"><?= $username ?></p>
                                </a>
                            <?php
                            }
                            ?>
                        </li>
                     </ul>
                 </div>
             </div>
                <div  id="logo" class="flex items-center cursor-pointer basis-1/4 xs:basis-0">
                        <img src="./assets/img/lmar_logo_black_nobg.png" alt="" class=" object-contain sm:size-14 xs:size-12">
                        <p class="text-2xl font-bold -ml-2 text-[#1d1d1d]  ">LMARHardware</p>
                </div>
                    <form action="" method="get" class="flex items-center justify-end  basis-1/2   max-[1000px]:hidden ">
                        <input type="text" name="" id="" placeholder="Search..." class=" w-[500px] px-6 py-2 text-md rounded-l bg-white border focus:outline-gray-200 focus:bg-slate-50   ">
                        <button type="submit" value="" class="px-6 py-2 bg-gray-950 rounded-r -ml-1 ">
                            <i data-lucide="search" class="size-6 text-white"></i>
                        </button>
                    </form>
 
                       <div class="flex items-center justify-end gap-3 basis-1/4" >
                            <a href="cart.php" id="cart" class="relative flex items-end gap-2 cursor-pointer">
                                <i data-lucide="shopping-cart" class=" size-8 text-customOrange"></i>
                                <div id="cart_items_count" class="absolute -top-1 right-0 bg-black/80 px-1 rounded-full">
                                    <p class="text-white text-xs" >0</p>
                                </div>
                            </a>
                            <?php
                         if(!isset($_SESSION['account'])){
                         ?> <button id="loginBtn" class=" rounded bg-gray-950 text-white  px-4 py-1 text-lg lg:flex xs:hidden">Log in</button>  <?php
                        } else {
                          ?> <a href="/frontend/account.php" class="lg:flex xs:hidden items-center gap-1">
                                    <i data-lucide="circle-user-round"></i>
                                    <p  class="font-semibold text-lg"><?= $username ?></p>
                              </a> 
                            <?php
                        }
                         ?>
                     </div>
                        
                       
                </div>
        </nav>
        <nav class="bg-white px-52 py-5 flex items-center justify-center gap-5 border-b lg:flex xs:hidden">
            <a href="/frontend/landing_page.php" id="homeTextClr" class="">Home</a>
            <a href="/frontend/products.php" id="allProdTextClr" class="">All Products</a>
            <div id="categoryDropdown"  class="relative flex items-center gap-2 cursor-pointer">
                Category
                <i data-lucide="chevron-down" id="iconDown" class=" size-4"></i>
                <div id="categoryDropdownContainer" class=" hidden absolute bottom-[-350px] right-0 pt-2 bg-white w-[200px] h-fit flex-col justify-start items-start rounded-b-md shadow-md">
                    <a href="">Hand Tools</a>
                    <a href="">Measuring Tools</a>
                    <a href="">Cutting Tools</a>
                    <a href="">Fastening Tools</a>
                    <a href="">Grinding Tools</a>
                    <a href="">Clamping Tools</a>
                    <a href="">Finishing Tools</a>
                    <a href="">Wood Materials</a>
                    <a href="">Building Materials</a>
                </div>
            </div>
           
        </nav>
    </header>
    <script src="./utils/nav_functions.js"></script>
    <script>
        const homeTextClr = document.getElementById('homeTextClr');
        const allProdTextClr = document.getElementById('allProdTextClr');
        const bulkOrderTextClr = document.getElementById('bulkOrderTextClr');


        if(window.location.href.indexOf("landing_page.php")> -1){
             homeTextClr.style.color = "#FB951C";
        } else if(window.location.href.indexOf("products.php")> -1){
            allProdTextClr.style.color = "#FB951C";
        } else if (window.location.href.indexOf("bulk_page.php")> -1){
            bulkOrderTextClr.style.color = "#FB951C";
        }

    </script>