<header class="flex flex-col  fixed z-50 top-0 left-0 right-0  bg-[#FBF0F4] shadow-lg ">
        <nav class="flex items-center justify-between px-[5%] py-6 bg-[#F05A28] w-full max-[640px]:px-[2%] ">
            <div class="relative min-[1030px]:hidden"> 
                <button id="burger_menuBttn" class="flex items-center "><img src="../assets/icons/menu-white.svg" alt=""></button>
                  <div id="burger_menu" class="hidden fixed top-[88px] bottom-0 left-0 right-0 ">
                     <ul class="menu_items flex flex-col items-start justify-start py-3 px-4 bg-white w-full h-full">
                         <li><a href="landing_page.php">Home</a></li>
                         <li><a href="products.php">All Products</a></li>
                         <li><a href="bulk_page.php">Bulk Order</a></li>
                         <li class="relative cursor-pointer">
                            <p id="burger_category" class="flex items-center justify-between">Category <img id="iconDown" src="../assets/icons/down.png" alt="down icon by ilham on flaticon" class=" size-4">
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
                         <li class="flex items-center  gap-1"><img src="../assets/icons/circle-user-round (1).svg" alt=""><a href="login_page.html" class="text-[#F05A28]">Login</a> </li>
                     </ul>
                 </div>
             </div>
            <div  id="logo" class="flex items-center cursor-pointer basis-1/5 max-[1030px]:basis-0">
                        <img src="../assets/img/lmar_logo3.png" alt="" class=" w-[58px] object-contain drop-shadow-sm max-[640px]:w-[48px]">
                     <p class="text-[22px] font-bold ml-[-7px] text-[#FCDC2A] drop-shadow-sm max-[640px]:text-[18px ">LMARHardware</p>
                </div>
                    <form action="" method="get" class="flex items-center justify-end justify-self-center basis-1/2 w-full  max-[1030px]:hidden ">
                        <input type="text" name="" id="" placeholder="Search..." class=" w-[70%] px-[1.6rem] py-[0.5rem] text-[1rem] rounded-l  ">
                        <button type="submit" value="" class="px-[1.6rem] py-[0.6rem] bg-[#FB951C] rounded-r ml-[-2px] ">
                            <img src="../assets/icons/magnifying-glass.png" alt="search icon by Taufik Glyph on flaticon" class="size-6 ">
                        </button>
                    </form>
                <!-- <a href="products.php" class=" font-poppins text-[14px] font-medium  ">Products</a> -->
                  
                      <div class="flex items-center justify-end gap-6 basis-1/4">
                            <div id="cart" class="relative flex items-end gap-2 cursor-pointer">
                                <p class="text-xl font-semibold text-[#FCDC2A] max-[1030px]:hidden">Cart</p>
                                <img src="../assets/icons/tool-box (1).png" alt="" class="size-9 mr-2 max-[640px]:size-8">
                                <div id="cart_items_count" class="absolute top-[-5px] right-0 bg-black/80 px-2 py-1 rounded-[50%]">
                                    <p class="text-white text-[10px]" >0</p>
                                </div>
                                <div id="cartContainer" class="fixed hidden flex-col  justify-center items-center top-[80px] right-[10%] min-w-[250px] max-w-[400px] h-[200px] bg-white rounded-lg py-4 px-3">
                                    <p>Empty cart... </p> 
                                    <!-- <div id="productCart" class="flex border-b-2 w-full h-fit  my-4 items-start justify-between">
                                        <img src="../assets/img/huhuh 1.png" alt="" class="size-11">
                                        <p>wswe</p>
                                        <p>210</p>
                                    </div> -->
                                    <button id="addToCart" class="fill-btn py-2 px-3 my-1 ">Shop Now</button>
                                </div>
                            </div>
                     
                        <button id="loginBtn" class="flex gap-2 white-btn font-poppins px-4 py-2 text-[1rem] font-medium  max-[1030px]:hidden"> <img src="../assets/icons/circle-user-round (1).svg" alt=""> Log in</button>
                </div>
        </nav>
        <nav class="bg-white px-52 py-5 flex items-center justify-center gap-5 max-[1030px]:hidden">
            <a href="landing_page.php" id="homeTextClr" class="">Home</a>
            <a href="products.php" id="allProdTextClr" class="">All Products</a>
            <a href="bulk_page.php" id="bulkOrderTextClr" class="flex items-center gap-2">
                Bulk Order
             </a>
            <div id="categoryDropdown"  class="relative flex items-center gap-2 cursor-pointer">
                Category
                 <img id="iconDown" src="../assets/icons/down.png" alt="down icon by ilham on flaticon" class=" size-3">

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
    <script src="../script/nav_functions.js"></script>
    <script>
        const homeTextClr = document.getElementById('homeTextClr');
        const allProdTextClr = document.getElementById('allProdTextClr');
        const bulkOrderTextClr = document.getElementById('bulkOrderTextClr');


        if(window.location.href.indexOf("landing_page.php")> -1){
             homeTextClr.style.color = "#C24E2E";
        } else if(window.location.href.indexOf("products.php")> -1){
            allProdTextClr.style.color = "#C24E2E";
        } else if (window.location.href.indexOf("bulk_page.php")> -1){
            bulkOrderTextClr.style.color = "#C24E2E";
        }

    </script>