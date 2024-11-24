<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trovoria</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Hamburger Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="login.css">
</head>


<body>
<?php
session_start();
require_once('header.php');
// Ensure database connection


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        echo "<div class='alert alert-danger text-center'>Please fill in both fields.</div>";
    } else {
        try {
            // Prepare statement
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];

                // Redirect based on user role
                if ($user['role'] === 'client') {
                    header("Location: clientDashboard.php");
                    exit();
                } elseif ($user['role'] === 'skilled_worker') {
                    header("Location: skilledWorkerDash.php");
                    exit();
                } else {
                    header("Location: defaultDashboard.php");
                    exit();
                }
            } else {
                echo "<div class='alert alert-danger text-center'>Invalid email or password.</div>";
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger text-center'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }
}
?>
<!-- Main Content (Login Form) -->
<div class="login-container d-flex justify-content-center align-items-center">
    <div class="login-box col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <h2 class="text-center">Welcome Back</h2>
        <p class="text-center">Enter your details to login.</p>

        <!-- Social Login Buttons -->
        <div class="social-login d-flex justify-content-center mb-3">
            <a href="#" class="social-btn apple mx-2"><i class="fab fa-apple"></i></a>
            <a href="#" class="social-btn google mx-2">
                <!-- Multi-colored Google SVG icon -->
                <svg class="google-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48">
                    <path fill="#4285F4" d="M24 9.5c1.5 0 2.9.2 4.2.6l3.4-3.4C28.6 5.8 26.4 5 24 5c-5.2 0-9.7 3-11.9 7.3l4 3.1c1.4-2.7 4.2-4.9 7.9-4.9z"/>
                    <path fill="#34A853" d="M24 44c3.6 0 6.5-1.2 8.7-3.3l-4-3.2c-1.2.8-2.7 1.3-4.7 1.3-4.4 0-8.2-3-9.5-7l-4.1 3.2C13.9 39 18.5 44 24 44z"/>
                    <path fill="#FBBC05" d="M43 24c0-1.2-.1-2.4-.4-3.5H24v7h11.1c-.5 2.4-1.9 4.4-3.9 5.7l4 3.2C38.4 33.7 43 29.4 43 24z"/>
                    <path fill="#EA4335" d="M14.5 27.1c-.4-1.2-.6-2.4-.6-3.6s.2-2.5.6-3.6l-4.1-3.2C9.6 19.4 9 21.6 9 24s.6 4.6 1.4 6.6l4.1-3.5z"/>
                </svg>
            </a>
            <a href="#" class="social-btn twitter mx-2"><i class="fab fa-twitter"></i></a>
        </div>

        <div class="divider">or</div>

        <!-- Login Form -->
        <form method="post">
            <div class="form-group">
                <label for="email">E-Mail Address</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email..." required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
            </div>

            <div class="login-options d-flex justify-content-between align-items-center mb-3">
                <label><input type="checkbox"> Remember me</label>
                <a href="forgotPassword.php" class="forgot-password">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-success btn-block signin-button">Sign In</button>
        </form>

        <p class="signup-prompt mt-3 text-center">Don't have an account yet? <a href="Signup.php">Sign Up</a></p>
    </div>
</div>

<?php require_once('footer.php'); ?>
</body>
</html>
