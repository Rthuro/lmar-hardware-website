<?php

session_start();

$host = 'localhost';
$dbname = 'lmar_hardware';
$user = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function clean_input($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

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
        $checkIfUserExists = $pdo->query("SELECT * FROM users WHERE email='$email' AND password = '$password';");
        $accExists = $checkIfUserExists ->fetchAll(PDO::FETCH_ASSOC);
        if(empty($accExists)){
            echo "<p class='err'>Account doesn't exists! Sign up to create an account.</p>";
        } else {
            header("Location: landing_page.php");
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
    <link rel="shortcut icon" href="../assets/img/lmar_logo.png" type="image/x-icon">
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
        <img src="../assets/img/lmar_logo_black_nobg.png" alt="" class="h-12">
        <p class="font-outfit font-bold text-[32px] ">LMAR Hardware</p>
    </div>
    <p class="text-center font-outfit font-semibold text-[24px] mt-2">Welcome back!</p>
    <div class="flex justify-center w-full mt-3 mb-3">
        <form action="" method="post" class="loginForm flex flex-col items-start w-fit">
            <label for="email">Email:</label>
            <input type="text" name="email" id="" value="<?= (isset($email))? $email:''; ?>">
            <?php if(!empty($emailErr)){ echo "<p class='err_input'>$emailErr</p>"; } ?>
            <label for="password">Password:</label>
            <div class="flex items-center relative">
                <input type="password" name="password" id="passInput" value="<?= (isset($password))? $password:'' ?>" >
             <img id="passIconImg" class="absolute right-2  cursor-pointer" src="../assets/icons/eye-off.svg" alt="">
            </div>
            

            <?php if(!empty($passwordErr)){ echo "<p class='err_input'>$passwordErr</p>"; } ?>
            <input type="submit" name='login' value="Login">
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
        const passIconImg = document.getElementById('passIconImg');
        const eyeOff = "../assets/icons/eye-off.svg";
        const eye = "../assets/icons/eye.svg";

        passIconImg.addEventListener('click', ()=>{
            if(passIconImg.src.includes("eye-off.svg"))
            {
                passIconImg.src = eye;
                passInput.type = "text";

            }
            else {
                passIconImg.src = eyeOff;
                passInput.type = "password";
            };
        })

    </script>
</body>
</html>