<?php
require_once('header.php');

// Initialize variables
$verificationMessage = "";
$userVerified = false;
$errorMessage = "";

// Check if the verification token is passed via the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    try {
        // Find the user by the token in the database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE verification_token = :token AND status = 'inactive'");
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user exists and the token matches
        if ($user) {
            // Update user status to 'active' and set the verification token to NULL
            $updateStmt = $pdo->prepare("UPDATE users SET status = 'active', verification_token = NULL WHERE user_id = :user_id");
            $updateStmt->bindParam(':user_id', $user['user_id'], PDO::PARAM_INT);
            $updateStmt->execute();

            $userVerified = true;
            $verificationMessage = "Your account has been successfully verified!";
        } else {
            $errorMessage = "Invalid or expired verification link.";
        }
    } catch (Exception $e) {
        $errorMessage = "An error occurred while verifying your account. Please try again later.";
    }
} else {
    $errorMessage = "No verification token provided.";
}

?>

<section class="content-header">
    <h1>Account Verification</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Verification Status</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php elseif ($userVerified): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($verificationMessage); ?></div>
            <?php else: ?>
                <p>Please check the link sent to your email for verification.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
