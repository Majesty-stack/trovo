<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trovoria Post a Job</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
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
    // Fetch client data from the database to get user information
    $stmt = $pdo->prepare("SELECT user_id, name, location FROM users WHERE email = :email AND role = 'client'");
    $stmt->execute([':email' => $userEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<div class='alert alert-danger text-center'>No user data found for the provided email.</div>";
        exit();
    }

    // Check if user_id is set
    if (empty($user['user_id'])) {
        echo "<div class='alert alert-danger text-center'>User ID not found. Please check your database records.</div>";
        exit();
    }

    // Fetch location_id and location_name based on user's location
    $locationStmt = $pdo->prepare("SELECT location_id, location_name FROM locations WHERE location_name = :location_name");
    $locationStmt->execute([':location_name' => $user['location']]);
    $location = $locationStmt->fetch(PDO::FETCH_ASSOC);

    if (!$location) {
        echo "<div class='alert alert-danger text-center'>Location not found in the database. Please check your locations table.</div>";
        exit();
    }

    $locationId = $location['location_id'];
    $locationName = $location['location_name'];
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error fetching user data: " . $e->getMessage() . "</div>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobTitle = $_POST['job_title'] ?? '';
    $jobDescription = $_POST['job_description'] ?? '';
    $budget = $_POST['budget'] ?? '';
    $deadline = $_POST['deadline'] ?? '';
    $jobImage = isset($_FILES['job_image']) && !empty($_FILES['job_image']['name']) ? $_FILES['job_image']['name'] : '';

    // Handle optional job image upload
    if (!empty($jobImage)) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['job_image']['tmp_name']);
        if (in_array($fileType, $allowedTypes) && $_FILES['job_image']['size'] <= 2097152) { // Limit to 2MB
            $targetDir = __DIR__ . '/uploads/';
            $targetFile = $targetDir . basename($jobImage);
            if (move_uploaded_file($_FILES['job_image']['tmp_name'], $targetFile)) {
                $jobImagePath = basename($jobImage);
            } else {
                $jobImagePath = null;
            }
        } else {
            echo "<div class='alert alert-danger'>Invalid file type or size. Please upload a valid image file (max size: 2MB).</div>";
            $jobImagePath = null;
        }
    } else {
        $jobImagePath = null;
    }

    // Validate required fields
    if (!empty($jobTitle) && !empty($jobDescription) && !empty($locationId) && !empty($deadline)) {
        try {
            // Insert job data into the database
            $stmt = $pdo->prepare("INSERT INTO jobs (client_id, title, description, location_id, budget, deadline, job_image, created_at) VALUES (:client_id, :title, :description, :location_id, :budget, :deadline, :job_image, NOW())");
            $stmt->execute([
                ':client_id' => $user['user_id'],
                ':title' => $jobTitle,
                ':description' => $jobDescription,
                ':location_id' => $locationId,
                ':budget' => $budget,
                ':deadline' => $deadline,
                ':job_image' => $jobImagePath
            ]);

            // Redirect to a success or job listings page (update as necessary)
            header("Location: joblistings.php");
            exit();
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error posting job: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center'>Please fill in all required fields.</div>";
    }
}
?>

<div class="contentsap d-flex justify-content-center align-items-center">
    <div class="profhead col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <button id="backButton" class="backButton" onclick="window.history.back();">
            <img src="assets/Back Arrow.svg" alt="Back">
        </button>
        <h2 class="post-job-title">Post a Job</h2>

    </div>
</div>

<!-- Main Content (Job Posting Form) -->
<div class="setAccProf d-flex justify-content-center align-items-center">
    <div class="accbox col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <!-- Job Post Form -->
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="job_title">Job Title</label>
                <input type="text" class="form-control" id="job_title" name="job_title" required>
            </div>
            <div class="form-group">
                <label for="job_description">Job Description</label>
                <textarea class="form-control" id="job_description" name="job_description" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($locationName); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="budget">Budget</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">₦</span>
                    </div>
                    <input type="text" class="form-control" id="budget" name="budget" placeholder="Enter amount">
                </div>
            </div>
            <div class="form-group">
                <label for="deadline">Deadline</label>
                <input type="date" class="form-control" id="deadline" name="deadline" required>
            </div>
            <div class="form-group">
                <label for="job_image">Job Image (Optional)</label>
                <input type="file" class="form-control-file" id="job_image" name="job_image">
            </div>
            <button type="submit" class="btn btn-primary">Post Job</button>
        </form>
    </div>
</div>

<?php require_once('footer.php'); ?>
</body>
</html>
