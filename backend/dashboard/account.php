<?php

require_once "../classes/account.class.php";
require_once "../tools/functions.php";
require_once "../classes/orders.class.php";
include_once "../includes/header.php";

$orderObj = new Order();
$accountObj = new Account();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lmar_hardware";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE role = 'admin' ";
$result = $conn->query($sql);

$current_page = basename($_SERVER['PHP_SELF']);

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_admin'])){
    $email = clean_input($_POST['email']);
    $username = clean_input($_POST['username']);
    $password =  clean_input($_POST['password']);
    $confirmpass =  clean_input($_POST['confirm_password']);
    $role = 'admin';

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
             $accountObj->username = $username;
             $accountObj->password = $password;
             $accountObj->role = $role;

             if($accountObj->add()){
                 echo "<p class='success'>Successfully created an account!</p>";
                 header('location: account.php');
             } else {
                 echo "<p class='err'>Error occurred</p>";
             }
         } else {
             echo "<p class='err'>Account already exists. Please enter a different email.</p>";
         }
         
     } 
    }

?>
<style>

.sidebar a.active {
    background-color: #e67e00; 
}
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

</style>

<body>

    <?php include_once "../includes/sidebar.php" ?>

    <?php 
        if( !empty($_GET['modal']) ){ 
            if($_GET['modal'] == 'add_admin'){  ?>
                <div class="fixed top-0 right-0 left-0 bottom-0 flex items-center justify-center bg-black/40">
                    <div class=" bg-[#1e1e1e] shadow-md rounded-lg w-[500px] h-fit p-4 ">
                        <p class=" text-lg ">Add New Admin</p>
                        <form action="" method="post" enctype="multipart/form-data" class="flex flex-col w-[450px] shadow-none m-0 p-0 bg-transparent ">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="" value="<?= (isset($username))? $username:''; ?>" >
                        <?php if(!empty($usernameErr)){ echo "<p class='err_input'>$usernameErr</p>"; }; ?>

                        <label for="email" class="mt-2">Email:</label>
                        <input type="email" name="email" id="" value="<?= (isset($email))? $email:''; ?>" >
                        <?php if(!empty($emailErr)){ echo "<p class='err_input'>$emailErr</p>"; }; ?>

                        <label for="password" class="mt-2">Password:</label>
                        <input type="password" name="password" id="passInput" value="<?= (isset($password))? $password:''; ?>" >
                            <div class="flex items-center justify-start gap-1">
                                <input type="checkbox" name="showPass" id="showPass" class="size-4">
                                <label for="showPass" class=" font-normal" >Show password</label>
                            </div>
                        <?php if(!empty($passwordErr)){ echo "<p class='err_input'>$passwordErr</p>"; }; ?>

                        <label for="confirm_password" class="mt-2">Confirm Password:</label>
                        <input type="password" name="confirm_password" id="passConfirmInput" value="<?= (isset($confirmpass))? $confirmpass:''; ?>" >
                            <div class="flex items-center justify-start gap-1">
                                <input type="checkbox" name="showConfirmPass" id="showConfirmPass" class="size-4">
                                <label for="showConfirmPass" class=" font-normal"  >Show password</label>
                            </div>
                        
                        <?php if(!empty($confirmpassErr)){ echo "<p class='err_input'>$confirmpassErr</p>"; }; ?>
                            <div class="flex gap-3">
                                <input type="submit" name="new_admin" value="Add Admin" class="flex-1 bg-[#ff8c00] py-2 px-6 my-4 rounded-md">
                                <a href="account.php" class="flex-1 text-center bg-red-600 py-2 px-6 my-4 rounded-md">Cancel</a>
                            </div>
                            
                        </form>
                    </div>
                </div>
      <?php  } } ?>
    <div class="main-content">
        <div class="header">
            <h1>Admin Dashboard - Available Accounts</h1>
        </div>

        <div class="dashboard-grid">
            
           <div class="card" onclick="location.href='inventory.php'">
                <!-- Inventory SVG Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50" style="fill: #e67e00;">
                    <path d="M19 3H5c-1.1 0-1.99.89-1.99 1.99L3 19c0 1.1.89 1.99 1.99 1.99h16c1.1 0 1.99-.89 1.99-1.99V5c0-1.1-.89-1.99-1.99-1.99zM5 5h14v14H5z"/>
                </svg>
                <h3>Inventory</h3>
            </div>
           
            <div class="card" onclick="location.href='orders.php'">
                <!-- Orders SVG Icon -->
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50" style="fill: #e67e00;">
                    <path d="M3 3h18v2H3zm0 4h18v2H3zm0 4h18v2H3zm0 4h18v2H3z"/>
                </svg>
                <h3>Orders</h3>
                
            </div>
            <div class="card" onclick="location.href='delivery.php'">
                <!-- Deliveries SVG Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50" style="fill: #e67e00;">
                    <path d="M2 5v14h20V5H2zm18 12h-4v-2h4zm-6-4h-4V9h4zm-6-1H4V7h4z"/>
                </svg>

                <h3>Deliveries</h3>
              
            </div>

            <div class="card" onclick="location.href='pickups.php'">
                <!-- Pickups SVG Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50" style="fill: #e67e00;">
                    <path d="M7 2C6.45 2 6 2.45 6 3V19C6 19.55 6.45 20 7 20H17C17.55 20 18 19.55 18 19V3C18 2.45 17.55 2 17 2H7ZM8 3H16V5H8V3ZM9 6H15C15.55 6 16 6.45 16 7V18C16 18.55 15.55 19 15 19H9C8.45 19 8 18.55 8 18V7C8 6.45 8.45 6 9 6Z"/>
                </svg>



                <h3>Pickups</h3>
            </div>
        </div>
        <a class="btn bg-[#ff8c00] py-2 px-6 rounded-md block my-4 w-fit" href="account.php?modal=add_admin">
                    Add Admin
        </a>
        <div class="recent-orders">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th> <!-- Optional, can replace with ***** -->
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td>*****</td>
                        <td><?= $row['role'] ?></td>
                        <td>
                             <!-- Delete action button -->
                            <a href="delete-account.php?id=<?= $row['id'] ?>" class="action-btn" onclick="return confirm('Are you sure you want to delete this account?');">Delete</a>
                        </td>
                    </tr>
            <?php }
        } else { ?>
        <tr>
            <td colspan="6" class="text-center">No available accounts found.</td>
        </tr>
        <?php }?>
</tbody>

            </table>
        </div>
    </div>
    <script>
        const err = document.getElementById('err');
        const succ = document.getElementById('success');

        if(err !== null){
            err.addEventListener( ('click'), ()=>{
            err.classList.replace("flex", "hidden");
        } )
        }
       

        if(succ !== null){
            succ.addEventListener( ('click'), ()=>{
            succ.classList.replace("flex", "hidden");
             } )
        }  
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

<?php
$conn->close();
?>
