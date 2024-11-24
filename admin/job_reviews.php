<?php
require_once('header.php');

$errorMessage = "";
$successMessage = "";

// Handle deletion of a job review
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    try {
        $delete_id = intval($_GET['delete_id']);
        $stmt = $pdo->prepare("DELETE FROM ratings WHERE rating_id = :rating_id");
        $stmt->execute(['rating_id' => $delete_id]);
        $successMessage = "Job review deleted successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error deleting job review: " . $e->getMessage();
    }
}

// Handle form submission for adding a new job review
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $job_id = intval($_POST['job_id']);
        $reviewer_id = intval($_POST['reviewer_id']);
        $reviewed_user_id = intval($_POST['reviewed_user_id']);
        $rating_score = intval($_POST['rating_score']);
        $review_comment = trim($_POST['review_comment']);

        if (empty($job_id) || empty($reviewer_id) || empty($reviewed_user_id) || empty($rating_score) || empty($review_comment)) {
            throw new Exception("All fields are required.");
        }

        // Insert new job review
        $stmt = $pdo->prepare("INSERT INTO ratings (job_id, reviewer_id, reviewed_user_id, rating_score, review_comment) VALUES (:job_id, :reviewer_id, :reviewed_user_id, :rating_score, :review_comment)");
        $stmt->execute([
            'job_id' => $job_id,
            'reviewer_id' => $reviewer_id,
            'reviewed_user_id' => $reviewed_user_id,
            'rating_score' => $rating_score,
            'review_comment' => $review_comment
        ]);

        $successMessage = "Job review added successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error adding job review: " . $e->getMessage();
    }
}

// Fetch job reviews from the database
$reviews = [];
try {
    $stmt = $pdo->query("SELECT * FROM ratings ORDER BY created_at DESC");
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching job reviews: " . $e->getMessage();
}
?>

<section class="content-header">
    <h1>Job Reviews</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Job Review</h3>
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

                <!-- Reviewer ID -->
                <div class="form-group">
                    <label for="reviewer_id">Reviewer ID</label>
                    <input type="number" class="form-control" id="reviewer_id" name="reviewer_id" required>
                </div>

                <!-- Reviewed User ID -->
                <div class="form-group">
                    <label for="reviewed_user_id">Reviewed User ID</label>
                    <input type="number" class="form-control" id="reviewed_user_id" name="reviewed_user_id" required>
                </div>

                <!-- Rating Score -->
                <div class="form-group">
                    <label for="rating_score">Rating Score</label>
                    <input type="number" class="form-control" id="rating_score" name="rating_score" min="1" max="5" required>
                </div>

                <!-- Review Comment -->
                <div class="form-group">
                    <label for="review_comment">Review Comment</label>
                    <textarea class="form-control" id="review_comment" name="review_comment" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Add Review</button>
            </form>
        </div>
    </div>

    <!-- Display Job Reviews -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Current Job Reviews</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($reviews)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Rating ID</th>
                            <th>Job ID</th>
                            <th>Reviewer ID</th>
                            <th>Reviewed User ID</th>
                            <th>Rating Score</th>
                            <th>Review Comment</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $review): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($review['rating_id']); ?></td>
                                <td><?php echo htmlspecialchars($review['job_id']); ?></td>
                                <td><?php echo htmlspecialchars($review['reviewer_id']); ?></td>
                                <td><?php echo htmlspecialchars($review['reviewed_user_id']); ?></td>
                                <td><?php echo htmlspecialchars($review['rating_score']); ?></td>
                                <td><?php echo htmlspecialchars($review['review_comment']); ?></td>
                                <td><?php echo htmlspecialchars($review['created_at']); ?></td>
                                <td>
                                    <a href="edit_review.php?rating_id=<?php echo $review['rating_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="job_reviews.php?delete_id=<?php echo $review['rating_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this review?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No job reviews found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
