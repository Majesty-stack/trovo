<?php
require_once('header.php');

$errorMessage = "";
$successMessage = "";

// Handle form submission for adding a new location
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $location_name = trim($_POST['location_name']);
        $region = trim($_POST['region']);

        if (empty($location_name) || empty($region)) {
            throw new Exception("All fields are required.");
        }

        // Insert new location into the database
        $stmt = $pdo->prepare("INSERT INTO locations (location_name, region, created_at) VALUES (:location_name, :region, NOW())");
        $stmt->execute([
            'location_name' => $location_name,
            'region' => $region
        ]);

        $successMessage = "Location added successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error adding location: " . $e->getMessage();
    }
}
?>

<section class="content-header">
    <h1>Add New Location</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add Location Details</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <form method="post">
                <!-- Location Name -->
                <div class="form-group">
                    <label for="location_name">Location Name</label>
                    <input type="text" class="form-control" id="location_name" name="location_name" required>
                </div>

                <!-- Region -->
                <div class="form-group">
                    <label for="region">Region</label>
                    <input type="text" class="form-control" id="region" name="region" required>
                </div>

                <button type="submit" class="btn btn-primary">Add Location</button>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
