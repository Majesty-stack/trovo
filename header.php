<!-- This is main configuration File -->
<?php
ob_start();
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
include("admin/inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

?>
<div id="sidebar" class="sidebar">
    
    <a href="index.php">Home</a>
    <a href="service.php">Services</a>
    <a href="categories.php">Categories</a>
    <a href="about-us.php">About Us</a>
    <a href="login.php">Log in</a>
    <a href="signup.php" class="sign-up-link">Sign Up</a>
</div>
<div id="overlay" class="overlay" onclick="closeSidebar()"></div>


    <!-- Header Section with Hamburger for Desktop and Mobile -->
   <header class="header bg-white text-dark">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Hamburger Icon for Both Desktop and Mobile -->
       
        <button class="navbar-toggler" onclick="toggleSidebar()">☰</button>

        <!-- Centered Logo -->
        <a href="#" class="navbar-brand mx-auto d-flex align-items-center">
            <img src="assets/Ellipse 4.png" alt="Trovoria Logo" class="logo-image mr-2">
            
        </a>
        <nav class="navigation d-none d-md-flex ml-auto">
            <a href="index.php" class="mr-3">Home</a>
            <a href="service.php" class="mr-3">Services</a>
            <a href="categories.php" class="mr-3">Categories</a>
            <a href="about-us.php" class="mr-3">About</a>
            <a href="login.php" class="mr-3">Log in</a>
        </nav>
        
        <!-- Sign-Up Button for Desktop -->
        <a href="Signup.php" class="btn btn-primary sign-up-btn d-none d-md-inline-block">Sign Up</a> <!-- Desktop -->
    </div>
</header>

