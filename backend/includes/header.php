<?php
     session_start();

     if (!isset($_SESSION['admin_logged_in'])) {
         header("Location: ../account/login.php");
         exit();
     }   
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="/frontend/tailwind.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="/frontend/assets/img/lmar_logo.png" type="image/x-icon">
    <script src="../../node_modules/lucide/dist/umd/lucide.js"></script>
   

</head>