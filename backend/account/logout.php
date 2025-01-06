<?php 
    session_start();
    session_destroy();
    header('location: /backend/account/login.php');
    exit();
?>