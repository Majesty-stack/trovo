<?php
require_once('header.php');

// Initialize variables
$errorMessage = "";
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';  // Default role is 'user'
    $email_verified = isset($_POST['email_verified']) ? 1 : 0;
    $status = $_POST['status'] ?? 'active';
    $agreed_to_terms = isset($_POST['agreed_to_terms']) ? 1 : 0;

    // Validate inputs
    if (empty($name) || empty($email) || empty($password)) {
        $errorMessage = "Name, email, and password are required.";
    } else {
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        try {
            // Insert the new user into the database
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, role, email_verified, status, agreed_to_terms, created_at, updated_at) 
                                   VALUES (:name, :email, :password_hash, :role, :email_verified, :status, :agreed_to_terms, NOW(), NOW())");
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password_hash' => $password_hash,
                ':role' => $role,
                ':email_verified' => $email_verified,
                ':status' => $status,
                ':agreed_to_terms' => $agreed_to_terms,
            ]);

            $successMessage = "User added successfully!";
        } catch (Exception $e) {
            $errorMessage = "Error adding user: " . $e->getMessage();
        }
    }
}

?>

<section class="content-header">
    <h1>Add New User</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">User Information</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <form method="POST" action="add_user.php">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="user" <?php echo isset($role) && $role == 'user' ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo isset($role) && $role == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="email_verified">Email Verified</label>
                    <input type="checkbox" id="email_verified" name="email_verified" <?php echo isset($email_verified) && $email_verified == 1 ? 'checked' : ''; ?>>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active" <?php echo isset($status) && $status == 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo isset($status) && $status == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="agreed_to_terms">Agreed to Terms</label>
                    <input type="checkbox" id="agreed_to_terms" name="agreed_to_terms" <?php echo isset($agreed_to_terms) && $agreed_to_terms == 1 ? 'checked' : ''; ?>>
                </div>

                <button type="submit" class="btn btn-primary">Add User</button>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
