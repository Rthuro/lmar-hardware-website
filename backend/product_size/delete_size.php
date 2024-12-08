
<?php

include_once "../includes/header.php";

$id =  '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

require_once '../classes/product_size.class.php';

$productSizeObj = new ProductSize();

$productSizeObj->size_id = $id;
if ($productSizeObj->deleteSize()) {
    $_SESSION['outputMsg']['success'] = 'Product deleted successfully';
    header("location: /backend/dashboard/inventory.php");
} else {
    $_SESSION['outputMsg']['error'] = 'Deleting product failed';
    header("location: /backend/dashboard/inventory.php");
}
?>

