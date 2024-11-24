<?php
ob_start();
session_start();
include("inc/config.php");  // Database connection
include("inc/functions.php");  // Helper functions
include("inc/CSRF_Protect.php");  // CSRF protection

$csrf = new CSRF_Protect();  // Initialize CSRF protection

// Initialize error and success messages
$error_message = '';
$success_message = '';

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Safely retrieve user session variables
$user_full_name = $_SESSION['user']['full_name'] ?? 'Guest';
$user_photo = $_SESSION['user']['photo'] ?? 'default-user.png';

// Set the current page to avoid undefined variables in sidebar highlighting
$cur_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Panel - Trovoria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/jquery.fancybox.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">
	<link rel="stylesheet" href="css/on-off-switch.css"/>
	<link rel="stylesheet" href="css/summernote.css">
	<link rel="stylesheet" href="style.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            <a href="index.php" class="logo">
                <span class="logo-lg">Trovoria</span>
            </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="../assets/uploads/<?php echo htmlspecialchars($user_photo); ?>" 
                                     class="user-image" alt="User Image">
                                <span class="hidden-xs"><?php echo htmlspecialchars($user_full_name); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-footer">
                                    <div>
                                        <a href="profile-edit.php" class="btn btn-default btn-flat">Edit Profile</a>
                                    </div>
                                    <div>
                                        <a href="logout.php" class="btn btn-default btn-flat">Log out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Sidebar -->
        <aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">

            <!-- Dashboard -->
            <li class="treeview">
                <a href="#">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="overview.php"><i class="fa fa-circle-o"></i> Overview</a></li>
                    <li><a href="reports.php"><i class="fa fa-circle-o"></i> Reports</a></li>
                    <li><a href="statistics.php"><i class="fa fa-circle-o"></i> Statistics</a></li>
                    <li><a href="recent_activities.php"><i class="fa fa-circle-o"></i> Recent Activities</a></li>
                </ul>
            </li>

            <!-- Website Settings -->
            <li class="treeview">
                <a href="#">
                    <i class="fas fa-cogs"></i> <span>Website Settings</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="general_settings.php"><i class="fa fa-circle-o"></i> General Settings</a></li>
                    <li><a href="appearance.php"><i class="fa fa-circle-o"></i> Appearance</a></li>
                    <li><a href="seo_settings.php"><i class="fa fa-circle-o"></i> SEO Settings</a></li>
                    <li><a href="email_settings.php"><i class="fa fa-circle-o"></i> Email Settings</a></li>
                    <li><a href="social_media_links.php"><i class="fa fa-circle-o"></i> Social Media Links</a></li>
                </ul>
            </li>

            <!-- Manage Jobs -->
            <li class="treeview">
                <a href="#">
                    <i class="fas fa-briefcase"></i> <span>Manage Jobs</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="job_listings.php"><i class="fa fa-circle-o"></i> Job Listings</a></li>
                    <li><a href="job_categories.php"><i class="fa fa-circle-o"></i> Job Categories</a></li>
                    <li><a href="job_applications.php"><i class="fa fa-circle-o"></i> Job Applications</a></li>
                    <li><a href="job_status_updates.php"><i class="fa fa-circle-o"></i> Job Status Updates</a></li>
                    <li><a href="job_reviews.php"><i class="fa fa-circle-o"></i> Job Reviews</a></li>
                </ul>
            </li>

            <!-- Manage Locations -->
            <li class="treeview">
                <a href="#">
                    <i class="fas fa-map-marker-alt"></i> <span>Manage Locations</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="location_list.php"><i class="fa fa-circle-o"></i> Location List</a></li>
                    <li><a href="add_location.php"><i class="fa fa-circle-o"></i> Add New Location</a></li>
                    <li><a href="location_settings.php"><i class="fa fa-circle-o"></i> Location Settings</a></li>
                    <li><a href="map_integration.php"><i class="fa fa-circle-o"></i> Map Integration</a></li>
                    <li><a href="location_statistics.php"><i class="fa fa-circle-o"></i> Location Statistics</a></li>
                </ul>
            </li>

            <!-- Payments -->
            <li class="treeview">
                <a href="#">
                    <i class="fas fa-credit-card"></i> <span>Payments</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="payment_history.php"><i class="fa fa-circle-o"></i> Payment History</a></li>
                    <li><a href="pending_payments.php"><i class="fa fa-circle-o"></i> Pending Payments</a></li>
                    <li><a href="completed_payments.php"><i class="fa fa-circle-o"></i> Completed Payments</a></li>
                    <li><a href="payment_methods.php"><i class="fa fa-circle-o"></i> Payment Methods</a></li>
                    <li><a href="refunds_adjustments.php"><i class="fa fa-circle-o"></i> Refunds and Adjustments</a></li>
                </ul>
            </li>

            <!-- Manage Sliders -->
            <li class="treeview">
                <a href="#">
                    <i class="fas fa-images"></i> <span>Manage Sliders</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="view_sliders.php"><i class="fa fa-circle-o"></i> View Sliders</a></li>
                    <li><a href="add_slider.php"><i class="fa fa-circle-o"></i> Add New Slider</a></li>
                    <li><a href="slider_settings.php"><i class="fa fa-circle-o"></i> Slider Settings</a></li>
                    <li><a href="slider_positioning.php"><i class="fa fa-circle-o"></i> Slider Positioning</a></li>
                </ul>
            </li>

            <!-- Manage Users -->
            <li class="treeview">
                <a href="#">
                    <i class="fas fa-users"></i> <span>Manage Users</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="user_list.php"><i class="fa fa-circle-o"></i> User List</a></li>
                    <li><a href="roles_permissions.php"><i class="fa fa-circle-o"></i> Roles and Permissions</a></li>
                    <li><a href="add_user.php"><i class="fa fa-circle-o"></i> Add New User</a></li>
                    <li><a href="user_activity_logs.php"><i class="fa fa-circle-o"></i> User Activity Logs</a></li>
                    <li><a href="account_verification.php"><i class="fa fa-circle-o"></i> Account Verification</a></li>
                </ul>
            </li>

        </ul>
    </section>
</aside>


        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content for each page will be included here -->
