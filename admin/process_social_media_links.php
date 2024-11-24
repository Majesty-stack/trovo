<?php
require_once('header.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and capture input data
    $facebook_url = filter_var($_POST['facebook'], FILTER_SANITIZE_URL);
    $twitter_url = filter_var($_POST['twitter'], FILTER_SANITIZE_URL);
    $instagram_url = filter_var($_POST['instagram'], FILTER_SANITIZE_URL);
    $linkedin_url = filter_var($_POST['linkedin'], FILTER_SANITIZE_URL);
    $youtube_url = filter_var($_POST['youtube'], FILTER_SANITIZE_URL);

    // Debugging: Print values to ensure they're captured correctly
    echo "Facebook URL: $facebook_url<br>";
    echo "Twitter URL: $twitter_url<br>";
    echo "Instagram URL: $instagram_url<br>";
    echo "LinkedIn URL: $linkedin_url<br>";
    echo "YouTube URL: $youtube_url<br>";
    
    // Prepare SQL statement to update social media links
    $sql = "UPDATE social_media_links SET 
                facebook_url = :facebook, 
                twitter_url = :twitter, 
                instagram_url = :instagram, 
                linkedin_url = :linkedin, 
                youtube_url = :youtube 
            WHERE id = 1";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':facebook' => $facebook_url,
            ':twitter' => $twitter_url,
            ':instagram' => $instagram_url,
            ':linkedin' => $linkedin_url,
            ':youtube' => $youtube_url
        ]);

        // Check if rows were updated
        if ($stmt->rowCount() > 0) {
            header("Location: social_media_links.php?success=Social media links updated successfully.");
        } else {
            header("Location: social_media_links.php?error=" . urlencode("No changes were made. Check if id = 1 exists."));
        }
        exit;
    } catch (PDOException $e) {
        header("Location: social_media_links.php?error=" . urlencode("Error updating links: " . $e->getMessage()));
        exit;
    }
} else {
    header("Location: social_media_links.php");
    exit;
}
?>
