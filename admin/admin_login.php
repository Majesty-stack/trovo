<?php
// Start output buffering and session management
ob_start();
session_start();

// Include necessary files
include("inc/config.php");  // Database connection
include("inc/functions.php");  // Helper functions
include("inc/CSRF_Protect.php");  // CSRF protection

$csrf = new CSRF_Protect();  // Initialize CSRF protection
$error_message = '';  // Initialize error message

// Check if the form is submitted
if (isset($_POST['form1'])) {
    // Validate email and password inputs
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error_message = 'Email and Password cannot be empty.<br>';
    } else {
        $email = strip_tags($_POST['email']);  // Sanitize email input
        $password = strip_tags($_POST['password']);  // Sanitize password input

        // Query the Users table for the given email and active status
        $statement = $pdo->prepare("SELECT * FROM Users WHERE email = ? AND status = 'active'");
        $statement->execute([$email]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $error_message .= 'Email address not found or account inactive.<br>';
        } else {
            // Verify the password using password_verify()
            if (!password_verify($password, $user['password_hash'])) {
                $error_message .= 'Incorrect password.<br>';
            } else {
                // Check if the user has the 'admin' role
                if ($user['role'] !== 'admin') {
                    $error_message .= 'Access denied. Admins only.<br>';
                } else {
                    // Set session and redirect to the admin dashboard
                    $_SESSION['user'] = $user;
                    header("Location: index.php");
                    exit();
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Login</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/AdminLTE.min.css">
    <link rel="stylesheet" href="css/_all-skins.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="hold-transition login-page sidebar-mini">
    <div class="login-box">
        <div class="login-logo">
            <b>Admin Panel</b>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Log in to start your session</p>

            <?php if (!empty($error_message)): ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form action="" method="post">
                <?php $csrf->echoInputField(); ?>
                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" placeholder="Email address" autocomplete="off" autofocus>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off">
                </div>
                <div class="row">
                    <div class="col-xs-8"></div>
                    <div class="col-xs-4">
                        <input type="submit" class="btn btn-success btn-block btn-flat" name="form1" value="Log In">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery-2.2.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
