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
    
    <link rel="stylesheet" href="forgotPassword.css">
   
    
</head>

<?php require_once('header.php');?>

<!-- Main Content (FORGOT PASSWORD) -->
<div class="forgot-password d-flex justify-content-center align-items-center">
    <div class="password-box col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <h2 class="text-center">Forgot password?</h2>
        <!-- Login Form -->
        <div class="send-button">
            <div class="buttonemail">
                <button><div class="img"><img src="assets/mail.png" alt="email"></div><div class="sendIt"><h3>Send via Email</h3>
                <p>Resend password via Email</p></div>
                </button>
            </div>
            <div class="buttongoogle">
                <button><div class="img"><img src="assets/Icon.png" alt="email"></div><div class="sendIt"><h3>Send via Google Auth</h3>
                <p>Resend password via G-auth</p></div>
                </button>
            </div>

            <div class="buttonsms">
                <button><div class="img"><img src="assets/SMS.png" alt="email"></div><div class="sendIt"><h3>Send via SMS</h3>
                <p>Resend password via SMS</p></div>
                </button>
            </div>

            <div class="buttonreset">
                <button type="reset" class="reset"><h3>Reset Password</h3>
                </button>
            </div>

            
            <div class="noAcc">
                <p class="signup-prompt mt-3 text-center">Don't have an account yet? <a href="Signup.php">Sign Up</a></p>
            </div>
            
        </div>
    </div>
</div>

<?php require_once ('footer.php');?>
</body>
</html>