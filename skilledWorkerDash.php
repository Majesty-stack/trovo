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
    <link rel="stylesheet" href="skilledAccountprofile.css">
</head>

<?php
// Include the database connection
require_once('header.php');

// Initialize variables for skilled worker information
$user = [];

try {
    // Assume the user ID is passed via session or GET for the skilled worker
    $user_id = $_SESSION['user_id'] ?? null;

    if ($user_id) {
        // Fetch user information
        $stmt = $pdo->prepare("
            SELECT 
                u.name, 
                u.email, 
                u.image, 
                u.available, 
                l.location_name AS location, 
                c.category_name, 
                s.skill, 
                e.years_of_exprience 
            FROM users u
            LEFT JOIN skills s ON u.skill_id = s.skill_id
            LEFT JOIN experiences e ON u.Exprience_id = e.Exprience_id
            LEFT JOIN locations l ON u.location = l.location_id
            LEFT JOIN categories c ON u.Specialization = c.category_name
            WHERE u.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error fetching data: " . $e->getMessage() . "</div>";
}
?>

<div class="contentsap d-flex justify-content-center align-items-center">
    <div class="profhead col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <button id="backButton" class="backButton">
            <img src="assets/Back Arrow.svg" alt="" srcset="">
        </button>
        <h2 class="text-center1">Account Profile</h2>
    </div>
</div>

<!-- Main Content (Account profile) -->
<div class="setAccProf d-flex justify-content-center align-items-center">
    <div class="accbox col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <!-- Display user profile image -->
        <img src="<?= htmlspecialchars($user['image'] ?? 'assets/default-profile.png') ?>" class="accimg" alt="Profile Image">
        <h2 class="text-center"><strong>Bio</strong></h2>
        <!-- Account info -->
        <div class="information">
            <div class="personalInfo">
                <p class="firstN">Full Name</p>
                <span id="fetchedFN"><?= htmlspecialchars($user['name'] ?? 'N/A') ?></span>
            </div>

            <div class="personalInfoEm">
                <p class="emailAdd">Email Address</p>
                <span id="fetchedEM"><?= htmlspecialchars($user['email'] ?? 'N/A') ?></span>
            </div>
            
            <div class="businessinfo"><h2><strong>Business Info</strong></h2></div>

            <div class="businf1">
                <p class="category">Category</p>
                <span id="fetchedCategory"><?= htmlspecialchars($user['category_name'] ?? 'N/A') ?></span>
            </div>

            <div class="businf2">
                <p class="skills">Skills</p>
                <span id="fetchedSkills"><?= htmlspecialchars($user['skill'] ?? 'N/A') ?></span>
            </div>

            <div class="businf3">
                <p class="Experience">Experience</p>
                <span id="fetchedExperience"><?= htmlspecialchars($user['years_of_exprience'] ?? 'N/A') ?> Years</span>
            </div>

            <div class="businf4">
                <p class="location">Location</p>
                <span id="fetchedLocation"><?= htmlspecialchars($user['location'] ?? 'N/A') ?></span>
            </div>

            <div class="businf5">
                <p class="availability">Availability status</p>
                <span id="fetchedAvailability"><?= htmlspecialchars(ucfirst($user['available'] ?? 'Not Specified')) ?></span>
            </div>

            <button class="Saveinfo"><p>Edit</p></button>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
</body>
</html>
