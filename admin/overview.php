<?php
require_once('header.php');


try {
    // Aggregated query to fetch counts for overview
    $query = "
        SELECT 
            (SELECT COUNT(*) FROM categories) AS total_categories,
            (SELECT COUNT(*) FROM jobs WHERE status = 'open') AS open_jobs,
            (SELECT COUNT(*) FROM jobs WHERE status = 'in_progress') AS in_progress_jobs,
            (SELECT COUNT(*) FROM jobs WHERE status = 'completed') AS completed_jobs,
            (SELECT COUNT(*) FROM payments WHERE status = 'completed') AS completed_payments,
            (SELECT COUNT(*) FROM payments WHERE status = 'pending') AS pending_payments,
            (SELECT COUNT(*) FROM users WHERE role = 'skilled_worker') AS total_workers,
            (SELECT COUNT(*) FROM users WHERE role = 'client') AS total_clients
        ";

    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    // Extract results into variables for easier access.
    extract($result);
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error fetching overview data: " . $e->getMessage() . "</div>";
}
?>

<section class="content-header">
    <h1>Overview</h1>
</section>

<section class="content">
    <div class="row">
        <!-- Total Categories -->
        <div class="col-lg-3 col-xs-6">
            <a href="categories.php">
                <div class="small-box bg-olive">
                    <div class="inner">
                        <h3><?php echo $total_categories; ?></h3>
                        <p>Categories</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-list"></i>
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
                        <i class="fas fa-briefcase"></i>
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
                        <i class="fas fa-tasks"></i>
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
                        <i class="fas fa-check-circle"></i>
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
                        <i class="fas fa-money-bill-wave"></i>
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
                        <i class="fas fa-exclamation-circle"></i>
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
                        <i class="fas fa-users"></i>
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
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
