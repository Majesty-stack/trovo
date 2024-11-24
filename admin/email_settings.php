<?php require_once('header.php'); ?>

<div class="content-wrapper" style="margin-left: 100px;">
    <section class="content-header">
        <h1  style="margin-left: 110px;">Email Settings</h1>
        <ol class="breadcrumb">
            <li><a href="overview.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Email Settings</li>
        </ol>

        <!-- Display success or error message -->
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
                <h3 class="box-title">Update SMTP Settings</h3>
            </div>

            <!-- Fetch existing SMTP settings -->
            <?php
            $stmt = $pdo->prepare("SELECT * FROM smtp_settings LIMIT 1");
            $stmt->execute();
            $smtp = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>

            <!-- form start -->
            <form action="process_email_settings.php" method="post">
                <div class="box-body">
                    <!-- SMTP Host -->
                    <div class="form-group">
                        <label for="smtp_host">SMTP Host</label>
                        <input type="text" class="form-control" id="smtp_host" name="smtp_host" value="<?php echo $smtp['smtp_host']; ?>" required>
                    </div>

                    <!-- SMTP Port -->
                    <div class="form-group">
                        <label for="smtp_port">SMTP Port</label>
                        <input type="number" class="form-control" id="smtp_port" name="smtp_port" value="<?php echo $smtp['smtp_port']; ?>" required>
                    </div>

                    <!-- SMTP Username -->
                    <div class="form-group">
                        <label for="smtp_username">SMTP Username</label>
                        <input type="text" class="form-control" id="smtp_username" name="smtp_username" value="<?php echo $smtp['smtp_username']; ?>" required>
                    </div>

                    <!-- SMTP Password -->
                    <div class="form-group">
                        <label for="smtp_password">SMTP Password</label>
                        <input type="password" class="form-control" id="smtp_password" name="smtp_password" value="<?php echo $smtp['smtp_password']; ?>" required>
                    </div>

                    <!-- Encryption -->
                    <div class="form-group">
                        <label for="smtp_encryption">Encryption</label>
                        <select class="form-control" id="smtp_encryption" name="smtp_encryption">
                            <option value="ssl" <?php echo $smtp['smtp_encryption'] == 'ssl' ? 'selected' : ''; ?>>SSL</option>
                            <option value="tls" <?php echo $smtp['smtp_encryption'] == 'tls' ? 'selected' : ''; ?>>TLS</option>
                            <option value="none" <?php echo $smtp['smtp_encryption'] == 'none' ? 'selected' : ''; ?>>None</option>
                        </select>
                    </div>
                </div>
                
                <!-- Box footer -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </section>
</div>

<?php require_once('footer.php'); ?>
