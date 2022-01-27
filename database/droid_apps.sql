-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2022 at 09:36 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `droid_apps`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_account`
--

CREATE TABLE `table_account` (
  `id` int(100) NOT NULL,
  `name` varchar(500) NOT NULL,
  `role` int(100) NOT NULL DEFAULT 0,
  `pkg_id` varchar(100) DEFAULT NULL,
  `user_id` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `active` int(100) NOT NULL DEFAULT 1,
  `validity` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_account`
--

INSERT INTO `table_account` (`id`, `name`, `role`, `pkg_id`, `user_id`, `password`, `active`, `validity`) VALUES
(1, 'Admin', 1, 'com.sampe.admin', 'admin', '123', 1, '2024-01-31 19:15:44'),
(2, 'Manager', 0, 'com.sampe.test', 'manager', 'manager@123', 1, '2022-05-17 19:16:26'),
(3, 'Amit Jain', 0, 'com.appsfeature.bizwiz', 'amit', '123', 1, '2022-05-17 19:16:26');

-- --------------------------------------------------------

--
-- Table structure for table `table_app`
--

CREATE TABLE `table_app` (
  `app_id` int(100) NOT NULL,
  `pkg_id` varchar(500) NOT NULL,
  `app_name` varchar(500) NOT NULL,
  `visibility` int(100) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_app`
--

INSERT INTO `table_app` (`app_id`, `pkg_id`, `app_name`, `visibility`) VALUES
(1, 'com.sample.live', 'Live Exam', 1),
(2, 'com.appsfeature.bizwiz', 'BizWiz', 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_category`
--

CREATE TABLE `table_category` (
  `pkg_id` varchar(100) NOT NULL,
  `cat_id` int(100) NOT NULL,
  `sub_cat_id` int(100) NOT NULL DEFAULT 0,
  `cat_name` varchar(1000) NOT NULL,
  `cat_type` int(100) NOT NULL DEFAULT 0,
  `image` varchar(1000) DEFAULT NULL,
  `order_id` int(100) NOT NULL DEFAULT 0,
  `visibility` int(100) NOT NULL DEFAULT 1,
  `json_data` varchar(5000) DEFAULT NULL,
  `other_property` varchar(1000) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_category`
--

INSERT INTO `table_category` (`pkg_id`, `cat_id`, `sub_cat_id`, `cat_name`, `cat_type`, `image`, `order_id`, `visibility`, `json_data`, `other_property`, `updated_at`, `created_at`) VALUES
('com.sample.live', 13, 5, 'Category Live Exam', 0, NULL, 0, 1, NULL, NULL, '2022-01-20 07:28:20', '2022-01-26 16:19:23'),
('com.sample.live', 14, 5, 'Category Live Exam 2', 0, NULL, 0, 1, NULL, NULL, '2022-01-20 07:28:20', '2022-01-26 16:19:23'),
('com.bizwiz.global', 15, 5, 'BizWiz Category 1', 0, NULL, 0, 1, NULL, NULL, '2022-01-20 07:28:20', '2022-01-26 16:19:23'),
('com.app', 97, 0, 'eqweqwe', 0, NULL, 0, 0, '', '', '2022-01-23 20:00:03', '2022-01-26 16:19:23'),
('com.sampe.admin', 99, 0, 'fdsf22222', 0, NULL, 0, 1, '', '', '2022-01-26 14:17:55', '2022-01-26 16:19:23'),
('com.sampe.admin', 100, 0, 'dfsdfsdf', 0, NULL, 0, 1, '', '', '2022-01-26 14:18:01', '2022-01-26 16:19:23'),
('com.sampe.admin', 101, 0, 'dfgdfgdfg', 0, NULL, 0, 1, '', '', '2022-01-26 14:18:05', '2022-01-26 16:19:23');

-- --------------------------------------------------------

--
-- Table structure for table `table_content`
--

CREATE TABLE `table_content` (
  `pkg_id` varchar(100) NOT NULL,
  `id` int(100) NOT NULL,
  `cat_id` int(100) NOT NULL DEFAULT 0,
  `sub_cat_id` int(100) NOT NULL DEFAULT 0,
  `title` varchar(1000) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `link` varchar(1000) DEFAULT NULL,
  `visibility` int(100) NOT NULL DEFAULT 1,
  `json_data` varchar(5000) DEFAULT NULL,
  `other_property` varchar(1000) DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_content`
--

INSERT INTO `table_content` (`pkg_id`, `id`, `cat_id`, `sub_cat_id`, `title`, `description`, `image`, `link`, `visibility`, `json_data`, `other_property`, `updated_at`, `created_at`) VALUES
('com.sample.live', 3, 13, 5, 'Live exam scheduled on 25th ', NULL, NULL, NULL, 1, NULL, NULL, '2022-01-20 12:59:38', '2022-01-26 16:18:09'),
('com.bizwiz.global', 4, 13, 5, 'BizWiz video striming soon.', NULL, NULL, NULL, 1, NULL, NULL, '2022-01-20 12:59:38', '2022-01-26 16:18:09'),
('com.sampe.admin', 5, 0, 0, 'Content', '', NULL, NULL, 1, '', '', '', '2022-01-26 16:18:09'),
('com.sampe.admin', 9, 0, 0, '', NULL, NULL, NULL, 1, 'dfsf', NULL, '', '2022-01-26 16:18:09'),
('com.appsfeature.bizwiz', 23, 0, 0, 'qwe', 'ss', NULL, 'http://localhost/droidapps/admin/bizwiz1', 0, NULL, '', '', '2022-01-26 19:16:44'),
('com.appsfeature.bizwiz', 24, 0, 0, 'AAA', '', NULL, '', 1, NULL, '', '', '2022-01-26 19:24:03'),
('com.sampe.admin', 25, 0, 0, 'ewrwer', '', NULL, '', 1, '', '', NULL, '2022-01-26 20:21:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_account`
--
ALTER TABLE `table_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_app`
--
ALTER TABLE `table_app`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `table_category`
--
ALTER TABLE `table_category`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_id` (`cat_id`);

--
-- Indexes for table `table_content`
--
ALTER TABLE `table_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_account`
--
ALTER TABLE `table_account`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table_app`
--
ALTER TABLE `table_app`
  MODIFY `app_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_category`
--
ALTER TABLE `table_category`
  MODIFY `cat_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `table_content`
--
ALTER TABLE `table_content`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
