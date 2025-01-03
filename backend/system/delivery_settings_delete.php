<?php 
    require_once "../classes/orders.class.php";
    include_once "../includes/header.php";

    $orderObj = new Order();

    $id = $_GET['id'];
    if(!empty($id)){
        if($orderObj->deleteLocation($id)){
            header('location: delivery_settings.php');
        }
    } else {
        header('location: delivery_settings.php');
    }
?>