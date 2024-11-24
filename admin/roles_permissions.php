<?php
require_once('header.php');

// Fetch roles and permissions from the database
$roles = [];
$permissions = [];

try {
    // Fetch all roles
    $stmt = $pdo->query("SELECT * FROM roles");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch all permissions
    $stmt = $pdo->query("SELECT * FROM permissions");
    $permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching roles and permissions: " . $e->getMessage();
}

// Assign permissions to roles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roleId = $_POST['role_id'];
    $selectedPermissions = $_POST['permissions'] ?? [];

    try {
        // Delete existing permissions for the selected role
        $stmt = $pdo->prepare("DELETE FROM role_permissions WHERE role_id = :role_id");
        $stmt->execute(['role_id' => $roleId]);

        // Assign new permissions
        foreach ($selectedPermissions as $permissionId) {
            $stmt = $pdo->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)");
            $stmt->execute(['role_id' => $roleId, 'permission_id' => $permissionId]);
        }

        $successMessage = "Permissions updated successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error updating permissions: " . $e->getMessage();
    }
}

?>

<section class="content-header">
    <h1>Manage Roles and Permissions</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Roles and Permissions</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php elseif (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <form action="roles_permissions.php" method="POST">
                <div class="form-group">
                    <label for="role_id">Select Role</label>
                    <select name="role_id" id="role_id" class="form-control" required>
                        <option value="">-- Select Role --</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role['role_id']; ?>"><?php echo htmlspecialchars($role['role_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="permissions">Select Permissions</label>
                    <div class="checkbox">
                        <?php foreach ($permissions as $permission): ?>
                            <label>
                                <input type="checkbox" name="permissions[]" value="<?php echo $permission['permission_id']; ?>">
                                <?php echo htmlspecialchars($permission['permission_name']); ?>
                            </label><br>
                        <?php endforeach; ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Permissions</button>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
