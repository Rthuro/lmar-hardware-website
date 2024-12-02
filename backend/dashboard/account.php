<?php

    require_once "../classes/product.class.php";

    session_start();

    if (!isset($_SESSION['admin_logged_in'])) {
        header("Location: index.php");
        exit();
    }    

    include_once "../includes/header.php";
    
?>

<style>
     .account{
        background-color: #ff8c00;
        color: white;
    }
</style>

<body>
    <?php include_once "../includes/sidebar.php" ?>
    <div class="main-content">
        <div class="flex justify-between items-end my-4">
                <p class="text-4xl">Account</p>
        </div>
    </div>
</body>
</html>