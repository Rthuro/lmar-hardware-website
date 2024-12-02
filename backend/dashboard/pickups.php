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
     .pickup{
        background-color: #ff8c00;
        color: white;
    }
</style>

<body>
    <?php include_once "../includes/sidebar.php" ?>
    <div class="main-content">
        <div class="flex justify-between items-end my-4">
                <p class="text-4xl">Manage Pickup Orders</p>
        </div>
    </div>
</body>
</html>