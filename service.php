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
    <link rel="stylesheet" href="services.css">
</head>

<?php require_once('header.php');?>

 <!-- Available Services Section in Columns on Mobile -->
 <section class="services py-5 text-left">
    <div class="container">
        <h3 class="mb-4 text-center">Our Professional Services</h3>
        <p class="text-center mb-5">We connect you with highly skilled professionals in various industries to ensure your needs are met with quality and efficiency. Explore our services below:</p>

            <div class="service-card p-4 shadow-sm">
                <img src="assets/Rectangle 6.png" alt="Artisans" class="mb-3">
                <h5 class="font-weight-bold">Artisans</h5>
                <p>Skilled professionals for your craft and design needs, ensuring high-quality results.</p>
                <button class="btn-custom mt-3">Learn More</button>
            </div>

            <div class="service-card p-4 shadow-sm text-center">
                <img src="assets/group 18.png" alt="IT Professionals" class="mb-3 mx-auto">
                <h5 class="font-weight-bold mt-3">IT Professionals</h5>
                <p>Expert IT support for your technical challenges, ensuring smooth and secure operations.</p>
                <button class="btn-custom mt-3">Learn More</button>
            </div>

            <div class="service-card p-4 shadow-sm text-center">
                <img src="assets/worker.png" alt="Construction Workers" class="mb-3 mx-auto">
                <h5 class="font-weight-bold mt-3">Construction Workers</h5>
                <p>Experienced workers for your building projects, delivering quality craftsmanship on time.</p>
                <button class="btn-custom mt-3">Learn More</button>
            </div>

    </section>

<section class="cta py-5 text-center bg-primary text-white">
    <div class="container">
        <h3 class="mb-3">Ready to Get Started?</h3>
        <p>Contact us today and let’s connect you with the right professionals for your needs!</p>
        <button class="btn-custom mt-3">Contact Us</button>
    </div>
</section>


<footer class="footer py-5 text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Subscribe</h5>
                <form>
                    <input type="email" placeholder="Enter your email" class="form-control mb-2">
                    <button class="btn-custom">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</footer>


<?php require_once ('footer.php');?>