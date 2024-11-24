<?php
require_once('header.php');

$errorMessage = "";
$successMessage = "";

// Check if category_id is provided in the URL and is valid
if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']);

    // Fetch category data
    try {
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE category_id = :category_id");
        $stmt->execute(['category_id' => $category_id]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$category) {
            $errorMessage = "Category not found.";
        }
    } catch (Exception $e) {
        $errorMessage = "Error fetching category: " . $e->getMessage();
    }
} else {
    $errorMessage = "Invalid or missing category ID.";
}

// Handle form submission for updating the category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errorMessage)) {
    try {
        $category_name = trim($_POST['category_name']);
        $description = trim($_POST['description']);

        if (empty($category_name)) {
            throw new Exception("Category name is required.");
        }

        // Update category details
        $stmt = $pdo->prepare("UPDATE categories SET category_name = :category_name, description = :description WHERE category_id = :category_id");
        $stmt->execute([
            'category_name' => $category_name,
            'description' => $description,
            'category_id' => $category_id
        ]);

        $successMessage = "Category updated successfully!";

        // Redirect to job categories page after successful update
        header("Location: job_categories.php");
        exit;

    } catch (Exception $e) {
        $errorMessage = "Error updating category: " . $e->getMessage();
    }
}
?>

<section class="content-header">
    <h1>Edit Category</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Category Details</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($category)): ?>
                <form method="post">
                    <!-- Category Name -->
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"><?php echo htmlspecialchars($category['description']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            <?php else: ?>
                <p>No category found for the given ID.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
