<?php
require_once('header.php');

$errorMessage = "";
$successMessage = "";

// Check if location_id is provided in the URL and is valid
if (isset($_GET['location_id']) && is_numeric($_GET['location_id'])) {
    $location_id = intval($_GET['location_id']);

    // Fetch location data for the given location_id
    try {
        $stmt = $pdo->prepare("SELECT * FROM locations WHERE location_id = :location_id");
        $stmt->execute(['location_id' => $location_id]);
        $location = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$location) {
            $errorMessage = "Location not found.";
        }
    } catch (Exception $e) {
        $errorMessage = "Error fetching location: " . $e->getMessage();
    }
} else {
    $errorMessage = "Invalid or missing location ID.";
}

// Handle form submission for updating the location
if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errorMessage)) {
    try {
        $location_name = trim($_POST['location_name']);
        $region = trim($_POST['region']);

        if (empty($location_name) || empty($region)) {
            throw new Exception("All fields are required.");
        }

        // Update location details
        $stmt = $pdo->prepare("UPDATE locations SET location_name = :location_name, region = :region WHERE location_id = :location_id");
        $stmt->execute([
            'location_name' => $location_name,
            'region' => $region,
            'location_id' => $location_id
        ]);

        $successMessage = "Location updated successfully!";

        // Redirect back to the list of locations or refresh the page
        header("Location: location_list.php");
        exit;

    } catch (Exception $e) {
        $errorMessage = "Error updating location: " . $e->getMessage();
    }
}
?>

<section class="content-header">
    <h1>Edit Location</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Location Details</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($location)): ?>
                <form method="post">
                    <!-- Location Name -->
                    <div class="form-group">
                        <label for="location_name">Location Name</label>
                        <input type="text" class="form-control" id="location_name" name="location_name" value="<?php echo htmlspecialchars($location['location_name']); ?>" required>
                    </div>

                    <!-- Region -->
                    <div class="form-group">
                        <label for="region">Region</label>
                        <input type="text" class="form-control" id="region" name="region" value="<?php echo htmlspecialchars($location['region']); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            <?php else: ?>
                <p>No location found for the given ID.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
