<?php
require_once('header.php');

// Initialize variables for error handling
$errorMessage = "";
$users = [];

try {
    // Fetch users from the database
    $stmt = $pdo->query("SELECT user_id, name, email, role, email_verified, status, agreed_to_terms, created_at, updated_at FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching users: " . $e->getMessage();
}
?>

<section class="content-header">
    <h1>User List</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Overview of Users</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <div class="user-list-section">
                <?php if (!empty($users)): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Email Verified</th>
                                <th>Status</th>
                                <th>Agreed to Terms</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                                    <td><?php echo $user['email_verified'] == 1 ? 'Yes' : 'No'; ?></td>
                                    <td><?php echo htmlspecialchars($user['status']); ?></td>
                                    <td><?php echo $user['agreed_to_terms'] == 1 ? 'Yes' : 'No'; ?></td>
                                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                                    <td><?php echo htmlspecialchars($user['updated_at']); ?></td>
                                    <td>
                                        <a href="edit_user.php?id=<?php echo htmlspecialchars($user['user_id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="delete_user.php?id=<?php echo htmlspecialchars($user['user_id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No users found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
