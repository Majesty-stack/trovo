<?php
require_once('header.php');

// Initialize error and success messages
$errorMessage = "";
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Validate input data
        $site_name = trim($_POST['site_name']);
        $site_description = trim($_POST['site_description']);
        $contact_email = trim($_POST['contact_email']);
        $contact_phone = trim($_POST['contact_phone']);

        if (empty($site_name) || empty($site_description) || empty($contact_email) || empty($contact_phone)) {
            throw new Exception("All fields are required.");
        }

        if (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }

        // Update settings in the database
        $settings = [
            'site_name' => $site_name,
            'site_description' => $site_description,
            'contact_email' => $contact_email,
            'contact_phone' => $contact_phone,
        ];

        foreach ($settings as $key => $value) {
            $updateStmt = $pdo->prepare("REPLACE INTO settings (setting_key, setting_value) VALUES (:key, :value)");
            $updateStmt->execute(['key' => $key, 'value' => $value]);
        }

        // Handle logo upload
        if (!empty($_FILES['logo']['name'])) {
            $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $logoDir = 'uploads/';
            $logoPath = $logoDir . basename($_FILES['logo']['name']);
            $fileType = mime_content_type($_FILES['logo']['tmp_name']);

            if (!in_array($fileType, $allowedFileTypes)) {
                throw new Exception("Invalid file type. Only JPG, PNG, and GIF files are allowed.");
            }

            if (!move_uploaded_file($_FILES['logo']['tmp_name'], $logoPath)) {
                throw new Exception("Failed to upload logo.");
            }

            // Save logo path in the database
            $updateLogoStmt = $pdo->prepare("REPLACE INTO settings (setting_key, setting_value) VALUES ('logo_url', :logo)");
            $updateLogoStmt->execute(['logo' => $logoPath]);
        }

        $successMessage = "Settings updated successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error updating settings: " . $e->getMessage();
    }
}

// Fetch current settings
$settingsData = [];
try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $settingsData[$row['setting_key']] = $row['setting_value'];
    }
} catch (Exception $e) {
    $errorMessage = "Error fetching settings: " . $e->getMessage();
}

?>

<section class="content-header">
    <h1>General Settings</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit General Settings</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <!-- Site Name -->
                <div class="form-group">
                    <label for="site_name">Site Name</label>
                    <input type="text" class="form-control" id="site_name" name="site_name" 
                           value="<?php echo isset($settingsData['site_name']) ? htmlspecialchars($settingsData['site_name']) : ''; ?>" required>
                </div>

                <!-- Site Description -->
                <div class="form-group">
                    <label for="site_description">Site Description</label>
                    <textarea class="form-control" id="site_description" name="site_description" required><?php echo isset($settingsData['site_description']) ? htmlspecialchars($settingsData['site_description']) : ''; ?></textarea>
                </div>

                <!-- Contact Email -->
                <div class="form-group">
                    <label for="contact_email">Contact Email</label>
                    <input type="email" class="form-control" id="contact_email" name="contact_email" 
                           value="<?php echo isset($settingsData['contact_email']) ? htmlspecialchars($settingsData['contact_email']) : ''; ?>" required>
                </div>

                <!-- Contact Phone -->
                <div class="form-group">
                    <label for="contact_phone">Contact Phone</label>
                    <input type="text" class="form-control" id="contact_phone" name="contact_phone" 
                           value="<?php echo isset($settingsData['contact_phone']) ? htmlspecialchars($settingsData['contact_phone']) : ''; ?>" required>
                </div>

                <!-- Logo Upload -->
                <div class="form-group">
                    <label for="logo">Logo</label>
                    <input type="file" class="form-control" id="logo" name="logo">
                    <?php if (!empty($settingsData['logo_url'])): ?>
                        <p>Current Logo:</p>
                        <img src="<?php echo htmlspecialchars($settingsData['logo_url']); ?>" alt="Logo" style="max-height: 100px;">
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
