<?php
require_once('header.php');

// Initialize error and success messages
$errorMessage = "";
$successMessage = "";

// Check if job_id is provided in the URL
if (isset($_GET['job_id']) && is_numeric($_GET['job_id'])) {
    $job_id = intval($_GET['job_id']);
    
    // Fetch the job data for the provided job_id
    try {
        $stmt = $pdo->prepare("SELECT * FROM jobs WHERE job_id = :job_id");
        $stmt->execute(['job_id' => $job_id]);
        $job = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$job) {
            $errorMessage = "Job not found.";
        }
    } catch (Exception $e) {
        $errorMessage = "Error fetching job: " . $e->getMessage();
    }
} else {
    $errorMessage = "Invalid job ID.";
}

// Handle form submission for updating the job
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $location_id = intval($_POST['location_id']);
        $budget = floatval($_POST['budget']);
        $deadline = $_POST['deadline'];
        $status = $_POST['status'];

        if (empty($title) || empty($description) || empty($deadline)) {
            throw new Exception("Title, description, and deadline are required.");
        }

        // Update job details
        $stmt = $pdo->prepare("UPDATE jobs SET title = :title, description = :description, location_id = :location_id, budget = :budget, deadline = :deadline, status = :status WHERE job_id = :job_id");
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'location_id' => $location_id,
            'budget' => $budget,
            'deadline' => $deadline,
            'status' => $status,
            'job_id' => $job_id
        ]);

        $successMessage = "Job updated successfully!";
        
        // Refresh job data
        $stmt = $pdo->prepare("SELECT * FROM jobs WHERE job_id = :job_id");
        $stmt->execute(['job_id' => $job_id]);
        $job = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        $errorMessage = "Error updating job: " . $e->getMessage();
    }
}

?>

<section class="content-header">
    <h1>Edit Job</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Job Details</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($job)): ?>
                <form method="post">
                    <!-- Job Title -->
                    <div class="form-group">
                        <label for="title">Job Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($job['title']); ?>" required>
                    </div>

                    <!-- Job Description -->
                    <div class="form-group">
                        <label for="description">Job Description</label>
                        <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($job['description']); ?></textarea>
                    </div>

                    <!-- Location ID -->
                    <div class="form-group">
                        <label for="location_id">Location ID</label>
                        <input type="number" class="form-control" id="location_id" name="location_id" value="<?php echo htmlspecialchars($job['location_id']); ?>" required>
                    </div>

                    <!-- Budget -->
                    <div class="form-group">
                        <label for="budget">Budget</label>
                        <input type="text" class="form-control" id="budget" name="budget" value="<?php echo htmlspecialchars($job['budget']); ?>">
                    </div>

                    <!-- Deadline -->
                    <div class="form-group">
                        <label for="deadline">Deadline</label>
                        <input type="date" class="form-control" id="deadline" name="deadline" value="<?php echo htmlspecialchars($job['deadline']); ?>" required>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="open" <?php echo ($job['status'] == 'open') ? 'selected' : ''; ?>>Open</option>
                            <option value="in_progress" <?php echo ($job['status'] == 'in_progress') ? 'selected' : ''; ?>>In Progress</option>
                            <option value="completed" <?php echo ($job['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                            <option value="closed" <?php echo ($job['status'] == 'closed') ? 'selected' : ''; ?>>Closed</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            <?php else: ?>
                <p>No job found for the given ID.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
