<?php

    require_once "../classes/product.class.php";
    require_once "../classes/orders.class.php";
    require_once "../tools/functions.php";


    include_once "../includes/header.php";

    $productObj = new Product();
    $orderObj = new Order();

    $search_term = isset($_GET['search']) ? clean_input($_GET['search']): '';
    $filter_category = isset($_GET['category']) ? clean_input($_GET['category']): '';

    $categories = $productObj->fetchCategory();
    $products = $productObj->showAll($search_term, $filter_category);
    $location = $orderObj->fetchLocation();

    
?>

<style>

.sidebar a.active {
    background-color: #e67e00; 
}

</style>

<body>

    <?php include_once "../includes/sidebar.php" ?>
    <div class="main-content">
  
        <div class="header">
                <h1 class="text-4xl">System Configurations</h1>
        </div>
        <div class="flex flex-col p-6 bg-[#1e1e1e] shadow-lg rounded-lg ">
        <p class="text-2xl my-2 text-[#ff8c00]">Product Settings</p>
            <div class="flex items-center border-b border-gray-500 py-3 justify-between">
                <form action="" class="flex items-center w-[450px] shadow-none m-0 p-0 bg-transparent gap-9">
                    <p class="text-nowrap">Product Categories</p>
                    <select name="category" class="search-input">
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['name'] ?>">
                        <?= $category['name'] ?>
                    </option>
                    <?php endforeach; ?>
                    </select>
                </form>
                <a href="../system/product_settings.php" class="flex items-center gap-2 text-green-600">Edit <i data-lucide="pencil-line" class=" size-5"></i></a>
            </div>
            <p class="text-2xl mb-2 mt-4 text-[#ff8c00]">Delivery Settings</p>
            <div class="flex items-center py-3 justify-between">
                <form action="" class="flex items-center w-[450px] shadow-none m-0 p-0 bg-transparent gap-9">
                    <p class="text-nowrap">Locations</p>
                    <select name="category" class="search-input">
                    <?php foreach ($location as $arr): ?>
                    <option value="<?= $arr['name'] ?>">
                        <?= $arr['name'] ?>
                    </option>
                    <?php endforeach; ?>
                    </select>
                </form>
                <a href="../system/delivery_settings.php" class="flex items-center gap-2 text-green-600">Edit <i data-lucide="pencil-line" class=" size-5"></i></a>
            </div>
        </div>
    </div>
    <?php include_once "../includes/footer.php" ?>
</body>
