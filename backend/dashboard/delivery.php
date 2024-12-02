<?php

    require_once "../classes/product.class.php";

    session_start();

    if (!isset($_SESSION['admin_logged_in'])) {
        header("Location: index.php");
        exit();
    }    

    include_once "../includes/header.php";

    $productObj = new Product();

    $search_term = isset($_GET['search']) ? clean_input($_GET['search']): '';
    $filter_category = isset($_GET['category']) ? clean_input($_GET['category']): '';

    $categories = $productObj->fetchCategory();
    $products = $productObj->showAll($search_term, $filter_category);$recent_orders = $productObj->fetchRecentOrders();

?>

<style>
   #deliveries{
        background-color: #ff8c00;
    }
    #delivery-form{
        margin:none;
    }
    .main-container{
        display: flex;
        justify-content: start;
        align-items: start;
        flex-direction: column;
        margin-left: 300px;
        padding-top: 50px;
    }
    .maincontent{
        height: fit-content;
    }

    .delivery{
        background-color: #ff8c00;
        color: white;
    }

</style>

<body>

    <?php include_once "../includes/sidebar.php" ?>

    <div class="main-container">
        <form id="delivery-form" method="GET" action="" class="">
            <input type="text" name="search" class="search-input" placeholder="Search by Customer Name"
                value="<?= htmlspecialchars($search_term) ?>">
            <select name="customer_name" class="search-input">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['name']) ?>"
                    <?= $filter_category == $category['name'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn bg-[#ff8c00] py-2 px-6 rounded-md">Search</button>
        </form>
        
    </div>

</body>
</html>