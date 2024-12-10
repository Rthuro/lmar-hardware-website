<?php

    require_once "../classes/product.class.php";
    require_once "../tools/functions.php";


    include_once "../includes/header.php";

    $productObj = new Product();

    $search_term = isset($_GET['search']) ? clean_input($_GET['search']): '';
    $filter_category = isset($_GET['category']) ? clean_input($_GET['category']): '';

    $categories = $productObj->fetchCategory();
    $products = $productObj->showAll($search_term, $filter_category);

    
?>

<style>
        #inventory{
            background-color: #ff8c00;
        }
      .addprod{
        display: block;
        width: fit-content;
        margin:8px 0;
      }
    .search-bar {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-input {
        padding: 10px;
        width: 250px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .btn-search {
        padding: 10px 20px;
        background-color: #ff9800;
        border: none;
        color: white;
        cursor: pointer;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .inventory{
        background-color: #ff8c00;
        color: white;
    }

    .product-img {
    width: 100px; /* Set the desired width */
    height: auto; /* Maintain the aspect ratio */
    object-fit: cover; /* Ensure images are cropped nicely if needed */
    border-radius: 5px; /* Optional: adds rounded corners */
}


</style>

<body>
<?php if (isset($_SESSION['outputMsg']['error'])) { 
            ?> <p id="err" class="err flex justify-center fixed top-0 left-0 right-0 py-5 bg-red-600 text-white z-40"><?= $_SESSION['outputMsg']['error'] ?></p> <?php 
            unset($_SESSION['outputMsg']['error']);
            }
        ?>
         <?php if (isset($_SESSION['outputMsg']['success'])) { 
            ?> <p id="succ" class="succ flex justify-center fixed top-0 left-0 right-0 py-5 bg-green-600 text-white z-50">
                <?= $_SESSION['outputMsg']['success'] ?>
            </p> <?php 
            unset($_SESSION['outputMsg']['success']);
         }
        ?>
    <?php include_once "../includes/sidebar.php" ?>
    <div class="main-content">
    <div class="flex justify-between items-end my-4">
    <p class="text-4xl">Inventory Management</p>
   
</div>

        <form method="GET" action="" class="search-bar">
            <input type="text" name="search" class="search-input" placeholder="Search by product name"
                value="<?= htmlspecialchars($search_term) ?>">
            <select name="category" class="search-input">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= $category['name'] ?>"
                    <?= $filter_category == $category['name'] ? 'selected' : '' ?>>
                    <?= $category['name'] ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-search">Search</button>
        </form>

        <div class="action-buttons">
          <!-- Button for Adding Product -->
            <button class="styled-button" onclick="window.location.href='../product/add_product.php'">
                Add Product
            </button>
          
       </div>


        <table border="1">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): 
                    ?>
                <tr>
                    <td><img src="../product/<?= $product['product_img'] ?>" alt="Product Image" class="product-img"></td>
                    <td><?= $product['product_name'] ?></td>
                    <td><?= $product['category_name'] ?></td>
                    <td>
                        <a href="../product/edit_product.php?id=<?= $product['id'] ?>">Edit</a>
                        <a href="../product/delete_product.php?id=<?= $product['id'] ?>"
                            onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>  
                <tr>
                    <td colspan="6">No products found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

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
</html>