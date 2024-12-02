<?php 
    session_start();
    session_destroy();
    header('location: /backend/index.php');
    exit();
?>