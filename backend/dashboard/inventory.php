<?php

    require_once "../classes/product.class.php";
    require_once "../tools/functions.php";
    session_start();

    if (!isset($_SESSION['admin_logged_in'])) {
        header("Location: index.php");
        exit();
    }

    $productObj = new Product();

    $search_term = isset($_GET['search']) ? clean_input($_GET['search']): '';
    $filter_category = isset($_GET['category']) ? clean_input($_GET['category']): '';

    $categories = $productObj->fetchCategory();
    $products = $productObj->showAll($search_term, $filter_category);

    include_once "../includes/header.php";
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

</style>

<body>
    <?php include_once "../includes/sidebar.php" ?>
    <div class="main-content">
        <div class="flex justify-between items-end my-4">
                <p class="text-4xl">Inventory Management</p>
                <button class="btn bg-[#ff8c00] py-2 px-6 rounded-md" onclick="window.location.href='orders.php'">Add Product</button>
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

        <table border="1">
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stocks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['product_code']) ?></td>
                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                    <td><?= htmlspecialchars($product['category_name']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['stocks']) ?></td>
                    <td>
                        <a href="../product/edit_product.php?id=<?= $product['id'] ?>">Edit</a>
                        <a href="../product/delete_product.php?id=<?= $product['id'] ?>"
                            onclick="return confirm('Are you sure?')">Delete</a>
                        <a href="../product/update_stock.php?id=<?= $product['id'] ?>">Update Stock</a>
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

</body>
</html>