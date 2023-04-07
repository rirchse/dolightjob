-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2021 at 07:39 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dolightjob`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `status` tinyint(2) DEFAULT 0,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `budget` decimal(11,2) DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cronjobs`
--

CREATE TABLE `cronjobs` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `mac_addr` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(255) UNSIGNED NOT NULL,
  `full_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `care_of` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `present_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `remind_status` int(1) DEFAULT NULL,
  `referral` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_contact` varchar(18) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify_date` date DEFAULT NULL,
  `created_by` int(255) DEFAULT NULL,
  `updated_by` int(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposit_balances`
--

CREATE TABLE `deposit_balances` (
  `id` bigint(20) NOT NULL,
  `pre_amount` decimal(11,3) DEFAULT NULL,
  `amount` decimal(11,3) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `diposits`
--

CREATE TABLE `diposits` (
  `id` bigint(20) NOT NULL,
  `amount_usd` decimal(11,3) NOT NULL,
  `amount_bdt` decimal(11,3) NOT NULL,
  `account_type` varchar(255) NOT NULL,
  `account_no` varchar(18) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `note` text DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `earning_balances`
--

CREATE TABLE `earning_balances` (
  `id` bigint(20) NOT NULL,
  `pre_amount` decimal(11,3) DEFAULT NULL,
  `amount` decimal(11,3) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) NOT NULL,
  `sender` bigint(20) NOT NULL,
  `receiver` bigint(20) DEFAULT NULL,
  `receiver_type` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `myjobs`
--

CREATE TABLE `myjobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_id` int(11) NOT NULL,
  `sub_cat_id` int(11) DEFAULT NULL,
  `worker` int(11) NOT NULL,
  `worker_earn` decimal(11,3) DEFAULT NULL,
  `screenshot` int(11) DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_cost` decimal(8,3) NOT NULL,
  `project_cost` decimal(8,3) DEFAULT NULL,
  `charge` decimal(11,3) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `estimated_day` int(11) DEFAULT NULL,
  `auto_pause` int(11) DEFAULT NULL,
  `apply_limit` int(11) DEFAULT NULL,
  `apply_counter` int(11) DEFAULT NULL,
  `paused_time` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `status` tinyint(2) DEFAULT 0,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(255) NOT NULL,
  `sales_id` int(255) NOT NULL,
  `paid_amount` decimal(11,2) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `received_by` int(255) NOT NULL,
  `actual_payment_date` datetime DEFAULT NULL,
  `details` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by` int(255) NOT NULL,
  `updated_by` int(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `status` tinyint(2) DEFAULT 0,
  `report_for` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdmin', 'Developer', '2019-12-22 09:30:25', '2019-12-22 09:30:25'),
(2, 'Admin', 'Administrator', '2019-12-22 09:30:25', '2019-12-22 09:30:25'),
(3, 'Editor', 'Manager', '2019-12-22 09:30:25', '2019-12-22 09:30:25'),
(4, 'Sales', 'Sales Manager', '2019-12-22 09:30:25', '2019-12-22 09:30:25'),
(5, 'User', 'System User', '2019-12-22 09:30:25', '2019-12-22 09:30:25');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 4, 3, '2020-01-28 11:57:38', '2020-01-28 11:57:38'),
(4, 2, 4, '2020-01-28 11:57:38', '2020-01-28 11:57:38'),
(5, 4, 5, '2020-01-28 11:57:38', '2020-01-28 11:57:38'),
(6, 3, 12, NULL, NULL),
(9, 2, 13, NULL, NULL),
(10, 4, 19, NULL, NULL),
(11, 5, 20, NULL, NULL),
(12, 5, 21, NULL, NULL),
(13, 5, 22, NULL, NULL),
(14, 5, 23, NULL, NULL),
(15, 5, 24, NULL, NULL),
(16, 5, 25, NULL, NULL),
(17, 5, 26, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `budget` decimal(11,2) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(255) NOT NULL,
  `job_id` int(255) NOT NULL,
  `client_id` int(255) NOT NULL,
  `client_question` text DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `agreement` varchar(255) DEFAULT NULL,
  `earning` decimal(11,3) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `proof` text DEFAULT NULL,
  `screenshot` varchar(255) DEFAULT NULL,
  `screenshot_2` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `approval` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `feedback` tinyint(4) DEFAULT NULL,
  `created_by` int(255) NOT NULL,
  `updated_by` int(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aff_id` bigint(20) DEFAULT NULL,
  `aff_bonus` decimal(11,3) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skill` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `contact`, `email`, `email_verified_at`, `password`, `aff_id`, `aff_bonus`, `image`, `skill`, `facebook`, `address`, `city`, `state`, `zip_code`, `country`, `status`, `created_by`, `updated_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Rocky', '1825322626', 'admin@dolightjob.com', NULL, '$2y$10$t8qVMhtF1MV5fhPFs0X5ReZEOWqgpAm2DCjLYzsj2AUtre1BXSTay', NULL, NULL, '/uploads/user/Rocky_1631851663.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2019-12-22 09:30:25', '2021-09-17 04:07:43'),
(4, 'Sayed Best', '01725770129', 'sayed@chalanbeel.com', NULL, '$2y$10$hHPhegtmrRW5JzCzwix1iumXpPCwhbw.JTngu7uI6Gv5OIljJn7aq', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, '2019-12-26 08:26:09', '2020-09-10 07:34:36'),
(5, 'Sales Manager', '01625322626', 'sales@manager.com', NULL, '$2y$10$t8qVMhtF1MV5fhPFs0X5ReZEOWqgpAm2DCjLYzsj2AUtre1BXSTay', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2020-01-28 11:57:38', '2020-01-28 15:55:10'),
(12, 'Editor Account', '01234567890', 'editor@account.com', NULL, '$2y$10$1i8WKChLBWkKninzPOCgr.CxFsaca3sQb1L4ja2TELJtXvJpEFENu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2020-09-11 08:01:25', '2020-09-11 08:01:25'),
(13, 'Sales Manager Account', '01912121212', 'manager@sales.com', NULL, '$2y$10$t8qVMhtF1MV5fhPFs0X5ReZEOWqgpAm2DCjLYzsj2AUtre1BXSTay', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2020-09-11 08:05:25', '2020-09-11 16:39:17'),
(19, 'My test name', '01998172631', 'name@email.com', NULL, '$2y$10$anB1RtGFfJd7QH01MdUp1ORNM96siOUFW.SqPNw7ASMceRRoD801u', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, '2021-07-16 16:55:23', '2021-07-16 16:55:23'),
(20, 'Rocky Ahmed', '01998172633', 'rocky@email.com', NULL, '$2y$10$usPlxfsUU2WWmTOxUk8/TukjBjiInU4Zp1Rre5gSBM3b8fY1bakrO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, '2021-07-17 16:20:51', '2021-07-19 02:22:51'),
(21, 'Test User One', '01825322424', 'userone@email.com', NULL, '$2y$10$KTym81iByZ8Gwwh3SaqH2eYJaM60S0II1jstg8GtaqUIBBtO9lQoi', NULL, NULL, '/uploads/profile/Test User One_1627567131.jpg', 'test', NULL, 'test address', 'test', 'test state', '980809', 'test country', 0, 0, NULL, 'Lx9QRXu1Jfrab9B1ZkgOQsPIW5D9sThrJjdvpjeFs9uNhtvUOiRHjJLn0uJr', '2021-07-19 06:30:42', '2021-09-18 16:54:23'),
(22, 'Test User Accout', '01778573396', 'testuser@gmail.com', NULL, '$2y$10$MRZDyciTSnTm4Oh4d2/iEuKvKbN.s/BYZCBVLQSB54QAUGFTh7s1.', NULL, NULL, 'Test User Accout_1626739526.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, '2021-07-19 07:00:48', '2021-07-20 00:05:34'),
(23, 'User Two', '01998172695', 'usertwo@email.com', NULL, '$2y$10$bn7d0090d8Q81y.6oHy.Cuq4EvPQE.C3NmIhyRR.2nefVAUi4E5.K', NULL, NULL, '/uploads/profile/User Two_1628085723.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, '2021-07-24 11:40:46', '2021-08-04 14:02:03'),
(24, 'User Three', '01928345676', 'userthree@email.com', NULL, '$2y$10$RBpwuj7GokcjPU62zEJq/.a44MHtrW4QUF55nDn8OuauqOWF2Y4Ui', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, '2021-08-09 18:36:43', '2021-08-09 18:36:43'),
(25, 'User Four', '01929873736', 'userfour@email.com', NULL, '$2y$10$r7R372LE8WF5y2Nh/Wc/8emV9qNNgigmIOe8z/xsm4uDvqorhllQK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, '2021-08-26 04:56:16', '2021-08-26 04:56:16'),
(26, 'Test Account 5', '01912121234', 'user5@email.com', NULL, '$2y$10$xKVgUgKIrINbRcBv7mjLF.KT4OC/wfJ2fOoMYIzrj6ngZMHRmILh6', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, 1, 'I6VDJRqxx9OWijnOxj75krrtblm22YgsiPpYTZ55tSPPPcoKydaIuu4C719h', '2021-10-01 06:29:49', '2021-11-03 05:20:09');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) NOT NULL,
  `amount` decimal(11,3) DEFAULT NULL,
  `usd` decimal(11,3) DEFAULT NULL,
  `bdt` decimal(8,3) DEFAULT NULL,
  `percent` int(11) DEFAULT NULL,
  `charge` decimal(11,3) DEFAULT NULL,
  `account_type` varchar(255) DEFAULT NULL,
  `account_no` varchar(18) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `approved_by` bigint(20) DEFAULT NULL,
  `request_type` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cronjobs`
--
ALTER TABLE `cronjobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contact` (`contact`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `deposit_balances`
--
ALTER TABLE `deposit_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diposits`
--
ALTER TABLE `diposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `earning_balances`
--
ALTER TABLE `earning_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `myjobs`
--
ALTER TABLE `myjobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_contact_unique` (`contact`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cronjobs`
--
ALTER TABLE `cronjobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposit_balances`
--
ALTER TABLE `deposit_balances`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diposits`
--
ALTER TABLE `diposits`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `earning_balances`
--
ALTER TABLE `earning_balances`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `myjobs`
--
ALTER TABLE `myjobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
