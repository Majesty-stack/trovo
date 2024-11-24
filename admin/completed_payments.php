<?php
require_once('header.php'); // Database connection included here

$errorMessage = "";
$completedPayments = [];

try {
    // Fetch all completed payments
    $stmt = $pdo->query("SELECT * FROM payments WHERE status = 'completed'");
    $completedPayments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching completed payments: " . $e->getMessage();
}
?>

<section class="content-header">
    <h1>Completed Payments</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">List of Completed Payments</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($completedPayments)): ?>
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
                        <?php foreach ($completedPayments as $payment): ?>
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
                <p>No completed payments found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
