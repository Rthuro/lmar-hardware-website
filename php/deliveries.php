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
    <title>Deliveries</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
    #deliveries{
        background-color: #ff8c00;
    }
    #delivery-form{
        margin:none;
    }
    .main-container{
        display: flex;
        justify-content: start;
        align-items: start;
        flex-direction: column;
        margin-left: 300px;
        padding-top: 50px;
    }
    .maincontent{
        height: fit-content;
    }
</style>
<body>


    <div class="sidebar">
        <h2>LMAR Hardware</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a id="deliveries" href="deliveries.php">Deliveries</a></li>
            <li><a href="pickup.php">Pickups</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-container">
        <form id="delivery-form" method="GET" action="" class="">
            <input type="text" name="search" class="search-input" placeholder="Search by Customer Name"
                value="<?= htmlspecialchars($search_term) ?>">
            <select name="customer_name" class="search-input">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['customer_name']) ?>"
                    <?= $filter_category == $category['customer_name'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['customer_name']) ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-search btn-primary">Search</button>
        </form>
        <div class="maincontent">
        <div class="header">
            <h1>Manage Orders</h1>
        </div>
        <div>
            <!-- Add functionalities for approving orders, filtering by status, etc. -->
            <p></p>
        </div>
    </div>

    </div>
    

   
</body>

</html>