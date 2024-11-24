<?php
require_once('header.php');

// Define how many recent records to display
$recentLimit = 10;

try {
    // Fetch recent activities from jobs, payments, and users
    $recentActivitiesQuery = "
        (SELECT 'Job Posted' AS activity_type, title AS description, created_at, 'job' AS source
         FROM jobs
         ORDER BY created_at DESC
         LIMIT $recentLimit)
         
        UNION ALL
         
        (SELECT 'Payment Completed' AS activity_type, CONCAT('Payment ID: ', payment_id, ' - Amount: ₦
', amount) AS description, transaction_date AS created_at, 'payment' AS source
         FROM payments
         WHERE status = 'completed'
         ORDER BY transaction_date DESC
         LIMIT $recentLimit)
         
        UNION ALL
         
        (SELECT 'User Registered' AS activity_type, CONCAT('User: ', name) AS description, created_at, 'user' AS source
         FROM users
         ORDER BY created_at DESC
         LIMIT $recentLimit)
         
        ORDER BY created_at DESC
        LIMIT $recentLimit
    ";

    $statement = $pdo->prepare($recentActivitiesQuery);
    $statement->execute();
    $recentActivities = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error fetching recent activities: " . $e->getMessage() . "</div>";
}

?>

<section class="content-header">
    <h1>Recent Activities</h1>
    <small>Overview of recent actions on the platform</small>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Recent Activities</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Activity Type</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recentActivities)): ?>
                        <?php foreach ($recentActivities as $activity): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($activity['activity_type']); ?></td>
                                <td><?php echo htmlspecialchars($activity['description']); ?></td>
                                <td><?php echo date('Y-m-d H:i:s', strtotime($activity['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No recent activities found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
