<?php
require_once('header.php');


// Fetch report data
try {
    // General overview counts for the report
    $query = "
        SELECT 
            (SELECT COUNT(*) FROM categories) AS total_categories,
            (SELECT COUNT(*) FROM jobs WHERE jobs.status = 'open') AS open_jobs,
            (SELECT COUNT(*) FROM jobs WHERE jobs.status = 'in_progress') AS in_progress_jobs,
            (SELECT COUNT(*) FROM jobs WHERE jobs.status = 'completed') AS completed_jobs,
            (SELECT COUNT(*) FROM payments WHERE payments.status = 'completed') AS completed_payments,
            (SELECT COUNT(*) FROM payments WHERE payments.status = 'pending') AS pending_payments,
            (SELECT COUNT(*) FROM users WHERE role = 'skilled_worker') AS total_workers,
            (SELECT COUNT(*) FROM users WHERE role = 'client') AS total_clients
    ";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $reportData = $statement->fetch(PDO::FETCH_ASSOC);

    // Fetch monthly data for jobs and payments (Example for creating a chart)
    $monthlyQuery = "
        SELECT 
            MONTH(jobs.created_at) AS month,
            COUNT(CASE WHEN jobs.status = 'completed' THEN 1 END) AS completed_jobs,
            COUNT(CASE WHEN jobs.status = 'open' THEN 1 END) AS open_jobs,
            COUNT(CASE WHEN jobs.status = 'in_progress' THEN 1 END) AS in_progress_jobs,
            COUNT(CASE WHEN payments.status = 'completed' THEN 1 END) AS completed_payments,
            COUNT(CASE WHEN payments.status = 'pending' THEN 1 END) AS pending_payments
        FROM jobs 
        JOIN payments ON jobs.job_id = payments.job_id
        GROUP BY MONTH(jobs.created_at)
    ";
    $monthlyStatement = $pdo->prepare($monthlyQuery);
    $monthlyStatement->execute();
    $monthlyData = $monthlyStatement->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error fetching report data: " . $e->getMessage() . "</div>";
}
?>

<section class="content-header">
    <h1>Reports</h1>
    <small>Detailed statistics and data analysis</small>
</section>

<section class="content">
    <!-- Overview Report Summary -->
    <div class="row">
        <!-- Display summary data similar to overview.php -->
        <?php
            $metrics = [
                "Categories" => ["count" => $reportData['total_categories'], "icon" => "fas fa-list", "color" => "bg-olive"],
                "Open Jobs" => ["count" => $reportData['open_jobs'], "icon" => "fas fa-briefcase", "color" => "bg-blue"],
                "Jobs in Progress" => ["count" => $reportData['in_progress_jobs'], "icon" => "fas fa-tasks", "color" => "bg-orange"],
                "Completed Jobs" => ["count" => $reportData['completed_jobs'], "icon" => "fas fa-check-circle", "color" => "bg-green"],
                "Completed Payments" => ["count" => $reportData['completed_payments'], "icon" => "fas fa-money-bill-wave", "color" => "bg-teal"],
                "Pending Payments" => ["count" => $reportData['pending_payments'], "icon" => "fas fa-exclamation-circle", "color" => "bg-yellow"],
                "Total Workers" => ["count" => $reportData['total_workers'], "icon" => "fas fa-users", "color" => "bg-red"],
                "Total Clients" => ["count" => $reportData['total_clients'], "icon" => "fas fa-user", "color" => "bg-purple"]
            ];
            foreach ($metrics as $label => $data) {
                echo "
                <div class='col-lg-3 col-xs-6'>
                    <div class='small-box {$data['color']}'>
                        <div class='inner'>
                            <h3>{$data['count']}</h3>
                            <p>$label</p>
                        </div>
                        <div class='icon'>
                            <i class='{$data['icon']}'></i>
                        </div>
                    </div>
                </div>";
            }
        ?>
    </div>

    <!-- Monthly Report Chart -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Monthly Jobs & Payments Report</h3>
        </div>
        <div class="box-body">
            <canvas id="monthlyReportChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Table for Detailed Report -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Detailed Report by Month</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Completed Jobs</th>
                        <th>Open Jobs</th>
                        <th>Pending Jobs</th>
                        <th>Completed Payments</th>
                        <th>Pending Payments</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($monthlyData as $row): ?>
                        <tr>
                            <td><?php echo $row['month']; ?></td>
                            <td><?php echo $row['completed_jobs']; ?></td>
                            <td><?php echo $row['open_jobs']; ?></td>
                            <td><?php echo $row['pending_jobs']; ?></td>
                            <td><?php echo $row['completed_payments']; ?></td>
                            <td><?php echo $row['pending_payments']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Chart.js Script for Monthly Report Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('monthlyReportChart').getContext('2d');
    var monthlyReportChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php foreach ($monthlyData as $row) echo "'".date("F", mktime(0, 0, 0, $row['month'], 1))."', "; ?>],
            datasets: [
                {
                    label: 'Completed Jobs',
                    data: [<?php foreach ($monthlyData as $row) echo $row['completed_jobs'] . ", "; ?>],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Open Jobs',
                    data: [<?php foreach ($monthlyData as $row) echo $row['open_jobs'] . ", "; ?>],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
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
</script>

<?php require_once('footer.php'); ?>
