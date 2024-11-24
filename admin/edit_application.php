<?php
require_once('header.php');

$errorMessage = "";
$successMessage = "";

// Check if application_id is provided in the URL and is valid
if (isset($_GET['application_id']) && is_numeric($_GET['application_id'])) {
    $application_id = intval($_GET['application_id']);

    // Fetch application data for the given application_id
    try {
        $stmt = $pdo->prepare("SELECT * FROM job_applications WHERE application_id = :application_id");
        $stmt->execute(['application_id' => $application_id]);
        $application = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$application) {
            $errorMessage = "Application not found.";
        }
    } catch (Exception $e) {
        $errorMessage = "Error fetching application: " . $e->getMessage();
    }
} else {
    $errorMessage = "Invalid or missing application ID.";
}

// Handle form submission for updating the application
if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errorMessage)) {
    try {
        $job_id = intval($_POST['job_id']);
        $applicant_name = trim($_POST['applicant_name']);
        $email = trim($_POST['email']);
        $status = trim($_POST['status']);

        if (empty($job_id) || empty($applicant_name) || empty($email) || empty($status)) {
            throw new Exception("All fields are required.");
        }

        // Update application details
        $stmt = $pdo->prepare("UPDATE job_applications SET job_id = :job_id, applicant_name = :applicant_name, email = :email, status = :status WHERE application_id = :application_id");
        $stmt->execute([
            'job_id' => $job_id,
            'applicant_name' => $applicant_name,
            'email' => $email,
            'status' => $status,
            'application_id' => $application_id
        ]);

        $successMessage = "Application updated successfully!";

        // Redirect back to the list of job applications or refresh the page
        header("Location: job_applications.php");
        exit;

    } catch (Exception $e) {
        $errorMessage = "Error updating application: " . $e->getMessage();
    }
}
?>

<section class="content-header">
    <h1>Edit Job Application</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Application Details</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($application)): ?>
                <form method="post">
                    <!-- Job ID -->
                    <div class="form-group">
                        <label for="job_id">Job ID</label>
                        <input type="number" class="form-control" id="job_id" name="job_id" value="<?php echo htmlspecialchars($application['job_id']); ?>" required>
                    </div>

                    <!-- Applicant Name -->
                    <div class="form-group">
                        <label for="applicant_name">Applicant Name</label>
                        <input type="text" class="form-control" id="applicant_name" name="applicant_name" value="<?php echo htmlspecialchars($application['applicant_name']); ?>" required>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($application['email']); ?>" required>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending" <?php echo ($application['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="reviewed" <?php echo ($application['status'] == 'reviewed') ? 'selected' : ''; ?>>Reviewed</option>
                            <option value="accepted" <?php echo ($application['status'] == 'accepted') ? 'selected' : ''; ?>>Accepted</option>
                            <option value="rejected" <?php echo ($application['status'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            <?php else: ?>
                <p>No application found for the given ID.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
