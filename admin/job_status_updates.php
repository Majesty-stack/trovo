<?php
require_once('header.php');

$errorMessage = "";
$successMessage = "";

// Handle form submission for updating job status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $job_id = intval($_POST['job_id']);
        $status = trim($_POST['status']);

        if (empty($job_id) || empty($status)) {
            throw new Exception("Job ID and status are required.");
        }

        // Update job status
        $stmt = $pdo->prepare("UPDATE jobs SET status = :status WHERE job_id = :job_id");
        $stmt->execute([
            'status' => $status,
            'job_id' => $job_id
        ]);

        $successMessage = "Job status updated successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error updating job status: " . $e->getMessage();
    }
}

// Fetch jobs from the database
$jobs = [];
try {
    $stmt = $pdo->query("SELECT * FROM jobs ORDER BY created_at DESC");
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching jobs: " . $e->getMessage();
}
?>

<section class="content-header">
    <h1>Job Status Updates</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Update Job Status</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($jobs)): ?>
                <form method="post">
                    <!-- Job Selection -->
                    <div class="form-group">
                        <label for="job_id">Select Job</label>
                        <select class="form-control" id="job_id" name="job_id" required>
                            <option value="">-- Select Job --</option>
                            <?php foreach ($jobs as $job): ?>
                                <option value="<?php echo htmlspecialchars($job['job_id']); ?>">
                                    <?php echo htmlspecialchars($job['title']); ?> (Job ID: <?php echo htmlspecialchars($job['job_id']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Status Selection -->
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="open">Open</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Status</button>
                </form>
            <?php else: ?>
                <p>No jobs found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
