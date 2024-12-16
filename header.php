<?php
session_start();
$usertype = isset($_SESSION['usertype']) ? $_SESSION['usertype'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System</title>
    <link rel="stylesheet" href="sidebar.css">
</head>
<body>
<div class="wrapper">
    <div class="sidebar" id="sidebar-admin-user">
        <div class="logo" id="logo">
            HandyGear System
        </div>
        <nav id="sidebar-nav">
            <ul id="sidebar-menu">
                <?php if ($usertype === 'Admin'): ?>
                    <li><a href="dashboard.php" class="sidebar-link" id="dashboard-link">Dashboard</a></li>
                    <li><a href="inventory.php" class="sidebar-link" id="inventory-link">Inventory</a></li>
                    <li><a href="manage_users.php" class="sidebar-link" id="manage-users-link">Manage Users</a></li>
                    <li><a href="orders.php" class="sidebar-link" id="orders-link">Transaction Log</a></li>
                <?php elseif ($usertype === 'User'): ?>
                    <li><a href="browse_items.php" class="sidebar-link" id="browse-items-link">Browse Items</a></li>
                    <li><a href="help_support.php" class="sidebar-link" id="help-support-link">Help/Support</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="logout" id="logout-section">
            <button onclick="location.href='logout.php';" id="logout-btn">Logout</button>
        </div>
    </div>
</div>
</body>
</html>
