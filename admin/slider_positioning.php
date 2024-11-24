<?php
require_once('header.php'); // Database connection included here

$errorMessage = "";
$successMessage = "";

// Fetch all sliders from the database
try {
    $stmt = $pdo->query("SELECT * FROM sliders ORDER BY position ASC");
    $sliders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching sliders: " . $e->getMessage();
}

// Handle position update
if (isset($_POST['update_positions'])) {
    try {
        // Loop through the sliders and update their positions
        foreach ($_POST['positions'] as $slider_id => $position) {
            $stmt = $pdo->prepare("UPDATE sliders SET position = ? WHERE slider_id = ?");
            $stmt->execute([$position, $slider_id]);
        }

        $successMessage = "Slider positions updated successfully.";
    } catch (Exception $e) {
        $errorMessage = "Error updating slider positions: " . $e->getMessage();
    }
}

?>

<section class="content-header">
    <h1>Slider Positioning</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Manage Slider Positions</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <form method="POST" action="slider_positioning.php">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Slider Title</th>
                            <th>Current Position</th>
                            <th>New Position</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sliders as $slider): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($slider['title']); ?></td>
                                <td><?php echo $slider['position']; ?></td>
                                <td>
                                    <input type="number" name="positions[<?php echo $slider['slider_id']; ?>]" value="<?php echo $slider['position']; ?>" min="1" class="form-control" required>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <button type="submit" name="update_positions" class="btn btn-primary">Update Positions</button>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
