<?php
include 'header.php'; // Include the sidebar header
require 'db_connect.php'; // Connect to the database

// Fetch purchase orders from tbl_transaction
$query = "SELECT t.transaction_ID, t.inventory_ID, i.product_name, t.transaction_date
          FROM tbl_transaction t
          JOIN tbl_inventory i ON t.inventory_ID = i.inventory_ID
          WHERE t.transaction_type = 'Purchase'";
$result = mysqli_query($conn, $query);

// Check if query executed successfully
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

// Fetch all rows as an associative array
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <!-- Link to Custom CSS for Orders Page -->
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

<div id="orders-page" style="margin-left: 270px;">
    <h1>Purchase Orders</h1>
    <table class="orders-table">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Inventory ID</th>
                <th>Product Name</th>
                <th>Transaction Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['transaction_ID']); ?></td>
                        <td><?php echo htmlspecialchars($order['inventory_ID']); ?></td>
                        <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['transaction_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No purchase orders found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
