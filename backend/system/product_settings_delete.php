<?php 
    require_once "../classes/product.class.php";
    include_once "../includes/header.php";

    $productObj = new Product();

    $id = $_GET['id'];
    if(!empty($id)){
        if($productObj->deleteCategory($id)){
            header('location: product_settings.php');
        }
    } else {
        header('location: product_settings.php');
    }
?>