<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trovoria</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="accverified.css">
</head>
<body>
<?php
session_start(); // Start the session

// Retrieve the user's email from the session
$userEmail = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'No email found in session';

?>

<div class="accver-container d-flex justify-content-center align-items-center">
    <div class="accverBox col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <div class="ver">
            <img src="assets/opened envelope.png" alt="Account Verified">
            <h2>Account Verified</h2>
            <div class="congWriteup">
                <p>Congratulations! Your email account 
                    <span id="emailinputed"><?php echo htmlspecialchars($userEmail); ?></span> 
                    has been verified.
                </p>
            </div>
            <button class="continue" onclick="window.location.href='login.php'">
                <p>Continue to your account</p>
            </button>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
</body>
</html>
