<?php 
require_once "includes/session_handler.inc.php"; 
require_once "includes/dbh.inc.php";

// Check if user is admin
if ($_SESSION['Role'] != 'admin') {
    header('Location: index.php');
    exit;
}

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);

    // Prevent actions on the currently logged-in admin
    if ($user_id == $_SESSION['UserID']) {
        $message = "You cannot change or delete your own account.";
    } else {
        if (isset($_POST['change_role'])) {
            $new_role = $_POST['new_role'];
            $stmt = $pdo->prepare('UPDATE registration SET Role = :new_role WHERE UserID = :user_id');
            $stmt->execute(['new_role' => $new_role, 'user_id' => $user_id]);
            $message = "User role updated successfully.";
        }

        if (isset($_POST['reset_password'])) {
            $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
            $stmt = $pdo->prepare('UPDATE registration SET PasswordHash = :new_password WHERE UserID = :user_id');
            $stmt->execute(['new_password' => $new_password, 'user_id' => $user_id]);
            $message = "User password reset successfully.";
        }

        if (isset($_POST['delete_user'])) {
            $stmt = $pdo->prepare('DELETE FROM registration WHERE UserID = :user_id');
            $stmt->execute(['user_id' => $user_id]);
            $message = "User deleted successfully.";
        }
    }
}

// Fetch all users
$stmt = $pdo->query('SELECT * FROM registration ORDER BY UserID ASC');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Manage Users</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-family: "Arial", sans-serif;
            background-color: #f5f5f5;
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        table {
            margin-top: 20px;
        }
        .password-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .w3-button {
            min-width: 80px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <div class="w3-bar w3-teal">
        <?php include_once "includes/nav_items.inc.php"; ?>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2 class="w3-text-teal">Admin Panel - Manage Users</h2>

        <!-- Message -->
        <?php if (isset($message)): ?>
            <div class="w3-panel w3-pale-green w3-border w3-round w3-margin-bottom">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- User Table -->
        <table class="w3-table w3-bordered w3-striped">
            <thead>
                <tr class="w3-light-grey">
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Created At</th>
                    <th>Role</th>
                    <th>Reset Password</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['UserID']) ?></td>
                        <td><?= htmlspecialchars($user['Username']) ?></td>
                        <td><?= htmlspecialchars($user['CreatedAt']) ?></td>
                        <td>
                            <?php if ($user['UserID'] == $_SESSION['UserID']): ?>
                                <?= htmlspecialchars($user['Role']) ?>
                            <?php else: ?>
                                <!-- Role Dropdown -->
                                <form method="post" action="admin_panel.php" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['UserID'] ?>">
                                    <select class="w3-select w3-border" name="new_role" onchange="this.form.submit()">
                                        <option value="user" <?= $user['Role'] === 'user' ? 'selected' : '' ?>>User</option>
                                        <option value="admin" <?= $user['Role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                    </select>
                                    <input type="hidden" name="change_role" value="1">
                                </form>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($user['UserID'] == $_SESSION['UserID']): ?>
                                <span class="w3-text-grey">Not editable</span>
                            <?php else: ?>
                                <!-- Reset Password Form -->
                                <form method="post" action="admin_panel.php" style="display: inline;">
                                    <div class="password-container">
                                        <input class="w3-input w3-border" type="text" name="new_password" placeholder="New Password" required>
                                        <button class="w3-button w3-yellow" type="submit" name="reset_password">Reset</button>
                                    </div>
                                    <input type="hidden" name="user_id" value="<?= $user['UserID'] ?>">
                                </form>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($user['UserID'] == $_SESSION['UserID']): ?>
                                <span class="w3-text-grey">Not editable</span>
                            <?php else: ?>
                                <!-- Delete User Button -->
                                <form method="post" action="admin_panel.php" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['UserID'] ?>">
                                    <button class="w3-button w3-red" type="submit" name="delete_user" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
