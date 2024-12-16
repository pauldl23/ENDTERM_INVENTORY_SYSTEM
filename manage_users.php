<?php
include 'header.php'; // Include the sidebar header
require 'db_connect.php'; // Connect to the database

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['usertype'] !== 'Admin') {
    header("Location: login_screen.php");
    exit;
}

// Fetch all users
$result = mysqli_query($conn, "SELECT * FROM tbl_users");
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Handle adding a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $usertype = mysqli_real_escape_string($conn, $_POST['usertype']);

    // // Hash password before storing it
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $query = "INSERT INTO tbl_users (username, password, firstname, lastname, usertype) VALUES ('$username', '$password', '$firstname', '$lastname', '$usertype')";
    if (mysqli_query($conn, $query)) {
        echo "<p>User added successfully.</p>";
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <!-- Link to Custom CSS File -->
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div id="manage-users" style="margin-left: 270px;">
        <h1>Manage Users</h1>

        <!-- Add User Form -->
        <div class="manage-users-card">
            <h3>Add New User</h3>
            <form method="POST" action="manage_users.php">
                <div class="manage-users-input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="manage-users-input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="manage-users-input-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>

                <div class="manage-users-input-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" required>
                </div>

                <div class="manage-users-input-group">
                    <label for="usertype">User Type</label>
                    <select id="usertype" name="usertype" required>
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                    </select>
                </div>

                <button type="submit" name="add_user">Add User</button>
            </form>
        </div>

        <!-- Users Table -->
        <div class="manage-users-card">
            <h3>Existing Users</h3>
            <table class="manage-users-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>User Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['userID']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['firstname']; ?></td>
                            <td><?php echo $user['lastname']; ?></td>
                            <td><?php echo $user['usertype']; ?></td>
                            <td>
                                <form method="post" action="delete_user.php">
                                    <input type="hidden" name="user_id" value="<?php echo $user['userID']; ?>">
                                    <button type="submit" class="manage-users-delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
