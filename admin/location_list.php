<?php
require_once('header.php');

$errorMessage = "";
$successMessage = "";

// Handle deletion of a location
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    try {
        $delete_id = intval($_GET['delete_id']);
        $stmt = $pdo->prepare("DELETE FROM locations WHERE location_id = :location_id");
        $stmt->execute(['location_id' => $delete_id]);
        $successMessage = "Location deleted successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error deleting location: " . $e->getMessage();
    }
}

// Fetch locations from the database
$locations = [];
try {
    $stmt = $pdo->query("SELECT * FROM locations ORDER BY created_at DESC");
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching locations: " . $e->getMessage();
}
?>

<section class="content-header">
    <h1>Location List</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Current Locations</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($locations)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Location ID</th>
                            <th>Location Name</th>
                            <th>Region</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($locations as $location): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($location['location_id']); ?></td>
                                <td><?php echo htmlspecialchars($location['location_name']); ?></td>
                                <td><?php echo htmlspecialchars($location['region']); ?></td>
                                <td><?php echo htmlspecialchars($location['created_at']); ?></td>
                                <td>
                                    <a href="edit_location.php?location_id=<?php echo $location['location_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="location_list.php?delete_id=<?php echo $location['location_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this location?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No locations found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
