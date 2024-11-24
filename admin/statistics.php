<?php
require_once('header.php');


// Fetch general statistics for the platform
try {
    // General statistics query
    $statsQuery = "
        SELECT 
            (SELECT COUNT(*) FROM categories) AS total_categories,
            (SELECT COUNT(*) FROM jobs WHERE jobs.status = 'open') AS open_jobs,
            (SELECT COUNT(*) FROM jobs WHERE jobs.status = 'completed') AS completed_jobs,
            (SELECT COUNT(*) FROM payments WHERE payments.status = 'completed') AS completed_payments,
            (SELECT COUNT(*) FROM users WHERE role = 'skilled_worker') AS total_workers,
            (SELECT COUNT(*) FROM users WHERE role = 'client') AS total_clients,
            (SELECT COUNT(*) FROM users WHERE role = 'admin') AS total_admins
    ";
    $statement = $pdo->prepare($statsQuery);
    $statement->execute();
    $statsData = $statement->fetch(PDO::FETCH_ASSOC);

    // Monthly trends for jobs and payments
    $monthlyTrendsQuery = "
        SELECT 
            MONTH(jobs.created_at) AS month,
            COUNT(CASE WHEN jobs.status = 'completed' THEN 1 END) AS completed_jobs,
            COUNT(CASE WHEN payments.status = 'completed' THEN 1 END) AS completed_payments
        FROM jobs 
        JOIN payments ON jobs.job_id = payments.job_id
        GROUP BY MONTH(jobs.created_at)
    ";
    $monthlyTrendsStatement = $pdo->prepare($monthlyTrendsQuery);
    $monthlyTrendsStatement->execute();
    $monthlyTrendsData = $monthlyTrendsStatement->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error fetching statistics data: " . $e->getMessage() . "</div>";
}

?>

<section class="content-header">
    <h1>Statistics</h1>
    <small>Detailed platform statistics and insights</small>
</section>

<section class="content">
    <!-- Overview of Key Statistics -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-olive">
                <div class="inner">
                    <h3><?php echo $statsData['total_categories']; ?></h3>
                    <p>Total Categories</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3><?php echo $statsData['open_jobs']; ?></h3>
                    <p>Open Jobs</p>
                </div>
                <div class="icon">
                    <i class="fas fa-briefcase"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo $statsData['completed_jobs']; ?></h3>
                    <p>Completed Jobs</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3><?php echo $statsData['completed_payments']; ?></h3>
                    <p>Completed Payments</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trends for Jobs and Payments -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Monthly Trends (Jobs & Payments)</h3>
        </div>
        <div class="box-body">
            <canvas id="monthlyTrendsChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- User Role Distribution -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">User Role Distribution</h3>
        </div>
        <div class="box-body">
            <canvas id="userRoleDistributionChart" width="100" height="50"></canvas>
        </div>
    </div>
</section>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Monthly Trends Chart
    var ctx = document.getElementById('monthlyTrendsChart').getContext('2d');
    var monthlyTrendsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php foreach ($monthlyTrendsData as $row) echo "'".date("F", mktime(0, 0, 0, $row['month'], 1))."', "; ?>],
            datasets: [
                {
                    label: 'Completed Jobs',
                    data: [<?php foreach ($monthlyTrendsData as $row) echo $row['completed_jobs'] . ", "; ?>],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    fill: false
                },
                {
                    label: 'Completed Payments',
                    data: [<?php foreach ($monthlyTrendsData as $row) echo $row['completed_payments'] . ", "; ?>],
                    borderColor: 'rgba(153, 102, 255, 1)',
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // User Role Distribution Chart
    var ctx2 = document.getElementById('userRoleDistributionChart').getContext('2d');
    var userRoleDistributionChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Workers', 'Clients', 'Admins'],
            datasets: [{
                data: [
                    <?php echo $statsData['total_workers']; ?>, 
                    <?php echo $statsData['total_clients']; ?>, 
                    <?php echo $statsData['total_admins']; ?>
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(75, 192, 192, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

<?php require_once('footer.php'); ?>
