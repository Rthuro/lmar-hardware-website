<?php
    require_once "../backend/classes/account.class.php";
    require_once('../backend/tools/functions.php');
    session_start();       

    $accountObj = new Account();
    $email = $username = $confirmpass =  $password = '';
    $emailErr  =  $passwordErr = $confirmpassErr = $usernameErr = '';
    $role = 'customer';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])){
       $email = clean_input($_POST['email']);
       $username = clean_input($_POST['username']);
       $password =  clean_input($_POST['password']);
       $confirmpass =  clean_input($_POST['confirm_password']);
        if(empty($email)){
            $emailErr = "Please enter your email.";
        }
        if(empty($username)){
            $usernameErr = "Please create a username.";
        }

        if(empty($password)){
            $passwordErr = "Please enter your email.";
        }

        if(empty($confirmpass)){
           $confirmpassErr = "You need to confirm your password" ;
        } elseif ($confirmpass !== $password) {
            $confirmpassErr =  "Wrong password" ;
        }

        if(empty($emailErr) && empty($passwordErr) && empty($confirmpassErr)){
            $checkAccDuplicate  = $accountObj->fetch($email);
            if(empty($checkAccDuplicate)){
                $accountObj->email = $email;
                $accountObj->password = $password;
                $accountObj->role = $role;

                if($accountObj->add()){
                    echo "<p class='success'>Successfully created an account! Please login your email and password in the login page.</p>";
                } else {
                    echo "<p class='err'>Error occurred</p>";
                }
            } else {
                echo "<p class='err'>Account already exists. Please enter a different email.</p>";
            }
            
        } 
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up | LMAR Hardware</title>
    <link rel="stylesheet" href="./tailwind.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="./assets/img/lmar_logo.png" type="image/x-icon">
</head>
<style>
    .success{
        color:green;
        background-color: rgb(232, 255, 232);
        padding: 16px 12px;
        border-radius: 8px;
        text-align: center;
    }
    .err{
        color:red;
        background-color: rgb(255, 238, 238);
        padding: 16px 12px;
        border-radius: 8px;
        text-align: center;
    }
    .err_input{
        font-size: 14px;
        color:red;
        background-color: rgb(255, 238, 238);
        padding: 6px 12px;
        border-radius: 2px;
        text-align: center;
        width: 100%;
        margin:6px 0;
    }
</style>
<body>
    <div id="logoCont" class="flex items-center justify-center gap-1 self-center mt-[50px] font-semibold cursor-pointer ">
        <img  src="./assets/img/lmar_logo_black_nobg.png" alt="" class="h-12">
        <p class="font-outfit font-bold text-[32px] ">LMAR Hardware</p>
    </div>
    <p class="text-center font-outfit font-semibold text-[24px] mt-2">Sign up!</p>
    <div class="flex justify-center w-full mt-3 mb-3">
        <form action="" method="post" class="loginForm flex flex-col items-start w-fit gap-1">
           <label for="username">Username:</label>
            <input type="text" name="username" id="" value="<?= (isset($username))? $username:''; ?>" >
            <?php if(!empty($usernameErr)){ echo "<p class='err_input'>$usernameErr</p>"; }; ?>

            <label for="email">Email:</label>
            <input type="email" name="email" id="" value="<?= (isset($email))? $email:''; ?>" >
            <?php if(!empty($emailErr)){ echo "<p class='err_input'>$emailErr</p>"; }; ?>

            <label for="password">Password:</label>
            <input type="password" name="password" id="passInput" value="<?= (isset($password))? $password:''; ?>" >
                <div class="flex items-center justify-start gap-1">
                    <input type="checkbox" name="showPass" id="showPass" class="size-4">
                    <label for="showPass" >Show password</label>
                </div>
        
             
            <?php if(!empty($passwordErr)){ echo "<p class='err_input'>$passwordErr</p>"; }; ?>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="passConfirmInput" value="<?= (isset($confirmpass))? $confirmpass:''; ?>" >
                <div class="flex items-center justify-start gap-1">
                    <input type="checkbox" name="showConfirmPass" id="showConfirmPass" class="size-4">
                    <label for="showConfirmPass"  >Show password</label>
                </div>
            
            <?php if(!empty($confirmpassErr)){ echo "<p class='err_input'>$confirmpassErr</p>"; }; ?>
            <input type="submit" name="signup" value="Sign up">
        </form>
        
    </div>
    <div class="flex items-center justify-center w-full gap-1">
        <p>Already have an account? </p>
        <a href="login_page.php" class="text-[#C24E2E]">Log in</a>
    </div>
    <script>
        const logoCont  = document.getElementById('logoCont');
        logoCont.addEventListener('click', ()=>{
            window.location.href = "landing_page.php";
        })

        const passInput = document.getElementById("passInput");
        const passConfirmInput = document.getElementById("passConfirmInput");
        const showPass = document.getElementById("showPass");
        const showConfirmPass = document.getElementById("showConfirmPass");
        
        showPass.addEventListener("change", () => {
            passInput.type = showPass.checked ? "text" : "password";
        });

        showConfirmPass.addEventListener("change", () => {
            passConfirmInput.type = showConfirmPass.checked ? "text" : "password";
        });

    </script>
</body>
</html>