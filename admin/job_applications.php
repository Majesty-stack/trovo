<?php
require_once('header.php');

$errorMessage = "";
$successMessage = "";

// Handle deletion of a job application
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    try {
        $delete_id = intval($_GET['delete_id']);
        $stmt = $pdo->prepare("DELETE FROM job_applications WHERE application_id = :application_id");
        $stmt->execute(['application_id' => $delete_id]);
        $successMessage = "Job application deleted successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error deleting job application: " . $e->getMessage();
    }
}

// Handle form submission for adding a new job application
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $job_id = intval($_POST['job_id']);
        $applicant_name = trim($_POST['applicant_name']);
        $email = trim($_POST['email']);
        $status = trim($_POST['status']);

        if (empty($job_id) || empty($applicant_name) || empty($email) || empty($status)) {
            throw new Exception("All fields are required.");
        }

        // Insert new job application
        $stmt = $pdo->prepare("INSERT INTO job_applications (job_id, applicant_name, email, status) VALUES (:job_id, :applicant_name, :email, :status)");
        $stmt->execute([
            'job_id' => $job_id,
            'applicant_name' => $applicant_name,
            'email' => $email,
            'status' => $status
        ]);

        $successMessage = "Job application added successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error adding job application: " . $e->getMessage();
    }
}

// Fetch job applications from the database
$applications = [];
try {
    $stmt = $pdo->query("SELECT * FROM job_applications ORDER BY created_at DESC");
    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching job applications: " . $e->getMessage();
}
?>

<section class="content-header">
    <h1>Job Applications</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Job Application</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <form method="post">
                <!-- Job ID -->
                <div class="form-group">
                    <label for="job_id">Job ID</label>
                    <input type="number" class="form-control" id="job_id" name="job_id" required>
                </div>

                <!-- Applicant Name -->
                <div class="form-group">
                    <label for="applicant_name">Applicant Name</label>
                    <input type="text" class="form-control" id="applicant_name" name="applicant_name" required>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="pending">Pending</option>
                        <option value="reviewed">Reviewed</option>
                        <option value="accepted">Accepted</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Add Application</button>
            </form>
        </div>
    </div>

    <!-- Display Job Applications -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Current Job Applications</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($applications)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Job ID</th>
                            <th>Applicant Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $application): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($application['application_id']); ?></td>
                                <td><?php echo htmlspecialchars($application['job_id']); ?></td>
                                <td><?php echo htmlspecialchars($application['applicant_name']); ?></td>
                                <td><?php echo htmlspecialchars($application['email']); ?></td>
                                <td><?php echo htmlspecialchars($application['status']); ?></td>
                                <td><?php echo htmlspecialchars($application['created_at']); ?></td>
                                <td>
                                    <a href="edit_application.php?application_id=<?php echo $application['application_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="job_applications.php?delete_id=<?php echo $application['application_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this application?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No job applications found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
