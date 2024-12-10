
<div class="sidebar">
    <h2>LMAR Hardware</h2>
    <ul>
        <li><a class="dashboard <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>" href="/backend/dashboard/dashboard.php">Dashboard</a></li>
        <li><a class="inventory <?php echo (basename($_SERVER['PHP_SELF']) == 'inventory.php') ? 'active' : ''; ?>" href="/backend/dashboard/inventory.php">Inventory</a></li>
        <li><a class="orders <?php echo (basename($_SERVER['PHP_SELF']) == 'orders.php') ? 'active' : ''; ?>" href="/backend/dashboard/orders.php">Orders</a></li>
        <li><a class="delivery <?php echo (basename($_SERVER['PHP_SELF']) == 'delivery.php') ? 'active' : ''; ?>" href="/backend/dashboard/delivery.php">Deliveries</a></li>
        <li><a class="pickup <?php echo (basename($_SERVER['PHP_SELF']) == 'pickups.php') ? 'active' : ''; ?>" href="/backend/dashboard/pickups.php">Pickups</a></li>
        <li><a class="account <?php echo (basename($_SERVER['PHP_SELF']) == 'account.php') ? 'active' : ''; ?>" href="/backend/dashboard/account.php">Account</a></li>
        <li><a href="/backend/account/logout.php">Logout</a></li>
    </ul>
</div>
