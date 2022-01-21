-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2022 at 02:57 PM
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
(2, 'com.bizwiz.global', 'BizWiz', 1);

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
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_category`
--

INSERT INTO `table_category` (`pkg_id`, `cat_id`, `sub_cat_id`, `cat_name`, `cat_type`, `image`, `order_id`, `visibility`, `json_data`, `other_property`, `updated_at`) VALUES
('com.sample.live', 13, 5, 'Category Live Exam', 0, NULL, 0, 1, NULL, NULL, '2022-01-20 12:58:20'),
('com.sample.live', 14, 5, 'Category Live Exam 2', 0, NULL, 0, 1, NULL, NULL, '2022-01-20 12:58:20'),
('com.bizwiz.global', 15, 5, 'BizWiz Category 1', 0, NULL, 0, 1, NULL, NULL, '2022-01-20 12:58:20');

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
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_content`
--

INSERT INTO `table_content` (`pkg_id`, `id`, `cat_id`, `sub_cat_id`, `title`, `description`, `image`, `link`, `visibility`, `json_data`, `other_property`, `updated_at`) VALUES
('com.sample.live', 3, 13, 5, 'Live exam scheduled on 25th ', NULL, NULL, NULL, 1, NULL, NULL, '2022-01-20 12:59:38'),
('com.bizwiz.global', 4, 13, 5, 'BizWiz video striming soon.', NULL, NULL, NULL, 1, NULL, NULL, '2022-01-20 12:59:38');

-- --------------------------------------------------------

--
-- Table structure for table `table_role`
--

CREATE TABLE `table_role` (
  `id` int(100) NOT NULL,
  `name` varchar(500) NOT NULL,
  `role` int(100) NOT NULL DEFAULT 0,
  `user_id` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `active` int(100) NOT NULL DEFAULT 1,
  `validity` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_role`
--

INSERT INTO `table_role` (`id`, `name`, `role`, `user_id`, `password`, `active`, `validity`) VALUES
(1, 'Admin', 1, 'admin', 'asxcv@123', 1, '2024-01-31 19:15:44'),
(2, 'Manager', 0, 'manager', 'manager@123', 1, '2022-05-17 19:16:26');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `table_role`
--
ALTER TABLE `table_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_app`
--
ALTER TABLE `table_app`
  MODIFY `app_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_category`
--
ALTER TABLE `table_category`
  MODIFY `cat_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `table_content`
--
ALTER TABLE `table_content`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `table_role`
--
ALTER TABLE `table_role`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
