<?php
require_once('header.php');

// Check if user ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid user ID.");
}

$user_id = $_GET['id'];

// Initialize variables for user data
$user = [];
$errorMessage = "";
$successMessage = "";

// Fetch the user details from the database
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }
} catch (Exception $e) {
    $errorMessage = "Error fetching user data: " . $e->getMessage();
}

// Handle the form submission to update user data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? 'user';
    $email_verified = isset($_POST['email_verified']) ? 1 : 0;
    $status = $_POST['status'] ?? 'active';
    $agreed_to_terms = isset($_POST['agreed_to_terms']) ? 1 : 0;

    // Update the user details in the database
    try {
        $stmt = $pdo->prepare("
            UPDATE users 
            SET name = :name, email = :email, role = :role, email_verified = :email_verified, 
                status = :status, agreed_to_terms = :agreed_to_terms, updated_at = CURRENT_TIMESTAMP 
            WHERE user_id = :user_id
        ");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':role' => $role,
            ':email_verified' => $email_verified,
            ':status' => $status,
            ':agreed_to_terms' => $agreed_to_terms,
            ':user_id' => $user_id
        ]);

        // Success message and redirection after the update
        $successMessage = "User updated successfully!";
        header("Location: user_list.php");  // Redirect to the user list page
        exit();  // Ensure no further code is executed after redirection
    } catch (Exception $e) {
        $errorMessage = "Error updating user data: " . $e->getMessage();
    }
}

?>

<section class="content-header">
    <h1>Edit User</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit User Details</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role">
                        <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                        <option value="moderator" <?php echo ($user['role'] === 'moderator') ? 'selected' : ''; ?>>Moderator</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="email_verified">Email Verified</label>
                    <input type="checkbox" id="email_verified" name="email_verified" <?php echo ($user['email_verified'] == 1) ? 'checked' : ''; ?>>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="active" <?php echo ($user['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo ($user['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="agreed_to_terms">Agreed to Terms</label>
                    <input type="checkbox" id="agreed_to_terms" name="agreed_to_terms" <?php echo ($user['agreed_to_terms'] == 1) ? 'checked' : ''; ?>>
                </div>

                <button type="submit" class="btn btn-primary">Update User</button>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
