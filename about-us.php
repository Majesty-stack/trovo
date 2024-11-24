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
    <link rel="stylesheet" href="about-us.css">
</head>



    <?php require_once('header.php');?>

     
 <!-- About Us Section -->
<section class="aboutUs" id="about-us"> 
    <div class="container">
        <h2 class="section-title text-center mb-4">About Us</h2>
        <div class="row align-items-center">
            <!-- Mission and Vision Section -->
            <div class="col-md-6">
                <h3 class="text-primary mb-3">Our Mission</h3>
                <p>At Trovoria, we bridge the gap between talented professionals and clients seeking reliable services. 
                   Our mission is to create a thriving ecosystem where skilled workers showcase their expertise while 
                   clients enjoy seamless access to trusted services.</p>
                <h3 class="text-primary mt-4 mb-3">Our Vision</h3>
                <p>To be the global leader in connecting professionals with opportunities, fostering growth, 
                   and enabling individuals and businesses to thrive through trustworthy partnerships.</p>
            </div>

            <!-- Values Section with Icons -->
            <div class="col-md-6">
                <h3 class="text-primary mb-3">Our Values</h3>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-center">
                        <i class="fas fa-check-circle text-success mr-2"></i>
                        <span>Reliability: Ensuring consistent quality in every interaction.</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="fas fa-users text-info mr-2"></i>
                        <span>Collaboration: Building strong, lasting partnerships.</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="fas fa-lightbulb text-warning mr-2"></i>
                        <span>Innovation: Staying ahead with creative solutions.</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="fas fa-shield-alt text-primary mr-2"></i>
                        <span>Integrity: Upholding transparency and ethical standards.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

 <!-- Improved Footer Section -->
 <footer class="footer py-4 text-center text-white">
        <div class="container">
            <h3 class="h5 mb-3">Trovoria</h3>
            <p>Connecting you with top professionals to meet your needs.</p>
            <div class="social-icons mb-3">
                <a href="#" class="mr-3"><i class="fab fa-instagram fa-lg"></i></a>
                <a href="#" class="mr-3"><i class="fab fa-facebook fa-lg"></i></a>
                <a href="#" class="mr-3"><i class="fab fa-tiktok fa-lg"></i></a>
                <a href="#" class="mr-3"><i class="fas fa-globe fa-lg"></i></a>
                <a href="#" class="mr-3"><i class="fab fa-linkedin fa-lg"></i></a>
            </div>
            <small>&copy; 2024 Trovoria. All rights reserved.</small>
        </div>
    </footer>   
<?php require_once("footer.php");?>