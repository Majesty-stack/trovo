<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trovoria Job Listings</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="joblistings.css">
    </head>
 <body> 

<?php
require_once('header.php');

try {
    // Fetch job listings from the database
    $stmt = $pdo->query("SELECT j.job_id, j.title, j.description, l.location_name, j.budget, j.deadline, j.job_image 
                         FROM jobs j
                         LEFT JOIN locations l ON j.location_id = l.location_id
                         ORDER BY j.created_at DESC");
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error fetching job listings: " . $e->getMessage() . "</div>";
    $jobs = [];
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Job Listings</h1>
    <div class="row">
        <?php if (empty($jobs)): ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">No job listings found.</div>
            </div>
        <?php else: ?>
            <?php foreach ($jobs as $job): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="job-card">
                        <?php if (!empty($job['job_image']) && file_exists(__DIR__ . '/uploads/' . $job['job_image'])): ?>
                            <img src="uploads/<?php echo htmlspecialchars($job['job_image']); ?>" alt="Job Image" class="job-image">
                        <?php else: ?>
                            <img src="assets/placeholder.png" alt="Placeholder Image" class="job-image">
                        <?php endif; ?>
                        <div class="job-content">
                            <h3 class="job-title"><?php echo htmlspecialchars($job['title']); ?></h3>
                            <p class="job-description"><?php echo htmlspecialchars(substr($job['description'], 0, 100)) . '...'; ?></p>
                            <div class="job-meta">
                                <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($job['location_name'] ?? 'Unknown'); ?></span>
                                <span><i class="fas fa-money-bill-wave"></i> ₦<?php echo htmlspecialchars(number_format($job['budget'])); ?></span>
                                <span><i class="fas fa-calendar-alt"></i> Deadline: <?php echo htmlspecialchars($job['deadline']); ?></span>
                            </div>
                            <?php if (isset($job['job_id'])): ?>
                                <a href="jobdetails.php?id=<?php echo urlencode($job['job_id']); ?>" class="btn btn-apply mt-3">View Details</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once('footer.php'); ?>
</body>
</html>
