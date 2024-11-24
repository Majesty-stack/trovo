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
    
    <link rel="stylesheet" href="signup.css">
   
    
</head>

<?php require_once('header.php');?>

<!-- Main Content (FORGOT PASSWORD) -->
<div class="gen-signup d-flex justify-content-center align-items-center">
    <div class="signup-box col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <h2 class="text-center">Sign Up As:</h2>
        <!-- Login Form -->
        <div class="signup-button">
            <div class="btn-skilled-wrk">
                <button onclick="window.location.href='./skilledWorkerSignup.php'" >Skilled Worker</h3>
                </button>
                
            </div>
            <div class="OR"><h4>OR</h4></div>
            <div class="btn-client">
                 <button onclick="window.location.href='./clientsignUp.php'" >Client</h3>
                </button>
            </div>

            <div class="btn-signup">
                <button><h3>Sign Up</h3>
                </button>
            </div>

            
            <div class="Acc">
                <p class="signup-prompt mt-3 text-center">Already have an account? <a href="login.php">Log In</a></p>
            </div>
            
        </div>
    </div>
</div>

<?php require_once('footer.php');?>
</body>
</html>