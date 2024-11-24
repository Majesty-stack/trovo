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
    <link rel="stylesheet" href="clientSignUp.css">
</head>

<body>
<?php
session_start(); // Start the session to access session variables

// Include the database connection (assuming connection is established in header.php)
require_once('header.php');

// Fetch locations from the database
$locations = [];
try {
    $stmt = $pdo->query("SELECT location_id, location_name FROM locations");
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error fetching locations: " . $e->getMessage() . "</div>";
}

// Form processing logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input values
    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName = htmlspecialchars(trim($_POST['last_name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $location = htmlspecialchars(trim($_POST['location'])); // New location field
    $password = trim($_POST['password']);
    $role = 'client'; // Setting role as "client"

    // Handle image upload
    $image = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['profile_image']['name']);
        $imageSize = getimagesize($_FILES['profile_image']['tmp_name']);
        
        if ($imageSize[0] == 120 && $imageSize[1] == 80) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFile)) {
                $image = $uploadFile;
            } else {
                echo "<div class='alert alert-danger'>Image upload failed.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Image must be exactly 120x80 pixels.</div>";
        }
    }

    // Basic validation checks
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Invalid email format.</div>";
    } elseif (empty($firstName) || empty($lastName) || empty($phone) || empty($location) || empty($password)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        // Hash the password for security
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        try {
            // Insert user data into the database
            $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, password_hash, role, status, created_at, image, location) VALUES (:name, :email, :phone, :password_hash, :role, :status, NOW(), :image, :location)");
            $stmt->execute([
                ':name' => $firstName . ' ' . $lastName,
                ':email' => $email,
                ':phone' => $phone,
                ':password_hash' => $passwordHash,
                ':role' => $role,
                ':status' => 'active',
                ':image' => $image,
                ':location' => $location
            ]);

            // Set the session for the user's email
            $_SESSION['user_email'] = $email;

            // Redirect to accverified.php upon successful registration
            header("Location: accverified.php");
            exit();
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error registering user: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!-- Main Content (Signup Form) -->
<div class="skiWRKsignup-container d-flex justify-content-center align-items-center">
    <div class="skilledwrkSignupbox col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <h2 class="text-center">Register With:</h2>

        <!-- Social Signup Buttons -->
        <div class="social-signup d-flex justify-content-center mb-3">
            <a href="#" class="social-btn apple mx-2"><i class="fab fa-apple"></i></a>
            <a href="#" class="social-btn google mx-2">
                <!-- Multi-colored Google SVG icon -->
                <svg class="google-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48">
                    <path fill="#4285F4" d="M24 9.5c1.5 0 2.9.2 4.2.6l3.4-3.4C28.6 5.8 26.4 5 24 5c-5.2 0-9.7 3-11.9 7.3l4 3.1c1.4-2.7 4.2-4.9 7.9-4.9z"/>
                    <path fill="#34A853" d="M24 44c3.6 0 6.5-1.2 8.7-3.3l-4-3.2c-1.2.8-2.7 1.3-4.7 1.3-4.4 0-8.2-3-9.5-7l-4.1 3.2C13.9 39 18.5 44 24 44z"/>
                    <path fill="#FBBC05" d="M43 24c0-1.2-.1-2.4-.4-3.5H24v7h11.1c-.5 2.4-1.9 4.4-3.9 5.7l4 3.2C38.4 33.7 43 29.4 43 24z"/>
                    <path fill="#EA4335" d="M14.5 27.1c-.4-1.2-.6-2.4-.6-3.6s.2-2.5.6-3.6l-4.1-3.2C9.6 19.4 9 21.6 9 24s.6 4.6 1.4 6.6l4.1-3.5z"/>
                </svg>
            </a>
            <a href="#" class="social-btn twitter mx-2"><i class="fab fa-twitter"></i></a>
        </div>

        <div class="divider">OR</div>

        <!-- Signup Form -->
        <form method="post" enctype="multipart/form-data">
            <div class="givenNametitle">
                <label for="Name">First Name</label>
                <label for="Name">Last Name</label>
            </div>

            <div class="givenName">
                <div class="firstName"><img src="assets/User.png" alt="">
                    <input type="text" class="form-control" name="first_name" id="writeF" placeholder="First Name" required>
                </div>
                <div class="lastName"><img src="assets/User.png" alt="">
                    <input type="text" class="form-control" name="last_name" id="writeL" placeholder="Last Name" required>
                </div>
            </div>

            <div class="form-group">
                <label for="Email">Email</label>
                <div class="emailbox"><img src="assets/Email.png" alt="">
                    <input type="email" class="form-control" name="email" id="writeE" placeholder="Enter Email Address" required>
                </div>
            </div>

            <!-- Phone Number Input -->
            <div class="form-group">
                <label for="Phone">Phone Number</label>
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone Number" required>
            </div>

            <!-- Image Upload -->
            <div class="form-group-flex">
                <label for="profile_image">Upload Profile Image (120x80 pixels)</label>
                <input type="file" class="form-control file-upload" name="profile_image" id="profile_image" accept="image/*" required>
            </div>

            <!-- Location Selection -->
            <div class="form-group">
                <label for="location">Location</label>
                <select name="location" id="location" class="form-control" required>
                    <option value="">Select Your Location</option>
                    <?php foreach ($locations as $loc): ?>
                        <option value="<?= htmlspecialchars($loc['location_name']) ?>"><?= htmlspecialchars($loc['location_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="pssWrdbox"><img src="assets/Password.png" alt="">
                    <input type="password" class="form-control" name="password" id="writeP" placeholder="************" required> 
                    <span class="toggle-password" onclick="togglePasswordVisibility()">
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="login-options d-flex justify-content-between align-items-center mb-3">
                <label><input type="checkbox" required> By registering you are agreeing to our terms of use and privacy policy</label>
            </div>

            <button type="submit" class="btn btn-success btn-block signup-button">Sign Up</button>
        </form>
    </div>
</div>

<script>
function togglePasswordVisibility() {
    var passwordField = document.getElementById("writeP");
    var toggleIcon = document.querySelector(".toggle-password i");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}
</script>

<?php require_once('footer.php'); ?>
</body>
</html>
