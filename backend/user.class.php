<?php
require_once "database.php";

try {
    $pdo = new PDO("mysql:host=localhost;dbname=lmar_hardware", "root", ""); // Adjust the credentials as necessary
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit();
}

function validation($input){
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    return $input;
}

class User{
    public $email = '';
    public $password = '';
    public $role = 'customer';
    
    function addUsers(){
        
        $sql = "INSERT INTO users (email,password,role) VALUES (:email,:password,:role); ";
        $query = $pdo-> prepare ($sql);
      }
}

?>