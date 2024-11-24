<?php require_once('header.php'); ?>

<div class="content-wrapper" style="margin-left: 30px;">
    <section class="content-header">
        <h1 style="margin-left: 30px;">Social Media Links</h1>
        <ol class="breadcrumb">
            <li><a href="overview.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="general_settings.php">Website Settings</a></li>
            <li class="active">Social Media Links</li>
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
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Update Social Media Links</h3>
            </div>

            <!-- form start -->
            <form action="process_social_media_links.php" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="facebook">Facebook URL</label>
                        <input type="url" class="form-control" id="facebook" name="facebook" placeholder="Enter Facebook URL">
                    </div>
                    <div class="form-group">
                        <label for="twitter">Twitter URL</label>
                        <input type="url" class="form-control" id="twitter_url" name="twitter" placeholder="Enter Twitter URL">
                    </div>
                    <div class="form-group">
                        <label for="instagram">Instagram URL</label>
                        <input type="url" class="form-control" id="instagram" name="instagram" placeholder="Enter Instagram URL">
                    </div>
                    <div class="form-group">
                        <label for="linkedin">LinkedIn URL</label>
                        <input type="url" class="form-control" id="linkedin" name="linkedin" placeholder="Enter LinkedIn URL">
                    </div>
                    <div class="form-group">
                        <label for="youtube">YouTube URL</label>
                        <input type="url" class="form-control" id="youtube" name="youtube" placeholder="Enter YouTube URL">
                    </div>
                </div>
                
                <!-- Box footer -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Save Links</button>
                </div>
            </form>
        </div>
    </section>
</div>

<?php require_once('footer.php'); ?>
