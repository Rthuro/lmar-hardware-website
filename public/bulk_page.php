<?php
    include_once 'header.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./tailwind.css">
    <link rel="shortcut icon" href="../assets/img/lmar_logo.png" type="image/x-icon">
    <title>Bulk Order | LMAR Hardware</title>
</head>
<body>
   
    <h1 class="text-center pt-[200px] pb-[50px] font-semibold text-4xl ">List your bulk orders here </h1>
    <form action="" method="post" class="max-w-[1100px] h-fit mx-auto flex flex-col items-center mb-[200px] max-[640px]:w-full">
        <div class="flex flex-col">
            <div class="flex justify-center gap-3 mb-3 max-[640px]:flex-col">
                <div class="flex flex-col">
                    <label for="bulkname">Name<span class="text-red-600">*</span></label>
                    <input type="text" name="bulkname" id="" class="w-[300px] px-2 py-2 border-[1px] border-gray-400 rounded ">
                </div>
                <div class="flex flex-col">
                    <label for="bulkcontact">Contact number<span class="text-red-600">*</span></label>
                    <input type="text" name="bulkcontact" id="" class="w-[300px] px-2 py-2 border-[1px] border-gray-400 rounded">
                </div>
            </div>
            <div class="flex flex-col mb-3">
                <label for="bulkorder">Products<span class="text-red-600">*</span></label>
                <textarea name="bulkorder" id="" rows="8" class="resize-y border-[1px] border-gray-400 rounded">
    
                </textarea>
            </div>
            <input type="submit" value="Submit Order" class="self-start orange-btn rounded py-2 px-4">
        </div>
    </form>

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
   <script src="/script/nav_functions.js"></script>
</body>
</html>