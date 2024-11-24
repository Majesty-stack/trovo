<?php
require_once('header.php');

$errorMessage = "";
$successMessage = "";

// Check if rating_id is provided in the URL and is valid
if (isset($_GET['rating_id']) && is_numeric($_GET['rating_id'])) {
    $rating_id = intval($_GET['rating_id']);

    // Fetch review data for the given rating_id
    try {
        $stmt = $pdo->prepare("SELECT * FROM ratings WHERE rating_id = :rating_id");
        $stmt->execute(['rating_id' => $rating_id]);
        $review = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$review) {
            $errorMessage = "Review not found.";
        }
    } catch (Exception $e) {
        $errorMessage = "Error fetching review: " . $e->getMessage();
    }
} else {
    $errorMessage = "Invalid or missing review ID.";
}

// Handle form submission for updating the review
if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errorMessage)) {
    try {
        $job_id = intval($_POST['job_id']);
        $reviewer_id = intval($_POST['reviewer_id']);
        $reviewed_user_id = intval($_POST['reviewed_user_id']);
        $rating_score = intval($_POST['rating_score']);
        $review_comment = trim($_POST['review_comment']);

        if (empty($job_id) || empty($reviewer_id) || empty($reviewed_user_id) || empty($rating_score) || empty($review_comment)) {
            throw new Exception("All fields are required.");
        }

        // Update review details
        $stmt = $pdo->prepare("UPDATE ratings SET job_id = :job_id, reviewer_id = :reviewer_id, reviewed_user_id = :reviewed_user_id, rating_score = :rating_score, review_comment = :review_comment WHERE rating_id = :rating_id");
        $stmt->execute([
            'job_id' => $job_id,
            'reviewer_id' => $reviewer_id,
            'reviewed_user_id' => $reviewed_user_id,
            'rating_score' => $rating_score,
            'review_comment' => $review_comment,
            'rating_id' => $rating_id
        ]);

        $successMessage = "Review updated successfully!";

        // Redirect back to the list of job reviews or refresh the page
        header("Location: job_reviews.php");
        exit;

    } catch (Exception $e) {
        $errorMessage = "Error updating review: " . $e->getMessage();
    }
}
?>

<section class="content-header">
    <h1>Edit Job Review</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Review Details</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($review)): ?>
                <form method="post">
                    <!-- Job ID -->
                    <div class="form-group">
                        <label for="job_id">Job ID</label>
                        <input type="number" class="form-control" id="job_id" name="job_id" value="<?php echo htmlspecialchars($review['job_id']); ?>" required>
                    </div>

                    <!-- Reviewer ID -->
                    <div class="form-group">
                        <label for="reviewer_id">Reviewer ID</label>
                        <input type="number" class="form-control" id="reviewer_id" name="reviewer_id" value="<?php echo htmlspecialchars($review['reviewer_id']); ?>" required>
                    </div>

                    <!-- Reviewed User ID -->
                    <div class="form-group">
                        <label for="reviewed_user_id">Reviewed User ID</label>
                        <input type="number" class="form-control" id="reviewed_user_id" name="reviewed_user_id" value="<?php echo htmlspecialchars($review['reviewed_user_id']); ?>" required>
                    </div>

                    <!-- Rating Score -->
                    <div class="form-group">
                        <label for="rating_score">Rating Score</label>
                        <input type="number" class="form-control" id="rating_score" name="rating_score" min="1" max="5" value="<?php echo htmlspecialchars($review['rating_score']); ?>" required>
                    </div>

                    <!-- Review Comment -->
                    <div class="form-group">
                        <label for="review_comment">Review Comment</label>
                        <textarea class="form-control" id="review_comment" name="review_comment" required><?php echo htmlspecialchars($review['review_comment']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            <?php else: ?>
                <p>No review found for the given ID.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
