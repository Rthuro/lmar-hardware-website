<?php

include_once "../includes/header.php";

$id =  $_GET['id'];

if (!isset($_GET['id'])) {
    header("location: /backend/dashboard/inventory.php");
}

require_once '../classes/product.class.php';

$productObj = new Product();

$productObj->id = $id;
if ($productObj->delete()) {
   
    header("location: /backend/dashboard/inventory.php");
} else {
    header("location: /backend/dashboard/inventory.php");
}
?>

