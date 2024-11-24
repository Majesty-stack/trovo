<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trovoria Job Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="jobdetails.css">
    
</head>
<body>
<?php
require_once('header.php');


// Fetch job details based on the passed job ID
$jobId = $_GET['id'] ?? null;

if ($jobId === null) {
    echo "<div class='alert alert-danger text-center'>Invalid job ID.</div>";
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT j.job_id, j.title, j.description, l.location_name, j.budget, j.deadline, j.job_image, j.created_at 
                           FROM jobs j
                           LEFT JOIN locations l ON j.location_id = l.location_id
                           WHERE j.job_id = :job_id");
    $stmt->execute([':job_id' => $jobId]);
    $job = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$job) {
        echo "<div class='alert alert-danger text-center'>Job not found.</div>";
        exit();
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error fetching job details: " . $e->getMessage() . "</div>";
    exit();
}
?>
<div class="gen-signup d-flex justify-content-center align-items-center">
<div class="container job-details-container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="job-card">
                <?php if (!empty($job['job_image']) && file_exists(__DIR__ . '/uploads/' . $job['job_image'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($job['job_image']); ?>" alt="Job Image" class="job-image">
                <?php else: ?>
                    <img src="assets/placeholder.png" alt="Placeholder Image" class="job-image">
                <?php endif; ?>
                
                <h1 class="job-title"><?php echo htmlspecialchars($job['title']); ?></h1>
                <p class="job-description"><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
                
                <div class="job-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Location: <?php echo htmlspecialchars($job['location_name'] ?? 'Unknown'); ?></span>
                    <span><i class="fas fa-money-bill-wave"></i> Budget: ₦<?php echo htmlspecialchars(number_format($job['budget'])); ?></span>
                    <span><i class="fas fa-calendar-alt"></i> Deadline: <?php echo htmlspecialchars($job['deadline']); ?></span>
                    <span><i class="fas fa-clock"></i> Posted on: <?php echo htmlspecialchars(date("F j, Y", strtotime($job['created_at']))); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php require_once('footer.php'); ?>
</body>
</html>
