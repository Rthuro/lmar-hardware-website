<?php
    include_once 'header.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./tailwind.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="../assets/img/lmar_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
      <link rel="stylesheet" href="./tailwind.css">
    <title>LMAR Hardware</title>
    <style>
        .drag-none{
            -webkit-user-drag: none;
            -khtml-user-drag: none;
            -moz-user-drag: none;
            -o-user-drag: none;
            user-drag: none;
        }
        
    </style>
</head>
<body>
  
    
    <form action="" method="get" class="hidden mt-[105px] items-center justify-center justify-self-center w-full py-3  max-[1030px]:flex ">
        <input type="text" name="" id="" placeholder="Search..." class=" w-[70%] px-[1.6rem] py-[0.5rem] text-[1rem] rounded-l smShadow bg-white focus:outline-none focus:bg-slate-50 focus:shadow-none focus:border focus:border-[#d3d3d3] ">
        <button type="submit" value="" class="px-[1.6rem] py-[0.6rem] bg-[#FB951C] rounded-r ml-[-2px] ">
            <img src="../assets/icons/magnifying-glass.png" alt="search icon by Taufik Glyph on flaticon" class="size-6 ">
        </button>
    </form>

    <section id="banner" class="flex 2xl:w-full lg:h-screen min-[375px]:w-fit lg:mt-[100px] min-[375px]:mt-6  ">
        <div class=" flex items-center lg:flex-nowrap md:flex-wrap justify-center w-full h-full mx-12 lg:flex-row  min-[375px]:flex-col    ">
            <div class="flex flex-1 flex-col  gap-2 max-w-[950px] lg:items-start  min-[375px]:items-center ">
                <p class="lg:text-start  min-[375px]:text-center text-wrap font-bold sm:text-8xl  min-[375px]:text-6xl text-[#1d1d1d] ">Welcome to <span class="text-[#FB951C]">LMAR</span> Hardware</p>
                <p class="md:text-lg  min-[375px]:text-sm lg:text-start  min-[375px]:text-center text-wrap text-[#1d1d1d]">Browse and shop easily to your next door hardware.</p>
                <div class="flex items-center gap-2 my-4">
                    <button id="order_nowBtn" class=" text-white bg-[#fb951c] rounded py-2 px-4">Order now</button>
                    <button id="view_prodBtn" class="text-white bg-[#1d1d1d] rounded py-2 px-4 gap-2 flex items-center">View products
                        <img src="../assets/icons/nucleo_icons/arrow-right.svg" alt="" >
                    </button>
                </div>
            </div>
            <img src="../assets/img/emetn.png" class="object-contain  lg:size-[500px] min-[375px]:size-[450px] object-center">  
        </div>
    </section>

    <section class="flex items-start justify-center gap-8 mx-auto w-full h-fit my-8 flex-wrap">
        <div class="flex flex-col h-full  w-[300px] gap-2  px-6 py-4 bg-[#fb951c] rounded-md bxShadow">
            <div class="flex items-center gap-1 border-b-2 border-[#1d1d1d]/70 pb-2 ">
                        <img src="../assets/icons/nucleo_icons/time-clock-2.svg" id='icon' alt="dmitri13 Lineal on flaticon" class="">
                        <p class="text-2xl  font-semibold ">Open hours</p>
            </div>
            <div class="flex flex-col items-start">
                <p class="text-md font-medium"> Monday to Saturday</p>
                <p class="text-md font-medium">8:00 am - 5:00 pm</p>
            </div>
        </div>
        <div class="flex flex-col w-[300px] gap-2  px-6 py-4 bg-[#fb951c] rounded-md bxShadow">
            <div class="flex items-center gap-1 border-b-2 border-[#1d1d1d] pb-2  ">
                        <img  src="../assets/icons/nucleo_icons/position-marker-2.svg" id='icon' alt="dmitri13 Lineal on flaticon" class="size-5">
                        <p class="text-2xl gap-2 font-semibold ">Location</p>
            </div>
            <div class="flex flex-col items-start">
                <p class="text-md font-medium text-wrap">Luyahan Housing, Villa Hermosa
                    Pasonanca, Zamboanga City</p>
                <a class="text-md font-medium underline">Get direction</a>
            </div>
        </div>
        <div class="flex flex-col h-full  w-[300px] gap-2 px-6 py-4 bg-[#fb951c] rounded-md bxShadow">
            <div class="flex items-center gap-1 border-b-2 border-[#1d1d1d] pb-2 ">
                        <img  src="../assets/icons/nucleo_icons/send-message-2.svg" id='icon' alt="dmitri13 Lineal on flaticon" class="size-5">
                        <p class="text-2xl  font-semibold  ">Contact us</p>
            </div>
            <div class="flex flex-col items-start">
                <p class="text-md font-medium">Orders & Enquiries</p>
                <p class="text-md font-medium underline">+612912344567</p>
            </div>
        </div>
       
    </section>
        <section class="flex flex-col items-center justify-start justify-self-center px-10 py-6 h-fit mx-[10vw] w-[80vw]  max-[1030px]:px-3 ">
            <p  class="text-center w-full text-3xl font-bold ">Shop by Categories</p>
            <div id="categoryContainer" class="flex items-center justify-start flex-wrap h-fit w-full my-8 gap-1 mx-auto max-[640px]:gap-1 ">
                <a href=""class="categoryCont "><img src="../assets/category img/10.png" alt="" class="categoryImg"><p class="absolute top-0 bottom-0 right-0 left-0">All Products</p></a>
                <a href=""class=" categoryCont "><img src="../assets/category img/1.png" alt="" class="categoryImg "><p class="absolute top-0 bottom-0 right-0 left-0">Hand Tools</p></a>
                <a href=""class="categoryCont "><img src="../assets/category img/2.png" alt="" class="categoryImg"><p class="absolute top-0 bottom-0 right-0 left-0">Measuring Tools</p></a>
                <a href=""class="categoryCont "><img src="../assets/category img/3.png" alt="" class="categoryImg"><p class="absolute top-0 bottom-0 right-0 left-0">Cutting Tools</p></a>
                <a href=""class="categoryCont"><img src="../assets/category img/4.png" alt="" class="categoryImg"><p class="absolute top-0 bottom-0 right-0 left-0">Fastening Tools</p></a>
                <a href=""class="categoryCont "><img src="../assets/category img/5.png" alt="" class="categoryImg"><p class="absolute top-0 bottom-0 right-0 left-0">Grinding Tools</p></a>
                <a href=""class="categoryCont "><img src="../assets/category img/6.png" alt="" class="categoryImg"><p class="absolute top-0 bottom-0 right-0 left-0">Clamping  Tools</p></a>
                <a href=""class="categoryCont "><img src="../assets/category img/7.png" alt="" class="categoryImg"><p class="absolute top-0 bottom-0 right-0 left-0">Finishing  Tools</p></a>
                <a href=""class="categoryCont "><img src="../assets/category img/8.png" alt="" class="categoryImg"><p class="absolute top-0 bottom-0 right-0 left-0">Wood Materials</p></a>
                <a href=""class="categoryCont "><img src="../assets/category img/9.png" alt="" class="categoryImg"><p class="absolute top-0 bottom-0 right-0 left-0">Building Materials</p></a>
            </div>
       </section>

       <p class="text-3xl text-center w-full font-semibold my-6">Top products</p>
    <section  id="scrollArea" class="flex flex-col items-start gap-1 mx-[10vw] w-[80vw] overflow-x-scroll  overflow-hidden  ">
        <div   class="w-screen flex justify-start cursor-default select-none gap-2 py-2 px-2  ">
            <div class="product smShadow border-[1px] border-[#d3d3d3] flex flex-col gap-2  w-[200px] hover:bxShadow cursor-pointer">
                <a class="text variant">Building Materials</a>
                <div class="flex flex-col px-2 " >
                    <img class="drag-none "  src="../assets/product_img/11.png" />
                    <div class="flex flex-col items-start " >
                        <a class="heading  font-poppins">Concrete Hollow Block</a>
                        <p class="price" >PHP 19.00</p>
                        <p class="sold" >1k sold</p>
                    </div>
                </div>
            <button class=" orange-btn">Add to cart</button>
          </div> 
        </div>
    </section>
    <div class="flex justify-end mx-[10vw] my-3">
        <button id="view_allBtn" class="text-white bg-[#1d1d1d] rounded py-2 px-4 gap-2 flex items-center">View all</button>
    </div>

    <footer class=" flex flex-col  justify-center items-center self-center w-full  max-w-[1450px] h-fit mb-10 mx-auto px-6 ">
        <div class="flex flex-col justify-center gap-[16px] border-b-2 border-black w-full h-[300px] px-2">
            <div class="flex items-center">
                 <img src="../assets/img/lmar_logo_black_nobg.png" alt="" class="ml-[-12px] w-[64px] object-contain">
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
    <script src="../script/carousel.js"></script>
    <script src="../script/landing_page.js"></script>
   
      
</body>
</html>

