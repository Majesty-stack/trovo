<?php
require_once('header.php'); // Database connection included here

$errorMessage = "";
$paymentMethods = [];

try {
    // Fetch all distinct payment methods
    $stmt = $pdo->query("SELECT DISTINCT payment_method FROM payments");
    $paymentMethods = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching payment methods: " . $e->getMessage();
}
?>

<section class="content-header">
    <h1>Payment Methods</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">List of Payment Methods</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($paymentMethods)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Payment Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paymentMethods as $method): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($method['payment_method']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No payment methods found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
