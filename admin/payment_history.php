<?php
require_once('header.php');

$errorMessage = "";
$paymentCount = 0;
$paymentStatistics = [];

try {
    // Fetch total count of payments
    $stmt = $pdo->query("SELECT COUNT(*) as total_payments FROM payments");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $paymentCount = $result['total_payments'] ?? 0;

    // Fetch count of payments grouped by month (or by status if you prefer)
    $stmt = $pdo->query("SELECT DATE_FORMAT(transaction_date, '%Y-%m') as month, COUNT(*) as count FROM payments GROUP BY month ORDER BY month DESC");
    $paymentStatistics = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching payment history: " . $e->getMessage();
}
?>

<section class="content-header">
    <h1>Payment History</h1>
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
                <h4>Total Payments</h4>
                <p><?php echo htmlspecialchars($paymentCount); ?></p>

                <h4>Payments by Month</h4>
                <?php if (!empty($paymentStatistics)): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Number of Payments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paymentStatistics as $stat): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($stat['month']); ?></td>
                                    <td><?php echo htmlspecialchars($stat['count']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No payment statistics available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
