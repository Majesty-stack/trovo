<?php
require_once('header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form inputs
    $smtp_host = filter_var($_POST['smtp_host'], FILTER_SANITIZE_STRING);
    $smtp_port = filter_var($_POST['smtp_port'], FILTER_SANITIZE_NUMBER_INT);
    $smtp_username = filter_var($_POST['smtp_username'], FILTER_SANITIZE_STRING);
    $smtp_password = filter_var($_POST['smtp_password'], FILTER_SANITIZE_STRING);
    $smtp_encryption = filter_var($_POST['smtp_encryption'], FILTER_SANITIZE_STRING);

    try {
        // Update SMTP settings
        $sql = "UPDATE smtp_settings SET 
                    smtp_host = :smtp_host, 
                    smtp_port = :smtp_port, 
                    smtp_username = :smtp_username, 
                    smtp_password = :smtp_password, 
                    smtp_encryption = :smtp_encryption 
                WHERE id = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':smtp_host' => $smtp_host,
            ':smtp_port' => $smtp_port,
            ':smtp_username' => $smtp_username,
            ':smtp_password' => $smtp_password,
            ':smtp_encryption' => $smtp_encryption
        ]);

        header("Location: email_settings.php?success=SMTP settings updated successfully.");
        exit;
    } catch (PDOException $e) {
        header("Location: email_settings.php?error=" . urlencode("Error updating settings: " . $e->getMessage()));
        exit;
    }
} else {
    header("Location: email_settings.php");
    exit;
}
?>
