<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trovoria Client Edit Profile</title>
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
    // Fetch client data from the database
    $stmt = $pdo->prepare("SELECT name, email, phone, location, image FROM users WHERE email = :email AND role = 'client'");
    $stmt->execute([':email' => $userEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<div class='alert alert-danger text-center'>No user data found for the provided email.</div>";
        exit();
    }

    // Split name into first and last name for editing
    $nameParts = explode(' ', $user['name']);
    $firstName = $nameParts[0] ?? '';
    $lastName = $nameParts[1] ?? '';

    // Fetch locations from the database
    $locationStmt = $pdo->query("SELECT location_id, location_name FROM locations");
    $locations = $locationStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error fetching data: " . $e->getMessage() . "</div>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $location = $_POST['location'] ?? '';
    $image = $_FILES['image']['name'] ?? '';

    // Update logic (assumes basic validation is done)
    try {
        $updatedName = trim($firstName . ' ' . $lastName);
        $imagePath = $user['image']; // Default image path

        // Handle image upload if a new image is provided
        if (!empty($image)) {
            $targetDir = __DIR__ . '/uploads/';
            $targetFile = $targetDir . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
            $imagePath = basename($image);
        }

        // Update user information in the database
        $stmt = $pdo->prepare("UPDATE users SET name = :name, phone = :phone, location = :location, image = :image WHERE email = :email AND role = 'client'");
        $stmt->execute([
            ':name' => $updatedName,
            ':phone' => $phone,
            ':location' => $location,
            ':image' => $imagePath,
            ':email' => $userEmail
        ]);

        // Redirect to clientdashboard.php after successful update
        header("Location: clientdashboard.php");
        exit();
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error updating user data: " . $e->getMessage() . "</div>";
    }
}
?>

<div class="contentsap d-flex justify-content-center align-items-center">
    <div class="profhead col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <button id="backButton" class="backButton" onclick="window.history.back();">
            <img src="assets/Back Arrow.svg" alt="Back">
        </button>
        
        <h2 class="post-job-title">Edit Profile</h2>
    </div>
</div>

<!-- Main Content (Edit Account profile) -->
<div class="setAccProf d-flex justify-content-center align-items-center">
    <div class="accbox col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <!-- Profile Edit Form -->
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($firstName); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($lastName); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <select class="form-control" id="location" name="location" required>
                    <option value="">Select Location</option>
                    <?php foreach ($locations as $loc): ?>
                        <option value="<?php echo htmlspecialchars($loc['location_name']); ?>" <?php echo ($user['location'] === $loc['location_name']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($loc['location_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Profile Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</div>

<?php require_once('footer.php'); ?>
</body>
</html>
