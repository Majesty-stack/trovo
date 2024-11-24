<?php
require_once('header.php'); // Database connection included here

$errorMessage = "";
$pendingPayments = [];

try {
    // Fetch all pending payments
    $stmt = $pdo->query("SELECT * FROM payments WHERE status = 'pending'");
    $pendingPayments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching pending payments: " . $e->getMessage();
}
?>

<section class="content-header">
    <h1>Pending Payments</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">List of Pending Payments</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($pendingPayments)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Job ID</th>
                            <th>Client ID</th>
                            <th>Worker ID</th>
                            <th>Location ID</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Transaction Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingPayments as $payment): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($payment['payment_id']); ?></td>
                                <td><?php echo htmlspecialchars($payment['job_id']); ?></td>
                                <td><?php echo htmlspecialchars($payment['client_id']); ?></td>
                                <td><?php echo htmlspecialchars($payment['worker_id']); ?></td>
                                <td><?php echo htmlspecialchars($payment['location_id']); ?></td>
                                <td><?php echo htmlspecialchars($payment['amount']); ?></td>
                                <td><?php echo htmlspecialchars($payment['payment_method']); ?></td>
                                <td><?php echo htmlspecialchars($payment['transaction_date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No pending payments found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
