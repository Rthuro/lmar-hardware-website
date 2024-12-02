
<?php

    require_once "../classes/product.class.php";

    session_start();

    if (!isset($_SESSION['admin_logged_in'])) {
        header("Location: index.php");
        exit();
    }    

    include_once "../includes/header.php";

    $productObj = new Product();

?>
<style>
    #orders{
        background-color: #ff8c00;
    }
    .orders{
        background-color: #ff8c00;
        color: white;
    }
</style>

<body>

    <?php include_once "../includes/sidebar.php" ?>

    <div class="main-content">
        <div class="header">
            <h1>Manage Orders</h1>
        </div>
        <div>
            
        </div>
    </div>

</body>
</html>