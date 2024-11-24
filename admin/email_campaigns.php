<?php require_once('header.php'); ?>

<div class="content-wrapper" style="margin-left: 100px;">
    <section class="content-header">
        <h1>Email Campaign Management</h1>
        <ol class="breadcrumb">
            <li><a href="overview.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="marketing.php">Marketing</a></li>
            <li class="active">Email Campaigns</li>
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
                <h3 class="box-title">Create New Email Campaign</h3>
            </div>

            <!-- form start -->
            <form action="process_email_campaigns.php" method="post">
                <div class="box-body">
                    <!-- Campaign Name -->
                    <div class="form-group">
                        <label for="campaign_name">Campaign Name</label>
                        <input type="text" class="form-control" id="campaign_name" name="campaign_name" placeholder="Enter Campaign Name" required>
                    </div>

                    <!-- Subject Line -->
                    <div class="form-group">
                        <label for="subject">Subject Line</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Email Subject" required>
                    </div>

                    <!-- Email Content -->
                    <div class="form-group">
                        <label for="content">Email Content</label>
                        <textarea class="form-control" id="content" name="content" rows="5" placeholder="Enter the email content" required></textarea>
                    </div>

                    <!-- Target Audience -->
                    <div class="form-group">
                        <label for="target_audience">Target Audience</label>
                        <input type="text" class="form-control" id="target_audience" name="target_audience" placeholder="Specify the target audience (e.g., subscribers, specific segment)">
                    </div>

                    <!-- Scheduled Send Date -->
                    <div class="form-group">
                        <label for="send_date">Scheduled Send Date</label>
                        <input type="date" class="form-control" id="send_date" name="send_date" required>
                    </div>
                </div>
                
                <!-- Box footer -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Create Campaign</button>
                </div>
            </form>
        </div>
    </section>
</div>

<?php require_once('footer.php'); ?>
