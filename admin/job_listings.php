<?php
require_once('header.php');

// Initialize error and success messages
$errorMessage = "";
$successMessage = "";



// Handle deletion of a job listing
if (isset($_GET['delete_id'])) {
    try {
        $delete_id = intval($_GET['delete_id']);
        $stmt = $pdo->prepare("DELETE FROM jobs WHERE job_id = :job_id");
        $stmt->execute(['job_id' => $delete_id]);
        $successMessage = "Job listing deleted successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error deleting job listing: " . $e->getMessage();
    }
}

// Fetch job listings from the database
$jobListings = [];
try {
    $stmt = $pdo->query("SELECT * FROM jobs ORDER BY created_at DESC");
    $jobListings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching job listings: " . $e->getMessage();
}
?>

<section class="content-header">
    <h1>Job Listings</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Current Job Listings</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($jobListings)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Location ID</th>
                            <th>Budget</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobListings as $job): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($job['job_id']); ?></td>
                                <td><?php echo htmlspecialchars($job['title']); ?></td>
                                <td><?php echo htmlspecialchars($job['description']); ?></td>
                                <td><?php echo htmlspecialchars($job['location_id']); ?></td>
                                <td><?php echo htmlspecialchars($job['budget']); ?></td>
                                <td><?php echo htmlspecialchars($job['deadline']); ?></td>
                                <td><?php echo htmlspecialchars($job['status']); ?></td>
                                <td>
                                    <a href="edit_job.php?job_id=<?php echo $job['job_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="job_listings.php?delete_id=<?php echo $job['job_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No job listings found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
