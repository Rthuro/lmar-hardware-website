<?php
    require_once "../backend/classes/account.class.php";
    require_once "../backend/tools/functions.php";
    session_start();

    $accountObj = new Account();


     $email = $password = '';
     $errAcc=$emailErr = $passwordErr = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
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

            if(empty($checkIfUserExists)){
                echo "<p class='err'>Account doesn't exists! Sign up to create an account.</p>";
            } else {
                if($accountObj->login($email,$password)){
                    $_SESSION['account'] = $checkIfUserExists;
                    header("Location: landing_page.php");
                } else {
                    echo "<p class='err'>The password you entered is incorrect. Please try again.</p>";
                }
            }
        }
    } else {
        if(isset($_SESSION['account'])){
            if($_SESSION['account']['role'] == 'customer'){
                header("Location: landing_page.php");
            } else {
                header("Location: ../backend/dashboard.php");
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in | LMAR Hardware</title>
    <link rel="stylesheet" href="./tailwind.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="./assets/img/lmar_logo.png" type="image/x-icon">
</head>
<style>
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
        <img src="./assets/img/lmar_logo_black_nobg.png" alt="" class="h-12">
        <p class="font-outfit font-bold text-[32px] ">LMAR Hardware</p>
    </div>
    <p class="text-center font-outfit font-semibold text-[24px] mt-2">Welcome back!</p>
    <div class="flex justify-center w-full mt-3 mb-3">
        <form action="" method="post" class="loginForm flex flex-col items-start w-fit">
            <label for="email">Email:</label>
            <input type="text" name="email" id="" value="<?= (isset($email))? $email:''; ?>">
            <?php if(!empty($emailErr)){ echo "<p class='err_input'>$emailErr</p>"; } ?>
            <label for="password">Password:</label>
                <input type="password" name="password" id="passInput" value="<?= (isset($password))? $password:'' ?>" >
                <div class="flex items-center justify-start gap-1">
                    <input type="checkbox" name="showPass" id="showPass" class="size-4">
                    <label for="showPass"  >Show password</label>
                </div>

            <?php if(!empty($passwordErr)){ echo "<p class='err_input'>$passwordErr</p>"; } ?>
            <input type="submit" name='login' value="Login" >
        </form>
        
    </div>
    <div class="flex items-center justify-center w-full gap-1">
        <p>Don't have an account? </p>
        <a href="signin_page.php" class="text-[#C24E2E]">Sign up</a>
    </div>
    
    <script>
        const logoCont  = document.getElementById('logoCont');
        logoCont.addEventListener('click', ()=>{
            window.location.href = "landing_page.php";
        })

        const passInput = document.getElementById("passInput");
        const showPass = document.getElementById("showPass");

        showPass.addEventListener("change", () => {
            passInput.type = showPass.checked ? "text" : "password";
        });

        

    </script>
</body>
</html>