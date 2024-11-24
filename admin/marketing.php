<?php require_once('header.php'); ?>

<div class="content-wrapper" style="margin-left: 50px;">
    <section class="content-header">
        <h1 style="margin-left: 130px;">Marketing Management</h1>
        <ol class="breadcrumb">
            <li><a href="overview.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="general_settings.php">Website Settings</a></li>
            <li class="active">Marketing Management</li>
        </ol>

        <!-- Display success or error message close to sidebar -->
        <?php if (isset($_GET['success'])): ?>
            <div class="callout callout-success" style="margin-top: 10px;">
                <p><?php echo htmlspecialchars($_GET['success']); ?></p>
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="callout callout-danger" style="margin-top: 10px;">
                <p><?php echo htmlspecialchars($_GET['error']); ?></p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Main content -->
    <section class="content" style="max-width: 800px;">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Update Marketing Campaigns</h3>
            </div>

            <!-- form start -->
            <form action="process_marketing.php" method="post">
                <div class="box-body">
                    <!-- Social Media Campaign -->
                    <div class="form-group">
                        <label for="social_media_campaign">Social Media Campaign</label>
                        <input type="text" class="form-control" id="social_media_campaign" name="social_media_campaign" placeholder="Enter Campaign Details">
                    </div>

                    <!-- Email Marketing Campaign -->
                    <div class="form-group">
                        <label for="email_campaign">Email Campaign</label>
                        <input type="text" class="form-control" id="email_campaign" name="email_campaign" placeholder="Enter Email Campaign Details">
                    </div>

                    <!-- Advertising Campaign -->
                    <div class="form-group">
                        <label for="advertising_campaign">Advertising Campaign</label>
                        <input type="text" class="form-control" id="advertising_campaign" name="advertising_campaign" placeholder="Enter Advertising Campaign Details">
                    </div>

                    <!-- Campaign Budget -->
                    <div class="form-group">
                        <label for="campaign_budget">Campaign Budget</label>
                        <input type="number" class="form-control" id="campaign_budget" name="campaign_budget" placeholder="Enter Campaign Budget">
                    </div>

                    <!-- Campaign Start Date -->
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>

                    <!-- Campaign End Date -->
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>
                </div>
                
                <!-- Box footer -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Save Campaign</button>
                </div>
            </form>
        </div>
    </section>
</div>

<?php require_once('footer.php'); ?>
