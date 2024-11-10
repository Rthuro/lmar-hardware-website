<?php
// Start session
session_start();

// Check if user is logged in, redirect to dashboard if true
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit();
}

// Sample login validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['email'];
    $password = $_POST['password'];

    // For demo purposes, hardcoding credentials
    if ($username == 'admin' && $password == 'password123') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
    } else {
        $error = "Invalid Email or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
    body {
        margin: 0;
        font-family: 'Arial', sans-serif;
        background-color: black;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        width: 100%;
    }

    .login-box {
        background-color: white;
        padding: 40px 30px;
        border-radius: 10px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
        max-width: 400px;
        width: 100%;
        text-align: center;
    }

    .login-box h2 {
        margin-bottom: 20px;
        font-size: 28px;
        color: rgb(228, 63, 17);
        /* Shade of orange */
    }

    .input-group {
        margin-bottom: 15px;
    }

    .input-group input {
        width: 92%;
        padding: 15px;
        border: none;
        background-color: #f4f4f4;
        font-size: 16px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .input-group input:focus {
        outline: none;
        background-color: #ffefdf;
        /* Light shade of orange on focus */
    }

    .btn-login {
        width: 100%;
        padding: 15px;
        background-color: #ff6600;
        /* Orange */
        color: white;
        border: none;
        font-size: 18px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-login:hover {
        background-color: #e65c00;
        /* Darker orange on hover */
    }

    .error {
        color: red;
        font-size: 14px;
        margin-top: 10px;
    }

    /* Responsive Design */
    @media (max-width: 600px) {
        .login-box {
            padding: 30px 20px;
            max-width: 90%;
        }
    }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h2>LMAR Hardware</h2>
            <h3>Admin Login</h3>
            <form method="post" action="index.php">
                <div class="input-group">
                    <input type="text" name="email" placeholder="email" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn-login">Login</button>
                <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            </form>
        </div>
    </div>
</body>

</html>