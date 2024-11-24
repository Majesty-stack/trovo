<?php
require_once('header.php'); // Database connection included here

$errorMessage = "";
$refundsAdjustments = [];

try {
    // Fetch all refunded payments with their adjustment details
    $stmt = $pdo->query("SELECT payment_id, job_id, client_id, worker_id, location_id, amount, status, payment_method, transaction_date
                         FROM payments 
                         WHERE status = 'refunded'");
    $refundsAdjustments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching refunds and adjustments: " . $e->getMessage();
}
?>

<section class="content-header">
    <h1>Refunds and Adjustments</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Refunds and Adjustments Overview</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($refundsAdjustments)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Job ID</th>
                            <th>Client ID</th>
                            <th>Worker ID</th>
                            <th>Location ID</th>
                            <th>Amount Refunded</th>
                            <th>Payment Method</th>
                            <th>Transaction Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($refundsAdjustments as $refund): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($refund['payment_id']); ?></td>
                                <td><?php echo htmlspecialchars($refund['job_id']); ?></td>
                                <td><?php echo htmlspecialchars($refund['client_id']); ?></td>
                                <td><?php echo htmlspecialchars($refund['worker_id']); ?></td>
                                <td><?php echo htmlspecialchars($refund['location_id']); ?></td>
                                <td><?php echo htmlspecialchars($refund['amount']); ?></td>
                                <td><?php echo htmlspecialchars($refund['payment_method']); ?></td>
                                <td><?php echo htmlspecialchars($refund['transaction_date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No refunds or adjustments found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
