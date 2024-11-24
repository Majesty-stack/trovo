<?php
require_once('header.php'); // Database connection included here

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form was submitted
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image_url = '';

    // Validate the inputs
    if (empty($title) || empty($description)) {
        $errorMessage = "Title and description are required.";
    } else {
        // Handle the file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_name = basename($_FILES['image']['name']);
            $upload_dir = 'uploads/sliders/';
            $image_path = $upload_dir . $image_name;

            // Create the uploads directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Move the uploaded image to the desired directory
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $image_url = $image_path;
            } else {
                $errorMessage = "Failed to upload the image.";
            }
        } else {
            $errorMessage = "Please select an image.";
        }

        // If no errors, insert into the database
        if (empty($errorMessage)) {
            try {
                // Insert the slider data into the database
                $stmt = $pdo->prepare("INSERT INTO sliders (title, description, image_url, status) VALUES (?, ?, ?, ?)");
                $stmt->execute([$title, $description, $image_url, 'active']);

                $successMessage = "Slider added successfully!";
            } catch (Exception $e) {
                $errorMessage = "Error inserting slider: " . $e->getMessage();
            }
        }
    }
}
?>

<section class="content-header">
    <h1>Add New Slider</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add Slider Details</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <form action="add_slider.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($title ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5" required><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Slider Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Slider</button>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
