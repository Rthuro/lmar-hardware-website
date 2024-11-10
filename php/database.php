<?php
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=lmar_hardware", "root", ""); // Adjust the credentials as necessary
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Database connection failed: " . $e->getMessage();
        exit();
    }
?>