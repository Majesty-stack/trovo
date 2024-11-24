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
    
    <link rel="stylesheet" href="skilledAccount.css">
</head>



<?php require_once('header.php') ;?>

<div class="contentsap d-flex justify-content-center align-items-center ">
    <div class="profhead col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4 ">
        <button id="backButton" class="backButton">
            <img src="assets/Back Arrow.svg" alt="" srcset="">
        </button><h2 class="text-center1">Account profile</h2>
    </div>
</div>

<!-- Main Content (Account profile) -->
<div class="setAccProf d-flex justify-content-center align-items-center">
    <div class="accbox col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <img src="assets/Approval.png" class="accimg" alt="" srcset="">
        <h2 class="text-center"><strong>Bio</strong></h2>
        <!-- account info -->
        <div class="information">
            <div class="personalInfo">
                <p class="firstN">First Name</p><span id="fetchedFN">Tosin</span>
            </div>

            <div class="personalInfo">
                <p class="lastN">Last Name</p><span id="fetchedLN">Tope</span>
            </div>

            <div class="personalInfoEm">
                <p class="emailAdd">Email Address</p><span id="fetchedEM">tt@member.com</span>
            </div>
            
            <div class="businessinfo"><h2><strong>Business Info</strong></h2></div>

            <div class="businf1">
                <p class="industry">Industry Type</p>
                <select id="industries-available">
                <option value=""></option>
                <option value="Construction">Construction</option>
                <option value="Manufacturing">Manufacturing</option>
                <option value="Hardwares">Hardwares</option>
                <option value="Automotive">Automotive</option>
                <option value="Logistics">Logistics</option>
                <option value="Home Decoration">Home Decoration</option>
                <option value="Installations">Installations</option>
                <option value="Repairs">Repairs</option>
                <option value="Maintainance">Maintainers</option>
                <option value="Information Technology">Information Technology</option>
                <option value="Forestry">Forestry</option>
                <option value="Beauty and Wellness">Beauty and Wellness</option>
                <option value="Fashion Industry">Fashion Industry</option>
                <option value="Creative Services">Creative Services</option>
                </select>
            </div>

            <div class="businf2">
                <p class="skills">Skills</p>
                <select id="skills-available">
                <option value=""></option>
                <option value="Capenter">Capenter</option>
                <option value="Plumber">Plumber</option>
                <option value="Electrician">Electrician</option>
                <option value="Mechanic">Mechanic</option>
                <option value="Painter">Painter</option>
                <option value="Fashion Designer">Fashion Designer</option>
                <option value="Welder">Welder</option>
                <option value="Jewelry Maker">Jewelry Maker</option>
                <option value="Cobbler">Cobbler</option>
                <option value="Electronic Repairs">Electronic Repairs</option>
                <option value="Software Engineer">Software Engineer</option>
                <option value="Data Scientist">Data Scientist</option>
                <option value="Cyber Security">Cyber Security</option>
                <option value="Web Developer">Web Developer</option>
                <option value="Product Designer">Product Designer</option>
                <option value="DevOps Engineer">DevOps Engineer</option>
                <option value="Cloud Computing">Cloud Computing</option>
                <option value="Product Manager">Product Manager</option>
                <option value="Game Developer">Game Developer</option>
                <option value="AI/ML Engineer">AI/ML Engineer</option>
                <option value="Graphic Designer">Graphic Designerx</option>
                <option value="Makeup Artist">Makeup Artist</option>
                <option value="Event Planner">Event Planner</option>
                </select>
            </div>

            <div class="businf3">
                <p class="Experience">Experience</p>
                <select id="list-of-exp">
                    <option value=""></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value=">10">>10</option>
                </select>
            </div>

            <div class="businf4">
                <p class="AvailableStat">Availability Status</p>
                <select id="list-of-av">
                    <option value=""></option>
                    <option value="Available"> Available</option>
                    <option v
                    alue="Not Available">Not AVailable</option>
                </select>
            </div>
            
            <button class="Saveinfo"><p>Save</p></button>
            
        </div>
    </div>
</div>

<!-- Custom JavaScript for Sidebar Toggle and Form Validation -->


<?php require_once('footer.php');?>

</body>
</html>