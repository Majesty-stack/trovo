<?php
require_once('header.php');

// Initialize error and success messages
$errorMessage = "";
$successMessage = "";

// Handle deletion of a job category
if (isset($_GET['delete_id'])) {
    try {
        $delete_id = intval($_GET['delete_id']);
        $stmt = $pdo->prepare("DELETE FROM categories WHERE category_id = :category_id");
        $stmt->execute(['category_id' => $delete_id]);
        $successMessage = "Job category deleted successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error deleting job category: " . $e->getMessage();
    }
}

// Handle form submission for adding a new job category
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $category_name = trim($_POST['category_name']);
        $description = trim($_POST['description']);

        if (empty($category_name)) {
            throw new Exception("Category name is required.");
        }

        // Insert new job category
        $stmt = $pdo->prepare("INSERT INTO categories (category_name, description) VALUES (:category_name, :description)");
        $stmt->execute([
            'category_name' => $category_name,
            'description' => $description
        ]);

        $successMessage = "Job category added successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error adding job category: " . $e->getMessage();
    }
}

// Fetch job categories from the database
$categories = [];
try {
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY created_at DESC");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching job categories: " . $e->getMessage();
}
?>

<section class="content-header">
    <h1>Job Categories</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Job Category</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <form method="post">
                <!-- Category Name -->
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" required>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Add Category</button>
            </form>
        </div>
    </div>

    <!-- Display Job Categories -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Current Job Categories</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($categories)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($category['category_id']); ?></td>
                                <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                                <td><?php echo htmlspecialchars($category['description']); ?></td>
                                <td><?php echo htmlspecialchars($category['created_at']); ?></td>
                                <td>
                                    <a href="edit_category.php?category_id=<?php echo $category['category_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="job_categories.php?delete_id=<?php echo $category['category_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No job categories found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
