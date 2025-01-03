<?php
    require_once "../classes/product.class.php";
    include_once "../includes/header.php";

    $productObj = new Product();
    $categories = $productObj->fetchCategory();

    $error = $success = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['edit_category'])){
            $category = $_POST['category'];
            $id = $_GET['id'];

            $edit_category = $productObj->fetchCategoryById($id);
            
                if( $edit_category[0]['name'] !== $category ){

                    if(!empty($productObj->fetchCategoryByName($category))){
                        $error = "Category ". $category . " already exists.";
                    } else {
                        if($productObj->editCategory($id,$category)){  
                            header('location: product_settings.php');
                        }
                    }
                } 
           
        } else if(isset($_POST['add_category'])){
            $addCategory_name = $_POST['addCategory_name'];
            if(!empty($productObj->fetchCategoryByName($addCategory_name))){
                $error = "Category ". $addCategory_name . " already exists.";
            } else {
                if($productObj->addCategory($addCategory_name)){
                    header('location: product_settings.php');
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
        if( !empty($_GET['modal']) && $_GET['modal'] == 'edit_category'){ 
            $editCategory = $productObj->fetchCategoryById($_GET['id']); ?>
                <div class="fixed top-0 right-0 left-0 bottom-0 flex items-center justify-center bg-black/40">
                    <div class=" bg-[#1e1e1e] shadow-md rounded-lg w-[500px] h-fit p-4">
                        <p class=" text-lg ">Edit Category</p>
                        <form action="" method="post" class="flex flex-col w-[450px] shadow-none m-0 p-0 bg-transparent ">
                            <?php 
                                if(!empty($editCategory)){ ?>
                                        <label for="category" class="mt-3">Category:</label>
                                        <input type="text" name="category" id="" value="<?= $editCategory[0]['name'] ?>" required>
                                  <?php }
                            ?>  
                            <div class="flex gap-3">
                                <input type="submit" name="edit_category" value="Edit" class="flex-1 bg-[#ff8c00] py-2 px-6 my-4 rounded-md">
                                <a href="product_settings.php" class="flex-1 text-center bg-red-600 py-2 px-6 my-4 rounded-md">Cancel</a>
                            </div>
                            
                        </form>
                    </div>
                </div>
      <?php  }
        if( !empty($_GET['modal']) && $_GET['modal'] == 'new_category'){ ?>
            <div class="fixed top-0 right-0 left-0 bottom-0 flex items-center justify-center bg-black/40">
                <div class=" bg-[#1e1e1e] shadow-md rounded-lg w-[500px] h-fit p-4">
                    <p class=" text-lg ">New Category</p>
                    <form action="" method="post" class="flex flex-col w-[450px] shadow-none m-0 p-0 bg-transparent ">
                        <label for="addCategory_name" class="mt-3">Category:</label>
                        <input type="text" name="addCategory_name" id="" value="" required>
                        <div class="flex gap-3">
                            <input type="submit" name="add_category" value="Add Category" class="flex-1 bg-[#ff8c00] py-2 px-6 my-4 rounded-md">
                            <a href="product_settings.php" class="flex-1 text-center bg-red-600 py-2 px-6 my-4 rounded-md">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php }
    ?>
    <div class="main-content">
        <div class="header">
            <h1>Product Settings</h1>
        </div>
        <a href="product_settings.php?modal=new_category" class="btn bg-[#ff8c00] py-2 px-6 rounded-md" >
                New Category
        </a>
        <table>
            <thead>
                <tr>
                    <td>Location</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(!empty($categories)){
                        foreach($categories as $arr){ ?>
                            <tr>
                                <td><?= $arr['name'] ?></td>
                                <td>
                                    <a href="product_settings.php?modal=edit_category&id=<?= $arr['id'] ?>">Edit</a>
                                    <a href="product_settings_delete.php?id=<?= $arr['id'] ?>"
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