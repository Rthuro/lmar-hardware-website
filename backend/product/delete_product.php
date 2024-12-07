<?php

include_once "../includes/header.php";

$id =  '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

require_once '../classes/product.class.php';

$productObj = new Product();

if ($productObj->delete($id)) {
    $_SESSION['outputMsg']['success'] = 'Product deleted successfully';
    header("location: /backend/dashboard/inventory.php");
} else {
    $_SESSION['outputMsg']['error'] = 'Deleting product failed';
    header("location: /backend/dashboard/inventory.php");
}
?>

