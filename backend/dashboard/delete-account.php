<?php
// Include necessary files (header, database connection)
require_once "../includes/header.php";

// Check if the 'id' parameter is passed via the URL
if (isset($_GET['id'])) {
    // Sanitize the 'id' to prevent SQL injection
    $user_id = intval($_GET['id']); // Cast to integer to ensure it's a valid number

    // Create database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lmar_hardware";

    // Create the connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the DELETE SQL query
    $sql = "DELETE FROM users WHERE id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the user ID parameter to the prepared statement
    $stmt->bind_param("i", $user_id); // "i" means the parameter is an integer

    // Execute the query
    if ($stmt->execute()) {
        // On success, redirect to the dashboard with a success message
        $_SESSION['outputMsg']['success'] = "Account deleted successfully.";
        header("Location: dashboard.php"); // Redirect to the dashboard or accounts page
        exit;
    } else {
        // If something goes wrong, redirect with an error message
        $_SESSION['outputMsg']['error'] = "Error deleting account.";
        header("Location: dashboard.php"); // Redirect back to the dashboard or accounts page
        exit;
    }

    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();
} else {
    // If no 'id' parameter is provided, redirect with an error message
    $_SESSION['outputMsg']['error'] = "No account ID provided.";
    header("Location: dashboard.php"); // Redirect back to the dashboard
    exit;
}
?>
