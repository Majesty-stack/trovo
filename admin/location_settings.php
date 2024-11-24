<?php
require_once('header.php');

$errorMessage = "";
$successMessage = "";

// Fetch current settings from the database (if applicable)
$settings = [];
try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM location_settings");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (Exception $e) {
    $errorMessage = "Error fetching location settings: " . $e->getMessage();
}

// Handle form submission for updating settings
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $default_region = trim($_POST['default_region']);
        $allow_location_editing = isset($_POST['allow_location_editing']) ? 1 : 0;

        // Update or insert settings in the database
        $settingsToUpdate = [
            'default_region' => $default_region,
            'allow_location_editing' => $allow_location_editing
        ];

        foreach ($settingsToUpdate as $key => $value) {
            $stmt = $pdo->prepare("REPLACE INTO location_settings (setting_key, setting_value) VALUES (:key, :value)");
            $stmt->execute(['key' => $key, 'value' => $value]);
        }

        $successMessage = "Location settings updated successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error updating location settings: " . $e->getMessage();
    }
}
?>

<section class="content-header">
    <h1>Location Settings</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Manage Location Settings</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <form method="post">
                <!-- Default Region Setting -->
                <div class="form-group">
                    <label for="default_region">Default Region</label>
                    <input type="text" class="form-control" id="default_region" name="default_region" value="<?php echo isset($settings['default_region']) ? htmlspecialchars($settings['default_region']) : ''; ?>" required>
                </div>

                <!-- Allow Location Editing -->
                <div class="form-group">
                    <label for="allow_location_editing">
                        <input type="checkbox" id="allow_location_editing" name="allow_location_editing" <?php echo (isset($settings['allow_location_editing']) && $settings['allow_location_editing'] == 1) ? 'checked' : ''; ?>>
                        Allow Location Editing
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
