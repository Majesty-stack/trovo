<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trovoria Client Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Hamburger Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="clientdashboard.css">
</head>
<body>
<?php
session_start(); // Ensure session is started
require_once('header.php');

// Check if the user's email is stored in the session
if (!isset($_SESSION['user_email'])) {
    echo "<div class='alert alert-warning text-center'>User is not logged in. No email found in session.</div>";
    exit();
}
$userEmail = $_SESSION['user_email'];

try {
    // Fetch client data from the database
    $stmt = $pdo->prepare("SELECT name, email, phone, location, image FROM users WHERE email = :email AND role = 'client'");
    $stmt->execute([':email' => $userEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<div class='alert alert-danger text-center'>No user data found for the provided email.</div>";
        exit();
    }

    // Split name into first and last name for display
    $nameParts = explode(' ', $user['name']);
    $firstName = $nameParts[0] ?? '';
    $lastName = $nameParts[1] ?? '';
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error fetching user data: " . $e->getMessage() . "</div>";
    exit();
}


$imageName = $user['image']; // Get the image name from the database
$imagePath = 'uploads/' . $imageName;
$absolutePath = __DIR__ . '/uploads/' . $imageName;

if (empty($imageName) || !file_exists($absolutePath)) {
    // If the file doesn't exist, use a placeholder image
    $imagePath = 'uploads/placeholder.png';
}

?>
<div class="contentsap d-flex justify-content-center align-items-center">
    <div class="profhead col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <button id="backButton" class="backButton">
            <img src="assets/Back Arrow.svg" alt="Back">
        </button>
        
        <h2 class="post-job-title">My Dashboard</h2>

    </div>
</div>

<!-- Main Content (Account profile) -->
<div class="setAccProf d-flex justify-content-center align-items-center">
    <div class="accbox col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <!-- Display user profile image -->
        <img src="<?php echo htmlspecialchars($imagePath); ?>" class="accimg" alt="Client Image">
        <a href="jobpost.php" class="d-block">
            <h2 class="text-center"><strong>Post a Job</strong></h2>
        </a>
        <!-- account info -->
        <div class="information">
            <div class="personalInfo">
                <p class="firstN">First Name</p><span id="fetchedFN"><?php echo htmlspecialchars($firstName); ?></span>
            </div>

            <div class="personalInfo">
                <p class="lastN">Last Name</p><span id="fetchedLN"><?php echo htmlspecialchars($lastName); ?></span>
            </div>
            <div class="personalInfoEm">
            <p class="emailAdd">Email</p><span id="fetchedEM"><?php echo htmlspecialchars($user['email']); ?></span>
            </div>


            <div class="personalInfo">
                <p class="location">Location</p><span id="fetchedLOC"><?php echo htmlspecialchars($user['location']); ?></span>
            </div>

            

            <div class="putInDetails">
                <p class="phone">Phone Number</p><span id="fetchedtelphone"><?php echo htmlspecialchars($user['phone']); ?></span>
            </div>

            <a href="clientaccountedit.php"><button class="EditInfo"><p>Edit</p></button></a>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
</body>
</html>
