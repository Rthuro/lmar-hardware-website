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
    <link rel="stylesheet" href="../css/swiper-bundle.min.css?v=<?php echo time(); ?>">
    <title>LMAR Hardware</title>
</head>
<body>
  
    
    <form action="" method="get" class="hidden mt-[105px] items-center justify-center justify-self-center w-full py-3  max-[1030px]:flex ">
        <input type="text" name="" id="" placeholder="Search..." class=" w-[70%] px-[1.6rem] py-[0.5rem] text-[1rem] rounded-l bg-white ">
        <button type="submit" value="" class="px-[1.6rem] py-[0.6rem] bg-[#FB951C] rounded-r ml-[-2px] ">
            <img src="../assets/icons/magnifying-glass.png" alt="search icon by Taufik Glyph on flaticon" class="size-6 ">
        </button>
    </form>
    <!-- max-w-[1450px] bg-[#F05A28]/10 -->
    <section id="banner" class=" bg-[#F05A28] relative overflow-hidden w-full h-[100vh] mt-[90px] max-[500px]:h-[50vh]  max-[1030px]:h-[65vh]  max-[1030px]:mt-0">
        <img src="../assets/img/emetn.png" alt="" class="absolute bottom-0 right-0 object-fill w-[50%] max-[800px]:-bottom-16 max-[800px]:-right-12  z-0 max-[500px]:w-[80%] max-[1030px]:w-[50%]   ">  
        <!-- <div class="absolute w-full h-full top-0 right-0 bottom-0 overflow-hidden">
            sm:w-full sm:h-[70vh] sm:bg-[#F05A28]/50 clip-banner
            <div class="clip-banner absolute left-0 top-0 bottom-0 w-[75%] h-full z-10  max-[640px]:hidden min-[641px]:w-[90%] max-[1030px]:w-[90%]"></div>
            <img src="../assets/img/emetn.png" alt="" class="absolute bottom-0 right-0 object-cover size-[150px] z-0 max-[640px]:w-full    ">  
            <img src="../assets/img/banner.png" alt="" srcset="" class="w-full h-full object-cover">
        </div> -->
         
        <div class="absolute top-0 bottom-0 left-[5%]  flex flex-col justify-center  items-start overflow-hidden z-20 max-[500px]:items-center  max-[500px]:justify-start max-[500px]:top-12">
            <h1 class="text-[75px] text-white  font-poppins font-semibold max-w-[700px] max-[500px]:text-center max-[500px]:w-full max-[500px]:text-[38px] max-[1030px]:text-[48px] ">Welcome to <span class="text-[#FCDC2A] text-[80px] max-[500px]:text-[58px] max-[1030px]:text-[56px] ">LMAR</span> Hardware</h1>
                <div class="flex items-start flex-col gap-8 max-[500px]:items-center max-[500px]:gap-5 ">
                    <p class="font-outfit font-light text-[16px] text-start text-[#FBF0F4] max-w-[500px] drop-shadow-md  max-[500px]:w-[70%]  max-[500px]:text-center max-[500px]:text-[12px] max-[1030px]:text-[14px]   ">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.</p>
                    <div class="flex gap-2 items-center  ">
                        <button id="order_nowBtn" class="yellow-btn  font-poppins px-[1.6rem] py-[0.6rem] text-[1rem] max-[500px]:text-sm ">Order now</button>
                        <button id="view_prodBtn" class="flex items-center gap-2 white-btn  font-poppins px-[1.6rem] py-[0.6rem] text-[1rem] w-fit max-[500px]:text-sm ">View products
                        <img src="../assets/icons/next (2).png" alt="arrow icon by  Ilham Fitrotul Hayat on flatIcon " class="max-[500px]:size-4" >
                        </button>
                    </div>
                </div>
        </div>
       
    </section>

    <!-- w-[1450px] -->
    <main class=" flex flex-col items-center h-fit self-center w-full  mx-auto">
        
        <div class=" flex flex-row h-fit items-center justify-center w-full my-5 max-[640px]:flex-col max-[640px]:my-2">
                <div class="afterBannerDiv ">
                    <img src="../assets/icons/clock (1).png" id='icon' alt="dmitri13 Lineal on flaticon" class="iconImg">
                    <div class="flex flex-col mt-[-4px]">
                        <p class="text-[24px]  font-poppins max-[1030px]:text-[22px] "><strong>Open hours</strong></p>
                        <p class="text-sm ml-1 max-[1030px]:text-xs">Monday to Saturday <br> 8:00 am - 5:00 pm</p>
                    </div>
                </div>
            
                <div class="afterBannerDiv  ">
                    <img  src="../assets/icons/pin.png" id='icon' alt="" class="iconImg">
                    <div class="flex flex-col mt-[-4px]">
                        <p class="text-[24px]  font-poppins max-[1030px]:text-[22px]"><strong>Location</strong></p>
                        <p class="text-sm  ml-1 max-[1030px]:text-xs">Luyahan Housing, Villa Hermosa <br>Pasonanca, Zamboanga City</p>
                        <a href=" " class="flex items-center ml-1 ">
                            <button class=" getDirection">Get direction <img src="../assets/icons/next (3).png" alt="" class=""></button>
                    
                        </a>
                    </div>
                </div>
  
                <div class="afterBannerDiv ">
                    <img  src="../assets/icons/send.png" id='icon' alt="" class="iconImg">
                    <div class="flex flex-col mt-[-4px]">
                        <p class="text-[24px]  font-poppins max-[1030px]:text-[22px]"><strong>Contact us</strong></p>
                        <p class="text-sm ml-1 max-[1030px]:text-xs">Orders & Enquiries  </p>
                        
                        <p class="text-sm ml-1 underline max-[1030px]:text-xs">+612912344567</p>
                    </div>
                </div>
        </div>
        <section class="flex flex-col items-center justify-start justify-self-center px-10 py-6 h-fit  max-[1030px]:px-3 ">
            <p  class="text-center w-full text-[28px] font-medium max-[640px]:text-[24px] ">Shop by Categories</p>
            <div class="flex items-center justify-center flex-wrap w-fit h-fit my-8 gap-4 self-center max-[640px]:gap-1 ">
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
       
     <section class=" productCont flex flex-col items-start gap-6 px-10 py-12 h-fit  max-[640px]:px-3">
         <div class=" text-[28px] font-medium drop-shadow-sm  max-[640px]:text-[24px] " >Top products</div> 
         <div class="swiper mySwiper w-full h-fit overflow-hidden">
            <div class="swiper-wrapper">
                    <div class="prodDetails swiper-slide w-fit">
                        <div class="product ">
                            <a class="text variant">Building Materials</a>
                            <div class="Group1 " >
                                <img class="placeholderImage"  src="../assets/product_img/11.png" />
                                <div class="content " >
                                    <a class="heading  font-poppins">Concrete Hollow Block</a>
                                    <p class="price" >PHP 19.00</p>
                                    <p class="sold" >1k sold</p>
                                </div>
                            </div>
                        <button class=" orange-btn">Add to cart</button>
                        </div>  
                    </div> 
                    <div class="prodDetails swiper-slide w-fit">
                        <div class="product ">
                             <a class="text variant">Building Materials</a>
                            <div class="Group1 " >
                                <img class="placeholderImage"  src="../assets/product_img/12.png" />
                                <div class="content " >
                                <a class="heading  font-poppins">Deformed Bar</a>
                                <p class="price" >PHP 80.00 - 650.00</p>
                                <p class="sold" >1k sold</p>
                                </div>
                            </div>
                        <button class=" orange-btn">Add to cart</button>
                        </div>  
                    </div> 
                    <div class="prodDetails swiper-slide w-fit">
                        <div class="product ">
                            <a class="text variant">Wood Materials</a>
                            <div class="Group1 " >
                                <img class="placeholderImage"  src="../assets/product_img/13.png" />
                                <div class="content " >
                                <a class="heading  font-poppins">Plywood</a>
                                <p class="price" >PHP 417.00 - 1065.00</p>
                                <p class="sold" >1k sold</p>
                                </div>
                            </div>
                        <button class=" orange-btn">Add to cart</button>
                        </div>  
                    </div>
                    <div class="prodDetails swiper-slide w-fit">
                        <div class="product ">
                            <a class="text variant">Building Materials</a>
                            <div class="Group1 " >
                                <img class="placeholderImage"  src="../assets/product_img/14.png" />
                                <div class="content " >
                                    <a class="heading  font-poppins">Republic Cement</a>
                                    <p class="price" >PHP 245.00</p>
                                    <p class="sold" >1k sold</p>
                                </div>
                            </div>
                        <button class=" orange-btn">Add to cart</button>
                        </div>  
                    </div> 
                    <div class="prodDetails swiper-slide w-fit">
                        <div class="product ">
                            <a class="text variant">Building Materials</a>
                            <div class="Group1 " >
                                <img class="placeholderImage"  src="../assets/product_img/15.png" />
                                <div class="content " >
                                    <a class="heading  font-poppins">White Sand</a>
                                    <p class="price" >PHP 190.00 - 2,000.00</p>
                                    <p class="sold" >1k sold</p>
                                </div>
                            </div>
                        <button class=" orange-btn">Add to cart</button>
                    </div>  
                 </div> 
                    <div class="prodDetails swiper-slide w-fit">
                        <div class="product ">
                            <a class="text variant">Building Materials</a>
                            <div class="Group1 " >
                                <img class="placeholderImage"  src="../assets/product_img/14.png" />
                                <div class="content " >
                                    <a class="heading  font-poppins">Republic Cement</a>
                                    <p class="price" >PHP 245.00</p>
                                    <p class="sold" >1k sold</p>
                                </div>
                            </div>
                        <button class=" orange-btn">Add to cart</button>
                        </div>  
                    </div> 
                    <div class="prodDetails swiper-slide w-fit">
                        <div class="product ">
                            <a class="text variant">Building Materials</a>
                            <div class="Group1 " >
                                <img class="placeholderImage"  src="../assets/product_img/15.png" />
                                <div class="content " >
                                    <a class="heading  font-poppins">White Sand</a>
                                    <p class="price" >PHP 190.00 - 2,000.00</p>
                                    <p class="sold" >1k sold</p>
                                </div>
                            </div>
                        <button class=" orange-btn">Add to cart</button>
                    </div>  
                </div> 
            </div>
          </div>
         <button id="view_allBtn" class="button  text-[1rem] py-[8px] px-[28px] o-y-btn  shadow-sm rounded" >View all</button>
    </section>
    </main>

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
    <script src="../script/swiper-bundle.min.js"></script>
    <script src="../script/carousel.js"></script>
    <script src="../script/landing_page.js"></script>
</body>
</html>