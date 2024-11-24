-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2024 at 03:17 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trovoria`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `action_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `target_user_id` int(11) NOT NULL,
  `action_type` enum('ban','disable','activate') NOT NULL,
  `reason` text DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `campaign_id` int(11) NOT NULL,
  `campaign_name` varchar(255) NOT NULL,
  `campaign_type` enum('email','social_media','advertising') NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('active','completed','pending') DEFAULT 'pending',
  `budget` decimal(10,2) DEFAULT NULL,
  `reach` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `attachment_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_analytics`
--

CREATE TABLE `campaign_analytics` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `clicks` int(11) DEFAULT 0,
  `conversions` int(11) DEFAULT 0,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`, `image_url`, `created_at`) VALUES
(24, 'Artistry', '', NULL, '2024-11-23 11:05:23'),
(25, 'IT Specialist', '', NULL, '2024-11-23 11:08:48'),
(26, 'Construction Worker', '', NULL, '2024-11-23 11:08:56'),
(27, 'Tutor', '', NULL, '2024-11-23 11:09:15'),
(28, 'Car Hire/Logistic', '', NULL, '2024-11-23 11:10:04');

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `Exprience_id` int(11) NOT NULL,
  `years_of_exprience` int(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`Exprience_id`, `years_of_exprience`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20),
(21, 21),
(22, 22),
(23, 23),
(24, 24),
(25, 25),
(26, 26),
(27, 27),
(28, 28),
(29, 29),
(30, 30);

-- --------------------------------------------------------

--
-- Table structure for table `jobcategories`
--

CREATE TABLE `jobcategories` (
  `job_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `job_image` varchar(255) DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `deadline` date NOT NULL,
  `status` enum('open','in_progress','completed','closed') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `client_id`, `location_id`, `title`, `description`, `job_image`, `budget`, `deadline`, `status`, `created_at`) VALUES
(3, 1, 1, 'Sample Job', 'This is a sample job description.', NULL, '1000.00', '2024-12-31', 'completed', '2024-11-09 15:49:49'),
(7, 18, 0, 'My laptop', 'gggggggggggggggggg', 'SULE.jpg', '50000.00', '2024-11-23', 'open', '2024-11-19 17:25:52'),
(8, 18, 14, 'My laptop', 'ggggggggggggggggggggg', 'SULE.jpg', '50000.00', '2024-11-23', 'open', '2024-11-19 17:47:45'),
(9, 18, 14, 'My laptop', 'gggggggggggggggg', 'SULE.jpg', '50000.00', '2024-11-22', 'open', '2024-11-19 18:10:10');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `application_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `applicant_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('pending','reviewed','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`application_id`, `job_id`, `applicant_name`, `email`, `status`, `created_at`) VALUES
(16, 2, 'Quadri', 'quadri@example.com', 'accepted', '2024-11-08 12:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `region` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `location_name`, `region`, `created_at`) VALUES
(1, 'Ikeja', 'Lagos Main', '2024-11-09 11:00:00'),
(2, 'Lekki', 'Lagos Island', '2024-11-09 11:00:00'),
(3, 'Victoria Island', 'Lagos Island', '2024-11-09 11:00:00'),
(4, 'Surulere', 'Lagos Mainland', '2024-11-09 11:00:00'),
(5, 'Yaba', 'Lagos Mainland', '2024-11-09 11:00:00'),
(6, 'Apapa', 'Lagos Mainland', '2024-11-09 11:00:00'),
(7, 'Ikoyi', 'Lagos Island', '2024-11-09 11:00:00'),
(8, 'Ajah', 'Lagos Island', '2024-11-09 11:00:00'),
(9, 'Agege', 'Lagos Mainland', '2024-11-09 11:00:00'),
(10, 'Alimosho', 'Lagos Mainland', '2024-11-09 11:00:00'),
(11, 'Epe', 'Lagos', '2024-11-09 11:00:00'),
(12, 'Badagry', 'Lagos', '2024-11-09 11:00:00'),
(13, 'Oshodi', 'Lagos Mainland', '2024-11-09 11:00:00'),
(14, 'Ikorodu', 'Lagos Mainland', '2024-11-09 11:00:00'),
(15, 'Mushin', 'Lagos Mainland', '2024-11-09 11:00:00'),
(16, 'Alaba SURU', 'Lagos Main', '2024-11-09 18:00:52'),
(17, 'Ajagbadi', 'Lagos Mainland', '2024-11-11 20:29:09');

-- --------------------------------------------------------

--
-- Table structure for table `location_settings`
--

CREATE TABLE `location_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `location_settings`
--

INSERT INTO `location_settings` (`setting_key`, `setting_value`) VALUES
('allow_location_editing', '0'),
('default_region', 'alaba');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `worker_id` int(11) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `payment_method` varchar(50) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `job_id`, `client_id`, `worker_id`, `location_id`, `amount`, `status`, `payment_method`, `transaction_date`) VALUES
(1, 1001, 501, 301, 101, '150.00', 'completed', 'credit_card', '2024-01-05 09:30:00'),
(2, 1002, 502, 302, 102, '200.50', 'pending', 'paystack', '2024-01-07 11:15:00'),
(3, 1003, 503, 303, 103, '250.75', 'failed', 'bank_transfer', '2024-01-10 13:45:00'),
(4, 1004, 504, 304, 104, '300.00', 'completed', 'credit_card', '2024-01-12 15:30:00'),
(5, 1005, 505, 305, 105, '120.00', 'refunded', 'paystack', '2024-01-15 08:00:00'),
(6, 1006, 506, 306, 106, '350.00', 'completed', 'debit_card', '2024-01-20 10:10:00'),
(7, 1007, 507, 307, 107, '500.00', 'pending', 'credit_card', '2024-01-25 12:25:00'),
(8, 1008, 508, 308, 108, '75.25', 'completed', 'cash', '2024-02-01 09:20:00'),
(9, 1009, 509, 309, 109, '425.50', 'failed', 'paystack', '2024-02-05 16:05:00'),
(10, 1010, 510, 310, 110, '600.00', 'completed', 'bank_transfer', '2024-02-10 11:50:00'),
(11, 1011, 511, 311, 111, '100.00', 'pending', 'credit_card', '2024-02-15 07:45:00'),
(12, 1012, 512, 312, 112, '300.00', 'refunded', 'cash', '2024-02-20 13:30:00'),
(13, 1013, 513, 313, 113, '750.00', 'completed', 'paystack', '2024-02-22 15:40:00'),
(14, 1014, 514, 314, 114, '450.00', 'pending', 'debit_card', '2024-03-01 09:30:00'),
(15, 1015, 515, 315, 115, '150.75', 'completed', 'bank_transfer', '2024-03-05 12:55:00'),
(16, 1016, 516, 316, 116, '225.00', 'failed', 'credit_card', '2024-03-10 08:10:00'),
(17, 1017, 517, 317, 117, '500.00', 'completed', 'paystack', '2024-03-15 10:35:00'),
(18, 1018, 518, 318, 118, '95.50', 'refunded', 'cash', '2024-03-18 11:20:00'),
(19, 1019, 519, 319, 119, '640.00', 'completed', 'debit_card', '2024-03-20 14:45:00'),
(20, 1020, 520, 320, 120, '850.25', 'pending', 'credit_card', '2024-03-25 15:55:00'),
(21, 1021, 521, 321, 121, '340.00', 'completed', 'bank_transfer', '2024-04-02 07:15:00'),
(22, 1022, 522, 322, 122, '120.75', 'failed', 'paypal', '2024-04-05 09:40:00'),
(23, 1023, 523, 323, 123, '95.00', 'completed', 'debit_card', '2024-04-08 11:00:00'),
(24, 1024, 524, 324, 124, '725.50', 'refunded', 'cash', '2024-04-10 13:20:00'),
(25, 1025, 525, 325, 125, '680.00', 'completed', 'credit_card', '2024-04-15 10:50:00'),
(26, 1026, 526, 326, 126, '540.25', 'pending', 'bank_transfer', '2024-04-20 12:30:00'),
(27, 1027, 527, 327, 127, '80.00', 'completed', 'paypal', '2024-04-30 23:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `permission_name`, `description`) VALUES
(1, 'view_users', 'Permission to view users'),
(2, 'edit_users', 'Permission to edit users'),
(3, 'delete_users', 'Permission to delete users'),
(4, 'manage_roles', 'Permission to create and manage roles'),
(5, 'manage_permissions', 'Permission to create and manage permissions'),
(6, 'view_content', 'Permission to view content'),
(7, 'edit_content', 'Permission to edit content'),
(8, 'delete_content', 'Permission to delete content');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `reviewed_user_id` int(11) NOT NULL,
  `rating_score` int(11) NOT NULL,
  `review_comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rating_id`, `job_id`, `reviewer_id`, `reviewed_user_id`, `rating_score`, `review_comment`, `created_at`) VALUES
(15, 1, 107, 207, 1, 'Work was subpar, did not meet specifications.', '2024-11-07 14:50:00'),
(16, 2, 108, 208, 4, 'Solid performance, completed on time with good.', '2024-11-08 09:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `description`) VALUES
(1, 'admin', 'Administrator role with full access to all system functionalities'),
(2, 'editor', 'Editor role with limited access to content management and editing functionalities'),
(3, 'user', 'Standard user with access to view content');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(2, 6),
(2, 7),
(3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('contact_email', 'support@mofemart.com'),
('contact_phone', '08060076346'),
('meta_description', 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhhh'),
('meta_keywords', 'gggggggggggggggggggg'),
('meta_title', 'mmemmeme'),
('og_description', 'hhhhhhhhhhhhhhhhhhhhh'),
('og_title', 'jjjjjjjjjjjjjjjjjjjjj'),
('robots_txt', 'User-agent : *\r\nDisallow: /admin\r\n'),
('site_description', 'hhj;;;;'),
('site_name', 'Trovoria');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `skill_id` int(11) NOT NULL,
  `skill` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`skill_id`, `skill`) VALUES
(1, 'Plumber'),
(2, 'Electrician'),
(3, 'Mechanic'),
(4, 'Painter'),
(5, 'Fashion Designer'),
(6, 'Welder'),
(7, 'Jewelry Maker'),
(8, 'Cobbler'),
(9, 'Electronic Repairs'),
(10, 'Software Engineer'),
(11, 'Data Scientist'),
(12, 'Cyber Security'),
(13, 'Web Developer'),
(14, 'Product Designer'),
(15, 'DevOps Engineer'),
(16, 'Cloud Computing'),
(17, 'Product Manager'),
(18, 'Game Developer'),
(19, 'AI/ML Engineer'),
(20, 'Graphic Designer'),
(21, 'Makeup Artist'),
(22, 'Event Planner');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `slider_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `smtp_settings`
--

CREATE TABLE `smtp_settings` (
  `id` int(11) NOT NULL,
  `smtp_host` varchar(255) NOT NULL,
  `smtp_port` int(11) NOT NULL,
  `smtp_username` varchar(255) NOT NULL,
  `smtp_password` varchar(255) NOT NULL,
  `smtp_encryption` enum('ssl','tls','none') DEFAULT 'tls'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `smtp_settings`
--

INSERT INTO `smtp_settings` (`id`, `smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `smtp_encryption`) VALUES
(1, 'smtp.example.com', 467, 'your_email@example.com', 'your_password', 'tls');

-- --------------------------------------------------------

--
-- Table structure for table `social_media_links`
--

CREATE TABLE `social_media_links` (
  `id` int(11) NOT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `social_media_links`
--

INSERT INTO `social_media_links` (`id`, `facebook_url`, `twitter_url`, `instagram_url`, `linkedin_url`, `youtube_url`, `updated_at`) VALUES
(1, '', 'http://www.twitter.com', '', '', '', '2024-11-02 10:21:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `Exprience_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('skilled_worker','client','admin','user') NOT NULL,
  `Specialization` varchar(100) NOT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `status` enum('active','banned','disabled') DEFAULT 'active',
  `agreed_to_terms` tinyint(1) NOT NULL DEFAULT 0,
  `Available` enum('available','Not Available') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `Location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `skill_id`, `Exprience_id`, `name`, `email`, `phone`, `password_hash`, `role`, `Specialization`, `email_verified`, `status`, `agreed_to_terms`, `Available`, `created_at`, `updated_at`, `image`, `Location`) VALUES
(3, 0, 0, 'Admin User', 'admin@trovoria.com', '0', '$2y$10$OTpqbl6EBF4DQjULNWAVN.2y962EsS09qvPbPuwfmqQIEy2XG5HMC', 'admin', '', 1, 'active', 1, '', '2024-10-30 12:30:49', '2024-11-10 13:42:54', NULL, ''),
(18, 0, 0, 'Quadr Amus', 'amusaabiodun88@gmail.com', '0806007634', '$2y$10$jU.A6JAscVwXUF29C6xc/.OWUgCSdNgmlnruBkWK/fGLG8ElKG5au', 'client', '', 0, 'active', 0, '', '2024-11-19 08:15:12', '2024-11-19 08:15:12', 'uploads/SULE.jpg', 'Ikorodu'),
(22, 1, 8, 'Fummi Sunday', 'amusaabiodun89@gmail.com', '08060076346', '$2y$10$JBQNldj5o1jDNvCrHnXPiOdzpWh5O8kjb0s88lZlXYy2qi2JL7/ga', 'skilled_worker', 'Artistry', 0, 'active', 0, 'available', '2024-11-23 13:37:58', '2024-11-23 13:37:58', 'uploads/SULE.jpg', 'Agege');

-- --------------------------------------------------------

--
-- Table structure for table `user_activity_logs`
--

CREATE TABLE `user_activity_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`action_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `target_user_id` (`target_user_id`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`campaign_id`);

--
-- Indexes for table `campaign_analytics`
--
ALTER TABLE `campaign_analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaign_id` (`campaign_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`Exprience_id`);

--
-- Indexes for table `jobcategories`
--
ALTER TABLE `jobcategories`
  ADD PRIMARY KEY (`job_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`),
  ADD UNIQUE KEY `location_name` (`location_name`);

--
-- Indexes for table `location_settings`
--
ALTER TABLE `location_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `worker_id` (`worker_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `reviewer_id` (`reviewer_id`),
  ADD KEY `reviewed_user_id` (`reviewed_user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skill_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`slider_id`);

--
-- Indexes for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_media_links`
--
ALTER TABLE `social_media_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_activity_logs`
--
ALTER TABLE `user_activity_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `action_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `campaign_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaign_analytics`
--
ALTER TABLE `campaign_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `Exprience_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `slider_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `social_media_links`
--
ALTER TABLE `social_media_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_activity_logs`
--
ALTER TABLE `user_activity_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `campaign_analytics`
--
ALTER TABLE `campaign_analytics`
  ADD CONSTRAINT `campaign_analytics_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`) ON DELETE CASCADE;

--
-- Constraints for table `jobcategories`
--
ALTER TABLE `jobcategories`
  ADD CONSTRAINT `jobcategories_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jobcategories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
