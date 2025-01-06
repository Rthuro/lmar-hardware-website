<?php
  session_start();
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); 

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lmar_hardware";

   
    $conn = new mysqli($servername, $username, $password, $dbname);

  
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM users WHERE id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

  
    $stmt->bind_param("i", $user_id); 
  
    if ($stmt->execute()) {
        
        $_SESSION['outputMsg']['success'] = "Account deleted successfully.";
        header("Location: landing_page.php"); 
        session_destroy();
        exit;
    } else {
       
        $_SESSION['outputMsg']['error'] = "Error deleting account.";
        header("Location: landing_page.php"); 
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
   
    $_SESSION['outputMsg']['error'] = "No account ID provided.";
    header("Location: landing_page.php"); 
    exit;
}
?>
