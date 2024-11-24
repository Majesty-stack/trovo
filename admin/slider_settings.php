<?php
require_once('header.php'); // Database connection included here

$errorMessage = "";
$successMessage = "";

// Fetch sliders from the database
try {
    $stmt = $pdo->query("SELECT * FROM sliders");
    $sliders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching sliders: " . $e->getMessage();
}

// Handle status change (active/inactive)
if (isset($_GET['action'], $_GET['slider_id'])) {
    $action = $_GET['action'];
    $slider_id = (int)$_GET['slider_id'];

    if ($action === 'activate' || $action === 'deactivate') {
        try {
            $status = ($action === 'activate') ? 'active' : 'inactive';
            $stmt = $pdo->prepare("UPDATE sliders SET status = ? WHERE slider_id = ?");
            $stmt->execute([$status, $slider_id]);
            $successMessage = "Slider status updated successfully.";
        } catch (Exception $e) {
            $errorMessage = "Error updating slider status: " . $e->getMessage();
        }
    }
}

?>

<section class="content-header">
    <h1>Slider Settings</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Manage Sliders</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Slider Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sliders as $slider): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($slider['title']); ?></td>
                            <td><?php echo htmlspecialchars($slider['description']); ?></td>
                            <td>
                                <?php echo $slider['status'] === 'active' ? 'Active' : 'Inactive'; ?>
                            </td>
                            <td>
                                <?php if ($slider['status'] === 'active'): ?>
                                    <a href="slider_settings.php?action=deactivate&slider_id=<?php echo $slider['slider_id']; ?>" class="btn btn-warning">Deactivate</a>
                                <?php else: ?>
                                    <a href="slider_settings.php?action=activate&slider_id=<?php echo $slider['slider_id']; ?>" class="btn btn-success">Activate</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
