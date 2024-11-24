<?php
require_once('header.php');


// Initialize messages
$errorMessage = "";
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Gather form data
        $theme_color = $_POST['theme_color'];
        $font_style = $_POST['font_style'];

        // Update settings in the database
        $appearanceSettings = [
            'theme_color' => $theme_color,
            'font_style' => $font_style,
        ];

        foreach ($appearanceSettings as $key => $value) {
            $updateStmt = $pdo->prepare("REPLACE INTO settings (setting_key, setting_value) VALUES (:key, :value)");
            $updateStmt->execute(['key' => $key, 'value' => $value]);
        }

        // Handle background image upload
        if (!empty($_FILES['background_image']['name'])) {
            $imageDir = 'uploads/';
            $imagePath = $imageDir . basename($_FILES['background_image']['name']);
            move_uploaded_file($_FILES['background_image']['tmp_name'], $imagePath);

            // Save background image path in the database
            $updateImageStmt = $pdo->prepare("REPLACE INTO settings (setting_key, setting_value) VALUES ('background_image', :image)");
            $updateImageStmt->execute(['image' => $imagePath]);
        }

        $successMessage = "Appearance settings updated successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error updating appearance settings: " . $e->getMessage();
    }
}

// Fetch current appearance settings
$appearanceData = [];
try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $appearanceData[$row['setting_key']] = $row['setting_value'];
    }
} catch (Exception $e) {
    $errorMessage = "Error fetching appearance settings: " . $e->getMessage();
}

?>

<section class="content-header">
    <h1>Appearance Settings</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Appearance Settings</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo $successMessage; ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <!-- Theme Color -->
                <div class="form-group">
                    <label for="theme_color">Theme Color</label>
                    <input type="color" class="form-control" id="theme_color" name="theme_color" 
                           value="<?php echo isset($appearanceData['theme_color']) ? htmlspecialchars($appearanceData['theme_color']) : '#000000'; ?>" required>
                </div>

                <!-- Font Style -->
                <div class="form-group">
                    <label for="font_style">Font Style</label>
                    <select class="form-control" id="font_style" name="font_style" required>
                        <option value="Arial" <?php echo (isset($appearanceData['font_style']) && $appearanceData['font_style'] == 'Arial') ? 'selected' : ''; ?>>Arial</option>
                        <option value="Helvetica" <?php echo (isset($appearanceData['font_style']) && $appearanceData['font_style'] == 'Helvetica') ? 'selected' : ''; ?>>Helvetica</option>
                        <option value="Times New Roman" <?php echo (isset($appearanceData['font_style']) && $appearanceData['font_style'] == 'Times New Roman') ? 'selected' : ''; ?>>Times New Roman</option>
                        <option value="Courier New" <?php echo (isset($appearanceData['font_style']) && $appearanceData['font_style'] == 'Courier New') ? 'selected' : ''; ?>>Courier New</option>
                        <option value="Verdana" <?php echo (isset($appearanceData['font_style']) && $appearanceData['font_style'] == 'Verdana') ? 'selected' : ''; ?>>Verdana</option>
                    </select>
                </div>

                <!-- Background Image Upload -->
                <div class="form-group">
                    <label for="background_image">Background Image</label>
                    <input type="file" class="form-control" id="background_image" name="background_image">
                    <?php if (!empty($appearanceData['background_image'])): ?>
                        <p>Current Background Image:</p>
                        <img src="<?php echo htmlspecialchars($appearanceData['background_image']); ?>" alt="Background Image" style="max-height: 100px;">
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Save Appearance Settings</button>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
