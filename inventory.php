<?php
include 'header.php'; // Include the sidebar header
require 'db_connect.php'; // Connect to the database

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $product_name = trim($_POST['product_name']);
    $product_id = trim($_POST['product_id']);
    $product_price = (float)$_POST['product_price'];
    $product_quantity = (int)$_POST['product_quantity'];
    $product_category = trim($_POST['product_category']);
    $user_id = 110025; // Replace with the actual user ID
    $transaction_type = 'add';
    $transaction_date = date('Y-m-d');
    
    if (!empty($product_name) && !empty($product_id)) {
        $query = "INSERT INTO tbl_inventory (product_name, product_ID, product_price, product_quantity, product_category) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdis", $product_name, $product_id, $product_price, $product_quantity, $product_category);
        $stmt->execute();
        $stmt->close();
    
        // Insert into the transaction table
        $insertQuery = "INSERT INTO tbl_transaction (user_ID, inventory_ID, transaction_type, transaction_date) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        // Get the last inserted ID to use as the inventory_ID
        $last_id = $conn->insert_id;
        $insertStmt->bind_param("iiss", $user_id, $last_id, $transaction_type, $transaction_date);
        $insertStmt->execute();
        $insertStmt->close();
    }
}

// Handle Edit Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $inventory_id = (int)$_POST['inventory_id'];
    $product_name = trim($_POST['product_name']);
    $product_id = trim($_POST['product_id']);
    $product_price = (float)$_POST['product_price'];
    $product_category = trim($_POST['product_category']);
    $user_id = 110025; // Replace with the actual user ID
    $transaction_type = 'edit';
    $transaction_date = date('Y-m-d');

    // Update the inventory record
    $updateQuery = "UPDATE tbl_inventory SET product_name = ?, product_ID = ?, product_price = ?, product_category = ? WHERE inventory_ID = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ssdis", $product_name, $product_id, $product_price, $product_category, $inventory_id);
    $updateStmt->execute();
    $updateStmt->close();

    // Insert into the transaction table
    $insertQuery = "INSERT INTO warehouse_db.tbl_transaction (user_ID, inventory_ID, transaction_type, transaction_date) VALUES (?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("iiss", $user_id, $inventory_id, $transaction_type, $transaction_date);
    $insertStmt->execute();
    $insertStmt->close();
}

// Handle Adjust Quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adjust_quantity'])) {
    $inventory_id = (int)$_POST['inventory_id'];
    $quantity_change = $_POST['adjust_quantity'] === 'add' ? (int)$_POST['quantity_change'] : -(int)$_POST['quantity_change'];
    $user_id = 110025; // Replace with the actual user ID
    $transaction_date = date('Y-m-d');
    

    // Calculate the absolute value of the quantity change
    $absolute_quantity_change = abs($quantity_change);

    // Determine the transaction type based on the quantity change
    $transaction_type = $quantity_change > 0 ? "restock + $absolute_quantity_change" : "deduct - $absolute_quantity_change";

    // Update the inventory record
    $updateQuery = "UPDATE tbl_inventory SET product_quantity = GREATEST(0, product_quantity + ?) WHERE inventory_ID = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ii", $quantity_change, $inventory_id);
    $updateStmt->execute();
    $updateStmt->close();

    // Insert into the transaction table
    $insertQuery = "INSERT INTO warehouse_db.tbl_transaction (user_ID, inventory_ID, transaction_type, transaction_date) VALUES (?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("iiss", $user_id, $inventory_id, $transaction_type, $transaction_date);
    $insertStmt->execute();
    $insertStmt->close();
}

// Handle Delete Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $inventory_id = (int)$_POST['inventory_id'];
    $transaction_type = 'delete';
    $user_id = 110025; // Replace with the actual user ID
    $transaction_date = date('Y-m-d');

    // Delete the inventory record
    $deleteQuery = "DELETE FROM tbl_inventory WHERE inventory_ID = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $inventory_id);
    $deleteStmt->execute();
    $deleteStmt->close();

    // Insert into the transaction table
    $insertQuery = "INSERT INTO warehouse_db.tbl_transaction (user_ID, inventory_ID, transaction_type, transaction_date) VALUES (?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("iiss", $user_id, $inventory_id, $transaction_type, $transaction_date);
    $insertStmt->execute();
    $insertStmt->close();
}

// Fetch Inventory Items
$result = $conn->query("SELECT * FROM tbl_inventory WHERE product_name IS NOT NULL AND product_name != ''");
$items = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="inventory" class="main-content" style="margin-left: 270px;"> <!-- Added margin-left here -->
        <h1>Inventory Management</h1>

        <!-- Add Product Form -->
        <div class="form-container">
            <h2>Add New Product</h2>
            <form method="post">
                <input type="text" name="product_name" placeholder="Product Name" required>
                <input type="text" name="product_id" placeholder="Product ID" required>
                <input type="number" step="0.01" name="product_price" placeholder="Price" required>
                <input type="number" name="product_quantity" placeholder="Quantity" required>
                <input type="text" name="product_category" placeholder="Category" required>
                <button type="submit" name="add_product" class="btn btn-search">Add Product</button>
            </form>
        </div>

        <!-- Inventory Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product ID</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr id="row-<?php echo $item['inventory_ID']; ?>">
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['product_ID']); ?></td>
                        <td><?php echo htmlspecialchars($item['product_price']); ?></td>
                        <td><?php echo htmlspecialchars($item['product_quantity']); ?></td>
                        <td><?php echo htmlspecialchars($item['product_category']); ?></td>
                        <td>
                            <!-- Adjust Quantity -->
                            <form method="post" class="action-form" style="display: inline;">
                                <input type="hidden" name="inventory_id" value="<?php echo $item['inventory_ID']; ?>">
                                <input type="number" name="quantity_change" placeholder="Qty" required style="width: 60px;">
                                <button type="submit" name="adjust_quantity" value="add" class="btn btn-success">+</button>
                                <button type="submit" name="adjust_quantity" value="subtract" class="btn btn-danger">-</button>
                            </form>

                            <!-- Edit Product -->
                            <button class="btn btn-warning" onclick="toggleEditForm(<?php echo $item['inventory_ID']; ?>)">Edit</button>

                            <!-- Delete Product -->
                            <form method="post" class="action-form" style="display: inline;">
                                <input type="hidden" name="inventory_id" value="<?php echo $item['inventory_ID']; ?>">
                                <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <!-- Hidden Edit Form -->
                    <tr id="edit-row-<?php echo $item['inventory_ID']; ?>" class="edit-row" style="display: none;">
                        <td colspan="6">
                            <form method="post" class="edit-form">
                                <input type="hidden" name="inventory_id" value="<?php echo $item['inventory_ID']; ?>">
                                <input type="text" name="product_name" value="<?php echo htmlspecialchars($item['product_name']); ?>" required>
                                <input type="text" name="product_id" value="<?php echo htmlspecialchars($item['product_ID']); ?>" required>
                                <input type="number" step="0.01" name="product_price" value="<?php echo htmlspecialchars($item['product_price']); ?>" required>
                                <input type="text" name="product_category" value="<?php echo htmlspecialchars($item['product_category']); ?>" required>
                                <button type="submit" name="edit_product" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary" onclick="toggleEditForm(<?php echo $item['inventory_ID']; ?>)">Cancel</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function toggleEditForm(id) {
            const editRow = document.getElementById(`edit-row-${id}`);
            editRow.style.display = editRow.style.display === 'none' ? 'table-row' : 'none';
        }
    </script>
</body>
</html>
