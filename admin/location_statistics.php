<?php
require_once('header.php');

$errorMessage = "";
$locationCount = 0;
$regionStatistics = [];

try {
    // Fetch total count of locations
    $stmt = $pdo->query("SELECT COUNT(*) as total_locations FROM locations");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $locationCount = $result['total_locations'] ?? 0;

    // Fetch count of locations grouped by region
    $stmt = $pdo->query("SELECT region, COUNT(*) as count FROM locations GROUP BY region");
    $regionStatistics = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching location statistics: " . $e->getMessage();
}
?>

<section class="content-header">
    <h1>Location Statistics</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Overview</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <div class="statistics-section">
                <h4>Total Locations</h4>
                <p><?php echo htmlspecialchars($locationCount); ?></p>

                <h4>Locations by Region</h4>
                <?php if (!empty($regionStatistics)): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Region</th>
                                <th>Number of Locations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($regionStatistics as $stat): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($stat['region']); ?></td>
                                    <td><?php echo htmlspecialchars($stat['count']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No region statistics available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
