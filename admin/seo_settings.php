<?php
require_once('header.php');


// Initialize messages
$errorMessage = "";
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Gather form data
        $meta_title = $_POST['meta_title'];
        $meta_description = $_POST['meta_description'];
        $meta_keywords = $_POST['meta_keywords'];
        $og_title = $_POST['og_title'];
        $og_description = $_POST['og_description'];
        $robots_txt = $_POST['robots_txt'];

        // Update settings in the database
        $seoSettings = [
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'robots_txt' => $robots_txt,
        ];

        foreach ($seoSettings as $key => $value) {
            $updateStmt = $pdo->prepare("REPLACE INTO settings (setting_key, setting_value) VALUES (:key, :value)");
            $updateStmt->execute(['key' => $key, 'value' => $value]);
        }

        $successMessage = "SEO settings updated successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error updating SEO settings: " . $e->getMessage();
    }
}

// Fetch current SEO settings
$seoData = [];
try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $seoData[$row['setting_key']] = $row['setting_value'];
    }
} catch (Exception $e) {
    $errorMessage = "Error fetching SEO settings: " . $e->getMessage();
}

?>

<section class="content-header">
    <h1>SEO Settings</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit SEO Settings</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo $successMessage; ?></div>
            <?php endif; ?>

            <form method="post">
                <!-- Meta Title -->
                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title" 
                           value="<?php echo isset($seoData['meta_title']) ? htmlspecialchars($seoData['meta_title']) : ''; ?>" required>
                </div>

                <!-- Meta Description -->
                <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <textarea class="form-control" id="meta_description" name="meta_description" required><?php echo isset($seoData['meta_description']) ? htmlspecialchars($seoData['meta_description']) : ''; ?></textarea>
                </div>

                <!-- Meta Keywords -->
                <div class="form-group">
                    <label for="meta_keywords">Meta Keywords (comma-separated)</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                           value="<?php echo isset($seoData['meta_keywords']) ? htmlspecialchars($seoData['meta_keywords']) : ''; ?>" required>
                </div>

                <!-- Open Graph Title -->
                <div class="form-group">
                    <label for="og_title">Open Graph Title (for social media)</label>
                    <input type="text" class="form-control" id="og_title" name="og_title" 
                           value="<?php echo isset($seoData['og_title']) ? htmlspecialchars($seoData['og_title']) : ''; ?>">
                </div>

                <!-- Open Graph Description -->
                <div class="form-group">
                    <label for="og_description">Open Graph Description (for social media)</label>
                    <textarea class="form-control" id="og_description" name="og_description"><?php echo isset($seoData['og_description']) ? htmlspecialchars($seoData['og_description']) : ''; ?></textarea>
                </div>

                <!-- Robots.txt -->
                <div class="form-group">
                    <label for="robots_txt">Robots.txt</label>
                    <textarea class="form-control" id="robots_txt" name="robots_txt"><?php echo isset($seoData['robots_txt']) ? htmlspecialchars($seoData['robots_txt']) : "User-agent: *\nDisallow: /admin\n"; ?></textarea>
                    <small>Use this to control web crawler access. Default restricts access to the admin section.</small>
                </div>

                <button type="submit" class="btn btn-primary">Save SEO Settings</button>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
