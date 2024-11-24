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
    <link rel="stylesheet" href="index.css">
</head>



    <?php require_once('header.php');?>
    
    <!-- Hero Section for Desktop -->
<section class="hero-section hero-section-desktop">
    <div class="hero-text-container">
        <h2 class="break-text">Connect with top skilled professionals to meet your needs.</h2>
        <div class="search-bar mt-3">
            <input type="text" class="form-control search-input" placeholder="Find skilled worker...">
            <button class="btn btn-primary search-btn"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <img src="assets/Ellipse 7.png" alt="Hero Image" class="hero-image">
</section>

<!-- Hero Section for Mobile -->

<section class="hero-section hero-section-mobile position-relative">

    <div class="curve-top"></div>
    <div class="hero-text-container">
        <h2 >Connect with top skilled professionals to meet your needs.</h2>

        <div class="search-bar mt-3">
            <input type="text" class="form-control search-input" placeholder="Find skilled worker...">
            <button class="btn btn-primary search-btn"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <div class="curve-bottom"></div>
</section>


    

    <!-- Available Services Section in Columns on Mobile -->
    <section class="services py-5 text-left">
        <div class="container">
            <h3 class="mb-4">Available Services</h3>
            <div class="row">
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="service-card p-4 shadow-sm">
                        <p class="font-weight-bold">Artisans</p>
                        <img src="assets/Rectangle 6.png" alt="Artisans" class="mb-3">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="service-card p-4 shadow-sm">
                        <p class="font-weight-bold">IT Professional</p>
                        <img src="assets/Group 18.png" alt="IT Professional" class="mb-3">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="service-card p-4 shadow-sm">
                        <p class="font-weight-bold">Construction Workers</p>
                        <img src="assets/Worker.png" alt="Construction Workers" class="mb-3">
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <!-- How It Works Section -->
    <section class="how-it-works">
        <h2 class="section-title">How It Works</h2>
        <div class="work-steps-container">
            <div class="work-step">
                <img src="assets/Rectangle 16.png" alt="Post a Job" class="step-image">
                <a href=""><h3>Post a Job</h3></a>
            </div>
            <div class="work-step">
                <img src="assets/Rectangle 17.png" alt="Connect with Skilled Expert" class="step-image">
                <a href=""><h3>Connect Experts</h3></a>
            </div>
            <div class="work-step">
                <img src="assets/Rectangle 18.png" alt="Get Work Done" class="step-image">
                <a href=""><h3>Get Work Done</h3></a>
            </div>
            <div class="work-step">
                <img src="assets/Rectangle 19.png" alt="Get Paid" class="step-image">
                <a href=""><h3>Get Paid</h3></a>
            </div>
        </div>
    </section>
    
    
    
    <!-- Categories Section -->
    <section class="categories-section">
        <h2 class="section-title">Categories</h2>
        <div class="categories-container">
            <div class="category-column">
                <p>Carpenters</p>
                <p>Plumbers</p>
                <p>Electricians</p>
                <p>Mechanic</p>
                <p>Painters</p>
                <p>Fashion Designing</p>
                <p>Welders</p>
                <p>Jewelry Maker</p>
                <p>Furniture</p>
                <p>Cobbler</p>
            </div>
            <div class="category-column">
                <p>Software Engineer</p>
                <p>Data Scientist</p>
                <p>Cyber Security</p>
                <p>Web Developer</p>
                <p>Product Designer</p>
                <p>DevOps Engineers</p>
                <p>Cloud Computing</p>
                <p>Product Managers</p>
                <p>Game Developer</p>
                <p>AI/ML Engineer</p>
            </div>
            <div class="category-column">
                <p>Architect</p>
                <p>Engineers</p>
                <p>Roofers</p>
                <p>Drywall Installer</p>
                <p>Iron Workers</p>
                <p>Tile Setters</p>
                <p>Insulation Worker</p>
                <p>Surveyor Assistant</p>
                <p>Scaffold Builder</p>
            </div>
        </div>
    </section>
    
 <!-- about us Section -->
<section class="aboutUs" id="about-us"> 
        <h2 class="section-title">About Us</h2>
        <div class="about-container">
            <div class="infoaboutus" id="infoAb">
                <p>At Trovoria, we bridge the gap between talented professionals and clients seeking reliable services. Our Mission is top create a thriving ecosytem where skilled workers can showcase their expertise whiles clients enjoy seamless access to trusted services.
                    We aim to  connect client with verified and trusted professionals across various industries, provide a platform for skilled workers to grow their careers and build credibility.</p>
            </div>
        </div>
</section>
    

    <!-- Why Trovoria Section with Bottom Border -->
    <section class="why-trovoria py-5 text-center bg-light">
        <div class="container">
            <h3 class="mb-4">Why Trovoria</h3>
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="feature">
                        <img src="assets/Thumbs Up.png" alt="Quality Work" class="mb-2">
                        <p>Quality work</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="feature">
                        <img src="assets/Approval.png" alt="Verified Freelancers" class="mb-2">
                        <p>Verified Freelancers</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="feature">
                        <img src="assets/Card Payment.png" alt="Secure Payment" class="mb-2">
                        <p>Secure Payment</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="feature">
                        <img src="assets/Innovation-removebg-preview.png" alt="Professional Workers" class="mb-2">
                        <p>Professional Workers</p>
                    </div>
                </div>
            </div>
            <button class="btn btn-custom mt-3">Sign Up</button>

        </div>
    </section>

    <!-- Heavy Divider Line Below Why Trovoria Section -->
    <div class="section-divider"></div>

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

    <?php require_once ('footer.php');?>
</body>
</html>