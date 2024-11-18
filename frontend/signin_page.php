<?php

$host = 'localhost';
$dbname = 'lmar_hardware';
$user = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function clean_input($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
$email = $confirmpass =  $password = '';
$emailErr  =  $passwordErr = $confirmpassErr = '';
$role = 'customer';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])){
       $email = clean_input($_POST['email']);
       $password =  clean_input($_POST['password']);
       $confirmpass =  clean_input($_POST['confirm_password']);
        if(empty($email)){
            $emailErr = "Please enter your email.";
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
            $checkAccDuplicate  =$pdo->query("SELECT * FROM users WHERE email = '$email';");
            $accExists = $checkAccDuplicate->fetchAll(PDO::FETCH_ASSOC);

            if(empty($accExists)){
                $sql = "INSERT INTO users (email,password,role) VALUES (:email,:password,:role);";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':email', $email);
                $stmt->bindValue(':password', $password);
                $stmt->bindValue(':role', $role);
                if($stmt->execute()){
                    echo "<p class='success'>Successfully created an account! Please login your email and password in the login page.</p>";
                } else {
                    echo "<p class='err'>Error Occurred</p>";
                }
            } else {
                echo "<p class='err'>Account Already Exists!</p>";
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
    <link rel="shortcut icon" href="../assets/img/lmar_logo.png" type="image/x-icon">
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
        <img  src="../assets/img/lmar_logo_black_nobg.png" alt="" class="h-12">
        <p class="font-outfit font-bold text-[32px] ">LMAR Hardware</p>
    </div>
    <p class="text-center font-outfit font-semibold text-[24px] mt-2">Sign up!</p>
    <div class="flex justify-center w-full mt-3 mb-3">
        <form action="" method="post" class="loginForm flex flex-col items-start w-fit">
            <label for="email">Email:</label>
            <input type="email" name="email" id="" value="<?= (isset($email))? $email:''; ?>" >
            <?php if(!empty($emailErr)){ echo "<p class='err_input'>$emailErr</p>"; }; ?>

            <label for="password">Password:</label>
            <div class="flex items-center relative">
                <input type="password" name="password" id="passInput" value="<?= (isset($password))? $password:''; ?>" >
                <img id="passIconImg" src="../assets/icons/eye-off.svg" alt="" srcset="" class="absolute right-2 ">
            </div>
             
            <?php if(!empty($passwordErr)){ echo "<p class='err_input'>$passwordErr</p>"; }; ?>

            <label for="confirm_password">Confirm Password:</label>
            <div class="flex items-center relative">
                <input type="password" name="confirm_password" id="passConfirmInput" value="<?= (isset($confirmpass))? $confirmpass:''; ?>" >
                <img id="passConfirmIconImg" src="../assets/icons/eye-off.svg" class="absolute right-2 "  alt="" srcset="">
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
        const passIconImg = document.getElementById("passIconImg");
        const passConfirmIconImg = document.getElementById("passConfirmIconImg");
        const passInput = document.getElementById("passInput");
        const passConfirmInput = document.getElementById("passConfirmInput");

        const eye = "../assets/icons/eye.svg";
        const eyeOff = "../assets/icons/eye-off.svg";

        passIconImg.addEventListener('click',()=>{
            if(passIconImg.src.includes("eye-off.svg")){
                passIconImg.src = eye;
                passInput.type = "text";
            } else {
                passIconImg.src = eyeOff;
                passInput.type = "password";
            }
        })

        passConfirmIconImg.addEventListener('click',()=>{
            if(passConfirmIconImg.src.includes("eye-off.svg")){
                passConfirmIconImg.src = eye;
                passConfirmInput.type = "text";
            } else {
                passConfirmIconImg.src = eyeOff;
                passConfirmInput.type = "password";
            }
        })

    </script>
</body>
</html>