<?php require_once('header.php'); ?>

<section class="content-header">
    <h1>Dashboard</h1>
</section>

<?php
try {
    // Aggregated query to fetch counts based on your schema.
    $query = "
        SELECT 
            (SELECT COUNT(*) FROM categories) AS total_categories,
            (SELECT COUNT(*) FROM jobs WHERE status = 'open') AS open_jobs,
            (SELECT COUNT(*) FROM jobs WHERE status = 'in_progress') AS in_progress_jobs,
            (SELECT COUNT(*) FROM jobs WHERE status = 'completed') AS completed_jobs,
            (SELECT COUNT(*) FROM payments WHERE status = 'completed') AS completed_payments,
            (SELECT COUNT(*) FROM payments WHERE status = 'pending') AS pending_payments,
            (SELECT COUNT(*) FROM users WHERE role = 'skilled_worker') AS total_workers,
            (SELECT COUNT(*) FROM users WHERE role = 'client') AS total_clients,
            (SELECT COUNT(*) FROM notifications WHERE is_read = 0) AS unread_notifications
        ";

    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    // Extract results into variables for easier access.
    extract($result);
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error fetching dashboard data: " . $e->getMessage() . "</div>";
}
?>

<section class="content">
    <div class="row">
        <!-- Categories -->
        <div class="col-lg-3 col-xs-6">
            <a href="categories.php">
                <div class="small-box bg-olive">
                    <div class="inner">
                        <h3><?php echo $total_categories; ?></h3>
                        <p>Categories</p>
                    </div>
                    <div class="icon">
                        <i class="ionicons ion-android-list"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Open Jobs -->
        <div class="col-lg-3 col-xs-6">
            <a href="jobs.php">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3><?php echo $open_jobs; ?></h3>
                        <p>Open Jobs</p>
                    </div>
                    <div class="icon">
                        <i class="ionicons ion-briefcase"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Jobs in Progress -->
        <div class="col-lg-3 col-xs-6">
            <a href="jobs.php">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3><?php echo $in_progress_jobs; ?></h3>
                        <p>Jobs in Progress</p>
                    </div>
                    <div class="icon">
                        <i class="ionicons ion-load-a"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Completed Jobs -->
        <div class="col-lg-3 col-xs-6">
            <a href="jobs.php">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $completed_jobs; ?></h3>
                        <p>Completed Jobs</p>
                    </div>
                    <div class="icon">
                        <i class="ionicons ion-checkmark-circled"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Completed Payments -->
        <div class="col-lg-3 col-xs-6">
            <a href="payments.php">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3><?php echo $completed_payments; ?></h3>
                        <p>Completed Payments</p>
                    </div>
                    <div class="icon">
                        <i class="ionicons ion-cash"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pending Payments -->
        <div class="col-lg-3 col-xs-6">
            <a href="payments.php">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo $pending_payments; ?></h3>
                        <p>Pending Payments</p>
                    </div>
                    <div class="icon">
                        <i class="ionicons ion-alert-circled"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Workers -->
        <div class="col-lg-3 col-xs-6">
            <a href="workers.php">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo $total_workers; ?></h3>
                        <p>Total Workers</p>
                    </div>
                    <div class="icon">
                        <i class="ionicons ion-person-stalker"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Clients -->
        <div class="col-lg-3 col-xs-6">
            <a href="clients.php">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3><?php echo $total_clients; ?></h3>
                        <p>Total Clients</p>
                    </div>
                    <div class="icon">
                        <i class="ionicons ion-person"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Unread Notifications -->
        <div class="col-lg-3 col-xs-6">
            <a href="notifications.php">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo $unread_notifications; ?></h3>
                        <p>Unread Notifications</p>
                    </div>
                    <div class="icon">
                        <i class="ionicons ion-email-unread"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
