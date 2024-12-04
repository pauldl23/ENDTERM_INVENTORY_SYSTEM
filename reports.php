<?php
include 'header.php'; // Include the sidebar header
require 'db_connect.php'; // Connect to the database

// Assuming you're storing user ID in session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$page_name = "Low Stock Report";
$log_message = "User accessed the low stock report page";

// Check if the user ID is available (you can skip this check if user is always logged in)
if ($user_id) {
    // Insert the log into the database using prepared statements
    $log_query = "INSERT INTO tbl_logs (log_message, user_id, page_name) VALUES (?, ?, ?)";
    
    if ($stmt = $conn->prepare($log_query)) {
        $stmt->bind_param("sis", $log_message, $user_id, $page_name); // "s" for string, "i" for integer
        $stmt->execute();
        $stmt->close();
    } else {
        // Handle error in case the statement preparation fails
        echo "Error preparing the statement: " . $conn->error;
    }
} else {
    // Handle case when user_id is not available
    echo "User is not logged in.";
}

// Fetch low stock items
$query = "SELECT product_name, product_quantity FROM tbl_inventory WHERE product_quantity < 20";
$result = mysqli_query($conn, $query);
$low_stock_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div id="report" class="container">
    <div class="main-content">
        <h1>Low Stock Report</h1>
        <h3>Items with Low Stock</h3>

        <!-- List of low stock items -->
        <ul class="list-group">
            <?php if (count($low_stock_items) > 0): ?>
                <?php foreach ($low_stock_items as $item): ?>
                    <li class="list-group-item">
                        <?php echo $item['product_name']; ?>
                        <span class="badge"><?php echo $item['product_quantity']; ?> left</span>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item">All items are sufficiently stocked.</li>
            <?php endif; ?>
        </ul>

        <!-- Transaction Logs -->
        <h3 class="mt-5">Transaction Log</h3>
        <table class="log-table">
            <thead>
                <tr>
                    <th>Log ID</th>
                    <th>User ID</th>
                    <th>Message</th>
                    <th>Page Name</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch logs for the current user (admin can see all logs)
                $log_query = "SELECT * FROM tbl_logs ORDER BY timestamp DESC";
                $log_result = mysqli_query($conn, $log_query);

                if (mysqli_num_rows($log_result) > 0) {
                    while ($log = mysqli_fetch_assoc($log_result)) {
                        echo "<tr>
                                <td>{$log['log_id']}</td>
                                <td>{$log['user_id']}</td>
                                <td>{$log['log_message']}</td>
                                <td>{$log['page_name']}</td>
                                <td>{$log['timestamp']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No logs available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
