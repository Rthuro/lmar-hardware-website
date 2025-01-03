<?php
    require_once "../classes/orders.class.php";
    include_once "../includes/header.php";

    $orderObj = new Order();
    $locations = $orderObj->fetchLocation();

    $error = $success = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['edit_location'])){
            $location_name = $_POST['location_name'];
            $deliveryFee = $_POST['deliveryFee'];
            $id = $_GET['id'];

            $edit_loc = $orderObj->fetchLocationById($id);
            if($deliveryFee <= 0){
                $error = "Delivery Fee should be greater than 0 ";
            }

                if( $edit_loc['name'] !== $location_name ){
                    $orderObj->location_name = $location_name;
                    if(!empty($orderObj->fetchLocationByName())){
                        $error = "Location ". $location_name . " already exists.";
                    } else {
                        if($orderObj->editLocation($location_name, $deliveryFee, $id)){  
                            header('location: delivery_settings.php');
                        }
                    }
                } else {
                    if($edit_loc['deliveryFee'] !== $deliveryFee){
                        if($orderObj->editLocation($location_name, $deliveryFee, $id)){      
                            header('location: delivery_settings.php');
                        }
                    } 
                }
            
           
        } else if(isset($_POST['add_location'])){
            $addLocation_name = $_POST['addLocation_name'];
            $addLocation_deliveryFee = $_POST['addLocation_deliveryFee'];

            $orderObj->location_name = $addLocation_name;
            if(!empty($orderObj->fetchLocationByName())){
                $error = "Location ". $addLocation_name . " already exists.";
            } else {
                if($orderObj->addLocation($addLocation_name, $addLocation_deliveryFee)){
                    header('location: delivery_settings.php');
                }
            }
        }
    }
?>

<body>  
    <?php include_once "../includes/sidebar.php";
     if (!empty($error)) { ?> 
     <p id="err" class="err flex justify-center fixed top-0 left-0 right-0 py-5 bg-red-600 text-white z-40"><?= $error ?></p>     
     <?php } 
     if (!empty($success)) { 
            ?> <p id="succ" class="succ flex justify-center fixed top-0 left-0 right-0 py-5 bg-green-600 text-white z-50">
                <?= $success ?>
            </p> 
    <?php 
     }
        if( !empty($_GET['modal']) && $_GET['modal'] == 'edit_location'){ 
            $editLocation = $orderObj->fetchLocationById($_GET['id']); ?>
                <div id="edit_location_modal" class="fixed top-0 right-0 left-0 bottom-0 flex items-center justify-center bg-black/40">
                    <div class=" bg-[#1e1e1e] shadow-md rounded-lg w-[500px] h-fit p-4">
                        <p class=" text-lg ">Edit Location</p>
                        <form action="" method="post" class="flex flex-col w-[450px] shadow-none m-0 p-0 bg-transparent ">
                            <?php 
                                if(!empty($editLocation)){ ?>
                                        <label for="location_name" class="mt-3">Location:</label>
                                        <input type="text" name="location_name" id="" value="<?= $editLocation['name'] ?>" required>
                                        <label for="deliveryFee" class="mt-3">Delivery Fee:</label>
                                        <input type="number" name="deliveryFee" id="" value="<?= $editLocation['deliveryFee'] ?>" min="0" required>
                                  <?php }
                            ?>  
                            <div class="flex gap-3">
                                <input type="submit" name="edit_location" value="Edit" class="flex-1 bg-[#ff8c00] py-2 px-6 my-4 rounded-md">
                                <a href="delivery_settings.php" class="flex-1 text-center bg-red-600 py-2 px-6 my-4 rounded-md">Cancel</a>
                            </div>
                            
                        </form>
                    </div>
                </div>
      <?php  }
        if( !empty($_GET['modal']) && $_GET['modal'] == 'new_location'){ ?>
            <div id="add_location_modal" class="fixed top-0 right-0 left-0 bottom-0 flex items-center justify-center bg-black/40">
                <div class=" bg-[#1e1e1e] shadow-md rounded-lg w-[500px] h-fit p-4">
                    <p class=" text-lg ">New Location</p>
                    <form action="" method="post" class="flex flex-col w-[450px] shadow-none m-0 p-0 bg-transparent ">
                        <label for="addLocation_name" class="mt-3">Location:</label>
                        <input type="text" name="addLocation_name" id="" value="" required>
                        <label for="addLocation_deliveryFee" class="mt-3">Delivery Fee:</label>
                        <input type="number" name="addLocation_deliveryFee" id="" value="" min="0" required>
                        <div class="flex gap-3">
                            <input type="submit" name="add_location" value="Add Location" class="flex-1 bg-[#ff8c00] py-2 px-6 my-4 rounded-md">
                            <a href="delivery_settings.php" class="flex-1 text-center bg-red-600 py-2 px-6 my-4 rounded-md">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php }
    ?>
    <div class="main-content">
        <div class="header">
            <h1>Delivery Settings</h1>
        </div>
        <a href="delivery_settings.php?modal=new_location" class="btn bg-[#ff8c00] py-2 px-6 rounded-md" >
                New Location
        </a>
        <table>
            <thead>
                <tr>
                    <td>Location</td>
                    <td>Delivery Fee</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(!empty($locations)){
                        foreach($locations as $arr){ ?>
                            <tr>
                                <td><?= $arr['name'] ?></td>
                                <td>PHP <?= $arr['deliveryFee'] ?> </td>
                                <td>
                                    <a href="delivery_settings.php?modal=edit_location&id=<?= $arr['id'] ?>">Edit</a>
                                    <a href="delivery_settings_delete.php?id=<?= $arr['id'] ?>"
                                        onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                    <?php }
                    }
                ?>
            </tbody>
        </table> 
    </div>

   

    <?php include_once "../includes/footer.php";  ?>
    <script>
        const err = document.getElementById('err');
        const succ = document.getElementById('succ');

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
    </script>
</body>