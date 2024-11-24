<?php
require_once('header.php'); // Database connection included here

$errorMessage = "";
$sliders = [];

try {
    // Fetch all sliders data
    $stmt = $pdo->query("SELECT slider_id, image_url, title, description, status FROM sliders");
    $sliders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching slider data: " . $e->getMessage();
}
?>

<section class="content-header">
    <h1>View Sliders</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Slider Overview</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($sliders)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Slider ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sliders as $slider): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($slider['slider_id']); ?></td>
                                <td><?php echo htmlspecialchars($slider['title']); ?></td>
                                <td><?php echo htmlspecialchars($slider['description']); ?></td>
                                <td>
                                    <img src="<?php echo htmlspecialchars($slider['image_url']); ?>" alt="<?php echo htmlspecialchars($slider['title']); ?>" style="width: 100px; height: auto;">
                                </td>
                                <td><?php echo htmlspecialchars($slider['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No sliders found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
