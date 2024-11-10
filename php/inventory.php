<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'lmar_hardware';
$user = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Initialize search and filter variables
$search_term = isset($_GET['search']) ? $_GET['search'] : '';
$filter_category = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch categories for the filter dropdown
$category_stmt = $pdo->query("SELECT DISTINCT category FROM products");
$categories = $category_stmt->fetchAll(PDO::FETCH_ASSOC);

// Modify the SQL query to include search and filter
$sql = "SELECT * FROM products WHERE 1";
if ($search_term) {
    $sql .= " AND product_name LIKE :search";
}
if ($filter_category) {
    $sql .= " AND category = :category";
}

$stmt = $pdo->prepare($sql);
if ($search_term) {
    $stmt->bindValue(':search', '%' . $search_term . '%');
}
if ($filter_category) {
    $stmt->bindValue(':category', $filter_category);
}
$stmt->execute();
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="css/style.css">
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

    .btn-search:hover {
        /* background-color: ; */
    }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>LMAR Hardware</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a id="inventory" href="inventory.php">Inventory</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="deliveries.php">Deliveries</a></li>
            <li><a href="pickup.php">Pickups</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Inventory Management</h1>
        <a  href="add_product.php" class="addprod btn btn-primary">Add Product</a><br><br>

        <!-- Search and Filter Section -->
        <form method="GET" action="" class="search-bar">
            <input type="text" name="search" class="search-input" placeholder="Search by product name"
                value="<?= htmlspecialchars($search_term) ?>">
            <select name="category" class="search-input">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['category']) ?>"
                    <?= $filter_category == $category['category'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['category']) ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-search">Search</button>
        </form>

        <!-- Inventory Table -->
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
                    <td><?= htmlspecialchars($product['category']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['stocks']) ?></td>
                    <td>
                        <a href="edit_product.php?id=<?= $product['id'] ?>">Edit</a>
                        <a href="delete_product.php?id=<?= $product['id'] ?>"
                            onclick="return confirm('Are you sure?')">Delete</a>
                        <a href="update_stock.php?id=<?= $product['id'] ?>">Update Stock</a>
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