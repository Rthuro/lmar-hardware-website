<?php

    require_once "../classes/account.class.php";
    require_once "../tools/functions.php";

    session_start();

    $accountObj = new Account();

    if (isset($_SESSION['admin_logged_in'])) {
        header("Location: dashboard.php");
        exit();
    } else {
        $email = $password = '';
        $errAcc=$emailErr = $passwordErr = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['adminLogin'])) {
            $email = clean_input($_POST['email']);
            $password = clean_input($_POST['password']);

            if(empty($email)){
                $emailErr = 'Please enter your email';
            }
            if(empty($password)){
                $passwordErr = 'Please enter your password';
            }

            if(empty($emailErr) && empty($passwordErr)){

                $checkIfUserExists = $accountObj->fetch($email);
                if(!empty($checkIfUserExists) && $checkIfUserExists['role'] === "admin") {
                    $_SESSION['admin_logged_in'] = $checkIfUserExists;
                    header("Location: /backend/dashboard/dashboard.php");
                } else {
                    echo "<p class='err'>Account doesn't exists</p>";
                }
            }
        }
    }
    
    include_once "../includes/header.php";
?>

<body class=" bg-[#1d1d1d]">
    <div class="flex items-center justify-center h-screen ">
        <div class="bg-white rounded-lg px-6 py-7 w-[400px] flex flex-col gap-3 items-center">
            <p class="text-3xl font-semibold text-[#ff6600]">LMAR Hardware</p>
            <p class=" text-md font-medium">Admin Login</p>
            <form method="post" action="" class="w-full flex flex-col items-center gap-3">
                    <input type="text" name="email" placeholder="email" value="<?= (isset($email))? $email:''; ?>" class=" w-full rounded-sm p-4 bg-[#f4f4f4] focus:outline-none focus:bg-[#ffefdf]" required>
                    <input type="password" name="password" placeholder="password" value="<?= (isset($password))? $password:''; ?>" class=" w-full rounded-sm p-4 bg-[#f4f4f4] focus:outline-none focus:bg-[#ffefdf]" required>
    
                <input type="submit" name="adminLogin" value="Login" class="w-full text-white py-3 bg-[#ff6600] hover:bg-[#e65c00] rounded-md" >
            </form>
        </div>
    </div>
</body>

</html>